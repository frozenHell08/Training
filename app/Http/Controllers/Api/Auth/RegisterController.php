<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyRegister;
use App\Models\User;
use Hamcrest\Core\IsEqual;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'mobile' => ['required', 'min:10', 'max:10', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'max:255'],
            'filesToken' => ['required', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'filesToken' => $request->filesToken,
        ]);

        if ($user->id == 1) {
            $user->user_type = 'Super Admin';
            $user->save();
        }

        event(new Registered($user));

        // Mail::to($user->email)->send(new VerifyRegister($user));

        $token = Auth::login($user);
        // event(new Verified($this->user()));
        
        return response()->json([
            'message' => "Account has been registered.",
            'account' => $user,
            'token' => $token
        ], 201);
    }
}
