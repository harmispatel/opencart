<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\CategoryLayout;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{

    // Function of List All Category
    function index()
    {
        // Check User Permission
        if (check_user_role(50) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();


        return view('admin.category.CategoryList', ['fetchparent' => $fetchparent]);
    }

    public function getcategory(Request $request){
        if ($request->ajax()) {
            $data =CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $edit_url = route('categoryedit',$row->category_id);
                $btn = '<a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';

                return $btn;
            })
            ->addColumn('checkbox', function($row){
                $cid = $row->category_id;
                $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$cid.'">';
                return $checkbox;
            })
            ->rawColumns(['action','checkbox'])
            ->make(true);
        }
    }



    function bulkcategory()
    {
        return view('admin.category.bulkcategory');
    }



    // Function of Add Category View
    function newcategory()
    {

        // Check User Permission
        if (check_user_role(55) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }


        // Fetch Category Layout
        $category_layout = CategoryLayout::select('layout_id', 'name')->get();

        $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

        return view('admin.category.newcategory', ['category_layout' => $category_layout, 'fetchparent' => $fetchparent]);
    }


    public function categoryupdate(Request $request)
    {
        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
            'matatitle' => 'required',
        ]);
        // update Category Details
        $catdetail = CategoryDetail::find($request->id);

        // update Category Image
        if ($request->hasFile('image')) {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/image/'), $imgname);
            $catdetail->image = $imgname;
        }

        // Insert Banner Image
        if ($request->hasFile('banner')) {
            $imgname = time() . "." . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('admin/banner/'), $imgname);
        }


        $catdetail->image = isset($imgname) ? $imgname : '';
        $catdetail->img_banner = isset($imgname) ? $imgname : '';
        $catdetail->parent_id = $request->parent;
        $catdetail->top =  isset($request->top) ? $request->top : 0;
        $catdetail->column =  $request->columns;
        $catdetail->sort_order = $request->sortorder;
        $catdetail->status = $request->status;
        date_default_timezone_set('Asia/Kolkata');
        $catdetail->date_modified = date("Y-m-d h:i:s");
        $catdetail->update();

        // $lastid = $catdetail->category_id;


        // update Category
        $cat = Category::find($request->id);
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = isset($request->description) ? $request->description : "";
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";

        $cat->update();
        $errors = "Update success";

        return redirect()->back()->withErrors($errors);
    }




    // Function of Delete Category

    function categorydelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            Category::whereIn('category_id', $ids)->delete();
            CategoryDetail::whereIn('category_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }



    // Function of Insert Category
    function categoryinsert(Request $request)
    {
        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
        ]);

        // echo '<pre>';
        // print_r($request->toArray());
        // exit();
        // Insert Category Details
        $catdetail = new CategoryDetail;

        // Insert Category Image
        if ($request->hasFile('image')) {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/image/'), $imgname);
            // $catdetail->image = $imgname;

        }
        // Insert Banner Image
        if ($request->hasFile('banner')) {
            $imgname = time() . "." . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('admin/banner/'), $imgname);
        }

        $catdetail->image = isset($imgname) ? $imgname : '';
        $catdetail->img_banner = isset($imgname) ? $imgname : '';
        $availibleday = implode(",", $request->availibleday);

        $catdetail->parent_id = isset($request->parent) ? $request->parent : 0;
        $catdetail->top = isset($request->top) ? $request->top : 0;
        $catdetail->column = isset($request->columns) ? $request->columns : 0;
        $catdetail->sort_order = isset($request->sortorder) ? $request->sortorder : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        date_default_timezone_set('Asia/Kolkata');
        $catdetail->date_added = date("Y-m-d h:i:s");
        $catdetail->date_modified = date("Y-m-d h:i:s");
        $catdetail->availibleday = $availibleday;
        $catdetail->save();
        $lastid = $catdetail->category_id;

        // Insert Category
        $cat = new Category;
        $cat->category_id = $lastid;
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = isset($request->description) ? $request->description : "";
        // $cat->meta_title = isset($request->matatitle) ? $request->matatitle : "";
        $cat->slug = isset($request->slug) ? $request->slug : "";
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";

        $cat->save();
        $errors = "Insert success";

        return redirect()->route('category')->withErrors($errors);
    }




    // Function of edit Category
    public function categoryedit($id)
    {

        // Check User Permission
        if (check_user_role(56) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Fetch Category Layout
        $category_layout = CategoryLayout::select('layout_id', 'name')->get();

        // Get Single Category Description
        $data = Category::where('oc_category_description.category_id', '=', $id)->join('oc_category', 'oc_category_description.category_id', '=', 'oc_category.category_id')->first();

        // Get Single Category
        // $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->g

        return view('admin.category.categoryedit', ['data' => $data, 'category_layout' => $category_layout]);
        // echo '<pre>';
        // print_r($data->toArray());
        // exit();

        return view('admin.category.categoryedit', ['data' => $data, 'category_layout' => $category_layout]);
    }
}
