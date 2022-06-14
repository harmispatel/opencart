<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DeliverySettingFeeds;

class DeliverySettings extends Model
{
    public $table = "oc_delivery_settings";
    protected $primaryKey = 'id_delivery_settings';
    public $timestamps = false;

    // Has Many Relation with "oc_delivery_feeds" table
    public function hasManyDeliveryFeeds()
    {
        return $this->hasMany(DeliverySettingFeeds::class,'id_delivery_settings','id_delivery_settings');
    }

}
