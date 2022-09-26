<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliverySettings;
use App\Models\Gallary;
use App\Models\HtmlBox;
use App\Models\OrderProduct;
use App\Models\Postcodes;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
use App\Models\Slider;
use App\Models\ToppingProductPriceSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    // Function For Fronted Home Page
    public function index()
    {
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id = $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // Get Current BestCategory ID & BestCategory Settings
        $current_bestcategory_id = layoutID($currentURL, 'bestcategory_id');
        $bestcategory_id = $current_bestcategory_id['bestcategory_id'];
        $store_bestcategory_settings = storeLayoutSettings($bestcategory_id, $front_store_id, 'bestcategory_settings', 'bestcategory_id');

        // Get Current PopularFood ID & PopularFood Settings
        $current_popularfood_id = layoutID($currentURL, 'popularfood_id');
        $popularfood_id = $current_popularfood_id['popularfood_id'];
        $store_popularfood_settings = storeLayoutSettings($popularfood_id, $front_store_id, 'popularfood_settings', 'popularfood_id');

        // Get Current Gallary ID & Gallary Settings
        $current_gallary_id = layoutID($currentURL, 'gallary_id');
        $gallary_id = $current_gallary_id['gallary_id'];
        $store_gallary_settings = storeLayoutSettings($gallary_id, $front_store_id, 'gallary_settings', 'gallary_id');

        $food_limit = isset($store_popularfood_settings['popularfood_limit']) ? $store_popularfood_settings['popularfood_limit'] : 10;

        $cat_limit = isset($store_bestcategory_settings['bestcategory_limit']) ? $store_bestcategory_settings['bestcategory_limit'] : 5;

        $gallary_limit = isset($store_gallary_settings['gallary_limit']) ? $store_gallary_settings['gallary_limit'] : 10;

        $sliders = Slider::where('store_id', $front_store_id)->get();

        $photos = Gallary::where('store_id', $front_store_id)->limit($gallary_limit)->get();

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

        $htmlbox_store_about_settings = HtmlBox::where('store_id', $front_store_id)->get();

        return view('frontend.pages.home', compact(['photos', 'best_categories', 'popular_foods', 'delivery_setting', 'areas', 'sliders', 'htmlbox_store_about_settings']));
    }

    // Suspend
    public function suspend()
    {
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id = $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // Suspend Data
        $data['suspend_title'] = isset($store_setting['suspend_title']) ? $store_setting['suspend_title'] : 'Maintenance Mode';
        $data['suspend_description'] = isset($store_setting['suspend_description']) ? $store_setting['suspend_description'] : '';
        $data['suspend_logo'] = isset($store_setting['suspend_logo']) ? $store_setting['suspend_logo'] : '';

        // Suspend Permenantly
        $suspend_permanently = isset($store_setting['suspend_permanently']) ? $store_setting['suspend_permanently'] : 'no';

        if ($suspend_permanently == 'yes') {
            return view('frontend.pages.suspend', $data);
        } else {
            return redirect()->route('home');
        }

    }

    // Function For ZipCode
    public function checkZipCode(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = layoutID($currentURL,'header_id');
        $current_theme_id = $current_theme['header_id'];
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
                    session()->forget('cart1');

                    // Change ortder type change price delevery and collection session
                    // $cart = session()->get('cart1');

                    // if (!empty($cart) || isset($cart)) {
                    //     if (isset($cart['size']) && !empty($cart['size'])) {
                    //         foreach ($cart['size'] as $key => $value) {
                    //             $cart['size'][$key]['del_price'] = 0.00;
                    //             session()->put('cart1', $cart);
                    //         }
                    //     }

                    //     if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                    //         foreach ($cart['withoutSize'] as $key => $value) {
                    //             $cart['withoutSize'][$key]['del_price'] = 0.00;
                    //             session()->put('cart1', $cart);
                    //         }
                    //     }
                    // }
                }
            } else {
                if (!empty($userid)) {
                    $user = Customer::find($userid);
                    $user->cart = '';
                    $user->update();

                    // Change ortder type change price delevery and collection Database
                    // $customer_cart = getuserCart($userid);

                    // if (isset($customer_cart) && !empty($customer_cart)) {
                    //     if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                    //         foreach ($customer_cart['size'] as $key => $value) {
                    //             $customer_cart['size'][$key]['del_price'] = 0.00;

                    //             $serial = serialize($customer_cart);
                    //             $base64 = base64_encode($serial);
                    //             $user = Customer::find($userid);
                    //             $user->cart = $base64;
                    //             $user->update();
                    //         }
                    //     }

                    //     if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                    //         foreach ($customer_cart['withoutSize'] as $key => $value) {
                    //             $customer_cart['withoutSize'][$key]['del_price'] = 0.00;

                    //             $serial = serialize($customer_cart);
                    //             $base64 = base64_encode($serial);
                    //             $user = Customer::find($userid);
                    //             $user->cart = $base64;
                    //             $user->update();
                    //         }
                    //     }
                    // }
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
                                session()->forget('cart1');
                                // if (session()->has('cart1')) {
                                //     $cart = session()->get('cart1');

                                //     if (!empty($cart) || isset($cart)) {
                                //         // For Delivery Price
                                //         if ($d_type == 'delivery') {
                                //             if (isset($cart['size']) && !empty($cart['size'])) {
                                //                 foreach ($cart['size'] as $key => $value) {
                                //                     $size_id = $key;
                                //                     $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                                //                     $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                //                     $cart['size'][$key]['del_price'] = $del_price;
                                //                     session()->put('cart1', $cart);
                                //                 }
                                //             }

                                //             if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                                //                 foreach ($cart['withoutSize'] as $key => $value) {
                                //                     $prod_id = $key;
                                //                     $prod = Product::where('product_id', $prod_id)->first();
                                //                     $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                //                     $cart['withoutSize'][$key]['del_price'] = $del_price;
                                //                     session()->put('cart1', $cart);
                                //                 }
                                //             }
                                //         }
                                //     }
                                // }
                            } else {
                                if (!empty($userid)) {
                                    $customer_cart = getuserCart($userid);
                                    $user = Customer::find($userid);
                                    $user->cart = '';
                                    $user->update();

                                    // if (isset($customer_cart) && !empty($customer_cart)) {
                                    //     // For Delivery Price
                                    //     if ($d_type == 'delivery') {
                                    //         if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                                    //             foreach ($customer_cart['size'] as $key => $value) {
                                    //                 $size_id = $key;
                                    //                 $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                                    //                 $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                    //                 $customer_cart['size'][$key]['del_price'] = $del_price;

                                    //                 $serial = serialize($customer_cart);
                                    //                 $base64 = base64_encode($serial);
                                    //                 $user = Customer::find($userid);
                                    //                 $user->cart = $base64;
                                    //                 $user->update();
                                    //             }
                                    //         }

                                    //         if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                                    //             foreach ($customer_cart['withoutSize'] as $key => $value) {
                                    //                 $prod_id = $key;
                                    //                 $prod = Product::where('product_id', $prod_id)->first();
                                    //                 $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                                    //                 $customer_cart['withoutSize'][$key]['del_price'] = $del_price;

                                    //                 $serial = serialize($customer_cart);
                                    //                 $base64 = base64_encode($serial);
                                    //                 $user = Customer::find($userid);
                                    //                 $user->cart = $base64;
                                    //                 $user->update();
                                    //             }
                                    //         }
                                    //     }
                                    // }
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


    // Function For PostCode
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
