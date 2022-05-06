<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCart extends Model
{
    use HasFactory;
    protected $table = "oc_order_cart";
    protected $primaryKey = 'order_cart_id';
    public $timestamps = false;
}
