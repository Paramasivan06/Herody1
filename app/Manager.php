<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Authenticatable
{
    use Notifiable,SoftDeletes;
    protected $guard = 'managers';
    protected $table = 'managers';

}
