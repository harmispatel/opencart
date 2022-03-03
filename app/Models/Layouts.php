<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layouts extends Model
{
    use HasFactory;
    protected $table='oc_layout';
    protected $primaryKey = 'layout_id';
    public $timestamps = false;
}
