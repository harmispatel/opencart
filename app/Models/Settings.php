<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table='oc_setting';
    protected $primaryKey = 'setting_id';
    public $timestamps = false;
}
