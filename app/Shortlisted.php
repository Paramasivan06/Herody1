<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shortlisted extends Model
{
    protected $table = 'shortlisteds';
    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'jid');
    }
}
