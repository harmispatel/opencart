<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    
    use HasFactory;
    protected $table = 'oc_product_reward';
    public $timestamps=false;
}
