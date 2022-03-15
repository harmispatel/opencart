<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Country;
use App\Models\Region;
use App\Models\CustomerAddress;
use App\Models\CustomerIP;
use Illuminate\Http\Request;
use DataTables;

class CustomerController extends Controller
{

    public function index()
    {
        // Get all Customers
        // $data['customers'] = Customer::select('oc_customer.*','cgd.name as groupname')->leftJoin('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer.customer_group_id')->get();

        return view('admin.customers.list');
    }


    function getcustomers(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select('*','cgd.name as customer_group','oc_store.name as shop')->leftJoin('oc_customer_group as cg','cg.customer_group_id','=','oc_customer.customer_group_id')->leftJoin('oc_customer_group_description as cgd','cgd.customer_group_id','=','cg.customer_group_id')->leftJoin('oc_store','oc_store.store_id','=','oc_customer.store_id');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $edit_url = route('editcustomer',$row->customer_id);
                $btn = '<div class="btn-group"><a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a><button type="button" data-toggle="dropdown" class="btn btn-sm btn-primary dropdown-toggle" aria-expanded="false" style="border-left:1px solid white"><span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right"><li class="dropdown-header">Login into Store</li><li class="text-center"><a href="" target="_blank"><i class="fa fa-lock"></i> Your Store</a></li></ul></div>';

                return $btn;
            })
            ->addColumn('date_added', function($row){
                $cust_date = date('d-m-Y',strtotime($row->date_added));
                return $cust_date;
            })
            ->addColumn('status', function($row){
                $status = '';
                if($row->status == 1)
                {
                    $status = 'Enabled';
                }
                else
                {
                    $status = 'Disabled';
                }
                return $status;
            })
            ->addColumn('approved', function($row){
                $approved = '';
                if($row->approved == 1)
                {
                    $approved = 'Yes';
                }
                else
                {
                    $approved = 'No';
                }
                return $approved;
            })
            ->addColumn('shop', function($row){
                $approved = '';
                if(!empty($row->shop))
                {
                    $shop = $row->shop;
                }
                else
                {
                    $shop = '---';
                }
                return $shop;
            })
            ->addColumn('customer_name', function($row){
                $cname = $row->firstname.' '.$row->lastname;
                return $cname;
            })
            ->addColumn('checkbox', function($row){
                $cid = $row->customer_id;
                $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$cid.'">';
                return $checkbox;
            })
            ->rawColumns(['action','date_added','status','approved','shop','customer_name','checkbox'])
            ->make(true);
        }

        return view('admin.customers.list');


    }


    public function add()
    {
        $data['customergroups'] = CustomerGroup::select('oc_customer_group.customer_group_id','cgd.name as gname')->join('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer_group.customer_group_id')->get();

        // Country
        $data['countries'] = Country::get();

        return view('admin.customers.add',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:oc_customer,email',
            'phone' => 'required|min:10',
            'password' => 'min:6|required_with:confirm|same:confirm',
            'confirm' => 'min:6|required_with:password|same:password',
        ]);

        $customer = new Customer;
        $customer->store_id = isset($request->store_id) ? $request->store_id : 0;
        $customer->firstname = isset($request->firstname) ? $request->firstname : '';
        $customer->lastname = isset($request->lastname) ? $request->lastname : '';
        $customer->email = isset($request->email) ? $request->email : '';
        $customer->telephone = isset($request->phone) ? $request->phone : '';
        $customer->fax = isset($request->fax) ? $request->fax : '';
        $customer->password = isset($request->password) ? bcrypt($request->password) : '';
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



        // Customer IP
        $customer_ip = new CustomerIP;
        $customer_ip->customer_id = $customer->customer_id;
        $customer_ip->ip = $_SERVER['REMOTE_ADDR'];
        $customer_ip->date_added = date('Y-m-d');
        $customer_ip->save();


        $address = $request->address;

        if(!empty($address))
        {
            foreach($address as  $val)
            {

                $fname = $val['fname'];
                $lname = $val['lname'];
                $company = $val['company'];
                $companyId = $val['companyId'];
                $taxid = $val['taxid'];
                $add_1 = $val['add_1'];
                $add_2 = $val['add_2'];
                $city = $val['city'];
                $postcode = $val['postcode'];
                $country_id = $val['country_id'];
                $region_id = $val['region_id'];
                $default = isset($val['default']) ? $val['default'] : '';

                if(!empty($fname) && !empty($lname))
                {
                    $cust_address = new CustomerAddress;
                    $cust_address->customer_id = $customer->customer_id;
                    $cust_address->firstname = isset($fname) ? $fname : '';
                    $cust_address->lastname = isset($lname) ? $lname : '';
                    $cust_address->company = isset($company) ? $company : '';
                    $cust_address->company_id = isset($companyId) ? $companyId : '';
                    $cust_address->tax_id = isset($taxid) ? $taxid : '';
                    $cust_address->address_1 = isset($add_1) ? $add_1 : '';
                    $cust_address->address_2 = isset($add_2) ? $add_2 : '';
                    $cust_address->city = isset($city) ? $city : '';
                    $cust_address->postcode = isset($postcode) ? $postcode : 0;
                    $cust_address->country_id = isset($country_id) ? $country_id : 0;
                    $cust_address->zone_id = isset($region_id) ? $region_id : 0;
                    $cust_address->phone = isset($request->phone) ? $request->phone : '';
                    $cust_address->billing = isset($request->billing) ? $request->billing : 0;
                    $cust_address->card_name = isset($request->cardname) ? $request->cardname : '';
                    $cust_address->save();

                    if(($default != '') || (!empty($default)))
                    {
                        $cust_update = Customer::find($customer->customer_id);
                        $cust_update->address_id = $cust_address->address_id;
                        $cust_update->update();
                    }

                }

            }
        }

        return response()->json('success');


    }


    public function edit($id)
    {
        $data['customergroups'] = CustomerGroup::select('oc_customer_group.*','cgd.name as gname')->join('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer_group.customer_group_id')->get();
        $data['countries'] = Country::get();
        $data['customer'] = Customer::find($id);
        return view('admin.customers.edit',$data);
    }


    public function update(Request $request)
    {
        //
    }


    public function delete(Request $request)
    {
        $ids = $request['id'];

        if(count($ids) > 0)
        {
            // Delete Customer
            Customer::whereIn('customer_id',$ids)->delete();

            // Delete Customer IP
            CustomerIP::whereIn('customer_id',$ids)->delete();

            // Delete Customer Addresses
            foreach($ids as $id)
            {
                CustomerAddress::where('customer_id',$id)->delete();
            }

            return response()->json([
                'success' => 1,
            ]);
        }
    }


    function getRegionbyCountry(Request $request)
    {
        $country_id = $request->country_id;

       if(!empty($country_id))
       {
            $regions = Region::where('country_id',$country_id)->get();

            $html = "";

            if(count($regions) > 0)
            {
                $html .= '<option value=""> --- Please Select Region --- </option>';
                foreach($regions as $region)
                {
                    $html .= '<option value="'.$region->zone_id.'">'.$region->name.'</option>';
                }
                return response()->json($html);
            }
            else
            {
                $html .= '<option value=""> --- Please Select Region --- </option>';
                $html .= '<option value="0"> --- None --- </option>';
                return response()->json($html);
            }
       }
       else
       {
            $html = '';
            $html .= '<option value=""> --- Please Select Region --- </option>';
            $html .= '<option value="0"> --- None --- </option>';
            return response()->json($html);

       }



    }


}
