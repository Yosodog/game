<?php

namespace App\Models\Nation;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public $fillable = ['city_id', 'building_id'];

    /**
     * Building/city relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('\App\Models\Nation\Cities', 'city_id');
    }

    /**
     * The Building/Building Type Relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buildingType() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('\App\Models\BuildingTypes', 'building_id');
    }
}
