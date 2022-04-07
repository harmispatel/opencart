<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'oc_currency';
    protected $primaryKey = "currency_id";
    public $timestamps = false;
}
