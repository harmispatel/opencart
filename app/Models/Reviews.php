<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerDescription;
use App\Models\Orders;

class Reviews extends Model
{
    use HasFactory;
    protected $table='oc_store_review';
    protected $primaryKey = 'store_review_id';
    public $timestamps = false;


    // Has One Relation with "oc_customer" table
    public function hasOneCustomer()
    {
        return $this->hasOne(Customer::class,'customer_id','customer_id')->select('customer_id','firstname','lastname');
    }

    // Has One Relation with "oc_order" table
    public function hasOneOrder()
    {
        return $this->hasOne(Orders::class,'order_id','order_id')->select('order_id','date_added');
    }

}
