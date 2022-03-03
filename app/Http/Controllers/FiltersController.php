<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filters;
use App\Models\FilterDescription;
use App\Models\FilterGroup;
use App\Models\FilterGroupDescription;

class FiltersController extends Controller
{
    public function index()
    {
        // Check User Permission
        if(check_user_role(66) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }
        return view('admin.Filters.filter');
    }
    public function add(){
        return view('admin.Filters.addFilter');
    }
     public function store(Request $request){

        
        $this->validate($request, [
            'filter' => 'required|min:2|max:64',
            // 'mulfilter' => 'required|min:2|max:64',

        ]);



         $filter_Group = new FilterGroup();
         $filter_Group->sort_order=$request['sort_order'];
         $filter_Group->save();

            
           if(!empty($request->mulsort_order)){
            
             $abc=$request->mulsort_order;

             foreach ($abc as $value) {
                //  echo $value;die;
                $filter_Group = new FilterGroup();
                $filter_Group->sort_order=$value;
                // $filter_Group->save();
             }

           }
         

        //  $filter =new Filters();
        //  $filter->filter_group_id=$filter_Group->id;
        //  $filter->sort_order=$request['sort_order'];
        //  $filter->save();

        //  $filter_group_Description=new FilterGroupDescription();
        //  $filter_group_Description->filter_group_id=$filter_Group->id;
        //  $filter_group_Description->language_id=1;
        //  $filter_group_Description->name=$request['filter'];
        //  $filter_group_Description->save();

        //  $filter_description=new FilterDescription();
        //  $filter_description->filter_id=$filter->id;
        //  $filter_description->language_id=1;
        //  $filter_description->filter_group_id=$filter_Group->id;
        //  $filter_description->name=$request['filter'];
        //  $filter_description->save();

         return redirect()->route('addFilter')->with('status',"Filter Inserted Successfully...");
         
     }
}
