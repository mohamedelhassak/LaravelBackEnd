<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Writing extends Model
{

    protected $fillable = [
        'title', 'content', 'user_id','created_at',
    ];
    public function user()
    {
        return $this->belogsTo(User::class);
    }
}
