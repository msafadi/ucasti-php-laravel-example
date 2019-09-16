@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Create Token</h2>

    <form method="post" action="{{ route('api-token.store') }}">
        @csrf
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        <button class="btn btn-danger" type="submit">Create</button>
    </form>

</div>

@endsection