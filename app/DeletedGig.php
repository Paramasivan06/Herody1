<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedGig extends Model
{
    protected $table = 'deleted_gigs';
    protected $fillable = [
        'id',
        'per_cost',
        'campaign_title',
        'description',
        'brand',
        'user_id',
        // Add other fields you want to store
    ];
    public function user()
    {
        return $this->belongsTo('App\User','uid');
    }
    public function gig()
    {
        return $this->belongsTo('App\Gig','cid');
    }
}
