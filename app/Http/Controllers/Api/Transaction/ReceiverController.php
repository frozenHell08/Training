<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiverController extends Controller
{
    public function check_receiver(TransactionRequest $request) {
        $validator = Validator::make($request->only('receiver'), [
            'receiver' => ['required', 'min:10', 'max:10']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $receiver = User::where('mobile', $request->receiver)->first();

        if (! $receiver) {
            return response()->json([
                'message' => 'Number does not exist'
            ], 404);
        }

        return response()->json([
            'receiver' => $receiver
        ], 200);
    }
}
