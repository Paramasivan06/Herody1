<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorPayment extends Model
{
   

    protected $fillable = [
        'name',
        'email',
        'phone',
        'upi_id',
        'amount',
        'status',
    ];

    // Optionally define any custom methods or relationships here
}
