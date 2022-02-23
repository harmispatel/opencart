<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function index()
    {
        return view('CategoryList');
    }
    function newcategory()
    {
        $category_layout = DB::table('oc_layout')->select('layout_id','name')->get();
        $parents = DB::table('oc_category_description')->select('category_id','name')->get();

            // echo '<pre>';
            // print_r($category_layout);
            // exit();
        // return view('newcategory');
        return view('newcategory', ['category_layout' => $category_layout,'parents' => $parents]);

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

        $category = Category::where('id',$_POST['id'])->first();

        if(file_exists('public/admin/category/'.$category->image))
        {
            unlink('public/admin/category/'.$category->image);
        }

        $category = Category::where('id',$_POST['id'])->delete();

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

        // echo '<pre>';
        // print_r($_POST);
        // exit();



        $data = DB::table('oc_category_description')->insert([
            'language_id' =>"1",
            'name'=> $request->category,
            'description'=> $request->description,
            'meta_title'=> $request->matatitle,
            'meta_description'=> $request->metadesc,
            'meta_keyword'=> $request->metakey,
        ]);
        $errors = "Insert success";
        return redirect()->back()->withErrors($errors);



    }

    public function categorylayout()
    {
            $category_layout = DB::table('oc_layout')->select('layout_id','name')->get();

            echo '<pre>';
            print_r($category_layout);
            exit();

            // return view('newcategory')->with('category_layout', $category_layout);
            return view('newcategory', ['category_layout' => $category_layout]);
    }
}
