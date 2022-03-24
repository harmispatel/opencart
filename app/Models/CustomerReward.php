<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReward extends Model
{
    public $table = "oc_customer_reward";
    protected $primaryKey = 'customer_reward_id';
    public $timestamps = false;
}
