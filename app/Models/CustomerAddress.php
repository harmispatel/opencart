<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Country;

class CustomerAddress extends Model
{
    public $table = "oc_address";
    protected $primaryKey = 'address_id';
    public $timestamps = false;

    public function hasOneRegion()
    {
        return $this->hasOne(Region::class,'zone_id','zone_id')->select('zone_id','name');
    }

    public function hasOneCountry()
    {
        return $this->hasOne(Country::class,'country_id','country_id')->select('country_id','name');
    }

}
