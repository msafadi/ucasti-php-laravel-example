<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthToken extends Model
{
    //
    protected $fillable = ['user_id', 'token', 'ip', 'agent'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
