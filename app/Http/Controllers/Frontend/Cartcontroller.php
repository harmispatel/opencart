<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\DeliverySettings;
use App\Models\Settings;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;


class Cartcontroller extends Controller
{
    // Function For Cart
    public function cart(Request $request)
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
        // minimum spend
        $DeliveryCollectionSettings = Settings::select('value')->where('store_id', $front_store_id)->where('key', 'delivery_option')->first();

        if ($DeliveryCollectionSettings['value'] == 'area') {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'area')->get();
        }
        else{
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'post_codes')->get();
        }
        $deliverysettings = $deliverysettings->toArray();
        $countdeliverysettings = count($deliverysettings)-1;
        $deliverysettings_last_array =  array_slice($deliverysettings, -1, 1, true);
        $minimum_spend = $deliverysettings_last_array[$countdeliverysettings];

        return view('frontend.pages.cart', ['Coupon' => $Coupon,'minimum_spend' => $minimum_spend]);
    }
}
