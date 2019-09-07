@extends('layouts.default')

@section('content')

<h2>Posts</h2>

@if($message)
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Content</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->content }}</td>
            <td>{{ $post->created_at->diffForHumans() }}</td>
            <td>{{ $post->updated_at->diffForHumans() }}</td>
            <td><a href="{{ route('posts.edit', [$post->id]) }}">Edit</a></td>
            <td>
                <form action="{{ route('posts.destroy', [$post->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection