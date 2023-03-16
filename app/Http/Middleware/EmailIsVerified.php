<?php

namespace App\Http\Middleware;

use App\Http\Requests\VerificationRequest;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class EmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param int $id
     */
    public function handle(Request $request, Closure $next)
    {
        dd($request->all());

        // $user = User::find($request->id);
        // // $user = User::find($this->route('id'));

        // if (! $user || 
        //     ($request->user() instanceof MustVerifyEmail && ! $request->user()->hasVerifiedEmail())) {
        //     return $request->expectsJson() 
        //         ? abort(403, 'You are not verified')
        //         : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
        // }

        /* if (! $user || 
            ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())) {
            return $request->expectsJson() 
                ? abort(403, 'You are not verified')
                : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
        } */

      /*   if ($user->hasVerifiedEmail()) {
            FacadesJWTAuth::parseToken()->authenticate();
        }else {
            return response()->json([
                'message' => 'none'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
            
        } */

        // return $next($request);



        if ($request->has('id') && ($request->id == 19 )) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}