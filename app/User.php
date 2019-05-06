<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'url', 'balance'
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

    public function is_admin()
    {
        return ($this->type == 'admin') ? true : false;
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog');
    }

    public function campaigns()
    {
        return $this->hasMany('App\Campaigns');
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

    public function donation()
    {
        return $this->hasMany('App\Donation');
    }
}
