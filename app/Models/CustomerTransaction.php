<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    public $table = "oc_customer_transaction";
    protected $primaryKey = 'customer_transaction_id';
    public $timestamps = false;
}
