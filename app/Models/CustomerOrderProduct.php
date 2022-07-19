<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderProduct extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'customer_order_product';
    public $timestamps = false;
}
