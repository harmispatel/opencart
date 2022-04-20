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

        $data['popular_foods'] = OrderProduct::with(['hasOrder','hasOneProduct'])->whereHas('hasOrder',function($query) use ($front_store_id)
        {
            $query->where('store_id',$front_store_id);
        })->groupBy('name')->select('product_id', DB::raw('count(*) as total_product'))->orderBy('total_product','DESC')->limit($limit)->get();


        return view('frontend.pages.home',$data);
    }


}
