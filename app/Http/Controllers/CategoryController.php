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
        if(check_user_role(50) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Fetch Categories
        $fetchparent = CategoryDetail::where('oc_category.parent_id','=',0)->where('oc_category.top','=',1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        return view('admin.category.CategoryList', ['fetchparent' => $fetchparent]);
    }



    // Function of Add Category View
    function newcategory()
    {

        // Check User Permission
        if(check_user_role(55) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }


        // Fetch Category Layout
        $category_layout = DB::table('oc_layout')->select('layout_id', 'name')->get();

        // Fetch Category Description
        $fetchparent = CategoryDetail::where('oc_category.parent_id','=',0)->where('oc_category.top','=',1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        return view('admin.category.newcategory', ['category_layout' => $category_layout, 'fetchparent' => $fetchparent]);

    }



    // Function of Delete Category
    function deleteCategory()
    {
        // Check User Permission
        if(check_user_role(57) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        //Fetch Single Category
        $category = Category::where('id', $_POST['id'])->first();

        // Delete Category Image
        if (file_exists('public/admin/category/' . $category->image)) {
            unlink('public/admin/category/' . $category->image);
        }

        // Delete Selected Category
        $category = Category::where('id', $_POST['id'])->delete();

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
        if ($request->hasFile('image'))
        {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/image/'), $imgname);
            $catdetail->image = $imgname;
        }

        $catdetail->parent_id = isset($request->parent) ? $request->parent : 0;
        $catdetail->top = isset($request->top) ? $request->top : 0 ;
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
        if(check_user_role(56) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Fetch Category Layout
        $category_layout = DB::table('oc_layout')->select('layout_id', 'name')->get();

        // Get Single Category Description
        $data=Category::where('oc_category_description.category_id','=',$id)->join('oc_category','oc_category_description.category_id','=','oc_category.category_id')->first();

        // Get Single Category
        $fetchparent = CategoryDetail::where('oc_category.parent_id','=',0)->where('oc_category.top','=',1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        return view('admin.category.categoryedit',['data'=>$data, 'fetchparent'=> $fetchparent , 'category_layout'=> $category_layout]);

    }



}
