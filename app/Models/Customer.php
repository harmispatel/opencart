<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CustomerGroup;
use App\Models\CustomerGroupDescription;
use App\Models\Store;

class Customer extends Model
{
    protected $table = "oc_customer";
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    public function hasOneCustomerGroupDescription()
    {
        return $this->hasOne(CustomerGroupDescription::class,'customer_group_id','customer_group_id');
    }

    public function hasOneStore()
    {
        return $this->hasOne(Store::class,'store_id','store_id');
    }

}
