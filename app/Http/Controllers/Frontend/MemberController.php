<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function member()
    {

        $userlogin = session('userid');

        if (!empty($userlogin)) {
            $customers = Customer::where('customer_id',$userlogin)->first();
            $customeraddress = CustomerAddress::where('customer_id',$userlogin)->get();
            return view('frontend.pages.member',compact('customers','customeraddress'));
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
        // Get All Countries
        $countries = Country::get();
        return view('frontend.pages.addnewaddress', compact('countries'));
    }
    public function newaddress(Request $request)
    {
        $userlogin = session('userid');
        if (!empty($userlogin)) {
            $customeraddress = new CustomerAddress;
            $customeraddress->customer_id = $userlogin;
            $customeraddress->firstname = $request->name;
            $customeraddress->lastname = $request->lastname;
            $customeraddress->company = isset($request->company) ? $request->company : '';
            $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
            $customeraddress->address_1 = $request->address_1;
            $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
            $customeraddress->city = $request->city;
            $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '0';
            $customeraddress->country_id = $request->country;
            $customeraddress->zone_id = $request->country_region_id;
            $customeraddress->phone = isset($request->phone) ? $request->phone : '0';
            $customeraddress->billing = isset($request->billing) ? $request->billing : '0';
            $customeraddress->save();

            return redirect()->route('member');
        }
        else {
            return redirect()->route('home');
        }
    }
    public function customeraddressdelete($id)
    {
        CustomerAddress::find($id)->delete();
        return redirect()->route('member');
    }

    public function customeraddressedit($id)
    {
        // Get All Countries
        $countries = Country::get();
        $customeraddress = CustomerAddress::where('address_id',$id)->first();
        return view('frontend.pages.editcustomeraddress', compact('countries','customeraddress'));
    }

    public function updatecustomeraddress(Request $request)
    {
        $addressid = $request->address_id;
        if (!empty($addressid)) {
            $customeraddress = CustomerAddress::find($addressid);
            $customeraddress->firstname = $request->name;
            $customeraddress->lastname = $request->lastname;
            $customeraddress->company = isset($request->company) ? $request->company : '';
            $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
            $customeraddress->address_1 = $request->address_1;
            $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
            $customeraddress->city = $request->city;
            $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '0';
            $customeraddress->country_id = $request->country;
            $customeraddress->zone_id = $request->country_region_id;
            $customeraddress->phone = isset($request->phone) ? $request->phone : '0';
            $customeraddress->billing = isset($request->billing) ? $request->billing : '0';
            $customeraddress->update();

            return redirect()->route('member');
        }
        else {
            return redirect()->route('home');
        }
    }
}
