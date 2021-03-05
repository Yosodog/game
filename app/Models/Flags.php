<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flags extends Model
{
    /**
     * Relationship between the flag and the nations that fly this flag.
     *
     * @return HasMany
     */
    public function nations(): HasMany
    {
        return $this->hasMany('App\Models\Nation\Nations', 'flagID');
    }
}
