<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $table='oc_topping';
    protected $primaryKey = 'id_topping';
    public $timestamps=false;
}
