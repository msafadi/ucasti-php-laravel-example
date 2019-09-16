<?php

namespace App\Http\Middleware;

use App\AuthToken;
use Closure;
use Illuminate\Support\Facades\Auth;

use function str_replace;

class CheckAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $header = $request->header('Authorization');
        if (!$header) {
            return response()->json([
                'message' => 'Authorization header is missing!',
            ], 400);
        }

        $token = str_replace('Bearer ', '', $header);
        $authToken = AuthToken::where('token', $token)->first();

        if (!$authToken) {
            return response()->json([
                'message' => 'Not authorized!',
            ], 401);
        }

        Auth::login($authToken->user);

        return $next($request);
    }
}
