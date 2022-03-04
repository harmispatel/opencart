<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $table = "oc_country";
    protected $primaryKey = 'country_id';
    public $timestamps = false;
}
