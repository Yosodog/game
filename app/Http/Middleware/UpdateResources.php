<?php

namespace App\Http\Middleware;

use App\Models\Nation\Cities;
use App\Models\Properties;
use Closure;
use Auth;

class UpdateResources
{
    /**
     * Unix timestamp of now
     *
     * @var int
     */
    protected $now;

    /**
     * Holds the user with all the nation and city info
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The difference in seconds between the last request and now
     *
     * @var int
     */
    protected $diff;

    /**
     * All resources are per second
     *
     * @var int $money
     * @var int $coal
     * @var int $oil
     * @var int $gas
     * @var int $wheat
     * @var int $livestock
     */
    protected $money = 0, $coal = 0, $oil = 0, $gas = 0, $wheat = 0, $livestock = 0;

    /**
     * All are per second
     *
     * @var int $bread
     * @var int $meat
     * @var int $water
     * @var int $clay
     * @var int $cement
     * @var int $timber
     */
    protected $bread = 0, $meat = 0, $water = 0, $clay = 0, $cement = 0, $timber = 0;

    /**
     * All are per second
     *
     * @var int $brick
     * @var int $concrete
     * @var int $lumber
     * @var int $rubber
     * @var int $iron
     */
    protected $brick = 0, $concrete = 0, $lumber = 0, $rubber = 0, $iron = 0;

    /**
     * All are per second
     *
     * @var int $steel
     * @var int $bauxite
     * @var int $aluminum
     * @var int $lead
     * @var int $ammo
     */
    protected $steel = 0, $bauxite = 0, $aluminum = 0, $lead = 0, $ammo = 0;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user has a nation or not. If not, just go to the next thing
        if (Auth::guest() || !Auth::user()->hasNation)
            return $next($request);


        // First calculate the unix timestamp right now
        $this->now = time(); // TODO There might be a problem with this method of updating resources because of daylight savings

        // Load everything
        $this->user = Auth::user()->load("nation.resources", "nation.cities.buildings.buildingType.effects.property");

        $this->calcDiff();
        if ($this->diff < 1)
            return $next($request); // If the difference is 0, don't bother doing all this

        $this->calcStats();
        $this->calcAddedResources();

        $this->updateResouces(); // Update the resources table
        $this->updateReq(); // Update the last request stuff
        $this->updateSession();

        return $next($request);
    }

    /**
     * Calculates the difference between the user's last request and now in seconds
     *
     * If their last request is null for some reason, just default it to whatever now is
     */
    protected function calcDiff()
    {
        $this->diff = $this->now - ($this->user->lastRequest ?? $this->now);
    }

    /**
     * Calculate the stats of all the user's cities
     */
    protected function calcStats()
    {
        // Get properties once so we don't have to do it for every city
        $properties = Properties::all();

        foreach ($this->user->nation->cities as $city)
        {
            $city->setupProperties($properties);
            $city->calcStats();
        }
    }

    /**
     * Calculate the added money/resources per second for the nation and update
     */
    protected function calcAddedResources()
    {
        foreach ($this->user->nation->cities as $city)
        {
            $this->calcMoney($city);
            $this->calcResources($city);
        }
    }

    /**
     * Calculates how much money they make per second
     *
     * @param Cities $city
     */
    protected function calcMoney(Cities $city)
    {
        // Calculate how much money they make per day
        $income = $city->properties["Avg Income"]["value"] * $city->population;
        $this->money += round($income / 86400, 2);
    }

    /**
     * Calculates how much of each resource is produced per second
     *
     * @param Cities $city
     */
    protected function calcResources(Cities $city)
    {

    }

    /**
     * Updates the resources table with the new resources
     */
    protected function updateResouces()
    {
        $resources = $this->user->nation->resources;

        $resources->money += $this->money * $this->diff;

        $resources->save();
    }

    /**
     * Updates the last request in the users table
     */
    protected function updateReq()
    {
        $this->user->lastRequest = $this->now;

        $this->user->save();
    }

    /**
     * Updates the session with the proper perSec variables so in the view we can display it easier
     */
    protected function updateSession()
    {
        session([
            "moneyPerSec" => $this->money,
        ]);
    }
}
