<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'oc_language';
    protected $primaryKey = "language_id";
    public $timestamps = false;
}
