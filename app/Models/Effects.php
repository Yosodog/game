<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effects extends Model
{
    public $timestamps = false;
    public $fillable = ["property", "relation", "affect"];
}
