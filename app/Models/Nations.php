<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nations extends Model
{
    /**
     * Returns the user that this nation belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
