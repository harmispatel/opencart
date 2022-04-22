<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Gallary;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\Product_to_category;
use DB;

class HomeController extends Controller
{

    public function index()
    {
        $front_store_id= session('front_store_id');
        $current_theme_id = session('theme_id');

        $template_setting = session('template_settings');

        $limit =  isset($template_setting['polianna_popular_food_count']) ? $template_setting['polianna_popular_food_count'] : 1;

        $data['photos'] = Gallary::where('store_id',$front_store_id)->get();

        // $data['best_category'] = OrderProduct::with(['hasOrder','hasOneProduct','hasOneCategorytoProduct'])->whereHas('hasOrder',function($query) use ($front_store_id)
        // {
        //     $query->where('store_id',$front_store_id);
        // })->limit(2)->get()->toArray();

        $data['best_categories'] = Product_to_category::with(['hasManyOrders','hasOneCategoryDetails'])->select('category_id','product_id', DB::raw('count(*) as total_category'))->whereHas('hasOneCategoryDetails',function ($q) use ($front_store_id)
        {
            $q->whereHas('hasManyCategoryStore',function ($q1) use ($front_store_id)
            {
                $q1->where('store_id',$front_store_id);
            });
        })->groupBy('category_id')->limit(5)->get()->sortByDesc(function($query)
        {
            return $query->hasManyOrders->count();
        });

        // echo '<pre>';
        // print_r($data['best_categories']);
        // exit();

        $data['popular_foods'] = OrderProduct::with(['hasOrder','hasOneProduct'])->whereHas('hasOrder',function($query) use ($front_store_id)
        {
            $query->where('store_id',$front_store_id);
        })->groupBy('name')->select('product_id', DB::raw('count(*) as total_product'))->orderBy('total_product','DESC')->limit($limit)->get();


        return view('frontend.pages.home',$data);
    }


}
