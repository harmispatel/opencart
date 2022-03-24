<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingCatOption extends Model
{
    protected $table='oc_topping_cat_option';
    protected $primaryKey = 'id';
    public $timestamps=false;
}
