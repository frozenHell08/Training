<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function show_details(Request $request) {

        $transactions = Transaction::where('sender', $request->user)
                                    ->orWhere('receiver', $request->user)
                                    ->get();  
        
        return response()->json([
            'transactions' => $transactions
        ], 200);
    }

    public function show_connections(Request $request) {
        $transact_sender = Transaction::distinct()
                                    ->where('sender', $request->user)
                                    // ->orWhere('receiver', $request->user)
                                    ->get(['receiver']);
                                    // ->except($request->user);

        $transact_receiver = Transaction::distinct()
                        // ->where('sender', $request->user)
                        // ->orWhere('receiver', $request->user)
                        ->where('receiver', $request->user)
                        ->get(['sender']);
                        // ->except($request->user);

        $transact = $transact_sender->concat($transact_receiver);

        // ---------------------------------------------------------- //

        $col = collect([]);

        foreach ($transact as $t) {
            $user = User::find($t);
            $col->push($user);
        }

        // $users = User::where('id', $transact)->get();

        // ---------------------------------------------------------- //

        return response()->json([
            'connections' => $col
        ], 200);
    }

    public function cash_in (Request $request) {
        $user = User::find($request->user);

        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->amount < 0) {
            return response()->json([
                'error' => 'Amount cannot be less that 0.'
            ], 422);
        }

        $new_balance = $user->balance + $request->amount;

        $user->balance = $new_balance;
        $user->save();

        return response()->json([
            'message' => "Successful cash-in of {$request->amount} pesos.",
            'user' => $user
        ], 200);
    }
}
