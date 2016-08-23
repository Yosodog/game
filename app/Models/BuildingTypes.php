<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BuildingTypes extends Model
{
    public $fillable = ["name", "category", "description", "energy", "baseCost", "resources"];

    /**
     * BuildingType/Building relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buildings()
    {
        return $this->hasMany('\App\Models\Nation\Building', 'building_id');
    }

    /**
     * Returns collection of buildings of a certain category
     *
     * @param Collection $collection
     * @param string $category
     * @return array
     */
    public static function getByCategory(Collection $collection, string $category) : array 
    {
        $filtered = $collection->where("category", $category);

        return $filtered->all();
    }
}
