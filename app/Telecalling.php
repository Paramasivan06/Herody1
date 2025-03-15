<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telecalling extends Model
{
    protected $table = "telecallings";
    public function applications()
    {
        return $this->hasMany('App\TelecallingApp', 'tid');
    }
}
