<?php

namespace App\Observers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function get_class;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        //
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($post),
            'model_id' => $post->id,
            'action' => 'create',
            'ip' => request()->ip(),
        ]);
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($post),
            'model_id' => $post->id,
            'action' => 'update',
            'ip' => request()->ip(),
        ]);
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($post),
            'model_id' => $post->id,
            'action' => 'delete',
            'ip' => request()->ip(),
        ]);
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($post),
            'model_id' => $post->id,
            'action' => 'restore',
            'ip' => request()->ip(),
        ]);
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($post),
            'model_id' => $post->id,
            'action' => 'force-delete',
            'ip' => request()->ip(),
        ]);
    }
}
