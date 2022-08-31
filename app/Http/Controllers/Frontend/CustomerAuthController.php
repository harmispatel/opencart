<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Product;
use App\Models\ToppingProductPriceSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CustomerAuthController extends Controller
{

    // Function For Customer Login
    public function customerlogin(Request $request)
    {
        $request->validate([
            'Email' => 'required|email|exists:oc_customer,email',
            'Password' => 'required',
        ]);

        $ajaxlogin = $request->ajaxlogin;

        $email = $request->Email;
        $pass = md5($request->Password);
        $emailexist = Customer::where('email', '=', $email)->exists();

        $customername = Customer::select('customer_id', 'firstname', 'password')->where('email', '=', $email)->first();

        if(empty($ajaxlogin))
        {
            if($pass != $customername->password)
            {
                return redirect()->route('member')->with('error',"No match for E-Mail Address and/or Password");
            }
        }

        if (($emailexist == 1) && ($pass == $customername->password)) {
            session()->put('username', $customername->firstname);
            session()->put('userid', $customername->customer_id);

              if (session()->has('userid'))
              {
                  if (session()->has('cart1'))
                  {
                      // If user is login then get usercart
                      $usercart = getuserCart(session()->get('userid'));
                      // Get cart from session
                      $session_array = session()->get('cart1');
                      if(isset($usercart['size'])){

                          foreach($session_array['size'] as $key=> $valus)
                          {
                              $size_id = $key;

                              if(isset($usercart['size'][$size_id]))
                              {
                                  $usercart['size'][$size_id]['quantity'] = $usercart['size'][$size_id]['quantity'] + $session_array['size'][$size_id]['quantity'];
                                  $usercart['size'][$size_id]['topping'] = isset($session_array['size'][$size_id]['topping']) ? $session_array['size'][$size_id]['topping'] : '';

                                  unset($session_array['size'][$size_id]);
                                  unset($session_array['size']['topping']);

                                  if(isset($session_array['size']))
                                  {
                                      if(count($session_array['size']) == 0)
                                      {
                                          unset($session_array['size']);
                                      }
                                  }


                                  // $NewArray= array_merge_recursive($usercart,$session_array);
                                  $serial = serialize($usercart);
                                  $base64 = base64_encode($serial);
                                  $user_id = session()->get('userid');
                                  $user = Customer::find($user_id);
                                  $user->cart = $base64;
                                  $user->update();
                              }
                              else
                              {
                                  array_push($usercart['size'],$session_array['size'][$size_id]);

                                  unset($session_array['size'][$size_id]);
                                  unset($session_array['size']['topping']);

                                  if(isset($session_array['size']))
                                  {
                                      if(count($session_array['size']) == 0)
                                      {
                                          unset($session_array['size']);
                                      }
                                  }
                                  $serial = serialize($usercart);
                                  $base64 = base64_encode($serial);
                                  $user_id = session()->get('userid');
                                  $user = Customer::find($user_id);
                                  $user->cart = $base64;
                                  $user->update();
                                }

                            }
                        }
                        else
                        {
                          $NewArray= array_merge_recursive($usercart,$session_array);
                          $serial = serialize($NewArray);
                          $base64 = base64_encode($serial);
                          $user_id = session()->get('userid');
                          $user = Customer::find($user_id);
                          $user->cart = $base64;
                          $user->update();

                      }


                  }
              }


            if ($ajaxlogin == 1) {
                return response()->json([
                    'status' => 1,
                ]);
            } else {
                return redirect()->back();
            }
        } else {
            if ($ajaxlogin == 1) {
                return response()->json([
                    'status' => 0,
                ]);
            } else {
                return redirect()->back();
            }
        }
    }




    // Function For Customer Registration
    public function customerregister(Request $request)
    {
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        $ajaxregister = isset($request->ajaxregister) ? $request->ajaxregister : 0;

        $address_check = isset($request->address_required) ? $request->address_required : 0;

        // if($address_check != 1 || $ajaxregister == 1)
        if ($ajaxregister == 1) {
            // Validation
            $request->validate([
                'title' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:oc_customer,email',
                'phone' => 'required|min:10',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6|required_with:password|same:password',
            ]);
        } elseif ($address_check == 1) {
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:oc_customer,email',
                'phone' => 'required|min:10',
                'address_1' => 'required',
                'city' => 'required',
                'country' => 'required',
                'region' => 'required',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6|required_with:password|same:password',
                'newsletter' => 'required',
            ]);
        } else {
            $request->validate([
                'title' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:oc_customer,email',
                'phone' => 'required|min:10',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6|required_with:password|same:password',
            ]);
        }

        $customer = new Customer;
        $customer->store_id = $front_store_id;
        $customer->firstname = isset($request->firstname) ? $request->firstname : '';
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
        $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : 1;
        $customer->ip =  $request->ip();
        $customer->status = isset($request->status) ? $request->status : 1;
        $customer->approved = isset($request->approved) ? $request->approved : 1;
        $customer->token = isset($request->token) ? $request->token : '';
        $customer->date_added = date('Y-m-d');
        $customer->gender_id = isset($request->title) ? $request->title : 1;
        $customer->save();


        // Last inserted id
        $lastInsertedID = $customer->customer_id;



        session()->put('username', $customer->firstname);
        session()->put('userid', $lastInsertedID);

        // Customer Address
        if ($address_check == 1) {
            $customeraddress = new CustomerAddress;
            $customeraddress->customer_id = $lastInsertedID;
            $customeraddress->firstname = isset($request->firstname) ? $request->firstname : '';
            $customeraddress->lastname = isset($request->lastname) ? $request->lastname : '';
            $customeraddress->company = isset($request->company) ? $request->company : '';
            $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
            $customeraddress->address_1 = isset($request->address_1) ? $request->address_1 : '';
            $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
            $customeraddress->city = isset($request->city) ? $request->city : '';
            $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '';
            $customeraddress->country_id = isset($request->country) ? $request->country : '';
            $customeraddress->zone_id = isset($request->region) ? $request->region : '';
            $customeraddress->save();

            $edit_cust = Customer::find($lastInsertedID);
            $edit_cust->address_id = $customeraddress->address_id;
            $edit_cust->update();
        }


        if (session()->has('userid')) {
            if (session()->has('cart1')) {
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

        if ($ajaxregister == 1) {
            return response()->json([
                'status' => 1,
            ]);
        } else {
            return redirect()->route('member');
        }
    }




    // Function For Customer logOut
    public function customerlogout()
    {
        session()->flush();
        return redirect()->route('home');
    }




    //  Function For Customer Detail Update
    public function customerdetailupdate(Request $request)
    {
        $customerid = session('userid');

       // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        // Validation
        $request->validate([
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required|min:10',

        ]);

        $email = $request->email;
        $check_unique = Customer::where('customer_id', '!=', $customerid)->where('email', $email)->first();

        if (!empty($check_unique) || $check_unique != '') {
            $request->validate([
                'email' => 'required|email|unique:oc_customer,email',
            ]);
        }

        if (!empty($request->password) && !empty($request->confirm_password)) {
            $request->validate([
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6|required_with:password|same:password',
            ]);
        }


        $customer = Customer::find($customerid);
        $customer->firstname = isset($request->firstname) ? $request->firstname : '';
        $customer->lastname = isset($request->lastname) ? $request->lastname : '';
        $customer->email = isset($request->email) ? $request->email : '';
        $customer->telephone = isset($request->phone) ? $request->phone : '';
        $customer->password = md5($request->password);
        $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : 1;
        $customer->ip =  $request->ip();
        $customer->gender_id = isset($request->title) ? $request->title : 1;
        $customer->update();

        return redirect()->route('member');
    }





    // // Function For Registration Guest Users
    public function registerguestuser(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $data['title'] = isset($request->title) ? $request->title : 1;
        $data['fname'] = isset($request->firstname) ? $request->firstname : '';
        $data['lname'] = isset($request->lastname) ? $request->lastname : '';
        $data['email'] = isset($request->email) ? $request->email : '';
        $data['phone'] = isset($request->phone) ? $request->phone : '';

        session()->put('guest_user', $data);

        return response()->json([
            'success' => 1,
        ]);
    }

}
