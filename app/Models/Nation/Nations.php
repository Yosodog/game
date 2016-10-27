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
}
