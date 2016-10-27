<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alliance extends Model
{
    /**
     * Table for the Alliance model
     *
     * @var string
     */
    protected $table = "alliances";
    
    /**
     * The fields that can be filled...
     *
     * @var array
     */
    protected $fillable = [
        "name", "description", "forumURL", "IRCChan"
    ];

    /**
     * Relationship between the alliance and its nations
     *
     * @return HasMany
     */
    public function nations() : HasMany
    {
        return $this->hasMany('App\Models\Nation\Nations', "allianceID");
    }
}
