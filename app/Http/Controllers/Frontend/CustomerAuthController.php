<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CustomerAuthController extends Controller
{
    public function customerlogin(Request $request)
    {
        $request->validate([
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

        $ajaxregister = isset($request->ajaxregister) ? $request->ajaxregister : 0;

        $address_check = isset($request->address_required) ? $request->address_required : 0;

        if($address_check != 1 || $ajaxregister == 1)
        {
            // Validation
            $request->validate([
                'title' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:oc_customer,email',
                'phone' => 'required|min:10',
                'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
                'confirmpassword' => 'min:6|required_with:password|same:password',
            ]);
        }
        else
        {
            // $request->validate([
            //     'title' => 'required',
            //     'name' => 'required',
            //     'lastname' => 'required',
            //     'email' => 'required|email|unique:oc_customer,email',
            //     'phone' => 'required|min:10',
            //     'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
            //     'confirmpassword' => 'min:6|required_with:password|same:password',
            //     'address_1' => 'required',
            //     'city' => 'required',
            //     'postcode' => 'required',
            //     'country' => 'required',
            //     'state' => 'required',
            // ]);
        }

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
        if($address_check == 1)
        {
            $customeraddress = new CustomerAddress;
            $customeraddress->customer_id = $lastInsertedID;
            $customeraddress->firstname = isset($request->name) ? $request->name : '';
            $customeraddress->lastname = isset($request->lastname) ? $request->lastname : '';
            $customeraddress->company = isset($request->company) ? $request->company : '';
            $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
            $customeraddress->address_1 = isset($request->address_1) ? $request->address_1 : '';
            $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
            $customeraddress->city = isset($request->city) ? $request->city : '';
            $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '';
            $customeraddress->country_id = isset($request->country) ? $request->country : '';
            $customeraddress->zone_id = isset($request->state) ? $request->state : '';
            $customeraddress->save();
        }

        $edit_cust = Customer::find($lastInsertedID);
        $edit_cust->address_id = $customeraddress->address_id;
        $edit_cust->update();

        session()->put('username', $customer->firstname);
        session()->put('userid',$lastInsertedID);

        if(session()->has('userid'))
        {
            if(session()->has('cart1'))
            {
                $cart = session()->get('cart1');
                $serial = serialize($cart);
                $base64 = base64_encode($serial);
                $user_id = session()->get('userid');
                $user = Customer::find($user_id);
                $user->cart = $base64;
                $user->update();

                session()->forget('cart1');
            }
        }

        if ($ajaxregister == 1)
        {
            return response()->json([
                'status' => 1,
            ]);
        }
        else
        {
            return redirect()->route('member');
        }

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
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        // Validation
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required|min:10',
        ]);

        $email = $request->email;

        $check_unique = Customer::where('customer_id','!=',$customerid)->where('email',$email)->first();

        if(!empty($check_unique) || $check_unique != '')
        {
            $request->validate([
                'email' => 'required|email|unique:oc_customer,email',
            ]);
        }

        if(!empty($request->password) && !empty($request->confirmpassword))
        {
            $request->validate([
                'password' => 'min:6|required_with:confirmpassword|same:confirmpassword',
                'confirmpassword' => 'min:6|required_with:password|same:password',
            ]);
        }


        $customer = Customer::find($customerid);
        $customer->firstname = isset($request->name) ? $request->name : '';
        $customer->lastname = isset($request->lastname) ? $request->lastname : '';
        $customer->email = isset($request->email) ? $request->email : '';
        $customer->telephone = isset($request->phone) ? $request->phone : '';
        $customer->password = md5($request->password);
        $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : 1;
        $customer->ip =  $_SERVER['REMOTE_ADDR'];
        $customer->gender_id = isset($request->title) ? $request->title : 1;
        $customer->update();

        return redirect()->route('member');

    }
}
