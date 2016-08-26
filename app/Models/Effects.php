<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effects extends Model
{
    public $timestamps = false;
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
