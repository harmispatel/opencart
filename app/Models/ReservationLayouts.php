<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationLayouts extends Model
{
    public $table = "oc_reservation_layouts";
    protected $primaryKey = 'reservation_id';
}
