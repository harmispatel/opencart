<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerstoStore extends Model
{
    public $table='oc_manufacturer_to_store';
    protected $primaryKey = 'manufacturer_id';
    public $timestamps = false;
}
