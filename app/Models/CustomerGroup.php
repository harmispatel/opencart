<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\CustomerGroupDescription;

class CustomerGroup extends Model
{
    public $table = "oc_customer_group";
    protected $primaryKey = 'customer_group_id';
    public $timestamps = false;

    // Has One Relation with "oc_customer_group_description" table
    public function hasOneCustomerGroupDescription()
    {
        return $this->hasOne(CustomerGroupDescription::class,'customer_group_id','customer_group_id');
    }

}
