<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationStore extends Model
{
    use HasFactory;
    protected $table='oc_information_to_store';
    protected $primaryKey = 'information_id';
    public $timestamps = false;
}
