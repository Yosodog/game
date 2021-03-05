<?php

namespace App\Models;

use App\Models\Nation\Building;
use Illuminate\Database\Eloquent\Model;

/**
 * Jobs class. Used to build things, research things, and whatever else needs to take time.
 *
 * Not to be confused with Laravel "jobs". That's in the "queue" table/model
 */
class Jobs extends Model
{
    /**
     * Properties that can be filled by the ::create method.
     *
     * @var array
     */
    public $fillable = ['type', 'status', 'nation_id', 'city_id', 'item_id', 'totalTurns', 'turnsLeft', 'runsAfter'];

    /**
     * The Job/ID of whatever the job is for relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        // TODO when implementing other queue types, you'll have to determine the relationship using this model's type property

        // For now, there's only building queues so just return it

        return $this->belongsTo('App\Models\BuildingTypes', 'item_id');
    }

    /**
     * Job/Nation relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Nation\Nations', 'id', 'nation_id');
    }

    /**
     * Job/City relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Nation\City', 'city_id');
    }

    /**
     * Adds a job for.
     *
     * @param array $attributes
     * @return Jobs
     */
    public static function addJob(array $attributes): self
    {
        // Check if the status was set to active. If it was, set runsAfter to null, otherwise set it to whichever job this job should run after
        if ($attributes['status'] === 'active')
            $attributes['runsAfter'] = null;
        else // Determine what job this should run after
        {
            // Check if the job is for a city
            if ($attributes['type'] === 'building')
            {
                $lastJob = self::selectLastCityJob($attributes['city_id']);
                $attributes['runsAfter'] = $lastJob->id;
            }
            else // If the job isn't for a city, then get the last nation job
            {
                // TODO
            }
        }

        return self::create($attributes);
    }

    /**
     * Selects the last job for a city.
     *
     * @param int $cityID
     * @return Jobs
     */
    public static function selectLastCityJob(int $cityID): self
    {
        return self::where('city_id', $cityID)
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhere('status', 'queued');
            })
            ->orderBy('id', 'desc')
            ->firstOrFail();
    }

    /**
     * Determines what percentage completed this job is.
     *
     * @return int
     */
    public function percentageFinished(): int
    {
        if ($this->status != 'active') // If it's not active then it's obviously 0%
            return 0;

        $turnsCompleted = $this->totalTurns - $this->turnsLeft;

        return round(($turnsCompleted / $this->totalTurns) * 100);
    }

    /**
     * Checks if the job has one turn left or not.
     *
     * If it does, then the building should be created
     *
     * @return bool
     */
    public function checkIfOneTurnLeftOnJob(): bool
    {
        if ($this->turnsLeft === 1)
            return true;
        else
            return false;
    }

    /**
     * Finishes the job.
     */
    public function finishJob()
    {
        switch ($this->type)
        {
            case 'building':
                $this->buildBuilding();
                break;
            default:
                throw new \Exception("Couldn't determine job type");
        }

        $this->turnsLeft = 0;
        $this->status = 'completed';
        $this->save();

        $this->startNextJob();
    }

    /**
     * Calls for the building to be created if the job is for a building.
     */
    private function buildBuilding()
    {
        $building = Building::firstOrNew([
            'city_id' => $this->city_id,
            'building_id' => $this->item_id,
        ]);

        $building->quantity += 1;
        $building->save();
    }

    /**
     * Starts the next queued job.
     */
    public function startNextJob()
    {
        $next = self::where('runsAfter', $this->id)->first();
        if ($next != null)
        {
            $this->start($next);

            return true; // If we were able to start the next job, return true
        }

        return false; // We weren't able to start the next job. This doesn't mean there's an error.
    }

    /**
     * Alright, this is an interesting one. If jobs are cancelled in a certain order,
     * it might not call the next job to start because runsAfter might already be deleted
     * so this method does a little more work than startNextJob in order to ensure the next job is called
     * however we keep startNextJob because it is less resource intensive for mostly the turn running.
     */
    public function startNextJobHardcore()
    {
        // Call startNextJob to see if it can start the next job for us
        if ($this->startNextJob())
            return; // If it started the next job then YAY we don't have to do shit

        // Didn't start the next job? Let's try to find the next one if there is any
        $nextJob = self::where('city_id', $this->city_id)
            ->where('status', 'queued')
            ->first();

        if ($nextJob == null)
            return; // No jobs are queued

        // If we found a queued job, then let's start it
        $this->start($nextJob);
    }

    /**
     * Start the job.
     *
     * @param Jobs $job
     */
    public function start(self $job)
    {
        $job->status = 'active';
        $job->save();
    }

    /**
     * Subtracts a turn from the job.
     */
    public function subtractTurn()
    {
        $this->turnsLeft -= 1;
        $this->save();
    }

    /**
     * Cancels the job.
     *
     * @throws \Exception
     */
    public function cancelJob()
    {
        $this->refund();
        // Check if this job was active. If it was, then start the next one.
        if ($this->status == 'active')
            $this->startNextJobHardcore();

        $this->delete();
    }

    /**
     * Determines which type of job this is and calls the appropriate method to refund.
     *
     * @throws \Exception
     */
    protected function refund()
    {
        switch ($this->type)
        {
            case 'building':
                $this->refundBuilding();
                break;
            default:
                throw new \Exception("Couldn't determine job type");
        }
    }

    /**
     * Refunds the nation the value of the building.
     */
    protected function refundBuilding()
    {
        // Get the nation's resources
        $this->nation->resources->money += $this->relation->cost();
        // And save their refund
        $this->nation->resources->save();
    }
}
