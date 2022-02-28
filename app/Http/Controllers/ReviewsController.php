<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use App\Models\ProductDescription;


class ReviewsController extends Controller
{
    public function reviews()
    {
        // Check User Permission
        if(check_user_role(78) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }
         return view('admin.Reviews.review');
    }

    public function index(){
    
        $review =ProductDescription::all();
        return view('admin.Reviews.addReview',['review'=>$review]);
    }
}
