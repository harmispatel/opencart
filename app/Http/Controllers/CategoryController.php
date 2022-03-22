<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\CategoryLayout;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{

    // Function of Category View
    function index()
    {
        // Check User Permission
        if (check_user_role(50) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.category.CategoryList');
    }




    // Function of Get all Categories
    public function getcategory(Request $request)
    {
        if($request->ajax())
        {
            $data =CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

            return DataTables::of($data)->addIndexColumn()
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




    // Function of Bulk Category View
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




    // Function of Update Category
    public function categoryupdate(Request $request)
    {
        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
        ]);

        // update Category Details
        $catdetail = CategoryDetail::find($request->id);

        // update Category Image
        if ($request->hasFile('image'))
        {
            $image = isset($catdetail['image']) ? $catdetail['image'] : '';
            if(!empty($image) || $image != '')
            {
                if(file_exists('public/admin/category/'.$image))
                {
                    unlink('public/admin/category/'.$image);
                }
            }

            $imgname = time().".". $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/category/'), $imgname);
            $catdetail->image = $imgname;
        }

        // Insert Banner Image
        if ($request->hasFile('banner'))
        {
            $banner = isset($catdetail['img_banner']) ? $catdetail['img_banner'] : '';
            if(!empty($banner) || $banner != '')
            {
                if(file_exists('public/admin/category/banner/'.$banner))
                {
                    unlink('public/admin/category/banner/'.$banner);
                }
            }

            $bannerimgname = time().".". $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('admin/category/banner'), $bannerimgname);
            $catdetail->img_banner = $bannerimgname;
        }

        $availibleday = implode(",", $request->availibleday);

        $catdetail->top =  isset($request->top) ? $request->top : 0;
        $catdetail->column = isset($request->columns) ? $request->columns : 1;
        $catdetail->sort_order = $request->sortorder;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        date_default_timezone_set('Asia/Kolkata');
        $catdetail->availibleday = $availibleday;
        $catdetail->update();


        // update Category
        $cat = Category::find($request->id);
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = isset($request->description) ? $request->description : "";
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
        $cat->update();

        return redirect()->route('category')->with('success','Category has been updated Successfully.');
    }




    // Function of Delete Category
    function categorydelete(Request $request)
    {
        $ids = $request['id'];

        if (count($ids) > 0)
        {
            // Delete Category Image & Banner Image
            foreach($ids as $id)
            {
                $category = CategoryDetail::where('category_id',$id)->first();
                $image = isset($category['image']) ? $category['image'] : '';
                $banner = isset($category['img_banner']) ? $category['img_banner'] : '';
                if(!empty($image) || $image != '')
                {
                    if(file_exists('public/admin/category/'.$image))
                    {
                        unlink('public/admin/category/'.$image);
                    }
                }
                if(!empty($banner) || $banner != '')
                {
                    if(file_exists('public/admin/category/banner/'.$banner))
                    {
                        unlink('public/admin/category/banner/'.$banner);
                    }
                }
            }

             // Delete Category
             Category::whereIn('category_id', $ids)->delete();

             // Delete Category Description
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

        // Insert Category Details
        $catdetail = new CategoryDetail;

        // Insert Category Image
        if ($request->hasFile('image'))
        {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/category'), $imgname);
        }

        // Insert Banner Image
        if ($request->hasFile('banner')) {
            $bannerimgname = time() . "." . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('admin/category/banner'), $bannerimgname);
        }

        $catdetail->image = isset($imgname) ? $imgname : '';
        $catdetail->img_banner = isset($bannerimgname) ? $bannerimgname : '';
        $availibleday = implode(",", $request->availibleday);

        $catdetail->parent_id = isset($request->parent) ? $request->parent : 0;
        $catdetail->top = isset($request->top) ? $request->top : 0;
        $catdetail->column = isset($request->columns) ? $request->columns : 1;
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

        $replaceslug = str_replace(' ','-',$request->category);
        $slug = strtolower($replaceslug);

        $cat->slug = $slug;
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
        $cat->save();

        return redirect()->route('category')->with('success','Category has been Inserted Successfully');
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

        return view('admin.category.categoryedit', ['data' => $data, 'category_layout' => $category_layout]);
    }
}
