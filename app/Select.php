<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Select extends Model
{
    protected $table = 'selects';
    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'jid');
    }
}
