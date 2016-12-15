<?php

namespace App\Http\Middleware;

use App\Models\Nation\Building;
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
     * Holds the strings of the resources we want to update so later it makes updating things easier. You'll see
     *
     * @var array
     */
    protected $updates = [
            "money", "coal", "oil", "gas", "rubber", "steel", "iron", "bauxite", "aluminum", "lead", "ammo",
            "clay", "cement", "timber", "brick", "concrete", "lumber", "wheat", "livestock", "bread", "meat", "water"
    ];

    /**
     * Holds the request for us
     *
     * @var \App\Http\Requests\
     */
    protected $request;

    /**
     * Used when the nation can only produce a % of a resource
     *
     * @var int|null
     */
    protected $percOfResource;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->request = $request;

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
        $this->money += $income / 86400;
    }

    /**
     * Calculates how much of each resource is produced per second
     *
     * @param Cities $city
     */
    protected function calcResources(Cities $city)
    {
        foreach ($city->buildings as $building)
        {
            $this->percOfResource = null; // Always make sure this was reset

            if (!$building->buildingType->produces && !$building->buildingType->requires)
                continue; // If the building does not produce or require resources, just go to the next iteration

            if ($building->buildingType->requires)
                if (!$this->calcRequired($building))
                    continue; // If the building does not have the required resource, move to next iteration

            // Now that the required resources has been taken, produce the produced resources
            if ($building->buildingType->produces)
                $this->calcProduced($building);
        }
    }

    /**
     * Verify that the nation has the required resources and if so, subtract those resources
     *
     * @param Building $building
     * @return bool
     */
    protected function calcRequired(Building $building) : bool
    {
        // Calculate the amount this building needs
        $reqAmount = (($building->buildingType->requiredAmount * $building->quantity) / 86400) * $this->diff;

        // Is the required amount more than what they have?
        if ($reqAmount > $this->user->nation->resources->{$building->buildingType->requiredResource}) // holy shit
        {
            // We need to check if they had enough resources to produce some stuff.
            // If they have nothing of what's required, just return false
            if ($this->user->nation->resources->{$building->buildingType->requiredResource} == 0)
                return false;

            // if they have some of the required resource but not enough for the entire duration,
            // calculate what percentage they can afford and later, that'll be how much they produce
            $this->percOfResource = $this->user->nation->resources->{$building->buildingType->requiredResource} / $reqAmount;

            // Now remove all of this resource. Divide it by the diff because later we multiply it by the diff. This makes it more simple
            $this->{$building->buildingType->requiredResource} -= $this->user->nation->resources->{$building->buildingType->requiredResource} / $this->diff;

            // Return true now that the resources has been subtracted
            return true;
        }

        // If the nation has the required resource, then subtract it
        $this->{$building->buildingType->requiredResource} -= $reqAmount;

        // Also subtract it from the nation->resources variable so that the next buildings are checked properly
        $this->user->nation->resources->{$building->buildingType->requiredResource} -= $reqAmount;

        return true;
    }

    /**
     * Calculates the amount this building should produce
     *
     * @param Building $building
     */
    protected function calcProduced(Building $building)
    {
        // Check if we should only produce a certain percentage
        if ($this->percOfResource != null)
        {
            // Calculate how much they should produce if they had all required resource, then multiply by the percentage
            $produce = ((($building->buildingType->producedAmount * $building->quantity) / 86400) * $this->diff) * $this->percOfResource;

            // Set the amount needed but divide it by the the diff because later is it multiplied by the diff
            $this->{$building->buildingType->producedResource} += $produce / $this->diff;

            return;
        }

        // If they can produce the full amount, add it here
        $this->{$building->buildingType->producedResource} += ($building->buildingType->producedAmount * $building->quantity) / 86400;
    }

    /**
     * Updates the resources table with the new resources
     */
    protected function updateResouces()
    {
        $resources = $this->user->nation->resources;

        foreach ($this->updates as $update)
            $resources->{$update} += $this->{$update} * $this->diff;

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
        foreach ($this->updates as $update)
            $this->request->session()->put($update."PerSec", $this->{$update});
    }
}
