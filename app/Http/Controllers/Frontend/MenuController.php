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
use App\Models\Customer;
use App\Models\ToppingProductPriceSize;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class MenuController extends Controller
{
    public function index()
    {
        $front_store_id = session('front_store_id');
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        // $front_store_id =  $current_theme['store_id'];
        $Coupon =Coupon::select('name','code','discount','date_start','date_end')->where('store_id',$front_store_id)->first();
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


        return view('frontend.pages.menu', ['data' => $data, 'delivery_setting' => $delivery_setting, 'areas'=>$areas,'Coupon'=>$Coupon]);
    }

    public function getid(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $productid = $request->product_id;
        $sizeid = $request->size_id;
        $userid = $request->user_id;
        $loopid = isset($request->loop_id) ? $request->loop_id : '';

        $Coupon =Coupon::select('name','code','discount')->where('store_id',$front_store_id)->first();



        if(!empty($loopid) || $loopid != '')
        {
            if($loopid <= 0)
            {
                if($userid == 0)
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
                    $cart = getuserCart($userid);
                    if($sizeid == 0)
                    {
                        unset($cart['withoutSize'][$productid]);
                    }
                    else
                    {
                        unset($cart['size'][$sizeid]);
                    }
                    $serial = serialize($cart);
                    $base64 = base64_encode($serial);
                    $user_id = $userid;
                    $user = Customer::find($user_id);
                    $user->cart = $base64;
                    $user->update();
                }
            }
            else
            {
                if($userid == 0)
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
                else
                {
                    $cart = getuserCart($userid);
                    if($sizeid == 0)
                    {
                        unset($cart['withoutSize'][$productid]);
                        $serial = serialize($cart);
                        $base64 = base64_encode($serial);
                        $user = Customer::find($userid);
                        $user->cart = $base64;
                        $user->update();
                        for($i=1;$i<=$loopid;$i++)
                        {
                            $newcart = getuserCart($userid);
                            addtoCartUser($request, $productid, $sizeid, $newcart, $userid);
                        }
                    }
                    else
                    {
                        unset($cart['size'][$sizeid]);
                        unset($cart['withoutSize'][$productid]);
                        $serial = serialize($cart);
                        $base64 = base64_encode($serial);
                        $user = Customer::find($userid);
                        $user->cart = $base64;
                        $user->update();
                        for($i=1;$i<=$loopid;$i++)
                        {
                            $newcart = getuserCart($userid);
                            addtoCartUser($request, $productid, $sizeid, $newcart, $userid);
                        }
                    }
                }
            }
        }
        else
        {
            if($userid == 0)
            {
                addtoCart($request, $productid, $sizeid);
            }
            else
            {
                $cart = getuserCart($userid);
                addtoCartUser($request, $productid, $sizeid, $cart, $userid);
            }
        }

        if($userid == 0)
        {
            $mycart = $request->session()->get('cart1');
        }
        else
        {
            $mycart = getuserCart($userid);
        }


        $cart_size = isset($mycart['size']) ? count($mycart['size']) : 0;
        $cart_withoutsize = isset($mycart['withoutSize']) ? count($mycart['withoutSize']) : 0;
        $cart_products = $cart_size + $cart_withoutsize;

        $html = '';
        $subtotal = 0;



        $html .= '<table class="table">';

        if (isset($mycart['size'])) {
            foreach ($mycart['size'] as $key => $cart) {

                $price = $cart['main_price'] * $cart['quantity'];
                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger" onclick="deletecartproduct('.$cart['product_id'].','.$key.','.$userid.')" style="cursor:pointer;"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td>' . $cart['size'] . '</td>';
                $html .= '<td>' . $cart['name'] . '</td>';
                $html .= '<td style="width: 80px;">£ ' . $price . '</td>';
                $html .= '</tr>';
                $subtotal += $price;
                $couponcode=($subtotal*$Coupon->discount)/100;
                $total=$subtotal-$couponcode;

            }


        }
        if (isset($mycart['withoutSize'])) {
            $sizeid = 0;
            foreach ($mycart['withoutSize'] as $cart) {
                $price = $cart['main_price'] * $cart['quantity'];
                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger" onclick="deletecartproduct('.$cart['product_id'].','.$sizeid.','.$userid.')" style="cursor:pointer"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td colspan="2">' . $cart['name'] . '</td>';
                $html .= '<td style="width: 80px;">£ ' . $price . '</td>';
                $html .= '</tr>';
                $subtotal += $price;
                $couponcode=($subtotal*$Coupon->discount)/100;
                $total=$subtotal-$couponcode;

            }


        }


        $html .= '</table>';
        $html2 = '';
        $html3 ='';
        $html4 ='';
        $html2 .= '<label>Sub-Total</label>
        <span>£ '.$subtotal.'</span>';
        $html3 .= '<label>Coupon('.$Coupon->code.')</label>
        <span>£ -' .$couponcode. '</span>';
        $html4 .= '<label><b>Total to pay:</b></label>
        <span>£ '. $total . '</span>';


        $headertotal = 0;
        $headertotal = $subtotal;


        return response()->json([
            'html' => $html,
            'subtotal' => $html2,
            'headertotal' => $headertotal,
            'cart_products' => $cart_products,
            'discount' => $html3,
            'total' => $html4,
            'coupon' =>$Coupon,


        ]);
    }

    public function deletecartproduct(Request $request)
    {
        $productid = $request->product_id;
        $sizeid = $request->size_id;
        $userid = $request->user_id;

        if($userid == 0)
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
            $cart = getuserCart($userid);

            if(isset($cart))
            {
                if($sizeid == 0)
                {
                    unset($cart['withoutSize'][$productid]);
                }
                else
                {
                    unset($cart['size'][$sizeid]);
                }
            }

            $serial = serialize($cart);
            $base64 = base64_encode($serial);
            $user_id = $userid;
            $user = Customer::find($user_id);
            $user->cart = $base64;
            $user->update();

        }

        return response()->json([
            'success' => 1,
        ]);

    }


    public function setDeliveyType(Request $request)
    {
        $d_type = $request->d_type;

        // Check User ID
        if(session()->has('userid'))
        {
            $userid = session()->get('userid');
        }
        else
        {
            $userid = 0;
        }

        // Guest User
        if($userid == 0)
        {
            if(session()->has('cart1'))
            {
                $cart = session()->get('cart1');

                if(!empty($cart) || isset($cart))
                {
                    // For Delivery Price
                    if($d_type == 'delivery')
                    {
                        if(isset($cart['size']) && !empty($cart['size']))
                        {
                            foreach ($cart['size'] as $key => $value)
                            {
                                $size_id = $key;
                                $prod = ToppingProductPriceSize::where('id_product_price_size',$size_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $cart['size'][$key]['del_price'] = $del_price;
                                session()->put('cart1',$cart);
                            }
                        }

                        if(isset($cart['withoutSize']) && !empty($cart['withoutSize']))
                        {
                            foreach ($cart['withoutSize'] as $key => $value)
                            {
                                $prod_id = $key;
                                $prod = Product::where('product_id',$prod_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $cart['withoutSize'][$key]['del_price'] = $del_price;
                                session()->put('cart1',$cart);
                            }
                        }
                    }
                }
            }
        }
        else
        {
            if(!empty($userid))
            {
                $customer_cart = getuserCart($userid);

                if(isset($customer_cart) && !empty($customer_cart))
                {
                    // For Delivery Price
                    if($d_type == 'delivery')
                    {
                        if(isset($customer_cart['size']) && !empty($customer_cart['size']))
                        {
                            foreach ($customer_cart['size'] as $key => $value)
                            {
                                $size_id = $key;
                                $prod = ToppingProductPriceSize::where('id_product_price_size',$size_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $customer_cart['size'][$key]['del_price'] = $del_price;

                                $serial = serialize($customer_cart);
                                $base64 = base64_encode($serial);
                                $user = Customer::find($userid);
                                $user->cart = $base64;
                                $user->update();
                            }
                        }

                        if(isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize']))
                        {
                            foreach ($customer_cart['withoutSize'] as $key => $value)
                            {
                                $prod_id = $key;
                                $prod = Product::where('product_id',$prod_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $customer_cart['withoutSize'][$key]['del_price'] = $del_price;

                                $serial = serialize($customer_cart);
                                $base64 = base64_encode($serial);
                                $user = Customer::find($userid);
                                $user->cart = $base64;
                                $user->update();
                            }
                        }
                    }
                }
            }
        }


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
