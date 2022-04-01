<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;

class OrderHistory extends Model
{
    protected $table = "oc_order_history";
    public $timestamps = false;
    protected $fillable = ['order_id', 'notify', 'comment', 'date_added'];

    public function oneOrderHistoryStatus()
    {
        return $this->hasOne(OrderStatus::class,'order_status_id','order_status_id');
    }

}
