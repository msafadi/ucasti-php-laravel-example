<?php

namespace App\Http\Middleware;

use App\ApiToken;
use Closure;

class CheckApiToken
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
        $key = $request->header('x-api-key');
        if (!$key) {
            return response()->json([
                'message' => 'x-api-key header is missing!',
            ], 400);
        }

        $token = ApiToken::where('token', $key)->first();
        if (!$token) {
            return response()->json([
                'message' => 'Invalid API key!',
            ], 403);
        }

        return $next($request);
    }
}
