<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CustomerGroup;

class Customer extends Model
{
    public $table = "oc_customer";
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

}
