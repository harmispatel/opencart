<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    public $table = "oc_user_group";
    protected $primaryKey = 'user_group_id';
    public $timestamps=false;
}
