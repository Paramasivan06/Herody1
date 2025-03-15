<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferwallUserOffer extends Model
{
    protected $table = 'offerwall_user_offer';

    protected $fillable = [
        'pubscale_user_id',
        'offerwall_initiation',
        'offerwall_completed',
        'created_date',
        'completed_date',
        'dau',
        'day',
        'revenue',
        'app_id',
    ];
}
