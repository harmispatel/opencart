<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table='oc_option';
    protected $primaryKey = 'option_id';
    public $timestamps = false;
}
