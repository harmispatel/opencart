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
use App\Models\Voucher;
use App\Models\CouponProduct;
use App\Models\Customer;
use App\Models\ToppingProductPriceSize;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use LDAP\Result;

class CheckoutController extends Controller
{
    public function checkout()
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];
        $delivery_setting = [];

        $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        $get_areas = DeliverySettings::select('area', 'id_delivery_settings')->where('id_store', $front_store_id)->where('delivery_type', 'area')->first();
        $area_explode = explode(',', isset($get_areas->area) ? $get_areas->area : '');
        $areas = array_filter($area_explode);

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }

        // $Coupon =Coupon::select('name','code','discount')->where('store_id',$front_store_id)->first();
        // return view('frontend.pages.chechout',compact('delivery_setting','Coupon'));

        $openclose = openclosetime();
        // collection
        $deliverydays = $openclose['deliverydays'];
        $deliveryfrom = $openclose['deliveryfrom'];
        $deliveryto   = $openclose['deliveryto'];
        $dile_gaptime   = $openclose['delivery_gaptime'];

        // delivery
        $collectiondays = $openclose['collectiondays'];
        $collectionfrom = $openclose['collectionfrom'];
        $collectionto   = $openclose['collectionto'];
        $co_gaptime   = $openclose['collection_gaptime'];
        if (empty($co_gaptime)) {
            $collectiongaptime = 1;
        } else {
            $collectiongaptime = $co_gaptime;
        }
        if (empty($dile_gaptime)) {
            $deliverygaptime = 1;
        } else {
            $deliverygaptime = $dile_gaptime;
        }
        date_default_timezone_set('Asia/Kolkata');

        $manghour = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        $mangminus = array('00', '15', '30', '45');

        // Collection checkout time
        $collectionresult = array();
        foreach ($collectiondays as $key => $item) {
            foreach ($item as $value) {
                $currenttime = time();
                $start = $collectionfrom[$key];
                $end = $collectionto[$key];
                $currentday = date('l');
                if ($currentday == $value) {
                    // if (strtotime($start) <= $currenttime && $currenttime <= strtotime($end)) {
                    //     $collectionresult[] = 'ASAP';
                    // }
                    $timebetween = date('H:i', ($currenttime + $collectiongaptime * 60));
                    foreach ($manghour as $hour) {
                        foreach ($mangminus as $minus) {
                            $temptime = $hour . ':' . $minus;
                            if (strtotime($timebetween) < strtotime($temptime) && strtotime($start) <= strtotime($temptime) && strtotime($temptime) <= strtotime($end)) {
                                if (!in_array($temptime, $collectionresult))
                                    $collectionresult[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                            }
                        }
                    }
                }
            }
        }

        // delivery checkout time
        $dileveryresult = array();
        foreach ($deliverydays as $key => $item) {
            foreach ($item as $value) {
                $currenttime = time();
                $start = $deliveryfrom[$key];
                $end = $deliveryto[$key];
                $currentday = date('l');
                if ($currentday == $value) {
                    // if (strtotime($start) <= $currenttime && $currenttime <= strtotime($end)) {
                    //     $dileveryresult[] = 'ASAP';
                    // }
                    $timebetween = date('H:i', ($currenttime + $deliverygaptime * 60));
                    foreach ($manghour as $hour) {
                        foreach ($mangminus as $minus) {
                            $temptime = $hour . ':' . $minus;
                            if (strtotime($timebetween) < strtotime($temptime) && strtotime($start) <= strtotime($temptime) && strtotime($temptime) <= strtotime($end)) {
                                if (!in_array($temptime, $dileveryresult))
                                    $dileveryresult[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                            }
                        }
                    }
                }
            }
        }
        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $Coupon = Coupon::where('store_id', $front_store_id)->first();
        }
        // $Coupon = Coupon::select('name', 'code', 'discount')->where('store_id', $front_store_id)->first();
        return view('frontend.pages.chechout', compact('delivery_setting', 'Coupon', 'collectionresult', 'dileveryresult', 'areas'));
    }

    // Get Payment & Shipping Address By Customer Address ID
    public function getcustomeraddress($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }

    public function voucher(Request $request)
    {
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];
        $delivery_setting = [];

        $voucher = $request->voucher;
        $vouchers = Voucher::where('code', $voucher)->where('store_id', $front_store_id)->first();
        if (isset($vouchers->amount)) {
            $amount = $vouchers->amount;
        }

        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $Coupon = Coupon::where('store_id', $front_store_id)->first();
        }
        $Couponcode = Coupon::where('code', $Coupon['code'])->where('store_id', $front_store_id)->first();
        if (session()->has('userid')) {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }

        if ($userid == 0) {
            $mycart = $request->session()->get('cart1');
        } else {
            $mycart = getuserCart($userid);
        }

        $subtotal = 0;
        if (isset($mycart['size'])) {

            foreach ($mycart['size'] as $key => $cart) {
                $price = $cart['main_price'] * $cart['quantity'];
                $subtotal += $price;
            }
        }
        if (isset($mycart['withoutSize'])) {

            foreach ($mycart['withoutSize'] as $key => $cart) {
                $price = $cart['main_price'] * $cart['quantity'];
                $subtotal += $price;
            }
        }
        $delivery_charge = 0;
        $current_date = strtotime(date('Y-m-d'));
        $start_date = isset($Coupon['date_start']) ? strtotime($Coupon['date_start']) : '';
        $end_date = isset($Coupon['date_end']) ? strtotime($Coupon['date_end']) : '';

        //current_date
        if ($current_date >= $start_date && $current_date < $end_date) {

            if ($Couponcode->type == 'P') {
                $couponcode = ($subtotal * $Couponcode->discount) / 100;
            }
            if ($Couponcode->type == 'F') {
                $couponcode = $Couponcode->discount;
            }
            $total = $subtotal - $couponcode - $amount;
        } else {
            $total = $subtotal + $delivery_charge - $amount;
        }

        $html = '';
        $html1 = '';
        $success_message = '';

        $html .= '<td><b>Voucher Code(' . $vouchers->code . ')</b></td><td><span><b>£ - ' . $amount . '</b></span></td>';
        $html1 .= '<td><b>Total to pay:</b></td><td><span><b id="total_pay">£ ' . $total . ' </b></span></td>';

        // if(!empty($amount) || $amount != ''){
        //     $success_message .= '<span class="text-success">Your Voucher has been Applied...</span>';
        // }else{
        //     $success_message .= '<span class="text-danger">Please enter valid Voucher Code</span>';
        // }

        return response()->json(['voucher' => $html, 'total' => $html1, 'pay' => $total, 'success_message' => $success_message]);
    }

    public function coupon(Request $request)
    {
        $Coupon = $request->coupon;
        $couponcode = coupon::where('code', $Coupon)->first();
        $code = isset($couponcode->code) ? $couponcode->code : '';

        if (!empty($code) || $code != '') {
            $json = 'Success: Your coupon discount has been applied!';
        } else {
            $json = 'Warning: Coupon is either invalid, expired or reached its usage limit!';
        }
        return response()->json(['json' => $json]);
    }
}
