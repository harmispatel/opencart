<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Category;
use App\Models\CategorytoStore;
use App\Models\Coupon;
use App\Models\DeliverySettings;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
use App\Models\ToppingSize;
use App\Models\CouponProduct;
use App\Models\Customer;
use App\Models\ToppingProductPriceSize;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

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
        
        $Coupon =Coupon::select('name','code','discount')->where('store_id',$front_store_id)->first();
        return view('frontend.pages.chechout',compact('delivery_setting','Coupon'));


        // return view('frontend.pages.chechout',['Coupon'=>$Coupon]);
    }

    // Get Payment & Shipping Address By Customer Address ID
    public function getcustomeraddress($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }

    public function voucher(Request $request){
      print_r($request->voucher);    
    }

    public function coupon(Request $request){
        $Coupon=$request->coupon;
        $couponcode=coupon::where('code',$Coupon)->first();
        $code = isset($couponcode->code) ? $couponcode->code : '';
       
        if(!empty($code) || $code != ''){
            $json ='Success: Your coupon discount has been applied!';
        }else{
            $json ='Warning: Coupon is either invalid, expired or reached its usage limit!';
        }
        return response()->json(['json'=>$json]);
      }
}