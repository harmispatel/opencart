<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductDescription;
use App\Models\ToppingSize;

class ProductOptionMapping extends Model
{
    protected $table = 'oc_product_options_mapping';
    protected $primaryKey = 'id';
    public $timestamps=false;

    public function hasOneCategoryDescription()
    {
        return $this->hasOne(Category::class,'category_id','category_id')->select(['category_id','name as cname']);
    }

    public function hasOneProductDescription()
    {
        return $this->hasOne(ProductDescription::class,'product_id','product_id')->select(['product_id','name as pname']);
    }

    public function hasOneToppingSize()
    {
        return $this->hasOne(ToppingSize::class,'id_size','size')->select('id_size','size as sizename');
    }

}
