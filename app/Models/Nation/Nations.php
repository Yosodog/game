<?php

namespace App\Models\Nation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nations extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'flagID'
    ];

    protected $appends = [
        "population", "land", "pollution", "growth_rate", "birth_rate", "death_rate", "immigration", "crime",
        "disease", "satisfaction", "income", "avg_income", "unemployment", "literacy"
    ];

    /**
     * @var int $population
     * @var int $land
     * @var int $pollution
     * @var int $growth_rate
     * @var int $birth_rate
     * @var int $death_rate
     * @var int $immigration
     * @var int $crime
     */
    public $population, $land, $pollution, $growth_rate, $birth_rate, $death_rate, $immigration, $crime;

    /**
     * @var int $disease
     * @var int $satisfaction
     * @var int $income
     * @var int $avg_income
     * @var int $unemployment
     * @var int $literacy
     */
    public $disease, $satisfaction, $income, $avg_income, $unemployment, $literacy;

    /**
     * Returns the user that this nation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relationship between the Nation and its Cities
     *
     * @return HasMany
     */
    public function cities() : HasMany
    {
        return $this->hasMany('App\Models\Nation\Cities', "nation_id");
    }

    /**
     * Nation/Jobs relationship
     *
     * @return HasMany
     */
    public function jobs() : HasMany
    {
        return $this->hasMany('App\Models\Jobs', 'nation_id');
    }

    /**
     * Relationship between the nation and it's flag
     *
     * @return BelongsTo
     */
    public function flag() : BelongsTo
    {
        return $this->belongsTo('App\Models\Flags', "flagID");
    }

    /**
     * Relationship between the nation and its alliance
     *
     * @return BelongsTo
     */
    public function alliance() : BelongsTo
    {
        return $this->belongsTo('App\Models\Alliance', "allianceID");
    }

    /**
     * The nation/resource relationship
     *
     * @return HasOne
     */
    public function resources() : HasOne
    {
        return $this->hasOne('App\Models\Nation\Resources', "nationID");
    }

    /**
     * Get and return an instance of this model by the Nation ID
     *
     * @param int $id
     * @return Nations
     */
    public static function getNationByID(int $id) : self
    {
        return self::find($id);
    }

    /**
     * Checks if the nation has an alliance
     *
     * @return bool
     */
    public function hasAlliance() : bool
    {
        return $this->allianceID != null;
    }

    /**
     * Loads EVERYTHING to do with this nation
     */
    public function loadFullNation()
    {
        $this->load("cities.buildings.buildingType.effects.property", "resources");
    }

    /**
     * Calculates stats for the entire nation. Basically, adds everyone from the cities.
     */
    public function calcStats()
    {
        $this->population = $this->cities->sum("population");
        $this->land = $this->cities->sum("land");
        $this->pollution = $this->cities->sum("pollution");
        $totalCities = $this->cities->count(); // Need this later for calculating averages

        // Okay, this is going to suck. Properties are stored as arrays, not collections. So I can't easily
        // just call ->avg or ->sum on them. So I have to calculate their average or total manually.
        // TODO one day clean up the properties

        foreach ($this->cities as $city)
        {
            $this->growth_rate += $city->properties["Growth Rate"]["value"];
            $this->birth_rate += $city->properties["Birth Rate"]["value"];
            $this->death_rate += $city->properties["Death Rate"]["value"];
            $this->immigration += $city->properties["Immigration"]["value"];
            $this->income += $city->properties["Avg Income"]["value"] * $city->population;
            $this->crime += $city->properties["Crime"]["value"]; // Avg
            $this->disease += $city->properties["Disease"]["value"]; // Avg
            $this->satisfaction += $city->properties["Govt Satisfaction"]["value"]; // Avg
            $this->avg_income += $city->properties["Avg Income"]["value"]; // Avg
            $this->unemployment += $city->properties["Unemployment"]["value"]; // Avg
            $this->literacy += $city->properties["Literacy"]["value"]; // Avg
        }

        $this->crime = $this->crime / $totalCities;
        $this->disease = $this->disease / $totalCities;
        $this->satisfaction = $this->satisfaction / $totalCities;
        $this->avg_income = $this->avg_income / $totalCities;
        $this->unemployment = $this->unemployment / $totalCities;
        $this->literacy = $this->literacy / $totalCities;

        // Now average the things that need to be averaged
    }

    /**
     * @return int
     */
    public function getPopulationAttribute()
    {
        return $this->population;
    }

    /**
     * @return int
     */
    public function getLandAttribute()
    {
        return $this->land;
    }

    /**
     * @return int
     */
    public function getPollutionAttribute()
    {
        return $this->pollution;
    }

    /**
     * @return int
     */
    public function getGrowthRateAttribute()
    {
        return $this->growth_rate;
    }

    /**
     * @return int
     */
    public function getBirthRateAttribute()
    {
        return $this->birth_rate;
    }

    /**
     * @return int
     */
    public function getDeathRateAttribute()
    {
        return $this->death_rate;
    }

    /**
     * @return int
     */
    public function getImmigrationAttribute()
    {
        return $this->immigration;
    }

    /**
     * @return int
     */
    public function getCrimeAttribute()
    {
        return $this->crime;
    }

    /**
     * @return int
     */
    public function getDiseaseAttribute()
    {
        return $this->disease;
    }

    /**
     * @return int
     */
    public function getSatisfactionAttribute()
    {
        return $this->satisfaction;
    }

    /**
     * @return int
     */
    public function getIncomeAttribute()
    {
        return $this->income;
    }

    /**
     * @return int
     */
    public function getAvgIncomeAttribute()
    {
        return $this->avg_income;
    }

    /**
     * @return int
     */
    public function getUnemploymentAttribute()
    {
        return $this->unemployment;
    }

    /**
     * @return int
     */
    public function getLiteracyAttribute()
    {
        return $this->literacy;
    }
}
