<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affects extends Model
{
    public $timestamps = false;
    public $fillable = ["property", "relation", "affect"];
}
