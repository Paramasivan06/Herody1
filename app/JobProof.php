<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobProof extends Model
{
    protected $table = 'job_proofs';
    public function user()
    {
        return $this->belongsTo('App\User', 'uid');
    }
    public function project()
    {
        return $this->belongsTo('App\Project', 'jid');
    }
}
