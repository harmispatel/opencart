<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDescription;
use App\Models\Product_to_category;
use App\Models\ToppingProductPriceSize;
use App\Models\ToppingSize;
use App\Models\ProductStore;
class Product extends Model
{
    use HasFactory;
    protected $table = 'oc_product';
    protected $primaryKey = 'product_id';
    public $timestamps=false;

    // Has One Relation with "oc_product_description" table
    public function hasOneProductDescription(){
        return $this->hasOne(ProductDescription::class,'product_id','product_id')->select('product_id','name','description');
    }

    // Has One Relation with "oc_topping_product_price_size" table
    public function hasOneToppingProductPriceSize()
    {
        return $this->hasOne(ToppingProductPriceSize::class,'id_product','product_id');
    }

    // Has One Relation with "oc_product_to_store" table
    public function hasOneProductToStore()
    {
        return $this->hasOne(ProductStore::class, 'product_id','product_id');
    }


}
