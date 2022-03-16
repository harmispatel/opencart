<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingProductPriceSize extends Model
{
    use HasFactory;
    protected $table='oc_topping_product_price_size';
    protected $primaryKey='id_product';
    public $timestamps=false;
}
