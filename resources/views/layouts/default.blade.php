<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')
</head>

<body>
    <div class="container">
        @include('partials.header')
        <main>
            @yield('content')
        </main>
        <hr>
        <footer>
            <p>&copy; 2019 Simple Twittler</p>
        </footer>
    </div>
    @yield('scripts')
</body>

</html>