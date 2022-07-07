<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturers extends Model
{
    use HasFactory;
    protected $table='oc_manufacturer';
    protected $primaryKey = 'manufacturer_id';
    public $timestamps = false;
}
