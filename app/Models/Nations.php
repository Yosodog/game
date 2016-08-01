<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nations extends Model
{
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
