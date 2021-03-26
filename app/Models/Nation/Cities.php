<?php

namespace App\Models\Nation;

use App\Models\Properties;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    /**
     * Array to store all the properties and their values for the city.
     *
     * @var array
     */
    public $properties = [];

    /**
     * Add properties to $appends so that Laravel will return this.
     *
     * @var array
     */
    protected $appends = ['properties'];

    /**
     * @var float Holds the multiplier for power if the city is underpowered
     */
    public float $powerMultiplier;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nation_id', 'land',
    ];

    /**
     * Relationship between the nation and the city.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Nation\Nations');
    }

    /**
     * City/BuildingQueue relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buildingQueue(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Nation\BuildingQueue', 'cityID');
    }

    /**
     * Relationship between the city and it's buildings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buildings()
    {
        return $this->hasMany('\App\Models\Nation\Building', 'city_id');
    }

    /**
     * Determines if the user viewing the city owns the city.
     *
     * @return bool
     */
    public function isOwner(): bool
    {
       return Auth::user()->nation->id === $this->nation_id;
    }

    /**
     * Checks if there are any open slots for building.
     *
     * @return bool
     */
    public function checkIfOpenBuildingSlots(): bool
    {
        $activeSlots = $this->countActiveJobs();

        return $activeSlots < $this->getTotalBuildingSlots();
    }

    /**
     * Returns how many building queue slots the city can support
     *
     * @return int
     */
    public function getTotalBuildingSlots(): int
    {
        return 5;
    }

    /**
     * Count how many jobs are currently active.
     *
     * @return int
     */
    public function countActiveJobs(): int
    {
        return $this->buildingQueue()->count();
    }

    /**
     * Returns information about a building by searching for the building ID
     * If the city doesn't have that building, it returns an empty array.
     *
     * @param int $buildingID
     * @return mixed
     */
    public function getBuilding(int $buildingID)
    {
        return $this->buildings->where('building_id', $buildingID);
    }

    /**
     * Loads the "full city".
     *
     * Includes the city's buildings, those building types, and the effects for that building
     */
    public function loadFullCity()
    {
        $this->load('buildings.buildingType.effects.property');
        $this->setupProperties();
    }

    /**
     * Gets all of the properties and sets them up properly for later use.
     *
     * @param Collection|null $properties Sometimes we want to call this in a loop and we don't want to lookup all
     * the properties every single time. So we can look it up once and pass it to this method
     */
    public function setupProperties(Collection $properties = null)
    {
        if ($properties == null)
            $properties = Properties::all(); // If we didn't pass the properties, then get them

        foreach ($properties as $prop) // Sort the properties how I want them
        {
            $this->properties[$prop->name] = [
                'id' => $prop->id,
                'higherIsBetter' => $prop->higherIsBetter,
                'isOutOf100' => $prop->isOutOf100,
                'maxPoints' => $this->population * $prop->pointsPerPerson,
                'points' => 0, // Would be calculated later
                'value' => 0.00,
                'usesPointSystem' => $prop->usesPointSystem,
            ];
        }
    }

    /**
     * Returns the properties array.
     *
     * @return array
     */
    public function getPropertiesAttribute()
    {
        return $this->properties;
    }

    /**
     * Calculate the values of the properties of the city.
     *
     * Loops over all buildings and their effects and then adds whatever that effect's points are to the property
     * and then loops over every property and calculates a value.
     */
    public function calcStats()
    {
        // TODO this method is horrible including the methods to find the other stats. Clean this up one day

        foreach ($this->buildings as $building)
        {
            foreach ($building->buildingType->effects as $effect)
            {
                $e = $effect->toArray(); // For some reason I can't use $effect properly, so we'll convert it to array for now
                // Add the points generated by these buildings to the property points
                $this->properties[$e['property']['name']]['points'] += $effect->affect * $building->quantity; // TODO try to clean this up one day
            }
        }

        // Now calculate the value of the property
        foreach ($this->properties as $k => $property)
        {
            if (! $property['usesPointSystem'])
                continue; // If the property doesn't use the point system, we're going to calculate it below manually

            $value = @(round(($property['points'] / $property['maxPoints']) * 100, 2));
            if (! $property['higherIsBetter'] && $property['isOutOf100'])
                $value = 100 - $value;
            if ($value > 100)
                $value = 100;
            elseif ($value < 0)
                $value = 0;
            elseif (is_nan($value) || is_infinite($value))
                $value = 0;

            $this->properties[$k]['value'] = $value;
        }

        // Calculate the other stats that don't use the point system
        $this->calcSatisfaction();
        $this->calcAvgIncome();
        $this->calcBirthRate();
        $this->calcDeathRate();
        $this->calcImmigration();
        $this->calcGrowthRate();
    }

    /**
     * Calculates Birth Rate.
     */
    protected function calcBirthRate()
    {
        $crime = $this->properties['Crime']['value'];
        $disease = $this->properties['Disease']['value'];
        $literacy = $this->properties['Literacy']['value'];

        $baseBirth = $this->population / 100;
        $crimeLost = ($crime / 170) * $baseBirth;
        $diseaseLost = ($disease / 170) * $baseBirth;
        $literacy = ($literacy / 170) * $baseBirth;

        $value = floor($baseBirth - ($crimeLost + $diseaseLost + $literacy));

        $this->properties['Birth Rate']['value'] = $value > 0 ? $value : 0; // Death rate can't less than 0...;
    }

    /**
     * Calculates Death Rate.
     */
    protected function calcDeathRate()
    {
        $crime = $this->properties['Crime']['value'];
        $disease = $this->properties['Disease']['value'];
        $literacy = $this->properties['Literacy']['value'];

        $baseDeath = $this->population / 250;
        $crimeGained = ($crime / 300) * $baseDeath;
        $diseaseGained = ($disease / 300) * $baseDeath;
        $literacyLost = ($literacy / 90) * $baseDeath;

        $value = floor(($baseDeath + $crimeGained + $diseaseGained) - $literacyLost);

        $this->properties['Death Rate']['value'] = $value > 0 ? $value : 0; // Death rate can't less than 0...
    }

    /**
     * Calculates Immigration Rate.
     */
    protected function calcImmigration()
    {
        $crime = $this->properties['Crime']['value'];
        $disease = $this->properties['Disease']['value'];
        $literacy = $this->properties['Literacy']['value'];
        $unemployment = $this->properties['Unemployment']['value'];
        $avgIncome = $this->properties['Avg Income']['value'];

        $baseImm = $this->population / 80;
        $crimeLost = ($crime / 200) * $baseImm;
        $diseaseLost = ($disease / 200) * $baseImm;
        $literacyGained = ($literacy / 90) * $baseImm;
        $unemploymentLost = ($unemployment / 90) * $baseImm;
        $incomeGained = ($avgIncome / 90) * $baseImm;

        $value = floor(($baseImm + $literacyGained + $incomeGained) - ($crimeLost + $diseaseLost + $unemploymentLost));

        $this->properties['Immigration']['value'] = $value;
    }

    /**
     * Calculates Growth Rate.
     */
    protected function calcGrowthRate()
    {
        $value = 0;
        $value += $this->properties['Birth Rate']['value'];
        $value += $this->properties['Immigration']['value'];
        $value -= $this->properties['Death Rate']['value'];

        $this->properties['Growth Rate']['value'] = $value;
    }

    /**
     * Calculates Govt Satisfaction.
     *
     * This is basically an average of a couple properties
     */
    protected function calcSatisfaction()
    {
        $total = 0;
        $total += 100 - $this->properties['Crime']['value'];
        $total += 100 - $this->properties['Disease']['value'];
        $total += 100 - $this->properties['Unemployment']['value'];
        $total += $this->properties['Literacy']['value'];

        $this->properties['Govt Satisfaction']['value'] = $total / 4;
    }

    /**
     * Calculates Average Income.
     */
    protected function calcAvgIncome()
    {
        $satisfaction = $this->properties['Govt Satisfaction']['value'];

        $value = $satisfaction * 1.5;

        $this->properties['Avg Income']['value'] = $value;
    }

    /**
     * Calculates energy based on whether we want to calculate power production or power consumption
     *
     * @param bool $produces
     * @return int
     */
    protected function calcPower(bool $produces): int
    {
        // TODO optimise
        $power = 0;
        foreach ($this->buildings as $building)
        {
            if ($building->buildingType->category === "power" xor ! $produces)
                continue; // Building produces power, does not consume

            $power += $building->buildingType->energy * $building->quantity;
        }

        return $power;
    }

    /**
     * Calculates power usage
     *
     * @return int
     */
    public function calculatePowerUsage(): int
    {
        return $this->calcPower(false);
    }

    /**
     * Calculates energy production
     *
     * @return int
     */
    public function calculatePowerProduction(): int
    {
        return $this->calcPower(true);
    }

    /**
     * Determines if the city is powered
     *
     * @return bool
     */
    public function isPowered(): bool
    {
        if ($this->calculatePowerUsage() < $this->calculatePowerProduction())
            return false;

        return true;
    }

    public function getPowerMultiplier()
    {
        
    }

    /**
     * This method determines if the city was powered for the duration that we're looking at
     * If the city was powered for 100% of the time, we'll return 1. If it was powered for
     * 40% of the time, we'll return 0.4. Then, we will use this value and multiply it
     * by the amount produced to get an accurate number of what was actually produced
     *
     * @param bool $refresh If the value is already set but we want to refresh it
     */
    public function getPowerMultiplierr(bool $refresh = false): void
    {
        if (isset($this->powerMultiplier) && ! $refresh)
            return; // In case this is called after it has already been set. No need to re-run everything

        $producedPower = 0;
        // First we need to determine how many MWs we produced for this diff
        foreach ($this->buildings as $building)
        {
            if (! $building->buildingType->producesPower())
                continue; // Building doesn't produce power

            $totalPower = ($building->buildingType->energy * $building->quantity) * $this->diff; // How much power this should produce for this diff
            $reqAmount = (($building->buildingType->requiredAmount * $building->quantity) / 86400) * $this->diff; // How many resources we needed for this diff

            echo "Required $reqAmount <br>";

            // Determine if we were able to feed the power plant for the whole time
            if ($reqAmount > $this->nation->resources->{$building->buildingType->requiredResource}) // holy shit
            {
                echo "Required Amount $reqAmount <br>";
                // We need to check if they had enough resources to produce some stuff.
                // If they have nothing of what's required, continue to the next building
                if ($this->nation->resources->{$building->buildingType->requiredResource} <= 0)
                    continue;

                echo "asdf " . $this->nation->resources->{$building->buildingType->requiredResource} . "<br>";

                echo "heyyy <br>";

                // if they have some of the required resource but not enough for the entire duration,
                // calculate what percentage they can afford and later, that'll be how much they produce
                $percOfProduced = $this->nation->resources->{$building->buildingType->requiredResource} / $reqAmount;

                echo "Perc $percOfProduced <br>";

                // Now see what was produced by multiplying the expected total power output by the percentage we could produce power
                $producedPower += $totalPower * $percOfProduced; // Add how much power we produced to the $producedPower
            }
            else // If we had the required amount to produce power
            {
                $producedPower += $totalPower; // Add all of our power to the produced power
            }
        }

        // Now that we've calculated how many MWs we produced for this diff, we need to figure out how much we needed
        $neededPower = $this->calculatePowerUsage() * $this->diff; // Total required power times how many seconds for the diff

        // Now calculate the percentage of produced power to total power needed
        $perc = $producedPower / $neededPower;

        echo "Actual Perc $perc <br>";

        echo "Pro $producedPower Need $neededPower <br>";

        // If we produced more than what we needed, set multiplier to 1, otherwise, set it to the perc we calculated above
        if ($perc > 1)
            $this->powerMultiplier = 1;
        elseif($perc < 0)
            $this->powerMultiplier = 0;
        else
            $this->powerMultiplier = $perc;
    }
}
