<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    
    use HasFactory;
    protected $table = 'oc_product_reward';
    protected $primaryKey='product_id';
    public $timestamps=false;
}
