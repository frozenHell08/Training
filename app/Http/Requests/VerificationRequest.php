<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class VerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // $user = User::find($this->route('id'));

        if (! hash_equals((string) $this->user()->getJWTIdentifier(), (string) $this->route('id'))) {
            return false;
        }

        if (! hash_equals(sha1($this->user()->getEmailForVerification()), (string) $this->route('hash'))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [];
    }

    public function fulfill() {
        if (! $this->user()->hasVerifiedEmail()) {
            $this->user()->markEmailAsVerified();
            $this->user()->update([
                'isVerified' => true
            ]);

            event(new Verified($this->user()));
        }
    }
}
