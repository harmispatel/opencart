<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\InformationLayouts;
use App\Models\InformationStore;
use App\Models\Layouts;
use App\Models\Seo;


class InformationController extends Controller
{
    public function index()
    {
        $data['informations'] =Information::select('oc_information.*','oid.title as oname')->leftJoin('oc_information_description as oid','oc_information.information_id','=','oid.information_id')->get();

        return view('admin.informations.list',$data);
    }

    public function add()
    {
        $data['layouts'] = Layouts::get();

        return view('admin.informations.add',$data);
    }

    function store(Request $request)
    {
        $request->validate([
            'infotitle' => 'required',
            'description' => 'required',
            'metatitle' => 'required',
        ]);


        // Store Information
        $information = new Information;
        $information->status = $request['status'];

        // Give Value to Variable
        $bottom = $request['bottom'];
        $sortorder = $request['sortorder'];

        $information->bottom = isset($bottom) ? $bottom : 0;
        $information->sort_order = isset($sortorder) ? $sortorder : 0;
        $information->save();
        $info_id = $information->id;


        // Store Information Description
        $infodescription = new InformationDescription;
        $infodescription->information_id = $info_id;
        $infodescription->language_id = 1;
        $infodescription->title = $request['infotitle'];
        $infodescription->description = $request['description'];
        $infodescription->meta_title = $request['metatitle'];

        // Give Value to Variable
        $metadesc = $request['metadescription'];
        $metakey = $request['metakeyword'];

        $infodescription->meta_description = isset($metadesc) ? $metadesc : "";
        $infodescription->meta_keyword = isset($metakey) ? $metakey : '';
        $infodescription->save();


        // Store Information Layout
        $infolayout = new InformationLayouts;
        $infolayout->information_id = $info_id;
        $infolayout->store_id = 0;

        // Give Value to Variable
        $layoutId = $request['designid'];

        $infolayout->layout_id = isset($layoutId) ? $layoutId : 0;

        $infolayout->save();


        // Store Information Store
        if(!empty($request['default']))
        {
            $infostore = new InformationStore;
            $infostore->information_id = $info_id;
            $infostore->store_id = 0;
            $infostore->save();
        }


        // Store Information SEO
        if(!empty($request['keyword']))
        {
            $seo = new Seo;
            $seo->store_id = 0;
            $seo->language_id = 1;
            $seo->query = 'information_id='.$info_id;
            $seo->keyword = $request['keyword'];
            $seo->save();
        }

        return redirect()->route('information')->with('success',"Information has been Inserted Successfully.");

    }



    function delete(Request $request)
    {
        // Check User Permission
    //    if(check_user_role(73) != 1)
    //    {
    //        return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
    //    }

       //Multiple Id's
       $ids = $request['id'];

       // When not empty ids Then Delete Otherwise Not
       if(count($ids) > 0)
       {
           // Delete Information
           Information::whereIn('information_id',$ids)->delete();

           // Delete Information Description
           InformationDescription::whereIn('information_id',$ids)->delete();

           // Delete Information Layout
           InformationLayouts::whereIn('information_id',$ids)->delete();

           // Delete Information Store
           InformationStore::whereIn('information_id',$ids)->delete();

           // Delete Information SEO
           foreach($ids as $id)
           {
               $query = 'information_id='.$id;
               Seo::where('query',$query)->delete();
           }

           return response()->json([
               'success' => 1,
           ]);
       }
    }



    function edit($id)
    {
        //Check User Permission
        // if(check_user_role(72) != 1)
        // {
        //     return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        // }

        // Get Information Details by Information ID
        $information = Information::select('oc_information.*','oid.title','oid.description','oid.meta_title','oid.meta_description','oid.meta_keyword','oitl.layout_id')->leftJoin('oc_information_description as oid','oid.information_id','=','oc_information.information_id')->leftJoin('oc_information_to_layout as oitl','oitl.information_id','=','oc_information.information_id')->where('oc_information.information_id',$id)->first();

        // When Empty Information Then Redirect to Informations List
        if(empty($information))
        {
            return redirect()->route('information');
        }

        // Give Information Details to Array
        $data['information'] = $information;

        // Give Information Store to Array
        $data['store'] = InformationStore::where('information_id',$id)->first();

        // Give Information SEO Details to Array
        $query = 'information_id='.$id;
        $data['seo'] = Seo::select('keyword')->where('query',$query)->first();

        // Layouts
        $data['layouts'] = Layouts::get();

        return view('admin.informations.edit',$data);
    }


}
