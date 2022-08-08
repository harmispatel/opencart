<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlBox extends Model
{
    use HasFactory;
    protected $table = 'oc_htmlbox';
    public $timestamps = false;

    public function hasoneaboutActive()
    {
        return $this->hasOne(AboutLayouts::class , 'about_id','about_layout_id');
    }
}
