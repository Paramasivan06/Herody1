<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectApps extends Model
{
    protected $table = 'project_apps';
    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'jid');
    }
}
