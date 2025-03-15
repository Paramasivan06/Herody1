<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
        'transaction_id',
        'user_id',
        'value_in_paise',
        'transaction_fee_in_paise',
        'to_currency_amount',
        'to_currency',
        'payout_id',
        'payment_status',
        'payment_method',
        'payment_gateway',
        'payment_address',
        'pack_id',
        'from_currency_amount',
        'from_currency',
        'error_reason',
        'client_ip',
        'app_id',
        'created_at',
        'completed_at',
    ];
}
