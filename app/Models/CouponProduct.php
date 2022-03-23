<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    use HasFactory;
    protected $table = "oc_coupon_product";
    protected $primaryKey = "coupon_id";
    public $timestamps = false; 
}
