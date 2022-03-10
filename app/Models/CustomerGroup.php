<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class CustomerGroup extends Model
{
    public $table = "oc_customer_group";
    protected $primaryKey = 'customer_group_id';
    public $timestamps = false;

    // function customer()
    // {
    //     return $this->belongsToMany(Customer::class);
    // }

}
