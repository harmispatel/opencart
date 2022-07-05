<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherThemenames extends Model
{
    use HasFactory;
    protected $table = "oc_voucher_theme_description";
    protected $primaryKey = 'voucher_theme_id';
    public $timestamps = false;
}