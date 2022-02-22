<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    function index()
    {
        
        $manufacturer=DB::table('oc_manufacturer')->select('*')->get();
        $category=DB::table('oc_category_description')->select('*')->get();
        // $releted_product=DB::table('oc_product_description')->select('*')->get();

        $result['manufacturer'] = $manufacturer;
        $result['category'] = $category;
        // $result['reletedproduct'] = $releted_product;

        return view('product',['result'=>$result]);
    }

    
}
