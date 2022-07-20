<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('APP_TOKEN');
        if ($token != env("APP_TOKEN", "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9")) {
            return response()->json(['message' => 'You are not authorized to access this content'], 401);
        }
        return $next($request);
    }
}
