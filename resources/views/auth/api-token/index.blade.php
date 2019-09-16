@extends('layouts.app')

@section('content')

<div class="container">
    <h2>API Tokens</h2>
    <a href="{{ route('api-token.create') }}" class="btn btn-success">Create new token</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Token</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tokens as $token)
            <tr>
                <td><a href="{{ route('api-token.edit', [$token->id]) }}">{{ $token->name }}</a></td>
                <td>{{ $token->token }}
                <form method="post" action="{{ route('api-token.regenerate', [$token->id]) }}">
                    @method('PUT')
                    @csrf
                    <button class="btn btn-danger" type="submit">Regenerate</button>
                </form>
                
                </td>
                <td>{{ $token->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection