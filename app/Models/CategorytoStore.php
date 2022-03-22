<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorytoStore extends Model
{
    protected $table = 'oc_category_to_store';
    protected $primaryKey = "category_id";
    public $timestamps = false;
}
