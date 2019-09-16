<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    //
    protected $table = 'api_tokens';

    protected $fillable = ['user_id', 'name', 'token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
