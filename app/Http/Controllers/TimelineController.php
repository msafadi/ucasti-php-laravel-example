<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimelineController extends Controller
{
    //
    public function index()
    {
        $user = \Auth::user();

        //return Post::withoutGlobalScope('public')->get();
        //return Post::status('private')->get();

        return view('timeline.index')->with([
            'posts' => $user->timelinePosts(),
            //'posts' => DB::table('posts')->get(),
            'user' => $user,
        ]);
    }

    public function profile($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            abort(404);
        }

        return view('timeline.index')->with([
            'posts' => $user->timelinePosts(),
            //'posts' => $user->posts,
            'user' => $user,
        ]);
    }

    public function follow(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            abort(404);
        }

        $user->followers()->attach(\Auth::user()->id, [
            'created_at' => Carbon::now(),
        ]);
        //$user->following()->attach(\Auth::user()->id);

        return redirect()->route('profile', [$user->username]);
    }

    public function followers($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            abort(404);
        }

        return view('followrs', [
            'followers' => $user->followers,
        ]);
    }

    public function following($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            abort(404);
        }

        return $user->following;
    }
}
