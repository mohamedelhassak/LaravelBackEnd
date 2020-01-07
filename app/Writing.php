<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Writing extends Model
{

    protected $fillable = [
        'title', 'content', 'user_id','created_at','lang','user_name'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
