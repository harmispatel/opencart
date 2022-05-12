<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Orders;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function member()
    {

        $userlogin = session('userid');

        if (!empty($userlogin)) {
            $customers = Customer::where('customer_id',$userlogin)->first();
            $customeraddress = CustomerAddress::with(['hasOneRegion','hasOneCountry'])->where('customer_id',$userlogin)->get();
            $customerorders = Orders::with(['hasManyOrderProduct','hasOneOrderStatus'])->where('customer_id',$userlogin)->get();
            // echo '<pre>';
            // print_r($customerorders->toArray());
            // exit();
            return view('frontend.pages.member',compact('customers','customeraddress','customerorders'));
        }
        else {
            return view('frontend.pages.member');
        }
    }
    public function memberregister()
    {
        $countries = Country::get();
        return view('frontend.pages.register',compact('countries'));
    }

    public function addnewaddress()
    {
        // Get All Countries
        $countries = Country::get();
        return view('frontend.pages.addnewaddress', compact('countries'));
    }

    public function changeDefAddress(Request $request)
    {
        $addressid = $request->address_id;
        $customerid = $request->customer_id;

        $edit_cust = Customer::find($customerid);
        $edit_cust->address_id = $addressid;
        $edit_cust->update();

        return response()->json([
            'success' => 1
        ]);

    }

    public function newaddress(Request $request)
    {
        $userlogin = session('userid');
        if (!empty($userlogin)) {
              // Validation
            $request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'address_1' => 'required',
                'city' => 'required',
                'country' => 'required',
                'country_region_id' => 'required',
            ]);
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
            $customeraddress->zone_id = isset($request->country_region_id) ? $request->country_region_id : '0';
            $customeraddress->phone = isset($request->phone) ? $request->phone : '0';
            $customeraddress->billing = isset($request->billing) ? $request->billing : '0';
            $customeraddress->save();

            if($request->default == 1)
            {
                $edit_cust = Customer::find($userlogin);
                $edit_cust->address_id = $customeraddress->address_id;
                $edit_cust->update();
            }

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
        $userlogin = session('userid');
        $addressid = $request->address_id;
        if (!empty($addressid))
        {
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

            if($request->defaultaddress == 1)
            {
                $edit_cust = Customer::find($userlogin);
                $edit_cust->address_id = $customeraddress->address_id;
                $edit_cust->update();
            }

            return redirect()->route('member');
        }
        else {
            return redirect()->route('home');
        }
    }

    public function getcustomerorderdetail(Request $request)
    {
        $cusromerOrderId = $request->customerorderid;
        // $customers = Customer::where('customer_id',$cusromerOrderId)->first();
        // $customeraddress = CustomerAddress::with(['hasOneRegion','hasOneCountry'])->where('customer_id',$cusromerOrderId)->get();
        $customerorders = Orders::with(['hasManyOrderProduct','hasOneOrderStatus'])->where('order_id',$cusromerOrderId)->get();

        return response()->json(['customerorders' => $customerorders]);
    }
}
