<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alliance extends Model
{
    /**
     * Table for the Alliance model.
     *
     * @var string
     */
    protected $table = 'alliances';

    /**
     * The fields that can be filled...
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'forumURL', 'flagID', 'discord', 'default_role_id',
    ];

    /**
     * Relationship between the alliance and its nations.
     *
     * @return HasMany
     */
    public function nations() : HasMany
    {
        return $this->hasMany('App\Models\Nation\Nations', 'allianceID');
    }

    /**
     * Relationship between the flag and the alliance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function flag() : \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Flags', 'id', 'flagID');
    }

    /**
     * Counts how many members are in the alliance.
     *
     * @return int
     */
    public function countMembers() : int
    {
        return $this->nations->count();
    }

    /**
     * Role/Alliance relationship.
     *
     * @return HasMany
     */
    public function role() : HasMany
    {
        return $this->hasMany('App\Models\Role', 'alliance_id');
    }
}
