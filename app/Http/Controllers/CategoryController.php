<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\CategoryDetail;
use Illuminate\Http\Request;

class CategoryController extends Controller
{



    // Function of List All Category
    function index()
    {
        // Check User Permission
        if (check_user_role(17) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Fetch Categories
        $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->where('oc_category.top', '=', 1)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        return view('admin.category.CategoryList', ['fetchparent' => $fetchparent]);
    }



    // Function of Add Category View
    function newcategory()
    {

        // Check User Permission
        if (check_user_role(18) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }


        // Fetch Category Layout
        $category_layout = DB::table('oc_layout')->select('layout_id', 'name')->get();

        // Fetch Category Description
        $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->where('oc_category.top', '=', 1)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        return view('admin.category.newcategory', ['category_layout' => $category_layout, 'fetchparent' => $fetchparent]);
    }


    public function categoryupdate(Request $request)
    {
        // update Category Details
        $catdetail = CategoryDetail::find($request->id);

        // update Category Image
        if ($request->hasFile('image')) {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/image/'), $imgname);
            $catdetail->image = $imgname;
        }

        $catdetail->parent_id = $request->parent;
        $catdetail->top = isset($request->top) ? $request->top : 0;
        $catdetail->column = $request->columns;
        $catdetail->sort_order = $request->sortorder;
        $catdetail->status = $request->status;
        date_default_timezone_set('Asia/Kolkata');
        // $catdetail->date_added = date("Y-m-d h:i:s");
        $catdetail->date_modified = date("Y-m-d h:i:s");
        $catdetail->update();

        // $lastid = $catdetail->category_id;


        // update Category
        $cat = Category::find($request->id);
        // $cat->category_id = $request->category_id;
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = $request->description;
        $cat->meta_title = $request->matatitle;
        $cat->meta_description = $request->metadesc;
        $cat->meta_keyword = $request->metakey;

        $cat->update();
        $errors = "Update success";

        return redirect()->back()->withErrors($errors);
    }




    // Function of Delete Category
    function deleteCategory()
    {

    }



    // Function of Insert Category
    function categoryinsert(Request $request)
    {
        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
            'matatitle' => 'required',
        ]);

        // Insert Category Details
        $catdetail = new CategoryDetail;

        // Insert Category Image
        if ($request->hasFile('image')) {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/image/'), $imgname);
            $catdetail->image = $imgname;
        }

        $catdetail->parent_id = isset($request->parent) ? $request->parent : 0;
        $catdetail->top = isset($request->top) ? $request->top : 0;
        $catdetail->column = isset($request->columns) ? $request->columns : 0;
        $catdetail->sort_order = isset($request->sortorder) ? $request->sortorder : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        date_default_timezone_set('Asia/Kolkata');
        $catdetail->date_added = date("Y-m-d h:i:s");
        $catdetail->date_modified = date("Y-m-d h:i:s");
        $catdetail->save();
        $lastid = $catdetail->id;


        // Insert Category
        $cat = new Category;
        $cat->category_id = $lastid;
        $cat->language_id = '1';
        $cat->name = isset($request->category) ? $request->category : "";
        $cat->description = isset($request->description) ? $request->description : "";
        $cat->meta_title = isset($request->matatitle) ? $request->matatitle : "";
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";

        $cat->save();
        $errors = "Insert success";

        return redirect()->back()->withErrors($errors);
    }



    // Function of edit Category
    public function categoryedit($id)
    {

        // Check User Permission
        if (check_user_role(19) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Fetch Category Layout
        $category_layout = DB::table('oc_layout')->select('layout_id', 'name')->get();

        // Get Single Category Description
        $data = Category::where('oc_category_description.category_id', '=', $id)->join('oc_category', 'oc_category_description.category_id', '=', 'oc_category.category_id')->first();

        // Get Single Category
        $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->where('oc_category.top', '=', 1)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        // echo '<pre>';
        // print_r($data);
        // exit();
        return view('admin.category.categoryedit', ['data' => $data, 'fetchparent' => $fetchparent, 'category_layout' => $category_layout]);
    }
}
