@extends('layouts.app')

@section('content')
<div class="container">
    <header class="d-flex flex-wrap align-items-center">
        <div class="media align-items-center">
            <img height="80" src="{{ route('avatar', [basename($user->avatar)]) }}" class="rounded-circle mr-3">
            <div class="media-body">
                <h2 class="mb-0 pb-0">{{ $user->name }} <small class="text-muted">{{ '@' . $user->username }}</small></h2>
            </div>
        </div>
        @if (Auth::id() != $user->id)
        <form method="post" action="{{ route('follow', [$user->id]) }}" class="form-inline ml-3">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <button type="submit" class="btn btn-sm btn-outline-primary{{ Auth::user()->isFollowing($user)? ' active' : '' }}">{{ Auth::user()->isFollowing($user)? 'Unfollow' : 'Follow' }}</button>
        </form>
        @endif
    </header>
    <hr>
    <nav class="nav nav-pills">
        <a href="{{ route('followers', [$user->username]) }}" class="nav-link">Followers</a>
        <a href="{{ route('following', [$user->username]) }}" class="nav-link">Following</a>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="my-2">
                <h3 class="h5">Create Post</h3>
                <form action="{{ route('posts.store') }}" method="post">
                    @csrf
                    <textarea name="content" class="form-control" placeholder="Write something..." rows="2"></textarea>
                    <div class="mt-2 text-right">
                        <button type="submit" class="btn btn-outline-primary">Post</button>
                    </div>
                </form>
            </div>
            <hr>
            <div class="my-2">
                <h3 class="h5">Timeline</h3>
                @foreach ($posts as $post)
                <div class="bg-white my-3 rounded p-3">
                    <div class="d-flex justify-content-between">
                        <div class="media">
                            <img src="https://via.placeholder.com/50" class="rounded-circle mr-3">
                            <div class="media-body">
                                <h5 class="mb-0 pb-0"><a href="">{{ $post->user->name }} <small class="text-muted">{{ '@' . $post->user->username }}</small></a></h5>
                                <small><time class="text-muted">{{ $post->created_at->diffForHumans() }}</time></small>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg style="height:32px;" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="ellipsis-v" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 512" class="svg-inline--fa fa-ellipsis-v fa-w-2 fa-3x">
                                    <path fill="currentColor" d="M32 224c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zM0 136c0 17.7 14.3 32 32 32s32-14.3 32-32-14.3-32-32-32-32 14.3-32 32zm0 240c0 17.7 14.3 32 32 32s32-14.3 32-32-14.3-32-32-32-32 14.3-32 32z" class=""></path>
                                </svg>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="my-3">
                        <p>{{ $post->content }}
                    </div>
                    <div class="">
                        <span>
                            <a href="#" class="post-like" data-id="{{ $post->id }}"><svg style="height: 24px" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-heart fa-w-16 fa-2x"><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z" class=""></path></svg></a>
                            <span id="likes_{{ $post->id }}" class="ml-2">{{ $post->usersLikes()->count() }}</span>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('a.post-like').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.post('{{ route('likes.store') }}', {
        post_id: id,
        _token: "{{ csrf_token() }}"
    }, function(data) {
        if (data.success == 1) {
            var likes = parseInt($('#likes_' + id).text()) + 1;
            $('#likes_' + id).text(likes);
        } else if (data.success == 2) {
            var likes = parseInt($('#likes_' + id).text()) - 1;
            $('#likes_' + id).text(likes);
        }
    });
});
</script>
@endsection