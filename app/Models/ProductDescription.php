<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;
    protected $table = 'oc_product_description';
    public $timestamps=false;
    protected $primaryKey='product_id';

}
