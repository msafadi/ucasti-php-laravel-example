<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $username = 'admin')
    {
        if (!Auth::guard('admin')->check()) {
            return redirect(route('login'));
        }
        if (Auth::guard('admin')->user()->username != $username) {
            abort(403);
        }

        return $next($request);
    }
}
