<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $table = "oc_zone";
    protected $primaryKey = 'zone_id';
    public $timestamps = false;
}
