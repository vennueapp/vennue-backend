<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // JWT-Auth package checks for cookie with a key of 'token'
    const JWT_COOKIE = 'token';

    public function login(Request $request)
    {
        $rules = ['email' => 'required|email', 'password' => ['required', Password::default()], 'remember' => 'boolean'];
        list(['email', 'password'] => $credentials, 'remember' => $remember) = $request->validate($rules);
        if (!Auth::attempt($credentials, $remember)) {
            return response('Invalid email or password', 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->withoutCookie(self::JWT_COOKIE);
    }
}
