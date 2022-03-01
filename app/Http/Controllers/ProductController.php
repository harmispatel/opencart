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
        // Check User Permission
        if(check_user_role(58) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $show_product = Product::join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id')->get();
        return view('admin.product.list', ['show_product' => $show_product]);
    }




    function add()
    {
         // Check User Permission
         if(check_user_role(59) != 1)
         {
             return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
         }

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

         $option = DB::table('oc_option_description')->select('*')->get();

         return view('admin.product.add', ['result' => $result ,'option'=>$option]);
    }

    public function getoptionhtml(Request $request){



        $option = DB::table('oc_option')->where('type',$request->type)->get();
        return response()->json([
            'option' => $option,
        ]);
    }

    public function addOptionValue(Request $request){
        $option_value = DB::table('oc_option_value_description')->where('option_id',$request->optionTypeId)->get();

        return response()->json([
            'option_value' => $option_value,
        ]);
    }


}
