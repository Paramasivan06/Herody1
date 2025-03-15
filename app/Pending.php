<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    protected $table = 'pendings';
    public function employer()
    {
        return $this->belongsTo('App\Employer', 'user');
    }
}
