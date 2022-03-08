<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filters;
use App\Models\FilterDescription;
use App\Models\FilterGroup;
use App\Models\FilterGroupDescription;
use PhpParser\Node\Expr\Empty_;

class FiltersController extends Controller
{



    // Function of List All Filtergroup
    public function index()
    {
        // Check User Permission
        // if (check_user_role(66) != 1) 
        // {
        //     return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        // }

        // Get All Filter Group
        $data['filtergroups'] = FilterGroup::select('oc_filter_group.*', 'fgd.name')->leftJoin('oc_filter_group_description as fgd', 'fgd.filter_group_id', '=', 'oc_filter_group.filter_group_id')->get();

        return view('admin.filters.list', $data);
    }



    public function add()
    {
        return view('admin.filters.add');
    }



    function store(Request $request)
    {

        // Sort Order
        $sort_order = $request->sort_order;

        // Insert Filter Group
        $filtergroup = new FilterGroup();
        $filtergroup->sort_order = isset($sort_order) ? $sort_order : 0;
        $filtergroup->created_at = date('Y-m-d');
        $filtergroup->save();

        // Insert Filter Group Description
        $filtergroupdescription = new FilterGroupDescription();
        $filtergroupdescription->filter_group_id = $filtergroup->filter_group_id;
        $filtergroupdescription->language_id = 1;
        $filtergroupdescription->name = $request['filter'];
        $filtergroupdescription->created_at = date('Y-m-d');
        $filtergroupdescription->save();


        if (!empty($request->mulfilter)) {

            $mulfilter = $request['mulfilter'];
            $order = $request['mulsort_order'];

            foreach ($mulfilter as $key => $filtername) {

                $filter = new Filters();
                $filter->filter_group_id = $filtergroup->filter_group_id;
                $filter->sort_order = isset($order[$key]) ? $order[$key] : 0;
                $filter->save();
                $filterdscription = new FilterDescription();

                $filterdscription->filter_id = $filter->filter_id;
                $filterdscription->language_id = 1;
                $filterdscription->filter_group_id = $filtergroup->filter_group_id;
                $filterdscription->name = $filtername;
                $filterdscription->save();
            }
        }

        return redirect()->route('filter')->with("success", "Filter Inserted Successfully...");
    }



    function delete(Request $request)
    {
        // Check User Permission
        //    if(check_user_role(103) != 1)
        //    {
        //        return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        //    }

        //Multiple Id's
        $ids = $request['id'];

        // When not empty ids Then Delete Otherwise Not
        if (count($ids) > 0) {
            // Delete FilterGroup
            FilterGroup::whereIn('filter_group_id', $ids)->delete();

            // Delete FilterGroup Description
            FilterGroupDescription::whereIn('filter_group_id', $ids)->delete();

            // Delete Filter
            Filters::whereIn('filter_group_id', $ids)->delete();

            // Delete Filter Description
            FilterDescription::whereIn('filter_group_id', $ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }

    public function edit($id)
    {

        $filterGroup = FilterGroup::where('filter_group_id', $id)->first();
        $data['filter'] = $filterGroup;
        $data['filtergroupdescription'] = FilterGroupDescription::where('filter_group_id', $id)->first();
        $data['filters'] = Filters::join('oc_filter_description', 'oc_filter.filter_id', '=', 'oc_filter_description.filter_id')->where('oc_filter.filter_group_id',$id)->get();

        return view('admin.filters.editfilter', $data);
    }



    public function update(Request $request)
    {

        $filter_group_id = $request['filter_group_id'];
        //   print_r($filter_group_id);die;
        // // print_r($filterdescription);die;
        $sort_order = $request->sort_order;

        // Insert Filter Group
        $filtergroup = FilterGroup::find($filter_group_id);

        $filtergroup->sort_order = isset($sort_order) ? $sort_order : 0;
        $filtergroup->created_at = date('Y-m-d');
        $filtergroup->update();

        // Insert Filter Group Description
        $filtergroupdescription = FilterGroupDescription::where('filter_group_id', $filter_group_id)->first();
        //   $filtergroupdescription->filter_group_id = $filtergroup->id;

        $filtergroupdescription->language_id = 1;
        $filtergroupdescription->name = $request['filter'];
        $filtergroupdescription->created_at = date('Y-m-d');
        $filtergroupdescription->save();



        if (!empty($request->mulfilter)) {

            $mulfilter = $request['mulfilter'];
            $order = $request['mulsort_order'];
            $filter_id = $request['filter_id'];

            foreach ($mulfilter as $key => $filtername) {

                $data= $key; 
                               
                $filter = Filters::find($filter_id[$key]);
                //  if(!empty($filter)){
                    $filter->sort_order = isset($order[$key]) ? $order[$key] : 0;
                    $filter->update();
                    $filterdescription = FilterDescription::find($filter_id[$key]);
                    // $filterdescription->filter_id = $filter->filter_id;
                    // $filterdescription->language_id = 1; 
                    // $filterdescription->filter_group_id = $filtergroup->id;
                    $filterdescription->name = $filtername;
                    $filterdescription->update();
                //  }else{
                //     $filters = new Filters();
                //     $filters->filter_group_id = $filter_group_id;
                //     $filters->sort_order = isset($data) ? $data : 0;
                //     $filters->save();
                //     $filterdscription = new FilterDescription();
                //     $filterdscription->filter_id = $filter->filter_id;
                //     $filterdscription->language_id = 1;
                //     $filterdscription->filter_group_id =$filter_group_id;
                //     $filterdscription->name = $filtername;
                //     $filterdscription->save();
                //  }
            }
        }
        return redirect()->route('filter')->with("success", "Filter Updated Successfully...");
    }
}
