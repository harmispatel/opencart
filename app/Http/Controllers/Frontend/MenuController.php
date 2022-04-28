<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategorytoStore;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;

class MenuController extends Controller
{
    public function index()
    {
        $front_store_id= session('front_store_id');

        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->get();

        $data['category'] =$category;

        $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        $delivery_setting = [];

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }

        return view('frontend.pages.menu',['data'=>$data,'delivery_setting'=>$delivery_setting]);
    }

    public function setDeliveyType(Request $request)
    {
        $d_type = $request->d_type;

        session()->put('user_delivery_type',$d_type);

        return response()->json([
            'success' => 1,
        ]);

    }

    public function store(Request $request){

        echo '<pre>';
        $description = $request->input('description');
        $productname = $request->input('productname');
        $image = $request->input('image');
        $size = $request->input('size');
        $price = $request->input('price');
        $size1 = $request->input('size1');
        $price1 = $request->input('price1');

        // $description = $request->input('description');
        print_r($description);echo "<br>";
        print_r($productname);echo "<br>";
        print_r($image);echo "<br>";
        print_r($size);echo "<br>";
        print_r($price);echo "<br>";
        print_r($size1);echo "<br>";
        print_r($price1);echo "<br>";
        exit();
        return $request->all();
    }

}
