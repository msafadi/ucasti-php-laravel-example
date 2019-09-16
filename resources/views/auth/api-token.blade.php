@extends('layouts.app')

@section('content')

<div class="container">
    <h2>API Tokens</h2>

    @if ($token)
    <p>{{ $token }}</p>
    <form method="post" action="{{ route('api-token.update', [$token]) }}">
        @method('PUT')
        @csrf
        <button class="btn btn-danger" type="submit">Regenerate Token</button>
    </form>
    @else
    <form method="post" action="{{ route('api-token.store') }}">
        @csrf
        <button class="btn btn-danger" type="submit">Create Token</button>
    </form>
    @endif
</div>

@endsection