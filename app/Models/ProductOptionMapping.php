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

     // Has One Relation with "oc_topping" table
    function hasOneTopping()
    {
        return $this->hasOne(Topping::class,'id_topping','topping_id');
    }

    // Has One Relation with "oc_topping_option" table
    public function hasManySubTopping()
    {
        return $this->hasMany(ToppingOption::class,'id_group_topping','topping_id');
    }

    // Has One Relation with "oc_category_description" table
    public function hasOneCategoryDescription()
    {
        return $this->hasOne(Category::class,'category_id','category_id')->select(['category_id','name as cname']);
    }

    // Has One Relation with "oc_product_description" table
    public function hasOneProductDescription()
    {
        return $this->hasOne(ProductDescription::class,'product_id','product_id')->select(['product_id','name as pname']);
    }

    // Has One Relation with "oc_topping_size" table
    public function hasOneToppingSize()
    {
        return $this->hasOne(ToppingSize::class,'id_size','size')->select('id_size','size as sizename');
    }

}
