<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryDetail;
use App\Models\Category;
use App\Models\ToppingSize;
use App\Models\ToppingProductPriceSize;
use App\Models\Product;
use App\Models\ProductDescription;


class Product_to_category extends Model
{
   
    use HasFactory;
    protected $table = 'oc_product_to_category';
    protected $primaryKey='product_id';
    public $timestamps=false;
    public function hasOneProduct(){
        return $this->hasOne(Product::class,'product_id','product_id');
    }
    public function hasOneDescription(){
        return $this->hasOne(ProductDescription::class,'product_id','product_id');
    }
    public function hasOneToppingProductPriceSize(){
        return $this->hasOne(ToppingProductPriceSize::class,'id_product','product_id');
    }
}
