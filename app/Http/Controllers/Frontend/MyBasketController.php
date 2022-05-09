<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyBasketController extends Controller
{
    public function success(Request $request){
        return view('frontend.pages.success');
    }
}
