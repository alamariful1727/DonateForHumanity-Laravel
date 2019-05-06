<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    // Table Name
    protected $table = 'campaigns';
    // Primary Key
    public $primaryKey = 'cid';
    // Timestamps
    public $timestamps = true;
    const CREATED_AT = 'c_created_at';
    const UPDATED_AT = 'c_updated_at';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function donation()
    {
        return $this->hasMany('App\Donation');
    }
}
