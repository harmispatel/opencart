<?php

namespace App\Http\Controllers;

use App\Models\ProductIcons;
use Illuminate\Http\Request;

class ProductIconsController extends Controller
{

    public function index()
    {
        return view('admin.producticons.list');
    }


    public function create()
    {
        //
    }


}
