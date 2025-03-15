<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    protected $table = "transitions";
    
     protected $fillable = [
        'uid', // Add 'uid' to the fillable array
        'reason',
        'transition',
        'addm',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'uid','id');
    }
}
