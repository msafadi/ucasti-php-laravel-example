<header class="bg-light">
    <h1>Simple Twitter</h1>
    @auth('admin')
    Welcome, {{ Auth::guard('admin')->user()->name }}
    @endauth
</header>