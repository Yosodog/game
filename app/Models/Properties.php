<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    /**
     * Properties that can be filled from the ::create method.
     *
     * @var array
     */
    public $fillable = ['name', 'baseValue'];

    /**
     * Do not add/update timestamps when querying.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Property/Effect relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function effects() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('\App\Models\Effects', 'property');
    }
}
