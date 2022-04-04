<?php

namespace App\Models;
use App\Models\Store;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'customer_order';

    public function hasOneStore()
    {
        return $this->hasOne(Store::class,'store_id','store_id');
    }
    
    public function hasOneOrder()
    {
        return $this->hasOne(Orders::class,'store_id','store_id');
    }
}
