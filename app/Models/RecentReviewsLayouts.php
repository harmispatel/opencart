<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentReviewsLayouts extends Model
{
    public $table = "oc_review_layouts";
    protected $primaryKey = 'review_id';
}
