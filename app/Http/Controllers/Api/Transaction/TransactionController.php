<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function send_money(TransactionRequest $request) {

        // ------------------------------------------------------------- //

        $validator = Validator::make($request->all(), [
            // 'sender' => ['required'],
            'receiver' => ['required', 'min:10', 'integer'],
            'amount' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // ------------------------------------------------------------- //

        /* return response()->json([
            'request' => $request->all()
        ]); */

        // ------------------------------------------------------------- //

        $sender = User::find($request->user);
        // $receiver = User::find($request->receiver); 
        // return $sender->getVerifiedStatus();

        $receiver = User::where('mobile', $request->receiver)->first();

        if (! $receiver) {
            return response()->json([
                'error' => "Receiver number does not exist"
            ], 404);
        }

        if (($sender->balance - $request->amount) < 0) {
            return response()->json([
                'error' => 'Request cannot push through. Balance not enough.'
            ], 403);
        }

        $randomized = Str::random();

        $transaction = Transaction::create([
            'reference_no' => $randomized,
            'sender' => $sender->id, //request->user
            'receiver' => $receiver->id, //request->receiver
            'amount' => $request->amount,
            'transaction_date' => now(),
        ]);
        
        // ------------------------------------------------------------- //

        $sender_name = sprintf('%s %s', $sender->firstName, $sender->lastName);
        $receiver_name = sprintf('%s %s', $receiver->firstName, $receiver->lastName);

        // return response()->json([
        //     'sender' => $sender_name,
        //     'receiver' => $receiver_name
        // ]);
        
        // $transaction = Transaction::create([
        //     'reference_no' => $randomized,
        //     'sender' => $request->user,
        //     'receiver' => $receiver->id, //request->receiver
        //     'amount' => $request->amount,
        //     'transaction_date' => now(),
        // ]);

        // ------------------------------------------------------------- //


        // $sender_bal = $sender->balance;
        // $receiver_bal = $receiver->balance;

        // $sender->balance = $sender_bal - $transaction->amount;
        // $receiver->balance = $receiver_bal + $transaction->amount;

        // $sender->save();
        // $receiver->save();

        $this->save_transaction_changes($sender, $receiver, $transaction->amount);

        return response()->json([
            'message' => 'something of a message',
            'transaction' => $transaction,
            'sender' => $sender,
            'receiver' => $receiver,
        ], 201);
    }

    public function save_transaction_changes(User $sender, User $receiver, float $amount) {
        $sender_bal = $sender->balance;
        $receiver_bal = $receiver->balance;

        $sender->balance = $sender_bal - $amount;
        $receiver->balance = $receiver_bal + $amount;

        $sender->save();
        $receiver->save();
    }
}

/**
 * reference_no
 * sender
 * receiver
 * amount
 * type
 * transaction_date
 */
