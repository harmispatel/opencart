<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationDescription extends Model
{
    use HasFactory;
    protected $table='oc_information_description';
    protected $primaryKey = 'information_id';
    public $timestamps = false;
}
