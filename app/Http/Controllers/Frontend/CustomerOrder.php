<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\OrderCart;
use App\Models\OrderHistory;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\OrderTotal;
use App\Models\Settings;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CustomerOrder extends Controller
{

    function checkorderstatus(Request $request)
    {
        if(session()->has('last_order_id'))
        {
            $order_id = session()->get('last_order_id');
        }
        else
        {
            $order_id = 0;
        }

        $order_dt = Orders::where('order_id',$order_id)->first();

        $status_id = isset($order_dt->order_status_id) ? $order_dt->order_status_id : '';

        if(!empty($status_id))
        {
            if($status_id == 15)
            {
                return response([
                    'success' => 1,
                ]);
            }

            if($status_id == 7)
            {
                return response([
                    'success' => 1,
                ]);
            }

            if($status_id == 11)
            {
                return response([
                    'success' => 1,
                ]);
            }

            if($status_id == 1)
            {
                return response([
                    'success' => 1,
                ]);
            }

            if($status_id == 5)
            {
                return response([
                    'success' => 1,
                ]);
            }
        }

    }

    function confirmorder(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $delivery_type = session()->get('flag_post_code');

        $total = $request->total;

        $subtotal = $request->subtotal;
        $delivery_charge = $request->delivery_charge;
        $couponcode = isset($request->couponcode) ? $request->couponcode : 0;
        $couponname = $request->couponname;


        // Store Details
        $store = Store::where('store_id', $front_store_id)->first();
        // End Store Details

        if (session()->has('userid')) {
            $user_id = session()->get('userid');
        } else {
            $user_id = 0;
        }

        // Customer Details
        if ($user_id != 0) {
            $customer = Customer::where('customer_id', $user_id)->first();

            $cust_address_id = isset($customer->address_id) ? $customer->address_id : '';

            $customer_def_address = CustomerAddress::where('address_id', $cust_address_id)->first();
        }
        // End Customer Details

        // Get Time Method
        if (session()->has('time_method')) {
            $time_method = session()->get('time_method');
        } else {
            $time_method = 'ASAP';
        }
        // End Time Method

        $payment_method = $request->p_method;

        // Check Delivery Type
        if ($delivery_type == 'collection')  // Collection
        {
            // Check Payment Method
            if ($payment_method == 3) //Cash On Delivery
            {
                // Check User Type
                if ($user_id == 0) //Guest User
                {
                    $guest_user = session()->get('guest_user');

                    if (!empty($guest_user)) {
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
                        $gorder->shipping_method = 'collection';
                        $gorder->shipping_code = '';
                        $gorder->comment = '';
                        $gorder->total = $total;
                        $gorder->order_status_id = 2; //Processing
                        $gorder->message = '';
                        $gorder->accepted_time = '';
                        $gorder->affiliate_id = 0;
                        $gorder->commission = 0.00;
                        $gorder->language_id = 1;
                        $gorder->currency_id = 1;
                        $gorder->currency_code = "GBP";
                        $gorder->currency_value = "1.00000000";
                        $gorder->ip = $request->ip();
                        $gorder->forwarded_ip = '';
                        $gorder->user_agent = '';
                        $gorder->accept_language = '';
                        $gorder->date_added = date('Y-m-d h:i:s');
                        $gorder->date_modified = date('Y-m-d h:i:s');
                        $gorder->flag_post_code = session()->get('flag_post_code');
                        $gorder->free_item = '';
                        $gorder->timedelivery = $time_method;
                        $gorder->gender_id = isset($guest_user['title']) ? $guest_user['title'] : 1;
                        $gorder->clear_history = 0;
                        $gorder->is_delete = 0;
                        $gorder->save();

                        session()->put('last_order_id',$gorder->order_id);

                        // Guest Order Product
                        if (isset($guestUserCart)) {
                            if (isset($guestUserCart['withoutSize']) && count($guestUserCart['withoutSize']) > 0) {
                                foreach ($guestUserCart['withoutSize'] as $key => $cart) {
                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $cart['main_price'];
                                    $gorder_product->total = $cart['main_price'] *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $gorder_product->toppings = '';
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }

                            if (isset($guestUserCart['size']) && count($guestUserCart['size']) > 0) {
                                foreach ($guestUserCart['size'] as $key => $cart) {
                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $cart['main_price'];
                                    $gorder_product->total = $cart['main_price'] *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $gorder_product->toppings = '';
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }
                        }


                        //Guest Order to Cart
                        $gcart = $guestUserCart;
                        $serial = serialize($gcart);
                        $base64 = base64_encode($serial);

                        $gorder_to_cart = new OrderCart;
                        $gorder_to_cart->order_id = $gorder->order_id;
                        $gorder_to_cart->session_order = $base64;
                        $gorder_to_cart->save();


                        // Guest Order History
                        $gorderhistory = new OrderHistory;
                        $gorderhistory->order_id = $gorder->order_id;
                        $gorderhistory->order_status_id = 2; //Processing
                        $gorderhistory->notify = 1;
                        $gorderhistory->comment = '';
                        $gorderhistory->date_added = date('Y-m-d h:i:s');
                        $gorderhistory->save();

                        // Order Delivery
                        $gorderdelivery = new OrderTotal;
                        $gorderdelivery->order_id = $gorder->order_id;
                        $gorderdelivery->code = 'delivery';
                        $gorderdelivery->title = 'Delivery';
                        $gorderdelivery->text = '£ 0.00';
                        $gorderdelivery->value = 0.00;
                        $gorderdelivery->sort_order = 0;
                        $gorderdelivery->save();

                        // Coupon Code
                        if ($couponcode != 0) {
                            $gordercoupon = new OrderTotal;
                            $gordercoupon->order_id = $gorder->order_id;
                            $gordercoupon->code = 'coupon';
                            $gordercoupon->title = 'Coupon(' . $couponname . ')';
                            $gordercoupon->text = '£ -' . $couponcode;
                            $gordercoupon->value = '-' . $couponcode;
                            $gordercoupon->sort_order = 0;
                            $gordercoupon->save();
                        }

                        // Subtotal
                        $gordersubtotal = new OrderTotal;
                        $gordersubtotal->order_id = $gorder->order_id;
                        $gordersubtotal->code = 'sub_total';
                        $gordersubtotal->title = 'Sub-Total';
                        $gordersubtotal->text = '£ ' . $subtotal;
                        $gordersubtotal->value = $subtotal;
                        $gordersubtotal->sort_order = 0;
                        $gordersubtotal->save();

                        // Total to Pay
                        $gordertotal = new OrderTotal;
                        $gordertotal->order_id = $gorder->order_id;
                        $gordertotal->code = 'total';
                        $gordertotal->title = 'Total to Pay';
                        $gordertotal->text = '£ ' . $total;
                        $gordertotal->value = $total;
                        $gordertotal->sort_order = 0;
                        $gordertotal->save();

                        session()->forget('cart1');
                        session()->forget('guest_user');

                        $new_url = $currentURL . '/success';

                        return response()->json([
                            'success' => 1,
                            'success_url' => $new_url,
                        ]);
                    }
                } else // Customer
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
                    $order->shipping_method = 'collection';
                    $order->shipping_code = '';
                    $order->comment = '';
                    $order->total = $total;
                    $order->order_status_id = 2; //Processing
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
                    $order->timedelivery = $time_method;
                    $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
                    $order->clear_history = 0;
                    $order->is_delete = 0;
                    $order->save();

                    $last_order_id = $order->order_id;

                    session()->put('last_order_id',$order->order_id);

                    // Order Product
                    if (isset($usercart)) {
                        if (isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0) {
                            foreach ($usercart['withoutSize'] as $key => $cart) {
                                $order_product = new OrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $cart['main_price'];
                                $order_product->total = $cart['main_price'] *  $cart['quantity'];
                                $order_product->tax = 0.00;
                                $order_product->reward = 0;
                                $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $order_product->toppings = '';
                                $order_product->request = '';
                                $order_product->save();
                            }
                        }

                        if (isset($usercart['size']) && count($usercart['size']) > 0) {
                            foreach ($usercart['size'] as $key => $cart) {
                                $order_product = new OrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $cart['main_price'];
                                $order_product->total = $cart['main_price'] *  $cart['quantity'];
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

                    // Order History
                    $orderhistory = new OrderHistory;
                    $orderhistory->order_id = $order->order_id;
                    $orderhistory->order_status_id = 2; //Processing
                    $orderhistory->notify = 1;
                    $orderhistory->comment = '';
                    $orderhistory->date_added = date('Y-m-d h:i:s');
                    $orderhistory->save();

                    // Order Delivery
                    $orderdelivery = new OrderTotal;
                    $orderdelivery->order_id = $order->order_id;
                    $orderdelivery->code = 'delivery';
                    $orderdelivery->title = 'Delivery';
                    $orderdelivery->text = '£ 0.00';
                    $orderdelivery->value = 0.00;
                    $orderdelivery->sort_order = 0;
                    $orderdelivery->save();

                    // Coupon Code
                    if ($couponcode != 0) {
                        $ordercoupon = new OrderTotal;
                        $ordercoupon->order_id = $order->order_id;
                        $ordercoupon->code = 'coupon';
                        $ordercoupon->title = 'Coupon(' . $couponname . ')';
                        $ordercoupon->text = '£ -' . $couponcode;
                        $ordercoupon->value = '-' . $couponcode;
                        $ordercoupon->sort_order = 0;
                        $ordercoupon->save();
                    }

                    // Subtotal
                    $ordersubtotal = new OrderTotal;
                    $ordersubtotal->order_id = $order->order_id;
                    $ordersubtotal->code = 'sub_total';
                    $ordersubtotal->title = 'Sub-Total';
                    $ordersubtotal->text = '£ ' . $subtotal;
                    $ordersubtotal->value = $subtotal;
                    $ordersubtotal->sort_order = 0;
                    $ordersubtotal->save();

                    // Total to Pay
                    $ordertotal = new OrderTotal;
                    $ordertotal->order_id = $order->order_id;
                    $ordertotal->code = 'total';
                    $ordertotal->title = 'Total to Pay';
                    $ordertotal->text = '£ ' . $total;
                    $ordertotal->value = $total;
                    $ordertotal->sort_order = 0;
                    $ordertotal->save();

                    $new_url = $currentURL . '/success';

                    return response()->json([
                        'success' => 1,
                        'success_url' => $new_url,
                    ]);
                }
            }
        }

        if ($delivery_type == 'delivery') // Delivery
        {
            // Check Payment Method
            if ($payment_method == 3) //Cash On Delivery
            {
                // Check User Type
                if ($user_id == 0) //Guest User
                {
                    $guest_user = session()->get('guest_user');
                    $guest_user_address = session()->get('guest_user_address');

                    if (!empty($guest_user)) {
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
                        $gorder->payment_firstname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                        $gorder->payment_lastname = isset($guest_user['lname']) ? $guest_user['lname'] : '';
                        $gorder->payment_company = '';
                        $gorder->payment_company_id = 0;
                        $gorder->payment_tax_id = 0;
                        $gorder->payment_address_1 = isset($guest_user_address['address_1']) ? $guest_user_address['address_1'] : '';
                        $gorder->payment_address_2 = isset($guest_user_address['address_2']) ? $guest_user_address['address_2'] : '';
                        $gorder->payment_city = isset($guest_user_address['city']) ? $guest_user_address['city'] : '';
                        $gorder->payment_postcode = isset($guest_user_address['postcode']) ? $guest_user_address['postcode'] : '';
                        $gorder->payment_country = 0;
                        $gorder->payment_country_id = 0;
                        $gorder->payment_zone = 0;
                        $gorder->payment_zone_id = 0;
                        $gorder->payment_address_format = '';
                        $gorder->payment_method = 'Cash on Delivery';
                        $gorder->payment_code = 'cod';
                        $gorder->shipping_firstname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                        $gorder->shipping_lastname = isset($guest_user['lname']) ? $guest_user['lname'] : '';
                        $gorder->shipping_company = '';
                        $gorder->shipping_address_1 = isset($guest_user_address['address_1']) ? $guest_user_address['address_1'] : '';
                        $gorder->shipping_address_2 = isset($guest_user_address['address_2']) ? $guest_user_address['address_2'] : '';
                        $gorder->shipping_city = isset($guest_user_address['city']) ? $guest_user_address['city'] : '';
                        $gorder->shipping_postcode = isset($guest_user_address['postcode']) ? $guest_user_address['postcode'] : '';
                        $gorder->shipping_country = 0;
                        $gorder->shipping_country_id = 0;
                        $gorder->shipping_zone = 0;
                        $gorder->shipping_zone_id = 0;
                        $gorder->shipping_address_format = '';
                        $gorder->shipping_method = 'delivery';
                        $gorder->shipping_code = '';
                        $gorder->comment = '';
                        $gorder->total = $total;
                        $gorder->order_status_id = 2; //Processing
                        $gorder->message = '';
                        $gorder->accepted_time = '';
                        $gorder->affiliate_id = 0;
                        $gorder->commission = 0.00;
                        $gorder->language_id = 1;
                        $gorder->currency_id = 1;
                        $gorder->currency_code = "GBP";
                        $gorder->currency_value = "1.00000000";
                        $gorder->ip = $request->ip();
                        $gorder->forwarded_ip = '';
                        $gorder->user_agent = '';
                        $gorder->accept_language = '';
                        $gorder->date_added = date('Y-m-d h:i:s');
                        $gorder->date_modified = date('Y-m-d h:i:s');
                        $gorder->flag_post_code = session()->get('flag_post_code');
                        $gorder->free_item = '';
                        $gorder->timedelivery = $time_method;
                        $gorder->gender_id = isset($guest_user['title']) ? $guest_user['title'] : 1;
                        $gorder->clear_history = 0;
                        $gorder->is_delete = 0;
                        $gorder->save();

                        session()->put('last_order_id',$gorder->order_id);

                        // Guest Order Product
                        if (isset($guestUserCart)) {
                            if (isset($guestUserCart['withoutSize']) && count($guestUserCart['withoutSize']) > 0) {
                                foreach ($guestUserCart['withoutSize'] as $key => $cart) {
                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $cart['main_price'];
                                    $gorder_product->total = $cart['main_price'] *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $gorder_product->toppings = '';
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }

                            if (isset($guestUserCart['size']) && count($guestUserCart['size']) > 0) {
                                foreach ($guestUserCart['size'] as $key => $cart) {
                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $cart['main_price'];
                                    $gorder_product->total = $cart['main_price'] *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $gorder_product->toppings = '';
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }
                        }

                        //Guest Order to Cart
                        $gcart = $guestUserCart;
                        $serial = serialize($gcart);
                        $base64 = base64_encode($serial);

                        $gorder_to_cart = new OrderCart;
                        $gorder_to_cart->order_id = $gorder->order_id;
                        $gorder_to_cart->session_order = $base64;
                        $gorder_to_cart->save();


                        // Guest Order History
                        $gorderhistory = new OrderHistory;
                        $gorderhistory->order_id = $gorder->order_id;
                        $gorderhistory->order_status_id = 2; //Processing
                        $gorderhistory->notify = 1;
                        $gorderhistory->comment = '';
                        $gorderhistory->date_added = date('Y-m-d h:i:s');
                        $gorderhistory->save();

                        // Order Delivery
                        $gorderdelivery = new OrderTotal;
                        $gorderdelivery->order_id = $gorder->order_id;
                        $gorderdelivery->code = 'delivery';
                        $gorderdelivery->title = 'Delivery';
                        $gorderdelivery->text = '£ ' . $delivery_charge;
                        $gorderdelivery->value = $delivery_charge;
                        $gorderdelivery->sort_order = 0;
                        $gorderdelivery->save();

                        // Coupon Code
                        if ($couponcode != 0) {
                            $gordercoupon = new OrderTotal;
                            $gordercoupon->order_id = $gorder->order_id;
                            $gordercoupon->code = 'coupon';
                            $gordercoupon->title = 'Coupon(' . $couponname . ')';
                            $gordercoupon->text = '£ -' . $couponcode;
                            $gordercoupon->value = '-' . $couponcode;
                            $gordercoupon->sort_order = 0;
                            $gordercoupon->save();
                        }

                        // Subtotal
                        $gordersubtotal = new OrderTotal;
                        $gordersubtotal->order_id = $gorder->order_id;
                        $gordersubtotal->code = 'sub_total';
                        $gordersubtotal->title = 'Sub-Total';
                        $gordersubtotal->text = '£ ' . $subtotal;
                        $gordersubtotal->value = $subtotal;
                        $gordersubtotal->sort_order = 0;
                        $gordersubtotal->save();

                        // Total to Pay
                        $gordertotal = new OrderTotal;
                        $gordertotal->order_id = $gorder->order_id;
                        $gordertotal->code = 'total';
                        $gordertotal->title = 'Total to Pay';
                        $gordertotal->text = '£ ' . $total;
                        $gordertotal->value = $total;
                        $gordertotal->sort_order = 0;
                        $gordertotal->save();

                        session()->forget('cart1');
                        session()->forget('guest_user');
                        session()->forget('guest_user_address');

                        $new_url = $currentURL . '/success';

                        return response()->json([
                            'success' => 1,
                            'success_url' => $new_url,
                        ]);
                    }
                } else //Customer
                {
                    $usercart = getuserCart($user_id);

                    if (!empty($usercart)) {
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
                        $order->payment_firstname = isset($customer->firstname) ? $customer->firstname : '';
                        $order->payment_lastname = isset($customer->lastname) ? $customer->lastname : '';
                        $order->payment_company = '';
                        $order->payment_company_id = 0;
                        $order->payment_tax_id = 0;
                        $order->payment_address_1 = isset($customer_def_address->address_1) ? $customer_def_address->address_1 : '';
                        $order->payment_address_2 = isset($customer_def_address->address_2) ? $customer_def_address->address_2 : '';
                        $order->payment_city = isset($customer_def_address->city) ? $customer_def_address->city : '';
                        $order->payment_postcode = isset($customer_def_address->postcode) ? $customer_def_address->postcode : '';
                        $order->payment_country = 0;
                        $order->payment_country_id = 0;
                        $order->payment_zone = 0;
                        $order->payment_zone_id = 0;
                        $order->payment_address_format = '';
                        $order->payment_method = 'Cash on Delivery';
                        $order->payment_code = 'cod';
                        $order->shipping_firstname = isset($customer->firstname) ? $customer->firstname : '';
                        $order->shipping_lastname = isset($customer->lastname) ? $customer->lastname : '';
                        $order->shipping_company = '';
                        $order->shipping_address_1 = isset($customer_def_address->address_1) ? $customer_def_address->address_1 : '';
                        $order->shipping_address_2 = isset($customer_def_address->address_2) ? $customer_def_address->address_2 : '';
                        $order->shipping_city = isset($customer_def_address->city) ? $customer_def_address->city : '';
                        $order->shipping_postcode = isset($customer_def_address->postcode) ? $customer_def_address->postcode : '';
                        $order->shipping_country = 0;
                        $order->shipping_country_id = 0;
                        $order->shipping_zone = 0;
                        $order->shipping_zone_id = 0;
                        $order->shipping_address_format = '';
                        $order->shipping_method = 'delivery';
                        $order->shipping_code = '';
                        $order->comment = '';
                        $order->total = $total;
                        $order->order_status_id = 2; //Processing
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
                        $order->timedelivery = $time_method;
                        $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
                        $order->clear_history = 0;
                        $order->is_delete = 0;
                        $order->save();

                        session()->put('last_order_id',$order->order_id);

                        // Order Product
                        if (isset($usercart)) {
                            if (isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0) {
                                foreach ($usercart['withoutSize'] as $key => $cart) {
                                    $order_product = new OrderProduct;
                                    $order_product->order_id = $order->order_id;
                                    $order_product->product_id = $cart['product_id'];
                                    $order_product->name = $cart['name'];
                                    $order_product->model = '';
                                    $order_product->quantity = $cart['quantity'];
                                    $order_product->price = $cart['main_price'];
                                    $order_product->total = $cart['main_price'] *  $cart['quantity'];
                                    $order_product->tax = 0.00;
                                    $order_product->reward = 0;
                                    $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $order_product->toppings = '';
                                    $order_product->request = '';
                                    $order_product->save();
                                }
                            }

                            if (isset($usercart['size']) && count($usercart['size']) > 0) {
                                foreach ($usercart['size'] as $key => $cart) {
                                    $order_product = new OrderProduct;
                                    $order_product->order_id = $order->order_id;
                                    $order_product->product_id = $cart['product_id'];
                                    $order_product->name = $cart['name'];
                                    $order_product->model = '';
                                    $order_product->quantity = $cart['quantity'];
                                    $order_product->price = $cart['main_price'];
                                    $order_product->total = $cart['main_price'] *  $cart['quantity'];
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
                        $order_to_cart->order_id = $order->order_id;
                        $order_to_cart->session_order = $cart;
                        $order_to_cart->save();

                        $customer_update = Customer::find($user_id);
                        $customer_update->cart = '';
                        $customer_update->update();

                        // Order History
                        $orderhistory = new OrderHistory;
                        $orderhistory->order_id = $order->order_id;
                        $orderhistory->order_status_id = 2; //Processing
                        $orderhistory->notify = 1;
                        $orderhistory->comment = '';
                        $orderhistory->date_added = date('Y-m-d h:i:s');
                        $orderhistory->save();

                        // Order Delivery
                        $orderdelivery = new OrderTotal;
                        $orderdelivery->order_id = $order->order_id;
                        $orderdelivery->code = 'delivery';
                        $orderdelivery->title = 'Delivery';
                        $orderdelivery->text = '£ ' . $delivery_charge;
                        $orderdelivery->value = $delivery_charge;
                        $orderdelivery->sort_order = 0;
                        $orderdelivery->save();

                        // Coupon Code
                        if ($couponcode != 0) {
                            $ordercoupon = new OrderTotal;
                            $ordercoupon->order_id = $order->order_id;
                            $ordercoupon->code = 'coupon';
                            $ordercoupon->title = 'Coupon(' . $couponname . ')';
                            $ordercoupon->text = '£ -' . $couponcode;
                            $ordercoupon->value = '-' . $couponcode;
                            $ordercoupon->sort_order = 0;
                            $ordercoupon->save();
                        }

                        // Subtotal
                        $ordersubtotal = new OrderTotal;
                        $ordersubtotal->order_id = $order->order_id;
                        $ordersubtotal->code = 'sub_total';
                        $ordersubtotal->title = 'Sub-Total';
                        $ordersubtotal->text = '£ ' . $subtotal;
                        $ordersubtotal->value = $subtotal;
                        $ordersubtotal->sort_order = 0;
                        $ordersubtotal->save();

                        // Total to Pay
                        $ordertotal = new OrderTotal;
                        $ordertotal->order_id = $order->order_id;
                        $ordertotal->code = 'total';
                        $ordertotal->title = 'Total to Pay';
                        $ordertotal->text = '£ ' . $total;
                        $ordertotal->value = $total;
                        $ordertotal->sort_order = 0;
                        $ordertotal->save();

                        $new_url = $currentURL . '/success';

                        return response()->json([
                            'success' => 1,
                            'success_url' => $new_url,
                        ]);
                    }
                }
            }
        }
    }

    public function customerdeliveryaddress(Request $request)
    {

        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];

        $delivery_type = session()->get('flag_post_code');

        if (session()->has('userid')) {
            $user_id = session()->get('userid');
        } else {
            $user_id = 0;
        }

        $address_1 = isset($request->address_1) ? $request->address_1 : '';
        $address_2 = isset($request->address_2) ? $request->address_2 : '';
        $city = $request->city;
        $postcode = isset($request->postcode) ? $request->postcode : '';
        $phone_no = isset($request->phone_no) ? $request->phone_no : '';
        $additional_directions = isset($request->additional_directions) ? $request->additional_directions : '';
        $area = $request->area;

        $time_method = $request->time_method;

        $address = $request->address;

        if (!empty($time_method)) {
            session()->put('time_method', $time_method);
        } else {
            session()->put('time_method', 'ASAP');
        }

        if ($request->has('city')) {
            $request->validate([
                'city' => 'required',
                'address_1' => 'required',
                'postcode' => 'required',
                'phone_no' => 'required',
            ]);
        } else {
            $request->validate([
                'address_1' => 'required',
                'postcode' => 'required',
                'phone_no' => 'required',
            ]);
        }

        if ($request->has('area')) {
            $request->validate([
                'area' => 'required',
                'address_1' => 'required',
                'postcode' => 'required',
                'phone_no' => 'required',
            ]);
        } else {
            $request->validate([
                'address_1' => 'required',
                'postcode' => 'required',
                'phone_no' => 'required',
            ]);
        }


        $zone_by_store = Settings::select('key', 'value')->where('store_id', $front_store_id)->where('key', 'available_zones')->first();
        $available_zones = isset($zone_by_store->value) ? $zone_by_store->value : '';

        if (empty($available_zones) || $available_zones == '') {
            return response()->json([
                'errors' => 1,
                'errors_message' => 'Sorry We Don\'t Deliver to Your Area.',
            ]);
        } else {
            $explode = explode(',', $available_zones);
            $old_postcode = str_replace(' ', '', $postcode);
            $check_code = in_array($old_postcode, $explode) ? 1 : 0;

            if ($check_code == 0) {
                return response()->json([
                    'errors' => 1,
                    'errors_message' => 'Sorry We Don\'t Deliver to Your Area.',
                ]);
            }
        }

        if ($user_id == 0) {
            $data['address_1'] = $address_1;
            $data['address_2'] = $address_2;
            $data['city'] = $city;
            $data['area'] = $area;
            $data['postcode'] = $postcode;
            $data['phone_no'] = $phone_no;
            $data['additional_directions'] = $additional_directions;
            session()->put('guest_user_address', $data);
        } else {
            if ($address == 0) {
                $customer_new_address = new CustomerAddress;
                $customer_new_address->customer_id = $user_id;
                $customer_new_address->firstname = '';
                $customer_new_address->lastname = '';
                $customer_new_address->company = '';
                $customer_new_address->company_id = '';
                $customer_new_address->tax_id = '';
                $customer_new_address->address_1 = $address_1;
                $customer_new_address->address_2 = $address_2;
                $customer_new_address->city = $city;
                $customer_new_address->postcode = $postcode;
                $customer_new_address->country_id = '';
                $customer_new_address->zone_id = '';
                $customer_new_address->phone = $phone_no;
                $customer_new_address->billing = 0;
                $customer_new_address->card_name = '';
                $customer_new_address->save();

                $customer_update = Customer::find($user_id);
                $customer_update->address_id = $customer_new_address->address_id;
                $customer_update->update();
            } else {
                $edit_customer_address = CustomerAddress::find($address);
                $edit_customer_address->address_1 = $address_1;
                $edit_customer_address->address_2 = $address_2;
                $edit_customer_address->city = $city;
                $edit_customer_address->postcode = $postcode;
                $edit_customer_address->phone = $phone_no;
                $edit_customer_address->update();

                $customer_update = Customer::find($user_id);
                $customer_update->address_id = $address;
                $customer_update->update();
            }
        }

        return response()->json([
            'success' => 1,
        ]);
    }
}
