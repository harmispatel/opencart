<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\CouponProduct;
use App\Models\DeliverySettings;
use App\Models\Product_to_category;
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
        $delivery_type = session()->get('flag_post_code');
        if(session()->has('userid')){
            $user_id = session()->get('userid');
         }else{
            $user_id = 0;
         }
        $current_date = strtotime(date('Y-m-d'));
        $Coupon = '';
        if (session()->has('currentcoupon')) {
            $Coupon= session()->get('currentcoupon');
            // $session_get_coupon = session()->get('currentcoupon');
            // if(isset($session_get_coupon)){
            //     $product_history = CouponProduct::where('coupon_id', $session_get_coupon['coupon_id'])->get();
            //     $category_history = CouponCategory::where('coupon_id', $session_get_coupon['coupon_id'])->get();

            //     $category_check = [];
            //     foreach ($category_history as $value) {
            //         $category_check[] = $value->category_id;
            //     }
            //     $cat_to_pro = array();
            //     foreach ($category_check as $values) {
            //         $pro_cat = Product_to_category::where('category_id', $values)->get();
            //         foreach ($pro_cat as $value) {
            //             $cat_to_pro[] = $value->product_id;
            //         }
            //     }
            //     $product_check = array();
            //     foreach ($product_history as $value) {
            //         $product_check[] = $value->product_id;
            //     }
            //     $session_proid = session()->get('product_id');

            //     if ($session_get_coupon['apply_shipping'] == 1) {
            //         $apply_shipping = 'delivery';
            //     } elseif ($session_get_coupon['apply_shipping'] == 2) {
            //         $apply_shipping = 'collection';
            //     } elseif ($session_get_coupon['apply_shipping'] == 3) {
            //         $apply_shipping = 'both';
            //     } else {
            //         $apply_shipping = '';
            //     }

            //     $start_date = isset($session_get_coupon->date_start) ? strtotime($session_get_coupon->date_start) : '';
            //     $end_date = isset($session_get_coupon->date_end) ? strtotime($session_get_coupon->date_end) : '';

            //     if ($session_get_coupon['logged'] == 1) {
            //         if ($user_id != 0) {
            //             $cart =getuserCart($user_id);
            //             $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
            //             $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
            //             $count_user_per_cpn = count($cpn_history);
            //             $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();
            //             if ((!empty($session_get_coupon) || $session_get_coupon != '') && $session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
            //                 if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
            //                     if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
            //                         if (!empty( $cart_proid) ||  $cart_proid != '') {
            //                             if (array_intersect($product_check,  $cart_proid) && count($product_check) != 0) {
            //                                 if ($apply_shipping == $delivery_type) {
            //                                     if ($current_date >= $start_date && $current_date < $end_date) {
            //                                         $Coupon = $session_get_coupon;
            //                                     } else {
            //                                         $Coupon = '';
            //                                     }
            //                                 } elseif ($apply_shipping == 'both') {
            //                                     if ($current_date >= $start_date && $current_date < $end_date) {
            //                                         $Coupon = $session_get_coupon;
            //                                     } else {
            //                                         $Coupon = '';
            //                                     }
            //                                 }
            //                             }
            //                             elseif (array_intersect($cat_to_pro,  $cart_proid) && count($cat_to_pro) != 0) {

            //                                 if ($apply_shipping == $delivery_type) {
            //                                     if ($current_date >= $start_date && $current_date < $end_date) {
            //                                         $Coupon = $session_get_coupon;
            //                                     } else {
            //                                         $Coupon = '';
            //                                     }
            //                                 } elseif ($apply_shipping == 'both') {
            //                                     if ($current_date >= $start_date && $current_date < $end_date) {
            //                                         $Coupon = $session_get_coupon;
            //                                     } else {
            //                                         $Coupon = '';
            //                                     }
            //                                 }
            //                             } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
            //                                 if ($apply_shipping == $delivery_type) {
            //                                     if ($current_date >= $start_date && $current_date < $end_date) {
            //                                         $Coupon = $session_get_coupon;
            //                                     } else {
            //                                         $Coupon = '';
            //                                     }
            //                                 } elseif ($apply_shipping == 'both') {
            //                                     if ($current_date >= $start_date && $current_date < $end_date) {
            //                                         $Coupon = $session_get_coupon;
            //                                     } else {
            //                                         $Coupon = '';
            //                                     }
            //                                 }
            //                             }
            //                         }
            //                     }
            //                 }
            //             }
            //         }
            //     } elseif ($session_get_coupon['logged'] == 0) {
            //         $cpn_history = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->get();
            //         // $product_history = CouponProduct::where('product_id', $productid)->first();

            //         // $cat_history = CouponCategory::where('category_id', $category_id)->first();
            //       $uses_per_cpn = CouponHistory::where('coupon_id', $session_get_coupon['coupon_id'])->where('customer_id', $user_id)->count();

            //         $count_user_per_cpn = count($cpn_history);
            //         if (!empty($session_get_coupon) || $session_get_coupon != '') {
            //             if ($session_get_coupon['status'] == 1 && $session_get_coupon['on_off'] == 1) {
            //                 if ($session_get_coupon['uses_total'] >  $count_user_per_cpn || $session_get_coupon['uses_total'] == 0) {
            //                       if ($session_get_coupon['uses_customer'] > $uses_per_cpn) {
            //                           if (!empty($session_proid) || $session_proid != '') {
            //                               if (array_intersect($product_check, $session_proid) && count($product_check) != 0) {
            //
            //                                   if ($apply_shipping == $delivery_type) {
            //                                       if ($current_date >= $start_date && $current_date < $end_date) {
            //                                           $Coupon = $session_get_coupon;
            //                                       } else {
            //                                           $Coupon = '';
            //                                       }
            //                                   } elseif ($apply_shipping == 'both') {
            //                                       if ($current_date >= $start_date && $current_date < $end_date) {
            //                                           $Coupon = $session_get_coupon;
            //                                       } else {
            //                                           $Coupon = '';
            //                                       }
            //                                   }
            //                               } elseif (array_intersect($cat_to_pro, $session_proid) && count($cat_to_pro) != 0) {
            //                                   // echo 'category ';
            //                                   if ($apply_shipping == $delivery_type) {
            //                                       if ($current_date >= $start_date && $current_date < $end_date) {
            //                                           $Coupon = $session_get_coupon;
            //                                       } else {
            //                                           $Coupon = '';
            //                                       }
            //                                   } elseif ($apply_shipping == 'both') {
            //                                       if ($current_date >= $start_date && $current_date < $end_date) {
            //                                           $Coupon = $session_get_coupon;
            //                                       } else {
            //                                           $Coupon = '';
            //                                       }
            //                                   }
            //                               } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
            //                                   // else {
            //                                   if ($apply_shipping == $delivery_type) {
            //                                       if ($current_date >= $start_date && $current_date < $end_date) {
            //                                           $Coupon = $session_get_coupon;
            //                                       } else {
            //                                           $Coupon = '';
            //                                       }
            //                                   } elseif ($apply_shipping == 'both') {
            //                                       if ($current_date >= $start_date && $current_date < $end_date) {
            //                                           $Coupon = $session_get_coupon;
            //                                       } else {
            //                                           $Coupon = '';
            //                                       }
            //                                   }
            //                               }
            //                           }
            //                       }
            //                           // else{
            //                           //     $Coupon = '';
            //                           // }
            //                 }
            //             }
            //         } else {
            //             if (!empty($session_get_coupon) || $session_get_coupon != '') {
            //                 if ($session_get_coupon['status'] == 1) {
            //                     if ($session_get_coupon['on_off'] == 1) {
            //                         if ($apply_shipping == $delivery_type) {
            //                             if ($current_date >= $start_date && $current_date < $end_date) {
            //                                 $Coupon = $session_get_coupon;
            //                             } else {
            //                                 $Coupon = '';
            //                             }
            //                         } elseif ($apply_shipping == 'both') {
            //                             if ($current_date >= $start_date && $current_date < $end_date) {
            //                                 $Coupon = $session_get_coupon;
            //                             } else {
            //                                 $Coupon = '';
            //                             }
            //                         }
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }
        }
        else
        {
            $get_coupon = Coupon::where('store_id', $front_store_id)->first();
            if(isset($get_coupon)){

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
                        $cart =getuserCart($user_id);
                        $cart_proid = isset($cart['product_id']) ? $cart['product_id'] : '';
                        $cpn_history = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->get();
                        $count_user_per_cpn = count($cpn_history);
                        $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();
                        if ((!empty($get_coupon) || $get_coupon != '') && $get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                if ($get_coupon->uses_customer > $uses_per_cpn) {
                                    if (!empty( $cart_proid) ||  $cart_proid != '') {
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

                    // $cat_history = CouponCategory::where('category_id', $category_id)->first();
                    $uses_per_cpn = CouponHistory::where('coupon_id', $get_coupon->coupon_id)->where('customer_id', $user_id)->count();

                    $count_user_per_cpn = count($cpn_history);
                    if (!empty($get_coupon) || $get_coupon != '') {
                        if ($get_coupon->status == 1 && $get_coupon->on_off == 1) {
                            if ($get_coupon->uses_total >  $count_user_per_cpn || $get_coupon->uses_total == 0) {
                                if ($get_coupon->uses_customer > $uses_per_cpn) {
                                    if (!empty($session_proid) || $session_proid != '') {
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
        // minimum spend
        $DeliveryCollectionSettings = Settings::select('value')->where('store_id', $front_store_id)->where('key', 'delivery_option')->first();

        if ($DeliveryCollectionSettings['value'] == 'area') {
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'area')->get();
        }
        else{
            $deliverysettings = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $front_store_id)->where('delivery_type', 'post_codes')->get();
        }
        $minimum_spend = $deliverysettings->last()->toArray();
        return view('frontend.pages.cart', ['Coupon' => $Coupon,'minimum_spend' => $minimum_spend]);
    }
}
