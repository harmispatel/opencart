<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductToppingType extends Model
{
    use HasFactory;
    protected $table='oc_product_topping_type';
    protected $primaryKey = 'id';
    public $timestamps=false;

    function hasOneTopping()
    {
        return $this->hasOne(Topping::class,'id_topping','id_group_topping');
    }

}
