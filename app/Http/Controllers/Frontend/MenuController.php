<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\CategorytoStore;
use App\Models\Coupon;
use App\Models\DeliverySettings;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
use App\Models\ToppingSize;
use App\Models\CouponProduct;
use App\Models\Customer;
use App\Models\ProductDescription;
use App\Models\ToppingProductPriceSize;
use App\Models\ToppingCatOption;
use App\Models\Topping;
use App\Models\ToppingOption;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class MenuController extends Controller
{
    // Function For Show Menu Page
    public function index()
    {
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        $current_date = strtotime(date('Y-m-d'));
        $Coupon = '';

        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();

            if (!empty($get_coupon) || $get_coupon != '') {
                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

                if ($current_date >= $start_date && $current_date < $end_date) {
                    $Coupon = $get_coupon;
                } else {
                    $Coupon = '';
                }
            }
        }

        $category = CategoryDetail::with(['hasManyCategoryStore','hasOneCategory'])->whereHas('hasManyCategoryStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->orderBy('sort_order', 'ASC')->get();

        $data['category'] = $category;

        $get_areas = DeliverySettings::select('area', 'id_delivery_settings')->where('id_store', $front_store_id)->where('delivery_type', 'area')->first();
        $area_explode = explode(',', isset($get_areas->area) ? $get_areas->area : '');
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


        return view('frontend.pages.menu', ['data' => $data, 'delivery_setting' => $delivery_setting, 'areas' => $areas, 'Coupon' => $Coupon]);
    }




    // Function For Add To Cart
    public function addToCart(Request $request)
    {

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        // Get Currency Details
        $currency = getCurrencySymbol($store_setting['config_currency']);

        $productid = $request->product_id;
        $pro_name = ProductDescription::where('product_id', $productid)->first();
        $cat_id = Product_to_category::where('product_id', $productid)->first();
        $toppingType = ToppingCatOption::where('id_category', $cat_id->category_id)->first();
        $group = unserialize(isset($toppingType->group) ? $toppingType->group : '');
        unset($group['number_group']);


        $sizeid = $request->size_id;
        $userid = $request->user_id;
        $loopid = isset($request->loop_id) ? $request->loop_id : '';

        $current_date = strtotime(date('Y-m-d'));

        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();

            if (!empty($get_coupon) || $get_coupon != '') {
                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

                if ($current_date >= $start_date && $current_date < $end_date) {
                    $Coupon = $get_coupon;
                } else {
                    $Coupon = '';
                }
            }
            else {
                $Coupon = '';
            }
        }

        if (!empty($loopid) || $loopid != '') {
            if ($loopid <= 0) {
                return response()->json([
                    'required_1' => 1,
                ]);
            } else {
                if ($loopid <= 50) {
                    if ($userid == 0) {
                        if ($sizeid == 0) {
                            session()->forget('cart1.withoutSize.' . $productid);
                            for ($i = 1; $i <= $loopid; $i++) {
                                addtoCart($request, $productid, $sizeid);
                            }
                        } else {
                            session()->forget('cart1.size.' . $sizeid);
                            for ($i = 1; $i <= $loopid; $i++) {
                                addtoCart($request, $productid, $sizeid);
                            }
                        }
                    } else {
                        $cart = getuserCart($userid);
                        if ($sizeid == 0) {
                            unset($cart['withoutSize'][$productid]);
                            $serial = serialize($cart);
                            $base64 = base64_encode($serial);
                            $user = Customer::find($userid);
                            $user->cart = $base64;
                            $user->update();
                            for ($i = 1; $i <= $loopid; $i++) {
                                $newcart = getuserCart($userid);
                                addtoCartUser($request, $productid, $sizeid, $newcart, $userid);
                            }
                        } else {
                            unset($cart['size'][$sizeid]);
                            unset($cart['withoutSize'][$productid]);
                            $serial = serialize($cart);
                            $base64 = base64_encode($serial);
                            $user = Customer::find($userid);
                            $user->cart = $base64;
                            $user->update();
                            for ($i = 1; $i <= $loopid; $i++) {
                                $newcart = getuserCart($userid);
                                addtoCartUser($request, $productid, $sizeid, $newcart, $userid);
                            }
                        }
                    }
                } else {
                    return response()->json([
                        'max_limit' => 1,
                    ]);
                }
            }
        } else {
            if ($userid == 0) {
                addtoCart($request, $productid, $sizeid);
            } else {
                $cart = getuserCart($userid);
                addtoCartUser($request, $productid, $sizeid, $cart, $userid);
            }
        }

        if ($userid == 0) {
            $mycart = $request->session()->get('cart1');
        } else {
            $mycart = getuserCart($userid);
        }



        $html = '';
        $subtotal = 0;
        $delivery_charge = 0;
        $cart_products = 0;


        $html .= '<table class="table">';

        if (isset($mycart['size'])) {
            foreach ($mycart['size'] as $key => $cart) {
                $price = $cart['main_price'] * $cart['quantity'];
                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger" onclick="deletecartproduct(' . $cart['product_id'] . ',' . $key . ',' . $userid . ')" style="cursor:pointer;"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td>' . $cart['size'] . '</td>';
                $html .= '<td>' . $cart['name'] . '</td>';
                $html .= '<td style="width: 80px;">'.$currency.' '.$price.'</td>';
                $html .= '</tr>';

                // Delivery Charge
                $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;

                // Sub Total
                $subtotal += $price;

                // Header Count
                $cart_products += $cart['quantity'];
            }
        }

        if (isset($mycart['withoutSize'])) {
            $sizeid = 0;
            foreach ($mycart['withoutSize'] as $cart) {
                $price = $cart['main_price'] * $cart['quantity'];
                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger" onclick="deletecartproduct(' . $cart['product_id'] . ',' . $sizeid . ',' . $userid . ')" style="cursor:pointer"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td colspan="2">' . $cart['name'] . '</td>';
                $html .= '<td style="width: 80px;">'.$currency.' '. $price . '</td>';
                $html .= '</tr>';

                // Delivery Charge
                $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;

                // Subtotal
                $subtotal += $price;

                // Header Count
                $cart_products += $cart['quantity'];
            }
        }
        $html .= '</table>';


        $coupon_html = '';

        // Coupon Code
        if (!empty($Coupon) || $Coupon != '') {
            if ($Coupon['type'] == 'P') {
                $couponcode = ($subtotal * $Coupon['discount']) / 100;
            }
            if ($Coupon['type'] == 'F') {
                $couponcode =  $Coupon['discount'];
            }
            $coupon_html .= '<label>Coupon(' . $Coupon['code'] . ')</label><span> -'.$currency.' '.number_format($couponcode, 2) . '</span>';
            // Main Total
            $total = $subtotal - $couponcode + $delivery_charge;
        } else {
            $total = $subtotal + $delivery_charge;
        }

        $sessiontotal = session()->put('total',$total);
        $sessionsubtotal = session()->put('subtotal',$subtotal);
        $sessioncouponcode = session()->put('couponcode',isset($couponcode) ? $couponcode : '');
        $sessioncouponname = session()->put('couponname',isset($Coupon['code']) ? $Coupon['code'] : '');
        $sessioncurrency = session()->put('currency',$store_setting['config_currency']);
        $sessiondelivery_charge = session()->put('delivery_charge',$delivery_charge);

        $subtotl_html = '';
        $deliverycharge_html = '';
        $headertotal = 0;
        $total_html = '';

        $subtotl_html .= '<label>Sub-Total</label><span>'.$currency.' '.$subtotal . '</span>';
        $deliverycharge_html .= '<label><b>Delivery Charge:</b></label><span>'.$currency.' '.$delivery_charge . '</span>';
        $total_html .= '<label><b>Total to pay:</b></label><span>'.$currency.' '. $total . '</span>';
        $headertotal += $total;

        return response()->json([
            'html' => $html,
            'subtotal' => $subtotl_html,
            'delivery_charge' => $deliverycharge_html,
            'cart_products' => $cart_products,
            'headertotal' => number_format($headertotal, 2),
            'total' => $total_html,
            'couponcode' => $coupon_html,
            // 'modal' => $modal,
        ]);
    }




    // Function For Delete Cart Product
    public function deletecartproduct(Request $request)
    {
        $productid = $request->product_id;
        $sizeid = $request->size_id;
        $userid = $request->user_id;

        if ($userid == 0) {
            if ($sizeid == 0) {
                session()->forget('cart1.withoutSize.' . $productid);
            } else {
                session()->forget('cart1.size.' . $sizeid);
            }
        } else {
            $cart = getuserCart($userid);

            if (isset($cart)) {
                if ($sizeid == 0) {
                    unset($cart['withoutSize'][$productid]);
                } else {
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



    // Function For Get Coupon Code
    public function getcoupon(Request $request)
    {
       // Get Current URL
       $currentURL = URL::to("/");

       // Get Store Settings & Other Settings
       $store_data = frontStoreID($currentURL);

       // Get Current Front Store ID
       $front_store_id =  $store_data['store_id'];

       // Store Settings
       $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

       // Get Currency Details
       $currency = getCurrencySymbol($store_setting['config_currency']);

        // cash on delevery setting
        $servicecharge = paymentdetails();
        $stripe_charge = $servicecharge["stripe"]["stripe_charge_payment"] ? $servicecharge["stripe"]["stripe_charge_payment"] : '0.00';
        $paypal_charge = $servicecharge["paypal"]["pp_charge_payment"] ? $servicecharge["paypal"]["pp_charge_payment"] : '0.00';
        $cod_charge = $servicecharge["cod"]["cod_charge_payment"] ? $servicecharge["cod"]["cod_charge_payment"] : '0.00';

        $current_date = strtotime(date('Y-m-d'));

        if (session()->has('userid')) {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }



        $Coupon = $request->coupon;
        $Couponcode = coupon::where('code', $Coupon)->where('store_id', $front_store_id)->first();

        if (!empty($Couponcode) || $Couponcode != '') // Valid Coupon
        {
            if ($Couponcode->on_off == 1) {
                if ($request->total >= $Couponcode->total) {
                    $start_date = isset($Couponcode->date_start) ? strtotime($Couponcode->date_start) : '';
                    $end_date = isset($Couponcode->date_end) ? strtotime($Couponcode->date_end) : '';

                    if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                    {
                        $code = $Couponcode->toArray();
                        session()->put('currentcoupon', $code);
                        session()->save();

                        if ($userid == 0) {
                            $mycart = $request->session()->get('cart1');
                        } else {
                            $mycart = getuserCart($userid);
                        }

                        $subtotal = 0;
                        $delivery_charge = 0;

                        if (isset($mycart['size']) || !empty($mycart['size'])) {
                            foreach ($mycart['size'] as $key => $cart) {
                                $price = $cart['main_price'] * $cart['quantity'];
                                $subtotal += $price;
                                $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                            }
                        }

                        if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                            foreach ($mycart['withoutSize'] as $key => $cart) {
                                $price = $cart['main_price'] * $cart['quantity'];
                                $subtotal += $price;
                                $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                            }
                        }

                        if ($Couponcode->type == 'P') {
                            $couponcode = ($subtotal * $Couponcode->discount) / 100;
                        }
                        if ($Couponcode->type == 'F') {
                            $couponcode = $Couponcode->discount;
                        }

                        $total = $subtotal - $couponcode + $delivery_charge;

                        $total_html = '';
                        $couponcode_html = '';
                        $success_message = '';

                        $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                        // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                        $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>'.$currency.' -' . round($couponcode,2) . '</b></span></td></tr>';
                        // $total_html .= '<label><b>Total to pay:</b></label><span><b id="total_pay">'. $currency . ' . $total . '</b></span>';
                        if ($request->method_type == 1) {
                            $total_html .= '<tr class="total"><td><b>Total to pay:</b></td><td><span><b id="total_pay">'.$currency.' ' . round($total+$stripe_charge ,2) . '</b></span></td></tr>';
                        }
                        elseif ($request->method_type == 2) {
                            $total_html .= '<tr class="total"><td><b>Total to pay:</b></td><td><span><b id="total_pay">'.$currency.' ' . round($total+$paypal_charge, 2) . '</b></span></td></tr>';
                        }
                        elseif ($request->method_type == 3) {
                            $total_html .= '<tr class="total"><td><b>Total to pay:</b></td><td><span><b id="total_pay">'.$currency.' ' . round($total+$cod_charge, 2) . '</b></span></td></tr>';
                        }
                        else{
                            $total_html .= '<tr class="total"><td><b>Total to pay:</b></td><td><span><b id="total_pay">'.$currency.' ' . round($total,2) . '</b></span></td></tr>';
                        }

                        return response()->json([
                            'success' => 1,
                            'success_message' => $success_message,
                            'couponcode' => $couponcode_html,
                            'total' => $total_html,
                            'headertotal' => number_format($total,2),
                        ]);
                    } else // Expired Coupon
                    {
                        $error_msg = '';
                        $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                        return response()->json([
                            'errors' => 1,
                            'errors_message' => $error_msg,
                        ]);
                    }
                }
                else{
                    $error_msg = '';
                    $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                    return response()->json([
                        'errors' => 1,
                        'errors_message' => $error_msg,
                    ]);
                }
            } else {
                $error_msg = '';
                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                return response()->json([
                    'errors' => 1,
                    'errors_message' => $error_msg,
                ]);
            }
        }
        else // Invalid Coupon
        {
            $error_msg = '';
            $error_msg .= '<span class="text-danger">Please enter valid Coupon Code</span>';
            return response()->json([
                'errors' => 1,
                'errors_message' => $error_msg,
            ]);
        }
    }




    // Function For  Set Delivery Type
    public function setDeliveyType(Request $request)
    {

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        // $Coupon = Coupon::where('store_id', $front_store_id)->first();

        $current_date = strtotime(date('Y-m-d'));

        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();

            if (!empty($get_coupon) || $get_coupon != '') {
                // $start_date = strtotime($get_coupon->date_start);
                // $end_date = strtotime($get_coupon->date_end);

                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

                if ($current_date >= $start_date && $current_date < $end_date) {
                    $Coupon = $get_coupon;
                } else {
                    $Coupon = '';
                }
            }
            else {
                $Coupon = '';
            }
        }

        $d_type = $request->d_type;


        // Check User ID
        if (session()->has('userid')) {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }

        // Guest User
        if ($userid == 0) {
            if (session()->has('cart1')) {
                $cart = session()->get('cart1');

                if (!empty($cart) || isset($cart)) {
                    // For Delivery Price
                    if ($d_type == 'delivery') {
                        if (isset($cart['size']) && !empty($cart['size'])) {
                            foreach ($cart['size'] as $key => $value) {
                                $size_id = $key;
                                $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $cart['size'][$key]['del_price'] = $del_price;
                                session()->put('cart1', $cart);
                            }
                        }

                        if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                            foreach ($cart['withoutSize'] as $key => $value) {
                                $prod_id = $key;
                                $prod = Product::where('product_id', $prod_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $cart['withoutSize'][$key]['del_price'] = $del_price;
                                session()->put('cart1', $cart);
                            }
                        }
                    } else {
                        if (isset($cart['size']) && !empty($cart['size'])) {
                            foreach ($cart['size'] as $key => $value) {
                                $cart['size'][$key]['del_price'] = 0.00;
                                session()->put('cart1', $cart);
                            }
                        }

                        if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                            foreach ($cart['withoutSize'] as $key => $value) {
                                $cart['withoutSize'][$key]['del_price'] = 0.00;
                                session()->put('cart1', $cart);
                            }
                        }
                    }
                }
            }
        } else {
            if (!empty($userid)) {
                $customer_cart = getuserCart($userid);

                if (isset($customer_cart) && !empty($customer_cart)) {
                    // For Delivery Price
                    if ($d_type == 'delivery') {
                        if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                            foreach ($customer_cart['size'] as $key => $value) {
                                $size_id = $key;
                                $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $customer_cart['size'][$key]['del_price'] = $del_price;

                                $serial = serialize($customer_cart);
                                $base64 = base64_encode($serial);
                                $user = Customer::find($userid);
                                $user->cart = $base64;
                                $user->update();
                            }
                        }

                        if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                            foreach ($customer_cart['withoutSize'] as $key => $value) {
                                $prod_id = $key;
                                $prod = Product::where('product_id', $prod_id)->first();
                                $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                $customer_cart['withoutSize'][$key]['del_price'] = $del_price;

                                $serial = serialize($customer_cart);
                                $base64 = base64_encode($serial);
                                $user = Customer::find($userid);
                                $user->cart = $base64;
                                $user->update();
                            }
                        }
                    } else {
                        if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                            foreach ($customer_cart['size'] as $key => $value) {
                                $customer_cart['size'][$key]['del_price'] = 0.00;

                                $serial = serialize($customer_cart);
                                $base64 = base64_encode($serial);
                                $user = Customer::find($userid);
                                $user->cart = $base64;
                                $user->update();
                            }
                        }

                        if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                            foreach ($customer_cart['withoutSize'] as $key => $value) {
                                $customer_cart['withoutSize'][$key]['del_price'] = 0.00;

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


        // Get New Delivery Total & Total
        $del_total = 0;
        $coupontotal = 0;
        $sub_total = 0;

        if ($userid == 0) {
            if (session()->has('cart1')) {
                $cart = session()->get('cart1');

                if (!empty($cart) || isset($cart)) {
                    if (isset($cart['size']) && !empty($cart['size'])) {
                        foreach ($cart['size'] as $key => $value) {
                            $del_total += $value['del_price'];
                            $sub_total += $value['main_price'] * $value['quantity'];
                        }
                    }

                    if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                        foreach ($cart['withoutSize'] as $key => $value) {
                            $del_total += $value['del_price'];
                            $sub_total += $value['main_price'] * $value['quantity'];
                        }
                    }
                }
            }
        } else {
            if (!empty($userid)) {
                $customer_cart = getuserCart($userid);

                if (isset($customer_cart) && !empty($customer_cart)) {
                    if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                        foreach ($customer_cart['size'] as $key => $value) {
                            $del_total += $value['del_price'];
                            $sub_total += $value['main_price'] * $value['quantity'];
                        }
                    }

                    if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                        foreach ($customer_cart['withoutSize'] as $key => $value) {
                            $del_total += $value['del_price'];
                            $sub_total += $value['main_price'] * $value['quantity'];
                        }
                    }
                }
            }
        }

        if (!empty($Coupon) || $Coupon != '')
        {
            if ($Coupon->type == 'P') {
            $coupontotal = ($sub_total * $Coupon->discount) / 100;
            }
            if ($Coupon->type == 'F') {
                $coupontotal = $sub_total - $Coupon->discount;
            }
        }



        $total_pay = $sub_total - $coupontotal;


        session()->put('flag_post_code',$d_type);


        return response()->json([
            'success' => 1,
            'delivery_charge' => '£ ' . $del_total,
            'total_pay' => '£ ' . $total_pay,
        ]);
    }

    // Function For Store data
    public function store(Request $request)
    {

        return $request->all();
    }

    // Function For Databade in Search Coupon Code
    public function searchcouponcode(Request $request)
    {
       // Get Current URL
       $currentURL = URL::to("/");

       // Get Store Settings & Other Settings
       $store_data = frontStoreID($currentURL);

       // Get Current Front Store ID
       $front_store_id =  $store_data['store_id'];

       // Store Settings
       $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        $coupon = $request->coupon;
        $filterResult = Coupon::select('code')->where('code', 'LIKE', '%' . $coupon . '%')->where('store_id', $front_store_id)->get();
        return response()->json($filterResult);
    }

}
