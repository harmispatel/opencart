<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Cartcontroller extends Controller
{
    public function cart(Request $request){
        return view('frontend.pages.cart');
    }
}
