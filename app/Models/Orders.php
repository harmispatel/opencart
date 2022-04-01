<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Models\Store;
use App\Models\CustomerGroupDescription;
use App\Models\Country;
use App\Models\Region;

class Orders extends Model
{
    protected $table = "oc_order";
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    public function hasOneOrderStatus()
    {
        return $this->hasOne(OrderStatus::class,'order_status_id','order_status_id');
    }

    public function hasOneStore()
    {
        return $this->hasOne(Store::class,'store_id','store_id');
    }

    public function hasOneCustomerGroupDescription()
    {
        return $this->hasOne(CustomerGroupDescription::class,'customer_group_id','customer_group_id');
    }

    public function hasOneCountry()
    {
        return $this->hasOne(Country::class,'country_id','payment_country_id');
    }

    public function hasOneRegion()
    {
        return $this->hasOne(Region::class,'zone_id','payment_zone_id');
    }

}
