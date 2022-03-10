<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Country;
use App\Models\Region;
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
        // $customers = Customer::select('oc_customer.*','cgd.name as groupname')->leftJoin('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer.customer_group_id')->get();

        // if(!empty($customers))
        // {
        //     $html = '';

        //     foreach($customers as $customer)
        //     {
        //         $cust_id = $customer->customer_id;

        //         $edit_url = route('editcustomer',$customer->customer_id);

        //         $html .= '<tr>';
        //         $html .= '<td><input type="checkbox" name="del_all" class="del_all" value="'.$cust_id.'"></td>';
        //         $html .= '<td>'.$customer->firstname.' '.$customer->lastname.'</td>';
        //         $html .= '<td>-</td>';
        //         $html .= '<td>'.$customer->email.'</td>';
        //         $html .= '<td>'.$customer->groupname.'</td>';
        //         $html .= '<td>';

        //         if($customer->status == 1)
        //         {
        //             $html .= 'Enabled';
        //         }
        //         else
        //         {
        //             $html .= 'Disabled';
        //         }

        //         $html .= '</td>';
        //         $html .= '<td>-</td>';
        //         $html .= '<td>'.$customer->ip.'</td>';
        //         $html .= '<td>'.date('d-m-Y',strtotime($customer->date_added)).'</td>';

        //         // $html .= '<td><a href="'.$edit_url.'" class="btn btn-sm btn-primary rounded"><i class="fa fa-edit"></i></a></td>';

        //         $html .= '<td>';
        //             $html .= '<div class="btn-group">';
        //                 $html .= '<a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
        //                 $html .= '<button type="button" data-toggle="dropdown" class="btn btn-sm btn-primary dropdown-toggle" aria-expanded="false" style="border-left:1px solid white">';
        //                     $html .= '<span class="caret"></span>';
        //                 $html .= '</button>';
        //                 $html .= '<ul class="dropdown-menu dropdown-menu-right">';
        //                     $html .= '<li class="dropdown-header">Login into Store</li>';
        //                     $html .= ' <li class="text-center"><a href="" target="_blank"><i class="fa fa-lock"></i> Your Store</a></li>';
        //                 $html .= '</ul>';
        //             $html .= '</div>';
        //         $html .= '</td>';

        //         $html .= '</tr>';
        //     }
        //     return response()->json($html);
        // }

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
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'fax' => 'required',
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
