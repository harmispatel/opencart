<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategorytoStore;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\ToppingSize;
use App\Models\ToppingProductPriceSize;
use Illuminate\Support\Facades\Session;    
class MenuController extends Controller
{
    public function index()
    {
        $front_store_id = session('front_store_id');

        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->get();

        $data['category'] = $category;

        return view('frontend.pages.menu', ['data' => $data]);
    }

    public function getid(Request $request)
    {
        $productid = $request->product_id;
        $sizeid = $request->size_id;
        // session()->forget('cart1');
        // exit;
        
        addtoCart($request,$productid,$sizeid);

        $new = $request->session()->get('cart1');

        echo '<pre>';
        print_r( $new );
        exit();

    }
}
