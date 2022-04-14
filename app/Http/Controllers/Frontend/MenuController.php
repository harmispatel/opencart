<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategorytoStore;
use App\Models\Product;
use App\Models\Product_to_category;




class MenuController extends Controller
{
    public function index()
    {
        $front_store_id= session('front_store_id');
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->get();
        $data['category'] =$category;
        return view('frontend.pages.menu',['data'=>$data]);
    }

}
