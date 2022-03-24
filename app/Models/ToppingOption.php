<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingOption extends Model
{
    protected $table='oc_topping_option';
    protected $primaryKey = 'id_topping_option';
    public $timestamps = false;
}
