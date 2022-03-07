<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use App\Models\CustomerGroupDescription;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{




    // Function of List All Customer Group & Description
    public function index()
    {
        // Get all Customer Group
        $data['customergroups'] = CustomerGroup::join('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer_group.customer_group_id')->get();

        return view('admin.customersgroup.list',$data);
    }




    // Function of Add new Customer Group View
    public function add()
    {
        return view('admin.customersgroup.add');
    }




    // Function of Store New Customer Group
    public function store(Request $request)
    {
        // Validation of New Customer Group
        $request->validate([
            'customergroupname' => 'required'
        ]);

        // Store Customer Group
        $sort_order = $request->sortorder;
        $customergroup = new CustomerGroup;
        $customergroup->approval = $request->approve;
        $customergroup->sort_order = isset($sort_order) ? $sort_order : 0;
        $customergroup->save();

        // Store Customer Group Description
        $description = $request->description;
        $customergroupdescription = new CustomerGroupDescription;
        $customergroupdescription->customer_group_id = $customergroup->customer_group_id;
        $customergroupdescription->language_id = 1;
        $customergroupdescription->name = $request->customergroupname;
        $customergroupdescription->description = isset($description) ? $description : '';
        $customergroupdescription->save();

        return redirect()->route('customersgroup')->with('success','Usergroup Inserted Successfully..');

    }




    // Function of Edit Customer Group View
    public function edit($id)
    {
        // Check User Permission
        // if(check_user_role(88) != 1)
        // {
        //     return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        // }

        // Get Customer Group Details by CustomerGroup ID
        $customergroup = CustomerGroup::join('oc_customer_group_description as cgd','cgd.customer_group_id','=','oc_customer_group.customer_group_id')->where('oc_customer_group.customer_group_id',$id)->first();

        if(empty($customergroup))
        {
            return redirect()->route('customersgroup');
        }

        $data['customergroup'] = $customergroup;
        return view('admin.customersgroup.edit',$data);
    }





    // Function of Update Customer Group
    function update(Request $request)
    {
        // Validation of Customer group
        $request->validate([
            'customergroupname' => 'required'
        ]);


        $customergroup_id = $request->id;

        // Update Customer Group
        $sort_order = $request->sortorder;
        $customergroup = CustomerGroup::find($customergroup_id);
        $customergroup->approval = $request->approve;
        $customergroup->sort_order = isset($sort_order) ? $sort_order : 0;
        $customergroup->update();

        // Update Customer Group Description
        $description = $request->description;
        $customergroupdescription = CustomerGroupDescription::find($customergroup_id);
        $customergroupdescription->name = $request->customergroupname;
        $customergroupdescription->description = isset($description) ? $description : '';
        $customergroupdescription->update();

        return redirect()->route('customersgroup')->with('success','Usergroup Updated Successfully..');
    }

    public function delete(Request $request)
    {
        // Check User Permission
        // if(check_user_role(89) != 1)
        // {
        //     return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        // }

        $ids = $request['id'];

        if(count($ids) > 0)
        {
            // Delete Customer Group
            CustomerGroup::whereIn('customer_group_id',$ids)->delete();

            // Delete Customer Group Description
            CustomerGroupDescription::whereIn('customer_group_id',$ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }
}
