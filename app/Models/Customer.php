<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $table = "oc_customer";
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
}
