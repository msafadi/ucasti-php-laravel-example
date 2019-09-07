<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

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

        Like::create([
            'post_id' => $request->post('post_id'),
            'user_id' => $request->user()->id, // Auth::id()
        ]);

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
