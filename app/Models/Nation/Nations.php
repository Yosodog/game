<?php

namespace App\Models\Nation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nations extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id',
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
     * Get and return an instance of this model by the Nation ID
     *
     * @param int $id
     * @return Nations
     */
    public static function getNationByID(int $id) : self
    {
        return self::find($id);
    }
}
