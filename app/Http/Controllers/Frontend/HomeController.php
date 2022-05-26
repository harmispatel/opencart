<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliverySettings;
use App\Models\Gallary;
use App\Models\OrderProduct;
use App\Models\Postcodes;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
use App\Models\ToppingProductPriceSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{

    public function index()
    {
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $food_limit_setting = Settings::select('value')->where('store_id', $front_store_id)->where('theme_id', $current_theme_id)->where('key', 'polianna_popular_food_count')->first();
        $food_limit =  isset($food_limit_setting['value']) ? $food_limit_setting['value'] : 1;

        $cat_limit_setting = Settings::select('value')->where('store_id', $front_store_id)->where('theme_id', $current_theme_id)->where('key', 'polianna_best_category_count')->first();
        $cat_limit = isset($cat_limit_setting['value']) ? $cat_limit_setting['value'] : 1;


        $photos = Gallary::where('store_id', $front_store_id)->get();

        $best_categories = Product_to_category::with(['hasManyOrders', 'hasOneCategoryDetails'])->select('category_id', 'product_id', DB::raw('count(*) as total_category'))->whereHas('hasOneCategoryDetails', function ($q) use ($front_store_id) {
            $q->whereHas('hasManyCategoryStore', function ($q1) use ($front_store_id) {
                $q1->where('store_id', $front_store_id);
            });
        })->groupBy('category_id')->limit($cat_limit)->get()->sortByDesc(function ($query) {
            return $query->hasManyOrders->count();
        });

        $categorytoproduct = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->get();
        foreach ($categorytoproduct as $categorydet) {
            $cat = $categorydet->category_id;
            $categorytoproduct = Product_to_category::with(['hasOneProduct', 'hasOneDescription'])->whereHas('hasOneProduct', function ($query) use ($cat) {
                $query->where('category_id', $cat);
            })->get();
        }
        // echo '<pre>';
        // print_r($categorytoproduct->toArray());
        // exit();
        $popular_foods = OrderProduct::with(['hasOrder', 'hasOneProduct'])->whereHas('hasOrder', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->groupBy('name')->select('product_id', DB::raw('count(*) as total_product'))->orderBy('total_product', 'DESC')->limit($food_limit)->get();

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

        return view('frontend.pages.home', compact(['photos', 'best_categories', 'popular_foods', 'delivery_setting', 'areas']));
    }


    public function checkZipCode(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $type = $request->type;

        // Check User ID
        if (session()->has('userid')) {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }

        if ($type == 'collection') {

            if ($userid == 0) {
                if (session()->has('cart1')) {
                    $cart = session()->get('cart1');

                    if (!empty($cart) || isset($cart)) {
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
            } else {
                if (!empty($userid)) {
                    $customer_cart = getuserCart($userid);

                    if (isset($customer_cart) && !empty($customer_cart)) {
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

            session()->put('flag_post_code', 'collection');
            $json['success'] = 'collection';
            return response()->json($json);
        }

        if (isset($request->keyword)) {
            $keyword = trim($request->keyword);
        } else {
            $keyword = '';
        }

        if ($keyword != '' || !empty($keyword)) {
            $d_type = 'delivery';
        }

        $keyword = str_replace(' ', '', $keyword);
        // $keyword = strtoupper($keyword);

        $json = array();

        $json['error'] = 'Sorry!!!! We don\'t do delivery to your area';

        if ($keyword != '') {
            $sql = Settings::where('key', 'available_zones')->get();
            $stores = array();
            if ($sql) {
                foreach ($sql as $row) {

                    if ($row['value'] != '') {
                        $isValid = false;
                        $temp = explode(',', $row['value']);
                        if ($temp) {
                            foreach ($temp as $t) {
                                $t = str_replace(' ', '', $t);
                                if ($t != '' && strlen($keyword) >= strlen($t) && (substr($keyword, 0, strlen($t)) == $t)) {
                                    $isValid = true;
                                    break;
                                }
                            }
                        }
                        if ($isValid && $row['store_id'] == $front_store_id) {

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
                                        }
                                    }
                                }
                            }

                            session()->put('checedStoreId', $front_store_id);
                            session()->put('flag_post_code', 'delivery');
                            session()->put('ets_post_code', $keyword);
                            $json['success'] = 'EXIST';
                        }
                    }
                }
            }
        } else {
            $json['error'] = 'Sorry!!!! We don\'t do delivery to your area';
        }
        if (!isset($json['success'])) $json['error'] = $json['error'];
        return response()->json($json);
    }

    public function postcodes(Request $request)
    {
        $keyword = $request->keyword;

        $sql1 = Postcodes::where('Postcode', 'LIKE', "%{$keyword}%")->limit(8)->get();

        if (count($sql1) > 0) {
            $json['postcodes'] = $sql1;
            $json['success'] = true;
        } else {
            $json['error'] = '<div style="padding-top: 15px;"><div class="store_list wrap_row" style="padding: 15px;">Sorry! We don\'t do delivery to your area</div></div>';
        }
        return response()->json($json);
    }
}
