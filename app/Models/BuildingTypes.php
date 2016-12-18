<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BuildingTypes extends Model
{
    /**
     * Allow all properties to be mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * BuildingType/Building relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buildings()
    {
        return $this->hasMany('\App\Models\Nation\Building', 'building_id');
    }

    /**
     * Relationship between the building_type and the effects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function effects()
    {
        return $this->hasMany('\App\Models\Effects', 'relation');
    }

    /**
     * Returns collection of buildings of a certain category.
     *
     * @param Collection $collection
     * @param string $category
     * @return array
     */
    public static function getByCategory(Collection $collection, string $category) : array
    {
        $filtered = $collection->where('category', $category);

        return $filtered->all();
    }
}
