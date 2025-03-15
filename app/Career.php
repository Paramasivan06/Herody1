<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'position',
        'location',
        'pay',
        'job_type',
        'shift',
        'responsibilities',
        'requirements',
    ];
}
