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
        $releted_product=DB::table('oc_product_description')->select('*')->get();
        $product_layout=DB::table('oc_layout')->select('*')->get();
        $option =DB::table('oc_option')->select('*')->get();

        $result['manufacturer'] = $manufacturer;
        $result['category'] = $category;
        $result['releted_product'] = $releted_product;
        $result['product_layout'] = $product_layout;
        $result['option']=$option;

        return view('admin.product.addproduct',['result'=>$result]);
    }
    public function productlist(){
        
        return view('admin.product.productlist');
    }

    
}
