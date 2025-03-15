<?php

namespace App\Http\Controllers\API;

use App\OfferwallUserOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferwallUserOfferController extends Controller
{
   public function store(Request $request)
{
    $validatedData = $request->validate([
        'transaction_id' => 'required|string',
        'user_id' => 'required|integer',
        'wallet_id' => 'required|integer',
        'source_entity_id' => 'required|integer',
        'source_entity_type' => 'required|string',
        'transaction_type' => 'required|string',
        'currency' => 'required|string',
        'amount' => 'required|numeric',
        'balance' => 'required|numeric',
        'app_id' => 'required|string',
        'idempotency_token' => 'required|string|unique:wallet_transactions',
    ]);

    $transaction = new WalletTransaction($validatedData);
    $transaction->save();

    return response()->json(['message' => 'Transaction saved successfully!'], 201);
}

}
