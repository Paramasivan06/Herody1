<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Applicant extends Model
{
   

    protected $fillable = [
        'name',
        'mobile_number',
        'location',
        'highest_qualification',
        'qualification',
        'resume_path'
    ];
}
