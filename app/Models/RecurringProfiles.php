<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringProfiles extends Model
{
    use HasFactory;
    protected $table='oc_recurring';
    protected $primaryKey='recurring_id';

}
