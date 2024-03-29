<?php

// THIS IS HELPER FILE
// ----------------------------------------------------------------------------------------------
// This File has been Includes Some Common Functions.
// That Function is used in anywhere in this Peoject.
// EX-: user_details(), storeThemeSettings() etc.
// ----------------------------------------------------------------------------------------------

use App\Models\AboutLayouts;
use App\Models\BestCategoryLayouts;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\CouponProduct;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerBanIp;
use App\Models\CustomerIP;
use App\Models\DeliverySettings;
use App\Models\Footers;
use App\Models\FreeItem;
use App\Models\FreeItemadd;
use App\Models\GallaryLayouts;
use App\Models\Headers;
use App\Models\HtmlBox;
use App\Models\OpenhourLayouts;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Store;
use App\Models\Topping;
use App\Models\ToppingProductPriceSize;
use App\Models\Product_to_category;
use App\Models\PhotoGallry;
use App\Models\PopularFoodsLayouts;
use App\Models\Product;
use App\Models\ProductToppingType;
use App\Models\RecentReviewsLayouts;
use App\Models\ReservationLayouts;
use App\Models\Reviews;
use App\Models\SlidersLayouts;
use App\Models\ToppingCatOption;
use App\Models\ToppingOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

use function PHPUnit\Framework\isNan;

// Function for Get user Details
function user_details()
{
    $user_dt = auth()->user();
    return $user_dt;
}




// Get Currency Symbol
function getCurrencySymbol($code)
{
    $currency = Currency::select('symbol_left')->where('code',$code)->first();
    $symbol = (isset($currency->symbol_left) && $currency->symbol_left != '') ? $currency->symbol_left : '£';
    return $symbol;
}




// Function for Get Total Ip Count
function gettotalip($ip)
{
    $ip = CustomerIP::where('ip',$ip)->count();
    return $ip;
}





// Function for Google Distance matrix calculation Api
function calculationDistanceMatrix($lat1,$long1,$lat2,$long2,$api_key)
{

    // Create a new CURL instance
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





// Function of get Distance
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





// Function for Active Current Theme
function themeActive()
{
    // Current Store ID
    $current_store_id = currentStoreId();

    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }
    $user_shop_id = $user_details['user_shop'];

    $key = 'theme_id';

    if($user_group_id == 1)
    {
        $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();
    }
    else
    {
        $setting = Settings::select('value')->where('store_id',$user_shop_id)->where('key',$key)->first();
    }

    $theme_id = isset($setting->value) ? $setting->value : '';

    return $theme_id;

}





// Function for Active Current Header
function headerActive()
{

    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Get Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'header_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Header ID
    $header_id = isset($setting->value) ? $setting->value : '';

    // Header Details
    $header_deatails = Headers::where('header_id',$header_id)->first();

    return $header_deatails;
}





// Function for Active Current Footer
function footerActive()
{

    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'footer_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Footer ID
    $footer_id = isset($setting->value) ? $setting->value : '';

    // Footer Details
    $footer_deatails = Footers::where('footer_id',$footer_id)->first();

    return $footer_deatails;
}





// Function for Active Current Gallary Layout
function gallaryActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }

    $key = 'gallary_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Gallary ID
    $gallary_id = isset($setting->value) ? $setting->value : '';

    // Gallary Details
    $gallary_deatails = GallaryLayouts::where('gallary_id',$gallary_id)->first();

    return $gallary_deatails;
}





// Function for Active Current Best Category Layout
function bestcategoryActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'bestcategory_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Best Category ID
    $bestcategory_id = isset($setting->value) ? $setting->value : '';

    // Best Category Details
    $bestcategory_deatails = BestCategoryLayouts::where('best_category_id',$bestcategory_id)->first();

    return $bestcategory_deatails;
}





// Function for Active Current Popular Food Layout
function popularfoodActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'popularfood_id';

    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Popular Food ID
    $popularfood_id = isset($setting->value) ? $setting->value : '';

    // Popular Food Details
    $popularfood_deatails = PopularFoodsLayouts::where('popular_food_id',$popularfood_id)->first();

    return $popularfood_deatails;
}





// Function for Active Current Slider Layout
function sliderActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'slider_id';

    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Slider ID
    $slider_id = isset($setting->value) ? $setting->value : '';

    // Header Details
    $slider_deatails = SlidersLayouts::where('slider_id',$slider_id)->first();

    return $slider_deatails;
}





// Function for Active Current Recent Review Layout
function recentreviewActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'review_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Review ID
    $review_id = isset($setting->value) ? $setting->value : '';

    // Reviews Layout Details
    $review_deatails = RecentReviewsLayouts::where('review_id',$review_id)->first();

    return $review_deatails;
}





// Function for Active Current Recent Review Layout
function reservationActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }

    $key = 'reservation_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Reservation ID
    $reservation_id = isset($setting->value) ? $setting->value : '';

    // Reservation Details
    $reservation_deatails = ReservationLayouts::where('reservation_id',$reservation_id)->first();

    return $reservation_deatails;
}





// // Function for Active Current About Layout
// function aboutActive()
// {
//     // User Details
//     $user_details = user_details();
//     if(isset($user_details))
//     {
//         $user_group_id = $user_details['user_group_id'];
//     }


//     // Current Store ID
//     if($user_group_id == 1)
//     {
//         $current_store_id = currentStoreId();
//     }
//     else
//     {
//         $current_store_id = $user_details['user_shop'];
//     }


//     $key = 'about_id';
//     // $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();
//     $setting = HtmlBox::select('about_layout_id')->where('store_id',$current_store_id)->first();

//     // About ID
//     $about_id = isset($setting->value) ? $setting->value : '';

//     // About Details
//     $about_deatails = AboutLayouts::where('about_id',$about_id)->first();

//     return $about_deatails;
// }





// Function for Active Current Open hours Layout
function openhoursActive()
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $key = 'openhour_id';

    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // Open Hours ID
    $openhour_id = isset($setting->value) ? $setting->value : '';

    // OpenHours Details
    $openhours_deatails = OpenhourLayouts::where('openhour_id',$openhour_id)->first();

    return $openhours_deatails;
}





// Get Layouts
function getLayouts($key,$current_layout_id,$layout_column_name)
{
    // User Details
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }


    // Get Current Store ID
    if($user_group_id == 1)
    {
        $current_store_id = currentStoreId();
    }
    else
    {
        $current_store_id = $user_details['user_shop'];
    }


    $get_header_settings = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->where($layout_column_name,$current_layout_id)->first();

    $unserial = isset($get_header_settings->value) ? unserialize($get_header_settings->value) : '';

    return $unserial;
}





// Function for Get Template Settings & Social Site Settings & Store Settings
function storeLayoutSettings($layout_id,$store_id,$setting_name,$key_name)
{
    if($setting_name == 'header_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $header_setting = isset($query->value) ? unserialize($query->value) : '';
        return $header_setting;
    }

    if($setting_name == 'slider_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $slider_setting = isset($query->value) ? unserialize($query->value) : '';
        return $slider_setting;
    }

    if($setting_name == 'about_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $about_setting = isset($query->value) ? unserialize($query->value) : '';
        return $about_setting;
    }

    if($setting_name == 'bestcategory_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $bestcategory_setting = isset($query->value) ? unserialize($query->value) : '';
        return $bestcategory_setting;
    }

    if($setting_name == 'popularfood_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $popularfood_setting = isset($query->value) ? unserialize($query->value) : '';
        return $popularfood_setting;
    }

    if($setting_name == 'review_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $review_setting = isset($query->value) ? unserialize($query->value) : '';
        return $review_setting;
    }

    if($setting_name == 'reservation_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $reservation_setting = isset($query->value) ? unserialize($query->value) : '';
        return $reservation_setting;
    }

    if($setting_name == 'gallary_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $gallary_setting = isset($query->value) ? unserialize($query->value) : '';
        return $gallary_setting;
    }

    if($setting_name == 'openhour_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $openhour_setting = isset($query->value) ? unserialize($query->value) : '';
        return $openhour_setting;
    }

    if($setting_name == 'footer_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where($key_name,$layout_id)->where('key',$setting_name)->first();
        $footer_setting = isset($query->value) ? unserialize($query->value) : '';
        return $footer_setting;
    }

    if($setting_name == 'general_settings')
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('key',$setting_name)->first();
        $general_setting = isset($query->value) ? unserialize($query->value) : '';
        return $general_setting;
    }

}





// Function for Get Public URL
function public_url()
{
    return asset('');
}





// Function of Get CSS URL
function get_css_url()
{
    // return 'https://the-public.co.uk/App-Myfood/myfoodbasket/';
    // return 'http://192.168.1.116/opencart/';
    // return 'http://192.168.1.3/opencart/';
    return 'http://192.168.1.73/ECOMM/';
}





// Function for Get Top 10 Store Sales
function getTopTenSales($range)
{
    $current_store_id = currentStoreId();

    $user_details = user_details();

    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }
    $user_shop_id = $user_details['user_shop'];

    if($user_group_id == 1)
    {
        if($current_store_id == 0)
        {
            if($range == 'alltime')
            {
                $query = Orders::where('order_status_id','=',15)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'day')
            {
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'yesterday')
            {
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'week')
            {
				$monday =  strtotime("monday this week");
				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
				$this_week_sd = date("Y-m-d",$monday);
				$this_week_ed = date("Y-m-d",$sunday);

				$startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
				$endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'month')
            {
				$startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'year')
            {
				$this_year_ini = new DateTime('first day of January this year');
				$this_year_end = new DateTime('last day of December this year');

				$this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				$this_year_end = $this_year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'lastweek')
            {
				$previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d",$start_week);
				$lst_sunday = date("Y-m-d",$end_week);

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'lastmonth')
            {
				$month_ini = new DateTime("first day of last month");
				$month_end = new DateTime("last day of last month");
				$lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				$lst_month_end = $month_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'lastyear')
            {
				$year_ini = new DateTime('first day of January last year');
				$year_end = new DateTime('last day of December last year');

				$lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				$lst_year_end = $year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

        }
        else
        {
            if($range == 'alltime')
            {
                $query = Orders::where('order_status_id','=',15)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'day')
            {
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'yesterday')
            {
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'week')
            {
				$monday =  strtotime("monday this week");
				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
				$this_week_sd = date("Y-m-d",$monday);
				$this_week_ed = date("Y-m-d",$sunday);

				$startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
				$endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'month')
            {
				$startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'year')
            {
				$this_year_ini = new DateTime('first day of January this year');
				$this_year_end = new DateTime('last day of December this year');

				$this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				$this_year_end = $this_year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'lastweek')
            {
				$previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d",$start_week);
				$lst_sunday = date("Y-m-d",$end_week);

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'lastmonth')
            {
				$month_ini = new DateTime("first day of last month");
				$month_end = new DateTime("last day of last month");
				$lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				$lst_month_end = $month_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'lastyear')
            {
				$year_ini = new DateTime('first day of January last year');
				$year_end = new DateTime('last day of December last year');

				$lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				$lst_year_end = $year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->where('store_id',$current_store_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

        }
    }
    else
    {
        if($range == 'alltime')
        {
            $query = Orders::where('order_status_id','=',15)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'day')
        {
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'yesterday')
        {
            $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
            $endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'week')
        {
            $monday =  strtotime("monday this week");
            $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
            $this_week_sd = date("Y-m-d",$monday);
            $this_week_ed = date("Y-m-d",$sunday);

            $startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
            $endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'month')
        {
            $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
            $lastDate_this_month  = date('Y-m-t 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'year')
        {
            $this_year_ini = new DateTime('first day of January this year');
            $this_year_end = new DateTime('last day of December this year');

            $this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
            $this_year_end = $this_year_end->format('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'lastweek')
        {
            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last monday midnight",$previous_week);
            $end_week = strtotime("next sunday",$start_week);

            $lst_monday = date("Y-m-d",$start_week);
            $lst_sunday = date("Y-m-d",$end_week);

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'lastmonth')
        {
            $month_ini = new DateTime("first day of last month");
            $month_end = new DateTime("last day of last month");
            $lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
            $lst_month_end = $month_end->format('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'lastyear')
        {
            $year_ini = new DateTime('first day of January last year');
            $year_end = new DateTime('last day of December last year');

            $lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
            $lst_year_end = $year_end->format('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->where('store_id',$user_shop_id)->selectRaw("oc_order.store_id,oc_order.store_name AS store_name, SUM(CASE WHEN order_status_id = '15' THEN total ELSE null END) AS total_sale, count(*) AS order_count, count(DISTINCT customer_id) AS customer_count, SUM(CASE WHEN payment_code = 'cod' THEN total ELSE null END) AS cod_total, SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE null END) AS card_total")->groupBy('store_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }
    }


}





// Function for get top 10 Customers
function getTop10Customers($range)
{
    $current_store_id = currentStoreId();

    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }
    $user_shop_id = $user_details['user_shop'];

    if($user_group_id == 1)
    {
        if($current_store_id == 0)
        {
            if($range == 'alltime')
            {
                $query = Orders::where('order_status_id','=',15)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'day')
            {
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'yesterday')
            {
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'week')
            {
                $monday = strtotime("monday this week");

				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
				$this_week_sd = date("Y-m-d",$monday);
				$this_week_ed = date("Y-m-d",$sunday);

				$startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
				$endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<',$endDate)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'month')
            {
                $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'year')
            {
                $this_year_ini = new DateTime('first day of January this year');
				$this_year_end = new DateTime('last day of December this year');

				$this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				$this_year_end = $this_year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'lastweek')
            {
                $previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d 00:00:00",$start_week);
				$lst_sunday = date("Y-m-d 23:59:59",$end_week);

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'lastmonth')
            {
                $month_ini = new DateTime("first day of last month");
				$month_end = new DateTime("last day of last month");
				$lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				$lst_month_end = $month_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'lastyear')
            {
                $year_ini = new DateTime('first day of January last year');
				$year_end = new DateTime('last day of December last year');

				$lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				$lst_year_end = $year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

        }
        else
        {
            if($range == 'alltime')
            {
                $query = Orders::where('order_status_id','=',15)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'day')
            {
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();

                return $query;
            }

            elseif($range == 'yesterday')
            {
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'week')
            {
                $monday = strtotime("monday this week");

				$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
				$this_week_sd = date("Y-m-d",$monday);
				$this_week_ed = date("Y-m-d",$sunday);

				$startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
				$endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<',$endDate)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'month')
            {
                $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'year')
            {
                $this_year_ini = new DateTime('first day of January this year');
				$this_year_end = new DateTime('last day of December this year');

				$this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				$this_year_end = $this_year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'lastweek')
            {
                $previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d 00:00:00",$start_week);
				$lst_sunday = date("Y-m-d 23:59:59",$end_week);

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'lastmonth')
            {
                $month_ini = new DateTime("first day of last month");
				$month_end = new DateTime("last day of last month");
				$lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				$lst_month_end = $month_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }

            elseif($range == 'lastyear')
            {
                $year_ini = new DateTime('first day of January last year');
				$year_end = new DateTime('last day of December last year');

				$lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				$lst_year_end = $year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->where('store_id',$current_store_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
                return $query;
            }
        }
    }
    else
    {
        if($range == 'alltime')
        {
            $query = Orders::where('order_status_id','=',15)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'day')
        {
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();

            return $query;
        }

        elseif($range == 'yesterday')
        {
            $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
            $endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'week')
        {
            $monday = strtotime("monday this week");

            $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
            $this_week_sd = date("Y-m-d",$monday);
            $this_week_ed = date("Y-m-d",$sunday);

            $startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
            $endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate)->where('date_added','<',$endDate)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'month')
        {
            $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
            $lastDate_this_month  = date('Y-m-t 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'year')
        {
            $this_year_ini = new DateTime('first day of January this year');
            $this_year_end = new DateTime('last day of December this year');

            $this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
            $this_year_end = $this_year_end->format('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'lastweek')
        {
            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last monday midnight",$previous_week);
            $end_week = strtotime("next sunday",$start_week);

            $lst_monday = date("Y-m-d 00:00:00",$start_week);
            $lst_sunday = date("Y-m-d 23:59:59",$end_week);

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'lastmonth')
        {
            $month_ini = new DateTime("first day of last month");
            $month_end = new DateTime("last day of last month");
            $lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
            $lst_month_end = $month_end->format('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }

        elseif($range == 'lastyear')
        {
            $year_ini = new DateTime('first day of January last year');
            $year_end = new DateTime('last day of December last year');

            $lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
            $lst_year_end = $year_end->format('Y-m-d 23:59:59');

            $query = Orders::where('order_status_id','=',15)->where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->where('store_id',$user_shop_id)->selectRaw("count(DISTINCT customer_id) AS CustomerCount, customer_id,SUM(CASE WHEN order_status_id = '15' THEN total ELSE 0 END) AS total_sale,SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cod_total,SUM(CASE WHEN payment_code != 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS card_total,firstname,lastname")->groupBy('customer_id')->orderBy('total_sale','DESC')->limit(10)->get();
            return $query;
        }
    }

}





// Function for get General Totals for Stores
function getGeneralTotals($range)
{
    $current_store_id = currentStoreId();

    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }
    $user_shop_id = $user_details['user_shop'];

    if($user_group_id == 1)
    {
        if($current_store_id == 0)
        {
            if($range == 'alltime')
            {
                $query = Orders::selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'day')
            {
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$startDate)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'yesterday')
            {
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'week')
            {
                $monday = $monday1 = strtotime("monday this week");
				$sunday = strtotime(date("Y-m-d",$monday1)." +6 days");
				$this_week_sd = date("Y-m-d",$monday1);
				$this_week_ed = date("Y-m-d",$sunday);

				$startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
				$endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

                $query = Orders::where('date_added','>=',$startDate)->where('date_added','<',$endDate)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'month')
            {
                $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');

                $query = Orders::where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'year')
            {
                $this_year_ini = new DateTime('first day of January this year');
				$this_year_end = new DateTime('last day of December this year');

				$this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				$this_year_end = $this_year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'lastweek')
            {
                $previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d",$start_week);
				$lst_sunday = date("Y-m-d",$end_week);

                $query = Orders::where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'lastmonth')
            {
                $month_ini = new DateTime("first day of last month");
				$month_end = new DateTime("last day of last month");
				$lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				$lst_month_end = $month_end->format('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'lastyear')
            {
                $year_ini = new DateTime('first day of January last year');
				$year_end = new DateTime('last day of December last year');

				$lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				$lst_year_end = $year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

        }
        else
        {
            if($range == 'alltime')
            {
                $query = Orders::where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'day')
            {
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$startDate)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'yesterday')
            {
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'week')
            {
                $monday = $monday1 = strtotime("monday this week");
				$sunday = strtotime(date("Y-m-d",$monday1)." +6 days");
				$this_week_sd = date("Y-m-d",$monday1);
				$this_week_ed = date("Y-m-d",$sunday);

				$startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
				$endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

                $query = Orders::where('date_added','>=',$startDate)->where('date_added','<',$endDate)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'month')
            {
                $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');

                $query = Orders::where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'year')
            {
                $this_year_ini = new DateTime('first day of January this year');
				$this_year_end = new DateTime('last day of December this year');

				$this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				$this_year_end = $this_year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'lastweek')
            {
                $previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d",$start_week);
				$lst_sunday = date("Y-m-d",$end_week);

                $query = Orders::where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'lastmonth')
            {
                $month_ini = new DateTime("first day of last month");
				$month_end = new DateTime("last day of last month");
				$lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				$lst_month_end = $month_end->format('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }

            if($range == 'lastyear')
            {
                $year_ini = new DateTime('first day of January last year');
				$year_end = new DateTime('last day of December last year');

				$lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				$lst_year_end = $year_end->format('Y-m-d 23:59:59');

                $query = Orders::where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->where('store_id',$current_store_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

                return $query;
            }
        }
    }
    else
    {
        if($range == 'alltime')
        {
            $query = Orders::where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'day')
        {
            $startDate = date('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59');

            $query = Orders::where('date_added','>=',$startDate)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'yesterday')
        {
            $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
            $endDate   = date('Y-m-d 23:59:59',strtotime("-1 days")); //date('Y-m-d 23:59:59');

            $query = Orders::where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'week')
        {
            $monday = $monday1 = strtotime("monday this week");
            $sunday = strtotime(date("Y-m-d",$monday1)." +6 days");
            $this_week_sd = date("Y-m-d",$monday1);
            $this_week_ed = date("Y-m-d",$sunday);

            $startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
            $endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));

            $query = Orders::where('date_added','>=',$startDate)->where('date_added','<',$endDate)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'month')
        {
            $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
            $lastDate_this_month  = date('Y-m-t 23:59:59');

            $query = Orders::where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'year')
        {
            $this_year_ini = new DateTime('first day of January this year');
            $this_year_end = new DateTime('last day of December this year');

            $this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
            $this_year_end = $this_year_end->format('Y-m-d 23:59:59');

            $query = Orders::where('date_added','>=',$this_year_strt)->where('date_added','<=',$this_year_end)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'lastweek')
        {
            $previous_week = strtotime("-1 week +1 day");

            $start_week = strtotime("last monday midnight",$previous_week);
            $end_week = strtotime("next sunday",$start_week);

            $lst_monday = date("Y-m-d",$start_week);
            $lst_sunday = date("Y-m-d",$end_week);

            $query = Orders::where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'lastmonth')
        {
            $month_ini = new DateTime("first day of last month");
            $month_end = new DateTime("last day of last month");
            $lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
            $lst_month_end = $month_end->format('Y-m-d 23:59:59');

            $query = Orders::where('date_added','>=',$lst_month_strt)->where('date_added','<=',$lst_month_end)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }

        if($range == 'lastyear')
        {
            $year_ini = new DateTime('first day of January last year');
            $year_end = new DateTime('last day of December last year');

            $lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
            $lst_year_end = $year_end->format('Y-m-d 23:59:59');

            $query = Orders::where('date_added','>=',$lst_year_strt)->where('date_added','<=',$lst_year_end)->where('store_id',$user_shop_id)->selectRaw("SUM(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN total ELSE 0 END) AS cash_total, COUNT(CASE WHEN payment_code = 'cod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS cash_count, SUM(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN total ELSE 0 END) AS worldpayhp_total, COUNT(CASE WHEN payment_code = 'worldpayhp' AND order_status_id = '15' THEN order_id ELSE NULL END) AS worldpayhp_count, SUM(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN total ELSE 0 END) AS pp_express_total, COUNT(CASE WHEN payment_code = 'pp_express' AND order_status_id = '15' THEN order_id ELSE NULL END) AS pp_express_count, SUM(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN total ELSE 0 END) AS ccod_total, COUNT(CASE WHEN payment_code = 'ccod' AND order_status_id = '15' THEN order_id ELSE NULL END) AS ccod_count, SUM(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN total ELSE 0 END) AS mfb_total, COUNT(CASE WHEN payment_code = 'myfoodbasketpayments_gateway' AND order_status_id = '15' THEN order_id ELSE NULL END) AS mfb_count, SUM(CASE WHEN order_status_id = '7' THEN total ELSE 0 END) AS rejct_total, COUNT(CASE WHEN order_status_id = '7' THEN order_id ELSE NULL END) AS rejct_count")->first();

            return $query;
        }
    }
}


function getorderdetails($range,$customDate,$type,$orderpayment,$status){

    $startDate = '';
    $endDate = '';

    $current_store_id = currentStoreId();

    if(empty($customDate))
    {
        if($range == 'day')
        {
            // Current Date
            $startDate = date('Y-m-d 00:00:00');

            // Order Details
            $orders_query = Orders::where('date_added','>=',$startDate);
            // Total Accepted Orders
            $accepted_order_query = Orders::where('date_added','>=',$startDate);
            // Order Total
            $total_query = Orders::where('date_added','>=',$startDate);
            // Total Collections Order
            $collection_count_query = Orders::where('date_added','>=',$startDate)->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::where('date_added','>=',$startDate)->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::where('date_added','>=',$startDate)->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::where('date_added','>=',$startDate)->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::where('date_added','>=',$startDate)->where('customer_group_id',0);
            // Total of Guest Customers
            $guest_customer_total_query = Orders::where('date_added','>=',$startDate)->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::where('date_added','>=',$startDate)->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::where('date_added','>=',$startDate)->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }


            // Delivery Type Query
            if(!empty($type))
            {
                // Order Details
                $orders_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Order Total
                $total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
            }


            // Payment Type Query
            if(!empty($orderpayment))
            {
                // Order Details
                $orders_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Order Total
                $total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
            }


            // Order Status Query
            if(!empty($status))
            {
                // Order Details
                $orders_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Order Total
                $total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
            }


            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');


        }
        elseif ($range == 'week')
        {
            $monday =  strtotime("monday this week");
            $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
            $this_week_sd = date("Y-m-d",$monday);
            $this_week_ed = date("Y-m-d",$sunday);

            // Start Date
            $startDate = date("Y-m-d 00:00:00",strtotime($this_week_sd));
            // Enddate
            $endDate = date('Y-m-d 00:00:00', strtotime($this_week_ed . ' +1 day'));


            // Order Details
            $orders_query = Orders::whereBetween('date_added', [$startDate, $endDate]);
            // Total Accepted Orders
            $accepted_order_query = Orders::whereBetween('date_added', [$startDate, $endDate]);
            // Order Total
            $total_query = Orders::whereBetween('date_added', [$startDate, $endDate]);
            // Total Collections Order
            $collection_count_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('customer_group_id',0);
            // Total of Guest Customers
            $guest_customer_total_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::whereBetween('date_added', [$startDate, $endDate])->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }


            // Delivery Type Query
            if(!empty($type))
            {
                // Order Details
                $orders_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Order Total
                $total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
            }


            // Payment Type Query
            if(!empty($orderpayment))
            {
                // Order Details
                $orders_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Order Total
                $total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
            }


            // Order Status Query
            if(!empty($status))
            {
                // Order Details
                $orders_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Order Total
                $total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
            }

            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');


        }
        elseif ($range == 'month')
        {
            // Start Date of This Month
            $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day

            // End Date of this Month
            $lastDate_this_month  = date('Y-m-t 23:59:59');


            // Order Details
            $orders_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month]);
            // Total Accepted Orders
            $accepted_order_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month]);
            // Order Total
            $total_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month]);
            // Total Collections Order
            $collection_count_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('customer_group_id',0);
            // Total of Guest Customers
            $guest_customer_total_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::whereBetween('date_added', [$startDate_this_month, $lastDate_this_month])->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }


            // Delivery Type Query
            if(!empty($type))
            {
                // Order Details
                $orders_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Order Total
                $total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
            }


            // Payment Type Query
            if(!empty($orderpayment))
            {
                // Order Details
                $orders_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Order Total
                $total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
            }


            // Order Status Query
            if(!empty($status))
            {
                // Order Details
                $orders_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Order Total
                $total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
            }

            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');

        }
        elseif($range == 'year')
        {
            // First Day Of Current Year
            $this_year_ini = new DateTime('first day of January this year');

            // Last Day Of Current Year
            $this_year_end = new DateTime('last day of December this year');

            $this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
            $this_year_end = $this_year_end->format('Y-m-d 23:59:59');


            // Order Details
            $orders_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end]);
            // Total Accepted Orders
            $accepted_order_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end]);
            // Order Total
            $total_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end]);
            // Total Collections Order
            $collection_count_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('customer_group_id',0);
            // Total of Guest Customers
            $guest_customer_total_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::whereBetween('date_added', [$this_year_strt, $this_year_end])->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }


            // Delivery Type Query
            if(!empty($type))
            {
                // Order Details
                $orders_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Order Total
                $total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($type) {
                    $q->where("shipping_method", $type);
                });
            }


            // Payment Type Query
            if(!empty($orderpayment))
            {
                // Order Details
                $orders_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Order Total
                $total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($orderpayment) {
                    $q->where("payment_code", $orderpayment);
                });
            }


            // Order Status Query
            if(!empty($status))
            {
                // Order Details
                $orders_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Order Total
                $total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($status) {
                    $q->where("order_status_id", $status);
                });
            }

            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');

        }
    }
    else
    {
        $start_d = $customDate['start_date'];
        $end_d = $customDate['end_date'];
        $dateType = $customDate['date_type'];

        if($range == 'day')
        {
            if($dateType == 'next')
            {
                // Current Date
                $start_date = date('Y-m-d 00:00:00', strtotime("+1 day", strtotime($start_d)));
                $end_date = date('Y-m-d 23:59:00', strtotime("+1 day", strtotime($start_d)));
            }
            elseif($dateType == 'pre')
            {
                // Current Date
                $start_date = date('Y-m-d 00:00:00', strtotime("-1 day", strtotime($start_d)));
                $end_date = date('Y-m-d 23:59:00', strtotime("-1 day", strtotime($start_d)));
            }

            // Order Details
            $orders_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Total Accepted Orders
            $accepted_order_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Order Total
            $total_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Total Collections Order
            $collection_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',0);
            // Total of Guest Customers
            $guest_customer_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }

            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');


            // Return Start Date
            $startDate = date('00:00 d-m-Y',strtotime($start_date));
            $endDate = date('23:59 d-m-Y',strtotime($start_date));

        }
        elseif ($range == 'week')
        {

            if($dateType == 'next')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("+7 day", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+6 day", strtotime($start_date)));
            }
            elseif($dateType == 'pre')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("-7 day", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+6 day", strtotime($start_date)));
            }

            // Order Details
            $orders_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Total Accepted Orders
            $accepted_order_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Order Total
            $total_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Total Collections Order
            $collection_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',0);
          // Total of Guest Customers
            $guest_customer_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }

            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');


            // Return Start Date
            $startDate = date('00:00 d-m-Y',strtotime($start_date));
            $endDate = date('23:59 d-m-Y',strtotime($end_date));

        }
        elseif ($range == 'month')
        {
            if($dateType == 'next')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("+01 month", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+01 month", strtotime($start_date)));
            }
            elseif($dateType == 'pre')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("-01 month", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+01 month", strtotime($start_date)));
            }

            // Order Details
            $orders_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Total Accepted Orders
            $accepted_order_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Order Total
            $total_query = Orders::whereBetween('date_added', [$start_date, $end_date]);
            // Total Collections Order
            $collection_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','collection');
            // Total of Collection Orders
            $collection_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','collection');
            // Total Delivery Order
            $delivery_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','delivery');
            // Total of Delivery Orders
            $delivery_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('flag_post_code','delivery');
            // Total Guest Customers
            $guest_customer_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',0);
          // Total of Guest Customers
            $guest_customer_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',0);
            // Total Customers
            $customer_count_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',1);
            // Total of Customers
            $customer_total_query = Orders::whereBetween('date_added', [$start_date, $end_date])->where('customer_group_id',1);


            // Store ID Query
            if($current_store_id != 0 || $current_store_id != '' || !empty($current_store_id))
            {
                // Order Details
                $orders_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Accepted Orders
                $accepted_order_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Order Total
                $total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Collections Order
                $collection_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Collection Orders
                $collection_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Delivery Order
                $delivery_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Delivery Orders
                $delivery_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Guest Customers
                $guest_customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Guest Customers
                $guest_customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total Customers
                $customer_count_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
                // Total of Customers
                $customer_total_query->where(function ($q) use ($current_store_id) {
                    $q->where("store_id", $current_store_id);
                });
            }

            $orders = $orders_query->get();
            $accepted_order = $accepted_order_query->count();
            $total = $total_query->sum('total');
            $collection_count = $collection_count_query->count();
            $collection_total = $collection_total_query->sum('total');
            $delivery_count = $delivery_count_query->count();
            $delivery_total = $delivery_total_query->sum('total');
            $guest_customer_count = $guest_customer_count_query->count();
            $guest_customer_total = $guest_customer_total_query->sum('total');
            $customer_count = $customer_count_query->count();
            $customer_total = $customer_total_query->sum('total');

            // Return Start Date
            $startDate = date('00:00 d-m-Y',strtotime($start_date));
            $endDate = date('23:59 d-m-Y',strtotime($end_date));

        }

    }

    return  ['orders'=>$orders,'accepted_order'=>$accepted_order,'total'=>$total,'collection_count'=>$collection_count,'collection_total'=>$collection_total,'delivery_count'=>$delivery_count,'delivery_total'=>$delivery_total,'guest_customer_count'=>$guest_customer_count,'guest_customer_total'=>$guest_customer_total ,'customer_count'=>$customer_count,'customer_total'=>$customer_total,'startDate'=>$startDate,'endDate'=>$endDate];
}



// Function for Check Order Status
function checkOrderStatus($order_id)
{
    $order_dt = Orders::where('order_id',$order_id)->first();
    $status_id = isset($order_dt->order_status_id) ? $order_dt->order_status_id : '';
    return $status_id;
}





// Function for Get Theme ID & Store ID
function layoutID($currentURL,$layout_key)
{
    $slash = substr($currentURL, -1);

    if($slash != '/')
    {
        $new_url = $currentURL .= '/';
    }
    else
    {
        $new_url = $currentURL;
    }
    $storeDetails = Store::where('url',$new_url)->orWhere('ssl',$new_url)->first();

    $store_id = isset($storeDetails->store_id) ? $storeDetails->store_id : '';

    $key = $layout_key;
    $setting = Settings::select('value')->where('store_id',$store_id)->where('key',$key)->first();

    $new_var = '$'.$layout_key;

    $new_var = isset($setting->value) ? $setting->value : '';

    $new = ([
        $layout_key => $new_var,
        'store_id' => $store_id,
    ]);

    return $new;

}





// Function for Get Product Count
function getproductcount($demo)
{
	$productcount=Product_to_category::where('category_id',$demo)->count();

	return $productcount;


}





// Function for get Product
function getproduct($front_store_id,$cat_id)
{
    $flag_post_code =session()->get('flag_post_code');
    $both ='both';
    if(isset($flag_post_code)){
        $product=Product_to_category::with(['hasOneProduct','hasOneDescription','hasOneToppingProductPriceSize'])->whereHas('hasOneProduct', function ($query) use ($cat_id) {
            $query->where('category_id', $cat_id);
        })->whereHas('hasOneProduct', function ($q) use ($flag_post_code, $both) {
            $q->whereIn('order_type',[$flag_post_code, $both]);
        })->get();
    }
    else{
        $product=Product_to_category::with(['hasOneProduct','hasOneDescription','hasOneToppingProductPriceSize'])->whereHas('hasOneProduct', function ($query) use ($cat_id) {
            $query->where('category_id', $cat_id);
        })->get();
    }
    return $product;
}





// Function for Get Topping Procuct Price Size
function getsize($product_id)
{

    $size =ToppingProductPriceSize::with(['hasOneToppingSize'])->where('id_product',$product_id)->get();
    return $size;

}





// Function for Get Images for Gallary
function getimage($current_store)
{
    if ($current_store == 0)
    {
        $image=PhotoGallry::orderBy('image_id','ASC')->get();
    }
    else {
        $image=PhotoGallry::where('store_id',$current_store)->orderBy('image_id','ASC')->get();
    }
    return $image;
}





// Function for Get Gallary Settings
function getphoto($current_store,$key)
{
    $gallery = Settings::where('key',$key)->where('store_id',$current_store)->first();
    $new = isset($gallery->value) ? $gallery->value : '';
    return $new;
}





// Function for Get Fonts
function getFonts()
{
    $fonts = array(
        "Cedarville Cursive"      => "'Cedarville Cursive', cursive",
        "Roboto"      => "'Roboto', sans-serif",
        "League Gothic"      => "'League Gothic', sans-serif",
        "Open Sans"      => "'Open Sans', sans-serif",
        "Raleway"      => "'Raleway', sans-serif",
        "Joan"      => "'Joan', serif",
        "Ubuntu"      => "'Ubuntu', sans-serif",
        "Roboto Slab"      => "'Roboto Slab', serif",
        "Noto Sans"      => "'Noto Sans', sans-serif",
        "Kdam Thmor Pro"      => "'Kdam Thmor Pro', sans-serif",
        "Roboto Mono"      => "'Roboto Mono', monospace",
	);

    return $fonts;
}





// Function for Get Store Details
function getStoreDetails($storeid,$key)
{
    $gedetails = Settings::where('key',$key)->where('store_id',$storeid)->first();
    $new = isset($gedetails->value) ? $gedetails->value : '';
    return $new;
}





// Function for Get Loyality Details
function getLoyaltyDetails($storeid,$key)
{

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





// Function for get Current Store ID for admin panel
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





// Function for Check Ban IP
function checkBanIp($ip)
{
    $ip = CustomerBanIp::select('ip')->where('ip',$ip)->first();
    return $ip;
}





// Function for Check New Model
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





// Function for get All Stores
function getStores()
{
    $stores = Store::get();
    return $stores;
}





// Function for get Current Store URL
function getCurrentStoreURL($id)
{
    $store = Store::select('ssl')->where('store_id',$id)->first();
    $url = isset($store->ssl) ? $store->ssl : '';
    return $url;
}





// Function for Get Sub option for Menu Options
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





// Function for Users Shop details
function user_shop_detail($shopID)
{
    $store_dt = Store::where('store_id',$shopID)->first();
    return $store_dt;
}





// Function for Get Zones by Country ID
function getZonebyId($zid)
{
    $zone = Region::where('zone_id',$zid)->first();
    return $zone;
}





// Function for Genrate random Token
function genratetoken($length = 32)
{
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $max = strlen($string) - 1;

    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $string[mt_rand(0, $max)];
    }

    return $token;
}





// Function for Sidebar Main Menu
function sidebar()
{
    $all_menu = MainMenu::orderBy('menu_order','ASC')->get();
    return $all_menu;
}





// Function for Sidebar Menu of Submenu
function submenu($menu_id)
{
    $sub_menu = Submenu::where('menu_id',$menu_id)->where('is_hidden','!=',1)->get();
    return $sub_menu;
}





// Function for  SubMenu of Submenu
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





// Function for Get User Role Action
function get_rel_userrole_action($where)
{
    $user_role_action = Permission::where($where)->first();
    return $user_role_action;
}





// Function for Fetch Other Users Sidebar Menu
function fetch_otherusers_mainmenu($where)
{
    $resultset = MainMenu::where($where)->select('oc_main_menu.*')->join('oc_userrole_actions','oc_userrole_actions.menu_id','=','oc_main_menu.id')->orderBy('oc_main_menu.menu_order')->get();
    return $resultset;
}





// Function for Fetch Other Users Sidebar Menu of Submenu
function fetch_otherusers_mainmenu_submenu($where)
{
    $resultset = Permission::where($where)->where('oc_menu_actions.is_hidden','!=',4)->select('oc_menu_actions.*')->join('oc_menu_actions','oc_menu_actions.id','=','oc_userrole_actions.action_id')->orderBy('oc_menu_actions.id')->get();
    return $resultset;
}





// Function for Get Products Price Size
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





// Function for Check User Role for Menu
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





// Function for Check Userrole for Single Menu
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





// Function for Get Submenus Array
function fetch_mainmenu_submenucolumn($id)
{
    $subMenu = SubMenu::where('menu_id',$id)->where('oc_menu_actions.is_hidden','!=',4)->select('slugurl','parent_id','id','menu_id')->get()->toArray();

    $arr = array_map(function ($value) {
        return $value;
    }, $subMenu);

    return $arr;

}





// Function for Get Submenu of Submenu Array
function fetch_submenuof_submenu($id)
{
    $subMenu = SubMenu::where('parent_id',$id)->where('oc_menu_actions.is_hidden','!=',4)->select('slugurl','parent_id')->get()->toArray();

    $arr = array_map(function ($value) {
        return $value;
    }, $subMenu);

    return $arr;

}





// Function for Get Submenu of Submenu Array
function fetch_subof_sub($id)
{
    $subMenu = SubMenu::where('parent_id',$id)->where('oc_menu_actions.is_hidden','!=',4)->where('slugurl','!=','')->select('slugurl','parent_id')->get()->toArray();

    $arr = array_map(function ($value) {
        return $value;
    }, $subMenu);

    return $arr;

}





// Function for Open-Close Time
function openclosetime()
{
    // date_default_timezone_set("Asia/Kolkata");

    // exit();
    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");

    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];

    // Current Date
    $curr_date = date('d-m-Y');

    // StrTo Close date
    $str_to_close_date = strtotime(date('Y-m-d'));

    // Current Time
    $curr_time =  time();

    // Get Current Day
    $curr_day = date("l",strtotime($curr_date));

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


    $time_data = [];
    $data = [];

    foreach($key as $newkey)
    {
        $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $newkey)->first();
        $time_data[$newkey] = isset($query->value) ? $query->value : '';
    }

    // Get Days from DB
    $get_business_days = isset($time_data['bussines']) ? unserialize($time_data['bussines']) : '';

    // Get Closing Date from DB
    $get_closing_dates = isset($time_data['closing_dates']) ? unserialize($time_data['closing_dates']) : '';

    // Get Delivery Same Business
    $delivery_same_bussiness = isset($time_data['delivery_same_bussiness']) ? $time_data['delivery_same_bussiness'] : 0;

    // Get Collection Same Business
    $collection_same_bussiness = isset($time_data['collection_same_bussiness']) ? $time_data['collection_same_bussiness'] : 0;


    // Get Delivery Gap Time
    $get_delivery_gap_time = (isset($time_data['delivery_gaptime']) && !empty($time_data['delivery_gaptime'])) ? $time_data['delivery_gaptime'] : 0;

    // Get Collection Gap Time
    $get_collection_gap_time = (isset($time_data['collection_gaptime']) && !empty($time_data['collection_gaptime'])) ? $time_data['collection_gaptime'] : 0;

    // Get Delivery Days from DB
    $get_delivery_days = isset($time_data['delivery']) ? unserialize($time_data['delivery']) : '';

    // Get Collection Days from DB
    $get_collection_days = isset($time_data['collection']) ? unserialize($time_data['collection']) : '';


    if(!empty($get_business_days['day']) ||  isset($get_business_days['day']))
    {
        foreach($get_business_days['day'] as $key => $bdays)
        {
            $bdays_array = $bdays;

            if(!empty(array_filter($get_closing_dates)))
            {
                foreach($get_closing_dates as $key => $cdate)
                {
                    $new_c_date = strtotime($cdate);

                    if($str_to_close_date == $new_c_date)
                    {
                        $data['store_open_close'] = 'close';
                        break;
                    }
                }
            }
            else
            {
                if(in_array('Everyday',$bdays_array))
                {
                    $data['day'] = 'Everyday';
                    $data['from_time'] = strtotime($get_business_days['from'][$key]);
                    $data['to_time'] = strtotime($get_business_days['to'][$key]);

                    if($curr_time >= $data['from_time'] && $curr_time <= $data['to_time'])
                    {
                        $data['store_open_close'] = 'open';
                    }
                    else
                    {
                        $data['store_open_close'] = 'close';
                    }

                    break;
                }
                elseif(in_array($curr_day,$bdays_array))
                {
                    $data['day'] = $curr_day;
                    $data['from_time'] = strtotime($get_business_days['from'][$key]);
                    $data['to_time'] = strtotime($get_business_days['to'][$key]);

                    if($curr_time >= $data['from_time'] && $curr_time <= $data['to_time'])
                    {
                        $data['store_open_close'] = 'open';
                    }
                    else
                    {
                        $data['store_open_close'] = 'close';
                    }

                    break;
                }
            }

        }

    }
    else
    {
        $data['store_open_close'] = 'close';
    }

    $data['delivery_gap'] = $get_delivery_gap_time;
    $data['collection_gap'] = $get_collection_gap_time;

    // Delivery Hours
    if(!empty($delivery_same_bussiness) ||  isset($delivery_same_bussiness))
    {
        if($delivery_same_bussiness == 1)
        {
            $data['delivery_same_business'] = 'yes';

            $delivery_business_from_time = isset($data['from_time']) ? $data['from_time'] : '';
            $delivery_business_to_time = isset($data['to_time']) ? $data['to_time'] : '';

            $manghour = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
            $mangminus = array('00', '15', '30', '45');

            $delivery_time_result = array();
            $timebetween = date('H:i', ($curr_time + $get_delivery_gap_time * 60));

            foreach ($manghour as $hour)
            {
                foreach ($mangminus as $minus)
                {
                    $temptime = $hour . ':' . $minus;
                    if (strtotime($timebetween) < strtotime($temptime) && $delivery_business_from_time <= strtotime($temptime) && strtotime($temptime) <= $delivery_business_to_time) {
                        if (!in_array($temptime, $delivery_time_result))
                            $delivery_time_result[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                    }
                }
            }

            $data['delivery_gap_time_array'] = $delivery_time_result;

        }
        else
        {
            $data['delivery_same_business'] = 'no';

            if(!empty($get_delivery_days['day']) ||  isset($get_delivery_days['day']))
            {
                foreach($get_delivery_days['day'] as $key => $ddays)
                {
                    $ddays_array = $ddays;

                    if(in_array('Everyday',$ddays_array))
                    {
                        $data['delivry_day'] = 'Everyday';
                        $data['delivery_from_time'] = strtotime($get_delivery_days['from'][$key]);
                        $data['delivery_to_time'] = strtotime($get_delivery_days['to'][$key]);

                        break;
                    }
                    elseif(in_array($curr_day,$ddays_array))
                    {
                        $data['delivry_day'] = $curr_day;
                        $data['delivery_from_time'] = strtotime($get_delivery_days['from'][$key]);
                        $data['delivery_to_time'] = strtotime($get_delivery_days['to'][$key]);

                        break;
                    }
                }
            }

            $delivery_from_time = isset($data['delivery_from_time']) ? $data['delivery_from_time'] : '';
            $delivery_to_time = isset($data['delivery_to_time']) ? $data['delivery_to_time'] : '';

            $manghour = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
            $mangminus = array('00', '15', '30', '45');

            $delivery_time_result = array();

            if ($delivery_from_time <= $curr_time && $curr_time <= $delivery_to_time)
            {
                $delivery_time_result[] = 'ASAP';
            }

            $timebetween = date('H:i', ($curr_time + $get_delivery_gap_time * 60));

            foreach ($manghour as $hour)
            {
                foreach ($mangminus as $minus)
                {
                    $temptime = $hour . ':' . $minus;
                    if (strtotime($timebetween) < strtotime($temptime) && $delivery_from_time <= strtotime($temptime) && strtotime($temptime) <= $delivery_to_time)
                    {
                        if (!in_array($temptime, $delivery_time_result))
                        {
                            $delivery_time_result[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                        }
                    }
                }
            }

            $data['delivery_gap_time_array'] = $delivery_time_result;

        }
    }


    // Collection Hours
    if(!empty($collection_same_bussiness) ||  isset($collection_same_bussiness))
    {
        if($collection_same_bussiness == 1)
        {
            $data['collection_same_business'] = 'yes';

            $collection_business_from_time = isset($data['from_time']) ? $data['from_time'] : '';
            $collection_business_to_time = isset($data['to_time']) ? $data['to_time'] : '';

            $manghour = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
            $mangminus = array('00', '15', '30', '45');

            $collection_time_result = array();
            $timebetween = date('H:i', ($curr_time + $get_collection_gap_time * 60));

            foreach ($manghour as $hour)
            {
                foreach ($mangminus as $minus)
                {
                    $temptime = $hour . ':' . $minus;
                    if (strtotime($timebetween) < strtotime($temptime) && $collection_business_from_time <= strtotime($temptime) && strtotime($temptime) <= $collection_business_to_time) {
                        if (!in_array($temptime, $collection_time_result))
                            $collection_time_result[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                    }
                }
            }

            $data['collection_gap_time_array'] = $collection_time_result;

        }
        else
        {
            if(!empty($get_collection_days['day']) ||  isset($get_collection_days['day']))
            {
                foreach($get_collection_days['day'] as $key => $cdays)
                {
                    $cdays_array = $cdays;

                    if(in_array('Everyday',$cdays_array))
                    {
                        $data['collection_day'] = 'Everyday';
                        $data['collection_from_time'] = strtotime($get_collection_days['from'][$key]);
                        $data['collection_to_time'] = strtotime($get_collection_days['to'][$key]);

                        break;
                    }
                    elseif(in_array($curr_day,$cdays_array))
                    {
                        $data['collection_day'] = $curr_day;
                        $data['collection_from_time'] = strtotime($get_collection_days['from'][$key]);
                        $data['collection_to_time'] = strtotime($get_collection_days['to'][$key]);

                        break;
                    }
                }
            }

            $collection_from_time = isset($data['collection_from_time']) ? $data['collection_from_time'] : '';
            $collection_to_time = isset($data['collection_to_time']) ? $data['collection_to_time'] : '';

            $manghour = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
            $mangminus = array('00', '15', '30', '45');

            $collection_time_result = array();

            if ($collection_from_time <= $curr_time && $curr_time <= $collection_to_time)
            {
                $collection_time_result[] = 'ASAP';
            }

            $timebetween = date('H:i', ($curr_time + $get_collection_gap_time * 60));

            foreach ($manghour as $hour)
            {
                foreach ($mangminus as $minus)
                {
                    $temptime = $hour . ':' . $minus;
                    if (strtotime($timebetween) < strtotime($temptime) && $collection_from_time <= strtotime($temptime) && strtotime($temptime) <= $collection_to_time)
                    {
                        if (!in_array($temptime, $collection_time_result))
                        {
                            $collection_time_result[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                        }
                    }
                }
            }

            $data['collection_gap_time_array'] = $collection_time_result;

        }
    }


    // Opening Hours
    if(!empty($get_business_days['day']) ||  isset($get_business_days['day']))
    {
        foreach($get_business_days['day'] as $key => $bdays)
        {
            $bdays_array = $bdays;

            if(in_array('Everyday',$bdays_array))
            {
                $openHours = array();
                $data['opning_hours'] = '';
                $openHours['days'][] = 'Everyday';
                $openHours['from'][] = $get_business_days['from'][$key];
                $openHours['to'][] = $get_business_days['to'][$key];
                break;
            }
            else
            {
                if(count($bdays_array) == 1)
                {
                    $openHours['days'][] = $bdays_array[0];
                    $openHours['from'][] = $get_business_days['from'][$key];
                    $openHours['to'][] = $get_business_days['to'][$key];
                }
                else
                {
                    $ckey = count($bdays_array) - 1;
                    $days_from = $bdays_array[0];
                    $bday_to = $bdays_array[$ckey];

                    $openHours['days'][] =  $days_from.' to '.$bday_to;
                    $openHours['from'][] = $get_business_days['from'][$key];
                    $openHours['to'][] = $get_business_days['to'][$key];
                }
            }
        }
    }

    $data['opning_hours'] = $openHours;

    return $data;
}





// Front Store ID
function frontStoreID($currentURL)
{
    $slash = substr($currentURL, -1);

    if($slash != '/')
    {
        $new_url = $currentURL .= '/';
    }
    else
    {
        $new_url = $currentURL;
    }
    $storeDetails = Store::where('url',$new_url)->orWhere('ssl',$new_url)->first();

    $data['store_id'] = isset($storeDetails->store_id) ? $storeDetails->store_id : '';


    // Social Site Settings
    $social_key = ([
        'polianna_facebook_id',
        'polianna_twitter_username',
        'polianna_gplus_id',
        'polianna_linkedin_id',
        'polianna_youtube_id',
    ]);
    $data['social_settings'] = [];
    foreach($social_key as $row)
    {
        $query = Settings::select('value')->where('store_id',$data['store_id'])->where('key',$row)->first();
        $data['social_settings'][$row] = isset($query->value) ? $query->value : '';
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
        'config_title',
        'config_meta_description',
        'enable_gallery_module',
        'enable_home_gallery',
        'gallery_background_options',
        'gallery_header_text',
        'gallery_header_desc',
        'gallery_background_color',
        'gallery_background_image',
        'config_currency',
        'config_logo',
        'suspend_for',
        'suspend_time',
        'suspend_title',
        'suspend_description',
        'suspend_permanently',
        'suspend_logo',
        'new_module_status'
    ]);
    $data['store_settings'] = [];
    foreach($store_key as $row)
    {
        $query = Settings::select('value')->where('store_id',$data['store_id'])->where('key',$row)->first();
        $data['store_settings'][$row] = isset($query->value) ? $query->value : '';
    }

    return $data;
}





// Function for Get Stores Reviews
function storereview()
{
    // Current URL
    $currentURL = URL::to("/");

    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];

    // Get Current Reviews ID & Reviews Settings
    $current_review_id = layoutID($currentURL,'review_id');
    $review_id = $current_review_id['review_id'];
    $store_review_settings = storeLayoutSettings($review_id,$front_store_id,'review_settings','reviews_id');

    $review_limit = isset($store_review_settings['review_limit']) ? $store_review_settings['review_limit'] : 5;

    $data['reviews'] = Reviews::with(['hasOneCustomer'])->where('store_id',$front_store_id)->orderBy('store_review_id','DESC')->take($review_limit)->get();

    return $data;
}





// Function for get User's Cart
function getuserCart($userId)
{
    $customer = Customer::select('cart')->where('customer_id',$userId)->first();
    $cust_cart = isset($customer->cart) ? $customer->cart : '';
    $base64decode = base64_decode($cust_cart);
    $cart = unserialize($base64decode);
    return $cart;
}





// Function for Add to Cart Login User
function addtoCartUser($request,$productid,$sizeid, $cart, $userid, $is_topping, $checkbox)
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
        echo '<pre>';
        print_r($product);
        exit();
        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->hasOneToppingProductPriceSize['delivery_price']) ? $product->hasOneToppingProductPriceSize['delivery_price'] : 0.00;
            $data['del_price'] = $del_price;
        }
        elseif($delivery_type == 'collection')
        {
            $col_price = isset($product->hasOneToppingProductPriceSize['collection_price']) ? $product->hasOneToppingProductPriceSize['collection_price'] : 0.00;
            $data['col_price'] = $col_price;
        }

        $data['main_price'] = isset($product->hasOneToppingProductPriceSize['price']) ? $product->hasOneToppingProductPriceSize['price'] : 0;
        $data['size'] = isset($product->hasOneToppingProductPriceSize->hasOneToppingSize['size']) ? $product->hasOneToppingProductPriceSize->hasOneToppingSize['size'] : '';

        if($is_topping == 1)
        {
            if(!empty($checkbox) || $checkbox != '')
            {
                $data['topping'] = $checkbox;
            }
        }
    }
    else
    {
        $product = Product::with(['hasOneProductDescription'])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->delivery_price) ? $product->delivery_price : 0.00;
            $data['del_price'] = $del_price;
        }
        elseif($delivery_type == 'collection')
        {
            $col_price = isset($product->collection_price) ? $product->collection_price : 0.00;
            $data['col_price'] = $col_price;
        }
        $data['main_price'] = $product->price;

        if($is_topping == 1)
        {
            if(!empty($checkbox) || $checkbox != '')
            {
                $data['topping'] = $checkbox;
            }
        }

    }
    $data['name'] = $product->hasOneProductDescription['name'];
    $data['description'] = $product->hasOneProductDescription['description'];
    $data['image'] = $product->image;
    $data['model'] = $product->model;
    $data['quantity'] = 1;
    $data['product_id'] = $productid;
    // $arrs = array();
    // if ($sizeid != 0){

    //     $arr['s_' . $sizeid] = $productid;
    // }
    // else{
    //     $arrs[$productid] = $productid;
    // }
    // $arr['product_id'] = $arrs;
    if ($sizeid != 0)
    {
        if(isset($arr['size'][$sizeid]))
        {
            $arr['size'][$sizeid]['quantity'] = $arr['size'][$sizeid]['quantity'] + 1;

            if(isset($data['topping']))
            {
                if(count($data['topping']) > 0)
                {
                    $arr['size'][$sizeid]['topping'] = $data['topping'];
                }
            }
        }
        else
        {
            $arr['size'][$sizeid] =$data;

        }
        if(isset($arr['product_id'])){

            $arr['product_id']['s_' . $sizeid] = $productid;
        }else{
            $arr['product_id']['s_' . $sizeid] = $productid;
        }
    }
    else
    {
        if(isset($arr['withoutSize'][$productid]))
        {
            $arr['withoutSize'][$productid]['quantity'] = $arr['withoutSize'][$productid]['quantity'] + 1;

            if(isset($data['topping']))
            {
                if(count($data['topping']) > 0)
                {
                    $arr['withoutSize'][$productid]['topping'] = $data['topping'];
                }
            }
        }
        else
        {
            $arr['withoutSize'][$productid] =$data;
        }

        if(isset($arr['product_id'])){

            $arr['product_id'][$productid] = $productid;
        }else{
            $arr['product_id'][$productid] = $productid;
        }
    }




    $serial = serialize($arr);
    $base64 = base64_encode($serial);
    $user_id = $userid;
    $user = Customer::find($user_id);
    $user->cart = $base64;
    $user->update();



}





// Function for get Coupon
function getCoupon()
{
    $currentURL = URL::to("/");
    $current_theme = layoutID($currentURL,'header_id');
    $current_theme_id = $current_theme['header_id'];
    $front_store_id =  $current_theme['store_id'];
    $delivery_type = session()->get('flag_post_code');
    if (session()->has('userid')) {
        $user_id = session()->get('userid');
    } else {
        $user_id = 0;
    }

    $current_date = strtotime(date('Y-m-d'));
    $Coupon = '';

    if (session()->has('currentcoupon'))
    {
        $coupon_name = session()->get('currentcoupon');

        if(!empty($coupon_name))
        {
            $session_get_coupon = Coupon::where('store_id', $front_store_id)->where('code',$coupon_name['code'])->where('on_off',1)->first();

            if (isset($session_get_coupon) && !empty($session_get_coupon))
            {
                $product_history = CouponProduct::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                $category_history = CouponCategory::where('coupon_id', $session_get_coupon['coupon_id'])->get();

                $category_check = [];
                foreach ($category_history as $value) {
                    $category_check[] = $value->category_id;
                }
                $cat_to_pro = array();
                foreach ($category_check as $values) {
                    $pro_cat = Product_to_category::where('category_id', $values)->get();
                    foreach ($pro_cat as $value) {
                        $cat_to_pro[] = $value->product_id;
                    }
                }
                $product_check = array();
                foreach ($product_history as $value) {
                    $product_check[] = $value->product_id;
                }
                $session_proid = session()->get('product_id');

                if ($session_get_coupon['apply_shipping'] == 1) {
                    $apply_shipping = 'delivery';
                } elseif ($session_get_coupon['apply_shipping'] == 2) {
                    $apply_shipping = 'collection';
                } elseif ($session_get_coupon['apply_shipping'] == 3) {
                    $apply_shipping = 'both';
                } else {
                    $apply_shipping = '';
                }

                $start_date = isset($session_get_coupon['date_start']) ? strtotime($session_get_coupon['date_start']) : '';
                $end_date = isset($session_get_coupon['date_end']) ? strtotime($session_get_coupon['date_end']) : '';


                if ($session_get_coupon['logged'] == 1)
                {
                    if ($user_id != 0)
                    {
                        $cart = getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();

                        if ((!empty($session_get_coupon) || $session_get_coupon != '') && $session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1)
                        {
                            if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0)
                            {
                                if(($session_get_coupon['uses_total'] == 0 || $session_get_coupon['uses_total'] == '') && ($session_get_coupon['uses_customer'] == 0 || $session_get_coupon['uses_customer'] == ''))
                                {
                                    if (!empty($cart_proid) ||  $cart_proid != '') {
                                        if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if ($session_get_coupon['uses_customer'] > $uses_per_cpn)
                                    {
                                        if (!empty($cart_proid) ||  $cart_proid != '') {
                                            if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                elseif ($session_get_coupon['logged'] == 0)
                {
                    if ($user_id != 0)
                    {
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();
                        $count_user_per_cpn = count($cpn_history);

                        if (!empty($session_get_coupon) || $session_get_coupon != '')
                        {
                            if ($session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1)
                            {
                                if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0)
                                {
                                    if(($session_get_coupon['uses_total'] == 0 || $session_get_coupon['uses_total'] == '') && ($session_get_coupon['uses_customer'] == 0 || $session_get_coupon['uses_customer'] == ''))
                                    {
                                        if (!empty($session_proid) || $session_proid != '') {
                                            if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                                // else {
                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $session_get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if ($session_get_coupon['uses_customer'] > $uses_per_cpn)
                                        {
                                            if (!empty($session_proid) || $session_proid != '') {
                                                if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                                    if ($apply_shipping == $delivery_type) {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $session_get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    } elseif ($apply_shipping == 'both') {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $session_get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    }
                                                } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                                    if ($apply_shipping == $delivery_type) {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $session_get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    } elseif ($apply_shipping == 'both') {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $session_get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    }
                                                } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                                    // else {
                                                    if ($apply_shipping == $delivery_type) {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $session_get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    } elseif ($apply_shipping == 'both') {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $session_get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            if (!empty($session_get_coupon) || $session_get_coupon != '')
                            {
                                if ($session_get_coupon['status'] == 1) {
                                    if ($session_get_coupon['on_off'] == 1) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $session_get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $session_get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();
                        $count_user_per_cpn = count($cpn_history);

                        if (!empty($session_get_coupon) || $session_get_coupon != '')
                        {
                            if ($session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1)
                            {
                                if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0)
                                {
                                    if (!empty($session_proid) || $session_proid != '')
                                    {
                                        if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                            // else {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $session_get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            if (!empty($session_get_coupon) || $session_get_coupon != '') {
                                if ($session_get_coupon['status'] == 1) {
                                    if ($session_get_coupon['on_off'] == 1) {

                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $session_get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $session_get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                session()->forget('currentcoupon');
            }
        }
        else
        {
            $get_coupon = Coupon::where('store_id', $front_store_id)->where('on_off',1)->orderBy('coupon_id','DESC')->first();

            if (isset($get_coupon)) {

                $product_history = CouponProduct::where('coupon_id', $get_coupon->coupon_id)->get();
                $category_history = CouponCategory::where('coupon_id', $get_coupon->coupon_id)->get();

                $category_check = [];
                foreach ($category_history as $value) {
                    $category_check[] = $value->category_id;
                }
                $cat_to_pro = array();
                foreach ($category_check as $values) {
                    $pro_cat = Product_to_category::where('category_id', $values)->get();
                    foreach ($pro_cat as $value) {
                        $cat_to_pro[] = $value->product_id;
                    }
                }
                $product_check = array();
                foreach ($product_history as $value) {
                    $product_check[] = $value->product_id;
                }
                $session_proid = session()->get('product_id');

                if ($get_coupon->apply_shipping == 1) {
                    $apply_shipping = 'delivery';
                } elseif ($get_coupon->apply_shipping == 2) {
                    $apply_shipping = 'collection';
                } elseif ($get_coupon->apply_shipping == 3) {
                    $apply_shipping = 'both';
                } else {
                    $apply_shipping = '';
                }

                $start_date = isset($get_coupon['date_start']) ? strtotime($get_coupon['date_start']) : '';
                $end_date = isset($get_coupon['date_end']) ? strtotime($get_coupon['date_end']) : '';

                if ($get_coupon->logged == 1) {
                    if ($user_id != 0)
                    {
                        $cart_proid = session()->get('product_id');
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                        if ((!empty($get_coupon) || $get_coupon != '') && $get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0)
                            {
                                if(($get_coupon->uses_total == 0 || $get_coupon->uses_total == '') && ($get_coupon->uses_customer == 0 || $get_coupon->uses_customer == ''))
                                {
                                    if (!empty($cart_proid) ||  $cart_proid != '') {
                                        if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if ($get_coupon->uses_customer > $uses_per_cpn) {
                                        if (!empty($cart_proid) ||  $cart_proid != '') {
                                            if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } elseif ($get_coupon->logged == 0) {

                    if ($user_id != 0) {
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();

                        if (!empty($get_coupon) || $get_coupon != '') {
                            if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                                if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {

                                    if(($get_coupon->uses_total == 0 || $get_coupon->uses_total == '') && ($get_coupon->uses_customer == 0 || $get_coupon->uses_customer == ''))
                                    {
                                        if(!empty($session_proid))
                                        {
                                            if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if ($get_coupon->uses_customer > $uses_per_cpn) {
                                            if(!empty($session_proid))
                                            {
                                                if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                                    if ($apply_shipping == $delivery_type) {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    } elseif ($apply_shipping == 'both') {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    }
                                                } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                                    if ($apply_shipping == $delivery_type) {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    } elseif ($apply_shipping == 'both') {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    }
                                                } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                                    if ($apply_shipping == $delivery_type) {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    } elseif ($apply_shipping == 'both') {
                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                            $Coupon = $get_coupon;
                                                        } else {
                                                            $Coupon = '';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            if (!empty($get_coupon) || $get_coupon != '') {
                                if ($get_coupon->status == 1) {
                                    if ($get_coupon->on_off == 1) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();

                        if (!empty($get_coupon) || $get_coupon != '') {
                            if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                                if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                    if(!empty($session_proid))
                                    {
                                        if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            if (!empty($get_coupon) || $get_coupon != '') {
                                if ($get_coupon->status == 1) {
                                    if ($get_coupon->on_off == 1) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

    }
    else
    {
        $get_coupon = Coupon::where('store_id', $front_store_id)->where('on_off',1)->orderBy('coupon_id','DESC')->first();

        if (isset($get_coupon))
        {

            $product_history = CouponProduct::where('coupon_id', $get_coupon->coupon_id)->get();
            $category_history = CouponCategory::where('coupon_id', $get_coupon->coupon_id)->get();

            $category_check = [];
            foreach ($category_history as $value) {
                $category_check[] = $value->category_id;
            }
            $cat_to_pro = array();
            foreach ($category_check as $values) {
                $pro_cat = Product_to_category::where('category_id', $values)->get();
                foreach ($pro_cat as $value) {
                    $cat_to_pro[] = $value->product_id;
                }
            }
            $product_check = array();
            foreach ($product_history as $value) {
                $product_check[] = $value->product_id;
            }
            $session_proid = session()->get('product_id');

            if ($get_coupon->apply_shipping == 1) {
                $apply_shipping = 'delivery';
            } elseif ($get_coupon->apply_shipping == 2) {
                $apply_shipping = 'collection';
            } elseif ($get_coupon->apply_shipping == 3) {
                $apply_shipping = 'both';
            } else {
                $apply_shipping = '';
            }

            $start_date = isset($get_coupon['date_start']) ? strtotime($get_coupon['date_start']) : '';
            $end_date = isset($get_coupon['date_end']) ? strtotime($get_coupon['date_end']) : '';

            if ($get_coupon->logged == 1) {
                if ($user_id != 0)
                {
                    $cart_proid = session()->get('product_id');
                    $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                    $count_user_per_cpn = count($cpn_history);
                    $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                    if ((!empty($get_coupon) || $get_coupon != '') && $get_coupon->status == 1 && $get_coupon->on_off == 1) {
                        if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0)
                        {
                            if(($get_coupon->uses_total == 0 || $get_coupon->uses_total == '') && ($get_coupon->uses_customer == 0 || $get_coupon->uses_customer == ''))
                            {
                                if (!empty($cart_proid) ||  $cart_proid != '') {
                                    if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {

                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if ($get_coupon->uses_customer > $uses_per_cpn) {
                                    if (!empty($cart_proid) ||  $cart_proid != '') {
                                        if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } elseif ($get_coupon->logged == 0) {

                if ($user_id != 0) {
                    $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                    $count_user_per_cpn = count($cpn_history);
                    $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();

                    if (!empty($get_coupon) || $get_coupon != '') {
                        if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {

                                if(($get_coupon->uses_total == 0 || $get_coupon->uses_total == '') && ($get_coupon->uses_customer == 0 || $get_coupon->uses_customer == ''))
                                {
                                    if(!empty($session_proid))
                                    {
                                        if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                            if ($apply_shipping == $delivery_type) {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            } elseif ($apply_shipping == 'both') {
                                                if ($current_date >= $start_date && $current_date < $end_date) {
                                                    $Coupon = $get_coupon;
                                                } else {
                                                    $Coupon = '';
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if ($get_coupon->uses_customer > $uses_per_cpn) {
                                        if(!empty($session_proid))
                                        {
                                            if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                                if ($apply_shipping == $delivery_type) {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                } elseif ($apply_shipping == 'both') {
                                                    if ($current_date >= $start_date && $current_date < $end_date) {
                                                        $Coupon = $get_coupon;
                                                    } else {
                                                        $Coupon = '';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if (!empty($get_coupon) || $get_coupon != '') {
                            if ($get_coupon->status == 1) {
                                if ($get_coupon->on_off == 1) {
                                    if ($apply_shipping == $delivery_type) {
                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                            $Coupon = $get_coupon;
                                        } else {
                                            $Coupon = '';
                                        }
                                    } elseif ($apply_shipping == 'both') {
                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                            $Coupon = $get_coupon;
                                        } else {
                                            $Coupon = '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                    $count_user_per_cpn = count($cpn_history);
                    $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();

                    if (!empty($get_coupon) || $get_coupon != '') {
                        if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                if(!empty($session_proid))
                                {
                                    if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {

                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($current_date >= $start_date && $current_date < $end_date) {
                                                $Coupon = $get_coupon;
                                            } else {
                                                $Coupon = '';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if (!empty($get_coupon) || $get_coupon != '') {
                            if ($get_coupon->status == 1) {
                                if ($get_coupon->on_off == 1) {
                                    if ($apply_shipping == $delivery_type) {
                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                            $Coupon = $get_coupon;
                                        } else {
                                            $Coupon = '';
                                        }
                                    } elseif ($apply_shipping == 'both') {
                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                            $Coupon = $get_coupon;
                                        } else {
                                            $Coupon = '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return $Coupon;
}



// Get Delivery Charge
function getDeliveryCharge($total)
{
    if(session()->has('min_spend_array'))
    {
        $min_spend_array = session()->get('min_spend_array');
    }
    else
    {
        $min_spend_array = array();
    }

    if($total != 0 || $total != 0.00)
    {
        if(!empty($min_spend_array) && count($min_spend_array) > 0)
        {
            $group_id = isset($min_spend_array['set_id']) ? $min_spend_array['set_id'] : '';

            if(!empty($group_id))
            {
                $get_settings =  DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_delivery_settings',$group_id)->first();

                if(isset($get_settings['hasManyDeliveryFeeds']) && count($get_settings['hasManyDeliveryFeeds']) > 0)
                {
                    $arr_price = array();
                    foreach($get_settings['hasManyDeliveryFeeds'] as $del_fees)
                    {
                        $price_shipping = isset($del_fees->price_shipping) ? $del_fees->price_shipping : '';
                        $price_upto = isset($del_fees->price_upto) ? $del_fees->price_upto : '';

                        $arr_price[$price_upto] = $price_shipping;

                    }

                    if(isset($arr_price) && count($arr_price) > 0)
                    {
                        $last_key = '';
                        foreach($arr_price as $key => $price)
                        {
                            $condition = $key;
                            $f_price = $price;

                            if(empty($last_key))
                            {
                                if($total <= $condition)
                                {
                                    $del_price = $f_price;
                                    break;
                                }
                                else
                                {
                                    $del_price = 0;
                                    $last_key = $condition;
                                }
                            }
                            else
                            {
                                if($total >= $last_key && $total <= $condition)
                                {
                                    $del_price = $f_price;
                                    break;
                                }
                                else
                                {
                                    $del_price = 0;
                                    $last_key = $condition;
                                }
                            }

                        }
                    }
                    else
                    {
                        $del_price = 0;
                    }
                }
                else
                {
                    $del_price = 0;
                }
            }
            else
            {
                $del_price = 0;
            }
        }
        else
        {
            $del_price = 0;
        }
    }
    else
    {
        $del_price = 0;
    }

    return number_format($del_price,2);

}




// Function for Add to Cart
function addtoCart($request,$productid,$qty,$sizeid, $is_topping, $checkbox,$extra_price=0,$mul_qty)
{
    $delivery_type = session()->get('flag_post_code');

    if(!is_numeric($extra_price))
    {
        $extra_price = 0.00;
    }

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
            $q->where('id_product_price_size',$sizeid);
        }])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->hasOneToppingProductPriceSize['delivery_price']) ? $product->hasOneToppingProductPriceSize['delivery_price'] : 0.00;

            if($del_price == 0 || $del_price == 0.00)
            {
                $data['del_price'] = $product->hasOneToppingProductPriceSize['price'] + $extra_price;
            }
            else
            {
                $data['del_price'] = $del_price + $extra_price;
            }

        }
        elseif($delivery_type == 'collection')
        {
            $col_price = isset($product->hasOneToppingProductPriceSize['collection_price']) ? $product->hasOneToppingProductPriceSize['collection_price'] : 0.00;

            if($col_price == 0 || $col_price == 0.00)
            {
                $data['col_price'] = $product->hasOneToppingProductPriceSize['price'] + $extra_price;
            }
            else
            {
                $data['col_price'] = $col_price + $extra_price;
            }
        }
        $data['main_price'] = $product->hasOneToppingProductPriceSize['price'] + $extra_price;
        $data['size'] = isset($product->hasOneToppingProductPriceSize->hasOneToppingSize['size']) ? $product->hasOneToppingProductPriceSize->hasOneToppingSize['size'] : '';

        if($is_topping == 1)
        {
            if(!empty($checkbox) || $checkbox != '')
            {
                $data['topping'] = $checkbox;
            }
        }

    }
    else
    {
        $product = Product::with(['hasOneProductDescription'])->where('product_id', $productid)->first();

        if($delivery_type == 'delivery')
        {
            $del_price = isset($product->delivery_price) ? $product->delivery_price : 0.00;

            if($del_price == 0 || $del_price == 0.00)
            {
                $data['del_price'] = $product->price + $extra_price;
            }
            else
            {
                $data['del_price'] = $del_price + $extra_price;
            }
        }
        elseif($delivery_type == 'collection')
        {
            $col_price = isset($product->collection_price) ? $product->collection_price : 0.00;

            if($col_price == 0 || $col_price == 0.00)
            {
                $data['col_price'] = $product->price + $extra_price;
            }
            else
            {
                $data['col_price'] = $col_price + $extra_price;
            }
        }
        $data['main_price'] = $product->price + $extra_price;

        if($is_topping == 1)
        {
            if(!empty($checkbox) || $checkbox != '')
            {
                $data['topping'] = $checkbox;
            }
        }
    }
    $data['name'] = $product->hasOneProductDescription['name'];
    $data['description'] = $product->hasOneProductDescription['description'];
    $data['image'] = $product->image;
    $data['model'] = $product->model;
    $data['quantity'] = $qty;
    $data['product_id'] = $productid;

    if ($sizeid != 0)
    {
        if(isset($arr['size'][$sizeid]))
        {
            if($mul_qty != 1)
            {
                $arr['size'][$sizeid]['quantity'] = $arr['size'][$sizeid]['quantity'] + $qty;
                if(isset($arr['size'][$sizeid]['del_price']))
                {
                    $arr['size'][$sizeid]['del_price'] = isset($data['del_price']) ? $data['del_price'] : 0.00;
                }

                if(isset($arr['size'][$sizeid]['col_price']))
                {
                    $arr['size'][$sizeid]['col_price'] = isset($data['col_price']) ? $data['col_price'] : 0.00;
                }

                if(isset($arr['size'][$sizeid]['main_price']))
                {
                    $arr['size'][$sizeid]['main_price'] = isset($data['main_price']) ? $data['main_price'] : 0.00;
                }
            }
            else
            {
                $arr['size'][$sizeid]['quantity'] = $qty;
            }

            if(isset($data['topping']))
            {
                if(count($data['topping']) > 0)
                {
                    $arr['size'][$sizeid]['topping'] = $data['topping'];
                }
            }
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

            if($mul_qty != 1)
            {
                $arr['withoutSize'][$productid]['quantity'] =  $arr['withoutSize'][$productid]['quantity'] + $qty;

                if(isset($arr['withoutSize'][$productid]['del_price']))
                {
                    $arr['withoutSize'][$productid]['del_price'] = isset($data['del_price']) ? $data['del_price'] : 0.00;
                }

                if(isset($arr['withoutSize'][$productid]['col_price']))
                {
                    $arr['withoutSize'][$productid]['col_price'] = isset($data['col_price']) ? $data['col_price'] : 0.00;
                }

                if(isset($arr['withoutSize'][$productid]['main_price']))
                {
                    $arr['withoutSize'][$productid]['main_price'] = isset($data['main_price']) ? $data['main_price'] : 0.00;
                }
            }
            else
            {
                $arr['withoutSize'][$productid]['quantity'] =  $qty;
            }

            if(isset($data['topping']))
            {
                if(count($data['topping']) > 0)
                {
                    $arr['withoutSize'][$productid]['topping'] = $data['topping'];
                }
            }
        }
        else
        {
            $arr['withoutSize'][$productid] =$data;
        }
    }

    $request->session()->put('cart1',$arr);
    $request->session()->save();
}





// Function for get All Products
function getallproduct($id)
{

    $cat=$id;
    $categorytoproduct = Product_to_category::with(['hasOneProduct','hasOneDescription'])->whereHas('hasOneProduct', function ($query) use ($cat) {
        $query->where('category_id',$cat);
    })->limit(10)->get();

    return $categorytoproduct;
}

// Payment settings
function paymentdetails()
{
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        $key = ([
            'cod_order_status_id',
            'cod_total',
            'cod_charge_payment',
            'cod_geo_zone_id',
            'cod_front_text_delivery',
            'cod_printer_text',
            'cod_status',
            'cod_front_text',
            'cod_sort_order',
        ]);

        $cod = [];

        foreach ($key as $row)
        {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();
            $cod[$row] = isset($query->value) ? $query->value : '';
        }

        $orderstatus = OrderStatus::get();


        $key = ([
            'stripe_publickey',
            'stripe_secretkey',
            'stripe_charge_payment',
            'stripe_geo_zone_id',
            'stripe_printer_text',
            'stripe_order_status',
            'stripe_orderstatus_faild',
            'stripe_status',
        ]);

        $stripe = [];

        foreach ($key as $row)
        {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();
            $stripe[$row] = isset($query->value) ? $query->value : '';
        }

        $key = ([
            'pp_express_completed_status_id',
            'pp_express_pending_status_id',
            'pp_express_failed_status_id',
            'pp_express_expired_status_id',
            'pp_express_denied_status_id',
            'pp_express_canceled_reversal_status_id',
            'pp_express_profile_cancel_status',
            'pp_express_currency',
            'pp_express_geo_zone_id',
            'pp_express_method',
            'pp_express_total',
            'pp_express_debug',
            'pp_express_logo',
            'pp_express_border_colour',
            'pp_express_processed_status_id',
            'pp_express_refunded_status_id',
            'pp_express_reversed_status_id',
            'pp_express_voided_status_id',
            'pp_express_allow_note',
            'pp_express_voided_status_id',
            'pp_express_reversed_status_id',
            'curren_store_id',
            'pp_express_debug',
            'pp_express_method',
            'pp_express_geo_zone_id',
            'pp_express_currency',
            'pp_express_profile_cancel_status',
            'pp_express_canceled_reversal_status_id',
            'pp_express_completed_status_id',
            'pp_express_expired_status_id',
            'pp_express_failed_status_id',
            'pp_express_pending_status_id',
            'pp_express_processed_status_id',
            'pp_express_refunded_status_id',
            'pp_printer_text',
            'pp_express_test',
            'pp_express_page_colour',
            'pp_express_password',
            'pp_express_username',
            'pp_express_header_colour',
            'cod_status',
            'pp_express_sort_order',
            'pp_charge_payment',
            'pp_front_text',
            'pp_express_signature',
            'pp_sandbox_secret',
            'pp_sandbox_clint',
            'pp_express_status',
        ]);
        $paypal = [];

        foreach ($key as $row)
        {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();
            $paypal[$row] = isset($query->value) ? $query->value : '';
        }

        return compact('cod', 'stripe', 'paypal');
}




// Gallary Path
function gallary_redirect_url()
{
    $url = url('/');
    return  $url;
}





// Get Free Items
function getFreeItems($freeIds)
{
    $freeItems = [];
    if(!empty($freeIds) || $freeIds != '')
    {
        foreach($freeIds as $id)
        {
            $free_item = FreeItemadd::select('name_item')->where('id_free_item',$id)->first();

            $freeItems[$id] = isset($free_item->name_item) ? $free_item->name_item : '';
        }
    }

    return $freeItems;
}



function getCatTopping($catID)
{
    $get_cat_top = ToppingCatOption::where('id_category',$catID)->first();
    $get_group = isset($get_cat_top->group) ?  unserialize($get_cat_top->group) : '';

    $data = [];
    $topparr = [];

    if(!empty($get_group) || $get_group != '')
    {
        foreach($get_group as $group)
        {
            $id_group_option = $group['id_group_option'];
            $get_topping = Topping::select('id_topping','name_topping')->where('id_topping',$id_group_option)->first();
            $data['id_topping'] = isset($get_topping->id_topping) ? $get_topping->id_topping : '';
            $data['name_topping'] = isset($get_topping->name_topping) ? $get_topping->name_topping : '';
            $topparr[] = $data;
        }
    }

    return $topparr;
}



// Get getEditTopping
function getEditTopping($tid, $pid)
{
    if(!empty($tid) && !empty($pid))
    {
        $get = ProductToppingType::where('id_product',$pid)->where('id_group_topping',$tid)->first();
        return $get;
    }
}



// getCatTopStatus
function getCatTopStatus($catId)
{
    $enable_option = 0;
    if(!empty($catId) || $catId != '')
    {
        $get_cat_top = ToppingCatOption::where('id_category',$catId)->first();
        $enable_option = isset($get_cat_top['enable_option']) ? $get_cat_top['enable_option'] : 0;
        return $get_cat_top;
    }

    return $enable_option;
}



// getProductTopOpt
function getProductTopOpt($proID)
{
    $get_pro_top = '';
    if(!empty($proID) || $proID != '')
    {
        $get_pro_top = ProductToppingType::with(['hasOneTopping'])->where('id_product',$proID)->where('enable','=',1)->get();
        return $get_pro_top;
    }
    return $get_pro_top;
}




// getSubTopping
function getSubTopping($id)
{
    $get_sub_top = '';

    if(!empty($id) || $id != '')
    {
        $get_sub_top = ToppingOption::where('id_group_topping',$id)->get();
        return $get_sub_top;
    }
    return $get_sub_top;
}


?>
