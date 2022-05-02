<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategorytoStore;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
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

        $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        $delivery_setting = [];

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }


        return view('frontend.pages.menu', ['data' => $data, 'delivery_setting' => $delivery_setting]);
    }

    public function getid(Request $request)
    {
        $productid = $request->product_id;
        $sizeid = $request->size_id;
        // session()->forget('cart1');
        // exit;


        addtoCart($request, $productid, $sizeid);

        $mycart = $request->session()->get('cart1');
        // echo "<pre>";
        // print_r($mycart);
        // exit;
        $html = '';
        $subtotal = 0;

        $html .= '<table class="table">';

        if (isset($mycart['size'])) {
            foreach ($mycart['size'] as $cart) {
               
                $price = $cart['price'] * $cart['quantity'];
                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td>' . $cart['size'] . '</td>';
                $html .= '<td>' . $cart['name'] . '</td>';
                $html .= '<td style="width: 80px;">£ ' . $price . '</td>';
                $html .= '</tr>';
                $subtotal += $price;
            }
        }
        if (isset($mycart['withoutSize'])) {
            foreach ($mycart['withoutSize'] as $cart) {
                $price = $cart['price'] * $cart['quantity'];
                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td colspan="2">' . $cart['name'] . '</td>';
                $html .= '<td style="width: 80px;">£ ' . $price . '</td>';
                $html .= '</tr>';
                $subtotal += $price;
            }
        }

        $html .= '</table>';
        $html2 = '';
        $html2 .= '<label>Sub-Total</label>
        <span>£ ' . $subtotal . '</span>';

        return response()->json([
            'html' => $html,
            'subtotal' => $html2,
        ]);
    }
    public function setDeliveyType(Request $request)
    {
        $d_type = $request->d_type;

        session()->put('user_delivery_type', $d_type);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function store(Request $request)
    {

        return $request->all();
    }
}
