<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    //
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all(),
            'message' => session('message'),
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Method 1
        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = $request->user()->id;
        $post->save();

        
        return redirect()->route('timeline')->with('message', 'Post created!');
        //return redirect()->action('index');

        // Method 2
        $post = Post::create([
            'content' => $request->input('content'),
            'user_id' => null,
        ]);

        Post::create($request->only([
            'content'
        ]));
    }

    public function edit($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('posts');
        }

        //return view('posts.edit', compact(['post']));
        return view('posts.edit')->with([
            'post' => $post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts');
        }

        // Method 1
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('posts')->with('message', 'Post updated!');;

        // Method 2
        $post->update([
            'content' => $request->input('content'),
        ]);

        // Method 3
        Post::where('id', $id)->update([
            'content' => $request->input('content'),
        ]);
    }

    public function destory($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts')->with('message', 'Post not found!');
        }

        // Method 1
        $post->delete();

        return redirect()->route('posts')->with('message', 'Post deleted!');

        // Method 2
        Post::where('id', $id)->delete();
    }
}
