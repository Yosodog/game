<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    public $fillable = ["name", "baseValue"];
    public $timestamps = false;
}
