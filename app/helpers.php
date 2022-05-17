<?php

use App\Models\Category;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;
use App\Models\CategoryDetail;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerBanIp;
use App\Models\CustomerIP;
use App\Models\Option;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Store;
use App\Models\Topping;
use App\Models\ToppingProductPriceSize;
use App\Models\Product_to_category;
use App\Models\ToppingSize;
use App\Models\PhotoGallry;
use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Support\Facades\URL;

// Function of User Details
function user_details()
{
    $user_dt = auth()->user();
    return $user_dt;
}

function full_copy($source, $target)
{
    if ( is_dir( $source ) ) {
            $d = dir( $source );
            while ( FALSE !== ( $entry = $d->read() ) )
            {
                if ( $entry == '.' || $entry == '..' )
                {
                        continue;
                }
                $Entry = $source . '/' . $entry;
                if ( is_dir( $Entry ) )
                {
                    @mkdir( $Entry );
                    // $this->full_copy( $Entry, $target . '/' . $entry );
                    full_copy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }
            $d->close();
    }else {
        copy( $source, $target );
    }
}

// Get Total Ip Count
function gettotalip($ip)
{
    $ip = CustomerIP::where('ip',$ip)->count();
    return $ip;
}


/* Google Distance matrix calculation Api */
function calculationDistanceMatrix($lat1,$long1,$lat2,$long2,$api_key)
{

    // Create a new CURL instance<br>
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&alternatives=true&sensor=false&key=".$api_key;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($response, true);

    return $res;
}


function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2))
    {
      return 0;
    }
    else
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K")
        {
            return ($miles * 1.609344);
        }
        else if ($unit == "N") {
            return ($miles * 0.8684);
        }
        else
        {
            return $miles;
        }
    }
}


//
function themeActive()
{
    // Current Store ID
    $current_store_id = currentStoreId();

    $key = 'theme_id';

    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    $theme_id = isset($setting->value) ? $setting->value : '';

    return $theme_id;

}


function storeThemeSettings($theme_id,$store_id)
{
    // Template Settings
    $key = ([
        'polianna_navbar_background',
        'polianna_navbar_link',
        'polianna_navbar_link_hover',
        'polianna_main_logo',
        'polianna_main_logo_width',
        'polianna_main_logo_height',

        'polianna_slider_permission',
        'polianna_slider_1',
        'polianna_slider_2',
        'polianna_slider_3',
        'polianna_slider_1_title',
        'polianna_slider_2_title',
        'polianna_slider_3_title',
        'polianna_slider_1_description',
        'polianna_slider_2_description',
        'polianna_slider_3_description',

        'polianna_online_order_permission',
        'polianna_open_close_store_permission',

        'polianna_open_banner',
        'polianna_close_banner',
        'polianna_open_close_banner_width',
        'polianna_open_close_banner_height',

        'polianna_store_fonts',
        'polianna_popular_food_count',
        'polianna_recent_review_count',
        'polianna_best_category_count',
        'polianna_store_description',
        'polianna_banner_image',

        'polianna_footer_background',
        'polianna_footer_text_color',
        'polianna_footer_title_color',
        'polianna_footer_logo',
    ]);

    $template_settings = [];

    foreach($key as $row)
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('theme_id',$theme_id)->where('key',$row)->first();
        $template_settings[$row] = isset($query->value) ? $query->value : '';
    }

    if(session()->has('template_settings'))
    {
        session()->forget('template_settings');
        session()->put('template_settings',$template_settings);
    }
    else
    {
        session()->put('template_settings', $template_settings);
    }
    // End Template Settings

    // Social Site
    $social_key = ([
        'polianna_facebook_id',
        'polianna_twitter_username',
        'polianna_gplus_id',
        'polianna_linkedin_id',
        'polianna_youtube_id',
    ]);

    $social_settings = [];

    foreach($social_key as $row)
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('key',$row)->first();
        $social_settings[$row] = isset($query->value) ? $query->value : '';
    }

    if(session()->has('social_site'))
    {
        session()->forget('social_site');
        session()->put('social_site',$social_settings);
    }
    else
    {
        session()->put('social_site', $social_settings);
    }
    // End Social Site


    // Store Settings
    $store_key = ([
        'config_name',
        'config_owner',
        'config_address',
        'map_ifram',
        'sitemap_url',
        'config_telephone',
        'config_email',
        'config_meta_description',
    ]);

    $store_settings = [];

    foreach($store_key as $row)
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('key',$row)->first();
        $store_settings[$row] = isset($query->value) ? $query->value : '';
    }

    if(session()->has('store_settings'))
    {
        session()->forget('store_settings');
        session()->put('store_settings',$store_settings);
    }
    else
    {
        session()->put('store_settings', $store_settings);
    }
    // End Store Settings

}

function public_url()
{
    return asset('');
}

function themeID($url)
{
    $slash = substr($url, -1);

    if($slash != '/')
    {
        $new_url = $url .= '/';
    }
    else
    {
        $new_url = $url;
    }
    $storeDetails = Store::where('url',$new_url)->orWhere('ssl',$new_url)->first();

    $store_id = isset($storeDetails->store_id) ? $storeDetails->store_id : '';

    $key = 'theme_id';
    $setting = Settings::select('value')->where('store_id',$store_id)->where('key',$key)->first();
    $theme_id = isset($setting->value) ? $setting->value : '';

	if(session()->has('front_store_id'))
    {
        session()->forget('front_store_id');
        session()->put('front_store_id',$store_id);
    }
    else
    {
        session()->put('front_store_id', $store_id);
    }

    if(session()->has('theme_id'))
    {
        session()->forget('theme_id');
        session()->put('theme_id', $theme_id);
    }
    else
    {
        session()->put('theme_id', $theme_id);
    }
    $new = ([
        'theme_id' => $theme_id,
        'store_id' => $store_id,
    ]);
    return $new;

}

function getproductcount($demo){
	$productcount=Product_to_category::where('category_id',$demo)->count();

	return $productcount;


}

function getproduct($front_store_id,$cat_id)
{
    $product=Product_to_category::with(['hasOneProduct','hasOneDescription','hasOneToppingProductPriceSize'])->whereHas('hasOneProduct', function ($query) use ($cat_id) {
        $query->where('category_id', $cat_id);
    })->get();
    return $product;

}
function getsize($product_id)
{

    $size =ToppingProductPriceSize::with(['hasOneToppingSize'])->where('id_product',$product_id)->get();
    return $size;

}

function getimage($current_store)
{
    $image=PhotoGallry::where('store_id',$current_store)->orderBy('image_id','ASC')->get();
    return $image;
}

function getphoto($current_store,$key){
    $gallery = Settings::where('key',$key)->where('store_id',$current_store)->first();
    $new = isset($gallery->value) ? $gallery->value : '';
    return $new;

}


function getFonts()
{
    $fonts = array(
        ''             => '- default -',
        'Arial'        => 'Arial',
        'Verdana'      => 'Verdana',
        'Helvetica'    => 'Helvetica',
        'Cursive'      => 'cursive',
        'Calibri'      => 'Calibri',
        'Noto'         => 'Noto',
        'Lucida Sans'  => 'Lucida Sans',
        'Gill Sans'    => 'Gill Sans',
        'Candara'      => 'Candara',
        'Futara'       => 'Futara',
        'Geneva'       => 'Geneva',
        'Segoe UI'     => 'Segoe UI',
        'Optima'       => 'Optima',
        'Avanta Garde' => 'Avanta Garde',
	);

    return $fonts;
}


// Function to Get Store Details
function getStoreDetails($storeid,$key)
{
    $gedetails = Settings::where('key',$key)->where('store_id',$storeid)->first();
    $new = isset($gedetails->value) ? $gedetails->value : '';
    return $new;
}

function getLoyaltyDetails($storeid,$key){

    $gedetails = Settings::where('store_id',$storeid)->where('key',$key)->first();

        $point = Settings::select('value')->where('store_id',$storeid)->where('key','point')->first();
        $unserializepoint =unserialize(isset($point['value']) ? $point['value'] :'');

        $money = Settings::select('value')->where('store_id',$storeid)->where('key','money')->first();
        $unserializemoney =unserialize(isset($money['value']) ? $money['value'] :'');



    $value = isset($gedetails->value) ? $gedetails->value : '';
    $data['value'] = $value;
    $data['unserializepoint'] =$unserializepoint;
    $data['unserializemoney'] =$unserializemoney;


    return $data;
}

function currentStoreId()
{
    if(session()->has('store_id'))
    {
        $storeID = session()->get('store_id');
    }
    else
    {
        $storeID = 0;
    }
    return $storeID;
}


// Check Ban IP
function checkBanIp($ip)
{
    $ip = CustomerBanIp::select('ip')->where('ip',$ip)->first();
    return $ip;
}


// Check New Model
function checkNewModel()
{
    $setting = Settings::where('key','new_module_status')->first();
    if($setting != '' || !empty($setting))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}



function getStores()
{
    $stores = Store::get();
    return $stores;
}


function getCurrentStoreURL($id)
{
    $store = Store::select('ssl')->where('store_id',$id)->first();
    $url = isset($store->ssl) ? $store->ssl : '';
    return $url;
}


function get_sub_opt_names($sub_opt_ids)
{
    $arr = array();
    $ids = explode(',',$sub_opt_ids);

    foreach($ids as $id)
    {
        $getname = Topping::select('name_topping')->where('id_topping',$id)->first();
        $name = isset($getname->name_topping) ? $getname->name_topping : '';
        $arr[] = $name;
    }

    $names = implode(',',$arr);
    return $names;
}


function user_shop_detail($shopID)
{
    $store_dt = Store::where('store_id',$shopID)->first();
    return $store_dt;
}



function getZonebyId($zid)
{
    $zone = Region::where('zone_id',$zid)->first();
    return $zone;
}


// Function of Genrate Token
function genratetoken($length = 32) {
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $max = strlen($string) - 1;

    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $string[mt_rand(0, $max)];
    }

    return $token;
}



// Function of Sidebar Menu
function sidebar()
{
    $all_menu = MainMenu::orderBy('menu_order','ASC')->get();
    return $all_menu;
}




// Function of Sidebar Menu of Submenu
function submenu($menu_id)
{
    $sub_menu = Submenu::where('menu_id',$menu_id)->get();
    return $sub_menu;
}




function submenuofsubmenu($submenu_id)
{
    $submenu_of_submenu = Submenu::where('parent_id',$submenu_id)->get();
    return $submenu_of_submenu;
}




// Function of Submenu Actions
function submenuaction($smenu_id)
{
    $sub_menu = Submenu::where('parent_id',$smenu_id)->get();
    return $sub_menu;
}




// Function of Get User Role Action
function get_rel_userrole_action($where)
{
    $user_role_action = Permission::where($where)->first();
    return $user_role_action;
}




// Function of Fetch Other Users Sidebar Menu
function fetch_otherusers_mainmenu($where)
{
    $resultset = MainMenu::where($where)->select('oc_main_menu.*')->join('oc_userrole_actions','oc_userrole_actions.menu_id','=','oc_main_menu.id')->orderBy('oc_main_menu.menu_order')->get();
    return $resultset;
}




// Function of Fetch Other Users Sidebar Menu of Submenu
function fetch_otherusers_mainmenu_submenu($where)
{
    $resultset = Permission::where($where)->where('oc_menu_actions.is_hidden','!=',4)->select('oc_menu_actions.*')->join('oc_menu_actions','oc_menu_actions.id','=','oc_userrole_actions.action_id')->orderBy('oc_menu_actions.id')->get();
    return $resultset;
}


function getProductSize($sizeid,$productid)
{
    $size = ToppingProductPriceSize::where('id_size',$sizeid)->where('id_product',$productid)->first();
    return $size;
}


// Function of Check Userrole of Submenus
function check_user_role($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('subaction_id','=',$action_id)->where('role_id','=',$uaccess)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }
}

// Checkuserrole for Menu
function check_user_role_menu($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('menu_id','=',$action_id)->where('role_id','=',$uaccess)->where('action_id','=',0)->where('subaction_id','=',0)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }

}




// Function of Check Userrole for Single Menu
function check_user_role_for_single_menu($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('action_id','=',$action_id)->where('role_id','=',$uaccess)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }

}

function getmaincat()
{
    $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

    foreach ($fetchparent as $main) {
        $subcat = CategoryDetail::where('oc_category.parent_id',$main->category_id)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
    }

    return $fetchparent;
}



//Function of Get Sub Category
function get_subcat($parentid)
{
    $subcat = CategoryDetail::where('oc_category.parent_id',$parentid)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
    return $subcat;
}




// Function of Subcategory of Category
function depend_subcat($value1)
{
    $subcat1 = CategoryDetail::where('oc_category.parent_id',$value1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();;
    return $subcat1;
}




//
function fetch_mainmenu_submenucolumn($id)
{
    $subMenu = SubMenu::where('menu_id',$id)->where('oc_menu_actions.is_hidden','!=',4)->select('slugurl','parent_id')->get()->toArray();

    $arr = array_map(function ($value) {
        return $value;
    }, $subMenu);

    return $arr;

}



function openclosetime()
{
    $days = array(
        '0' => "Every day",
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    );

    $times = array(
        '00:00' => 'Start day',
        '01:00' => "1:00 AM",
        '02:00' => "2:00 AM",
        '03:00' => "3:00 AM",
        '04:00' => "4:00 AM",
        '05:00' => "5:00 AM",
        '06:00' => "6:00 AM",
        '07:00' => "7:00 AM",
        '08:00' => "8:00 AM",
        '09:00' => "9:00 AM",
        '10:00' => "10:00 AM",
        '11:00' => "11:00 AM",
        '12:00' => "12:00 AM",
        '13:00' => "1:00 PM",
        '14:00' => "2:00 PM",
        '15:00' => "3:00 PM",
        '16:00' => "4:00 PM",
        '17:00' => "5:00 PM",
        '18:00' => "6:00 PM",
        '19:00' => "7:00 PM",
        '20:00' => "8:00 PM",
        '21:00' => "9:00 PM",
        '22:00' => "10:00 PM",
        '23:00' => "11:00 PM",
        '23:59' => 'End day'
    );

    $key = ([
        'opening_time_collection',
        'opening_time_delivery',
        'opening_time_bussness',
        'business_closing_dates',
        'order_outof_bussiness_time',
        'collection',
        'collection_gaptime',
        'collection_same_bussiness',
        'delivery',
        'delivery_gaptime',
        'delivery_same_bussiness',
        'closing_dates',
        'bussines',
    ]);

    $minitunes = array('00', '10', '20', '30', '40', '50');
    $timearray = array();
    $timearray['00:00'] = '00:00';
    for ($i = 0; $i <= 23; $i++) {
        foreach ($minitunes as $phut) {
            $timearray[$i . ':' . $phut] = $i . ':' . $phut;
        }
    }
    $timearray['23:59'] = '23:59';
    $times = $times = $timearray;

    $open_close = [];
    $front_store_id = session('front_store_id');

    foreach ($key as $row) {
        $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

        $open_close[$row] = isset($query->value) ? $query->value : '';
    }

    // $closedate = unserialize($open_close['closing_dates']);
    $delivery = unserialize($open_close['delivery']);
    $collection = unserialize($open_close['collection']);
    // $timesetting = $open_close;
    $bussines = unserialize($open_close['bussines']);
    $days = $days;
    $times = $times;

    // echo '<pre>';
    // print_r($collection);
    // exit();

    // bussines Time
    $openday = array();
    $fromtime = array();
    $totime = array();
    if (isset($bussines['day']) && count($bussines['day'])) {
        foreach ($bussines['day'] as $keyday => $daytime) {
            $day2 = array();
            foreach ($days as $key => $day) {
                if (in_array($key, $daytime)) {
                   $day2[] = $day;
                }
            }
            $openday[]=$day2;
            foreach ($times as $key => $time) {
                if (isset($bussines['from'][$keyday]) && $bussines['from'][$keyday] == $key) {
                    $fromtime[] = $time;
                }
            }
            foreach ($times as $key => $time) {
                if (isset($bussines['to'][$keyday]) && $bussines['to'][$keyday] == $key) {
                    $totime[] = $time;
                }
            }
        }
    }

    // Collection Time
    $collectiondays = array();
    $collectionfrom = array();
    $collectionto = array();
    if (isset($collection['day']) && count($collection['day'])) {
        foreach ($collection['day'] as $keyday => $daytime) {
            $collectionday = array();
            foreach ($days as $key => $day) {
                if (in_array($key, $daytime)) {
                   $collectionday[] = $day;
                }
            }
            $collectiondays[]=$collectionday;
            foreach ($times as $key => $time) {
                if (isset($collection['from'][$keyday]) && $collection['from'][$keyday] == $key) {
                    $collectionfrom[] = $time;
                }
            }
            foreach ($times as $key => $time) {
                if (isset($collection['to'][$keyday]) && $collection['to'][$keyday] == $key) {
                    $collectionto[] = $time;
                }
            }
        }
    }
    // delivery Time
    $deliverydays = array();
    $deliveryfrom = array();
    $deliveryto = array();
    if (isset($delivery['day']) && count($delivery['day'])) {
        foreach ($delivery['day'] as $keyday => $daytime) {
            $deliveryday = array();
            foreach ($days as $key => $day) {
                if (in_array($key, $daytime)) {
                   $deliveryday[] = $day;
                }
            }
            $deliverydays[]=$deliveryday;
            foreach ($times as $key => $time) {
                if (isset($delivery['from'][$keyday]) && $delivery['from'][$keyday] == $key) {
                    $deliveryfrom[] = $time;
                }
            }
            foreach ($times as $key => $time) {
                if (isset($delivery['to'][$keyday]) && $delivery['to'][$keyday] == $key) {
                    $deliveryto[] = $time;
                }
            }
        }
    }
    $data['deliverydays'] = $deliverydays;
    $data['deliveryfrom'] = $deliveryfrom;
    $data['deliveryto'] = $deliveryto;

    $data['collectiondays'] = $collectiondays;
    $data['collectionfrom'] = $collectionfrom;
    $data['collectionto'] = $collectionto;

    $data['openday'] = $openday;
    $data['fromtime'] = $fromtime;
    $data['totime'] = $totime;

    $data['collection_same_bussiness'] = $open_close['collection_same_bussiness'];
    $data['delivery_same_bussiness'] = $open_close['delivery_same_bussiness'];

    $data['collection_gaptime'] = $open_close['collection_gaptime'];
    $data['delivery_gaptime'] = $open_close['delivery_gaptime'];
    return $data;
}

function storereview()
{
    $front_store_id = session('front_store_id');
    $current_theme_id = session('theme_id');

    $review_limit_setting = Settings::select('value')->where('store_id',$front_store_id)->where('theme_id',$current_theme_id)->where('key','polianna_recent_review_count')->first();
    $review_limit = isset($review_limit_setting['value']) ? $review_limit_setting['value'] : 1;

    $data['reviews'] = Reviews::with(['hasOneCustomer'])->where('store_id',$front_store_id)->latest('store_review_id')->take($review_limit)->get();

    return $data;
}

function getuserCart($userId)
{
    $customer = Customer::select('cart')->where('customer_id',$userId)->first();
    $cust_cart = isset($customer->cart) ? $customer->cart : '';
    $base64decode = base64_decode($cust_cart);
    $cart = unserialize($base64decode);
    return $cart;
}

function addtoCartUser($request,$productid,$sizeid, $cart, $userid)
{
    $delivery_type = session()->get('flag_post_code');

    if(isset($cart))
    {
        $arr = $cart;
    }
    else
    {
        $arr = array();
    }

    if($sizeid != 0)
    {
        $product = Product::with(['hasOneToppingProductPriceSize' => function ($q) use ($sizeid) {
            $q->where('id_product_price_size', $sizeid);
        }])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->hasOneToppingProductPriceSize['delivery_price']) ? $product->hasOneToppingProductPriceSize['delivery_price'] : 0.00;
            $data['del_price'] = $del_price;
        }

        $data['main_price'] = $product->hasOneToppingProductPriceSize['price'];
        $data['size'] = $product->hasOneToppingProductPriceSize->hasOneToppingSize['size'];
    }
    else
    {
        $product = Product::with(['hasOneProductDescription'])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->delivery_price) ? $product->delivery_price : 0.00;
            $data['del_price'] = $del_price;
        }
        $data['main_price'] = $product->price;
    }
    $data['name'] = $product->hasOneProductDescription['name'];
    $data['description'] = $product->hasOneProductDescription['description'];
    $data['image'] = $product->image;
    $data['model'] = $product->model;
    $data['quantity'] = 1;
    $data['product_id'] = $productid;

    if ($sizeid != 0)
    {
        if(isset($arr['size'][$sizeid]))
        {
            $arr['size'][$sizeid]['quantity'] = $arr['size'][$sizeid]['quantity'] + 1;
        }
        else
        {
            $arr['size'][$sizeid] =$data;
        }
    }
    else
    {
        if(isset($arr['withoutSize'][$productid]))
        {
            $arr['withoutSize'][$productid]['quantity'] = $arr['withoutSize'][$productid]['quantity'] + 1;
        }
        else
        {
            $arr['withoutSize'][$productid] =$data;
        }
    }

    $serial = serialize($arr);
    $base64 = base64_encode($serial);
    $user_id = $userid;
    $user = Customer::find($user_id);
    $user->cart = $base64;
    $user->update();

}

function getCoupon()
{
    $currentURL = URL::to("/");
    $current_theme = themeID($currentURL);
    $current_theme_id = $current_theme['theme_id'];
    $front_store_id =  $current_theme['store_id'];

    $current_date = strtotime(date('Y-m-d'));
    $Coupon = '';
    if(session()->has('currentcoupon'))
    {
        $Coupon=session()->get('currentcoupon');
    }
    else
    {
        $get_coupon = Coupon::where('store_id',$front_store_id)->first();

        if(!empty($get_coupon) || $get_coupon != '')
        {
            $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
            $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

            if($current_date >= $start_date && $current_date < $end_date)
            {
                $Coupon = $get_coupon;
            }
            else
            {
                $Coupon = '';
            }

        }

    }
    return $Coupon;
}

function addtoCart($request,$productid,$sizeid)
{
    $delivery_type = session()->get('flag_post_code');

    if(session()->has('cart1'))
    {
        $arr = session()->get('cart1');
    }
    else
    {
        $arr = array();
    }

    if ($sizeid != 0)
    {
        $product = Product::with(['hasOneToppingProductPriceSize' => function ($q) use ($sizeid) {
            $q->where('id_product_price_size', $sizeid);
        }])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->hasOneToppingProductPriceSize['delivery_price']) ? $product->hasOneToppingProductPriceSize['delivery_price'] : 0.00;
            $data['del_price'] = $del_price;
        }
        $data['main_price'] = $product->hasOneToppingProductPriceSize['price'];
        $data['size'] = $product->hasOneToppingProductPriceSize->hasOneToppingSize['size'];
    }
    else
    {
        $product = Product::with(['hasOneProductDescription'])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->delivery_price) ? $product->delivery_price : 0.00;
            $data['del_price'] = $del_price;
        }
        $data['main_price'] = $product->price;
    }
    $data['name'] = $product->hasOneProductDescription['name'];
    $data['description'] = $product->hasOneProductDescription['description'];
    $data['image'] = $product->image;
    $data['model'] = $product->model;
    $data['quantity'] = 1;
    $data['product_id'] = $productid;

    if ($sizeid != 0)
    {
        if(isset($arr['size'][$sizeid]))
        {
            $arr['size'][$sizeid]['quantity'] = $arr['size'][$sizeid]['quantity'] + 1;
        }
        else
        {
            $arr['size'][$sizeid] =$data;
        }
    }
    else
    {
        if(isset($arr['withoutSize'][$productid]))
        {
            $arr['withoutSize'][$productid]['quantity'] = $arr['withoutSize'][$productid]['quantity'] + 1;
        }
        else
        {
            $arr['withoutSize'][$productid] =$data;
        }
    }

    $request->session()->put('cart1',$arr);
    $request->session()->save();
}



function getallproduct($id)
{

    $cat=$id;
    $categorytoproduct = Product_to_category::with(['hasOneProduct','hasOneDescription'])->whereHas('hasOneProduct', function ($query) use ($cat) {
        $query->where('category_id',$cat);
    })->get();
    // echo '<pre>';
    // print_r($categorytoproduct);
    // exit();
    return $categorytoproduct;
}
?>
