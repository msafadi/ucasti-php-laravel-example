<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $user = User::where('username', $request->post('username'))->first();
        if ($user) {
            $password = $request->post('password');
            if (Hash::check($password, $user->password)) {
                $token = Str::random(70);
                $user->authTokens()->create([
                    'token' => $token,
                    'ip' => $request->ip(),
                    'agent' => $request->header('User-Agent'), //$_SERVER['HTTP_USER_AGENT'],
                ]);

                return response()->json([
                    'token' => $token,
                ]);
            }
        }

        return response()->json([
            'message' => 'Invalid username or password.'
        ], 401);
    }
}
