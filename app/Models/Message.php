<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;

class Message extends Model
{
    use HasFactory;
    protected $table = 'oc_contact_us';

    public function hasOneStore()
    {
        return $this->hasOne(Store::class,'store_id','store_id');
    }
}
