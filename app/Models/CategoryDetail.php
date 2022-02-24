<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    use HasFactory;
    protected $table = 'oc_category';
    protected $primaryKey = "category_id";
    public $timestamps = false;
}
