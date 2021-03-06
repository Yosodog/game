<?php

namespace App\Models\Nation;

use App\Jobs\BuildBuilding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingQueue extends Model
{
    use HasFactory;

    /**
     * The BuildingQueue's associated BuildingType
     */
    public function buildingType()
    {
        return $this->hasOne("\App\Models\BuildingType", "id", "buildingID");
    }

    /**
     * Returns the next Building in the BuildingQueue
     *
     * @param int $cityID
     * @return bool|BuildingQueue
     */
    public static function selectNextJob(int $cityID): bool|self
    {
        $building = self::where("cityID", $cityID)
            ->orderBy("created_at", "ASC")
            ->first();

        if ($building->count() === 0)
            return false; //
        else
            return $building;
    }

    /**
     * Starts the building process. Dispatches a job into the queue and delays for how long the building takes
     */
    public function start(): void
    {
        $buildingType = $this->buildingType();

        dispatch(new BuildBuilding($buildingType, $this))
            ->delay(now()->addMinutes($buildingType->buildingTime));
    }
}
