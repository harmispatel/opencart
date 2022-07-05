<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingSize extends Model
{
    use HasFactory;
    protected $table='oc_topping_size';
    protected $primaryKey = 'id_size';
    public $timestamps=false;
}
