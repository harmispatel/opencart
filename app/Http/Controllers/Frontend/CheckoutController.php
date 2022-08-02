<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Coupon;
use App\Models\DeliverySettings;
use App\Models\FreeRule;
use App\Models\Settings;
use App\Models\Voucher;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    // Function For Checkout
    public function checkout()
    {
        // echo '<pre>';
        // print_r(session()->all());
        // exit();
        $current_date = strtotime(date('Y-m-d'));


        // Get Current URL
        $currentURL = URL::to("/");


        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);


        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        // Get Cart Rule
        $cart_rule = FreeRule::where('id_store',$front_store_id)->first();

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


        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();

            if (!empty($get_coupon) || $get_coupon != '') {
                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

                if ($current_date >= $start_date && $current_date < $end_date) {
                    $Coupon = $get_coupon;
                }
                else
                {
                    $Coupon = '';
                }
            }
            else
            {
                $Coupon = '';
            }
        }

        return view('frontend.pages.chechout', compact('delivery_setting', 'Coupon', 'areas', 'cart_rule'));
    }



    // Get Payment & Shipping Address By Customer Address ID
    public function getcustomeraddress($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }




    // function For Get Voucher Code
    public function voucher(Request $request)
    {

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

        $delivery_setting = [];

        // Get Voucher Code
        $voucher = $request->voucher;

        // Current Date
        $current_date = strtotime(date('Y-m-d'));

        // Get Cart
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


        // Vouchers
        $get_voucher = Voucher::where('code', $voucher)->where('status', 1)->where('store_id', $front_store_id)->first();

        if (!empty($get_voucher) || $get_voucher != '') {
            $voucher = $get_voucher->toArray();
            session()->put('currentvoucher', $voucher);
            session()->save();

            $voucheramount = isset($voucher['amount']) ? $voucher['amount'] : 0;
            $vouchercode = isset($voucher['code']) ? $voucher['code'] : '';
        } else {
            $error_msg = '';
            $error_msg .= '<span class="text-danger">Please enter valid Voucher Code</span>';
            return response()->json([
                'errors' => 1,
                'errors_message' => $error_msg,
            ]);
        }
        // End Voucher

        // Coupon
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
        // End Coupon

        // Coupon Condition
        if (!empty($Coupon)) {
            $Couponcode = Coupon::where('code', $Coupon['code'])->where('store_id', $front_store_id)->first();
        } else {
            $Couponcode = '';
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

        if (!empty($Coupon)) {
            if ($Couponcode->type == 'P') {
                $coupondiscount = ($subtotal * $Couponcode->discount) / 100;
            }
            if ($Couponcode->type == 'F') {
                $coupondiscount = $Couponcode->discount;
            }
            $couponamount = $coupondiscount;
        } else {
            $couponamount = 0;
        }

        $total = $subtotal + $delivery_charge - $couponamount - $voucheramount;

        $html = '';
        $html1 = '';
        $success_message = '<span class="text-success">Voucher has been Applied Successfully..</span>';

        $html .= '<td><b>Voucher Code(' . $vouchercode . ')</b></td><td><span><b>£ -' . number_format($voucheramount,2) . '</b></span></td>';
        $html1 .= '<td><b>Total to pay:</b></td><td><span><b id="total_pay">£ ' . number_format($total,2) . '</b></span></td>';

        return response()->json([
            'success' => 1,
            'voucher' => $html,
            'total' => $html1,
            'success_message' => $success_message
        ]);
    }




    // function For Get Coupon Code
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
