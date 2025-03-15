<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferwallUser extends Model
{
    protected $fillable = [
        'pubscale_user_id',
        'user_id',
        'signup_ip',
        'last_open_at',
        'app_id',
        'completed_at',
        'utm_source',
    ];
    }
