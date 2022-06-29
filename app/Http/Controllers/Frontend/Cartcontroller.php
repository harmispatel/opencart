<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;


class Cartcontroller extends Controller
{
    // Function For Cart
    public function cart(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID;
        $current_theme_id = $current_theme['header_id'];
        $front_store_id =  $current_theme['store_id'];

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

        return view('frontend.pages.cart', ['Coupon' => $Coupon]);
    }
}
