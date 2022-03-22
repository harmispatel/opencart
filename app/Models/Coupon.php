<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'oc_coupon';
    protected $primaryKey = "coupon_id";
    public $timestamps = false;
}
