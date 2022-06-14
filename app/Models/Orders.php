<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Models\Store;
use App\Models\CustomerGroupDescription;
use App\Models\Country;
use App\Models\Region;
use App\Models\OrderProduct;

class Orders extends Model
{
    protected $connection = 'mysql';
    protected $table = "oc_order";
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    // Has One Relation with "oc_order_status" table
    public function hasOneOrderStatus()
    {
        return $this->hasOne(OrderStatus::class,'order_status_id','order_status_id');
    }

    // Has One Relation with "oc_store" table
    public function hasOneStore()
    {
        return $this->hasOne(Store::class,'store_id','store_id');
    }

    // Has One Relation with "oc_customer_group_description" table
    public function hasOneCustomerGroupDescription()
    {
        return $this->hasOne(CustomerGroupDescription::class,'customer_group_id','customer_group_id');
    }

    // Has One Relation with "oc_country" table
    public function hasOneCountry()
    {
        return $this->hasOne(Country::class,'country_id','payment_country_id');
    }

    // Has One Relation with "oc_zone" table
    public function hasOneRegion()
    {
        return $this->hasOne(Region::class,'zone_id','payment_zone_id');
    }

    // Has Many Relation with "oc_order_product" table
    public function hasManyOrderProduct()
    {
        return $this->hasMany(OrderProduct::class,'order_id','order_id');
    }

    // Has Many Relation with "oc_order_total" table
    public function hasManyOrderTotal()
    {
        return $this->hasMany(OrderTotal::class,'order_id','order_id');
    }

}
