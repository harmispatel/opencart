<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBanIp extends Model
{
    public $table = "oc_customer_ban_ip";
    protected $primaryKey = 'customer_ban_ip_id';
    public $timestamps = false;
}
