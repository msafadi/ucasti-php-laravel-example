<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Carbon\Carbon;

class TimelineController extends Controller
{
    //
    public function index()
    {
        $user = \Auth::user();

        return view('timeline.index')->with([
            'posts' => Post::where('user_id', $user->id)->paginate(20),
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
            'posts' => Post::where('user_id', $user->id)->paginate(20),
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
