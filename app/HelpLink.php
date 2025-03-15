<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpLink extends Model
{

    protected $table = "help_links";

    protected $fillable = [
        'whatsapp',
        'email',
        'google',
    ];
}
