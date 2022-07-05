<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoGallry extends Model
{
    use HasFactory;
    protected $table ='oc_photo_gallery';
    public $timestamps = false;
}
