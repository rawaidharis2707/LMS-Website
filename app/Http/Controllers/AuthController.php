<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->merge([
            'email' => strtolower($request->email)
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        \Illuminate\Support\Facades\Log::info('Login attempt:', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'enrolled_class' => $user->enrolled_class,
                    'school_class_id' => $user->school_class_id,
                    'roll_number' => $user->roll_number,
                ],
                'redirect' => "/{$user->role}/dashboard",
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'The provided credentials do not match our records.',
        ], 422);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }

    /**
     * Get current authenticated user.
     */
    public function user(Request $request)
    {
        if ($user = Auth::user()) {
            return response()->json([
                'isLoggedIn' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'enrolled_class' => $user->enrolled_class,
                    'school_class_id' => $user->school_class_id,
                    'roll_number' => $user->roll_number,
                ]
            ]);
        }

        return response()->json(['isLoggedIn' => false], 401);
    }
}
