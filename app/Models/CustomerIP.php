<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerIP extends Model
{
    public $table = "oc_customer_ip";
    protected $primaryKey = 'customer_ip_id';
    public $timestamps = false;
}
