<?php

namespace App\Console\Commands;

use App\Models\Jobs;
use App\Models\Properties;
use App\Models\Nation\Cities;
use App\Models\Nation\Nations;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

ini_set('memory_limit', '512M'); // TODO this is a temporary hack. Fix this later

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
     * Store the nation that is being worked.
     *
     * @var Nations
     */
    protected $nation;

    /**
     * Holds the job that we're currently working on.
     *
     * @var Jobs
     */
    protected $job;

    /**
     * Holds the properties of the cities.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $properties;

    /**
     * Holds the when $id then $pop statement for every city.
     *
     * @var array
     */
    protected $queries = [];

    /**
     * Holds an array of all city IDs.
     *
     * @var array
     */
    protected $cIDs = [];

    /**
     * A place to temp store a nation's new resource values.
     *
     * @var array
     */
    protected $resources = [];

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
        $this->properties = Properties::all(); // Get properties now so we don't have to query this a billion times

        foreach ($nations as $nation) // Run through every nation in the game
        {
            $this->resources = [];
            $this->nation = $nation;
            $this->nation->loadFullNation();
            // Right now all we have to do is process their queue
            $this->processQueue();
            $this->updateCities();
        }

        $this->setupQuery();
    }

    /**
     * Processes the job queue for the nation.
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
        $job = $this->nation->jobs->where('status', 'active');

        return $job->all();
    }

    /**
     * Method to update the nation's cities with all their shit.
     */
    protected function updateCities()
    {
        foreach ($this->nation->cities as $city)
        {
            $city->setupProperties($this->properties);
            $city->calcStats();

            $pop = $city->population + ($city->properties['Growth Rate']['value'] / 12); // Calculate the new population

            $sql = "when $city->id then ".intval($pop); // Setup whatever needs to be added to the sql query

            array_push($this->queries, $sql); // Push it to an array so we can setup the query later
            array_push($this->cIDs, $city->id); // Add the city ID to an array so we can add that to the query later
        }
    }

    /**
     * Sets up and executes one query to update all nations.
     */
    protected function setupQuery()
    {
        $query = "UPDATE cities SET population = CASE id\n"; // Setup the query
        foreach ($this->queries as $qu) // Add each when $id then $pop to the query for every city
            $query .= $qu."\n";

        $IDs = implode(',', $this->cIDs); // Separate the city IDs with commas

        $query .= "END WHERE id IN ($IDs)"; // Add the comma separated IDs to the query

        DB::statement($query); // Now execute the GIGANTIC QUERY. This is a fuck-ton faster than one query for every city
    }
}
