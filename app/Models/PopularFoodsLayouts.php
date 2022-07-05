<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularFoodsLayouts extends Model
{
    public $table = "oc_popular_food_layouts";
    protected $primaryKey = 'popular_food_id';
}
