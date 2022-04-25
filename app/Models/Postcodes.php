<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcodes extends Model
{
    protected $connection = 'mysql3';
    public $table = "coordinates";
    public $timestamps = false;
}
