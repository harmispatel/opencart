<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\Orders;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     return view('admin.login');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $front_store_id= session('front_store_id');
            
        $data['popular_foods'] = OrderProduct::with(['hasOrder','hasOneProduct'])->whereHas('hasOrder',function($query) use ($front_store_id)
        {
            $query->where('store_id',$front_store_id);
        })->groupBy('name')->select('product_id',DB::raw('count(*) as total_product'))->orderBy('total_product','DESC')->limit(20)->get();
        
       

        return view('frontend.pages.home',$data);
    }


}
