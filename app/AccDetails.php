<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccDetails extends Model
{
    protected $table = 'accdetails';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id','contact_id','fund_id','acc_type',
    ];
}
