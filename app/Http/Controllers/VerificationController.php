<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    public function verify($user_id, VerificationRequest $request) {

        if (! $request->hasValidSignature()) {
            return response()->json([
                'message' => "Invalid/expired url"
            ], 401);
        }

        $user = User::findOrFail($user_id);

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $user->update([
                'isVerified' => true
            ]);

            event(new Verified($user));
        
            return redirect('/');
        }
    }
}
