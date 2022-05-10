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

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }
        
        // $Coupon =Coupon::select('name','code','discount')->where('store_id',$front_store_id)->first();
        // return view('frontend.pages.chechout',compact('delivery_setting','Coupon'));

        $openclose = openclosetime();
        $collectiondays = $openclose['collectiondays'];
        $collectionfrom = $openclose['collectionfrom'];
        $collectionto   = $openclose['collectionto'];
        $gaptime   = $openclose['collection_gaptime'];

        // echo '<pre>';
        // print_r($openclose);
        // exit();

        // $gaptime = (int)$this->config->get($flag_post_code.'_gaptime');
        // if(!$gaptime) $gaptime = 10;

        $result = array();
        $manghour = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16','17', '18', '19', '20', '21', '22', '23');
        $mangminus = array('00', '15', '30', '45');

        $collectiondays = $openclose['collectiondays'];
        $collectionfrom = $openclose['collectionfrom'];
        $collectionto   = $openclose['collectionto'];
        foreach ($collectiondays as $key => $item) {
            foreach ($item as $value) {
                date_default_timezone_set("Asia/kolkata");
                $today = date('l');
                $currenttime = time();
                $start = strtotime($collectionfrom[$key]);
                $end = strtotime($collectionto[$key]);

                if (strtotime($start) <= strtotime($currenttime) && strtotime($currenttime) <= strtotime($end)) {
                    $result[] = 'ASAP';
                }

                $timebetween = date('H:i', (strtotime($currenttime) + $gaptime * 60));
                foreach ($manghour as $hour){
                    foreach ($mangminus as $minus) {
                        $temptime = $hour . ':' . $minus;
                        if (strtotime($timebetween) < strtotime($temptime) && strtotime($start) <= strtotime($temptime) && strtotime($temptime) <= strtotime($end)) {
                            if (!in_array($temptime, $result))
                                $result[] = $temptime . '-' . date('H:i', (strtotime($temptime) + 15 * 60));
                                echo 'Hello';
                        }
                    }
                }
                // echo '<pre>';
                // print_r($result);
                // exit();
                // for ($i = $currenttime; $i <= $end - 15 * 60; $i = $i + 15 * 60) {
                //     echo '<pre>';
                //     print_r(date('H:i',$i).'-'.date('H:i',$i + 15*60));
                // }
            }
        }
        // exit;


        // $result = array();
        // if (isset($this->session->data['flag_post_code'])){
        //     $flag_post_code = $this->session->data['flag_post_code'];
        //     $timesetting = $this->getTimeToday();
        //     if (isset($timesetting['time_'.$flag_post_code])) {
        //         $gaptime = (int)$this->config->get($flag_post_code.'_gaptime');
        //         if(!$gaptime) $gaptime = 10;
        //         $manghour = array('00', '01', '02', '03','04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16',
        //          '17', '18', '19', '20', '21', '22', '23');
        //         $mangminus= array('00', '15', '30' ,'45');
        //         foreach($timesetting['time_'.$flag_post_code] as $time) {
        //             $timecurrent = date('H:i');
        //             if(strtotime($time['to']) < strtotime($time['from'])) {
        //                 $temp = $time['from'];
        //                 $time['from'] = $time['to'];
        //                 $time['to'] = $temp;
        //             }

        //             if (strtotime($time['from']) <= strtotime($timecurrent) && strtotime($timecurrent) <= strtotime($time['to'])) {
        //                 $result[] = 'ASAP';
        //             }

        //             $timebetween = date('H:i', (strtotime($timecurrent) + $gaptime*60));
        //             foreach($manghour as $hour)
        //                 foreach($mangminus as $minus) {
        //                     $temptime = $hour.':'.$minus;

        //                     if (strtotime($timebetween) < strtotime($temptime) && strtotime($time['from']) <= strtotime($temptime) && strtotime($temptime) <= strtotime($time['to'])) {
        //                         if (!in_array($temptime, $result))
        //                             $result[] = $temptime.'-'.date('H:i', (strtotime($temptime) + 15*60));
        //                     }
        //                }
        //         }
        //     }
        // }
        // return $result;

        $Coupon = Coupon::select('name', 'code', 'discount')->where('store_id', $front_store_id)->first();
        return view('frontend.pages.chechout', compact('delivery_setting', 'Coupon'));
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