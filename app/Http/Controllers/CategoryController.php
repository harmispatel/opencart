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
        return view('newcategory');
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

    function categoryAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
        ]);


        $slug = $request->slug;
        $data = Category::select('slug')->where('slug',$slug)->first();

        if(!empty($data))
        {
            return response()->json([
                'success' => 2,
            ]);
        }
        else
        {
            $data = new Category;
            $data->name = $request['name'];
            $data->slug = $request['slug'];

            if($request->hasFile('image'))
            {
                $name = time().'.'.$request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('admin/category'),$name);
                $data->image = $name;
            }

            $data->save();

            return response()->json([
                'success' => 1,
            ]);
        }

    }
}
