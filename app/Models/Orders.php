<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatus;
use App\Models\Store;
use App\Models\CustomerGroupDescription;
use App\Models\Country;
use App\Models\Region;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class Orders extends Model
{
    protected $connection = 'mysql';
    protected $table = "oc_order";
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    // Has One Relation with "oc_order_status" table
    public function hasOneOrderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'order_status_id', 'order_status_id');
    }

    // Has One Relation with "oc_store" table
    public function hasOneStore()
    {
        return $this->hasOne(Store::class, 'store_id', 'store_id');
    }

    // Has One Relation with "oc_customer_group_description" table
    public function hasOneCustomerGroupDescription()
    {
        return $this->hasOne(CustomerGroupDescription::class, 'customer_group_id', 'customer_group_id');
    }

    // Has One Relation with "oc_country" table
    public function hasOneCountry()
    {
        return $this->hasOne(Country::class, 'country_id', 'payment_country_id');
    }

    // Has One Relation with "oc_zone" table
    public function hasOneRegion()
    {
        return $this->hasOne(Region::class, 'zone_id', 'payment_zone_id');
    }

    // Has Many Relation with "oc_order_product" table
    public function hasManyOrderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'order_id');
    }

    // Has Many Relation with "oc_order_total" table
    public function hasManyOrderTotal()
    {
        return $this->hasMany(OrderTotal::class, 'order_id', 'order_id');
    }

    // Has One Relation with "oc_currency" table
    public function hasOneCurrency()
    {
        return $this->hasOne(Currency::class, 'currency_id', 'currency_id');
    }

    // paypal order
    public static function paypalstoreOrder(Request $request)
    {

        $currentURL = URL::to("/");
        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);
        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];
        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';


        // Free Item
        $f_item = $request->free_item;
        if (!empty($f_item) || $f_item != '') 
        {
            $free_item = $f_item;
        } 
        else 
        {
            if (session()->has('free_item')) 
            {
                $free_item = session()->get('free_item');
            } 
            else 
            {
                $free_item = '';
            }
        }


        // Get Coupon Name
        if(session()->has('couponname'))
        {
            $couponname = session()->get('couponname');
        }
        else
        {
            $couponname = "";
        }


        // Get Coupon Amont
        if(session()->has('couponcode'))
        {
            $couponcode = session()->get('couponcode');
        }
        else
        {
            $couponcode = 0.00;
        }

        // Current Applied Coupon
        $currentcoupon = session()->get('currentcoupon');
        $code =isset($currentcoupon['code']) ? $currentcoupon['code'] : $couponname ;
        if(!empty($code))
        {
            $cpn_dt = Coupon::where('code',$code)->where('store_id',$front_store_id)->first();
        }
        else
        {
            $cpn_dt = '';
        }

        // Get Currency Details
        $currency_code = $store_setting['config_currency'];
        $currency_details = Currency::where('code', $currency_code)->first();
        

        // Get Service Charge
        $servicecharge = isset($request->service_charge) ? $request->service_charge : 0.00;


        // Get SubTotal From Session
        if(session()->has('subtotal'))
        {
            $subtotal =  session()->get('subtotal');
        }
        else
        {
            $subtotal = 0.00;
        }


        // Get Total From Session
        if(session()->has('total'))
        {
            $total =  session()->get('total');
        }
        else
        {
            $total = 0.00;
        }
        $total = $total + $servicecharge;


        // Delivery Type
        $delivery_type = session()->get('flag_post_code');
        

        // Store Details
        $store = Store::where('store_id', $front_store_id)->first();
        $data['store_mail'] = getStoreDetails($front_store_id, 'config_email');
        $data['store_name'] = getStoreDetails($front_store_id, 'config_name');
        // End Store Details


        // Check Is User or Guest
        if (session()->has('userid')) 
        {
            $user_id = session()->get('userid');
        } 
        else 
        {
            $user_id = 0;
        }


        // Get Delivery Charge
        if (session()->has('delivery_charge')) 
        {
            $delivery_charge = session()->get('delivery_charge');
        } 
        else 
        {
            $delivery_charge = 0.00;
        }


        // Customer Details
        if ($user_id != 0) 
        {
            $customer = Customer::where('customer_id', $user_id)->first();
            $cust_address_id = isset($customer->address_id) ? $customer->address_id : '';
            $customer_def_address = CustomerAddress::where('address_id', $cust_address_id)->first();

            // Get customer Country
            $cust_country_id = isset($customer_def_address->country_id) ? $customer_def_address->country_id : '';
            $country = Country::select('name')->where('country_id',$cust_country_id)->first();
            $cust_country_name = isset($country->name) ? $country->name : '';

            // Get customer Zone
            $cust_zone_id = isset($customer_def_address->zone_id) ? $customer_def_address->zone_id : '';
            $zone = Region::select('name')->where('zone_id',$cust_zone_id)->first();
            $cust_zone_name = isset($zone->name) ? $zone->name : '';

        }
        // End Customer Details


        // Get Time Method
        if (session()->has('time_method')) 
        {
            $time_method = session()->get('time_method');
        } 
        else 
        {
            $time_method = '';
        }
        // End Time Method


        // This Payment Method
        $payment_method = 2;


        // Check Delivery Type
        if ($delivery_type == 'collection')
        {
            // Check Payment Method
            if ($payment_method == 2) //Pay Online On Collection
            {
                // Check User Type
                if ($user_id == 0) //Guest User
                {
                    $guest_user = session()->get('guest_user');

                    if (!empty($guest_user)) 
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
                        $gorder->fax = '';
                        $gorder->payment_firstname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                        $gorder->payment_lastname = isset($guest_user['lname']) ? $guest_user['lname'] : '';
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
                        $gorder->payment_method = 'Pay Online';
                        $gorder->payment_code = 'pp_express';
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
                        $gorder->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $gorder->message = '';
                        $gorder->accepted_time = '';
                        $gorder->affiliate_id = 0;
                        $gorder->commission = 0.00;
                        $gorder->language_id = 1;
                        $gorder->currency_id = $currency_details['currency_id'];
                        $gorder->currency_code = $currency_details['code'];
                        $gorder->currency_value = $currency_details['value'];
                        $gorder->ip = $_SERVER['REMOTE_ADDR'];
                        $gorder->forwarded_ip = '';
                        $gorder->user_agent = '';
                        $gorder->accept_language = '';
                        $gorder->date_added = date('Y-m-d h:i:s');
                        $gorder->date_modified = date('Y-m-d h:i:s');
                        $gorder->flag_post_code = session()->get('flag_post_code');
                        $gorder->free_item = $free_item;
                        $gorder->timedelivery = $time_method;
                        $gorder->gender_id = isset($guest_user['title']) ? $guest_user['title'] : 1;
                        $gorder->clear_history = 0;
                        $gorder->is_delete = 0;
                        $gorder->save();

                        // Last Inserted Order Id
                        $last_order_id = $gorder->order_id;

                        // Coupon Info
                        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


                        // Add Coupon History
                        if(!empty($cpn_id) && $cpn_id != 0)
                        {
                            $coupon_history = new CouponHistory;
                            $coupon_history->coupon_id = $cpn_id;
                            $coupon_history->order_id = $last_order_id;
                            $coupon_history->customer_id = 0;
                            $coupon_history->amount = "-$cpn_discount";
                            $coupon_history->date_added = date('Y-m-d  H:i:s');
                            $coupon_history->save();
                        }


                        session()->put('last_order_id', $gorder->order_id);

                        // Guest Order Product
                        if (isset($guestUserCart)) 
                        {
                            if (isset($guestUserCart['withoutSize']) && count($guestUserCart['withoutSize']) > 0) 
                            {
                                foreach ($guestUserCart['withoutSize'] as $key => $cart) 
                                {
                                    $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $col_price;
                                    $gorder_product->total = $col_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }

                            if (isset($guestUserCart['size']) && count($guestUserCart['size']) > 0) 
                            {
                                foreach ($guestUserCart['size'] as $key => $cart) 
                                {
                                    $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $col_price;
                                    $gorder_product->total = $col_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
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
                        $gorderhistory->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $gorderhistory->notify = 1;
                        $gorderhistory->comment = '';
                        $gorderhistory->date_added = date('Y-m-d h:i:s');
                        $gorderhistory->save();

                        // Coupon Code
                        if (isset($cpn_dt['code']) && $cpn_dt['code'] != 0) 
                        {
                            $gordercoupon = new OrderTotal;
                            $gordercoupon->order_id = $gorder->order_id;
                            $gordercoupon->code = 'coupon';
                            $gordercoupon->title = 'Coupon(' . $couponname . ')';
                            $gordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                            $gordercoupon->value = '-' . $couponcode;
                            $gordercoupon->sort_order = 0;
                            $gordercoupon->save();
                        }

                        // Subtotal
                        $gordersubtotal = new OrderTotal;
                        $gordersubtotal->order_id = $gorder->order_id;
                        $gordersubtotal->code = 'sub_total';
                        $gordersubtotal->title = 'Sub-Total';
                        $gordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                        $gordersubtotal->value = $subtotal;
                        $gordersubtotal->sort_order = 0;
                        $gordersubtotal->save();


                        // service charge
                        if ($servicecharge != "") 
                        {
                            $gordertotal = new OrderTotal;
                            $gordertotal->order_id = $gorder->order_id;
                            $gordertotal->code = 'credit';
                            $gordertotal->title = 'Service Charge';
                            $gordertotal->text = $currency_details['symbol_left'] . $servicecharge;
                            $gordertotal->value = $servicecharge;
                            $gordertotal->sort_order = 0;
                            $gordertotal->save();
                        }

                        // Total to Pay
                        $gordertotal = new OrderTotal;
                        $gordertotal->order_id = $gorder->order_id;
                        $gordertotal->code = 'total';
                        $gordertotal->title = 'Total to Pay';
                        $gordertotal->text = $currency_details['symbol_left'] . $total;
                        $gordertotal->value = $total;
                        $gordertotal->sort_order = 0;
                        $gordertotal->save();


                        // Guest Name
                        $fname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                        $lname = isset($guest_user['lname']) ? $guest_user['lname'] : '';
                        $full_name = "$fname $lname";


                        // Order Details Array
                        $orderserialize = $gorder->toArray();

                        // Insert Guest Customer Order
                        $guest_customer_order = new CustomerOrder;
                        $guest_customer_order->store_id = $front_store_id;
                        $guest_customer_order->order_id = $last_order_id;
                        $guest_customer_order->customer_name = $full_name;
                        $guest_customer_order->billing_address = "";
                        $guest_customer_order->delivery_address = "";
                        $guest_customer_order->order_status = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $guest_customer_order->order_type = "collection";
                        $guest_customer_order->order_amount = $total;
                        $guest_customer_order->commission_fee = "";
                        $guest_customer_order->balance = "";
                        $guest_customer_order->refunded_amount = null;
                        $guest_customer_order->value = serialize($orderserialize);
                        $guest_customer_order->is_order = "";
                        $guest_customer_order->is_full_refund = 0;
                        $guest_customer_order->old_order_amount = null;
                        $guest_customer_order->order_date = date('Y-m-d h:i:s');
                        $guest_customer_order->date_added = date('Y-m-d h:i:s');
                        $guest_customer_order->refunded_date = null;
                        $guest_customer_order->save();

                        session()->forget('couponcode');
                        session()->forget('couponname');
                        session()->forget('guest_user');
                        session()->forget('guest_user_address');
                        session()->forget('currentcoupon');
                        session()->forget('cart1');
                        session()->forget('free_item');
                        session()->forget('headertotal');
                        session()->forget('total');
                        session()->forget('subtotal');
                        session()->forget('delivery_charge');
                        session()->forget('product_id'); 
                    }
                } 
                else // Customer
                {
                    // $usercart = getuserCart($user_id);
                    $usercart = session()->get('cart1'); // Session

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
                    $order->payment_address_1 = '';
                    $order->payment_address_2 = '';
                    $order->payment_city = '';
                    $order->payment_postcode = '';
                    $order->payment_country = isset($cust_country_name) ? $cust_country_name : '';
                    $order->payment_country_id = 0;
                    $order->payment_zone = isset($cust_zone_name) ? $cust_zone_name : '';
                    $order->payment_zone_id = 0;
                    $order->payment_address_format = '';
                    $order->payment_method = 'Pay Online';
                    $order->payment_code = 'pp_express';
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
                    $order->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                    $order->message = '';
                    $order->accepted_time = '';
                    $order->affiliate_id = 0;
                    $order->commission = 0.00;
                    $order->language_id = 1;
                    $order->currency_id = $currency_details['currency_id'];
                    $order->currency_code = $currency_details['code'];
                    $order->currency_value = $currency_details['value'];
                    $order->ip = isset($customer->ip) ? $customer->ip : '';
                    $order->forwarded_ip = '';
                    $order->user_agent = '';
                    $order->accept_language = '';
                    $order->date_added = date('Y-m-d h:i:s');
                    $order->date_modified = date('Y-m-d h:i:s');
                    $order->flag_post_code = session()->get('flag_post_code');
                    $order->free_item = $free_item;
                    $order->timedelivery = $time_method;
                    $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
                    $order->clear_history = 0;
                    $order->is_delete = 0;
                    $order->save();

                    // Last Inserted Order ID
                    $last_order_id = $order->order_id;

                    // Coupon Info
                    $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                    $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                    $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';

                    // Create Coupon History
                    if(!empty($cpn_id) && $cpn_id != 0)
                    {
                        $coupon_history = new CouponHistory;
                        $coupon_history->coupon_id = $cpn_id;
                        $coupon_history->order_id = $last_order_id;
                        $coupon_history->customer_id = 0;
                        $coupon_history->amount = "-$cpn_discount";
                        $coupon_history->date_added = date('Y-m-d  H:i:s');
                        $coupon_history->save();
                    }

                    session()->put('last_order_id', $order->order_id);

                    // Order Product
                    if (isset($usercart)) 
                    {
                        if (isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0) 
                        {
                            foreach ($usercart['withoutSize'] as $key => $cart) 
                            {
                                $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                // Order Product without size
                                $order_product = new OrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $col_price;
                                $order_product->total = $col_price *  $cart['quantity'];
                                $order_product->tax = 0.00;
                                $order_product->reward = 0;
                                $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $toppings = [];
                                if (isset($cart['topping']) && !empty($cart['topping'])) 
                                {
                                    foreach ($cart['topping'] as $topping) {
                                        $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                    }
                                    $order_product->toppings = implode('', $toppings);
                                } 
                                else 
                                {
                                    $order_product->toppings = '';
                                }
                                $order_product->request = '';
                                $order_product->save();

                                // payment db, Customer Order Product without size
                                $order_product = new CustomerOrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $col_price;
                                $order_product->total = $col_price *  $cart['quantity'];
                                $order_product->tax = 0.00;
                                $order_product->reward = 0;
                                $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $toppings = [];
                                if (isset($cart['topping']) && !empty($cart['topping'])) 
                                {
                                    foreach ($cart['topping'] as $topping) 
                                    {
                                        $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                    }
                                    $order_product->toppings = implode('', $toppings);
                                } 
                                else 
                                {
                                    $order_product->toppings = '';
                                }
                                $order_product->request = '';
                                $order_product->save();
                            }
                        }

                        if (isset($usercart['size']) && count($usercart['size']) > 0) 
                        {
                            foreach ($usercart['size'] as $key => $cart) 
                            {
                                $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                // Order Product without size
                                $order_product = new OrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $col_price;
                                $order_product->total = $col_price *  $cart['quantity'];
                                $order_product->tax = 0.00;
                                $order_product->reward = 0;
                                $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $toppings = [];
                                if (isset($cart['topping']) && !empty($cart['topping'])) 
                                {
                                    foreach ($cart['topping'] as $topping) 
                                    {
                                        $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                    }
                                    $order_product->toppings = implode('', $toppings);
                                } 
                                else 
                                {
                                    $order_product->toppings = '';
                                }
                                $order_product->request = '';
                                $order_product->save();

                                // paymant db, Customer Order product with size
                                $payment_order_product = new CustomerOrderProduct;
                                $payment_order_product->order_id = $last_order_id;
                                $payment_order_product->product_id = $cart['product_id'];
                                $payment_order_product->name = $cart['name'];
                                $payment_order_product->model = '';
                                $payment_order_product->quantity = $cart['quantity'];
                                $payment_order_product->price = $col_price;
                                $payment_order_product->total = $col_price *  $cart['quantity'];
                                $payment_order_product->tax = 0.00;
                                $payment_order_product->reward = 0;
                                $payment_order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $toppings = [];
                                if (isset($cart['topping']) && !empty($cart['topping'])) 
                                {
                                    foreach ($cart['topping'] as $topping) 
                                    {
                                        $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                    }
                                    $payment_order_product->toppings = implode('', $toppings);
                                }
                                else 
                                {
                                    $payment_order_product->toppings = '';
                                }
                                $payment_order_product->request = '';
                                $payment_order_product->save();
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
                    $orderhistory->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                    $orderhistory->notify = 1;
                    $orderhistory->comment = '';
                    $orderhistory->date_added = date('Y-m-d h:i:s');
                    $orderhistory->save();

                    // Coupon Code
                    if (isset($cpn_dt['code']) && $cpn_dt['code'] != 0) 
                    {
                        $ordercoupon = new OrderTotal;
                        $ordercoupon->order_id = $order->order_id;
                        $ordercoupon->code = 'coupon';
                        $ordercoupon->title = 'Coupon(' . $couponname . ')';
                        $ordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                        $ordercoupon->value = '-' . $couponcode;
                        $ordercoupon->sort_order = 0;
                        $ordercoupon->save();
                    }

                    // Subtotal
                    $ordersubtotal = new OrderTotal;
                    $ordersubtotal->order_id = $order->order_id;
                    $ordersubtotal->code = 'sub_total';
                    $ordersubtotal->title = 'Sub-Total';
                    $ordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                    $ordersubtotal->value = $subtotal;
                    $ordersubtotal->sort_order = 0;
                    $ordersubtotal->save();

                    // service charge
                    if ($servicecharge != "") 
                    {
                        $orderservicecharge = new OrderTotal;
                        $orderservicecharge->order_id = $order->order_id;
                        $orderservicecharge->code = 'credit';
                        $orderservicecharge->title = 'Service Charge';
                        $orderservicecharge->text = $currency_details['symbol_left'] . $servicecharge;
                        $orderservicecharge->value = $servicecharge;
                        $orderservicecharge->sort_order = 0;
                        $orderservicecharge->save();
                    }

                    // Total to Pay
                    $ordertotal = new OrderTotal;
                    $ordertotal->order_id = $order->order_id;
                    $ordertotal->code = 'total';
                    $ordertotal->title = 'Total to Pay';
                    $ordertotal->text = $currency_details['symbol_left'] . $total;
                    $ordertotal->value = $total;
                    $ordertotal->sort_order = 0;
                    $ordertotal->save();

                    // Order Details Array
                    $orderserialize = $order->toArray();

                    $cfname = isset($customer->firstname) ? $customer->firstname : '';
                    $clname = isset($customer->lastname) ? $customer->lastname : '';
                    $cfullname = $cfname . ' ' . $clname;

                    $customer_order = new CustomerOrder;
                    $customer_order->store_id = $front_store_id;
                    $customer_order->order_id = $last_order_id;
                    $customer_order->customer_name = $cfullname;
                    $customer_order->billing_address = "";
                    $customer_order->delivery_address = "";
                    $customer_order->order_status = 7; //Rejected. paypal success trnnsaction after order prossesing.
                    $customer_order->order_type = "collection";
                    $customer_order->order_amount = $total;
                    $customer_order->commission_fee = "";
                    $customer_order->balance = "";
                    $customer_order->refunded_amount = null;
                    $customer_order->value = serialize($orderserialize);
                    $customer_order->is_order = "";
                    $customer_order->is_full_refund = 0;
                    $customer_order->old_order_amount = null;
                    $customer_order->order_date = date('Y-m-d h:i:s');
                    $customer_order->date_added = date('Y-m-d h:i:s');
                    $customer_order->refunded_date = null;
                    $customer_order->save();

                    session()->forget('couponcode');
                    session()->forget('couponname');
                    session()->forget('currentcoupon');
                    session()->forget('cart1');
                    session()->forget('free_item');
                    session()->forget('headertotal');
                    session()->forget('total');
                    session()->forget('subtotal');
                    session()->forget('delivery_charge');
                    session()->forget('product_id');                    
                }
            }
        }

        if ($delivery_type == 'delivery') // Delivery
        {
            // Check Payment Method
            if ($payment_method == 2) //Pay Online Delivery
            {
                // Check User Type
                if ($user_id == 0) //Guest User
                {
                    $guest_user = session()->get('guest_user');
                    $guest_user_address = session()->get('guest_user_address');

                    if (!empty($guest_user)) 
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
                        $gorder->fax = '';
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
                        $gorder->payment_method = 'Pay Online';
                        $gorder->payment_code = 'pp_express';
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
                        $gorder->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $gorder->message = '';
                        $gorder->accepted_time = '';
                        $gorder->affiliate_id = 0;
                        $gorder->commission = 0.00;
                        $gorder->language_id = 1;
                        $gorder->currency_id = $currency_details['currency_id'];
                        $gorder->currency_code = $currency_details['code'];
                        $gorder->currency_value = $currency_details['value'];
                        $gorder->ip = $_SERVER['REMOTE_ADDR'];
                        $gorder->forwarded_ip = '';
                        $gorder->user_agent = '';
                        $gorder->accept_language = '';
                        $gorder->date_added = date('Y-m-d h:i:s');
                        $gorder->date_modified = date('Y-m-d h:i:s');
                        $gorder->flag_post_code = session()->get('flag_post_code');
                        $gorder->free_item = $free_item;
                        $gorder->timedelivery = $time_method;
                        $gorder->gender_id = isset($guest_user['title']) ? $guest_user['title'] : 1;
                        $gorder->clear_history = 0;
                        $gorder->is_delete = 0;
                        $gorder->save();

                        // Last Inserted Order ID
                        $last_order_id = $gorder->order_id;

                        // Coupon Info
                        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


                        // Insert Coupon History
                        if(!empty($cpn_id) && $cpn_id != 0)
                        {
                            $coupon_history = new CouponHistory;
                            $coupon_history->coupon_id = $cpn_id;
                            $coupon_history->order_id = $last_order_id;
                            $coupon_history->customer_id = 0;
                            $coupon_history->amount = "-$cpn_discount";
                            $coupon_history->date_added = date('Y-m-d  H:i:s');
                            $coupon_history->save();
                        }

                        session()->put('last_order_id', $gorder->order_id);

                        // Guest Order Product
                        if (isset($guestUserCart)) {
                            if (isset($guestUserCart['withoutSize']) && count($guestUserCart['withoutSize']) > 0) {
                                foreach ($guestUserCart['withoutSize'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    // Order Product without size
                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $del_price;
                                    $gorder_product->total = $del_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
                                    $gorder_product->request = '';
                                    $gorder_product->save();

                                    // payment db, Customer Order Product without size
                                    $payment_gorder_product = new CustomerOrderProduct;
                                    $payment_gorder_product->order_id = $gorder->order_id;
                                    $payment_gorder_product->product_id = $cart['product_id'];
                                    $payment_gorder_product->name = $cart['name'];
                                    $payment_gorder_product->model = '';
                                    $payment_gorder_product->quantity = $cart['quantity'];
                                    $payment_gorder_product->price = $del_price;
                                    $payment_gorder_product->total = $del_price *  $cart['quantity'];
                                    $payment_gorder_product->tax = 0.00;
                                    $payment_gorder_product->reward = 0;
                                    $payment_gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $payment_gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $payment_gorder_product->toppings = '';
                                    }
                                    $payment_gorder_product->request = '';
                                    $payment_gorder_product->save();
                                }
                            }

                            if (isset($guestUserCart['size']) && count($guestUserCart['size']) > 0) {
                                foreach ($guestUserCart['size'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    // Order Product with size
                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $del_price;
                                    $gorder_product->total = $del_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
                                    $gorder_product->request = '';
                                    $gorder_product->save();

                                    // payment db, Customer Order Product with size
                                    $payment_gorder_product = new CustomerOrderProduct;
                                    $payment_gorder_product->order_id = $gorder->order_id;
                                    $payment_gorder_product->product_id = $cart['product_id'];
                                    $payment_gorder_product->name = $cart['name'];
                                    $payment_gorder_product->model = '';
                                    $payment_gorder_product->quantity = $cart['quantity'];
                                    $payment_gorder_product->price = $del_price;
                                    $payment_gorder_product->total = $del_price *  $cart['quantity'];
                                    $payment_gorder_product->tax = 0.00;
                                    $payment_gorder_product->reward = 0;
                                    $payment_gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $payment_gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $payment_gorder_product->toppings = '';
                                    }
                                    $payment_gorder_product->request = '';
                                    $payment_gorder_product->save();
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
                        $gorderhistory->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $gorderhistory->notify = 1;
                        $gorderhistory->comment = '';
                        $gorderhistory->date_added = date('Y-m-d h:i:s');
                        $gorderhistory->save();

                        // Order Delivery
                        $gorderdelivery = new OrderTotal;
                        $gorderdelivery->order_id = $gorder->order_id;
                        $gorderdelivery->code = 'delivery';
                        $gorderdelivery->title = 'Delivery';
                        $gorderdelivery->text = $currency_details['symbol_left'] . $delivery_charge;
                        $gorderdelivery->value = $delivery_charge;
                        $gorderdelivery->sort_order = 0;
                        $gorderdelivery->save();

                        // Coupon Code
                        if (isset($cpn_dt['code']) && $cpn_dt['code'] != 0) 
                        {
                            $gordercoupon = new OrderTotal;
                            $gordercoupon->order_id = $gorder->order_id;
                            $gordercoupon->code = 'coupon';
                            $gordercoupon->title = 'Coupon(' . $couponname . ')';
                            $gordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                            $gordercoupon->value = '-' . $couponcode;
                            $gordercoupon->sort_order = 0;
                            $gordercoupon->save();
                        }

                        // Subtotal
                        $gordersubtotal = new OrderTotal;
                        $gordersubtotal->order_id = $gorder->order_id;
                        $gordersubtotal->code = 'sub_total';
                        $gordersubtotal->title = 'Sub-Total';
                        $gordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                        $gordersubtotal->value = $subtotal;
                        $gordersubtotal->sort_order = 0;
                        $gordersubtotal->save();

                        // service charge
                        if ($servicecharge != "") 
                        {
                            $gordertotal = new OrderTotal;
                            $gordertotal->order_id = $gorder->order_id;
                            $gordertotal->code = 'credit';
                            $gordertotal->title = 'Service Charge';
                            $gordertotal->text = $currency_details['symbol_left'] . $servicecharge;
                            $gordertotal->value = $servicecharge;
                            $gordertotal->sort_order = 0;
                            $gordertotal->save();
                        }

                        // Total to Pay
                        $gordertotal = new OrderTotal;
                        $gordertotal->order_id = $gorder->order_id;
                        $gordertotal->code = 'total';
                        $gordertotal->title = 'Total to Pay';
                        $gordertotal->text = $currency_details['symbol_left'] . $total;
                        $gordertotal->value = $total;
                        $gordertotal->sort_order = 0;
                        $gordertotal->save();

                        // Guest Name
                        $fname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                        $lname = isset($guest_user['lname']) ? $guest_user['lname'] : '';
                        $full_name = "$fname $lname";


                        // Order Details Array
                        $orderserialize = $gorder->toArray();

                        // Insert Guest Customer Order
                        $guest_customer_order = new CustomerOrder;
                        $guest_customer_order->store_id = $front_store_id;
                        $guest_customer_order->order_id = $last_order_id;
                        $guest_customer_order->customer_name = $full_name;
                        $guest_customer_order->billing_address = "";
                        $guest_customer_order->delivery_address = "";
                        $guest_customer_order->order_status = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $guest_customer_order->order_type = "collection";
                        $guest_customer_order->order_amount = $total;
                        $guest_customer_order->commission_fee = "";
                        $guest_customer_order->balance = "";
                        $guest_customer_order->refunded_amount = null;
                        $guest_customer_order->value = serialize($orderserialize);
                        $guest_customer_order->is_order = "";
                        $guest_customer_order->is_full_refund = 0;
                        $guest_customer_order->old_order_amount = null;
                        $guest_customer_order->order_date = date('Y-m-d h:i:s');
                        $guest_customer_order->date_added = date('Y-m-d h:i:s');
                        $guest_customer_order->refunded_date = null;
                        $guest_customer_order->save();

                        session()->forget('couponname');
                        session()->forget('couponcode');
                        session()->forget('currentcoupon');
                        session()->forget('cart1');
                        session()->forget('total');
                        session()->forget('subtotal');
                        session()->forget('headertotal');
                        session()->forget('free_item');
                        session()->forget('guest_user');
                        session()->forget('guest_user_address');
                        session()->forget('product_id');
                        session()->forget('delivery_charge');
                    }
                } 
                else //Customer
                {
                    // $usercart = getuserCart($user_id);
                    $usercart = session()->get('cart1');;

                    if (!empty($usercart)) 
                    {
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
                        $order->payment_company = isset($customer_def_address->company) ? $customer_def_address->company : '';
                        $order->payment_company_id = isset($customer_def_address->company_id) ? $customer_def_address->company_id : '';
                        $order->payment_tax_id = 0;
                        $order->payment_address_1 = isset($customer_def_address->address_1) ? $customer_def_address->address_1 : '';
                        $order->payment_address_2 = isset($customer_def_address->address_2) ? $customer_def_address->address_2 : '';
                        $order->payment_city = isset($customer_def_address->city) ? $customer_def_address->city : '';
                        $order->payment_postcode = isset($customer_def_address->postcode) ? $customer_def_address->postcode : '';
                        $order->payment_country = isset($cust_country_name) ? $cust_country_name : '';;
                        $order->payment_country_id = isset($customer_def_address->country_id) ? $customer_def_address->country_id : '';
                        $order->payment_zone = isset($cust_zone_name) ? $cust_zone_name : '';;
                        $order->payment_zone_id = isset($customer_def_address->zone_id) ? $customer_def_address->zone_id : '';
                        $order->payment_address_format = '';
                        $order->payment_method = 'Pay Online';
                        $order->payment_code = 'pp_express';
                        $order->shipping_firstname = isset($customer->firstname) ? $customer->firstname : '';
                        $order->shipping_lastname = isset($customer->lastname) ? $customer->lastname : '';
                        $order->shipping_company = isset($customer_def_address->company) ? $customer_def_address->company : '';
                        $order->shipping_address_1 = isset($customer_def_address->address_1) ? $customer_def_address->address_1 : '';
                        $order->shipping_address_2 = isset($customer_def_address->address_2) ? $customer_def_address->address_2 : '';
                        $order->shipping_city = isset($customer_def_address->city) ? $customer_def_address->city : '';
                        $order->shipping_postcode = isset($customer_def_address->postcode) ? $customer_def_address->postcode : '';
                        $order->shipping_country = isset($cust_country_name) ? $cust_country_name : '';;
                        $order->shipping_country_id = isset($customer_def_address->country_id) ? $customer_def_address->country_id : '';
                        $order->shipping_zone = isset($cust_zone_name) ? $cust_zone_name : '';
                        $order->shipping_zone_id = isset($customer_def_address->zone_id) ? $customer_def_address->zone_id : '';
                        $order->shipping_address_format = '';
                        $order->shipping_method = 'delivery';
                        $order->shipping_code = '';
                        $order->comment = '';
                        $order->total = $total;
                        $order->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $order->message = '';
                        $order->accepted_time = '';
                        $order->affiliate_id = 0;
                        $order->commission = 0.00;
                        $order->language_id = 1;
                        $order->currency_id = $currency_details['currency_id'];
                        $order->currency_code = $currency_details['code'];
                        $order->currency_value = $currency_details['value'];
                        $order->ip = isset($customer->ip) ? $customer->ip : '';
                        $order->forwarded_ip = '';
                        $order->user_agent = '';
                        $order->accept_language = '';
                        $order->date_added = date('Y-m-d h:i:s');
                        $order->date_modified = date('Y-m-d h:i:s');
                        $order->flag_post_code = session()->get('flag_post_code');
                        $order->free_item = $free_item;
                        $order->timedelivery = $time_method;
                        $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
                        $order->clear_history = 0;
                        $order->is_delete = 0;
                        $order->save();

                        // Last Inserted Order ID
                        $last_order_id = $order->order_id;

                        // Coupon Info
                        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';

                        // Insert Coupon History
                        if(!empty($cpn_id) && $cpn_id != 0)
                        {
                            $coupon_history = new CouponHistory;
                            $coupon_history->coupon_id = $cpn_id;
                            $coupon_history->order_id = $last_order_id;
                            $coupon_history->customer_id = 0;
                            $coupon_history->amount = "-$cpn_discount";
                            $coupon_history->date_added = date('Y-m-d  H:i:s');
                            $coupon_history->save();
                        }

                        session()->put('last_order_id', $last_order_id);

                        // Order Product
                        if (isset($usercart)) 
                        {
                            if (isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0) {
                                foreach ($usercart['withoutSize'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    // Order Product without size
                                    $order_product = new OrderProduct;
                                    $order_product->order_id = $order->order_id;
                                    $order_product->product_id = $cart['product_id'];
                                    $order_product->name = $cart['name'];
                                    $order_product->model = '';
                                    $order_product->quantity = $cart['quantity'];
                                    $order_product->price = $del_price;
                                    $order_product->total = $del_price *  $cart['quantity'];
                                    $order_product->tax = 0.00;
                                    $order_product->reward = 0;
                                    $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $order_product->toppings = implode('', $toppings);
                                    } else {
                                        $order_product->toppings = '';
                                    }
                                    $order_product->request = '';
                                    $order_product->save();

                                    // payment db, Customer Order Product without size
                                    $payment_order_product = new CustomerOrderProduct;
                                    $payment_order_product->order_id = $order->order_id;
                                    $payment_order_product->product_id = $cart['product_id'];
                                    $payment_order_product->name = $cart['name'];
                                    $payment_order_product->model = '';
                                    $payment_order_product->quantity = $cart['quantity'];
                                    $payment_order_product->price = $del_price;
                                    $payment_order_product->total = $del_price *  $cart['quantity'];
                                    $payment_order_product->tax = 0.00;
                                    $payment_order_product->reward = 0;
                                    $payment_order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $order_product->toppings = implode('', $toppings);
                                    } else {
                                        $order_product->toppings = '';
                                    }
                                    $payment_order_product->request = '';
                                    $payment_order_product->save();
                                }
                            }

                            if (isset($usercart['size']) && count($usercart['size']) > 0) {
                                foreach ($usercart['size'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    // Order Product with size
                                    $order_product = new OrderProduct;
                                    $order_product->order_id = $order->order_id;
                                    $order_product->product_id = $cart['product_id'];
                                    $order_product->name = $cart['name'];
                                    $order_product->model = '';
                                    $order_product->quantity = $cart['quantity'];
                                    $order_product->price = $del_price;
                                    $order_product->total = $del_price *  $cart['quantity'];
                                    $order_product->tax = 0.00;
                                    $order_product->reward = 0;
                                    $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $order_product->toppings = implode('', $toppings);
                                    } else {
                                        $order_product->toppings = '';
                                    }
                                    $order_product->request = '';
                                    $order_product->save();

                                    // payment db, Customer Order Product with size
                                    $payment_order_product = new CustomerOrderProduct;
                                    $payment_order_product->order_id = $order->order_id;
                                    $payment_order_product->product_id = $cart['product_id'];
                                    $payment_order_product->name = $cart['name'];
                                    $payment_order_product->model = '';
                                    $payment_order_product->quantity = $cart['quantity'];
                                    $payment_order_product->price = $del_price;
                                    $payment_order_product->total = $del_price *  $cart['quantity'];
                                    $payment_order_product->tax = 0.00;
                                    $payment_order_product->reward = 0;
                                    $payment_order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $payment_order_product->toppings = implode('', $toppings);
                                    } else {
                                        $payment_order_product->toppings = '';
                                    }
                                    $payment_order_product->request = '';
                                    $payment_order_product->save();
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
                        $orderhistory->order_status_id = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $orderhistory->notify = 1;
                        $orderhistory->comment = '';
                        $orderhistory->date_added = date('Y-m-d h:i:s');
                        $orderhistory->save();

                        // Order Delivery
                        $orderdelivery = new OrderTotal;
                        $orderdelivery->order_id = $order->order_id;
                        $orderdelivery->code = 'delivery';
                        $orderdelivery->title = 'Delivery';
                        $orderdelivery->text = $currency_details['symbol_left'] . $delivery_charge;
                        $orderdelivery->value = $delivery_charge;
                        $orderdelivery->sort_order = 0;
                        $orderdelivery->save();

                        // Coupon Code
                        if ($couponcode != 0) 
                        {
                            $ordercoupon = new OrderTotal;
                            $ordercoupon->order_id = $order->order_id;
                            $ordercoupon->code = 'coupon';
                            $ordercoupon->title = 'Coupon(' . $couponname . ')';
                            $ordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                            $ordercoupon->value = '-' . $couponcode;
                            $ordercoupon->sort_order = 0;
                            $ordercoupon->save();
                        }

                        // Subtotal
                        $ordersubtotal = new OrderTotal;
                        $ordersubtotal->order_id = $order->order_id;
                        $ordersubtotal->code = 'sub_total';
                        $ordersubtotal->title = 'Sub-Total';
                        $ordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                        $ordersubtotal->value = $subtotal;
                        $ordersubtotal->sort_order = 0;
                        $ordersubtotal->save();

                        // service charge
                        if ($servicecharge != "") 
                        {
                            $orderservisecharge = new OrderTotal;
                            $orderservisecharge->order_id = $order->order_id;
                            $orderservisecharge->code = 'credit';
                            $orderservisecharge->title = 'Service Charge';
                            $orderservisecharge->text = $currency_details['symbol_left'] . $servicecharge;
                            $orderservisecharge->value = $servicecharge;
                            $orderservisecharge->sort_order = 0;
                            $orderservisecharge->save();
                        }

                        // Total to Pay
                        $ordertotal = new OrderTotal;
                        $ordertotal->order_id = $order->order_id;
                        $ordertotal->code = 'total';
                        $ordertotal->title = 'Total to Pay';
                        $ordertotal->text = $currency_details['symbol_left'] . $total;
                        $ordertotal->value = $total;
                        $ordertotal->sort_order = 0;
                        $ordertotal->save();

                        // Order Details Array
                        $orderserialize = $order->toArray();

                        // Insert New Customer Order
                        $cfname = isset($customer->firstname) ? $customer->firstname : '';
                        $clname = isset($customer->lastname) ? $customer->lastname : '';
                        $cfullname = $cfname . ' ' . $clname;
                        $customer_order = new CustomerOrder;
                        $customer_order->store_id = $front_store_id;
                        $customer_order->order_id = $last_order_id;
                        $customer_order->customer_name = $cfullname;
                        $customer_order->billing_address = "";
                        $customer_order->delivery_address = "";
                        $customer_order->order_status = 7; //Rejected. paypal success trnnsaction after order prossesing.
                        $customer_order->order_type = "delivery";
                        $customer_order->order_amount = $total;
                        $customer_order->commission_fee = "";
                        $customer_order->balance = "";
                        $customer_order->refunded_amount = null;
                        $customer_order->value = serialize($orderserialize);
                        $customer_order->is_order = "";
                        $customer_order->is_full_refund = 0;
                        $customer_order->old_order_amount = null;
                        $customer_order->order_date = date('Y-m-d h:i:s');
                        $customer_order->date_added = date('Y-m-d h:i:s');
                        $customer_order->refunded_date = null;
                        $customer_order->save();

                        session()->forget('couponcode');
                        session()->forget('couponname');
                        session()->forget('currentcoupon');
                        session()->forget('cart1');
                        session()->forget('free_item');
                        session()->forget('headertotal');
                        session()->forget('total');
                        session()->forget('product_id');
                        session()->forget('subtotal');
                        session()->forget('delivery_charge');
                    }

                }
            }
        }
    }


    // Stripe payment gateway order store
    public static function stripestoreOrder(Request $request)
    {
        $currentURL = URL::to("/");
        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);
        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];


        // Free Item
        $f_item = $request->free_item;
        if (!empty($f_item) || $f_item != '') {
            $free_item = $f_item;
        } else {
            if (session()->has('free_item')) {
                $free_item = session()->get('free_item');
            } else {
                $free_item = '';
            }
        }

        // Coupon Name
        $couponname = (session()->has('couponname')) ? session()->get('couponname') : '';

        // Current Coupon Array
        $currentcoupon = session()->get('currentcoupon');

        // Coupon Amount
        $couponcode = (session()->has('couponcode')) ? session()->get('couponcode') : 0.00;
        $code =isset($currentcoupon['code']) ? $currentcoupon['code'] : $couponname ;
        if(!empty($code))
        {
            $cpn_dt = Coupon::where('code',$code)->where('store_id',$front_store_id)->first();
        }
        else
        {
            $cpn_dt = '';
        }


        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] : '';


        // Get Currency Details
        $currency_code = $store_setting['config_currency'];
        $currency_details = Currency::where('code', $currency_code)->first();

        // Delivery Type
        $delivery_type = session()->get('flag_post_code');

        // Total
        $total = (session()->has('total')) ? session()->get('total') : 0.00;

        // Get Subtotal
        $subtotal = (session()->has('subtotal')) ? session()->get('subtotal') : 0.00;

        // Get Delivery Charge
        $delivery_charge = (session()->has('delivery_charge')) ? session()->get('delivery_charge') : 0.00;
        
        // Service Charge
        $servicecharge = isset($request->stripe_service_charge) ? $request->stripe_service_charge : 0.00;

        $total += $servicecharge;

        // Store Details
        $store = Store::where('store_id', $front_store_id)->first();
        $data['store_mail'] = getStoreDetails($front_store_id, 'config_email');
        $data['store_name'] = getStoreDetails($front_store_id, 'config_name');
        // End Store Details


        // Customer ID
        if (session()->has('userid')) 
        {
            $user_id = session()->get('userid');
        } else {
            $user_id = 0;
        }

        // Customer Details
        if ($user_id != 0) 
        {
            $customer = Customer::where('customer_id', $user_id)->first();
            $cust_address_id = isset($customer->address_id) ? $customer->address_id : '';
            $customer_def_address = CustomerAddress::where('address_id', $cust_address_id)->first();

            // Get customer Country
            $cust_country_id = isset($customer_def_address->country_id) ? $customer_def_address->country_id : '';
            $country = Country::select('name')->where('country_id',$cust_country_id)->first();
            $cust_country_name = isset($country->name) ? $country->name : '';

            // Get customer Zone
            $cust_zone_id = isset($customer_def_address->zone_id) ? $customer_def_address->zone_id : '';
            $zone = Region::select('name')->where('zone_id',$cust_zone_id)->first();
            $cust_zone_name = isset($zone->name) ? $zone->name : '';

        }
        // End Customer Details


        // Get Time Method
        if (session()->has('time_method')) {
            $time_method = session()->get('time_method');
        } else {
            $time_method = '';
        }
        // End Time Method


        $payment_method = 1;


        // Check Delivery Type
        if ($delivery_type == 'collection')  // Collection
        {
            // Check Payment Method
            if ($payment_method == 1) //Cash On Delivery
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
                        $gorder->fax = '';
                        $gorder->payment_firstname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
                        $gorder->payment_lastname = isset($guest_user['fname']) ? $guest_user['fname'] : '';
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
                        $gorder->payment_method = 'CARD';
                        $gorder->payment_code = 'stripe_gateway';
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
                        $gorder->currency_id = $currency_details['currency_id'];
                        $gorder->currency_code = $currency_details['code'];
                        $gorder->currency_value = $currency_details['value'];
                        $gorder->ip = $_SERVER['REMOTE_ADDR'];
                        $gorder->forwarded_ip = '';
                        $gorder->user_agent = '';
                        $gorder->accept_language = '';
                        $gorder->date_added = date('Y-m-d h:i:s');
                        $gorder->date_modified = date('Y-m-d h:i:s');
                        $gorder->flag_post_code = session()->get('flag_post_code');
                        $gorder->free_item =  $free_item;
                        $gorder->timedelivery = $time_method;
                        $gorder->gender_id = isset($guest_user['title']) ? $guest_user['title'] : 1;
                        $gorder->clear_history = 0;
                        $gorder->is_delete = 0;
                        $gorder->save();


                        $last_order_id = $gorder->order_id;

                        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


                        if(!empty($cpn_id) && $cpn_id != 0)
                        {
                            $coupon_history = new CouponHistory;
                            $coupon_history->coupon_id = $cpn_id;
                            $coupon_history->order_id = $last_order_id;
                            $coupon_history->customer_id = 0;
                            $coupon_history->amount = "-$cpn_discount";
                            $coupon_history->date_added = date('Y-m-d  H:i:s');
                            $coupon_history->save();
                        }

                        session()->put('last_order_id', $gorder->order_id);

                        // Guest Order Product
                        if (isset($guestUserCart)) 
                        {
                            if (isset($guestUserCart['withoutSize']) && count($guestUserCart['withoutSize']) > 0) 
                            {
                                foreach ($guestUserCart['withoutSize'] as $key => $cart) 
                                {
                                    $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $col_price;
                                    $gorder_product->total = $col_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }

                            if (isset($guestUserCart['size']) && count($guestUserCart['size']) > 0) 
                            {
                                foreach ($guestUserCart['size'] as $key => $cart) 
                                {
                                    $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $col_price;
                                    $gorder_product->total = $col_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
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

                        // Coupon Code
                        if ($couponcode != 0 || $couponcode != '') 
                        {
                            $gordercoupon = new OrderTotal;
                            $gordercoupon->order_id = $gorder->order_id;
                            $gordercoupon->code = 'coupon';
                            $gordercoupon->title = 'Coupon(' . $couponname . ')';
                            $gordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                            $gordercoupon->value = '-' . $couponcode;
                            $gordercoupon->sort_order = 0;
                            $gordercoupon->save();
                        }


                        // Subtotal
                        $gordersubtotal = new OrderTotal;
                        $gordersubtotal->order_id = $gorder->order_id;
                        $gordersubtotal->code = 'sub_total';
                        $gordersubtotal->title = 'Sub-Total';
                        $gordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                        $gordersubtotal->value = $subtotal;
                        $gordersubtotal->sort_order = 0;
                        $gordersubtotal->save();

                        // service charge
                        if ($servicecharge != "") 
                        {
                            $gordertotal = new OrderTotal;
                            $gordertotal->order_id = $gorder->order_id;
                            $gordertotal->code = 'credit';
                            $gordertotal->title = 'Service Charge';
                            $gordertotal->text = $currency_details['symbol_left'] . $servicecharge;
                            $gordertotal->value = $servicecharge;
                            $gordertotal->sort_order = 0;
                            $gordertotal->save();
                        }

                        // Total to Pay
                        $gordertotal = new OrderTotal;
                        $gordertotal->order_id = $gorder->order_id;
                        $gordertotal->code = 'total';
                        $gordertotal->title = 'Total to Pay';
                        $gordertotal->text = $currency_details['symbol_left'] . $total;
                        $gordertotal->value = $total;
                        $gordertotal->sort_order = 0;
                        $gordertotal->save();

                        session()->forget('guest_user');
                        session()->forget('headertotal');
                        session()->forget('total');
                        session()->forget('subtotal');
                        session()->forget('product_id');
                        session()->forget('couponcode');
                        session()->forget('currentcoupon');
                        session()->forget('couponname');
                        session()->forget('cart1');
                        session()->forget('free_item');
                    }
                } 
                else // Customer
                {
                    $usercart = session()->get('cart1');

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
                    $order->payment_address_1 = '';
                    $order->payment_address_2 = '';
                    $order->payment_city = '';
                    $order->payment_postcode = '';
                    $order->payment_country = 0;
                    $order->payment_country_id = 0;
                    $order->payment_zone = 0;
                    $order->payment_zone_id = 0;
                    $order->payment_address_format = '';
                    $order->payment_method = 'CARD';
                    $order->payment_code = 'stripe_gateway';
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
                    $order->currency_id = $currency_details['currency_id'];
                    $order->currency_code = $currency_details['code'];
                    $order->currency_value = $currency_details['value'];
                    $order->ip = isset($customer->ip) ? $customer->ip : '';
                    $order->forwarded_ip = '';
                    $order->user_agent = '';
                    $order->accept_language = '';
                    $order->date_added = date('Y-m-d h:i:s');
                    $order->date_modified = date('Y-m-d h:i:s');
                    $order->flag_post_code = session()->get('flag_post_code');
                    $order->free_item =  $free_item;
                    $order->timedelivery = $time_method;
                    $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
                    $order->clear_history = 0;
                    $order->is_delete = 0;
                    $order->save();

                    // Last Inserted Order ID
                    $last_order_id = $order->order_id;


                    $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                    $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                    $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


                    if(!empty($cpn_id) && $cpn_id != 0)
                    {
                        $coupon_history = new CouponHistory;
                        $coupon_history->coupon_id = $cpn_id;
                        $coupon_history->order_id = $last_order_id;
                        $coupon_history->customer_id = 0;
                        $coupon_history->amount = "-$cpn_discount";
                        $coupon_history->date_added = date('Y-m-d  H:i:s');
                        $coupon_history->save();
                    }


                    session()->put('last_order_id', $order->order_id);

                    // Order Product
                    if (isset($usercart)) 
                    {
                        if (isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0) 
                        {
                            foreach ($usercart['withoutSize'] as $key => $cart) 
                            {
                                $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];

                                $order_product = new OrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $col_price;
                                $order_product->total = $col_price *  $cart['quantity'];
                                $order_product->tax = 0.00;
                                $order_product->reward = 0;
                                $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $toppings = [];
                                if (isset($cart['topping']) && !empty($cart['topping'])) {
                                    foreach ($cart['topping'] as $topping) {
                                        $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                    }
                                    $order_product->toppings = implode('', $toppings);
                                } else {
                                    $order_product->toppings = '';
                                }
                                $order_product->request = '';
                                $order_product->save();
                            }
                        }

                        if (isset($usercart['size']) && count($usercart['size']) > 0) 
                        {
                            foreach ($usercart['size'] as $key => $cart) 
                            {
                                $col_price = (isset($cart['col_price']) && !empty($cart['col_price']) && $cart['col_price'] != 0) ? $cart['col_price'] : $cart['main_price'];
                                
                                $order_product = new OrderProduct;
                                $order_product->order_id = $last_order_id;
                                $order_product->product_id = $cart['product_id'];
                                $order_product->name = $cart['name'];
                                $order_product->model = '';
                                $order_product->quantity = $cart['quantity'];
                                $order_product->price = $col_price;
                                $order_product->total = $col_price *  $cart['quantity'];
                                $order_product->tax = 0.00;
                                $order_product->reward = 0;
                                $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                $toppings = [];
                                if (isset($cart['topping']) && !empty($cart['topping'])) {
                                    foreach ($cart['topping'] as $topping) {
                                        $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                    }
                                    $order_product->toppings = implode('', $toppings);
                                } else {
                                    $order_product->toppings = '';
                                }
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

                    // Coupon Code
                    if ($couponcode != 0 || $couponcode != '') {
                        $ordercoupon = new OrderTotal;
                        $ordercoupon->order_id = $order->order_id;
                        $ordercoupon->code = 'coupon';
                        $ordercoupon->title = 'Coupon(' . $couponname . ')';
                        $ordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                        $ordercoupon->value = '-' . $couponcode;
                        $ordercoupon->sort_order = 0;
                        $ordercoupon->save();
                    }

                    // Subtotal
                    $ordersubtotal = new OrderTotal;
                    $ordersubtotal->order_id = $order->order_id;
                    $ordersubtotal->code = 'sub_total';
                    $ordersubtotal->title = 'Sub-Total';
                    $ordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                    $ordersubtotal->value = $subtotal;
                    $ordersubtotal->sort_order = 0;
                    $ordersubtotal->save();

                    // service charge
                    if ($servicecharge != "") 
                    {
                        $ordertservicecharge = new OrderTotal;
                        $ordertservicecharge->order_id = $order->order_id;
                        $ordertservicecharge->code = 'credit';
                        $ordertservicecharge->title = 'Service Charge';
                        $ordertservicecharge->text = $currency_details['symbol_left'] . $servicecharge;
                        $ordertservicecharge->value = $servicecharge;
                        $ordertservicecharge->sort_order = 0;
                        $ordertservicecharge->save();
                    }

                    // Total to Pay
                    $ordertotal = new OrderTotal;
                    $ordertotal->order_id = $order->order_id;
                    $ordertotal->code = 'total';
                    $ordertotal->title = 'Total to Pay';
                    $ordertotal->text = $currency_details['symbol_left'] . $total;
                    $ordertotal->value = $total;
                    $ordertotal->sort_order = 0;
                    $ordertotal->save();

                    // Order Details Array
                    $orderserialize = $order->toArray();

                    $cfname = isset($customer->firstname) ? $customer->firstname : '';
                    $clname = isset($customer->lastname) ? $customer->lastname : '';
                    $cfullname = $cfname . ' ' . $clname;

                    $customer_order = new CustomerOrder;
                    $customer_order->store_id = $front_store_id;
                    $customer_order->order_id = $last_order_id;
                    $customer_order->customer_name = $cfullname;
                    $customer_order->billing_address = "";
                    $customer_order->delivery_address = "";
                    $customer_order->order_status = "";
                    $customer_order->order_type = "collection";
                    $customer_order->order_amount = $total;
                    $customer_order->commission_fee = "";
                    $customer_order->balance = "";
                    $customer_order->refunded_amount = null;
                    $customer_order->value = serialize($orderserialize);
                    $customer_order->is_order = "";
                    $customer_order->is_full_refund = 0;
                    $customer_order->old_order_amount = null;
                    $customer_order->order_date = date('Y-m-d h:i:s');
                    $customer_order->date_added = date('Y-m-d h:i:s');
                    $customer_order->refunded_date = null;
                    $customer_order->save();


                    session()->forget('headertotal');
                    session()->forget('total');
                    session()->forget('subtotal');
                    session()->forget('product_id');
                    session()->forget('couponcode');
                    session()->forget('currentcoupon');
                    session()->forget('couponname');
                    session()->forget('cart1');
                    session()->forget('free_item');

                }
            }
        }

        if ($delivery_type == 'delivery') // Delivery
        {
            // Check Payment Method
            if ($payment_method == 1) //Cash On Delivery
            {
                // Check User Type
                if ($user_id == 0) //Guest User
                {
                    $guest_user = session()->get('guest_user');
                    $guest_user_address = session()->get('guest_user_address');

                    if (!empty($guest_user)) 
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
                        $gorder->fax = '';
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
                        $gorder->payment_method = 'CARD';
                        $gorder->payment_code = 'stripe_gateway';
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
                        $gorder->currency_id = $currency_details['currency_id'];
                        $gorder->currency_code = $currency_details['code'];
                        $gorder->currency_value = $currency_details['value'];
                        $gorder->ip = $_SERVER['REMOTE_ADDR'];
                        $gorder->forwarded_ip = '';
                        $gorder->user_agent = '';
                        $gorder->accept_language = '';
                        $gorder->date_added = date('Y-m-d h:i:s');
                        $gorder->date_modified = date('Y-m-d h:i:s');
                        $gorder->flag_post_code = session()->get('flag_post_code');
                        $gorder->free_item =  $free_item;
                        $gorder->timedelivery = $time_method;
                        $gorder->gender_id = isset($guest_user['title']) ? $guest_user['title'] : 1;
                        $gorder->clear_history = 0;
                        $gorder->is_delete = 0;
                        $gorder->save();

                        // Last Inserted Order ID
                        $last_order_id = $gorder->order_id;

                        // Coupon Info
                        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


                        if(!empty($cpn_id) && $cpn_id != 0)
                        {
                            $coupon_history = new CouponHistory;
                            $coupon_history->coupon_id = $cpn_id;
                            $coupon_history->order_id = $last_order_id;
                            $coupon_history->customer_id = 0;
                            $coupon_history->amount = "-$cpn_discount";
                            $coupon_history->date_added = date('Y-m-d  H:i:s');
                            $coupon_history->save();
                        }

                        session()->put('last_order_id', $gorder->order_id);

                        // Guest Order Product
                        if (isset($guestUserCart)) 
                        {
                            if (isset($guestUserCart['withoutSize']) && count($guestUserCart['withoutSize']) > 0) 
                            {
                                foreach ($guestUserCart['withoutSize'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $del_price;
                                    $gorder_product->total = $del_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
                                    $gorder_product->request = '';
                                    $gorder_product->save();
                                }
                            }

                            if (isset($guestUserCart['size']) && count($guestUserCart['size']) > 0) 
                            {
                                foreach ($guestUserCart['size'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    $gorder_product = new OrderProduct;
                                    $gorder_product->order_id = $gorder->order_id;
                                    $gorder_product->product_id = $cart['product_id'];
                                    $gorder_product->name = $cart['name'];
                                    $gorder_product->model = '';
                                    $gorder_product->quantity = $cart['quantity'];
                                    $gorder_product->price = $del_price;
                                    $gorder_product->total = $del_price *  $cart['quantity'];
                                    $gorder_product->tax = 0.00;
                                    $gorder_product->reward = 0;
                                    $gorder_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $gorder_product->toppings = implode('', $toppings);
                                    } else {
                                        $gorder_product->toppings = '';
                                    }
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
                        $gorderdelivery->text = $currency_details['symbol_left'] . $delivery_charge;
                        $gorderdelivery->value = $delivery_charge;
                        $gorderdelivery->sort_order = 0;
                        $gorderdelivery->save();

                        // Coupon Code
                        if ($couponcode != 0 || !empty($couponcode)) 
                        {
                            $gordercoupon = new OrderTotal;
                            $gordercoupon->order_id = $gorder->order_id;
                            $gordercoupon->code = 'coupon';
                            $gordercoupon->title = 'Coupon(' . $couponname . ')';
                            $gordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                            $gordercoupon->value = '-' . $couponcode;
                            $gordercoupon->sort_order = 0;
                            $gordercoupon->save();
                        }

                        // Subtotal
                        $gordersubtotal = new OrderTotal;
                        $gordersubtotal->order_id = $gorder->order_id;
                        $gordersubtotal->code = 'sub_total';
                        $gordersubtotal->title = 'Sub-Total';
                        $gordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                        $gordersubtotal->value = $subtotal;
                        $gordersubtotal->sort_order = 0;
                        $gordersubtotal->save();

                        // service charge
                        if ($servicecharge != "") 
                        {
                            $gordertotal = new OrderTotal;
                            $gordertotal->order_id = $gorder->order_id;
                            $gordertotal->code = 'credit';
                            $gordertotal->title = 'Service Charge';
                            $gordertotal->text = $currency_details['symbol_left'] . $servicecharge;
                            $gordertotal->value = $servicecharge;
                            $gordertotal->sort_order = 0;
                            $gordertotal->save();
                        }

                        // Total to Pay
                        $gordertotal = new OrderTotal;
                        $gordertotal->order_id = $gorder->order_id;
                        $gordertotal->code = 'total';
                        $gordertotal->title = 'Total to Pay';
                        $gordertotal->text = $currency_details['symbol_left'] . $total;
                        $gordertotal->value = $total;
                        $gordertotal->sort_order = 0;
                        $gordertotal->save();

                        session()->forget('guest_user');
                        session()->forget('guest_user_address');
                        session()->forget('headertotal');
                        session()->forget('total');
                        session()->forget('subtotal');
                        session()->forget('product_id');
                        session()->forget('couponcode');
                        session()->forget('currentcoupon');
                        session()->forget('couponname');
                        session()->forget('cart1');
                        session()->forget('free_item');
                        session()->forget('delivery_charge');

                    }
                } 
                else //Customer
                {
                    $usercart = session()->get('cart1');

                    if (!empty($usercart)) 
                    {
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
                        $order->payment_company = isset($customer_def_address->company) ? $customer_def_address->company : '';
                        $order->payment_company_id = isset($customer_def_address->company_id) ? $customer_def_address->company_id : '' ;
                        $order->payment_tax_id = 0;
                        $order->payment_address_1 = isset($customer_def_address->address_1) ? $customer_def_address->address_1 : '';
                        $order->payment_address_2 = isset($customer_def_address->address_2) ? $customer_def_address->address_2 : '';
                        $order->payment_city = isset($customer_def_address->city) ? $customer_def_address->city : '';
                        $order->payment_postcode = isset($customer_def_address->postcode) ? $customer_def_address->postcode : '';
                        $order->payment_country = isset($cust_country_name) ? $cust_country_name : '';
                        $order->payment_country_id = isset($customer_def_address->country_id) ? $customer_def_address->country_id : '';
                        $order->payment_zone = isset($cust_zone_name) ? $cust_zone_name : '';
                        $order->payment_zone_id = isset($customer_def_address->zone_id) ? $customer_def_address->zone_id : '';
                        $order->payment_address_format = '';
                        $order->payment_method = 'CARD';
                        $order->payment_code = 'stripe_gateway';
                        $order->shipping_firstname = isset($customer->firstname) ? $customer->firstname : '';
                        $order->shipping_lastname = isset($customer->lastname) ? $customer->lastname : '';
                        $order->shipping_company = isset($customer_def_address->company) ? $customer_def_address->company : '';
                        $order->shipping_address_1 = isset($customer_def_address->address_1) ? $customer_def_address->address_1 : '';
                        $order->shipping_address_2 = isset($customer_def_address->address_2) ? $customer_def_address->address_2 : '';
                        $order->shipping_city = isset($customer_def_address->city) ? $customer_def_address->city : '';
                        $order->shipping_postcode = isset($customer_def_address->postcode) ? $customer_def_address->postcode : '';
                        $order->shipping_country = isset($cust_country_name) ? $cust_country_name : '';
                        $order->shipping_country_id = isset($customer_def_address->country_id) ? $customer_def_address->country_id : '';
                        $order->shipping_zone = isset($cust_zone_name) ? $cust_zone_name : '';
                        $order->shipping_zone_id = isset($customer_def_address->zone_id) ? $customer_def_address->zone_id : '';
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
                        $order->currency_id = $currency_details['currency_id'];
                        $order->currency_code = $currency_details['code'];
                        $order->currency_value = $currency_details['value'];
                        $order->ip = isset($customer->ip) ? $customer->ip : '';
                        $order->forwarded_ip = '';
                        $order->user_agent = '';
                        $order->accept_language = '';
                        $order->date_added = date('Y-m-d h:i:s');
                        $order->date_modified = date('Y-m-d h:i:s');
                        $order->flag_post_code = session()->get('flag_post_code');
                        $order->free_item =  $free_item;
                        $order->timedelivery = $time_method;
                        $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
                        $order->clear_history = 0;
                        $order->is_delete = 0;
                        $order->save();

                        // Last Inserted Order ID
                        $last_order_id = $order->order_id;

                        // Coupon Info
                        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


                        if(!empty($cpn_id) && $cpn_id != 0)
                        {
                            $coupon_history = new CouponHistory;
                            $coupon_history->coupon_id = $cpn_id;
                            $coupon_history->order_id = $last_order_id;
                            $coupon_history->customer_id = 0;
                            $coupon_history->amount = "-$cpn_discount";
                            $coupon_history->date_added = date('Y-m-d  H:i:s');
                            $coupon_history->save();
                        }

                        session()->put('last_order_id', $last_order_id);

                        // Order Product
                        if (isset($usercart)) 
                        {
                            if (isset($usercart['withoutSize']) && count($usercart['withoutSize']) > 0) 
                            {
                                foreach ($usercart['withoutSize'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    $order_product = new OrderProduct;
                                    $order_product->order_id = $order->order_id;
                                    $order_product->product_id = $cart['product_id'];
                                    $order_product->name = $cart['name'];
                                    $order_product->model = '';
                                    $order_product->quantity = $cart['quantity'];
                                    $order_product->price = $del_price;
                                    $order_product->total = $del_price *  $cart['quantity'];
                                    $order_product->tax = 0.00;
                                    $order_product->reward = 0;
                                    $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $order_product->toppings = implode('', $toppings);
                                    } else {
                                        $order_product->toppings = '';
                                    }
                                    $order_product->request = '';
                                    $order_product->save();
                                }
                            }

                            if (isset($usercart['size']) && count($usercart['size']) > 0) {
                                foreach ($usercart['size'] as $key => $cart) 
                                {
                                    $del_price = (isset($cart['del_price']) && !empty($cart['del_price']) && $cart['del_price'] != 0) ? $cart['del_price'] : $cart['main_price'];

                                    $order_product = new OrderProduct;
                                    $order_product->order_id = $order->order_id;
                                    $order_product->product_id = $cart['product_id'];
                                    $order_product->name = $cart['name'];
                                    $order_product->model = '';
                                    $order_product->quantity = $cart['quantity'];
                                    $order_product->price = $del_price;
                                    $order_product->total = $del_price *  $cart['quantity'];
                                    $order_product->tax = 0.00;
                                    $order_product->reward = 0;
                                    $order_product->name_size_base = isset($cart['size']) ? $cart['size'] : '';
                                    $toppings = [];
                                    if (isset($cart['topping']) && !empty($cart['topping'])) {
                                        foreach ($cart['topping'] as $topping) {
                                            $toppings[] = '<span class="bg" style="display:block">+' . $topping . '</span>';
                                        }
                                        $order_product->toppings = implode('', $toppings);
                                    } else {
                                        $order_product->toppings = '';
                                    }
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
                        $orderdelivery->text = $currency_details['symbol_left'] . $delivery_charge;
                        $orderdelivery->value = $delivery_charge;
                        $orderdelivery->sort_order = 0;
                        $orderdelivery->save();

                        // Coupon Code
                        if ($couponcode != 0 || !empty($couponcode)) 
                        {
                            $ordercoupon = new OrderTotal;
                            $ordercoupon->order_id = $order->order_id;
                            $ordercoupon->code = 'coupon';
                            $ordercoupon->title = 'Coupon(' . $couponname . ')';
                            $ordercoupon->text = $currency_details['symbol_left'] . ' -' . $couponcode;
                            $ordercoupon->value = '-' . $couponcode;
                            $ordercoupon->sort_order = 0;
                            $ordercoupon->save();
                        }

                        // Subtotal
                        $ordersubtotal = new OrderTotal;
                        $ordersubtotal->order_id = $order->order_id;
                        $ordersubtotal->code = 'sub_total';
                        $ordersubtotal->title = 'Sub-Total';
                        $ordersubtotal->text = $currency_details['symbol_left'] . $subtotal;
                        $ordersubtotal->value = $subtotal;
                        $ordersubtotal->sort_order = 0;
                        $ordersubtotal->save();

                        // service charge
                        if ($servicecharge != "") 
                        {
                            $orderservicecharge = new OrderTotal;
                            $orderservicecharge->order_id = $order->order_id;
                            $orderservicecharge->code = 'credit';
                            $orderservicecharge->title = 'Service Charge';
                            $orderservicecharge->text = $currency_details['symbol_left'] . $servicecharge;
                            $orderservicecharge->value = $servicecharge;
                            $orderservicecharge->sort_order = 0;
                            $orderservicecharge->save();
                        }

                        // Total to Pay
                        $ordertotal = new OrderTotal;
                        $ordertotal->order_id = $order->order_id;
                        $ordertotal->code = 'total';
                        $ordertotal->title = 'Total to Pay';
                        $ordertotal->text = $currency_details['symbol_left'] . $total;
                        $ordertotal->value = $total;
                        $ordertotal->sort_order = 0;
                        $ordertotal->save();


                        // Order Details Array
                        $orderserialize = $order->toArray();
                        $cfname = isset($customer->firstname) ? $customer->firstname : '';
                        $clname = isset($customer->lastname) ? $customer->lastname : '';
                        $cfullname = $cfname . ' ' . $clname;
                        $customer_order = new CustomerOrder;
                        $customer_order->store_id = $front_store_id;
                        $customer_order->order_id = $last_order_id;
                        $customer_order->customer_name = $cfullname;
                        $customer_order->billing_address = "";
                        $customer_order->delivery_address = "";
                        $customer_order->order_status = "";
                        $customer_order->order_type = "delivery";
                        $customer_order->order_amount = $total;
                        $customer_order->commission_fee = "";
                        $customer_order->balance = "";
                        $customer_order->refunded_amount = null;
                        $customer_order->value = serialize($orderserialize);
                        $customer_order->is_order = "";
                        $customer_order->is_full_refund = 0;
                        $customer_order->old_order_amount = null;
                        $customer_order->order_date = date('Y-m-d h:i:s');
                        $customer_order->date_added = date('Y-m-d h:i:s');
                        $customer_order->refunded_date = null;
                        $customer_order->save();

                        session()->forget('couponname');
                        session()->forget('couponcode');
                        session()->forget('currentcoupon');
                        session()->forget('cart1');
                        session()->forget('total');
                        session()->forget('subtotal');
                        session()->forget('headertotal');
                        session()->forget('free_item');
                        session()->forget('product_id');
                        session()->forget('delivery_charge');

                    }
                }
            }
        }
    }


}
