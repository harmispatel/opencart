<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategorytoStore;
use App\Models\Coupon;
use App\Models\DeliverySettings;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
use App\Models\ToppingSize;
use App\Models\CouponProduct;
use App\Models\ToppingProductPriceSize;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class MenuController extends Controller
{
    public function index()
    {
        $front_store_id = session('front_store_id');

        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->get();

        $data['category'] = $category;

        $get_areas = DeliverySettings::select('area','id_delivery_settings')->where('id_store',$front_store_id)->where('delivery_type','area')->first();
        $area_explode = explode(',',isset($get_areas->area) ? $get_areas->area : '');
        $areas = array_filter($area_explode);

        $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        $delivery_setting = [];

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }


        return view('frontend.pages.menu', ['data' => $data, 'delivery_setting' => $delivery_setting, 'areas'=>$areas]);
    }

    public function getid(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $productid = $request->product_id;
        $sizeid = $request->size_id;
        $loopid = isset($request->loop_id) ? $request->loop_id : '';


        if(!empty($loopid) || $loopid != '')
        {
            if($loopid <= 0)
            {
                if($sizeid == 0)
                {
                    session()->forget('cart1.withoutSize.'.$productid);
                }
                else
                {
                    session()->forget('cart1.size.'.$sizeid);
                }
            }
            else
            {
                if($sizeid == 0)
                {
                    session()->forget('cart1.withoutSize.'.$productid);
                    for($i=1;$i<=$loopid;$i++)
                    {
                        addtoCart($request, $productid, $sizeid);
                    }
                }
                else
                {
                    session()->forget('cart1.size.'.$sizeid);
                    for($i=1;$i<=$loopid;$i++)
                    {
                        addtoCart($request, $productid, $sizeid);
                    }
                }
            }
        }
        else
        {
            addtoCart($request, $productid, $sizeid);
        }


        $mycart = $request->session()->get('cart1');

        $cart_size = isset($mycart['size']) ? count($mycart['size']) : 0;
        $cart_withoutsize = isset($mycart['withoutSize']) ? count($mycart['withoutSize']) : 0;
        $cart_products = $cart_size + $cart_withoutsize;

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
        $html3 = '';
        $html2 .= '<label>Sub-Total</label>
        <span>£ ' . $subtotal . '</span>';


        $headertotal = 0;
        $headertotal = $subtotal;


        return response()->json([
            'html' => $html,
            'subtotal' => $html2,
            'headertotal' => $headertotal,
            'cart_products' => $cart_products,
        ]);
    }

    public function deletecartproduct(Request $request)
    {
        $productid = $request->product_id;
        $sizeid = $request->size_id;

        if($sizeid == 0)
        {
            session()->forget('cart1.withoutSize.'.$productid);
        }
        else
        {
            session()->forget('cart1.size.'.$sizeid);
        }

        return response()->json([
            'success' => 1,
        ]);

    }


    public function setDeliveyType(Request $request)
    {
        $d_type = $request->d_type;

        session()->put('flag_post_code', $d_type);

        return response()->json([
            'success' => 1,
        ]);
    }

    public function store(Request $request)
    {

        return $request->all();
    }

}
