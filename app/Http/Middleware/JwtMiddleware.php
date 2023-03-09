<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) 
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            FacadesJWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'message' => 'Invalid Token'
                ], Response::HTTP_UNAUTHORIZED);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'message' => 'Expired Token'
                ], Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json([
                    'message' => 'Token not found.'
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
