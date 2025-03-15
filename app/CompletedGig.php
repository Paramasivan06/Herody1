<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompletedGig extends Model
{
    protected $table = 'completed_gigs';
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
