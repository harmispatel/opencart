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
use App\Models\Settings;
use DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{

    public function index()
    {
        // $front_store_id= session('front_store_id');
        // $current_theme_id = session('theme_id');
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $food_limit_setting = Settings::select('value')->where('store_id',$front_store_id)->where('theme_id',$current_theme_id)->where('key','polianna_popular_food_count')->first();
        $food_limit =  isset($food_limit_setting['value']) ? $food_limit_setting['value'] : 1;

        $cat_limit_setting = Settings::select('value')->where('store_id',$front_store_id)->where('theme_id',$current_theme_id)->where('key','polianna_best_category_count')->first();
        $cat_limit = isset($cat_limit_setting['value']) ? $cat_limit_setting['value'] : 1;


        $data['photos'] = Gallary::where('store_id',$front_store_id)->get();
         
        $data['best_categories'] = Product_to_category::with(['hasManyOrders','hasOneCategoryDetails'])->select('category_id','product_id', DB::raw('count(*) as total_category'))->whereHas('hasOneCategoryDetails',function ($q) use ($front_store_id)
        {
            $q->whereHas('hasManyCategoryStore',function ($q1) use ($front_store_id)
            {
                $q1->where('store_id',$front_store_id);
            });
        })->groupBy('category_id')->limit($cat_limit)->get()->sortByDesc(function($query)
        {
            return $query->hasManyOrders->count();
        });

        $data['popular_foods'] = OrderProduct::with(['hasOrder','hasOneProduct'])->whereHas('hasOrder',function($query) use ($front_store_id)
        {
            $query->where('store_id',$front_store_id);
        })->groupBy('name')->select('product_id', DB::raw('count(*) as total_product'))->orderBy('total_product','DESC')->limit($food_limit)->get();


        return view('frontend.pages.home',$data);
    }


}
