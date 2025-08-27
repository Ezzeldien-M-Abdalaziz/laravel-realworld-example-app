<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();
            dd($user);
        // try {

        //     if (!$user) {
        //         return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        //     }
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        // }
        return $next($request);
    }
}
