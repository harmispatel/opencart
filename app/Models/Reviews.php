<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $table='oc_store_review';
    protected $primaryKey = 'store_review_id';
    public $timestamps = false;
}
