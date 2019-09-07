<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers()
    {
        return $this->belongsToMany(
            User::class, 
            'followers', 
            'follower_id', 
            'following_id',
            'id',
            'id'
        )->withPivot(['created_at']);
    }
    
    public function following()
    {
        return $this->belongsToMany(
            User::class, 
            'followers', 
            'following_id',
            'follower_id', 
            'id',
            'id'
        )->withPivot(['created_at']);
    }

    public function likes()
    {
        $this->hasMany(Like::class, 'user_id', 'id');
    }
    
    public function posts()
    {
        $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function isFollowing($user)
    {
        $following = $this->following()->where('follower_id', $user->id)->first();
        if (!$following) {
            return false;
        }
        return true;
    }
}
