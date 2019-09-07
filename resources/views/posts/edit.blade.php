@extends('layouts.default')

@section('content')

<h2>Edit Post <span>{{ $post->id }}</span></h2>

<form method="post" action="{{ route('posts.update', [$post->id]) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label class="col-4">Content</label>
        <div class="col-8">
            <textarea class="form-control" name="content" id="" cols="30" rows="10">{{ $post->content }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

@endsection