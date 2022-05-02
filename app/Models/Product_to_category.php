<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryDetail;
use App\Models\Category;
use App\Models\ToppingSize;
use App\Models\OrderProduct;
use App\Models\ToppingProductPriceSize;
use App\Models\Product;
use App\Models\ProductDescription;


class Product_to_category extends Model
{

    use HasFactory;
    protected $table = 'oc_product_to_category';
    protected $primaryKey='product_id';
    public $timestamps=false;

    public function hasManyOrders()
    {
        return $this->hasMany(OrderProduct::class,'product_id','product_id')->select('order_product_id','order_id','product_id');
    }
    public function hasManyProduct()
    {
        return $this->hasMany(Product::class,'product_id','product_id');
    }

    public function hasOneCategoryDetails()
    {
        return $this->hasOne(CategoryDetail::class,'category_id','category_id');
    }

    public function hasOneProduct()
    {
        return $this->hasOne(Product::class,'product_id','product_id');
    }

    public function hasOneDescription()
    {
        return $this->hasOne(ProductDescription::class,'product_id','product_id');
    }

    public function hasOneToppingProductPriceSize()
    {
        return $this->hasOne(ToppingProductPriceSize::class,'id_product','product_id');
    }

    public function hasOneToppingSize()
    {
        return $this->hasOne(ToppingSize::class,'id_category','category_id');
    }
}
