<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
    
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized - Token missing'], 401);
        }

        $hashedToken = hash('sha256', $token);
        $user = User::where('api_token', $hashedToken)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized - Invalid token'], 401);
        }

        Auth::setUser($user);
        if ($request->is('api/me')) {
            return $next($request);
        }
        return $next($request);
    }
}