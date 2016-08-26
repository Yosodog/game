<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    public $fillable = ["name", "baseValue"];
    public $timestamps = false;

    /**
     * Property/Effect relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function effects() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('\App\Models\Effects', "property");
    }
}
