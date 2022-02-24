<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDescription;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function index()
    {
        $manufacturer = DB::table('oc_manufacturer')->select('*')->get();
        $category = DB::table('oc_category_description')->select('*')->get();
        $releted_product = DB::table('oc_product_description')->select('*')->get();
        $product_layout = DB::table('oc_layout')->select('*')->get();
        // $option = DB::table('oc_option')->select('*')->get();
        $stok_status = DB::table('oc_stock_status')->select('*')->get();
        $tex_class = DB::table('oc_tax_class')->select('*')->get();
        $lenght_class = DB::table('oc_length_class_description')->select('*')->get();
        $weight_class = DB::table('oc_weight_class_description')->select('*')->get();
        $result['manufacturer'] = $manufacturer;
        $result['category'] = $category;
        $result['releted_product'] = $releted_product;
        $result['product_layout'] = $product_layout;
        // $result['option'] = $option;
        $result['stok_status'] = $stok_status;
        $result['tex_class'] = $tex_class;
        $result['lenght_class'] = $lenght_class;
        $result['weight_class'] = $weight_class;

        $option = DB::table('oc_option')->select('*')->get();
        // return response()->json([
        //     'posts' => $option,
        // ]);
       

        return view('admin.product.addproduct', ['result' => $result ,'option'=>$option]);
    }
    public function productlist()
    {
        $show_product = Product::join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id')->get();
        return view('admin.product.productlist', ['show_product' => $show_product]);
    }

    public function option(){

        $option = DB::table('oc_option')->select('*')->get();
        return response()->json([
            'option' => $option,
        ]);
    }

    
}
