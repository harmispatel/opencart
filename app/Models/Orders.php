<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Models\Store;

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

}
