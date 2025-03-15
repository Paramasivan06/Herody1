<?php

namespace App\Http\Controllers\API;

use App\WalletTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletTransactionController extends Controller
{
   public function store(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'transaction_id' => 'required|string',
        'user_id' => 'required|integer',
        'wallet_id' => 'required|integer',
        'source_entity_id' => 'required|integer',
        'source_entity_type' => 'required|string|in:OFFER_REWARD,SPIN_WHEEL,DAILY_CHECKIN,REFERRAL,REDEEM,TRANSACTION_REVERSAL,BONUS',
        'transaction_type' => 'required|string|in:DEBIT,CREDIT',
        'currency'=>'required|string',
        'amount' => 'required|numeric',
        'balance' => 'required|numeric',
        'app_id' => 'required|string',
        'idempotency' => 'nullable',
    ]);

    // Log the validated data to see if it's correct
    \Log::info('Validated data: ', $validated);

    // Store the data in the database
    $transaction = WalletTransaction::create($validated);

    // Log the created transaction
    \Log::info('Created transaction: ', $transaction->toArray());

    return response()->json(['message' => 'Transaction stored successfully', 'data' => $transaction], 201);
}

}
