<?php

namespace App\Http\Controllers;

use App\Models\ProductIcons;
use Illuminate\Http\Request;

class ProductIconsController extends Controller
{

    public function index()
    {
        // Check User Permission
        if(check_user_role(93) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $data['producticons'] = ProductIcons::get();
        return view('admin.producticons.list',$data);
    }


    public function add()
    {
        // Check User Permission
        if(check_user_role(92) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.producticons.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon_name' => 'required',
            'icon_url' => 'required',
        ]);

        $product_icons = new ProductIcons;
        $product_icons->icon_name = $request->icon_name;
        $product_icons->icon_desc = isset($request->description) ? $request->description : '';
        $product_icons->icon_url = $request->icon_url;
        $product_icons->icon_sort = isset($request->sort_order) ? $request->sort_order : 0;
        $product_icons->icon_status = 1;
        $product_icons->date_added = date('Y-m-d');
        $product_icons->save();

        return redirect()->route('producticons')->with('success','Product Icons has been Inserted Successfully.');

    }

    // Function of Delete Product Icons
    public function delete(Request $request)
    {
        // Check User Permission
        if(check_user_role(95) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $ids = $request['id'];

        if(count($ids) > 0)
        {
            // Delete Product Icon
            ProductIcons::whereIn('id',$ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }


    function edit($id)
    {
        // Check User Permission
        if(check_user_role(94) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $data['producticon'] = ProductIcons::where('id',$id)->first();
        return view('admin.producticons.edit',$data);
    }


    public function update(Request $request)
    {
        $request->validate([
            'icon_name' => 'required',
            'icon_url' => 'required',
        ]);

        $product_icons = ProductIcons::find($request->id);
        $product_icons->icon_name = $request->icon_name;
        $product_icons->icon_desc = isset($request->description) ? $request->description : '';
        $product_icons->icon_url = $request->icon_url;
        $product_icons->icon_sort = isset($request->sort_order) ? $request->sort_order : 0;
        $product_icons->update();

        return redirect()->route('producticons')->with('success','Product Icons has been Updated Successfully.');

    }

}
