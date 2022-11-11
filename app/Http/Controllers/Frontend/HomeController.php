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
        $front_store_id =  $current_theme['store_id'];

        $checkout_type = $request->type;

        $delCheckout = isset($request->delCheckout) ? $request->delCheckout : 0;


        // Check User ID
        if (session()->has('userid'))
        {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }

        // Get Checkout type from session();
        if(session()->has('flag_post_code'))
        {
            $flag_post_code = session()->get('flag_post_code');
        }
        else
        {
            $flag_post_code = '';
        }


        // When User Change type collection to delivery from checkout page
        if($delCheckout == 1)
        {
            $current_type = 'delivery';

            if($current_type != $flag_post_code)
            {
                // Remove Cart Date
                if (session()->has('cart1'))
                {
                    session()->forget('cart1');
                }

                // Remove Subtotal
                if(session()->has('subtotal'))
                {
                    session()->forget('subtotal');
                }

                // Remove Coupon
                if(session()->has('currentcoupon'))
                {
                    session()->forget('currentcoupon');
                }

                // Remove Products ID
                if(session()->has('product_id'))
                {
                    session()->forget('product_id');
                }

                // Remove Coupon Code
                if(session()->has('couponcode'))
                {
                    session()->forget('couponcode');
                }

                // Remove Coupon Name
                if(session()->has('couponname'))
                {
                    session()->forget('couponname');
                }

                // Remove Header Total
                if(session()->has('headertotal'))
                {
                    session()->forget('headertotal');
                }

                // Remove Free Items
                if(session()->has('free_item'))
                {
                    session()->forget('free_item');
                }
            }

            // Get Delivery Setting
            $del_key = ([
                'enable_delivery',
                'delivery_option',
            ]);
            $delivery_setting = [];

            foreach ($del_key as $row) {
                $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

                $delivery_setting[$row] = isset($query->value) ? $query->value : '';
            }

            if(!empty($delivery_setting))
            {
                if(isset($delivery_setting['delivery_option']) && !empty($delivery_setting['delivery_option']))
                {
                    if($delivery_setting['delivery_option'] == 'area')
                    {
                        $current_delivery_option = 'areaname';
                    }
                    else
                    {
                        $current_delivery_option = 'postcodes';
                    }
                }
                else
                {
                    $current_delivery_option = '';
                }
            }
            else
            {
                $current_delivery_option = '';
            }

            if(!empty($current_delivery_option))
            {
                session()->put('delivery_code_option',$current_delivery_option);
            }

            session()->put('flag_post_code',$current_type);

            return response()->json([
                'success'=>1,
            ]);

        }

        // When Checkout Type is Collection
        if($checkout_type == 'collection')
        {
            if($checkout_type != $flag_post_code)
            {
                // Remove Cart Date
                if (session()->has('cart1'))
                {
                    session()->forget('cart1');
                }

                // Remove Subtotal
                if(session()->has('subtotal'))
                {
                    session()->forget('subtotal');
                }

                // Remove Coupon
                if(session()->has('currentcoupon'))
                {
                    session()->forget('currentcoupon');
                }

                // Remove Products ID
                if(session()->has('product_id'))
                {
                    session()->forget('product_id');
                }

                // Remove Coupon Code
                if(session()->has('couponcode'))
                {
                    session()->forget('couponcode');
                }

                // Remove Coupon Name
                if(session()->has('couponname'))
                {
                    session()->forget('couponname');
                }

                // Remove Header Total
                if(session()->has('headertotal'))
                {
                    session()->forget('headertotal');
                }

                // Remove Free Items
                if(session()->has('free_item'))
                {
                    session()->forget('free_item');
                }

                // Remove Selected Postcode
                if(session()->has('selected_postcode'))
                {
                    session()->forget('selected_postcode');
                }

                // Remove DeliveryCode Option
                if(session()->has('delivery_code_option'))
                {
                    session()->forget('delivery_code_option');
                }
            }

            session()->put('flag_post_code', 'collection');

            return response()->json([
                'success' => 1,
                'checkout_type' => 'collection'
            ]);
        }
        else
        {
            if($checkout_type != $flag_post_code)
            {
                // Remove Cart Date
                if (session()->has('cart1'))
                {
                    session()->forget('cart1');
                }

                // Remove Subtotal
                if(session()->has('subtotal'))
                {
                    session()->forget('subtotal');
                }

                // Remove Coupon
                if(session()->has('currentcoupon'))
                {
                    session()->forget('currentcoupon');
                }

                // Remove Products ID
                if(session()->has('product_id'))
                {
                    session()->forget('product_id');
                }

                // Remove Coupon Code
                if(session()->has('couponcode'))
                {
                    session()->forget('couponcode');
                }

                // Remove Coupon Name
                if(session()->has('couponname'))
                {
                    session()->forget('couponname');
                }

                // Remove Header Total
                if(session()->has('headertotal'))
                {
                    session()->forget('headertotal');
                }

                // Remove Free Items
                if(session()->has('free_item'))
                {
                    session()->forget('free_item');
                }
            }

            $delivery_option = isset($request->delivery_option) ? $request->delivery_option : '';
            $keyword = isset($request->keyword) ? trim($request->keyword) : '';
            $new_keyword = str_replace(' ', '', $keyword);

            if(!empty($new_keyword))
            {
                $sql = Settings::where('key', 'available_zones')->where('store_id',$front_store_id)->first();
                if(isset($sql) && !empty($sql))
                {
                    $all_zones = isset($sql->value) ? $sql->value : '';

                    if(!empty($all_zones))
                    {
                        $zones_array = explode(',',$all_zones);
                    }
                    else
                    {
                        $zones_array = [];
                    }

                    if(count($zones_array) > 0)
                    {
                        if(in_array($new_keyword,$zones_array))
                        {
                            session()->put('flag_post_code', 'delivery');
                            session()->put('selected_postcode',$new_keyword);
                            session()->put('delivery_code_option',$delivery_option);

                            return response()->json([
                                'success'=>1,
                                'checkout_type'=>'delivery'
                            ]);
                        }
                        else
                        {
                            return response()->json([
                                'error'=>1,
                                'message'=>'Sorry!!!! We don\'t do delivery to your area'
                            ]);
                        }
                    }
                    else
                    {
                        return response()->json([
                            'error'=>1,
                            'message'=>'Sorry!!!! We don\'t do delivery to your area'
                        ]);
                    }

                }
                else
                {
                    return response()->json([
                        'error'=>1,
                        'message'=>'Sorry!!!! We don\'t do delivery to your area'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'error'=>1,
                    'message'=>'Sorry!!!! We don\'t do delivery to your area'
                ]);
            }

        }

    }


    // Function For PostCode
    public function postcodes(Request $request)
    {
        $keyword = $request->keyword;

        $sql1 = Postcodes::where('Postcode', 'LIKE', "%{$keyword}%")->limit(10)->get();

        if (count($sql1) > 0)
        {
            $json['postcodes'] = $sql1;
            $json['success'] = true;
        }
        else
        {
            $json['error'] = '<div style="padding-top: 15px;"><div class="store_list wrap_row" style="padding: 15px;">Sorry Postcode Not Available Enter Valid Postcode!</div></div>';
        }
        return response()->json($json);
    }

}
