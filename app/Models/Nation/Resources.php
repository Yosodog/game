<?php

namespace App\Models\Nation;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Nation/resources relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Nation\Nations', 'nationID');
    }
}
