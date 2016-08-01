<?php

namespace App\Models\Nation;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nation_id',
    ];

    /**
     * Relationship between the nation and the city
     *
     * @return BelongsTo
     */
    public function nation() : BelongsTo
    {
        return $this->belongsTo('App\Models\Nation\Nation');
    }
}
