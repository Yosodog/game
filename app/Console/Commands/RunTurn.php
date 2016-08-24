<?php

namespace App\Console\Commands;

use App\Models\Jobs;
use App\Models\Nation\Nations;
use Illuminate\Console\Command;

class RunTurn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'turn:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the turn';

    /**
     * Store the nation that is being worked
     *
     * @var Nations
     */
    protected $nation;

    /**
     * Holds the job that we're currently working on
     *
     * @var Jobs
     */
    protected $job;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nations = Nations::all();
        foreach ($nations as $nation) // Run through every nation in the game
        {
            $this->nation = $nation;
            // Right now all we have to do is process their queue
            $this->processQueue();
        }
    }

    /**
     * Processes the job queue for the nation
     */
    protected function processQueue()
    {
        $jobs = $this->selectActiveJobs();
        if (empty($jobs))
            return; // If they have no active jobs, just return

        foreach ($jobs as $job)
        {
            $this->job = $job;
            if ($this->job->checkIfOneTurnLeftOnJob())
                $this->job->finishJob();
            else
                $this->job->subtractTurn();

        }
    }

    /**
     * Selects the nation's active jobs.
     *
     * @return mixed
     */
    protected function selectActiveJobs()
    {
        $job = $this->nation->jobs->where("status", "active");

        return $job->all();
    }
}
