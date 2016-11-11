<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BuildingTypes extends Model
{
    /**
     * Properties that can be filled
     *
     * @var array
     */
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
     * Relationship between the building_type and the effects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function effects()
    {
        return $this->hasMany('\App\Models\Effects', "relation");
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
