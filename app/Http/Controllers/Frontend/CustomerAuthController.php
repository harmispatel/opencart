<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function customerlogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $ajaxlogin = $request->ajaxlogin;
        $email = $request->email;
        $pass = $request->password;
        $emailexist = Customer::where('email', '=', $email)->exists();
        $customername = Customer::select('customer_id','firstname','password')->where('email', '=', $email)->first();

         if ($emailexist && md5($pass) == $customername->password) {
                session()->put('username', $customername->firstname);
                session()->put('userid', $customername->customer_id);
            if ($ajaxlogin == 1) {
                return response()->json([
                    'status' => 1,
                ]);
            }
            else{
                return redirect()->back();
            }
         }
         else{
             if ($ajaxlogin == 1) {
                 return response()->json([
                     'status' => 0,
                 ]);
             }
             else {
                return redirect()->back();
             }
         }


    }

    public function customerregister(Request $request)
    {
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        // Validation
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:oc_customer,email',
            'phone' => 'required|min:10',
            'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
            'confirmpassword' => 'min:6|required_with:password|same:password',
            // 'address_1' => 'required',
            // 'city' => 'required',
            // 'postcode' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
        ]);

        $ajaxregister = $request->ajaxregister;
        $customer = new Customer;
        $customer->store_id = $front_store_id;
        $customer->firstname = isset($request->name) ? $request->name : '';
        $customer->lastname = isset($request->lastname) ? $request->lastname : '';
        $customer->email = isset($request->email) ? $request->email : '';
        $customer->telephone = isset($request->phone) ? $request->phone : '';
        $customer->fax = isset($request->fax) ? $request->fax : '';
        $customer->password = md5($request->password);
        $customer->salt = genratetoken(9);
        $customer->cart = isset($request->cart) ? $request->cart : '';
        $customer->wishlist = isset($request->wishlist) ? $request->wishlist : '';
        $customer->newsletter = isset($request->newsletter) ? $request->newsletter : 0;
        $customer->address_id = isset($request->address_id) ? $request->address_id : 0;
        $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : '';
        $customer->ip =  $_SERVER['REMOTE_ADDR'];
        $customer->status = isset($request->status) ? $request->status : 1;
        $customer->approved = isset($request->approved) ? $request->approved : 1;
        $customer->token = isset($request->token) ? $request->token : '';
        $customer->date_added = date('Y-m-d');
        $customer->gender_id = isset($request->gender_id) ? $request->gender_id : 1;
        $customer->save();

        // Last inserted id
        $lastInsertedID = $customer->customer_id;

        // Customer Address
        $customeraddress = new CustomerAddress;
        $customeraddress->customer_id = $lastInsertedID;
        $customeraddress->company = isset($request->company) ? $request->company : '';
        $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
        $customeraddress->address_1 = isset($request->address_1) ? $request->address_1 : '';
        $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
        $customeraddress->city = isset($request->city) ? $request->city : '';
        $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '';
        $customeraddress->country_id = isset($request->country) ? $request->country : '';
        $customeraddress->zone_id = isset($request->state) ? $request->state : '';
        $customer->save();
        // echo '<pre>';
        // print_r($customeraddress->toArray());
        // exit();





        session()->put('username', $customer->firstname);
        session()->put('userid',$lastInsertedID);

        if ($ajaxregister == 1) {
            return response()->json([
                'status' => 1,
            ]);
        }
        else{
            return redirect()->back();
        }
        return back();


    }

    public function customerlogout()
    {
        session()->flush();
        return redirect()->route('home');
    }

    public function customerdetailupdate(Request $request)
    {
        $customerid = session('userid');
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        // $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        // Validation
        // $request->validate([
        //     'title' => 'required',
        //     'name' => 'required',
        //     'lastname' => 'required',
        //     'email' => 'required|email|unique:oc_customer,email',
        //     'phone' => 'required|min:10',
        //     'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
        //     'confirmpassword' => 'min:6|required_with:password|same:password',
        //     // 'address_1' => 'required',
        //     // 'city' => 'required',
        //     // 'postcode' => 'required',
        //     // 'country' => 'required',
        //     // 'state' => 'required',
        // ]);

        $customer = Customer::find($customerid);
        $customer->store_id = $front_store_id;
        $customer->firstname = isset($request->name) ? $request->name : '';
        $customer->lastname = isset($request->lastname) ? $request->lastname : '';
        $customer->email = isset($request->email) ? $request->email : '';
        $customer->telephone = isset($request->phone) ? $request->phone : '';
        $customer->fax = isset($request->fax) ? $request->fax : '';
        $customer->password = md5($request->password);
        $customer->salt = genratetoken(9);
        $customer->cart = isset($request->cart) ? $request->cart : '';
        $customer->wishlist = isset($request->wishlist) ? $request->wishlist : '';
        $customer->newsletter = isset($request->newsletter) ? $request->newsletter : 0;
        $customer->address_id = isset($request->address_id) ? $request->address_id : 0;
        $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : '';
        $customer->ip =  $_SERVER['REMOTE_ADDR'];
        $customer->status = isset($request->status) ? $request->status : 1;
        $customer->approved = isset($request->approved) ? $request->approved : 1;
        $customer->token = isset($request->token) ? $request->token : '';
        $customer->date_added = date('Y-m-d');
        $customer->gender_id = isset($request->gender_id) ? $request->gender_id : 1;
        $customer->update();
        // echo '<pre>';
        // print_r($customer->toArray());

        // $lastinsertid = $customer->id;
        // // Customer Address
        // $customeraddress = CustomerAddress::find($customerid);
        // $customeraddress->customer_id = $lastinsertid;
        // $customeraddress->company = isset($request->company) ? $request->company : '';
        // $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
        // $customeraddress->address_1 = isset($request->address_1) ? $request->address_1 : '';
        // $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
        // $customeraddress->city = isset($request->city) ? $request->city : '';
        // $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '';
        // $customeraddress->country_id = isset($request->country) ? $request->country : '';
        // $customeraddress->zone_id = isset($request->state) ? $request->state : '';
        // $customer->update();
        // echo '<pre>';
        // print_r($customeraddress->toArray());
        // exit();
        return back();

    }
}
