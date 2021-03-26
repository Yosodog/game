<?php


namespace App\Helpers;

use App\Models\Nation\Building;
use App\Models\Nation\Cities;
use App\Models\Properties;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UpdateResources
{
    /**
     * Unix timestamp of now.
     *
     * @var int
     */
    protected $now;

    /**
     * Holds the user with all the nation and city info.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The difference in seconds between the last request and now.
     *
     * @var int
     */
    protected $diff;

    /**
     * All resources are per second.
     *
     * @var int
     * @var int
     * @var int
     * @var int
     * @var int
     * @var int
     */
    protected $money = 0;
    protected $coal = 0;
    protected $oil = 0;
    protected $gas = 0;
    protected $wheat = 0;
    protected $livestock = 0;

    /**
     * All are per second.
     *
     * @var int
     * @var int
     * @var int
     * @var int
     * @var int
     * @var int
     */
    protected $bread = 0;
    protected $meat = 0;
    protected $water = 0;
    protected $clay = 0;
    protected $cement = 0;
    protected $timber = 0;

    /**
     * All are per second.
     *
     * @var int
     * @var int
     * @var int
     * @var int
     * @var int
     */
    protected $brick = 0;
    protected $concrete = 0;
    protected $lumber = 0;
    protected $rubber = 0;
    protected $iron = 0;

    /**
     * All are per second.
     *
     * @var int
     * @var int
     * @var int
     * @var int
     * @var int
     */
    protected $steel = 0;
    protected $bauxite = 0;
    protected $aluminum = 0;
    protected $lead = 0;
    protected $ammo = 0;

    /**
     * Holds the strings of the resources we want to update so later it makes updating things easier. You'll see.
     *
     * @var array
     */
    protected $updates = [
        'money', 'coal', 'oil', 'gas', 'rubber', 'steel', 'iron', 'bauxite', 'aluminum', 'lead', 'ammo',
        'clay', 'cement', 'timber', 'brick', 'concrete', 'lumber', 'wheat', 'livestock', 'bread', 'meat', 'water',
    ];

    /**
     * Holds the request for us.
     *
     * @var \App\Http\Requests\
     */
    protected $request;

    /**
     * Used when the nation can only produce a % of a resource.
     *
     * @var int|null
     */
    protected $percOfResource;

    /**
     * Handle an incoming request.
     *
     * @param User $user
     * @return mixed
     */
    public function handle(User $user)
    {
        if (! $user->hasNation)
            return; // User doesn't have a nation

        // First calculate the unix timestamp right now
        $this->now = time(); // TODO There might be a problem with this method of updating resources because of daylight savings

        // Load everything
        $this->user = $user->load('nation.resources', 'nation.cities.buildings.buildingType.effects.property');

        $this->calcDiff();

        echo "Diff $this->diff <br>";
        if ($this->diff < 1)
            return; // If the difference is 0, don't bother doing all this

        $this->calcStats();
        $this->calcAddedResources();

        $this->updateResouces(); // Update the resources table
        $this->updateReq(); // Update the last request stuff
    }

    /**
     * Calculates the difference between the user's last request and now in seconds.
     *
     * If their last request is null for some reason, just default it to whatever now is
     */
    protected function calcDiff()
    {
        if ($this->user->nation->resources_last_updated === null)
            $this->diff = 1;
        else
            $this->diff = $this->now - ($this->user->nation->resources_last_updated ?? $this->now - 1);
    }

    /**
     * Checks if the city is powered. We create our own method here in case of future logic
     *
     * @param Cities $city
     * @return bool
     */
    protected function checkForPower(Cities $city): bool
    {
        return $city->isPowered();
    }

    /**
     * Calculate the stats of all the user's cities.
     */
    protected function calcStats()
    {
        // Get properties once so we don't have to do it for every city
        $properties = Properties::all();

        foreach ($this->user->nation->cities as $city)
        {
            echo "$city->name <br>";
            $city->setupProperties($properties);
            $city->calcStats();
            echo "<br>";
        }
    }

    /**
     * Calculate the added money/resources per second for the nation and update.
     */
    protected function calcAddedResources()
    {
        foreach ($this->user->nation->cities as $city)
        {
            if (! $this->checkForPower($city))
                continue; // We won't do any calculations for the unpowered city

            $city->getPowerMultiplier();
            echo "Mult $city->powerMultiplier";

            $this->calcMoney($city);
            $this->calcResources($city);
        }
    }

    /**
     * Calculates how much money they make per second.
     *
     * @param Cities $city
     */
    protected function calcMoney(Cities $city)
    {
        // Calculate how much money they make per day. Multiply it by the power multiplier
        $income = $city->properties['Avg Income']['value'] * $city->population;
        $this->money += ($income / 86400) * $city->powerMultiplier;
    }

    /**
     * Calculates how much of each resource is produced per second.
     *
     * @param Cities $city
     */
    protected function calcResources(Cities $city)
    {
        foreach ($city->buildings as $building)
        {
            $this->percOfResource = null; // Always make sure this was reset

            if (! $building->buildingType->produces && ! $building->buildingType->requires)
                continue; // If the building does not produce or require resources, just go to the next iteration

            if ($building->buildingType->requires)
                if (! $this->calcRequired($building))
                    continue; // If the building does not have the required resource, move to next iteration

            // Now that the required resources has been taken, produce the produced resources
            if ($building->buildingType->produces)
                $this->calcProduced($building);
        }
    }

    /**
     * Verify that the nation has the required resources and if so, subtract those resources.
     *
     * @param Building $building
     * @return bool
     */
    protected function calcRequired(Building $building): bool
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
            $this->{$building->buildingType->requiredResource} -= ($this->user->nation->resources->{$building->buildingType->requiredResource} / $this->diff) * $building->city->powerMultiplier;

            // Return true now that the resources has been subtracted
            return true;
        }

        // If the nation has the required resource, then subtract it
        $this->{$building->buildingType->requiredResource} -= ($reqAmount / $this->diff) * $building->city->powerMultiplier;

        // Also subtract it from the nation->resources variable so that the next buildings are checked properly
        $this->user->nation->resources->{$building->buildingType->requiredResource} -= ($reqAmount / $this->diff) * $building->city->powerMultiplier;

        return true;
    }

    /**
     * Calculates the amount this building should produce.
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
            $this->{$building->buildingType->producedResource} += ($produce / $this->diff) * $building->city->powerMultiplier;

            return;
        }

        // If they can produce the full amount, add it here
        $this->{$building->buildingType->producedResource} += (($building->buildingType->producedAmount * $building->quantity) / 86400) * $building->city->powerMultiplier;
    }

    /**
     * Updates the resources table with the new resources.
     */
    protected function updateResouces()
    {
        $resources = $this->user->nation->resources;

        foreach ($this->updates as $update)
        {
            $resources->{$update} += $this->{$update} * $this->diff;
            echo "Updated $update by " . ($this->{$update} * $this->diff). "<br>";
        }

        $resources->save();
    }

    /**
     * Updates the resources last updated in the nations table.
     */
    protected function updateReq()
    {
        $this->user->nation->resources_last_updated = $this->now;

        $this->user->nation->save();
    }

    /**
     * Updates the session with the proper perSec variables so in the view we can display it easier.
     * @param Request $request
     * @return Request
     */
    public function updateSession(Request $request): Request
    {
        foreach ($this->updates as $update)
            $request->session()->put($update.'PerSec', $this->{$update});

        return $request;
    }
}