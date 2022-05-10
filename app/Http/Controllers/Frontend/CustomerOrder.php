<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderCart;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CustomerOrder extends Controller
{
    function confirmorder(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $total = $request->total;

        // Store Details
        $store = Store::where('store_id',$front_store_id)->first();
        // End Store Details

        if(session()->has('userid'))
        {
            $user_id = session()->get('userid');
        }
        else
        {
            $user_id = 0;
        }

        // Customer Details
        if($user_id != 0)
        {
            $customer = Customer::where('customer_id',$user_id)->first();
        }
        // End Customer Details

        $payment_method = $request->p_method;

        if($payment_method == 3)
        {
            if($user_id == 0)
            {
                $guest_user = session()->get('guest_user');

                if(!empty($guest_user))
                {
                    $guestUserCart = session()->get('cart1');

                    // Guest Order
                    $gorder = new Orders;
                    $gorder->invoice_no = 0;
                    $gorder->invoice_prefix = 'INV-2013-00';
                    $gorder->store_id = $front_store_id;
                    $gorder->store_name = isset($store->name) ? $store->name : '';
                    $gorder->store_url = isset($store->url) ? $store->url : '';
                    $gorder->customer_id = 0;
                    $gorder->customer_group_id = isset($customer->customer_group_id) ? $customer->customer_group_id : 0;
                    $gorder->firstname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                    $gorder->lastname = isset($guest_user['lname']) ? $guest_user['lname'] : '';
                    $gorder->email = isset($guest_user['email']) ? $guest_user['email'] : '';
                    $gorder->telephone = isset($guest_user['phone']) ? $guest_user['phone'] : '';
                    $gorder->fax = isset($request->fax) ? $request->fax : '';
                    $gorder->payment_firstname = '';
                    $gorder->payment_lastname = '';
                    $gorder->payment_company = '';
                    $gorder->payment_company_id = 0;
                    $gorder->payment_tax_id = 0;
                    $gorder->payment_address_1 = '';
                    $gorder->payment_address_2 = '';
                    $gorder->payment_city = '';
                    $gorder->payment_postcode = '';
                    $gorder->payment_country = 0;
                    $gorder->payment_country_id = 0;
                    $gorder->payment_zone = 0;
                    $gorder->payment_zone_id = 0;
                    $gorder->payment_address_format = '';
                    $gorder->payment_method = 'Cash on Delivery';
                    $gorder->payment_code = 'cod';
                    $gorder->shipping_firstname = '';
                    $gorder->shipping_lastname = '';
                    $gorder->shipping_company = '';
                    $gorder->shipping_address_1 = '';
                    $gorder->shipping_address_2 = '';
                    $gorder->shipping_city = '';
                    $gorder->shipping_postcode = '';
                    $gorder->shipping_country = 0;
                    $gorder->shipping_country_id = 0;
                    $gorder->shipping_zone = 0;
                    $gorder->shipping_zone_id = 0;
                    $gorder->shipping_address_format = '';
                    $gorder->shipping_method = '';
                    $gorder->shipping_code = '';
                    $gorder->comment = '';
                    $gorder->total = $total;
                    $gorder->order_status_id = 5; //Complete
                    $gorder->message = '';
                    $gorder->accepted_time = '';
                    $gorder->affiliate_id = 0;
                    $gorder->commission = 0.00;
                    $gorder->language_id = 1;
                    $gorder->currency_id = 1;
                    $gorder->currency_code = "GBP";
                    $gorder->currency_value = "1.00000000";
                    $gorder->ip = isset($request->ip) ? $request->ip : '';
                    $gorder->forwarded_ip = '';
                    $gorder->user_agent = '';
                    $gorder->accept_language = '';
                    $gorder->date_added = date('Y-m-d h:i:s');
                    $gorder->date_modified = date('Y-m-d h:i:s');
                    $gorder->flag_post_code = session()->get('flag_post_code');
                    $gorder->free_item = '';
                    $gorder->timedelivery = '';
                    $gorder->gender_id = '';
                    $gorder->clear_history = 0;
                    $gorder->is_delete = 0;
                    $gorder->save();

                    session()->forget('cart1');
                    session()->forget('guest_user');

                    $new_url = $currentURL.'/success';

                    return response()->json([
                        'guest_success_cod' => 1,
                        'guest_success_url' => $new_url,
                    ]);

                }
            }
            else
            {
                $usercart = getuserCart($user_id);

                // New Order
                $order = new Orders;
                $order->invoice_no = 0;
                $order->invoice_prefix = 'INV-2013-00';
                $order->store_id = $front_store_id;
                $order->store_name = isset($store->name) ? $store->name : '';
                $order->store_url = isset($store->url) ? $store->url : '';
                $order->customer_id = $user_id;
                $order->customer_group_id = isset($customer->customer_group_id) ? $customer->customer_group_id : 1;
                $order->firstname = isset($customer->firstname) ? $customer->firstname : '';
                $order->lastname = isset($customer->lastname) ? $customer->lastname : '';
                $order->email = isset($customer->email) ? $customer->email : '';
                $order->telephone = isset($customer->telephone) ? $customer->telephone : '';
                $order->fax = isset($customer->fax) ? $customer->fax : '';
                $order->payment_firstname = '';
                $order->payment_lastname = '';
                $order->payment_company = '';
                $order->payment_company_id = 0;
                $order->payment_tax_id = 0;
                $order->payment_address_1 = '';
                $order->payment_address_2 = '';
                $order->payment_city = '';
                $order->payment_postcode = '';
                $order->payment_country = 0;
                $order->payment_country_id = 0;
                $order->payment_zone = 0;
                $order->payment_zone_id = 0;
                $order->payment_address_format = '';
                $order->payment_method = 'Cash on Delivery';
                $order->payment_code = 'cod';
                $order->shipping_firstname = '';
                $order->shipping_lastname = '';
                $order->shipping_company = '';
                $order->shipping_address_1 = '';
                $order->shipping_address_2 = '';
                $order->shipping_city = '';
                $order->shipping_postcode = '';
                $order->shipping_country = 0;
                $order->shipping_country_id = 0;
                $order->shipping_zone = 0;
                $order->shipping_zone_id = 0;
                $order->shipping_address_format = '';
                $order->shipping_method = '';
                $order->shipping_code = '';
                $order->comment = '';
                $order->total = $total;
                $order->order_status_id = 5; //Complete
                $order->message = '';
                $order->accepted_time = '';
                $order->affiliate_id = 0;
                $order->commission = 0.00;
                $order->language_id = 1;
                $order->currency_id = 1;
                $order->currency_code = "GBP";
                $order->currency_value = "1.00000000";
                $order->ip = isset($customer->ip) ? $customer->ip : '';
                $order->forwarded_ip = '';
                $order->user_agent = '';
                $order->accept_language = '';
                $order->date_added = date('Y-m-d h:i:s');
                $order->date_modified = date('Y-m-d h:i:s');
                $order->flag_post_code = session()->get('flag_post_code');
                $order->free_item = '';
                $order->timedelivery = '';
                $order->gender_id = '';
                $order->clear_history = 0;
                $order->is_delete = 0;
                $order->save();

                $last_order_id = $order->order_id;


                // Order Product
                if(isset($usercart))
                {
                    if(isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0)
                    {
                        foreach($usercart['withoutSize'] as $key => $cart)
                        {
                            $order_product = new OrderProduct;
                            $order_product->order_id = $last_order_id;
                            $order_product->product_id = $cart['product_id'];
                            $order_product->name = $cart['name'];
                            $order_product->model = '';
                            $order_product->quantity = $cart['quantity'];
                            $order_product->price = $cart['price'];
                            $order_product->total = $cart['price'] *  $cart['quantity'];
                            $order_product->tax = 0.00;
                            $order_product->reward = 0;
                            $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                            $order_product->toppings = '';
                            $order_product->request = '';
                            $order_product->save();
                        }
                    }

                    if(isset($usercart['size']) && count($usercart['size']) > 0)
                    {
                        foreach($usercart['size'] as $key=> $cart)
                        {
                            $order_product = new OrderProduct;
                            $order_product->order_id = $last_order_id;
                            $order_product->product_id = $cart['product_id'];
                            $order_product->name = $cart['name'];
                            $order_product->model = '';
                            $order_product->quantity = $cart['quantity'];
                            $order_product->price = $cart['price'];
                            $order_product->total = $cart['price'] *  $cart['quantity'];
                            $order_product->tax = 0.00;
                            $order_product->reward = 0;
                            $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                            $order_product->toppings = '';
                            $order_product->request = '';
                            $order_product->save();
                        }
                    }
                }


                //Order to Cart
                $cart = isset($customer->cart) ? $customer->cart : '';

                $order_to_cart = new OrderCart;
                $order_to_cart->order_id = $last_order_id;
                $order_to_cart->session_order = $cart;
                $order_to_cart->save();

                $customer_update = Customer::find($user_id);
                $customer_update->cart = '';
                $customer_update->update();

                $new_url = $currentURL;

                return response()->json([
                    'success_cod' => 1,
                    'success_url' => $new_url,
                ]);

            }
        }

    }
}
