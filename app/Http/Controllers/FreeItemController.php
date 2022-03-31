<?php

namespace App\Http\Controllers;

use App\Models\FreeItem;
use App\Models\FreeItemadd;
use App\Models\FreeRule;
use Illuminate\Http\Request;

class FreeItemController extends Controller
{
    public function cartrule()
    {
        $current_store_id = currentStoreId();
        $data['cartrul'] = FreeRule::where('id_store',$current_store_id)->get();
        return view('admin.freeitems.cartrule',$data);
    }

    public function addfreerule()
    {
        $current_store_id = currentStoreId();
        $data['freeitems'] = FreeItemadd::where('store_id',$current_store_id)->get();
        return view('admin.freeitems.addfreerule',$data);
    }

    public function cartruleinsert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'free_item' => 'required',
            'total_above' => 'required',
        ]);

        $cartrule = new FreeRule;
        $current_store_id = currentStoreId();
        $cartrule->name_rule = $request->name;
        $cartrule->id_store = $current_store_id;
        $id_item = implode(":",$request->free_item);
        $cartrule->id_item = $id_item;
        $cartrule->min_total = isset($request->total_above) ? $request->total_above : "";
        $cartrule->save();
        return redirect()->route('cartrule')->with('success', "Cartrule Insert Successfully.");
    }

    public function cartruleupdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'free_item' => 'required',
            'total_above' => 'required',
        ]);

        $cartrule = FreeRule::find($request->id);
        $cartrule->name_rule = $request->name;
        // $cartrule->id_store = currentStoreId();
        $id_item = implode(":",$request->free_item);
        $cartrule->id_item = $id_item;
        $cartrule->min_total = isset($request->total_above) ? $request->total_above : "";
        $cartrule->update();
        return redirect()->route('cartrule')->with('success', "Cartrule Update Successfully.");
    }

    public function cartruledelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            FreeRule::whereIn('id_rule', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }

    public function editfreerule($id)
    {
        $current_store_id = currentStoreId();
        $data['freeitems'] = FreeItemadd::where('store_id',$current_store_id)->get();
        $data['getfreeitem'] = FreeRule::find($id);
        if(empty($data['getfreeitem']))
        {
            return redirect()->route('cartrule');
        }
        return view('admin.freeitems.edit',$data);
    }

    public function freeitems()
    {
        $current_store_id = currentStoreId();
        $data = FreeItemadd::where('store_id',$current_store_id)->get();  
        return view('admin.freeitems.freeitemlist',['data'=>$data]);
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
        $freeitem->name_item = $request->name_item;
        $freeitem->store_id = currentStoreId();
        $freeitem->save();

        return redirect()->route('freeitemlist');
    }

    public function freeitemlist()
    {
        $current_store_id = currentStoreId();
        $data = FreeItemadd::where('store_id',$current_store_id)->get();  
        return view('admin.freeitems.freeitemlist',['data'=>$data]);
    }

    public function freeitemedit($id)
    {
        $freeitemedit = FreeItemadd::find($id);
        if(empty($freeitemedit))
        {
            return redirect()->route('freeitems');
        }
        return view('admin.freeitems.freeitemedit',['freeitemedit'=>$freeitemedit]);
    }

    public function freeitemupdate(Request $request,$id)
    {
        $request->validate([
            'name_item' => 'required',
        ]);
        $current_store_id = currentStoreId();
        $freeitemupdate = FreeItemadd::where('id_store',$current_store_id)->find($id);
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
        }
    }
    


}
