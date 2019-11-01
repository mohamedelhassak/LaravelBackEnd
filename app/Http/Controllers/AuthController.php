<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon;
use Auth;
use DB;

class AuthController extends Controller
{
    //Register new User
     function register(Request $request){
        $valid = validator($request->only('email', 'name', 'password','native_lang','other_lang'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'native_lang' => 'required',
            'other_lang' => 'required',
        ]);
    
        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }
    
        $data = request()->only('email','name','password','native_lang','other_lang');
    
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'native_lang' => $data['native_lang'],
            'other_lang' => $data['other_lang'],

            'password' => bcrypt($data['password']),
        ]);

    
        $token = $user->createToken('TutsForWeb')->accessToken;
 
        return response()->json(['token' => $token], 200);
     }

     public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
       
    public function logout(Request $request) {
        $token= $request->user()->tokens->find($token);
        $token->revoke();
        return response()->json(null, 204);
    }

    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }


    function editProfile(Request $request){
        $valid = validator($request->only('email', 'name', 'password','native_lang','other_lang'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'native_lang' => 'required',
            'other_lang' => 'required',
        ]);
    
        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }
    
        $data = request()->only('email','name','password','native_lang','other_lang');
    

        $user = Auth()->user();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'native_lang' => $data['native_lang'],
            'other_lang' => $data['other_lang'],

            'password' => bcrypt($data['password']),
        ]);

    
        $token = $user->createToken('TutsForWeb')->accessToken;
 
        return response()->json(['token' => $token], 200);
     }
    
}
