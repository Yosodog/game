<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effects extends Model
{
    /**
     * Do not add timestamps on queries
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Properties that are fillable in the ::create method
     *
     * @var array
     */
    public $fillable = ["property", "relation", "affect"];

    /**
     * Effect/Property relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('\App\Models\Properties', "property");
    }
}
