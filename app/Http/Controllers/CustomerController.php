<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Country;
use App\Models\Region;
use App\Models\CustomerAddress;
use App\Models\CustomerBanIp;
use App\Models\CustomerHistory;
use App\Models\CustomerIP;
use App\Models\CustomerReward;
use App\Models\CustomerTransaction;
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


    function getcustomerhistory(Request $request)
    {
        $customer_id = $request->cust_id;

        $cust_history = CustomerHistory::where('customer_id',$customer_id)->get();

        $html = '';

        if(count($cust_history) > 0)
        {
            foreach($cust_history as $history)
            {
                $html .= '<tr>';
                $html .= '<td>'.$history['date_added'].'</td>';
                $html .= '<td>'.$history['comment'].'</td>';
                $html .= '</tr>';
            }
            return response()->json($html);
        }
        else
        {
            $html .= '<tr>';
            $html .= '<td colspan="2" class="text-center">History Not Avavilable</td>';
            $html .= '</tr>';
            return response()->json($html);
        }

    }


    function addcustomerbanip(Request $request)
    {
        $ip = $request->ip;
        $tdid = $request->td_id;
        $banIp = new CustomerBanIp;
        $banIp->ip = $ip;
        $banIp->save();

        $ipbtn = '';

        $ipbtn .= '[<a href="#" onclick="removeBanIP('."'$ip'".','.$tdid.')" class="text-danger">Remove Ban IP</a>]';

        return response()->json($ipbtn);

    }

    function removecustomerbanip(Request $request)
    {
        $ip = $request->ip;
        $tdid = $request->td_id;
        CustomerBanIp::where('ip',$ip)->delete();

        $ipbtn = '';

        $ipbtn .= '[<a href="#" onclick="addBanIP('."'$ip'".','.$tdid.')" class="text-success">Add Ban IP</a>]';

        return response()->json($ipbtn);

    }


    function getcustomertransactions(Request $request)
    {
        $customer_id = $request->cust_id;

        $cust_transaction = CustomerTransaction::where('customer_id',$customer_id)->get();

        $cust_sum = CustomerTransaction::where('customer_id',$customer_id)->sum('oc_customer_transaction.amount');

        $html = '';
        $sum = '';

        if(count($cust_transaction) > 0)
        {
            foreach($cust_transaction as $transaction)
            {
                $html .= '<tr>';
                $html .= '<td>'.$transaction['date_added'].'</td>';
                $html .= '<td>'.$transaction['description'].'</td>';
                $html .= '<td>'.number_format($transaction['amount']).'</td>';
                $html .= '</tr>';
            }

            $sum .= '<div class="col-md-12 bg-secondary p-2"><b>Total Balance -: '.number_format($cust_sum).'</b></div>';


            return response()->json([
                'transaction' => $html,
                'sum' => $sum,
            ]);
        }
        else
        {
            $html .= '<tr>';
            $html .= '<td colspan="3" class="text-center">Transaction Not Avavilable</td>';
            $html .= '</tr>';

            $sum .= '<div class="col-md-12 bg-secondary p-2"><b>Total Balance -: 0</b></div>';

            return response()->json([
                'transaction' => $html,
                'sum' => $sum,
            ]);
        }
    }

    function getcustomerrewardpoints(Request $request)
    {
        $customer_id = $request->cust_id;

        $cust_reward = CustomerReward::where('customer_id',$customer_id)->get();

        $cust_sum = CustomerReward::where('customer_id',$customer_id)->sum('oc_customer_reward.points');

        $html = '';
        $sum = '';

        if(count($cust_reward) > 0)
        {
            foreach($cust_reward as $reward)
            {
                $html .= '<tr>';
                $html .= '<td>'.$reward['date_added'].'</td>';
                $html .= '<td>'.$reward['description'].'</td>';
                $html .= '<td>'.$reward['points'].'</td>';
                $html .= '</tr>';
            }

            $sum .= '<div class="col-md-12 bg-secondary p-2"><b>Total Balance -: '.$cust_sum.'</b></div>';
            return response()->json([
                'rewards' => $html,
                'sum' => $sum,
            ]);
        }
        else
        {
            $html .= '<tr>';
            $html .= '<td colspan="3" class="text-center">Rewards Not Avavilable</td>';
            $html .= '</tr>';

            $sum .= '<div class="col-md-12 bg-secondary p-2"><b>Total Balance -: 0</b></div>';

            return response()->json([
                'rewards' => $html,
                'sum' => $sum,
            ]);
        }
    }


    public function add()
    {
        $data['customergroups'] = CustomerGroup::select('oc_customer_group.customer_group_id','cgd.name as gname')->join('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer_group.customer_group_id')->get();

        // Country
        $data['countries'] = Country::get();

        return view('admin.customers.add',$data);
    }


    function storecustomerhistory(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $cust_address = new CustomerHistory;
        $cust_address->customer_id = $request->cid;
        $cust_address->comment = $request->comment;
        $cust_address->date_added = date('Y-m-d');
        $cust_address->save();

        return response()->json('success');

    }

    function storecustomertransaction(Request $request)
    {
        $request->validate([
            'trdescription' => 'required',
            'tramount' => 'required',
        ]);

        $cust_transaction = new CustomerTransaction();
        $cust_transaction->customer_id = $request->trcid;
        $cust_transaction->order_id = 0;
        $cust_transaction->description = $request->trdescription;
        $cust_transaction->amount = $request->tramount;
        $cust_transaction->date_added = date('Y-m-d');
        $cust_transaction->save();

        return response()->json('success');

    }

    function storecustomerrewardpoint(Request $request)
    {
        $request->validate([
            'rdescription' => 'required',
            'rpoints' => 'required',
        ]);

        $cust_reward = new CustomerReward;
        $cust_reward->customer_id = $request->rcid;
        $cust_reward->order_id = 0;
        $cust_reward->description = $request->rdescription;
        $cust_reward->points = $request->rpoints;
        $cust_reward->date_added = date('Y-m-d');
        $cust_reward->save();

        return response()->json('success');

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
                $add_one = $val['add_one'];
                $add_two = $val['add_two'];
                $city = $val['city'];
                $postcode = $val['postcode'];
                $country_id = $val['country_id'];
                $region_id = $val['region_id'];
                $default = isset($val['default']) ? $val['default'] : '';

                if(!empty($fname) && !empty($lname) && !empty($add_one) && !empty($city) && !empty($postcode) && !empty($country_id) && !empty($region_id))
                {
                    $cust_address = new CustomerAddress;
                    $cust_address->customer_id = $customer->customer_id;
                    $cust_address->firstname = isset($fname) ? $fname : '';
                    $cust_address->lastname = isset($lname) ? $lname : '';
                    $cust_address->company = isset($company) ? $company : '';
                    $cust_address->company_id = isset($companyId) ? $companyId : '';
                    $cust_address->tax_id = isset($taxid) ? $taxid : '';
                    $cust_address->address_1 = isset($add_one) ? $add_one : '';
                    $cust_address->address_2 = isset($add_two) ? $add_two : '';
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
        $data['regions'] = Region::get();
        $data['customer'] = Customer::find($id);
        $data['ips'] = CustomerIP::where('customer_id','=',$id)->get();
        $data['addresses'] = CustomerAddress::where('customer_id',$id)->orderBy('address_id','ASC')->get();
        return view('admin.customers.edit',$data);
    }


    public function update(Request $request)
    {
        $customer_id = $request->customer_id;

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required|min:10',
        ]);


        $email = $request->email;
        $dup_email = Customer::where('customer_id','!=',$customer_id)->where('email','=',$email)->first();

        if(!empty($dup_email))
        {
            $request->validate([
                'email' => 'required|email|unique:oc_customer,email',
            ]);
        }

        if(($request->password != '' || !empty($request->password)))
        {
            $request->validate([
                'password' => 'min:6|required_with:confirm|same:confirm',
                'confirm' => 'min:6|required_with:password|same:password',
            ]);
        }


        $customer = Customer::find($customer_id);
        // $customer->store_id = isset($request->store_id) ? $request->store_id : 0;
        $customer->firstname = isset($request->firstname) ? $request->firstname : '';
        $customer->lastname = isset($request->lastname) ? $request->lastname : '';
        $customer->email = isset($request->email) ? $request->email : '';
        $customer->telephone = isset($request->phone) ? $request->phone : '';
        $customer->fax = isset($request->fax) ? $request->fax : '';

        if(($request->password != '' || !empty($request->password)))
        {
            $customer->password = isset($request->password) ? bcrypt($request->password) : '';
        }

        // $customer->cart = isset($request->cart) ? $request->cart : '';
        // $customer->wishlist = isset($request->wishlist) ? $request->wishlist : '';
        $customer->newsletter = isset($request->newsletter) ? $request->newsletter : 0;
        // $customer->address_id = isset($request->address_id) ? $request->address_id : 0;
        $customer->customer_group_id = isset($request->customer_group_id) ? $request->customer_group_id : '';
        $customer->status = isset($request->status) ? $request->status : 1;
        // $customer->approved = isset($request->approved) ? $request->approved : 1;
        // $customer->token = isset($request->token) ? $request->token : '';
        // $customer->gender_id = isset($request->gender_id) ? $request->gender_id : 1;
        $customer->update();



        // Customer IP
        $cip = $_SERVER['REMOTE_ADDR'];
        $customer_ip = CustomerIP::where('customer_id',$customer_id)->where('ip',$cip)->first();

        if(empty($customer_ip) || $customer_ip == '')
        {
            $customerIp = new CustomerIP;
            $customerIp->customer_id = $customer->customer_id;
            $customerIp->ip = $cip;
            $customerIp->date_added = date('Y-m-d');
            $customerIp->save();
        }



        // Customer Address
        $address = $request->address;

        foreach($address as  $val)
        {

            $fname = $val['fname'];
            $lname = $val['lname'];
            $company = $val['company'];
            $companyId = $val['companyId'];
            $taxid = $val['taxid'];
            $add_one = $val['add_one'];
            $add_two = $val['add_two'];
            $city = $val['city'];
            $postcode = $val['postcode'];
            $country_id = $val['country_id'];
            $region_id = $val['region_id'];
            $default = isset($val['default']) ? $val['default'] : '';

                if(!empty($val['address_id']))
                {
                    $cust_address_update = CustomerAddress::find($val['address_id']);
                    $cust_address_update->firstname = isset($fname) ? $fname : '';
                    $cust_address_update->lastname = isset($lname) ? $lname : '';
                    $cust_address_update->company = isset($company) ? $company : '';
                    $cust_address_update->company_id = isset($companyId) ? $companyId : '';
                    $cust_address_update->tax_id = isset($taxid) ? $taxid : '';
                    $cust_address_update->address_1 = isset($add_one) ? $add_one : '';
                    $cust_address_update->address_2 = isset($add_two) ? $add_two : '';
                    $cust_address_update->city = isset($city) ? $city : '';
                    $cust_address_update->postcode = isset($postcode) ? $postcode : '';
                    $cust_address_update->country_id = isset($country_id) ? $country_id : 0;
                    $cust_address_update->zone_id = isset($region_id) ? $region_id : 0;
                    $cust_address_update->phone = isset($request->phone) ? $request->phone : '';
                    $cust_address_update->billing = isset($request->billing) ? $request->billing : 0;
                    $cust_address_update->card_name = isset($request->cardname) ? $request->cardname : '';
                    $cust_address_update->update();

                    if(($default != '') || (!empty($default)))
                    {
                        $cust_update = Customer::find($customer_id);
                        $cust_update->address_id = $val['address_id'];
                        $cust_update->update();
                    }

                }
                else
                {
                    if(!empty($fname) && !empty($lname) && !empty($add_one) && !empty($city) && !empty($postcode) && !empty($country_id) && !empty($region_id))
                    {
                        $cust_address = new CustomerAddress;
                        $cust_address->customer_id = $customer_id;
                        $cust_address->firstname = isset($fname) ? $fname : '';
                        $cust_address->lastname = isset($lname) ? $lname : '';
                        $cust_address->company = isset($company) ? $company : '';
                        $cust_address->company_id = isset($companyId) ? $companyId : '';
                        $cust_address->tax_id = isset($taxid) ? $taxid : '';
                        $cust_address->address_1 = isset($add_one) ? $add_one : '';
                        $cust_address->address_2 = isset($add_two) ? $add_two : '';
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
                            $cust_update = Customer::find($customer_id);
                            $cust_update->address_id = $cust_address->address_id;
                            $cust_update->update();
                        }
                    }
                }

        }


        $url = route('customers');
        return response()->json($url);

    }


    public function delete(Request $request)
    {
        $ids = $request['id'];

        if(count($ids) > 0)
        {
            // Delete Customer
            Customer::whereIn('customer_id',$ids)->delete();

            // Delete Customer IP
            foreach($ids as $id)
            {
                CustomerIP::where('customer_id',$id)->delete();
            }

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


    function delCustomerAddress(Request $request)
    {

        $address_id = $request->add_id;

        // Delete Customer Address
        CustomerAddress::where('address_id',$address_id)->delete();

        return response()->json([
            'success' => 1,
        ]);

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
