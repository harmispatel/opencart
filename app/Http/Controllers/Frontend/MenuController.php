<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\CategorytoStore;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\DeliverySettings;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\Settings;
use App\Models\ToppingSize;
use App\Models\CouponProduct;
use App\Models\Customer;
use App\Models\FreeItem;
use App\Models\FreeRule;
use App\Models\ProductDescription;
use App\Models\ToppingProductPriceSize;
use App\Models\ToppingCatOption;
use App\Models\Topping;
use App\Models\ToppingOption;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Arr;

class MenuController extends Controller
{

    public function servicecharge(Request $req)
    {

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        $servicecharge = paymentdetails();

        $stripe_charge = $servicecharge["stripe"]["stripe_charge_payment"] ? $servicecharge["stripe"]["stripe_charge_payment"] : '0.00';
        $paypal_charge = $servicecharge["paypal"]["pp_charge_payment"] ? $servicecharge["paypal"]["pp_charge_payment"] : '0.00';
        $cod_charge = $servicecharge["cod"]["cod_charge_payment"] ? $servicecharge["cod"]["cod_charge_payment"] : '0.00';

         $s_subtotal = session()->get('subtotal');
         $s_coupon = session()->get('currentcoupon');
         $ordertype = session()->get('flag_post_code');
         $coupon_name = session()->get('couponname');
         $Coupon_code = coupon::where('code', $coupon_name)->where('store_id', $front_store_id)->first();


         if (isset($Coupon_code['type']) ? ($Coupon_code['type'] == 'P') : '')
         {
             $couponcode = ($s_subtotal * $s_coupon['discount']) / 100;
         }
         if ( isset($Coupon_code['type']) ? ($Coupon_code['type'] == 'F') : '' )
         {
             $couponcode = $s_coupon['discount'];
         }

        //  echo '<pre>';
        //  print_r($couponcode);
        //  exit();

         $discount = isset($couponcode) ? $couponcode : (session()->get('couponcode'));

        //  Minimum Spend
         $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        $delivery_setting = [];

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }


        if ($delivery_setting['delivery_option'] == 'area') {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'area')->get();
        } else {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'post_codes')->get();
        }
        $minimum_spend = $deliverysettings->last()->toArray();
        //  End Minimum Spend
        // $total = $s_subtotal - $discount;


        if ($req->method_type == 1) {
            if (!empty($discount) || $discount != '') {
                $total = $s_subtotal - $discount;
            } else {
                $total = $s_subtotal;
            }
            $tottal = ($total <= 0) ? 0 : $total;
            $order_total = $tottal + $stripe_charge;
            session()->put('total',$order_total);
            if($ordertype == 'delivery' && $order_total <= $minimum_spend['min_spend']){
                return response()->json([
                    'error' => 1,
                    'message' => "Minimum delivery is " . session()->get('currency')." ". number_format($minimum_spend['min_spend'],2) .", you must spend " . session()->get('currency')." ".  number_format($minimum_spend['min_spend'],2) - $tottal ." more for the chekout.",
                    'total' => $order_total,
                    'headertotal' => $order_total,
                    'service_charge' => $stripe_charge,
                ]);

            }else{
                return response()->json([
                    'success' => 1,
                    'total' => $order_total,
                    'headertotal' => $order_total,
                    'service_charge' => $stripe_charge
                ]);
            }
        }
        if ($req->method_type == 2) {
            if (!empty($discount) || $discount != '') {
                $total = $s_subtotal - $discount;
            } else {
                $total = $s_subtotal;
            }
            $tottal = ($total <= 0) ? 0 : $total;
            $order_total = $tottal  + $paypal_charge;
            session()->put('total',$order_total);
            if($ordertype == 'delivery' && $order_total <= $minimum_spend['min_spend']){
                return response()->json([
                    'error' => 1,
                    'message' => "Minimum delivery is " . session()->get('currency')." ". number_format($minimum_spend['min_spend'],2) .", you must spend " . session()->get('currency')." ".  number_format($minimum_spend['min_spend'],2) - $tottal  ." more for the chekout.",
                    'total' => $order_total,
                    'headertotal' => $order_total,
                    'service_charge' => $paypal_charge,

                ]);

            }else{
                return response()->json([
                    'success' => 2,
                    'total' => $order_total,
                    'headertotal' => $order_total,
                    'service_charge' => $paypal_charge,
                ]);
            }
        }
        if ($req->method_type == 3) {
            if (!empty($discount) || $discount != '') {
                $total = $s_subtotal - $discount;
            } else {
                $total = $s_subtotal;
            }
            $tottal = ($total <= 0) ? 0 : $total;
            $order_total = $tottal + $cod_charge;
            session()->put('total',$order_total);

            if($ordertype == 'delivery' && $order_total <= $minimum_spend['min_spend']){
                return response()->json([
                    'error' => 1,
                    'message' => "Minimum delivery is " . session()->get('currency')." ". number_format($minimum_spend['min_spend'],2) .", you must spend " . session()->get('currency')." ".  number_format($minimum_spend['min_spend'],2) - $tottal  ." more for the chekout.",
                    'total' => $order_total,
                    'headertotal' => $order_total,
                    'service_charge' => $cod_charge

                ]);

            }else{
                return response()->json([
                    'success' => 3,
                    'total' => $order_total,
                    'headertotal' => $order_total,
                    'service_charge' => $cod_charge
                ]);
            }
        }

    }


    // Function For Show Menu Page
    public function index()
    {

        //   echo '<pre>';
        //   print_r(session()->all());
        //   exit();
        // session()->forget('couponcode');
        //  session()->forget('couponname');
        $prod_id = session()->get('product_id');
        // if(isset($prod_id)){
        $cat_id = Product_to_category::where('product_id', $prod_id)->first();
        // }

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // Get Cart Rule
        $cart_rule = FreeRule::where('id_store', $front_store_id)->first();

        $current_date = strtotime(date('Y-m-d'));
        $Coupon = '';
        $delivery_type = session()->get('flag_post_code');
        if (session()->has('userid')) {
            $user_id = session()->get('userid');
        } else {
            $user_id = 0;
        }
        $get_cpn = session()->get('currentcoupon');


        if (session()->has('currentcoupon')) {
            $session_get_coupon = session()->get('currentcoupon');
            if(isset($session_get_coupon)){
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

                $start_date = isset($session_get_coupon->date_start) ? strtotime($session_get_coupon->date_start) : '';
                $end_date = isset($session_get_coupon->date_end) ? strtotime($session_get_coupon->date_end) : '';

                if ($session_get_coupon['logged'] == 1) {
                    if ($user_id != 0) {
                        $cart =getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();
                        if ((!empty($session_get_coupon) || $session_get_coupon != '') && $session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
                            if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
                                if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
                                    if (!empty( $cart_proid) ||  $cart_proid != '') {
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
                                        }
                                        elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

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
                } elseif ($session_get_coupon['logged'] == 0) {
                    $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                    // $product_history = CouponProduct::where('product_id', $productid)->first();

                    // $cat_history = CouponCategory::where('category_id', $category_id)->first();
                  $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();

                    $count_user_per_cpn = count($cpn_history);
                    if (!empty($session_get_coupon) || $session_get_coupon != '') {
                        if ($session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
                            if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
                                  if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
                                      if (!empty($session_proid) || $session_proid != '') {
                                          if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {
                                              echo 'product ';
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
                                              // echo 'category ';
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
                                      // else{
                                      //     $Coupon = '';
                                      // }
                            }
                        }
                    } else {
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
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();
            if (isset($get_coupon) || $get_coupon != '') {

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

                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';
                if ($get_coupon->logged == 1) {
                    if ($user_id != 0) {
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $product_history = CouponProduct::where('product_id', $get_coupon->coupon_id)->first();
                        $cart = getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        // $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->groupBy('customer_id')->get();
                        $count_user_per_cpn = count($cpn_history);

                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                        if (!empty($get_coupon) || $get_coupon != '') {
                            if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                                if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                    if ($get_coupon->uses_customer > $uses_per_cpn) {
                                        if (!empty($cart_proid) || $cart_proid != '') {
                                            if (array_intersect($product_check, $cart_proid) && count($product_check) != 0) {

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
                                            } elseif (array_intersect($cat_to_pro, $cart_proid) && count($cat_to_pro) != 0) {

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

                    $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                    $count_user_per_cpn = count($cpn_history);

                    $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                    if ((!empty($get_coupon) || $get_coupon != '') && $get_coupon->status == 1 && $get_coupon->on_off == 1) {
                        if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                            if (!empty($session_proid) || $session_proid != '') {
                                if ($get_coupon->uses_customer > $uses_per_cpn) {
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

        $category = CategoryDetail::with(['hasManyCategoryStore', 'hasOneCategory'])->whereHas('hasManyCategoryStore', function ($query) use ($front_store_id) {
            $query->where('store_id', $front_store_id);
        })->orderBy('sort_order', 'ASC')->get();

        $data['category'] = $category;

        $get_areas = DeliverySettings::select('area', 'id_delivery_settings')->where('id_store', $front_store_id)->where('delivery_type', 'area')->first();
        $area_explode = explode(',', isset($get_areas->area) ? $get_areas->area : '');
        $areas = array_filter($area_explode);

        $key = ([
            'enable_delivery',
            'delivery_option',
        ]);

        $delivery_setting = [];

        foreach ($key as $row) {
            $query = Settings::select('value')->where('store_id', $front_store_id)->where('key', $row)->first();

            $delivery_setting[$row] = isset($query->value) ? $query->value : '';
        }


        // minimum spend
        if ($delivery_setting['delivery_option'] == 'area') {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'area')->get();
        } else {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'post_codes')->get();
        }
        $minimum_spend = $deliverysettings->last()->toArray();

        return view('frontend.pages.menu', ['minimum_spend' => $minimum_spend, 'data' => $data, 'delivery_setting' => $delivery_setting, 'areas' => $areas, 'Coupon' => $Coupon, 'cart_rule' => $cart_rule]);
    }




    // Chnage Free Item
    function changeFreeItem(Request $request)
    {
        $item = $request->item;

        if (!empty($item) || $item != '') {
            session()->put('free_item', $item);
            return response()->json([
                'success' => 1,
            ]);
        }

        return response()->json([
            'error' => 0,
        ]);
    }




    // Function For Add To Cart
    public function addToCart(Request $request)
    {

        $is_topping = isset($request->topping) ? $request->topping : 0;
        $checkbox = isset($request->checkbox) ? array_filter($request->checkbox) : '';
        $drpdwn = isset($request->drpdwn) ? array_filter($request->drpdwn) : '';


        if ($is_topping != 0) {
            if (!empty($checkbox)  && !empty($drpdwn)) {
                $checkbox = array_merge($checkbox, $drpdwn);
            } else {
                if (!empty($checkbox)) {
                    $checkbox = $checkbox;
                } elseif (!empty($drpdwn)) {
                    $checkbox = $drpdwn;
                } else {
                    $checkbox = '';
                }
            }
        } else {
            $checkbox = '';
        }

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // Get Currency Details
        $currency = getCurrencySymbol($store_setting['config_currency']);

        $productid = $request->product_id;

        $sizeid = $request->size_id;

        if (session()->has('product_id')) {
            $arr = session()->get('product_id');
        } else {
            $arr = array();
        }


        if ($sizeid != 0) {
            $arr['s_' . $sizeid] = $productid;
        } else {
            $arr[$productid] = $productid;
        }


        session()->put('product_id', $arr);
        session()->save();

        $category_id = Product_to_category::where('product_id',  $productid)->first();

        $pro_name = ProductDescription::where('product_id', $productid)->first();
        $cat_id = Product_to_category::where('product_id', $productid)->first();
        $toppingType = ToppingCatOption::where('id_category', $cat_id->category_id)->first();
        $group = unserialize(isset($toppingType->group) ? $toppingType->group : '');
        unset($group['number_group']);

        // minimum spend
        $DeliveryCollectionSettings = Settings::select('value')->where('store_id', $front_store_id)->where('key', 'delivery_option')->first();

        if ($DeliveryCollectionSettings['value'] == 'area') {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'area')->get();
        } else {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'post_codes')->get();
        }
        $minimum_spend = $deliverysettings->last()->toArray();

        $delivery_type = session()->get('flag_post_code');


        $sizeid = $request->size_id;
        $userid = $request->user_id;
        $loopid = isset($request->loop_id) ? $request->loop_id : '';

        $current_date = strtotime(date('Y-m-d'));
        if (session()->has('userid')) {
            $user_id = session()->get('userid');
        } else {
            $user_id = 0;
        }

        if (session()->has('currentcoupon')) {
            $session_get_coupon = session()->get('currentcoupon');
            if(isset($session_get_coupon)){
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

                $start_date = isset($session_get_coupon->date_start) ? strtotime($session_get_coupon->date_start) : '';
                $end_date = isset($session_get_coupon->date_end) ? strtotime($session_get_coupon->date_end) : '';

                if ($session_get_coupon['logged'] == 1) {
                    if ($user_id != 0) {
                        $cart =getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();
                        if ((!empty($session_get_coupon) || $session_get_coupon != '') && $session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
                            if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
                                if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
                                    if (!empty( $cart_proid) ||  $cart_proid != '') {
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
                                        }
                                        elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

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
                } elseif ($session_get_coupon['logged'] == 0) {
                    $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                    // $product_history = CouponProduct::where('product_id', $productid)->first();

                    // $cat_history = CouponCategory::where('category_id', $category_id)->first();
                  $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();

                    $count_user_per_cpn = count($cpn_history);
                    if (!empty($session_get_coupon) || $session_get_coupon != '') {
                        if ($session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
                            if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
                                  if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
                                      if (!empty($session_proid) || $session_proid != '') {
                                          if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {
                                              echo 'product ';
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
                                              // echo 'category ';
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
                                      // else{
                                      //     $Coupon = '';
                                      // }
                            }
                        }
                    } else {
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
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();
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

                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

                if ($get_coupon->logged == 1) {
                    if ($user_id != 0) {
                        $cart = getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                        if ((!empty($get_coupon) || $get_coupon != '') && $get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
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
                } elseif ($get_coupon->logged == 0) {
                    $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                    // $product_history = CouponProduct::where('product_id', $productid)->first();


                    $count_user_per_cpn = count($cpn_history);
                    $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();

                    if (!empty($get_coupon) || $get_coupon != '') {
                        if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                if ($get_coupon->uses_customer > $uses_per_cpn) {
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
                                        // else {
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
                                // else{
                                //     $Coupon = '';
                                // }
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

        if (!empty($loopid) || $loopid != '') {
            if ($loopid <= 0) {
                return response()->json([
                    'required_1' => 1,
                ]);
            } else {
                if ($loopid <= 50) {
                    if ($userid == 0) {
                        if ($sizeid == 0) {
                            session()->forget('cart1.withoutSize.' . $productid);
                            for ($i = 1; $i <= $loopid; $i++) {
                                addtoCart($request, $productid, $sizeid, $is_topping, $checkbox);
                            }
                        } else {
                            session()->forget('cart1.size.' . $sizeid);
                            for ($i = 1; $i <= $loopid; $i++) {
                                addtoCart($request, $productid, $sizeid, $is_topping, $checkbox);
                            }
                        }
                    } else {
                        if ($sizeid == 0) {
                            session()->forget('cart1.withoutSize.' . $productid);
                            for ($i = 1; $i <= $loopid; $i++) {
                                addtoCart($request, $productid, $sizeid, $is_topping, $checkbox);
                            }
                        } else {
                            session()->forget('cart1.size.' . $sizeid);
                            for ($i = 1; $i <= $loopid; $i++) {
                                addtoCart($request, $productid, $sizeid, $is_topping, $checkbox);
                            }
                        }
                        // $cart = getuserCart($userid);
                        // if ($sizeid == 0) {
                        //     unset($cart['withoutSize'][$productid]);
                        //     $serial = serialize($cart);
                        //     $base64 = base64_encode($serial);
                        //     $user = Customer::find($userid);
                        //     $user->cart = $base64;
                        //     $user->update();

                        //     for ($i = 1; $i <= $loopid; $i++) {
                        //         $newcart = getuserCart($userid);
                        //         addtoCartUser($request, $productid, $sizeid, $newcart, $userid, $is_topping, $checkbox);
                        //     }
                        // } else {
                        //     unset($cart['size'][$sizeid]);
                        //     unset($cart['withoutSize'][$productid]);
                        //     $serial = serialize($cart);
                        //     $base64 = base64_encode($serial);
                        //     $user = Customer::find($userid);
                        //     $user->cart = $base64;
                        //     $user->update();
                        //     for ($i = 1; $i <= $loopid; $i++) {
                        //         $newcart = getuserCart($userid);
                        //         addtoCartUser($request, $productid, $sizeid, $newcart, $userid, $is_topping, $checkbox);
                        //     }
                        // }
                    }
                } else {
                    return response()->json([
                        'max_limit' => 1,
                    ]);
                }
            }
        } else {
            if ($userid == 0) {
                addtoCart($request, $productid, $sizeid, $is_topping, $checkbox);
            } else {
                addtoCart($request, $productid, $sizeid, $is_topping, $checkbox); //Session

                // Database
                // $cart = getuserCart($userid);

                // addtoCartUser($request, $productid, $sizeid, $cart, $userid, $is_topping, $checkbox);
            }
        }

        if ($userid == 0) {
            $mycart = $request->session()->get('cart1');
        } else {
            $mycart = $request->session()->get('cart1'); //Session
            // $mycart = getuserCart($userid); //Database
        }



        $html = '';
        $subtotal = 0;
        $delivery_charge = 0;
        $cart_products = 0;


        $html .= '<table class="table">';

        if (isset($mycart['size'])) {
            foreach ($mycart['size'] as $key => $cart) {

                // price
                if ($delivery_type == 'delivery') {
                    $price = $cart['del_price'] * $cart['quantity'];
                } elseif ($delivery_type == 'collection') {
                    $price = $cart['col_price'] * $cart['quantity'];
                } else {
                    $price = $cart['main_price'] * $cart['quantity'];
                }


                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger" onclick="deletecartproduct(' . $cart['product_id'] . ',' . $key . ',' . $userid . ')" style="cursor:pointer;"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td>' . $cart['size'] . '</td>';
                $html .= '<td>' . $cart['name'] . '<br>';

                if (isset($cart['topping']) && !empty($cart['topping'])) {
                    foreach ($cart['topping'] as $topp) {
                        $html .= '<span>- ' . $topp . '</span></br>';
                    }
                }

                $html .= '</td>';
                $html .= '<td style="width: 80px;">' . $currency . ' ' . $price . '</td>';
                $html .= '</tr>';


                // Sub Total
                $subtotal += $price;

                // Header Count
                $cart_products += $cart['quantity'];
            }
        }

        if (isset($mycart['withoutSize'])) {
            $sizeid = 0;
            foreach ($mycart['withoutSize'] as $cart) {
                // price
                if ($delivery_type == 'delivery') {
                    $price = $cart['del_price'] * $cart['quantity'];
                } elseif ($delivery_type == 'collection') {
                    $price = $cart['col_price'] * $cart['quantity'];
                } else {
                    $price = $cart['main_price'] * $cart['quantity'];
                }

                $html .= '<tr>';
                $html .= '<td><i class="fa fa-times-circle text-danger" onclick="deletecartproduct(' . $cart['product_id'] . ',' . $sizeid . ',' . $userid . ')" style="cursor:pointer"></i></td>';
                $html .= '<td>' . $cart['quantity'] . 'x</td>';
                $html .= '<td>-</td>';
                $html .= '<td>' . $cart['name'] . '<br>';

                if (isset($cart['topping']) && !empty($cart['topping'])) {
                    foreach ($cart['topping'] as $topp) {
                        $html .= '<span>- ' . $topp . '</span></br>';
                    }
                }

                $html .= '</td>';
                $html .= '<td style="width: 80px;">' . $currency . ' ' . $price . '</td>';
                $html .= '</tr>';

                // Subtotal
                $subtotal += $price;

                // Header Count
                $cart_products += $cart['quantity'];
            }
        }
        $html .= '</table>';


        $coupon_html = '';

        // Coupon Code
        if (!empty(isset($Coupon) ? $Coupon : '') || isset($Coupon) ? $Coupon : '' != '') {
            $couponcode = 0;
            if ($Coupon['total'] >= $subtotal) {
                if ($Coupon['type'] == 'P') {
                    $couponcode = ($subtotal * $Coupon['discount']) / 100;
                }
                if ($Coupon['type'] == 'F') {
                    $couponcode =  $Coupon['discount'];
                }
            }

            // Main Total
            $total = $subtotal - $couponcode + $delivery_charge;
            $all_total = ($total <= 0) ? 0 : $total;

        } else {
            $total = $subtotal + $delivery_charge;
        }
        if (isset($couponcode) ? $couponcode : 0 != 0) {
            $coupon_html .= '<label>Coupon(' . $Coupon['code'] . ')</label><span> -' . $currency . ' ' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</span>';
        } else {
            $coupon_html .= '';
        }
        session()->put('headertotal', $total);
        // $coupon_html .= '<label>Coupon(' . $Coupon['code'] . ')</label><span> -' . $currency . ' ' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</span>';
        $sessioncouponcode = session()->put('couponcode', isset($couponcode) ? $couponcode : '');
        $sessioncouponname = session()->put('couponname', isset($Coupon['code']) ? $Coupon['code'] : '');
        $sessioncurrency = session()->put('currency', $store_setting['config_currency']);

        // Get Cart Rule
        $cart_rule = FreeRule::where('id_store', $front_store_id)->first();

        if (isset($cart_rule) && !empty($cart_rule)) {
            $cart_rule_total = $cart_rule['min_total'];
        } else {
            $cart_rule_total = '';
        }

        $cart_rule_html = '';

        if (!empty($cart_rule_total) || $cart_rule_total != '') {
            if ($subtotal >= $cart_rule_total) {
                $free_explode = isset($cart_rule['id_item']) ? explode(':', $cart_rule['id_item']) : '';
                $free_items = getFreeItems($free_explode);

                $cart_rule_html .= '<div class="form-group">';
                $cart_rule_html .= '<label>Please Choose Your Free Items</label>';
                $cart_rule_html .= '<select name="free_item" id="free_item" class="form-control mt-1" onchange="changeFreeItem()">';

                if (!empty($free_items) || $free_items != '') {
                    foreach ($free_items as $key => $fitem) {
                        if ($key == 0) {
                            session()->put('free_item', $fitem);
                        }
                        $cart_rule_html .= '<option value="' . $fitem . '">' . $fitem . '</option>';
                    }
                }

                $cart_rule_html .= '</select>';
                $cart_rule_html .= '</div>';
            }
        }

        $subtotl_html = '';
        $headertotal = 0;
        $total_html = '';

        $subtotl_html .= '<label>Sub-Total</label><span>' . $currency . ' ' . $subtotal . '</span>';
        $total_html .= '<label><b>Total to pay:</b></label><span>' . $currency . ' ' . (($total <= 0) ? 0 : $total) . '</span>';
        $headertotal += $total;



        if ($minimum_spend['min_spend'] <= $total) {
            $min_spend = 'true';
        } else {
            $min_spend = 'false';
        }

        return response()->json([
            'html' => $html,
            'subtotal' => $subtotl_html,
            'cart_products' => $cart_products,
            'headertotal' => (round($headertotal, 2) <= 0) ? 0 : round($headertotal, 2),
            'total' => $total_html,
            'couponcode' => $coupon_html,
            'cart_rule_html' => $cart_rule_html,
            'min_spend' => $min_spend,
        ]);
    }




    // Function For Delete Cart Product
    public function deletecartproduct(Request $request)
    {
        $productid = $request->product_id;
        $sizeid = $request->size_id;
        $userid = $request->user_id;

        $pro_id = session()->get('product_id');


        //  if(in_array($productid,$pro_id)){
        //     unset($pro_id['s_'.$productid]);
        //  }
        if ($sizeid == 0) {
            if (in_array($productid, $pro_id)) {
                unset($pro_id[$productid]);
            }
        } else {
            if (in_array($productid, $pro_id)) {
                unset($pro_id['s_' . $sizeid]);
            }
        }

        session()->put('product_id', $pro_id);
        session()->save();

        if ($userid == 0) {
            if ($sizeid == 0) {
                session()->forget('cart1.withoutSize.' . $productid);
            } else {
                session()->forget('cart1.size.' . $sizeid);
            }
        } else {
            // Session
            if ($sizeid == 0) {
                session()->forget('cart1.withoutSize.' . $productid);
            } else {
                session()->forget('cart1.size.' . $sizeid);
            }

            // $cart = getuserCart($userid);  // Database
            // if (isset($cart)) {
            //     if ($sizeid == 0) {
            //         unset($cart['withoutSize'][$productid]);
            //         unset($cart['product_id'][$productid]);
            //     } else {
            //         unset($cart['size'][$sizeid]);
            //         unset($cart['product_id']['s_' . $sizeid]);
            //         if (isset($cart['size']) && count($cart['size']) == 0) {
            //             unset($cart['size']);
            //         }
            //         if (isset($cart['withoutSize']) && count($cart['withoutSize']) == 0) {
            //             unset($cart['withoutSize']);
            //         }
            //         if (count($cart['product_id']) == 0) {
            //             unset($cart['product_id']);
            //         }
            //     }
            // }

            // $serial = serialize($cart);
            // $base64 = base64_encode($serial);
            // $user_id = $userid;
            // $user = Customer::find($user_id);
            // $user->cart = $base64;
            // $user->update();
        }



        return response()->json([
            'success' => 1,
        ]);
    }



    // Function For Get Coupon Code
    public function getcoupon(Request $request)
    {

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // Get Currency Details
        $currency = getCurrencySymbol($store_setting['config_currency']);

        // cash on delevery setting
        $servicecharge = paymentdetails();
        $stripe_charge = $servicecharge["stripe"]["stripe_charge_payment"] ? $servicecharge["stripe"]["stripe_charge_payment"] : '0.00';
        $paypal_charge = $servicecharge["paypal"]["pp_charge_payment"] ? $servicecharge["paypal"]["pp_charge_payment"] : '0.00';
        $cod_charge = $servicecharge["cod"]["cod_charge_payment"] ? $servicecharge["cod"]["cod_charge_payment"] : '0.00';

        $current_date = strtotime(date('Y-m-d'));
        $delivery_type = session()->get('flag_post_code');

        if (session()->has('userid')) {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }

        $session_proid = session()->get('product_id');

        $Coupon = $request->coupon;
        $method_type = isset($request->method_type) ? $request->method_type : '';

        $Couponcode = coupon::where('code', $Coupon)->where('store_id', $front_store_id)->first();

        $product_history = CouponProduct::where('coupon_id', isset($Couponcode->coupon_id))->get();
        $category_history = CouponCategory::where('coupon_id', isset($Couponcode->coupon_id))->get();

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

        $start_date = isset($Couponcode->date_start) ? strtotime($Couponcode->date_start) : '';
        $end_date = isset($Couponcode->date_end) ? strtotime($Couponcode->date_end) : '';



        if (!empty($Couponcode) || $Couponcode != '') // Valid Coupon
        {
            if ($Couponcode->logged == 1) {
                if ($userid != 0) {
                    if ($Couponcode->apply_shipping == 1) {
                        $apply_shipping = 'delivery';
                    } elseif ($Couponcode->apply_shipping == 2) {
                        $apply_shipping = 'collection';
                    } elseif ($Couponcode->apply_shipping == 3) {
                        $apply_shipping = 'both';
                    } else {
                        $apply_shipping = '';
                    }
                    $cpn_history = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->get();
                    $count_user_per_cpn = count($cpn_history);
                    // $cart = getuserCart($userid); // Database
                    $cart = getuserCart($userid); // Database
                    $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                    $uses_per_cpn = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->where('customer_id', $userid)->count();
                    if ($Couponcode->on_off == 1 && $Couponcode->status == 1) {
                        if ($Couponcode->uses_total >  $count_user_per_cpn || $Couponcode->uses_total == 0) {
                            if ($Couponcode->uses_customer > $uses_per_cpn) {
                                if (!empty($cart_proid) ||  $cart_proid != '') {
                                    if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($Couponcode->total >= $request->total) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $code = $Couponcode->toArray();
                                                    session()->put('currentcoupon', $code);
                                                    session()->put('couponname', $Couponcode['name']);
                                                    session()->save();

                                                    if ($userid == 0) {
                                                        $mycart = $request->session()->get('cart1');
                                                    } else {
                                                        $mycart = $request->session()->get('cart1');
                                                        $mycart = getuserCart($userid); // Database
                                                    }

                                                    $subtotal = 0;
                                                    $delivery_charge = 0;

                                                    if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                        foreach ($mycart['size'] as $key => $cart) {
                                                            if ($delivery_type == 'delivery') {
                                                                $price = $cart['del_price'] * $cart['quantity'];
                                                            } elseif ($delivery_type == 'collection') {
                                                                $price = $cart['col_price'] * $cart['quantity'];
                                                            } else {

                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                            }
                                                            $subtotal += $price;
                                                            $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                        }
                                                    }

                                                    if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                        foreach ($mycart['withoutSize'] as $key => $cart) {
                                                            if ($delivery_type == 'delivery') {
                                                                $price = $cart['del_price'] * $cart['quantity'];
                                                            } elseif ($delivery_type == 'collection') {
                                                                $price = $cart['col_price'] * $cart['quantity'];
                                                            } else {

                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                            }
                                                            $subtotal += $price;
                                                            // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                        }
                                                    }
                                                    $couponcode = 0;
                                                    if ($Couponcode['total'] >= $subtotal) {

                                                        if ($Couponcode->type == 'P') {
                                                            $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                        }
                                                        if ($Couponcode->type == 'F') {
                                                            $couponcode = $Couponcode->discount;
                                                        }
                                                    }
                                                    $total = $subtotal - $couponcode + $delivery_charge;
                                                    $all_total = ($total <= 0) ? 0 : $total;

                                                    $total_html = '';
                                                    $couponcode_html = '';
                                                    $success_message = '';

                                                    $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                    // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                    $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                    //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                                    if ($request->method_type == 1) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $stripe_charge, 2));
                                                    } elseif ($request->method_type == 2) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                    } elseif ($request->method_type == 3) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $cod_charge, 2));
                                                    } else {
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                        $head_total = (round($all_total, 2) );
                                                    }

                                                    // echo '<pre>';
                                                    // print_r($total_html+ 1);
                                                    // exit();
                                                    return response()->json([
                                                        'success' => 1,
                                                        'success_message' => $success_message,
                                                        'couponcode' => $couponcode_html,
                                                        'total' => $total_html,
                                                        'headertotal' => $head_total,
                                                    ]);
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '';
                                                    $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    return response()->json([
                                                        'errors' => 1,
                                                        'errors_message' => $error_msg,
                                                    ]);
                                                }
                                            } else {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Maximum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            // if ($request->total >= $Couponcode->total) {
                                            if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                            {
                                                $code = $Couponcode->toArray();
                                                session()->put('currentcoupon', $code);
                                                session()->put('couponname', $Couponcode['name']);
                                                session()->save();

                                                if ($userid == 0) {
                                                    $mycart = $request->session()->get('cart1');
                                                } else {
                                                    $mycart = $request->session()->get('cart1'); // Session
                                                    // $mycart = getuserCart($userid); // Database
                                                }

                                                $subtotal = 0;
                                                $delivery_charge = 0;

                                                if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                    foreach ($mycart['size'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                    foreach ($mycart['withoutSize'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                $couponcode = 0;
                                                if ($Couponcode['total'] >= $subtotal) {

                                                    if ($Couponcode->type == 'P') {
                                                        $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                    }
                                                    if ($Couponcode->type == 'F') {
                                                        $couponcode = $Couponcode->discount;
                                                    }
                                                }

                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                $all_total = ($total <= 0) ? 0 : $total;

                                                $total_html = '';
                                                $couponcode_html = '';
                                                $success_message = '';

                                                $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                if ($request->method_type == 1) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $stripe_charge, 2));
                                                } elseif ($request->method_type == 2) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                } elseif ($request->method_type == 3) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $cod_charge, 2));
                                                } else {
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                    $head_total = (round($all_total, 2) );
                                                }

                                                // echo '<pre>';
                                                // print_r($total_html+ 2);
                                                // exit();
                                                return response()->json([
                                                    'success' => 1,
                                                    'success_message' => $success_message,
                                                    'couponcode' => $couponcode_html,
                                                    'total' => $total_html,
                                                    'headertotal' => $head_total,
                                                ]);
                                            } else // Expired Coupon
                                            {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                            // }
                                            // else{
                                            //     $error_msg = '';
                                            //     $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                                            //     return response()->json([
                                            //         'errors' => 1,
                                            //         'errors_message' => $error_msg,
                                            //     ]);
                                            // }
                                        } else {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            // $error_msg .= '<span class="text-danger">Please Select '. ($delivery_type == "collection") ? "delivery" : ($delivery_type == "delivery"  ? "collection" : "") .' to Apply this Coupon.</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                    } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($Couponcode->total >= $request->total) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $code = $Couponcode->toArray();
                                                    session()->put('currentcoupon', $code);
                                                    session()->put('couponname', $Couponcode['name']);
                                                    session()->save();

                                                    if ($userid == 0) {
                                                        $mycart = $request->session()->get('cart1');
                                                    } else {
                                                        $mycart = $request->session()->get('cart1'); // Session
                                                        // $mycart = getuserCart($userid); // Database
                                                    }

                                                    $subtotal = 0;
                                                    $delivery_charge = 0;

                                                    if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                        foreach ($mycart['size'] as $key => $cart) {
                                                            if ($delivery_type == 'delivery') {
                                                                $price = $cart['del_price'] * $cart['quantity'];
                                                            } elseif ($delivery_type == 'collection') {
                                                                $price = $cart['col_price'] * $cart['quantity'];
                                                            } else {

                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                            }
                                                            $subtotal += $price;
                                                            // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                        }
                                                    }

                                                    if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                        foreach ($mycart['withoutSize'] as $key => $cart) {
                                                            if ($delivery_type == 'delivery') {
                                                                $price = $cart['del_price'] * $cart['quantity'];
                                                            } elseif ($delivery_type == 'collection') {
                                                                $price = $cart['col_price'] * $cart['quantity'];
                                                            } else {

                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                            }
                                                            $subtotal += $price;
                                                            // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                        }
                                                    }

                                                    $couponcode = 0;
                                                    if ($Couponcode['total'] >= $subtotal) {

                                                        if ($Couponcode->type == 'P') {
                                                            $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                        }
                                                        if ($Couponcode->type == 'F') {
                                                            $couponcode = $Couponcode->discount;
                                                        }
                                                    }

                                                    $total = $subtotal - $couponcode + $delivery_charge;
                                                    $all_total = ($total <= 0) ? 0 : $total;

                                                    $total_html = '';
                                                    $couponcode_html = '';
                                                    $success_message = '';

                                                    $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                    // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                    $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                    //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                                    if ($request->method_type == 1) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $stripe_charge, 2));
                                                    } elseif ($request->method_type == 2) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                    } elseif ($request->method_type == 3) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $cod_charge, 2));
                                                    } else {
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                        $head_total = (round($all_total, 2) );
                                                    }

                                                    // echo '<pre>';
                                                    // print_r($total_html+ 2);
                                                    // exit();
                                                    return response()->json([
                                                        'success' => 1,
                                                        'success_message' => $success_message,
                                                        'couponcode' => $couponcode_html,
                                                        'total' => $total_html,
                                                        'headertotal' => $head_total,
                                                    ]);
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '';
                                                    $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    return response()->json([
                                                        'errors' => 1,
                                                        'errors_message' => $error_msg,
                                                    ]);
                                                }
                                            } else {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Maximum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            // if ($request->total >= $Couponcode->total) {
                                            if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                            {
                                                $code = $Couponcode->toArray();
                                                session()->put('currentcoupon', $code);
                                                session()->put('couponname', $Couponcode['name']);
                                                session()->save();

                                                if ($userid == 0) {
                                                    $mycart = $request->session()->get('cart1');
                                                } else {
                                                    $mycart = $request->session()->get('cart1'); // Session
                                                    // $mycart = getuserCart($userid); // Database
                                                }

                                                $subtotal = 0;
                                                $delivery_charge = 0;

                                                if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                    foreach ($mycart['size'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                    foreach ($mycart['withoutSize'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                $couponcode = 0;
                                                if ($Couponcode['total'] >= $subtotal) {

                                                    if ($Couponcode->type == 'P') {
                                                        $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                    }
                                                    if ($Couponcode->type == 'F') {
                                                        $couponcode = $Couponcode->discount;
                                                    }
                                                }
                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                $all_total = ($total <= 0) ? 0 : $total;

                                                $total_html = '';
                                                $couponcode_html = '';
                                                $success_message = '';

                                                $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';

                                                //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                                if ($request->method_type == 1) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $stripe_charge, 2));
                                                } elseif ($request->method_type == 2) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                } elseif ($request->method_type == 3) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $cod_charge, 2));
                                                } else {
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                    $head_total = (round($all_total, 2) );
                                                }
                                                // echo '<pre>';
                                                // print_r($total_html+ 4);
                                                // exit();
                                                return response()->json([
                                                    'success' => 1,
                                                    'success_message' => $success_message,
                                                    'couponcode' => $couponcode_html,
                                                    'total' => $total_html,
                                                    'headertotal' => $head_total,
                                                ]);
                                            } else // Expired Coupon
                                            {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                            // }
                                            // else{
                                            //     $error_msg = '';
                                            //     $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                                            //     return response()->json([
                                            //         'errors' => 1,
                                            //         'errors_message' => $error_msg,
                                            //     ]);
                                            // }
                                        } else {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            // $error_msg .= '<span class="text-danger">Please Select '. ($delivery_type == "collection") ? "delivery" : ($delivery_type == "delivery"  ? "collection" : "") .' to Apply this Coupon.</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                    } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                        if ($apply_shipping == $delivery_type) {
                                            if ($Couponcode->total >= $request->total) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $code = $Couponcode->toArray();
                                                    session()->put('currentcoupon', $code);
                                                    session()->put('couponname', $Couponcode['name']);
                                                    session()->save();

                                                    if ($userid == 0) {
                                                        $mycart = $request->session()->get('cart1');
                                                    } else {
                                                        $mycart = $request->session()->get('cart1'); // Session
                                                        // $mycart = getuserCart($userid); // Database
                                                    }

                                                    $subtotal = 0;
                                                    $delivery_charge = 0;

                                                    if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                        foreach ($mycart['size'] as $key => $cart) {
                                                            if ($delivery_type == 'delivery') {
                                                                $price = $cart['del_price'] * $cart['quantity'];
                                                            } elseif ($delivery_type == 'collection') {
                                                                $price = $cart['col_price'] * $cart['quantity'];
                                                            } else {

                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                            }
                                                            $subtotal += $price;
                                                            // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                        }
                                                    }

                                                    if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                        foreach ($mycart['withoutSize'] as $key => $cart) {
                                                            if ($delivery_type == 'delivery') {
                                                                $price = $cart['del_price'] * $cart['quantity'];
                                                            } elseif ($delivery_type == 'collection') {
                                                                $price = $cart['col_price'] * $cart['quantity'];
                                                            } else {

                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                            }
                                                            $subtotal += $price;
                                                            // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                        }
                                                    }
                                                    $couponcode = 0;
                                                    if ($Couponcode['total'] >= $subtotal) {

                                                        if ($Couponcode->type == 'P') {
                                                            $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                        }
                                                        if ($Couponcode->type == 'F') {
                                                            $couponcode = $Couponcode->discount;
                                                        }
                                                    }

                                                    // $total = $subtotal - $couponcode + $delivery_charge;
                                                    $total = $subtotal - $couponcode;
                                                    $all_total = ($total <= 0) ? 0 : $total;



                                                    $total_html = '';
                                                    $couponcode_html = '';
                                                    $success_message = '';

                                                    $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                    // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                    $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                    //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                                    if ($request->method_type == 1) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $stripe_charge, 2));
                                                    } elseif ($request->method_type == 2) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                    } elseif ($request->method_type == 3) {
                                                        // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                        $head_total = (round($all_total + $cod_charge, 2));
                                                    } else {
                                                        $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                        $head_total = (round($all_total, 2) );
                                                    }

                                                    // echo '<pre>';
                                                    // print_r($total_html+ 5);
                                                    // exit();
                                                    return response()->json([
                                                        'success' => 1,
                                                        'success_message' => $success_message,
                                                        'couponcode' => $couponcode_html,
                                                        'total' => $total_html,
                                                        'headertotal' => $head_total,
                                                    ]);
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '';
                                                    $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    return response()->json([
                                                        'errors' => 1,
                                                        'errors_message' => $error_msg,
                                                    ]);
                                                }
                                            } else {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Maximum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            // if ($request->total >= $Couponcode->total) {
                                            if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                            {
                                                $code = $Couponcode->toArray();
                                                session()->put('currentcoupon', $code);
                                                session()->put('couponname', $Couponcode['name']);
                                                session()->save();

                                                if ($userid == 0) {
                                                    $mycart = $request->session()->get('cart1');
                                                } else {
                                                    $mycart = $request->session()->get('cart1'); // Session
                                                    // $mycart = getuserCart($userid); // Database
                                                }

                                                $subtotal = 0;
                                                $delivery_charge = 0;

                                                if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                    foreach ($mycart['size'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                    foreach ($mycart['withoutSize'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                $couponcode = 0;
                                                if ($Couponcode['total'] >= $subtotal) {

                                                    if ($Couponcode->type == 'P') {
                                                        $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                    }
                                                    if ($Couponcode->type == 'F') {
                                                        $couponcode = $Couponcode->discount;
                                                    }
                                                }

                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                $all_total = ($total <= 0) ? 0 : $total;

                                                $total_html = '';
                                                $couponcode_html = '';
                                                $success_message = '';

                                                $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';

                                                //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                                if ($request->method_type == 1) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $stripe_charge, 2));
                                                } elseif ($request->method_type == 2) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                } elseif ($request->method_type == 3) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $cod_charge, 2));
                                                } else {
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                    $head_total = (round($all_total, 2) );
                                                }

                                                // echo '<pre>';
                                                // print_r($total_html+ 6);
                                                // exit();
                                                return response()->json([
                                                    'success' => 1,
                                                    'success_message' => $success_message,
                                                    'couponcode' => $couponcode_html,
                                                    'total' => $total_html,
                                                    'headertotal' => $head_total,
                                                ]);
                                            } else // Expired Coupon
                                            {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                            // }
                                            // else{
                                            //     $error_msg = '';
                                            //     $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                                            //     return response()->json([
                                            //         'errors' => 1,
                                            //         'errors_message' => $error_msg,
                                            //     ]);
                                            // }
                                        } else {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            // $error_msg .= '<span class="text-danger">Please Select '. ($delivery_type == "collection") ? "delivery" : ($delivery_type == "delivery"  ? "collection" : "") .' to Apply this Coupon.</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                    }
                                }
                            } else {
                                $error_msg = '';
                                $error_msg .= '<span class="text-danger">This Coupon already Used.</span>';
                                return response()->json([
                                    'errors' => 1,
                                    'errors_message' => $error_msg,
                                ]);
                            }
                        } else {
                            $error_msg = '';
                            $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                            return response()->json([
                                'errors' => 1,
                                'errors_message' => $error_msg,
                            ]);
                        }
                    } else {
                        $error_msg = '';
                        $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                        return response()->json([
                            'errors' => 1,
                            'errors_message' => $error_msg,
                        ]);
                    }
                }
            } elseif ($Couponcode->logged == 0) {
                if ($Couponcode->apply_shipping == 1) {
                    $apply_shipping = 'delivery';
                } elseif ($Couponcode->apply_shipping == 2) {
                    $apply_shipping = 'collection';
                } elseif ($Couponcode->apply_shipping == 3) {
                    $apply_shipping = 'both';
                } else {
                    $apply_shipping = '';
                }
                $cpn_history = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->get();
                $count_user_per_cpn = count($cpn_history);
                // $cart = getuserCart($userid); // Database
                // $cart_proid = $cart['product_id'];
                $uses_per_cpn = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->where('customer_id', $userid)->count();
                if ($Couponcode->on_off == 1 && $Couponcode->status == 1) {
                    if ($Couponcode->uses_total >  $count_user_per_cpn || $Couponcode->uses_total == 0) {
                        if ($Couponcode->uses_customer > $uses_per_cpn) {
                            if (!empty($session_proid) ||  $session_proid != '') {
                                if (array_intersect($product_check,  $session_proid) && count($product_check) != 0) {
                                    if ($apply_shipping == $delivery_type) {

                                        if ($Couponcode->total >= $request->total) {

                                            if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                            {

                                                $code = $Couponcode->toArray();
                                                session()->put('currentcoupon', $code);
                                                session()->put('couponname', $Couponcode['name']);
                                                session()->save();

                                                if ($userid == 0) {
                                                    $mycart = $request->session()->get('cart1');
                                                } else {
                                                    $mycart = $request->session()->get('cart1'); // Session
                                                    // $mycart = getuserCart($userid); // Database
                                                }

                                                $subtotal = 0;
                                                $delivery_charge = 0;

                                                if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                    foreach ($mycart['size'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                    foreach ($mycart['withoutSize'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                $couponcode = 0;
                                                if ($Couponcode['total'] >= $subtotal) {

                                                    if ($Couponcode->type == 'P') {
                                                        $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                    }
                                                    if ($Couponcode->type == 'F') {
                                                        $couponcode = $Couponcode->discount;
                                                    }
                                                }

                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                $all_total = ($total <= 0) ? 0 : $total;

                                                $total_html = '';
                                                $couponcode_html = '';
                                                $success_message = '';

                                                $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                                if ($request->method_type == 1) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $stripe_charge, 2));
                                                } elseif ($request->method_type == 2) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                } elseif ($request->method_type == 3) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $cod_charge, 2));
                                                } else {
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                    $head_total = (round($all_total, 2) );
                                                }

                                                // echo '<pre>';
                                                // print_r($total_html+ 7);
                                                // exit();
                                                return response()->json([
                                                    'success' => 1,
                                                    'success_message' => $success_message,
                                                    'couponcode' => $couponcode_html,
                                                    'total' => $total_html,
                                                    'headertotal' => $head_total,
                                                ]);
                                            } else // Expired Coupon
                                            {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                        } else {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger">Maximum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                    } elseif ($apply_shipping == 'both') {
                                        // if ($request->total >= $Couponcode->total) {
                                        if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                        {
                                            $code = $Couponcode->toArray();
                                            session()->put('currentcoupon', $code);
                                            session()->put('couponname', $Couponcode['name']);
                                            session()->save();

                                            if ($userid == 0) {
                                                $mycart = $request->session()->get('cart1');
                                            } else {
                                                $mycart = $request->session()->get('cart1'); // Session
                                                // $mycart = getuserCart($userid); // Database
                                            }

                                            $subtotal = 0;
                                            $delivery_charge = 0;

                                            if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                foreach ($mycart['size'] as $key => $cart) {
                                                    if ($delivery_type == 'delivery') {
                                                        $price = $cart['del_price'] * $cart['quantity'];
                                                    } elseif ($delivery_type == 'collection') {
                                                        $price = $cart['col_price'] * $cart['quantity'];
                                                    } else {

                                                        $price = $cart['main_price'] * $cart['quantity'];
                                                    }
                                                    $subtotal += $price;
                                                    // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                }
                                            }

                                            if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                foreach ($mycart['withoutSize'] as $key => $cart) {
                                                    if ($delivery_type == 'delivery') {
                                                        $price = $cart['del_price'] * $cart['quantity'];
                                                    } elseif ($delivery_type == 'collection') {
                                                        $price = $cart['col_price'] * $cart['quantity'];
                                                    } else {

                                                        $price = $cart['main_price'] * $cart['quantity'];
                                                    }
                                                    $subtotal += $price;
                                                    // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                }
                                            }

                                            $couponcode = 0;
                                            if ($Couponcode['total'] >= $subtotal) {

                                                if ($Couponcode->type == 'P') {
                                                    $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                }
                                                if ($Couponcode->type == 'F') {
                                                    $couponcode = $Couponcode->discount;
                                                }
                                            }
                                            $total = $subtotal - $couponcode + $delivery_charge;
                                            $all_total = ($total <= 0) ? 0 : $total;

                                            $total_html = '';
                                            $couponcode_html = '';
                                            $success_message = '';

                                            $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                            // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                            $couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span>';
                                            if ($request->method_type == 1) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $stripe_charge, 2));
                                            } elseif ($request->method_type == 2) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $paypal_charge, 2)) ;
                                            } elseif ($request->method_type == 3) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $cod_charge, 2));
                                            } else {
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                $head_total = (round($all_total, 2) );
                                            }
                                            // echo '<pre>';
                                            // print_r($total_html+ 8);
                                            // exit();
                                            return response()->json([
                                                'success' => 1,
                                                'success_message' => $success_message,
                                                'couponcode' => $couponcode_html,
                                                'total' => $total_html,
                                                'headertotal' => $head_total,
                                            ]);
                                        } else // Expired Coupon
                                        {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                        // }
                                        // else{
                                        //     $error_msg = '';
                                        //     $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                                        //     return response()->json([
                                        //         'errors' => 1,
                                        //         'errors_message' => $error_msg,
                                        //     ]);
                                        // }
                                    } else {
                                        $error_msg = '';
                                        $error_msg .= '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                        // $error_msg .= '<span class="text-danger">Please Select '. ($delivery_type == "collection") ? "delivery" : ($delivery_type == "delivery"  ? "collection" : "") .' to Apply this Coupon.</span>';
                                        return response()->json([
                                            'errors' => 1,
                                            'errors_message' => $error_msg,
                                        ]);
                                    }
                                } elseif (array_intersect($cat_to_pro,  $session_proid) && count($cat_to_pro) != 0) {

                                    if ($apply_shipping == $delivery_type) {
                                        if ($Couponcode->total >= $request->total) {
                                            if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                            {
                                                $code = $Couponcode->toArray();
                                                session()->put('currentcoupon', $code);
                                                session()->put('couponname', $Couponcode['name']);
                                                session()->save();

                                                if ($userid == 0) {
                                                    $mycart = $request->session()->get('cart1');
                                                } else {
                                                    $mycart = $request->session()->get('cart1'); // Session
                                                    // $mycart = getuserCart($userid); // Database
                                                }

                                                $subtotal = 0;
                                                $delivery_charge = 0;

                                                if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                    foreach ($mycart['size'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                    foreach ($mycart['withoutSize'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                $couponcode = 0;
                                                if ($Couponcode['total'] >= $subtotal) {

                                                    if ($Couponcode->type == 'P') {
                                                        $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                    }
                                                    if ($Couponcode->type == 'F') {
                                                        $couponcode = $Couponcode->discount;
                                                    }
                                                }

                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                $all_total = ($total <= 0) ? 0 : $total;

                                                $total_html = '';
                                                $couponcode_html = '';
                                                $success_message = '';

                                                $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';
                                                if ($request->method_type == 1) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $stripe_charge, 2));
                                                } elseif ($request->method_type == 2) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                } elseif ($request->method_type == 3) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $cod_charge, 2));
                                                } else {
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                    $head_total = (round($all_total, 2) );
                                                }

                                                // echo '<pre>';
                                                // print_r($total_html+ 9);
                                                // exit();
                                                return response()->json([
                                                    'success' => 1,
                                                    'success_message' => $success_message,
                                                    'couponcode' => $couponcode_html,
                                                    'total' => $total_html,
                                                    'headertotal' => $head_total,
                                                ]);
                                            } else // Expired Coupon
                                            {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                        } else {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger">Maximum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                    } elseif ($apply_shipping == 'both') {
                                        // if ($request->total >= $Couponcode->total) {
                                        if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                        {
                                            $code = $Couponcode->toArray();
                                            session()->put('currentcoupon', $code);
                                            session()->put('couponname', $Couponcode['name']);
                                            session()->save();

                                            if ($userid == 0) {
                                                $mycart = $request->session()->get('cart1');
                                            } else {
                                                $mycart = $request->session()->get('cart1'); // Session
                                                // $mycart = getuserCart($userid); // Database
                                            }

                                            $subtotal = 0;
                                            $delivery_charge = 0;

                                            if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                foreach ($mycart['size'] as $key => $cart) {
                                                    if ($delivery_type == 'delivery') {
                                                        $price = $cart['del_price'] * $cart['quantity'];
                                                    } elseif ($delivery_type == 'collection') {
                                                        $price = $cart['col_price'] * $cart['quantity'];
                                                    } else {

                                                        $price = $cart['main_price'] * $cart['quantity'];
                                                    }
                                                    $subtotal += $price;
                                                    // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                }
                                            }

                                            if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                foreach ($mycart['withoutSize'] as $key => $cart) {
                                                    if ($delivery_type == 'delivery') {
                                                        $price = $cart['del_price'] * $cart['quantity'];
                                                    } elseif ($delivery_type == 'collection') {
                                                        $price = $cart['col_price'] * $cart['quantity'];
                                                    } else {

                                                        $price = $cart['main_price'] * $cart['quantity'];
                                                    }
                                                    $subtotal += $price;
                                                    // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                }
                                            }

                                            $couponcode = 0;
                                            if ($Couponcode['total'] >= $subtotal) {

                                                if ($Couponcode->type == 'P') {
                                                    $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                }
                                                if ($Couponcode->type == 'F') {
                                                    $couponcode = $Couponcode->discount;
                                                }
                                            }

                                            $total = $subtotal - $couponcode + $delivery_charge;

                                            $all_total = ($total <= 0) ? 0 : $total;


                                            $total_html = '';
                                            $couponcode_html = '';
                                            $success_message = '';

                                            $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                            // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                            $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';

                                            //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';
                                            if ($request->method_type == 1) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $stripe_charge, 2));
                                            } elseif ($request->method_type == 2) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $paypal_charge, 2)) ;
                                            } elseif ($request->method_type == 3) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $cod_charge, 2));
                                            } else {
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                $head_total = (round($all_total, 2) );
                                            }

                                            // echo '<pre>';
                                            // print_r($total_html+ 10);
                                            // exit();
                                            return response()->json([
                                                'success' => 1,
                                                'success_message' => $success_message,
                                                'couponcode' => $couponcode_html,
                                                'total' => $total_html,
                                                'headertotal' => $head_total,
                                            ]);
                                        } else // Expired Coupon
                                        {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                        // }
                                        // else{
                                        //     $error_msg = '';
                                        //     $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                                        //     return response()->json([
                                        //         'errors' => 1,
                                        //         'errors_message' => $error_msg,
                                        //     ]);
                                        // }
                                    } else {
                                        $error_msg = '';
                                        $error_msg .= '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                        // $error_msg .= '<span class="text-danger">Please Select '. ($delivery_type == "collection") ? "delivery" : ($delivery_type == "delivery"  ? "collection" : "") .' to Apply this Coupon.</span>';
                                        return response()->json([
                                            'errors' => 1,
                                            'errors_message' => $error_msg,
                                        ]);
                                    }
                                } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                    if ($apply_shipping == $delivery_type) {

                                        if ($Couponcode->total >= $request->total) {
                                            if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                            {

                                                $code = $Couponcode->toArray();
                                                session()->put('currentcoupon', $code);
                                                session()->put('couponname', $Couponcode['name']);
                                                session()->save();

                                                if ($userid == 0) {
                                                    $mycart = $request->session()->get('cart1');
                                                } else {
                                                    $mycart = $request->session()->get('cart1'); // Session
                                                    // $mycart = getuserCart($userid); // Database
                                                }

                                                $subtotal = 0;
                                                $delivery_charge = 0;

                                                if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                    foreach ($mycart['size'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }

                                                if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                    foreach ($mycart['withoutSize'] as $key => $cart) {
                                                        if ($delivery_type == 'delivery') {
                                                            $price = $cart['del_price'] * $cart['quantity'];
                                                        } elseif ($delivery_type == 'collection') {
                                                            $price = $cart['col_price'] * $cart['quantity'];
                                                        } else {

                                                            $price = $cart['main_price'] * $cart['quantity'];
                                                        }
                                                        $subtotal += $price;
                                                        // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                    }
                                                }
                                                $couponcode = 0;
                                                if ($Couponcode['total'] >= $subtotal) {

                                                    if ($Couponcode->type == 'P') {
                                                        $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                    }
                                                    if ($Couponcode->type == 'F') {
                                                        $couponcode = $Couponcode->discount;
                                                    }
                                                }


                                                // $total = $subtotal - $couponcode + $delivery_charge;
                                                $total = $subtotal - $couponcode;
                                                $all_total = ($total <= 0) ? 0 : $total;




                                                $total_html = '';
                                                $couponcode_html = '';
                                                $success_message = '';

                                                $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                                // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                                $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                                //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';
                                                if ($request->method_type == 1) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $stripe_charge, 2));
                                                } elseif ($request->method_type == 2) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $paypal_charge, 2)) ;
                                                } elseif ($request->method_type == 3) {
                                                    // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                    $head_total = (round($all_total + $cod_charge, 2));
                                                } else {
                                                    $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                    $head_total = (round($all_total, 2) );
                                                }
                                                // echo '<pre>';
                                                // print_r($total_html+ 11);
                                                // exit();
                                                return response()->json([
                                                    'success' => 1,
                                                    'success_message' => $success_message,
                                                    'couponcode' => $couponcode_html,
                                                    'total' => $total_html,
                                                    'headertotal' => $head_total,
                                                ]);
                                            } else // Expired Coupon
                                            {
                                                $error_msg = '';
                                                $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                return response()->json([
                                                    'errors' => 1,
                                                    'errors_message' => $error_msg,
                                                ]);
                                            }
                                        } else {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger">Maximum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                    } elseif ($apply_shipping == 'both') {
                                        // if ($request->total >= $Couponcode->total) {
                                        if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                        {
                                            $code = $Couponcode->toArray();
                                            session()->put('currentcoupon', $code);
                                            session()->put('couponname', $Couponcode['name']);
                                            session()->save();

                                            if ($userid == 0) {
                                                $mycart = $request->session()->get('cart1');
                                            } else {
                                                $mycart = $request->session()->get('cart1'); // Session
                                                // $mycart = getuserCart($userid); // Database
                                            }

                                            $subtotal = 0;
                                            $delivery_charge = 0;

                                            if (isset($mycart['size']) || !empty($mycart['size'])) {
                                                foreach ($mycart['size'] as $key => $cart) {
                                                    if ($delivery_type == 'delivery') {
                                                        $price = $cart['del_price'] * $cart['quantity'];
                                                    } elseif ($delivery_type == 'collection') {
                                                        $price = $cart['col_price'] * $cart['quantity'];
                                                    } else {

                                                        $price = $cart['main_price'] * $cart['quantity'];
                                                    }
                                                    $subtotal += $price;
                                                    // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                }
                                            }

                                            if (isset($mycart['withoutSize']) || !empty($mycart['withoutSize'])) {
                                                foreach ($mycart['withoutSize'] as $key => $cart) {
                                                    if ($delivery_type == 'delivery') {
                                                        $price = $cart['del_price'] * $cart['quantity'];
                                                    } elseif ($delivery_type == 'collection') {
                                                        $price = $cart['col_price'] * $cart['quantity'];
                                                    } else {

                                                        $price = $cart['main_price'] * $cart['quantity'];
                                                    }
                                                    $subtotal += $price;
                                                    // $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0.00;
                                                }
                                            }

                                            $couponcode = 0;
                                            if ($Couponcode['total'] >= $subtotal) {

                                                if ($Couponcode->type == 'P') {
                                                    $couponcode = ($subtotal * $Couponcode->discount) / 100;
                                                }
                                                if ($Couponcode->type == 'F') {
                                                    $couponcode = $Couponcode->discount;
                                                }
                                            }

                                            $total = $subtotal - $couponcode + $delivery_charge;
                                            $all_total = ($total <= 0) ? 0 : $total;

                                            $total_html = '';
                                            $couponcode_html = '';
                                            $success_message = '';

                                            $success_message .= '<span class="text-success">Your Coupon has been Applied...</span>';
                                            // $couponcode_html .= '<label><b>Coupon(' . $Couponcode->code . '):</b></label><span><b>£ -' . $couponcode . '</b></span>';
                                            $couponcode_html .= '<tr class="coupon_code"><td><b>Coupon(' . $Couponcode->code . '):</b></td><td><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode, 2)) . '</b></span></td></tr>';
                                            //$couponcode_html .= '<span><b>Coupon(' . $Couponcode->code . '):</b></span><span><b>' . $currency . ' -' . (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) . '</b></span>';

                                            // $total_html .= '<label><b>Total to pay:</b></label><span><b id="total_pay">'. $currency . ' . $total . '</b></span>';

                                            if ($request->method_type == 1) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  round($total + $stripe_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $stripe_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $stripe_charge, 2));
                                            } elseif ($request->method_type == 2) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $paypal_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $paypal_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $paypal_charge, 2)) ;
                                            } elseif ($request->method_type == 3) {
                                                // $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . round($total + $cod_charge, 2) . '</b></span>';
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' .  (round($all_total + $cod_charge, 2)) . '</b></span>';
                                                $head_total = (round($all_total + $cod_charge, 2));
                                            } else {
                                                $total_html .= '<span><b>Total to pay:</b></span><span><b id="total_pay">' . $currency . ' ' . (round($all_total, 2)) . '</b></span>';
                                                $head_total = (round($all_total, 2) );
                                            }


                                            return response()->json([
                                                'success' => 1,
                                                'success_message' => $success_message,
                                                'couponcode' => $couponcode_html,
                                                'total' => $total_html,
                                                'headertotal' => $head_total,
                                            ]);
                                        } else // Expired Coupon
                                        {
                                            $error_msg = '';
                                            $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                            return response()->json([
                                                'errors' => 1,
                                                'errors_message' => $error_msg,
                                            ]);
                                        }
                                        // }
                                        // else{
                                        //     $error_msg = '';
                                        //     $error_msg .= '<span class="text-danger">Minimum Amount is '.$currency.''.number_format($Couponcode->total,0).' for Apply This Coupon.</span>';
                                        //     return response()->json([
                                        //         'errors' => 1,
                                        //         'errors_message' => $error_msg,
                                        //     ]);
                                        // }
                                    } else {
                                        $error_msg = '';
                                        $error_msg .= '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                        // $error_msg .= '<span class="text-danger">Please Select '. ($delivery_type == "collection") ? "delivery" : ($delivery_type == "delivery"  ? "collection" : "") .' to Apply this Coupon.</span>';
                                        return response()->json([
                                            'errors' => 1,
                                            'errors_message' => $error_msg,
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $error_msg = '';
                            $error_msg .= '<span class="text-danger">This Coupon already Used.</span>';
                            return response()->json([
                                'errors' => 1,
                                'errors_message' => $error_msg,
                            ]);
                        }
                    } else {
                        $error_msg = '';
                        $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                        return response()->json([
                            'errors' => 1,
                            'errors_message' => $error_msg,
                        ]);
                    }
                } else {
                    $error_msg = '';
                    $error_msg .= '<span class="text-danger">Sorry Coupon is Expired!</span>';
                    return response()->json([
                        'errors' => 1,
                        'errors_message' => $error_msg,
                    ]);
                }
            } else {
                $error_msg = '';
                $error_msg .= '<span class="text-danger">Login Required.</span>';
                return response()->json([
                    'errors' => 1,
                    'errors_message' => $error_msg,
                ]);
            }
        } else // Invalid Coupon
        {
            $error_msg = '';
            $error_msg .= '<span class="text-danger">Please enter valid Coupon Code</span>';
            return response()->json([
                'errors' => 1,
                'errors_message' => $error_msg,
            ]);
        }
    }




    // Function For  Set Delivery Type
    public function setDeliveyType(Request $request)
    {

        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // $Coupon = Coupon::where('store_id', $front_store_id)->first();

        $current_date = strtotime(date('Y-m-d'));


        if (session()->has('currentcoupon')) {
            $Coupon = session()->get('currentcoupon');
        } else {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();

            if (!empty($get_coupon) || $get_coupon != '') {
                // $start_date = strtotime($get_coupon->date_start);
                // $end_date = strtotime($get_coupon->date_end);

                $start_date = isset($get_coupon->date_start) ? strtotime($get_coupon->date_start) : '';
                $end_date = isset($get_coupon->date_end) ? strtotime($get_coupon->date_end) : '';

                if ($current_date >= $start_date && $current_date < $end_date) {
                    $Coupon = $get_coupon;
                } else {
                    $Coupon = '';
                }
            } else {
                $Coupon = '';
            }
        }
        $flag_post_code = session()->get('flag_post_code');
        $d_type = $request->d_type;

        // Check User ID
        if (session()->has('userid')) {
            $userid = session()->get('userid');
        } else {
            $userid = 0;
        }
        if ($flag_post_code == $d_type) {

            // Guest User
            if ($userid == 0) {
                if (session()->has('cart1')) {
                    $cart = session()->get('cart1');

                    // if (!empty($cart) || isset($cart)) {
                    //     // For Delivery Price
                    //     if ($d_type == 'delivery') {
                    //         if (isset($cart['size']) && !empty($cart['size'])) {
                    //             foreach ($cart['size'] as $key => $value) {
                    //                 $size_id = $key;
                    //                 $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                    //                 $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                    //                 $cart['size'][$key]['del_price'] = $del_price;
                    //                 session()->put('cart1', $cart);
                    //             }
                    //         }

                    //         if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                    //             foreach ($cart['withoutSize'] as $key => $value) {
                    //                 $prod_id = $key;
                    //                 $prod = Product::where('product_id', $prod_id)->first();
                    //                 $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                    //                 $cart['withoutSize'][$key]['del_price'] = $del_price;
                    //                 session()->put('cart1', $cart);
                    //             }
                    //         }
                    //     } elseif ($d_type == 'collection') {
                    //         if (isset($cart['size']) && !empty($cart['size'])) {
                    //             foreach ($cart['size'] as $key => $value) {
                    //                 $size_id = $key;
                    //                 $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                    //                 $col_price = isset($prod->collection_price) ? $prod->collection_price : 0.00;
                    //                 $cart['size'][$key]['col_price'] = $col_price;
                    //                 session()->put('cart1', $cart);
                    //             }
                    //         }

                    //         if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                    //             foreach ($cart['withoutSize'] as $key => $value) {
                    //                 $prod_id = $key;
                    //                 $prod = Product::where('product_id', $prod_id)->first();
                    //                 $col_price = isset($prod->collection_price) ? $prod->collection_price : 0.00;
                    //                 $cart['withoutSize'][$key]['col_price'] = $col_price;
                    //                 session()->put('cart1', $cart);
                    //             }
                    //         }
                    //     }
                    // }
                }
            } else {
                if (!empty($userid)) {
                    // $customer_cart = getuserCart($userid); //Database
                    $customer_cart = session()->get('cart1'); //Session

                    // if (isset($customer_cart) && !empty($customer_cart)) {
                    //     // For Delivery Price
                    //     if ($d_type == 'delivery') {
                    //         if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                    //             foreach ($customer_cart['size'] as $key => $value) {
                    //                 $size_id = $key;
                    //                 $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                    //                 $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                    //                 $customer_cart['size'][$key]['del_price'] = $del_price;

                    //                 $serial = serialize($customer_cart);
                    //                 $base64 = base64_encode($serial);
                    //                 $user = Customer::find($userid);
                    //                 $user->cart = $base64;
                    //                 $user->update();
                    //             }
                    //         }

                    //         if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                    //             foreach ($customer_cart['withoutSize'] as $key => $value) {
                    //                 $prod_id = $key;
                    //                 $prod = Product::where('product_id', $prod_id)->first();
                    //                 $del_price = isset($prod->delivery_price) ? $prod->delivery_price : 0.00;
                    //                 $customer_cart['withoutSize'][$key]['del_price'] = $del_price;

                    //                 $serial = serialize($customer_cart);
                    //                 $base64 = base64_encode($serial);
                    //                 $user = Customer::find($userid);
                    //                 $user->cart = $base64;
                    //                 $user->update();
                    //             }
                    //         }
                    //     } elseif ($d_type == 'collection') {
                    //         if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                    //             foreach ($customer_cart['size'] as $key => $value) {
                    //                 $size_id = $key;
                    //                 $prod = ToppingProductPriceSize::where('id_product_price_size', $size_id)->first();
                    //                 $col_price = isset($prod->collection_price) ? $prod->collection_price : 0.00;
                    //                 $customer_cart['size'][$key]['col_price'] = $col_price;

                    //                 $serial = serialize($customer_cart);
                    //                 $base64 = base64_encode($serial);
                    //                 $user = Customer::find($userid);
                    //                 $user->cart = $base64;
                    //                 $user->update();
                    //             }
                    //         }

                    //         if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                    //             foreach ($customer_cart['withoutSize'] as $key => $value) {
                    //                 $prod_id = $key;
                    //                 $prod = Product::where('product_id', $prod_id)->first();
                    //                 $col_price = isset($prod->collection_price) ? $prod->collection_price : 0.00;
                    //                 $customer_cart['withoutSize'][$key]['col_price'] = $col_price;

                    //                 $serial = serialize($customer_cart);
                    //                 $base64 = base64_encode($serial);
                    //                 $user = Customer::find($userid);
                    //                 $user->cart = $base64;
                    //                 $user->update();
                    //             }
                    //         }
                    //     }
                    // }
                }
            }


            // Get New Delivery Total & Total
            $coupontotal = 0;
            $sub_total = 0;

            if ($userid == 0) {
                if (session()->has('cart1')) {
                    $cart = session()->get('cart1');

                    // if (!empty($cart) || isset($cart)) {
                    //     if (isset($cart['size']) && !empty($cart['size'])) {
                    //         foreach ($cart['size'] as $key => $value) {
                    //             if ($d_type == 'delivery') {
                    //                 $sub_total += $value['del_price'] * $value['quantity'];
                    //             } elseif ($d_type == 'collection') {
                    //                 $sub_total += $value['col_price'] * $value['quantity'];
                    //             } else {
                    //                 $sub_total += $value['main_price'] * $value['quantity'];
                    //             }
                    //         }
                    //     }

                    //     if (isset($cart['withoutSize']) && !empty($cart['withoutSize'])) {
                    //         foreach ($cart['withoutSize'] as $key => $value) {
                    //             if ($d_type == 'delivery') {
                    //                 $sub_total += $value['del_price'] * $value['quantity'];
                    //             } elseif ($d_type == 'collection') {
                    //                 $sub_total += $value['col_price'] * $value['quantity'];
                    //             } else {
                    //                 $sub_total += $value['main_price'] * $value['quantity'];
                    //             }
                    //         }
                    //     }
                    // }
                }
            } else {
                if (!empty($userid)) {
                    // $customer_cart = getuserCart($userid); // Database
                    $customer_cart = session()->get('cart1'); // Session

                    // if (isset($customer_cart) && !empty($customer_cart)) {
                    //     if (isset($customer_cart['size']) && !empty($customer_cart['size'])) {
                    //         foreach ($customer_cart['size'] as $key => $value) {
                    //             if ($d_type == 'delivery') {
                    //                 $sub_total += $value['del_price'] * $value['quantity'];
                    //             } elseif ($d_type == 'collection') {
                    //                 $sub_total += $value['col_price'] * $value['quantity'];
                    //             } else {
                    //                 $sub_total += $value['main_price'] * $value['quantity'];
                    //             }
                    //         }
                    //     }

                    //     if (isset($customer_cart['withoutSize']) && !empty($customer_cart['withoutSize'])) {
                    //         foreach ($customer_cart['withoutSize'] as $key => $value) {
                    //             if ($d_type == 'delivery') {
                    //                 $sub_total += $value['del_price'] * $value['quantity'];
                    //             } elseif ($d_type == 'collection') {
                    //                 $sub_total += $value['col_price'] * $value['quantity'];
                    //             } else {
                    //                 $sub_total += $value['main_price'] * $value['quantity'];
                    //             }
                    //         }
                    //     }
                    // }
                }
            }


            if (!empty($Coupon) || $Coupon != '') {
                if ($Coupon->type == 'P') {
                    $coupontotal = ($sub_total * $Coupon->discount) / 100;
                }

                if ($Coupon->type == 'F') {
                    $coupontotal = $sub_total - $Coupon->discount;
                }
            }



            $total_pay = $sub_total - $coupontotal;

            if (session()->has('total')) {
                session()->put('total', $total_pay);
            } else {
                session()->put('total', $total_pay);
            }
            if (session()->has('subtotal')) {
                session()->put('subtotal', $sub_total);
            } else {
                session()->put('subtotal', $sub_total);
            }

            // $sessiontotal = session()->put('total',$total_pay);
            // $sessionsubtotal = session()->put('subtotal',$sub_total);
            session()->put('flag_post_code', $d_type);


            return response()->json([
                'success' => 1,
                'total_pay' => '£ ' . $total_pay,
            ]);
        } else {

            if ($userid == 0) {
                // session()->delete('cart1');
                session()->forget('cart1');
            } else {
                // session()->delete('cart1');
                session()->forget('cart1');
                // $user = Customer::find($userid);
                // $user->cart = '';
                // $user->update();
            }
            session()->put('flag_post_code', $d_type);
            return response()->json([
                'success' => 1,
            ]);
        }
    }

    // Function For Store data
    public function store(Request $request)
    {

        return $request->all();
    }

    // Function For Databade in Search Coupon Code
    public function searchcouponcode(Request $request)
    {
        // Get Current URL
        $currentURL = URL::to("/");

        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);

        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];

        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        $coupon = $request->coupon;
        $filterResult = Coupon::select('code')->where('code', 'LIKE', '%' . $coupon . '%')->where('store_id', $front_store_id)->get();
        return response()->json($filterResult);
    }
}
