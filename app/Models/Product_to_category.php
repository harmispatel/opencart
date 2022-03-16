<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_to_category extends Model
{
   
    use HasFactory;
    protected $table = 'oc_product_to_category';
    protected $primaryKey='product_id';
    public $timestamps=false;

}
