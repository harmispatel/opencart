<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $table = "oc_order_history";
    public $timestamps = false;
    protected $fillable = ['order_id', 'notify', 'comment', 'date_added'];
}