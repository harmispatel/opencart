<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    public function checkout(){

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];
        $delivery_setting = [];

        $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }
        return view('frontend.pages.chechout',compact('delivery_setting'));
    }

    // Get Payment & Shipping Address By Customer Address ID
    public function getcustomeraddress($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }
}
