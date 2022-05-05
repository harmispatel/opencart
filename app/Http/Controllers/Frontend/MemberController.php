<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function member()
    {

        $userlogin = session('userid');

        if (!empty($userlogin)) {
            $customers = Customer::where('customer_id',$userlogin)->first();
            // echo '<pre>';
            // print_r($customers->toArray());
            // exit();
            // die;
            return view('frontend.pages.member',compact('customers'));
        }
        else {
            return view('frontend.pages.member');
        }
    }
    public function memberregister()
    {
        return view('frontend.pages.register');
    }

    public function addnewaddress()
    {
        return view('frontend.pages.addnewaddress');
    }
}
