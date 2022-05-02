<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CustomerAuthController extends Controller
{
    public function customerlogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $userlogin = new Customer;
        // $userlogin->


    }

    public function customerregister(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // exit();
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'min:6|required_with:confirm|same:confirm',
            'confirmpassword' => 'min:6|required_with:password|same:password',
        ]);


        // Store New Customer
        // $customer = new Customer;
        // $customer->store_id = $front_store_id;
        // $customer->firstname = isset($request->name) ? $request->name : '';
        // $customer->lastname = isset($request->surname) ? $request->surname : '';
        // $customer->email = isset($request->email) ? $request->email : '';
        // $customer->telephone = isset($request->phone) ? $request->phone : '';
        // $customer->fax = isset($request->fax) ? $request->fax : '';
        // $customer->password = isset($request->password) ? bcrypt($request->password) : '';
        // $customer->salt = genratetoken(9);
        // $customer->cart = isset($request->cart) ? $request->cart : '';
        // $customer->wishlist = isset($request->wishlist) ? $request->wishlist : '';
        // $customer->newsletter = isset($request->newsletter) ? $request->newsletter : 0;
        // $customer->address_id = isset($request->address_id) ? $request->address_id : 0;
        // $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : '';
        // $customer->ip =  $_SERVER['REMOTE_ADDR'];
        // $customer->status = isset($request->status) ? $request->status : 1;
        // $customer->approved = isset($request->approved) ? $request->approved : 1;
        // $customer->token = isset($request->token) ? $request->token : '';
        // $customer->date_added = date('Y-m-d');
        // $customer->gender_id = isset($request->gender_id) ? $request->gender_id : 1;
        // $customer->save();

        // $userlogin = new Customer;
        // $userlogin->store_id = $request->$front_store_id;
        // $userlogin->firstname = $request->name;
        // $userlogin->lastname = $request->surname;
        // $userlogin->email = $request->email;
        // $userlogin->telephone = $request->phone;
        // $userlogin->password = $request->phone;




    }
}
