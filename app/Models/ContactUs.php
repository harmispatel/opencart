<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table ='oc_contact_us';
    protected $primaryKey = "contact_id";
    public $timestamps = false;

}
