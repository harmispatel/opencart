<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDescription;
use App\Models\Product_to_category;
class Product extends Model
{
    use HasFactory;
    protected $table = 'oc_product';
    protected $primaryKey = 'product_id';
    public $timestamps=false;
    // public function hasOneProductDescription(){
    //     return $this->hasOne(ProductDescription::class,'product_id','product_id');
    // }
    // public function hasOneProduct_to_category(){
    //     return $this->hasOne(Product_to_category::class,'product_id','product_id');
    // }

}
