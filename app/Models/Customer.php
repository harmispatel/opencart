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
    // protected $fillable = ['store_id'];
    protected $table = "oc_customer";
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    // Has One Relation with "oc_customer_group_description" table
    public function hasOneCustomerGroupDescription()
    {
        return $this->hasOne(CustomerGroupDescription::class,'customer_group_id','customer_group_id');
    }

    // Has One Relation with "oc_store" table
    public function hasOneStore()
    {
        return $this->hasOne(Store::class,'store_id','store_id');
    }

}
