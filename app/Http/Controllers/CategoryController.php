<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\CategoryDetail;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function index()
    {
        // $fetchparent = DB::table('oc_category_description')->select('category_id','name')->get();


        $fetchparent = CategoryDetail::where('oc_category.parent_id','=',0)->where('oc_category.top','=',1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

            // $leagues = DB::table('oc_category')
            // ->select('')
            // ->join('oc_category_description', 'countries.country_id', '=', 'leagues.country_id')
            // ->where('countries.country_name')
            // ->get();


        return view('admin.category.CategoryList', ['fetchparent' => $fetchparent]);
    }
    function newcategory()
    {
        $category_layout = DB::table('oc_layout')->select('layout_id', 'name')->get();
        $fetchparent = DB::table('oc_category_description')->select('category_id', 'name')->get();


        // $fetchparent = CategoryDetail::all('parent_id');
        // $fetchparent = CategoryDetail::select('oc_category_description.*,oc_category.*')
        // ->from('oc_category')
        // ->leftJoin('oc_category_description', 'oc_category_description.name', '=', 'oc_category.parent_id')
        // ->get();


        // echo '<pre>';
        // print_r($fetchparent);
        // exit();
        // return view('newcategory');


        return view('admin.category.newcategory', ['category_layout' => $category_layout, 'parents' => $fetchparent]);
    }

    function getcategory()
    {
        // $categories = Category::get();
        // $categories = DB::table('oc_category')
        //     ->join('oc_category', 'users.id', '=', 'contacts.user_id')
        //     ->join('orders', 'users.id', '=', 'orders.user_id')
        //     ->select('users.*', 'contacts.phone', 'orders.price')
        //     ->get();
    }

    function deleteCategory()
    {

        $category = Category::where('id', $_POST['id'])->first();

        if (file_exists('public/admin/category/' . $category->image)) {
            unlink('public/admin/category/' . $category->image);
        }

        $category = Category::where('id', $_POST['id'])->delete();

        return response()->json([
            'success' => 1,
        ]);
    }

    function categoryinsert(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'matatitle' => 'required',
        ]);

        $catdetail = new CategoryDetail;
        if ($request->hasFile('image')) {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/image/'), $imgname);
            $catdetail->image = $imgname;
        }
        $catdetail->parent_id = $request->top;
        $catdetail->top = $request->top;
        $catdetail->column = $request->columns;
        $catdetail->sort_order = $request->sortorder;
        $catdetail->status = $request->status;
        $catdetail->save();


        $cat = new Category;
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = $request->description;
        $cat->meta_title = $request->matatitle;
        $cat->meta_description = $request->metadesc;
        $cat->meta_keyword = $request->metakey;

        $cat->save();

        // $data = DB::table('oc_category_description')->insert([
        //     'language_id' =>"1",
        //     'name'=> $request->category,
        //     'description'=> $request->description,
        //     'meta_title'=> $request->matatitle,
        //     'meta_description'=> $request->metadesc,
        //     'meta_keyword'=> $request->metakey,
        // ]);
        // $errors = "Insert success";
        // return redirect()->back()->withErrors($errors);



    }

    public function categorylayout()
    {
        $category_layout = DB::table('oc_layout')->select('layout_id', 'name')->get();

        echo '<pre>';
        print_r($category_layout);
        exit();

        // return view('newcategory')->with('category_layout', $category_layout);
        return view('newcategory', ['category_layout' => $category_layout]);
    }
}
