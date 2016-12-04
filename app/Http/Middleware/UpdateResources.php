<?php

namespace App\Http\Middleware;

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
        $totalIncome = 0;

        foreach ($this->user->nation->cities as $city)
        {
            // Calculate how much money they make per day
            $totalIncome += round($city->properties["Avg Income"]["value"] * $city->population, 2);
        }

        // Calculate how much they make per second
        $moneyPerSec = round($totalIncome / 86400, 2);

        // Add the per second things to the session so we don't have to calculate them later
        session([
            "moneyPerSec" => $moneyPerSec
        ]);

        // TODO implement adding resources here

        // Now update resources
        $this->user->nation->resources->money += $moneyPerSec * $this->diff;

        // Update last request
        $this->user->lastRequest = $this->now;

        // Save Resources and user
        $resouces = $this->user->nation->resources;

        $this->user->save();
        $resouces->save();
    }
}
