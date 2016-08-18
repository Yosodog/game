<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    public $fillable = ["type", "status", "nation_id", "city_id", "item_id", "totalTurns", "turnsLeft"];

    /**
     * The Job/ID of whatever the job is for relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relation() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        // TODO when implementing other queue types, you'll have to determine the relationship using this model's type property

        // For now, there's only building queues so just return it

        return $this->belongsTo('App\Models\BuildingTypes', "item_id");
    }

    /**
     * Determines what percentage completed this job is
     *
     * @return int
     */
    public function percentageFinished() : int
    {
        if ($this->status != "active") // If it's not active then it's obviously 0%
            return 0;

        $turnsCompleted = $this->totalTurns - $this->turnsLeft;


        return round(($turnsCompleted / $this->totalTurns) * 100);
    }
}
