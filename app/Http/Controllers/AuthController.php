<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth; // Import JWTAuth
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        \Log::info('Attempting login with email: ' . $request->email); // Debugging log

        if (! $token = auth()->attempt($credentials)) {
            \Log::error('Login failed for email: ' . $request->email); // Debugging log
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        \Log::info('Login successful for email: ' . $request->email); // Debugging log
        return response()->json([
            'message' => 'Login Successful!',
            'access_token' => $token,
        ]);
    }

    /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        JWTAuth::logout(); // Use JWTAuth::logout
        return response()->json(['message' => 'Successfully logged out']);
    }
}