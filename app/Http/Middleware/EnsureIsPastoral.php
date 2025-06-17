<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsPastoral
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role === 'pastoral') {
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized - Pastoral access only'
        ], 403);
    }
}