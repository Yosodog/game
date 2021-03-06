<?php

namespace App\Jobs;

use App\Models\BuildingTypes;
use App\Models\Nation\BuildingQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BuildBuilding implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var BuildingTypes
     */
    protected BuildingTypes $building;

    /**
     * @var BuildingQueue
     */
    protected BuildingQueue $buildingQueue;

    /**
     * @var int Hold the City ID for this job for future use
     */
    protected int $cityID;

    /**
     * Create a new job instance.
     *
     * @param BuildingTypes $building
     * @param BuildingQueue $buildingQueue
     */
    public function __construct(BuildingTypes $building, BuildingQueue $buildingQueue)
    {
        $this->building = $building;
        $this->buildingQueue = $buildingQueue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->build();
        $this->killBuildingQueue();
        $this->startNextJob();
    }

    /**
     * Tells the BuildingType to build itself
     */
    protected function build(): void
    {
        $this->building->build($this->buildingQueue->cityID);
    }

    /**
     * Cleans up the building queue
     *
     * @throws \Exception
     */
    protected function killBuildingQueue(): void
    {
        $this->buildingQueue->delete();
    }

    protected function startNextJob(): void
    {
        // See the next job in BuildingQueue model
        $this->buildingQueue = BuildingQueue::selectNextJob($this->cityID);

        if (! $this->buildingQueue)
            return; // There's nothing left in the queue
        else
            $this->buildingQueue->start(); // Add the next building to the queue
    }
}
