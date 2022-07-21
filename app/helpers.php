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
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerBanIp;
use App\Models\CustomerIP;
use App\Models\Footers;
use App\Models\GallaryLayouts;
use App\Models\Headers;
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
use App\Models\RecentReviewsLayouts;
use App\Models\ReservationLayouts;
use App\Models\Reviews;
use App\Models\SlidersLayouts;
use Illuminate\Support\Facades\URL;





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





// Function for Active Current About Layout
function aboutActive()
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


    $key = 'about_id';
    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    // About ID
    $about_id = isset($setting->value) ? $setting->value : '';

    // About Details
    $about_deatails = AboutLayouts::where('about_id',$about_id)->first();

    return $about_deatails;
}





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
    return 'http://192.168.1.3/opencart/';
    // return 'http://192.168.1.73/ECOMM/';
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
    $product=Product_to_category::with(['hasOneProduct','hasOneDescription','hasOneToppingProductPriceSize'])->whereHas('hasOneProduct', function ($query) use ($cat_id) {
        $query->where('category_id', $cat_id);
    })->get();
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
    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = layoutID($currentURL,'header_id');
    $theme_id = $current_theme_id['header_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // Get Current Theme ID & Store ID

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
    for ($i = 0; $i <= 23; $i++)
    {
        foreach ($minitunes as $phut) {
            $timearray[$i . ':' . $phut] = $i . ':' . $phut;
        }
    }
    $timearray['23:59'] = '23:59';
    $times = $times = $timearray;


    $open_close = [];

    foreach ($key as $row)
    {
        $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

        $open_close[$row] = isset($query->value) ? $query->value : '';
    }

    $delivery = unserialize($open_close['delivery']);
    $collection = unserialize($open_close['collection']);
    $bussines = unserialize($open_close['bussines']);
    $days = $days;
    $times = $times;

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
    $data['close_date'] = $open_close['business_closing_dates'];

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
        'config_currency',
        'config_logo',
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





// Function for get Coupon
function getCoupon()
{
    $currentURL = URL::to("/");
    $current_theme = layoutID($currentURL,'header_id');
    $current_theme_id = $current_theme['header_id'];
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





// Function for Add to Cart
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



?>
