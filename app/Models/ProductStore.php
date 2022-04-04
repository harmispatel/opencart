<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDescription;

class ProductStore extends Model
{
    protected $table='oc_product_to_store';
    protected $primaryKey='product_id';
    public $timestamps=false;

    public function hasOneProductDescription()
    {
        return $this->hasOne(ProductDescription::class,'product_id','product_id')->select(['product_id','name as pname']);
    }

}
