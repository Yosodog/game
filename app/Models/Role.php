<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * Prevent timestamps from appearing in queries.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Table for the Role model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The fields that can be filled...
     *
     * @var array
     */
    protected $fillable = [
            'alliance_id', 'name', 'canChangeName', 'canRemoveMember', 'canDisbandAlliance', 'canChangeCosmetics', 'canCreateRoles', 'canEditRoles', 'canRemoveRoles', 'canReadAnnouncements', 'isDefaultRole', 'canAssignRoles', 'isLeaderRole'
    ];

    /**
     * Relationship between the role and the nations.
     *
     * @return HasMany
     */
    public function nations() : HasMany
    {
        return $this->hasMany('App\Models\Nation\Nations', 'role_id', 'id');
    }

    /**
     * Relationship between the role and the alliance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alliance() : \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Alliance', 'id', 'alliance_id');
    }
}
