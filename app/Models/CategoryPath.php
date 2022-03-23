<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPath extends Model
{
    protected $table = 'oc_category_path';
    protected $primaryKey = "path_id";
    public $timestamps = false;
}
