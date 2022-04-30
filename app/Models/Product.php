<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDescription;
use App\Models\Product_to_category;
use App\Models\ToppingProductPriceSize;
use App\Models\ToppingSize;
class Product extends Model
{
    use HasFactory;
    protected $table = 'oc_product';
    protected $primaryKey = 'product_id';
    public $timestamps=false;
    public function hasOneProductDescription(){
        return $this->hasOne(ProductDescription::class,'product_id','product_id')->select('product_id','name','description');
    }
    public function hasOneToppingProductPriceSize()
    {
        return $this->hasOne(ToppingProductPriceSize::class,'id_product','product_id');
    }

   

}
