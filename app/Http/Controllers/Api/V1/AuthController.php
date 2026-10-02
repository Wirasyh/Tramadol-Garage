<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return response()->json([
                'message' => 'Email atau kata sandi tidak cocok.',
            ], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'data' => $request->user()->only(['id', 'name', 'email']),
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $request->user()->only(['id', 'name', 'email']),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(status: 204);
    }
}
