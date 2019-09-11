@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Notifications</h3>

    <ul>
        @foreach (Auth::user()->notifications as $notification)
        
        <li>
            <time>{{ $notification->created_at->diffForHumans() }}</time>
            <a href="{{ $notification->data['url'] }}">
            {{ $notification->data['message'] }}
            </a>
            -
            {{ ($notification->read_at)? 'Read' : 'Unread'}}
            - <a href="{{ route('notifications.read', [$notification->id]) }}">Mark as read</a>
        </li>
        @endforeach
        
    </ul>
</div>

@endsection