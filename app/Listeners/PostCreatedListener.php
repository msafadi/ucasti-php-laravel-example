<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        //
        DB::table('logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($event->post),
            'model_id' => $event->post->id,
            'action' => 'create-by-listener',
            'ip' => request()->ip(),
        ]);
    }
}
