<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    protected $table = 'rejects';
    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'jid');
    }
}
