<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterGroup extends Model
{
    use HasFactory;
    protected $table='oc_filter_group';
    protected $primaryKey='filter_group_id';
}
