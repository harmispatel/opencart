<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\CategorytoStore;

class CategoryDetail extends Model
{
    use HasFactory;
    protected $table = 'oc_category';
    protected $primaryKey = "category_id";
    public $timestamps = false;

    public function hasOneCategory()
    {
        return $this->hasOne(Category::class,'category_id','category_id');
    }

    public function hasManyCategoryStore()
    {
        return $this->hasMany(CategorytoStore::class,'category_id','category_id');
    }

}
