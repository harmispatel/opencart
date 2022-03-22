<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionMapping extends Model
{
    protected $table = 'oc_product_options_mapping';
    protected $primaryKey = 'id';
    public $timestamps=false;
}
