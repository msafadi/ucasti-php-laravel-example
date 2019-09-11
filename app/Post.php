<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = ['content', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        /*static::addGlobalScope('public', function($query) {
            $query->where('status', 'public');
        });*/
    }

    public function scopeStatus($query, $status = 'public')
    {
        $query->where('status', $status);
    }

    public function usersLikes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
