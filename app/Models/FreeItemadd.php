<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeItemadd extends Model
{
    use HasFactory;
    protected $table = 'oc_free_item';
    protected $fillable = ['name_item'];
    protected $primaryKey = 'id_free_item';

    public $timestamps = false;
}
