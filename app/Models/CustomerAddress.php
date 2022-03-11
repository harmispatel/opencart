<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    public $table = "oc_address";
    protected $primaryKey = 'address_id';
    public $timestamps = false;
}
