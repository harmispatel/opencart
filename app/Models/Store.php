<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $connection = 'mysql';
    public $table = "oc_store";
    protected $primaryKey = 'store_id';
    public $timestamps = false;
}
