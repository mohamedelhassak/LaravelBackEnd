<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Writing;

class WritingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang)
    {
        $writings = Writing::where('lang', $lang)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($writings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = validator($request->only('title', 'content'), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->all();

        $writing = Writing::create([
            'title' => $data['title'],
            'content' => $data['content'],
                        'user_id' => auth()->user()->id,
            'lang' => $data['lang'],
            'user_name' => $data['user_name'],
        ]);


        return response()->json(['writing'=>$writing,'status' => 'Writing created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $writing = Auth()->user()->writings->find($id);;

        return response()->json(['writing'=>$writing,'status'=>200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $writing = Writing::find($id);

        $valid = validator($request->only('title', 'content'), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->only('title','content','updated_at');


        $writing->title      = $data['title'];
        $writing->content    = $data['content'];
        $writing->updated_at = $data['updated_at'];
        $writing->save();

        return response()->json(['writing'=>$writing,'status' => 'Writing updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $writing = Writing::find($id);

        $writing->delete();

        return response()->json(['writing'=>$writing,'status'=>'writing deleted']);
    }
}
