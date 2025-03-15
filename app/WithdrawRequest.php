<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $table = 'withdraw_requests';
    public function withdraw_method()
    {
        return $this->belongsTo('App\Withdraw', 'withdraw_method_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
