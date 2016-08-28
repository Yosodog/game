<?php

namespace App\Models\Nation;

use App\Models\BuildingTypes;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Cities extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nation_id',
    ];

    /**
     * Relationship between the nation and the city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nation() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Nation\Nations');
    }

    /**
     * City/Jobs relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Jobs', 'city_id');
    }

    public function buildings()
    {
        return $this->hasMany('\App\Models\Nation\Building', 'city_id');
    }

    /**
     * Determines if the user viewing the city owns the city
     *
     * @return bool
     */
    public function isOwner() : bool
    {
       return Auth::user()->nation->id === $this->nation_id;
    }

    public function checkIfOpenBuildingSlots() : bool
    {
        // TODO implement more than one building slots

        $activeSlots = $this->countActiveJobs();

        if ($activeSlots > 0)
            return false;
        else
            return true;
    }

    public function countActiveJobs() : int
    {
        return $this->jobs()->where("status", "active")->count();
    }

    /**
     * Returns information about a building by searching for the building ID
     * If the city doesn't have that building, it returns an empty array
     *
     * @param int $buildingID
     * @return mixed
     */
    public function getBuilding(int $buildingID)
    {
        return $this->buildings->where("building_id", $buildingID);
    }

    /**
     * Loads the "full city"
     *
     * Includes the city's buildings, those building types, and the effects for that building
     */
    public function loadFullCity()
    {
        $this->load('buildings.buildingType.effects');
    }
}
