<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;
    protected $fillable = [
        'name', 'email','password','phone','user_name','ref_code','ref_by','balance','reward_points'
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function jobs()
    {
        return $this->hasMany('App\ProjectApps', 'uid');
    }
    public function gigs()
    {
        return $this->hasMany('App\GigApp', 'uid');
    }
    public function teles()
    {
        return $this->hasMany('App\TelecallingApp', 'uid');
    }
}
