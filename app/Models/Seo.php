<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    public $table = "oc_seo_url";
    protected $primaryKey = 'query';
    public $timestamps = false;
}
