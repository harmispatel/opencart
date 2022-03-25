<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryDetail;
use App\Models\Category;
class Product_to_category extends Model
{
   
    use HasFactory;
    protected $table = 'oc_product_to_category';
    protected $primaryKey='product_id';
    public $timestamps=false;
    public function hasOneCategory(){
        return $this->hasOne(Category::class,'category_id','category_id');
    }
    public function hasOneCategoryDetail(){
        return $this->hasOne(CategoryDetail::class,'category_id','category_id');
    }
}
