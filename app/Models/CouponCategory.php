<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    use HasFactory;
    protected $table = "oc_coupon_category";
    protected $primaryKey = "coupon_id";
    public $timestamps = false; 
}
