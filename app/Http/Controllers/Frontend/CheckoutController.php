<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\CouponProduct;
use App\Models\DeliverySettings;
use App\Models\FreeRule;
use App\Models\Product_to_category;
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
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

        // Get Cart Rule
        $cart_rule = FreeRule::where('id_store', $front_store_id)->first();

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
        $Coupon = '';

        $delivery_type = session()->get('flag_post_code');
        if (session()->has('userid')) {
            $user_id = session()->get('userid');
        } else {
            $user_id = 0;
        }
        if (session()->has('currentcoupon')) {
            $session_get_coupon = session()->get('currentcoupon');
            if (isset($session_get_coupon)) {
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

                $start_date = isset($session_get_coupon['date_start']) ? strtotime($session_get_coupon['date_start']) : '';
                $end_date = isset($session_get_coupon['date_end']) ? strtotime($session_get_coupon['date_end']) : '';

                if ($session_get_coupon['logged'] == 1) {
                    if ($user_id != 0) {
                        $cart = getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();
                        if ((!empty($session_get_coupon) || $session_get_coupon != '') && $session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
                            if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
                                if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
                                    if (!empty($cart_proid) ||  $cart_proid != '') {
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
                                        } elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

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
                    if ($user_id != 0) {
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
                    } else {
                        $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
                        // $product_history = CouponProduct::where('product_id', $productid)->first();

                        // $cat_history = CouponCategory::where('category_id', $category_id)->first();
                        $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();

                        $count_user_per_cpn = count($cpn_history);
                        if (!empty($session_get_coupon) || $session_get_coupon != '') {
                            if ($session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
                                if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
                                    //   if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
                                    if (!empty($session_proid) || $session_proid != '') {
                                        if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {

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
                                    //   }
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

                $start_date = isset($get_coupon['date_start']) ? strtotime($get_coupon['date_start']) : '';
                $end_date = isset($get_coupon['date_end']) ? strtotime($get_coupon['date_end']) : '';
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

                    if ($user_id != 0) {

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
                    } else {
                        // echo "ho";
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $count_user_per_cpn = count($cpn_history);

                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                        if ((!empty($get_coupon) || $get_coupon != '') && $get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                if (!empty($session_proid) || $session_proid != '') {
                                    // if ($get_coupon->uses_customer > $uses_per_cpn) {
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
                                    // }
                                }
                            }
                        } else {

                            // if (!empty($get_coupon) || $get_coupon != '') {
                            //     if ($get_coupon->status == 1) {
                            //         if ($get_coupon->on_off == 1) {
                            //             if ($apply_shipping == $delivery_type) {
                            //                 if ($current_date >= $start_date && $current_date < $end_date) {
                            //                     $Coupon = $get_coupon;
                            //                 } else {
                            //                     $Coupon = '';
                            //                 }
                            //             } elseif ($apply_shipping == 'both') {
                            //                 if ($current_date >= $start_date && $current_date < $end_date) {
                            //                     $Coupon = $get_coupon;
                            //                 } else {
                            //                     $Coupon = '';
                            //                 }
                            //             }
                            //         }
                            //     }
                            // }
                        }
                    }
                }
            }
        }

        // minimum spend
        $DeliveryCollectionSettings = Settings::select('value')->where('store_id', $front_store_id)->where('key', 'delivery_option')->first();

        if ($DeliveryCollectionSettings['value'] == 'area') {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'area')->get();
        } else {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'post_codes')->get();
        }
        $minimum_spend = $deliverysettings->last()->toArray();

        return view('frontend.pages.chechout', compact('delivery_setting', 'Coupon', 'areas', 'cart_rule', 'minimum_spend'));
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
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';

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
            // $mycart = getuserCart($userid); // Database
            $mycart = $request->session()->get('cart1'); // Sission
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

        $html .= '<td><b>Voucher Code(' . $vouchercode . ')</b></td><td><span><b>£ -' . number_format($voucheramount, 2) . '</b></span></td>';
        $html1 .= '<td><b>Total to pay:</b></td><td><span><b id="total_pay">£ ' . number_format($total, 2) . '</b></span></td>';

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
