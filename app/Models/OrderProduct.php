<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Product_to_category;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = "oc_order_product";
    protected $primaryKey = 'order_product_id';
    public $timestamps = false;

    public function hasOrder()
    {
        return $this->hasOne(Orders::class,'order_id','order_id')->select('order_id','store_id');
    }

    public function hasOneProduct()
    {
        return $this->hasOne(Product::class,'product_id','product_id')->select('product_id','image');
    }

    // public function hasOneCategorytoProduct()
    // {
    //     return $this->hasOne(Product_to_category::class,'product_id','product_id');
    // }

}
