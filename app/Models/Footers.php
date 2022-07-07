<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footers extends Model
{
    public $table = "oc_footers";
    protected $primaryKey = 'footer_id';
}
