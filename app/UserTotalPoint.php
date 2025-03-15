<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTotalPoint extends Model
{
   protected $table = 'user_total_points';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'total_points',
    ];
}