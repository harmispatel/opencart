<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\Users;
use App\Models\Product;
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
        $customers = Customer::count();
        $product = Product::count();
        $categories = Category::count();
        $orders = Orders::count();

        return view('dashboard',['customers'=>$customers,'orders'=>$orders,'product'=>$product,'categories'=>$categories]);

    }
}
