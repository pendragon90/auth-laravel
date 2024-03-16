<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthCntroller extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'msg' => 'Email not found'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'msg' => 'Invalid password'
            ], 401);
        }

        $accessToken = $user->createToken('accessToken', ['*'], now()->addMinute())->plainTextToken;
        $refreshToken = $user->createToken('refreshToken')->plainTextToken;

        $user->update([
            'refresh_token' => $refreshToken
        ]);

        $cookie = cookie('refreshToken', $refreshToken, 60 * 24); // 7 days

        return response()->json([
            'access_token' => $accessToken,
        ])->withCookie($cookie);
    }

    public function refreshToken()
    {
        $token = Cookie::get('refreshToken');
        if (!$token) {
            return response()->json(['cek' => 'Unauthorized'], 401);
        }

        $user = User::where('refresh_token', $token)->first();
        $refreshToken = $user->createToken('refreshToken', ['*'], now()->addMinute())->plainTextToken;

        return response()->json([
            'access_token' => $refreshToken,
        ]);
    }
}
