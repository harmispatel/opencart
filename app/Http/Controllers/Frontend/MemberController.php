<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function member()
    {
        return view('frontend.pages.member');
    }
    public function memberregister()
    {
        return view('frontend.pages.register');
    }
}
