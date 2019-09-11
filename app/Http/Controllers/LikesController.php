<?php

namespace App\Http\Controllers;

use App\Like;
use App\Notifications\LikeNotification;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class LikesController extends Controller
{
    public function store(Request $request)
    {
        $like = Like::where('post_id', $request->post_id)
                    ->where('user_id', $request->user()->id)
                    ->first();

        if ($like) {
            Like::where('post_id', $request->post_id)
                ->where('user_id', $request->user()->id)
                ->delete();

            return response()->json([
                'success' => 2,
                'message' => 'Dislike!'
            ]);
        }

        $post_id = $request->post('post_id');
        $post = Post::findOrFail($post_id);
        $user = $request->user();

        Like::create([
            'post_id' => $post->id,
            'user_id' => $user->id, // Auth::id()
        ]);

        $post->user->notify(new LikeNotification($post, $user));

        /*Notification::send(User::all(), new LikeNotification($post, $user));
        Notification::route('mail', 'engmsafadi@gmail.com')
                    ->route('nexmo', '+97259988547')
                    ->notify(new LikeNotification($post, $user));*/

        return response()->json([
            'success' => 1,
            'message' => 'Success!'
        ]);
    }

    public function dislike(Request $request)
    {
        Like::where('post_id', $request->post_id)
            ->where('user_id', $request->user()->id)
            ->delete();

            return response()->json([
                'success' => 1,
                'message' => 'Deleted!'
            ]);
    }
}
