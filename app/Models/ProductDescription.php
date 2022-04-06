<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Product_to_category;

class ProductDescription extends Model
{
    use HasFactory;
    protected $table = 'oc_product_description';
    public $timestamps=false;
    protected $primaryKey='product_id';

    public function hasOneProduct()
    {
        return $this->hasOne(Product::class, 'product_id','product_id');
    }

    public function hasOneProductToStore()
    {
        return $this->hasOne(ProductStore::class, 'product_id','product_id');
    }
    public function hasOnecategorytostore()
    {
        return $this->hasOne(Product_to_category::class, 'product_id','product_id');
    }
}
