<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    protected $table = 'gigs';
     protected $fillable = ['gigstatus',];
    public function employer()
    {
        return $this->belongsTo('App\Employer', 'user_id');
    }
    public function applications()
    {
        return $this->hasMany('App\GigApp', 'cid');
    }
}
