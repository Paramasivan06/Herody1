<?php

namespace App\Http\Controllers\API;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'transaction_id' => 'required|string',
            'user_id' => 'required|integer',
            'value_in_paise' => 'required|integer',
            'transaction_fee_in_paise' => 'required|integer',
            'to_currency_amount' => 'required|numeric',
            'to_currency' => 'required|string|in:INR',  // Validates the 'to_currency' as INR
            'payout_id' => 'required|string',
            'payment_status' => 'required|string|in:PROCESSING,PROCESSED,FAILED',
            'payment_method' => 'required|string|in:UPI,Paytm,gift_card',
            'payment_gateway' => 'required|string|in:razorpay,payu,xoxoday',
            'payment_address' => 'required|string',
            'pack_id' => 'required|integer',
            'from_currency_amount' => 'required|numeric',
            'from_currency' => 'required|string',
            'error_reason' => 'nullable|string',
            'client_ip' => 'nullable|string',
            'app_id' => 'required|string',
            'created_at' => 'required|date',  // Validates the 'created_at' field as a valid date
            'completed_at' => 'nullable|date',  // Validates the 'completed_at' as a valid date (nullable)
        ]);
        

        // Store the data in the database
        $transaction = Transaction::create($validated);

        return response()->json(['message' => 'Transaction stored successfully', 'data' => $transaction], 201);
    }
}
