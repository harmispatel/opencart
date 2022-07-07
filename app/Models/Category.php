<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategorytoStore;

class Category extends Model
{
    use HasFactory;
    // protected $connection = 'mysql';
    protected $table = 'oc_category_description';
    protected $primaryKey = "category_id";
    public $timestamps = false;

    // Has One Relation with "oc_category_to_store" table
    public function hasOneCategoryToStore()
    {
        return $this->hasOne(CategorytoStore::class, 'category_id','category_id');
    }
}
