<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    use HasFactory;
    protected $table = 'oc_coupon_history';
    public $timestamps = false;
    // protected $primaryKey = "coupon_id";


    public function hasOnecustomersorder()
    {
        return $this->hasOne(Orders::class,'order_id','order_id')->select('order_id','firstname', 'lastname');
    }

}
