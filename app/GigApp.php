<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GigApp extends Model
{
    protected $fillable = [
        'cid', 'user_id', 'status', // add other attributes that can be mass assigned
    ];
    
    protected $table = "gig_apps";
    public function user()
    {
        return $this->belongsTo('App\User','uid');
    }
    public function gig()
    {
        return $this->belongsTo('App\Gig','cid');
    }
}
