<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    public $table = "oc_themes";
    protected $primaryKey = 'theme_id';
}
