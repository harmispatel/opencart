<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterGroupDescription extends Model
{
    use HasFactory;
    protected $table='oc_filter_group_description';
    protected $primaryKey ='filter_group_id';
}
