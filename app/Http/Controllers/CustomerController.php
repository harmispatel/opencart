<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        // Get all Customers
        $data['customers'] = Customer::select('oc_customer.*','cgd.name as groupname')->leftJoin('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer.customer_group_id')->get();

        return view('admin.customers.list',$data);
    }


    public function add()
    {
        $data['customergroups'] = CustomerGroup::select('oc_customer_group.customer_group_id','cgd.name as gname')->join('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer_group.customer_group_id')->get();

        return view('admin.customers.add',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'password' => 'min:6|required_with:confirm|same:confirm',
            'confirm' => 'min:6|required_with:password|same:password',
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        //
    }


    public function delete(Request $request)
    {
        //
    }
}
