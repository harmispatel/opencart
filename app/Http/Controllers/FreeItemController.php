<?php

namespace App\Http\Controllers;
use App\Models\FreeItemadd;
use App\Models\FreeRule;
use Illuminate\Http\Request;

class FreeItemController extends Controller
{

    // Function of get Cart Rule By Current Store ID
    public function cartrule()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $data['cartrul'] = FreeRule::where('id_store',$current_store_id)->get();
        return view('admin.freeitems.cartrule',$data);
    }





    // Function of Add Cart Rule View
    public function addfreerule()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Get Free Items By Current Store
        $data['freeitems'] = FreeItemadd::where('store_id',$current_store_id)->get();

        return view('admin.freeitems.addfreerule',$data);
    }





    // Function of Store Cart Rule
    public function cartruleinsert(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Validation
        $request->validate([
            'name' => 'required',
            'free_item' => 'required',
            'total_above' => 'required',
        ]);

        // Store New Cart Rule
        $cartrule = new FreeRule;
        $cartrule->name_rule = $request->name;
        $cartrule->id_store = $current_store_id;
        $id_item = implode(":",$request->free_item);
        $cartrule->id_item = $id_item;
        $cartrule->min_total = isset($request->total_above) ? $request->total_above : "";
        $cartrule->save();

        return redirect()->route('cartrule')->with('success', "Cartrule Insert Successfully.");
    }





    // Function of Update Cart Rule
    public function cartruleupdate(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'free_item' => 'required',
            'total_above' => 'required',
        ]);

        $cartrule = FreeRule::find($request->id);
        $cartrule->name_rule = $request->name;
        $id_item = implode(":",$request->free_item);
        $cartrule->id_item = $id_item;
        $cartrule->min_total = isset($request->total_above) ? $request->total_above : "";
        $cartrule->update();

        return redirect()->route('cartrule')->with('success', "Cartrule Update Successfully.");
    }





    // Function of Delete Cart Rule
    public function cartruledelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0)
        {
            FreeRule::whereIn('id_rule', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }





    // Function of Edit Cart Rule View
    public function editfreerule($id)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Get Free Items By Current Store
        $data['freeitems'] = FreeItemadd::where('store_id',$current_store_id)->get();

        $data['getfreeitem'] = FreeRule::find($id);
        if(empty($data['getfreeitem']))
        {
            return redirect()->route('cartrule');
        }

        return view('admin.freeitems.edit',$data);
    }





    // Function of Get Free Items By Current Store
    public function freeitems()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $data = FreeItemadd::where('store_id',$current_store_id)->get();
        return view('admin.freeitems.freeitemlist',['data'=>$data]);
    }





    // Function of add Free Items view
    public function addfreeitems()
    {
        return view('admin.freeitems.additem');
    }





    // Function of Store Free Items
    public function freeiteminsert(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Validation
        $request->validate([
            'name_item' => 'required',
        ]);

        $freeitem = new FreeItemadd;
        $freeitem->name_item = $request->name_item;
        $freeitem->store_id = $current_store_id;
        $freeitem->save();

        return redirect()->route('freeitemlist');
    }






    public function freeitemlist()
    {
        $current_store_id = currentStoreId();
        $data = FreeItemadd::where('store_id',$current_store_id)->get();
        return view('admin.freeitems.freeitemlist',['data'=>$data]);
    }





    // Function of Edit Free Item View
    public function freeitemedit($id)
    {
        $freeitemedit = FreeItemadd::find($id);

        if(empty($freeitemedit))
        {
            return redirect()->route('freeitems');
        }
        return view('admin.freeitems.freeitemedit',['freeitemedit'=>$freeitemedit]);
    }





    // Function of Update Free Item
    public function freeitemupdate(Request $request,$id)
    {
        // Validation
        $request->validate([
            'name_item' => 'required',
        ]);

        $freeitemupdate = FreeItemadd::find($id);
        $freeitemupdate->name_item = $request->name_item;
        $freeitemupdate->update();

        return redirect()->route('freeitemlist')->with('success','Free Item has been Updated Successfully..');
    }





    // Function of Delete Free Items
    public function freeitemdelete(Request $request)
    {
        $ids = $request['id'];

        if (count($ids) > 0)
        {
            FreeItemadd::whereIn('id_free_item', $ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }


}
