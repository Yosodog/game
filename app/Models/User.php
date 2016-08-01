<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Returns the nation that belongs to this uer
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nation()
    {
        return $this->hasOne('App\Models\Nation\Nations');
    }
}
