<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    public $incrementing = false;

    protected $fillable = ['post_id', 'user_id'];

    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
