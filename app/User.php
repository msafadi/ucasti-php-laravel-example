<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar', 'mobile',
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
        return $this->hasMany(Like::class, 'user_id', 'id');
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class, 'user_id', 'id');
    }

    public function authTokens()
    {
        return $this->hasMany(AuthToken::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function isFollowing($user)
    {
        if (!$user) {
            return false;
        }
        $following = $this->following()->where('follower_id', $user->id)->first();
        if (!$following) {
            return false;
        }
        return true;
    }

    public function timelinePosts($count = 20)
    {
        $posts = Post::with(['user', 'usersLikes'])
                    ->where('posts.user_id', $this->id)
                    ->orWhereRaw('posts.user_id IN (SELECT followers.follower_id from followers where followers.following_id = ?)', [$this->id])
                    //->orderBy('posts.created_at', 'DESC')
                    ->latest()
                    ->paginate($count);
        
        return $posts;
    }

    public function routeNotificationForNexmo()
    {
        return $this->mobile;
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'User.' . $this->id;
    }

    public function hasPermission($code)
    {
        $count = DB::table('users_roles')
            ->join('roles_permissions', 'users_roles.role_id', '=', 'roles_permissions.role_id')
            ->join('permissions', 'permissions.id', '=', 'roles_permissions.permission_id')
            ->where('users_roles.user_id', '=', $this->id)
            ->where('permissions.code', '=', $code)
            ->count();

        if ($count) {
            return true;
        }

        return false;
    }
}
