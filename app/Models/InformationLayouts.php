<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationLayouts extends Model
{
    use HasFactory;
    protected $table='oc_information_to_layout';
    protected $primaryKey = 'information_id';
    public $timestamps = false;
}
