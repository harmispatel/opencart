<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;

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
}
