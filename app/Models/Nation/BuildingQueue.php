<?php

namespace App\Models\Nation;

use App\Jobs\BuildBuilding;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

class BuildingQueue extends Model
{
    use HasFactory;
    use DispatchesJobs;

    public $table = "building_queue_key";

    /**
     * The BuildingQueue's associated BuildingType
     */
    public function buildingType()
    {
        return $this->hasOne("\App\Models\BuildingTypes", "id", "buildingID");
    }

    /**
     * Relationship between this queued building and its job
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function job()
    {
        return $this->hasOne("\App\Models\Jobs", "id", "jobID");
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
        $job = (new BuildBuilding($this->buildingType, $this))
            ->delay(now()->addMinutes($this->buildingType->buildingTime));

        $jobID = $this->dispatch($job);

        $this->jobID = $jobID;
        $this->save();
    }

    /**
     * Determines if the job is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        if ($this->jobID === null)
            return false;

        return true;
    }

    /**
     * Figures out how much time left on the job with a readable format
     *
     * @return false|string
     */
    public function timeLeft(): bool|string
    {
        if (! $this->isActive()) // If the job isn't active, it's not gonna have a time left
            return false;

        return Carbon::createFromTimestamp($this->job->available_at)->diffForHumans();
    }
}
