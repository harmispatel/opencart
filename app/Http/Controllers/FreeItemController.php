<?php

namespace App\Http\Controllers;

use App\Models\FreeItem;
use App\Models\FreeItemadd;
use App\Models\FreeRule;
use Illuminate\Http\Request;

class FreeItemController extends Controller
{

    public function freeitems()
    {
        // return view('admin.freeitems.freeitem');
        $data = FreeItemadd::all();  
        return view('admin.freeitems.freeitemlist',['data'=>$data]);
    }

    // public function cartruleinsert(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'total_above' => 'required',
    //     ]);

    //     $cartrule = new FreeRule;

    //     return view('admin.freeitems.cartrule');
    // }

    public function cartrule()
    {
        $data['cartrul'] = FreeRule::get();
        // echo '<pre>';
        // print_r($data['cartrul']->toArray());
        // exit();
        return view('admin.freeitems.cartrule',$data);
    }

    public function addfreeitems()
    {
        return view('admin.freeitems.additem');
    }

    public function freeiteminsert(Request $request)
    {
        $request->validate([
            'name_item' => 'required',
        ]);
        
        $freeitem = new FreeItemadd;
        $freeitem->name_item = $request['name_item'];
        $freeitem->save();

        return redirect()->route('freeitemlist');
    }

    public function freeitemlist()
    {
        $data = FreeItemadd::all();  
        return view('admin.freeitems.freeitemlist',['data'=>$data]);
    }
    public function freeitemedit($id)
    {
        // echo "<pre>";print_r($id);exit;
        $freeitemedit = FreeItemadd::find($id);

        return view('admin.freeitems.freeitemedit',['freeitemedit'=>$freeitemedit]);

    }

    public function freeitemupdate(Request $request,$id)
    {
        $request->validate([
            'name_item' => 'required',
        ]);
        $freeitemupdate = FreeItemadd::find($id);
        $freeitemupdate->name_item = $request->name_item;
        $freeitemupdate->update();

        return redirect()->route('freeitemlist');

    }
    public function freeitemdelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            FreeItemadd::whereIn('id_free_item ', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
            echo "<pre>"; print_r($ids);exit;
        }
    }
    


}
