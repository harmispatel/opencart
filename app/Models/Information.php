<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $table='oc_information';
    protected $primaryKey = 'information_id';
    public $timestamps = false;
}
