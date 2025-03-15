<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
   protected $fillable = [
    'transaction_id',
    'user_id',
    'wallet_id',
    'source_entity_id',
    'source_entity_type',
    'transaction_type',
    'currency',
    'amount',
    'balance',
    'app_id',
    'idempotency_token',
];
}
