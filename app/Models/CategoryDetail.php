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

    // Has One Relation with "oc_category_description" table
    public function hasOneCategory()
    {
        return $this->hasOne(Category::class,'category_id','category_id');
    }

    // Has Many Relation with "oc_category_to_store" table
    public function hasManyCategoryStore()
    {
        return $this->hasMany(CategorytoStore::class,'category_id','category_id');
    }

}
