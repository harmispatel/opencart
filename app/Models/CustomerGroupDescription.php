<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroupDescription extends Model
{
    public $table = "oc_customer_group_description";
    protected $primaryKey = 'customer_group_id';
    public $timestamps = false;
}
