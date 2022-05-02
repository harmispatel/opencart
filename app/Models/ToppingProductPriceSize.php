<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ToppingSize;

class ToppingProductPriceSize extends Model
{
    use HasFactory;
    protected $table='oc_topping_product_price_size';
    protected $primaryKey='id_product_price_size';
    public $timestamps=false;

    public function hasOneToppingSize()
    {
        return $this->hasOne(ToppingSize::class,'id_size','id_size');
    }
    // public function hasOneProduct()
    // {
    //     return $this->hasOne(Product::class,'product_id','id_product');
    // }
    // public function hasOneProductDescription(){
    //     return $this->hasOne(ProductDescription::class,'product_id','product_id')->select('product_id','name','description');
    // }
}
