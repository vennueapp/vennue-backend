<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // JWT-Auth package checks for cookie with a key of 'token'
    const JWT_COOKIE = 'token';

    public function register(Request $request)
    {
        $rules = ['name' => 'required', 'email' => 'required|email', 'password' => ['required', Password::default()]];
        $userData = $request->validate($rules);
        $userData['password'] = Hash::make($userData['password']);
        $user = new User($userData);
        $user->save();
        return response()->json()->withCookie(self::createJwtCookie(self::getGuard()->login($user)));
    }

    public function login(Request $request)
    {
        $rules = ['email' => 'required|email', 'password' => ['required', Password::default()]];
        if (!$token = self::getGuard()->attempt($request->validate($rules))) {
            return response()->json(['error' => 'Invalid email or password.'], 401);
        }
        return response()->json()->withCookie(self::createJwtCookie($token));
    }

    public function logout()
    {
        Auth::logout();
        return response()->json()->withoutCookie(self::JWT_COOKIE);
    }

    public static function createJwtCookie(string $token) {
        // TODO: Send with secure:true when not on localhost
        // $cookie = Cookie::make(self::JWT_COOKIE, Auth::getToken(), 0, null, null, true, true, false, 'strict');
        return Cookie::make(self::JWT_COOKIE, $token, 0, null, null, false, true, false, 'strict');
    }

    /**
     * @return \Tymon\JWTAuth\JWTGuard
     */
    public static function getGuard()
    {
        return auth();
    }
}
