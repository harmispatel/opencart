<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductToppingType extends Model
{
    use HasFactory;
    protected $table='oc_product_topping_type';
    protected $primaryKey = 'id_product';
    public $timestamps=false;

}
