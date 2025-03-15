<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignApp extends Model
{
    protected $table = "campaign_apps";

    protected $fillable = [
        'cid',      // Campaign ID
        'uid',      // User ID
        'status',   // Application status
        'created_at',
        'updated_at',
    ];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }
}
