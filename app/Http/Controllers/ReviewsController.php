<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;

class ReviewsController extends Controller
{
    public function reviews(){

         return view('admin.Reviews.review');
    }
}
