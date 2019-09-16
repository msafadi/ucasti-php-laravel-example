@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Token</h2>

    <form method="post" action="{{ route('api-token.update', [$token->id]) }}">
        @method('PUT')
        @csrf
        <input type="text" name="name" class="form-control" value="{{ old('name', $token->name) }}">
        <button class="btn btn-danger" type="submit">Update</button>
    </form>

</div>

@endsection