<?php

namespace App\Http\Controllers;

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
        $data['users'] = Users::get();
        $data['product'] = Product::get();

        return view('dashboard',$data);

    }
}
