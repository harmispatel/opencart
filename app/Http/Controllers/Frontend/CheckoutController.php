<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Coupon;
use App\Models\DeliverySettings;
use App\Models\Settings;
use App\Models\Voucher;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    // Function For Checkout
    public function checkout()
    {
        $current_date = strtotime(date('Y-m-d'));
        $currentURL = URL::to("/");
        $current_theme = themeID;
        $current_theme_id = $current_theme['header_id'];
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

        return view('frontend.pages.chechout', compact('delivery_setting', 'Coupon', 'collectionresult', 'dileveryresult', 'areas'));
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
        $currentURL = URL::to("/");
        $current_theme = themeID;
        $current_theme_id = $current_theme['header_id'];
        $front_store_id =  $current_theme['store_id'];
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
