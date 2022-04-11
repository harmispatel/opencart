<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySettingFeeds extends Model
{
    public $table = "oc_delivery_feeds";
    protected $primaryKey = 'id_delivery_feeds';
    public $timestamps = false;
}
