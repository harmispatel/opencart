<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\Users;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return view('admin.login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('home');
    }


    function adminLogin()
    {
        return view('admin.login');
    }


    public function adminHome()
    {
        // current store id
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        if($user_group_id == 1)
        {
            if($current_store_id == 0)
            {
                $customers = Customer::count();
                $product = Product::count();
                $categories = Category::count();
                $orders = Orders::count();
            }
            else
            {
                $customers = Customer::where('store_id',$current_store_id)->count();
                $product = Product::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore',function($q) use($current_store_id)
                {
                    $q->where('store_id',$current_store_id);
                })->count();
                $categories = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore',function($q) use($current_store_id)
                {
                    $q->where('store_id',$current_store_id);
                })->count();
                $orders = Orders::where('store_id',$current_store_id)->count();
            }
        }
        else
        {

            $customers = Customer::where('store_id',$user_shop_id)->count();
            $product = Product::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore',function($q) use($user_shop_id)
            {
                $q->where('store_id',$user_shop_id);
            })->count();
            $categories = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore',function($q) use($user_shop_id)
            {
                $q->where('store_id',$user_shop_id);
            })->count();
            $orders = Orders::where('store_id',$user_shop_id)->count();
        }


        return view('dashboard',['customers'=>$customers,'orders'=>$orders,'product'=>$product,'categories'=>$categories]);

    }

    function setStore(Request $request)
    {
        $storeId = $request->store_id;
        if($request->session()->has('store_id'))
        {
            $request->session()->forget('store_id');
            $request->session()->put('store_id', $storeId);
        }
        else
        {
            $request->session()->put('store_id', $storeId);
        }

        return response()->json([
            'success' => 1
        ]);
    }


}
