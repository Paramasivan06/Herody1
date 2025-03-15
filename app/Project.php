<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "projects";
    public function employer()
    {
        return $this->belongsTo('App\Employer', 'user');
    }
    public function applications()
    {
        return $this->hasMany('App\ProjectApps', 'jid');
    }
}
