<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $table = "oc_slider";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
