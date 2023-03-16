<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            // 'mobile' => ['required', 'email'],
            'mobile' => ['required', 'min:10', 'max:10'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('mobile', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json([
                'error' => 'Login failed.'
            ], 401);
        }

        return $this->respondWithtoken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            // 'user' => auth()->user(),
            'payload' => Auth::payload(),
            'user' => Auth::user(),
        ]);
    }
}
