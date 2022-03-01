<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringDescription extends Model
{
    use HasFactory;
    protected $table ='oc_recurring_description';
    protected $prinarykey='recurring_id';
}
