<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncompletedGig extends Model
{
    protected $table = 'incompleted_gigs';
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}



