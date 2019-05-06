<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    // Table Name
    protected $table = 'donations';
    // Primary Key
    public $primaryKey = 'did';
    // Timestamps
    public $timestamps = true;
    const CREATED_AT = 'd_created_at';
    const UPDATED_AT = 'd_updated_at';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function campaign()
    {
        return $this->belongsTo('App\Campaigns');
    }
}
