<?php

namespace App\Models;

use App\Models\Nation\Building;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
    public static function getByCategory(Collection $collection, string $category): array
    {
        $filtered = $collection->where('category', $category);

        return $filtered->all();
    }

    /**
     * Returns the cost of the building.
     *
     * We have a special method for this because the building cost won't always be the same as the base cost
     *
     * @return float
     */
    public function cost(): float
    {
        return $this->baseCost;
    }

    /**
     * Build the BuildingType in the city.
     *
     * @param int $cityID
     */
    public function build(int $cityID)
    {
        // Get the Building or create a new one if it's the first of its type
        $building = Building::firstOrNew([
            'city_id' => $cityID,
            'building_id' => $this->id,
        ]);

        $building->quantity++; // Add one to the quantity
        $building->save(); // And save and build
    }

    /**
     * Determines if the building produces power
     *
     * @return bool
     */
    public function producesPower(): bool
    {
        if ($this->category === "power")
            return true;
        return false;
    }
}
