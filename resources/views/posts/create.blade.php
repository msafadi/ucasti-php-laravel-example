@extends('layouts.default')

@section('content')

<h2>Create New Post</h2>

<form method="post" action="{{ route('posts.store') }}">
    @csrf
    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
    <div class="form-group">
        <label class="col-4">Content</label>
        <div class="col-8">
            <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

@endsection
 