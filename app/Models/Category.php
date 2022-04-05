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

    public function hasOneCategoryToStore()
    {
        return $this->hasOne(CategorytoStore::class, 'category_id','category_id');
    }
}
