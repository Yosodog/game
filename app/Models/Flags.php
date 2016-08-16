<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flags extends Model
{
    public function nations() : HasMany
    {
        return $this->hasMany('App\Models\Nation\Nations', "flagID");
    }
}
