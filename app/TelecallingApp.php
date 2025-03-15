<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelecallingApp extends Model
{
    protected $table = "telecalling_apps";
    public function project()
    {
        return $this->belongsTo('App\Telecalling', 'tid');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }
}
