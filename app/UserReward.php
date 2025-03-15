<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'points',
        'reward_data',
        'offerwall_completed',
    ];
}
