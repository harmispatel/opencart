<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ToppingSize;

class CategorytoStore extends Model
{
    protected $table = 'oc_category_to_store';
    protected $primaryKey = "category_id";
    public $timestamps = false;

    // Has One Relation with "oc_category_to_store" table
    public function hasOneCategoryDescription()
    {
        return $this->hasOne(Category::class,'category_id','category_id')->select(['category_id','name as cname']);
    }

    // Has Many Relation with "oc_topping_size" table
    public function hasManyToppingSize()
    {
        return $this->hasMany(ToppingSize::class,'id_category','category_id');
    }

}
