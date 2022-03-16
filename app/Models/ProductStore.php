<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
    use HasFactory;
    protected $table='oc_product_to_store';
    protected $primaryKey='product_id';

    public $timestamps=false;

}
