<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Table Name
    protected $table = 'transactions';
    // Primary Key
    public $primaryKey = 'tid';
    // Timestamps
    public $timestamps = true;
    const CREATED_AT = 't_created_at';
    const UPDATED_AT = 't_approved_at';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    // public function campaign()
    // {
    //     return $this->belongsTo('App\Campaigns');
    // }
}
