<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\CouponProduct;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerGroupDescription;
use App\Models\OrderCart;
use App\Models\OrderHistory;
use App\Models\OrderProduct;
use App\Models\OrderReturn;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\OrderTotal;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\ProductDescription;
use App\Models\ReturnAction;
use App\Models\ReturnProduct;
use App\Models\ReturnReason;
use App\Models\Settings;
use App\Models\Store;
use App\Models\Voucher;
use App\Models\VoucherThemeDescription;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    // Function for Order List
    public function index()
    {
        // Check User Permission
        if (check_user_role(39) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.order.list');
    }





    // Function of Get Orders By Current Store
    public function getorders(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }

        $columns = array(
            0 => 'order_id',
            1 => 'order_id',
            4 => 'firstname',
            2 => 'flag_post_code',
            7 => 'date_added',
        );

        if ($user_group_id == 1) {
            if ($current_store_id == 0) {
                $totalData = Orders::with(['hasOneOrderStatus', 'hasOneStore'])->count();

                $totalFiltered = $totalData;
                $limit = $request->request->get('length');
                $start = $request->request->get('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');

                    $posts =  Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where(function ($query) use ($search) {
                        $query->where('order_id', 'LIKE', "%{$search}%")->orWhere('firstname', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->orWhere('flag_post_code', 'LIKE', "%{$search}%")->orWhere('date_added', 'LIKE', "%{$search}%");
                    })->offset($start)->orderBy($order, $dir)->limit($limit)->get();


                    $totalFiltered = Orders::with(['hasOneStore', 'hasOneCurrency'])->where(function ($query) use ($search) {
                        $query->where('order_id', 'LIKE', "%{$search}%")->orWhere('firstname', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->orWhere('flag_post_code', 'LIKE', "%{$search}%")->orWhere('date_added', 'LIKE', "%{$search}%");
                    })->offset($start)->orderBy($order, $dir)->limit($limit)->count();
                } else {
                    $posts = Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
                }
            } else {
                $totalData = Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where('store_id', $current_store_id)->count();

                $totalFiltered = $totalData;
                $limit = $request->request->get('length');
                $start = $request->request->get('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');

                    $posts =  Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where(function ($query) use ($search) {
                        $query->where('order_id', 'LIKE', "%{$search}%")->orWhere('firstname', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->orWhere('flag_post_code', 'LIKE', "%{$search}%")->orWhere('date_added', 'LIKE', "%{$search}%");
                    })->where('store_id', $current_store_id)->offset($start)->orderBy($order, $dir)->limit($limit)->get();


                    $totalFiltered = Orders::with(['hasOneStore', 'hasOneCurrency'])->where(function ($query) use ($search) {
                        $query->where('order_id', 'LIKE', "%{$search}%")->orWhere('firstname', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->orWhere('flag_post_code', 'LIKE', "%{$search}%")->orWhere('date_added', 'LIKE', "%{$search}%");
                    })->where('store_id', $current_store_id)->offset($start)->orderBy($order, $dir)->limit($limit)->count();
                } else {
                    $posts = Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where('store_id', $current_store_id)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
                }
            }
        } else {
            $user_shop_id = $user_details['user_shop'];

            // Get Orders
            $totalData = Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where('store_id', $user_shop_id)->count();

            $totalFiltered = $totalData;
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');

                $posts =  Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where(function ($query) use ($search) {
                    $query->where('order_id', 'LIKE', "%{$search}%")->orWhere('firstname', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->orWhere('flag_post_code', 'LIKE', "%{$search}%")->orWhere('date_added', 'LIKE', "%{$search}%");
                })->where('store_id', $user_shop_id)->offset($start)->orderBy($order, $dir)->limit($limit)->get();


                $totalFiltered = Orders::with(['hasOneStore', 'hasOneCurrency'])->where(function ($query) use ($search) {
                    $query->where('order_id', 'LIKE', "%{$search}%")->orWhere('firstname', 'LIKE', "%{$search}%")->orWhere('lastname', 'LIKE', "%{$search}%")->orWhere('flag_post_code', 'LIKE', "%{$search}%")->orWhere('date_added', 'LIKE', "%{$search}%");
                })->where('store_id', $user_shop_id)->offset($start)->orderBy($order, $dir)->limit($limit)->count();
            } else {
                $posts = Orders::with(['hasOneOrderStatus', 'hasOneStore', 'hasOneCurrency'])->where('store_id', $user_shop_id)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
            }
        }


        $data = array();
        $data1 = array();

        if ($posts) {
            foreach ($posts as $post) {
                $order_id = $post->order_id;
                $firstname = isset($post->firstname) ? $post->firstname : '';
                $lastname = isset($post->lastname) ? $post->lastname : '';
                $status = isset($post->hasOneOrderStatus->name) ? $post->hasOneOrderStatus->name : '';
                $edit_url = route('vieworder', $post->order_id);

                $currency = $post->hasOneCurrency['symbol_left'];

                $data['checkbox'] = "<input type='checkbox' name='del_all' class='del_all' value='$order_id'>";
                $data['order_id'] = $order_id;
                $data['order_type'] = $post->flag_post_code;
                $data['shop_name'] = $post->store_name;
                $data['customer_name'] = $firstname . ' ' . $lastname;

                if ($status == "Accepted") {
                    $data['status'] = '<span class="badge badge-info">' . $status . '</div>';
                } elseif ($status == "Rejected") {
                    $data['status'] = '<span class="badge badge-danger">' . $status . '</div>';
                } elseif ($status == "Processing") {
                    $data['status'] = '<span class="badge badge-warning">' . $status . '</div>';
                } elseif ($status == "Complete") {
                    $data['status'] = '<span class="badge badge-success">' . $status . '</div>';
                } elseif ($status == "Refunded") {
                    $data['status'] = '<span class="badge badge-primary">' . $status . '</div>';
                } elseif ($status == "Charge Back") {
                    $data['status'] = '<span class="badge badge-dark">' . $status . '</div>';
                } else {
                    $data['status'] = '-';
                }

                $data['total'] = $currency . ' ' . number_format($post->total, 2);
                $data['date_added'] = date('Y-m-d', strtotime($post->date_added));

                if ($post->payment_code == "worldpayhp") {
                    $data['payment_type'] = "World Pay";
                } elseif ($post->payment_code == "ccod") {
                    $data['payment_type'] = "Chip & Pin";
                } elseif ($post->payment_code == "pp_express") {
                    $data['payment_type'] = "PayPal";
                } elseif ($post->payment_code == "cod") {
                    $data['payment_type'] = "Cash";
                } elseif ($post->payment_code == "myfoodbasketpayments_gateway") {
                    $data['payment_type'] = "Paid by Card";
                } else {
                    $data['payment_type'] = $post->payment_code;
                }

                if (check_user_role(42) == 1) {
                    $data['action'] = '<a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-eye text-white"></i><a>';
                } else {
                    $data['action'] = '-';
                }


                $data1[] = $data;
            }
        }

        $json_data = array(
            "draw"            => intval($request->request->get('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
            "data"            => $data1
        );

        echo json_encode($json_data);
    }






    // Function for View order
    public function vieworder($id)
    {
        // Check User Permission
        if (check_user_role(42) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Get Order Details By Order ID
        $orders = Orders::with(['hasOneOrderStatus', 'hasOneCustomerGroupDescription', 'hasOneCountry', 'hasOneRegion', 'hasOneCurrency'])->where('order_id', '=', $id)->first();

        // Get All Status
        $orderstatus = OrderStatus::all();

        // Get Totals By Order ID
        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->orderBy('order_total_id', 'DESC')->get();

        // Get Total Products By Order ID
        $productorders = OrderProduct::where('oc_order_product.order_id', '=', $id)->get();

        // Get Total Order History By Order ID
        $ordershistory = OrderHistory::with(['oneOrderHistoryStatus'])->where('order_id', $id)->get();

        return view('admin.order.view', ['orders' => $orders, 'orderstatus' => $orderstatus, 'ordertotal' => $ordertotal, 'productorders' => $productorders, 'ordershistory' => $ordershistory]);
    }





    // Function of Insert Order page
    public function ordersinsert()
    {
        // Check User Permission
        if (check_user_role(38) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }

        if ($user_group_id == 1) {
            // Get All Stores
            $data['stores'] = Store::get();
        } else {
            $user_shop_id = $user_details['user_shop'];
            $data['stores'] = Store::where('store_id', $user_shop_id)->get();
        }


        // Get All Customers
        $data['Customers'] = CustomerGroupDescription::get();

        // Get All Countries
        $data['countries'] = Country::get();

        // Get Voucher Theme Description
        $data['voucherthemes'] = VoucherThemeDescription::get();

        //Get Order Status
        $data['orderstatus'] = OrderStatus::get();

        return view('admin.order.addneworder', $data);
    }





    // Function of Generate Order Invoice..
    function generateinvoice(Request $request)
    {
        $orderID = $request->order_id;
        $order = Orders::where('order_id', $orderID)->first();
        $html = '';

        if (!empty($order) || $order != '') {
            if ($order->invoice_no == 0 || $order->invoice_no == '') {
                $query = Orders::max('invoice_no');
                if (!empty($query) || $query != '') {
                    $invoice_no = $query + 1;
                    $html .= $order->invoice_prefix . '' . $invoice_no;
                } else {
                    $invoice_no = 1;
                    $html .= $order->invoice_prefix . '' . $invoice_no;
                }
                $order_update = Orders::find($orderID);
                $order->invoice_no = $invoice_no;
                $order->update();
                return response()->json($html);
            }
        }
    }






    // Function for Store New Orders
    public function addneworders(Request $request)
    {


        $shipping_method =isset($request->shipping_method) ? $request->shipping_method : '' ;
        $flag_post_code =isset($request->shipping_method) ? $request->shipping_method : '' ;
        $order_status_id =isset($request->theme) ? $request->theme : '' ;

        // session all data Get

        $Total = session()->get('totals');

        $servicecharge = session()->get('service');
        $couponcode = session()->get('admin_couponcode');
        $couponname =session()->get('admin_couponcode_name');
        $subtotal = session()->get('admincarttotal');
        $vouchercode = session()->get('admin_vouchers_amount');
        $vouchername =session()->get('admin_vouchers_name');
        $usercart =session()->get('admincart');

        $user_id = isset($request->customerid) ? $request->customerid : 0 ;


        if ($user_id != 0) {
            $customer = Customer::where('customer_id', $user_id)->first();

            $cust_address_id = isset($customer->address_id) ? $customer->address_id : '';

            $customer_def_address = CustomerAddress::where('address_id', $cust_address_id)->first();
        }
        $currentURL = URL::to("/");


        // Get Store Settings & Other Settings
        $store_data = frontStoreID($currentURL);


        // Get Current Front Store ID
        $front_store_id =  $store_data['store_id'];


        // Store Settings
        $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';
        $code = session()->get('admin_couponcode_name');


        if(!empty($code))
        {
            $cpn_dt = Coupon::where('code',$code)->where('store_id',$front_store_id)->first();
        }
        else
        {
            $cpn_dt = '';
        }


        $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
        $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
        $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';


         // Get Currency Details
         $currency_code = $store_setting['config_currency'];
         $currency_details = Currency::where('code',$currency_code)->first();

        // Validation
        $request->validate([
            'firstname' => 'min:3 | max:32',
            'lastname' => 'min:3 | max:32',
            'phone' => 'min:3 | max:32',
            'email' => 'required|email',
            'payment_firstname' => 'min:1 | max:32',
            'payment_lastname' => 'min:1 | max:32',
            'payment_region_id' => 'required',
            'payment_country_id' => 'required',
            'payment_city' => 'min:3 | max:32',
            'payment_address_1' => 'min:1 | max:32',
            'shipping_firstname' => 'min:1 | max:32',
            'shipping_lastname' => 'min:1 | max:32',
            'shipping_address_1' => 'min:3 | max:32',
            'shipping_city' => 'min:3 | max:32',
            'shipping_region_id' => 'required',
            'shipping_country_id' => 'required',
            'shipping_city' => 'required',
            'shipping_address_1' => 'required',
            'storename' => 'required',
            'payment_method' => 'required',
        ]);

        // Store Details
        $store = Store::where('store_id', $request->storename)->first();

        // gust Uset
        if($user_id == 0){
                // // New Order
                $gorder = new Orders;
                $gorder->invoice_no = 0;
                $gorder->invoice_prefix = 'INV-2013-00';
                $gorder->store_id = isset($request->storename) ? $request->storename : "0";;
                $gorder->store_name =isset($store->name) ? $store->name : '';;
                $gorder->store_url = isset($store->url) ? $store->url : '';
                $gorder->customer_id = 0;
                $gorder->customer_group_id = 0;
                $gorder->firstname = isset($request->firstname) ? $request->firstname : '';
                $gorder->lastname = isset($request->lastname) ? $request->lastname : '';
                $gorder->email = isset($request->email) ? $request->email : '';
                $gorder->telephone = isset($request->phone) ? $request->phone : '';
                $gorder->fax = isset($request->fax) ? $request->fax : '';
                $gorder->payment_firstname = $request->payment_firstname;
                $gorder->payment_lastname = $request->payment_lastname;
                $gorder->payment_company =isset($request->payment_company) ? $request->payment_company : "";
                $gorder->payment_company_id =isset($request->payment_company_id) ? $request->payment_company_id : "";
                $gorder->payment_tax_id =isset($request->firstname) ? $request->firstname : "";
                $gorder->payment_address_1 = $request->payment_address_1;
                $gorder->payment_address_2 =isset($request->payment_address_2) ? $request->payment_address_2 : "";
                $gorder->payment_city =isset($request->payment_city) ? $request->payment_city : "";
                $gorder->payment_postcode = isset($request->payment_postcode) ? $request->payment_postcode : "";;
                $gorder->payment_country =$request->payment_country_id;
                $gorder->payment_country_id =isset($request->payment_region_id) ? $request->payment_region_id : "";;
                $gorder->payment_zone = 0;
                $gorder->payment_zone_id = 0;
                $gorder->payment_address_format = '';
                $gorder->payment_method = 'Cash on Delivery';
                $gorder->payment_code = 'cod';
                $gorder->shipping_firstname =$request->shipping_firstname;
                $gorder->shipping_lastname = $request->shipping_lastname;
                $gorder->shipping_company = isset($request->shipping_company) ? $request->shipping_company : "";
                $gorder->shipping_address_1 =$request->shipping_address_1;
                $gorder->shipping_address_2 = isset($request->shipping_address_2) ? $request->shipping_address_2 : "";
                $gorder->shipping_city = $request->shipping_city;
                $gorder->shipping_postcode = isset($request->shipping_postcode) ? $request->shipping_postcode : "";
                $gorder->shipping_country =$request->shipping_country_id;
                $gorder->shipping_country_id =isset($request->shipping_country_id) ? $request->shipping_country_id : "";
                $gorder->shipping_zone = 0;
                $gorder->shipping_zone_id = 0;
                $gorder->shipping_address_format = '';
                $gorder->shipping_method =$shipping_method;
                $gorder->shipping_code = '';
                $gorder->comment = '';
                $gorder->total = $Total;
                $gorder->order_status_id =$order_status_id; //Processing
                $gorder->message = '';
                $gorder->accepted_time = '';
                $gorder->affiliate_id = 0;
                $gorder->commission = 0.00;
                $gorder->language_id = 1;
                $gorder->currency_id = $currency_details['currency_id'];
                $gorder->currency_code = $currency_details['code'];
                $gorder->currency_value = $currency_details['value'];
                $gorder->ip = $request->ip();
                $gorder->forwarded_ip = '';
                $gorder->user_agent = '';
                $gorder->accept_language = '';
                $gorder->date_added = date('Y-m-d h:i:s');
                $gorder->date_modified = date('Y-m-d h:i:s');
                $gorder->flag_post_code =$flag_post_code;
                $gorder->free_item = '';
                $gorder->timedelivery = '';
                $gorder->gender_id = 1;
                $gorder->clear_history = 0;
                $gorder->is_delete = 0;
                $gorder->save();

                $last_gorder_id = $gorder->order_id;

                $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
                $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
                $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';

                // Coupon History
                if(!empty($cpn_id) && $cpn_id != 0)
                {
                    $coupon_history = new CouponHistory;
                    $coupon_history->coupon_id = $cpn_id;
                    $coupon_history->order_id = $last_gorder_id;
                    $coupon_history->customer_id = $user_id;
                    $coupon_history->amount ="-$cpn_discount";
                    $coupon_history->date_added = date('Y-m-d  H:i:s');
                    $coupon_history->save();
                }



                // Order Product
                if (isset($usercart)) {
                    foreach ($usercart as $key => $cart) {
                        $gorder_product = new OrderProduct;
                        $gorder_product->order_id = $last_gorder_id;
                        $gorder_product->product_id = $cart['product_id'];
                        $gorder_product->name = $cart['p_name'];
                        $gorder_product->model = '';
                        $gorder_product->quantity = $cart['p_quantity'];
                        $gorder_product->price = $cart['p_price'];
                        $gorder_product->total = $cart['p_price'] *  $cart['p_quantity'];
                        $gorder_product->tax = 0.00;
                        $gorder_product->reward = 0;
                        $gorder_product->name_size_base = '';
                        $gorder_product->toppings = '';
                        $gorder_product->request = '';
                        $gorder_product->save();
                    }
                }

                // //Order to Cart
                // $cart = isset($customer->cart) ? $customer->cart : '';
                // $gorder_to_cart = new OrderCart;
                // $gorder_to_cart->order_id = $last_gorder_id;
                // $gorder_to_cart->session_order = $cart;
                // $gorder_to_cart->save();

                // $customer_update = Customer::find($user_id);
                // $customer_update->cart = '';
                // $customer_update->update();

                // Order History
                $gorderhistory = new OrderHistory;
                $gorderhistory->order_id = $last_gorder_id;
                $gorderhistory->order_status_id =$order_status_id; //Processing
                $gorderhistory->notify = 1;
                $gorderhistory->comment = '';
                $gorderhistory->date_added = date('Y-m-d h:i:s');
                $gorderhistory->save();


                // Subtotal
                $gordersubtotal = new OrderTotal;
                $gordersubtotal->order_id = $last_gorder_id;
                $gordersubtotal->code = 'sub_total';
                $gordersubtotal->title = 'Sub-Total';
                $gordersubtotal->text = $currency_details['symbol_left'].$subtotal;
                $gordersubtotal->value = $subtotal;
                $gordersubtotal->sort_order = 0;
                $gordersubtotal->save();

                // Coupon Code
                if ($couponcode != 0) {
                    $gordercoupon = new OrderTotal;
                    $gordercoupon->order_id = $last_gorder_id;
                    $gordercoupon->code = 'coupon';
                    $gordercoupon->title = 'Coupon(' . $couponname . ')';
                    $gordercoupon->text = $currency_details['symbol_left'].' -' . number_format($couponcode,2);
                    $gordercoupon->value = '-' . number_format($couponcode,2);
                    $gordercoupon->sort_order = 0;
                    $gordercoupon->save();
                }

                // Voucher Code
                if ($vouchercode != 0) {
                    $gordervoucher = new OrderTotal;
                    $gordervoucher->order_id = $last_gorder_id;
                    $gordervoucher->code = 'voucher';
                    $gordervoucher->title = 'Voucher(' . $vouchername . ')';
                    $gordervoucher->text = $currency_details['symbol_left'].' -' . number_format($vouchercode,2);
                    $gordervoucher->value = '-' . number_format($vouchercode,2);
                    $gordervoucher->sort_order = 0;
                    $gordervoucher->save();
                }

                // Order Delivery
                $gorderdelivery = new OrderTotal;
                $gorderdelivery->order_id = $last_gorder_id;
                $gorderdelivery->code = 'delivery';
                $gorderdelivery->title = 'Delivery';
                $gorderdelivery->text = $currency_details['symbol_left'].'0.00';
                $gorderdelivery->value = 0.00;
                $gorderdelivery->sort_order = 0;
                $gorderdelivery->save();

                // service charge
                if ($servicecharge != "") {
                    $gordertotal = new OrderTotal;
                    $gordertotal->order_id = $last_gorder_id;
                    $gordertotal->code = 'credit';
                    $gordertotal->title = 'Service Charge';
                    $gordertotal->text = $currency_details['symbol_left'].$servicecharge;
                    $gordertotal->value = $servicecharge;
                    $gordertotal->sort_order = 0;
                    $gordertotal->save();
                }


                // Total to Pay
                $gordertotal = new OrderTotal;
                $gordertotal->order_id = $last_gorder_id;
                $gordertotal->code = 'total';
                $gordertotal->title = 'Total to Pay';
                $gordertotal->text = $Total;
                $gordertotal->value = $Total;
                $gordertotal->sort_order = 0;
                $gordertotal->save();

                // $new_url = $currentURL . '/success';

                session()->forget('admincart');
                // session()->forget('flag_post_code');
                session()->forget('admincarttotal');
                session()->forget('admin_couponcode');
                session()->forget('admin_couponcode_name');
                session()->forget('admin_vouchers_name');
                session()->forget('admin_vouchers_amount');
                session()->forget('service');
                session()->forget('totals');
                session()->forget('store_id');
        }
        else
        {

            // // New Order
            $order = new Orders;
            $order->invoice_no = 0;
            $order->invoice_prefix = 'INV-2013-00';
            $order->store_id = isset($request->storename) ? $request->storename : "0";;
            $order->store_name =isset($store->name) ? $store->name : '';;
            $order->store_url = isset($store->url) ? $store->url : '';
            $order->customer_id = $request->customerid;
            $order->customer_group_id = isset($customer->customer_group_id) ? $customer->customer_group_id : 1;
            $order->firstname = isset($customer->firstname) ? $customer->firstname : '';
            $order->lastname = isset($customer->lastname) ? $customer->lastname : '';
            $order->email = isset($customer->email) ? $customer->email : '';
            $order->telephone = isset($customer->telephone) ? $customer->telephone : '';
            $order->fax = isset($customer->fax) ? $customer->fax : '';
            $order->payment_firstname = $request->payment_firstname;
            $order->payment_lastname = $request->payment_lastname;
            $order->payment_company =isset($request->payment_company) ? $request->payment_company : "";
            $order->payment_company_id =isset($request->payment_company_id) ? $request->payment_company_id : "";
            $order->payment_tax_id =isset($request->firstname) ? $request->firstname : "";
            $order->payment_address_1 = $request->payment_address_1;
            $order->payment_address_2 =isset($request->payment_address_2) ? $request->payment_address_2 : "";
            $order->payment_city =isset($request->payment_city) ? $request->payment_city : "";
            $order->payment_postcode = isset($request->payment_postcode) ? $request->payment_postcode : "";;
            $order->payment_country =$request->payment_country_id;
            $order->payment_country_id =isset($request->payment_region_id) ? $request->payment_region_id : 0;
            $order->payment_zone = 0;
            $order->payment_zone_id = 0;
            $order->payment_address_format = '';
            $order->payment_method = 'Cash on Delivery';
            $order->payment_code = 'cod';
            $order->shipping_firstname =$request->shipping_firstname;
            $order->shipping_lastname = $request->shipping_lastname;
            $order->shipping_company = isset($request->shipping_company) ? $request->shipping_company : "";
            $order->shipping_address_1 =$request->shipping_address_1;
            $order->shipping_address_2 = isset($request->shipping_address_2) ? $request->shipping_address_2 : "";
            $order->shipping_city = $request->shipping_city;
            $order->shipping_postcode = isset($request->shipping_postcode) ? $request->shipping_postcode : "";
            $order->shipping_country =$request->shipping_country_id;
            $order->shipping_country_id =isset($request->shipping_country_id) ? $request->shipping_country_id : "";
            $order->shipping_zone = 0;
            $order->shipping_zone_id = 0;
            $order->shipping_address_format = '';
            $order->shipping_method =$shipping_method;
            $order->shipping_code = '';
            $order->comment = '';
            $order->total = $Total;
            $order->order_status_id =$order_status_id; //Processing
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
            $order->flag_post_code =$flag_post_code;
            $order->free_item = '';
            $order->timedelivery = '';
            $order->gender_id = isset($customer->gender_id) ? $customer->gender_id : 1;
            $order->clear_history = 0;
            $order->is_delete = 0;
            $order->save();

            $last_order_id = $order->order_id;

            $cpn_id = isset($cpn_dt->coupon_id) ? $cpn_dt->coupon_id : 0;
            $cpn_type = isset($cpn_dt->type) ? $cpn_dt->type : '';
            $cpn_discount = isset($cpn_dt->discount) ? $cpn_dt->discount : '';

            // Coupon History
            if(!empty($cpn_id) && $cpn_id != 0)
            {
                $coupon_history = new CouponHistory;
                $coupon_history->coupon_id = $cpn_id;
                $coupon_history->order_id = $last_order_id;
                $coupon_history->customer_id = $user_id;
                $coupon_history->amount ="-$cpn_discount";
                $coupon_history->date_added = date('Y-m-d  H:i:s');
                $coupon_history->save();
            }



            // Order Product
            if (isset($usercart)) {
                foreach ($usercart as $key => $cart) {
                    $order_product = new OrderProduct;
                    $order_product->order_id = $last_order_id;
                    $order_product->product_id = $cart['product_id'];
                    $order_product->name = $cart['p_name'];
                    $order_product->model = '';
                    $order_product->quantity = $cart['p_quantity'];
                    $order_product->price = $cart['p_price'];
                    $order_product->total = $cart['p_price'] *  $cart['p_quantity'];
                    $order_product->tax = 0.00;
                    $order_product->reward = 0;
                    $order_product->name_size_base = '';
                    $order_product->toppings = '';
                    $order_product->request = '';
                    $order_product->save();
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
            $orderhistory->order_id = $last_order_id;
            $orderhistory->order_status_id =$order_status_id; //Processing
            $orderhistory->notify = 1;
            $orderhistory->comment = '';
            $orderhistory->date_added = date('Y-m-d h:i:s');
            $orderhistory->save();


            // Subtotal
            $ordersubtotal = new OrderTotal;
            $ordersubtotal->order_id = $last_order_id;
            $ordersubtotal->code = 'sub_total';
            $ordersubtotal->title = 'Sub-Total';
            $ordersubtotal->text = $currency_details['symbol_left'].$subtotal;
            $ordersubtotal->value = $subtotal;
            $ordersubtotal->sort_order = 0;
            $ordersubtotal->save();

            // Coupon Code
            if ($couponcode != 0) {
                $ordercoupon = new OrderTotal;
                $ordercoupon->order_id = $last_order_id;
                $ordercoupon->code = 'coupon';
                $ordercoupon->title = 'Coupon(' . $couponname . ')';
                $ordercoupon->text = $currency_details['symbol_left'].' -' . number_format($couponcode,2);
                $ordercoupon->value = '-' . number_format($couponcode,2);
                $ordercoupon->sort_order = 0;
                $ordercoupon->save();
            }

            // Voucher Code
            if ($vouchercode != 0) {
                $ordervoucher = new OrderTotal;
                $ordervoucher->order_id = $last_order_id;
                $ordervoucher->code = 'voucher';
                $ordervoucher->title = 'Voucher(' . $vouchername . ')';
                $ordervoucher->text = $currency_details['symbol_left'].' -' . number_format($vouchercode,2);
                $ordervoucher->value = '-' . number_format($vouchercode,2);
                $ordervoucher->sort_order = 0;
                $ordervoucher->save();
            }

            // Order Delivery
            $orderdelivery = new OrderTotal;
            $orderdelivery->order_id = $last_order_id;
            $orderdelivery->code = 'delivery';
            $orderdelivery->title = 'Delivery';
            $orderdelivery->text = $currency_details['symbol_left'].'0.00';
            $orderdelivery->value = 0.00;
            $orderdelivery->sort_order = 0;
            $orderdelivery->save();

            // service charge
            if ($servicecharge != "") {
                $gordertotal = new OrderTotal;
                $gordertotal->order_id = $last_order_id;
                $gordertotal->code = 'credit';
                $gordertotal->title = 'Service Charge';
                $gordertotal->text = $currency_details['symbol_left'].$servicecharge;
                $gordertotal->value = $servicecharge;
                $gordertotal->sort_order = 0;
                $gordertotal->save();
            }


            // Total to Pay
            $ordertotal = new OrderTotal;
            $ordertotal->order_id = $last_order_id;
            $ordertotal->code = 'total';
            $ordertotal->title = 'Total to Pay';
            $ordertotal->text = $Total;
            $ordertotal->value = $Total;
            $ordertotal->sort_order = 0;
            $ordertotal->save();

            // $new_url = $currentURL . '/success';

            session()->forget('admincart');
            // session()->forget('flag_post_code');
            session()->forget('admincarttotal');
            session()->forget('admin_couponcode');
            session()->forget('admin_couponcode_name');
            session()->forget('admin_vouchers_name');
            session()->forget('admin_vouchers_amount');
            session()->forget('service');
            session()->forget('totals');
            session()->forget('store_id');
        }

        return view('admin.order.list');
    }






    // Function for Store new Order History
    public function orderhistoryinsert(Request $request)
    {
        // New Order History
        $orderhisins = new OrderHistory;
        $orderhisins->order_status_id = $request->order_status_id;
        $orderhisins->order_id = $request->order_id;
        $orderhisins->notify  = isset($request->notify) ? $request->notify : "0";
        $orderhisins->comment = isset($request->comment) ? $request->comment : "";
        $orderhisins->date_added = date("Y-m-d h:i:s");
        $orderhisins->save();

        // Update order Status
        $order = Orders::find($request->order_id);
        $order->order_status_id = $request->order_status_id;
        $order->update();

        // Send Mail & Notify to Customer for Changing Status
        if ($orderhisins->notify == 1) {
            $data['cust_mail'] = $order->email;
            $data['cust_name'] = $order->firstname . ' ' . $order->lastname;
            $data['order_id'] = $order->order_id;
            $data['pay_method'] = $order->payment_method;
            $data['store_name'] = $order->store_name;

            $status = OrderStatus::select('name')->where('order_status_id', $request->order_status_id)->first();
            $logo = Settings::where('key', 'polianna_main_logo')->where('store_id', $order->store_id)->first();
            $store_mail = Settings::where('key', 'config_email')->where('store_id', $order->store_id)->first();
            $store_addr = Settings::where('key', 'config_address')->where('store_id', $order->store_id)->first();
            $store_tele = Settings::where('key', 'config_telephone')->where('store_id', $order->store_id)->first();

            $data['status_code'] = isset($status->name) ? $status->name : '';
            $data['store_logo'] = isset($logo->value) ? $logo->value : '';
            $data['storeMail'] = isset($store_mail->value) ? $store_mail->value : '';
            $data['storeAddr'] = isset($store_addr->value) ? $store_addr->value : '';
            $data['storePhone'] = isset($store_tele->value) ? $store_tele->value : '';

            Mail::send(
                'admin.mail_format.orderstatus',
                ['data' => $data],
                function ($message) use ($data) {
                    $message->from('hasankaradiya1626@gmail.com');
                    $message->to($data['cust_mail']);
                    $message->subject('Order Status');
                }
            );
        }

        $html = '';

        // Get Total Order History By Order ID
        $ordershistory = OrderHistory::with(['oneOrderHistoryStatus'])->where('order_id', $request->order_id)->get();

        foreach ($ordershistory as $key => $value) {
            $html .= '<tr>';
            $html .= '<td>' . $value->date_added . '</td>';
            $html .= '<td>' . $value->comment . '</td>';
            $html .= '<td>' . $value->oneOrderHistoryStatus->name . '</td>';
            $html .= '<td>' . $value->notify . '</td>';
            $html .= '</tr>';
        }

        return response()->json([
            'success' => 200,
            'message' => "Success: You have modified orders!",
            'html' => $html,
        ]);
    }





    // Function for Delete Order
    public function deleteorder(Request $request)
    {
        // Check User Permission
        if (check_user_role(41) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $ids = $request->id;

        if (count($ids) > 0) {
            // Delete Orders
            Orders::whereIn('order_id', $ids)->delete();

            // Delete Order Cart
            OrderCart::whereIn('order_id', $ids)->delete();

            // Delete Order History
            OrderHistory::whereIn('order_id', $ids)->delete();

            // Delete Orders Products
            OrderProduct::whereIn('order_id', $ids)->delete();

            // Delete Orders Total
            OrderTotal::whereIn('order_id', $ids)->delete();
        }

        return response()->json([
            'success' => 1,
        ]);

        return view('admin.order.list');
    }





    // Function for Print Invoice
    public function invoice2($id)
    {

        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();

        $productorders = OrderProduct::where('oc_order_product.order_id', '=', $id)->get();

        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->get();

        return view('admin.order.invoice2', ["orders" => $orders, 'productorders' => $productorders, 'ordertotal' => $ordertotal]);
    }


    public function invoice(Request $request)
    {
        $invoiceIds = explode(',', $request->invoiceIds);

        $order = Orders::with(['hasManyOrderProduct','hasManyOrderTotal'])->whereIn('oc_order.order_id', $invoiceIds)->get();

        return view('admin.order.invoice', ["order" => $order]);

    }





    // Function for Get Products
    public function getproducts($id)
    {
        $productorders = Orders::select('*')->join('oc_order_product as op', 'op.order_id', '=', 'oc_order.order_id')->where('oc_order.customer_id', '=', $id)->get();
        $html = '';
        foreach ($productorders as $order) {
            $html .= '<tr>';
            $html .= '<td class="left"><a href="#">' . htmlspecialchars_decode($order->name) . '</a><br>' . $order->toppings . '</td>';
            $html .= '<td class="left">' . $order->model . '</td>';
            $html .= '<td class="right">' . $order->quantity  . '</td>';
            $html .= '<td class="right">' . $order->price  . '</td>';
            $html .= '<td class="right">' . number_format($order->total, 2)  . '</td>';
            $html .= '</tr>';
        }

        return response()->json($html);
    }





    // Function for Get Customer By Searching Customer Name
    public function autocomplete(Request $request)
    {
        $user_details = user_details();

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }

        if ($user_group_id == 1) {
            $res = Customer::where('firstname', 'LIKE', "%{$request->term}%")->orWhere('lastname', 'LIKE', "%{$request->term}%")->get();
        } else {
            $user_shop_id = $user_details['user_shop'];
            $res = Customer::where('firstname', 'LIKE', "%{$request->term}%")->where('store_id', $user_shop_id)->get();
        }
        return response()->json($res);
    }





    // Function For Get Product By Searching Product Name
    public function autocompleteproduct(Request $request)
    {
        $user_details = user_details();

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }

        if ($user_group_id == 1) {
            $pro = ProductDescription::where("name", "LIKE", "%{$request->product}%")->get();
        } else {
            $user_shop_id = $user_details['user_shop'];
            $pro = ProductDescription::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore', function ($q) use ($user_shop_id) {
                $q->where('store_id', $user_shop_id);
            })->where("name", "LIKE", "%{$request->product}%")->get();
        }

        return response()->json($pro);
    }





    // Function of Get Address By Selected Customer
    public function getaddress($id)
    {
        $addresses = CustomerAddress::where('customer_id', '=', $id)->get();

        $html = "";
        $html .= '<option value="0">Select Your Address</option>';
        foreach ($addresses as $address) {
            $html .= '<option value="' . $address->address_id . '">' . $address->address_1 . ', ' . $address->city . '</option>';
        }
        return response()->json($html);
    }





    // Function for Get Payment & Shipping Address By Customer Address ID
    public function payment_and_shipping_address($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }


    // Admin AddToCart Data

    public function adminaddtocart(Request $request)
    {

        $product_id = isset($request->product_id) ? $request->product_id : '';
        $quantity   = $request->quantity;
        $store_id   = $request->store_id;

        if (session()->has('admincart_product_id')) {
            $arr = session()->get('admincart_product_id');
        } else {
            $arr = array();
        }
        $arr[$product_id] = $product_id;
        session()->put('admincart_product_id', $arr);
        session()->save();


        if (session()->has('admincart')) {
            $data = session()->get('admincart');
        } else {
            $data = array();
        }


        $product = Product::with(['hasOneProductDescription'])->where('product_id', $product_id)->first();
        $admincart['p_name'] = $product->hasOneProductDescription->name;
        $admincart['p_model'] = $product->model;
        $admincart['p_quantity'] = $quantity;
        $admincart['p_price'] = $product->price;
        $admincart['total'] = $admincart['p_quantity'] * $admincart['p_price'];
        $admincart['product_id'] = $product->product_id;

        if (isset($data[$product_id])) {
            $data[$product_id]['p_quantity'] = $data[$product_id]['p_quantity'] + $quantity;
            $data[$product_id]['total'] = $data[$product_id]['p_quantity'] * $data[$product_id]['p_price'];
        } else {
            $data[$product_id] = $admincart;
        }

        $request->session()->put('admincart', $data);
        $request->session()->save();


        $admincartdata = session()->get('admincart');

        $html = '';
        $total = 0;
        foreach ($admincartdata as $value) {
            $html .= '<tr>';
            $html .= '<td>
            <a class="btn btn-sm btn-danger ml-1 deletesellected" onclick="deleteproductcart(' . $value['product_id'] . ')" >
            <i class="fa fa-trash" ></i>
            </a>
            </td>';
            $html .= '<td>' . $value['p_name'] . '</td>';
            if (isset($value['p_model'])) {
                $html .= '<td>' . $value['p_model'] . '</td>';
            } else {
                $html .= '<td>' - '</td>';
            }
            $html .= '<td>' . $value['p_quantity'] . '</td>';
            $html .= '<td>' . $value['p_price'] . '</td>';
            $html .= '<td>' . $value['total'] . '</td>';
            $html .= '</tr>';

            $total += $value['total'];
        }
        $html .= '<tr>';
        $html .= '<td colspan="4"></td>';
        $html .= '<td><b>SubTotal</b></td>';
        $html .= '<td>' . $total . '</td>';
        $html .= '</tr>';

        session()->put('admincarttotal', $total);
        $service=session()->get('service');
        $admin_couponcode=session()->get('admin_couponcode');
        $admin_couponcode_name=session()->get('admin_couponcode_name');
        $admin_vouchers_name=session()->get('admin_vouchers_name');
        $admin_vouchers_amount=session()->get('admin_vouchers_amount');
        $sub_total = session()->get('admincarttotal');
        $totals = $sub_total - $admin_couponcode - $admin_vouchers_amount + $service;

        // $subtotals = '';
        // $coupons = '';
        // $vouchers = '';
        // $service = '';
        // $totals ='';




        if(!empty($admin_couponcode_name)  || $admin_couponcode_name != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>Coupon('.$admin_couponcode_name.')</b></td>';
            $html .= '<td>-' . $admin_couponcode . '</td>';
            $html .= '</tr>';
        }

        if(!empty($admin_vouchers_amount) || $admin_vouchers_amount != '' &&  !empty($admin_vouchers_name) || $admin_vouchers_name != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>Voucher('.$admin_vouchers_name.')</b></td>';
            $html .= '<td> -' . $admin_vouchers_amount . '</td>';
            $html .= '</tr>';
        }

        if(!empty($service) || $service != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>service_charge</b></td>';
            $html .= '<td>' . $service . '</td>';
            $html .= '</tr>';
        }

        if(!empty($totals) || $totals != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>Total</b></td>';
            $html .= '<td>' . $totals . '</td>';
            $html .= '</tr>';
        }
        return response()->json([
            'html' => $html,
        ]);
    }


    // Admin Delete Cart product

    public function deleteproductcart(Request $request)
    {
        $pro_id = $request->pro_id;

        if (session()->has('admincart_product_id')) {
            $productid  = session()->get('admincart_product_id');

        }


        if (in_array($pro_id,$productid)) {
            unset($productid[$pro_id]);
            session()->put('admincart_product_id', $pro_id);
            session()->save();
        }

        $cart = session()->get('admincart');
        if (isset($cart[$pro_id])) {
            unset($cart[$pro_id]);
            session()->put('admincart', $cart);
        }
        $admincartdata = session()->get('admincart');
        $html = '';
        $total = 0;
        foreach ($admincartdata as $value) {
            $html .= '<tr>';
            $html .= '<td>
            <a class="btn btn-sm btn-danger ml-1 deletesellected" onclick="deleteproductcart(' . $value['product_id'] . ')" >
            <i class="fa fa-trash" ></i>
            </a>
            </td>';
            $html .= '<td>' . $value['p_name'] . '</td>';
            if (isset($value['p_model'])) {
                $html .= '<td>' . $value['p_model'] . '</td>';
            } else {
                $html .= '<td>' - '</td>';
            }
            $html .= '<td>' . $value['p_quantity'] . '</td>';
            $html .= '<td>' . $value['p_price'] . '</td>';
            $html .= '<td>' . $value['total'] . '</td>';
            $html .= '</tr>';

            $total += $value['total'];
        }
        $html .= '<tr>';
        $html .= '<td colspan="4"></td>';
        $html .= '<td><b>SubTotal</b></td>';
        $html .= '<td>' . $total . '</td>';
        $html .= '</tr>';
        session()->put('admincarttotal', $total);

        $service=session()->get('service');
        $admin_couponcode=session()->get('admin_couponcode');
        $admin_couponcode_name=session()->get('admin_couponcode_name');
        $admin_vouchers_name=session()->get('admin_vouchers_name');
        $admin_vouchers_amount=session()->get('admin_vouchers_amount');
        $sub_total = session()->get('admincarttotal');
        $totals = $sub_total - $admin_couponcode - $admin_vouchers_amount + $service;

        // $subtotals = '';
        // $coupons = '';
        // $vouchers = '';
        // $service = '';
        // $totals ='';




        if(!empty($admin_couponcode_name)  || $admin_couponcode_name != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>Coupon('.$admin_couponcode_name.')</b></td>';
            $html .= '<td>-' . $admin_couponcode . '</td>';
            $html .= '</tr>';
        }

        if(!empty($admin_vouchers_amount) || $admin_vouchers_amount != '' &&  !empty($admin_vouchers_name) || $admin_vouchers_name != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>Voucher('.$admin_vouchers_name.')</b></td>';
            $html .= '<td> -' . $admin_vouchers_amount . '</td>';
            $html .= '</tr>';
        }

        if(!empty($service) || $service != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>service_charge</b></td>';
            $html .= '<td>' . $service . '</td>';
            $html .= '</tr>';
        }

        if(!empty($totals) || $totals != ''){
            $html .= '<tr>';
            $html .= '<td colspan="4"></td>';
            $html .= '<td><b>Total</b></td>';
            $html .= '<td>' . $totals . '</td>';
            $html .= '</tr>';
        }


        return response()->json([
            'html' => $html,
            // 'subtotal' => $subtotals,
            // 'coupons' => $coupons,
            // 'vouchers' => $vouchers,
            // 'service' => $service,
            // 'totals' => $totals,
        ]);
    }


    //

    public function applycouponvoucher(Request $request)
    {

        $coupon = isset($request->coupon) ? $request->coupon : '';
        $voucher = isset($request->voucher) ? $request->voucher : '';
        $store_id   = $request->store_id;
        $shipping_method   = $request->shipping_method;
        $userid   = $request->userid;
        $method_type   = isset($request->servicecharge) ? $request->servicecharge : '';
        $subtotal = session()->get('admincarttotal');
        $current_date = strtotime(date('Y-m-d'));


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
        $servicecharge = paymentdetails();

        $stripe_charge = $servicecharge["stripe"]["stripe_charge_payment"] ? $servicecharge["stripe"]["stripe_charge_payment"] : '0.00';
        $paypal_charge = $servicecharge["paypal"]["pp_charge_payment"] ? $servicecharge["paypal"]["pp_charge_payment"] : '0.00';
        $cod_charge = $servicecharge["cod"]["cod_charge_payment"] ? $servicecharge["cod"]["cod_charge_payment"] : '0.00';
        $success ='';
        $error ='';

        $Couponcode  = Coupon::where('code', $coupon)->where('store_id', $store_id)->first();

        $get_voucher = Voucher::where('code', $voucher)->where('store_id', $store_id)->first();
        if(!empty($get_voucher) || $get_voucher != ''){

            if ($get_voucher->apply_shipping == 1) {
                $type = 'delivery';
            } elseif ($get_voucher->apply_shipping == 2) {
                $type = 'collection';
            } elseif ($get_voucher->apply_shipping == 3) {
                $type = 'both';
            } else {
                $type = '';
            }
        }

        $apply_coupon = '';
        $start_date = isset($get_voucher['date_start']) ? strtotime($Couponcode['date_start']) : '';
        $end_date = isset($Couponcode['date_end']) ? strtotime($Couponcode['date_end']) : '';
        $cart_proid = session()->get('admincart_product_id');
        $session_proid = session()->get('admincart_product_id');
        $success_message_coupon = '';
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

       if(!empty($coupon) || $coupon !=  ''){

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
                    $uses_per_cpn = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->where('customer_id', $userid)->count();
                    if ($Couponcode->on_off == 1 && $Couponcode->status == 1) {
                        if ($Couponcode->uses_total >  $count_user_per_cpn || $Couponcode->uses_total == 0) {
                            if ($Couponcode->uses_customer > $uses_per_cpn) {
                                if (!empty($session_proid) ||  $session_proid != '') {
                                    if (array_intersect($product_check,  $session_proid) && count($product_check) != 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $errors = 1;
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;

                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $errors = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;
                                            }
                                        } else {

                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $errors = 1;
                                        }
                                    } elseif (array_intersect($cat_to_pro,  $session_proid) && count($cat_to_pro) != 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $errors = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;

                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {

                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } else {

                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $error = 1;
                                        }
                                    } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {

                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } elseif ($apply_shipping == 'both') {

                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;

                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } else {
                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $error = 1;
                                        }
                                    }
                                }
                            } else {
                                $error_msg = '<span class="text-danger">This Coupon already Used.</span>';
                                $error = 1;
                            }
                        } else {
                            $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                            $error = 1;
                        }
                    } else {
                        $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                        $error = 1;
                    }
                }
            } elseif ($Couponcode->logged == 0) {
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
                    $uses_per_cpn = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->where('customer_id', $userid)->count();
                    if ($Couponcode->on_off == 1 && $Couponcode->status == 1) {
                        if ($Couponcode->uses_total >  $count_user_per_cpn || $Couponcode->uses_total == 0) {
                            if ($Couponcode->uses_customer > $uses_per_cpn) {
                                if (!empty($session_proid) ||  $session_proid != '') {
                                    if (array_intersect($product_check,  $session_proid) && count($product_check) != 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $errors = 1;
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;

                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $errors = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;
                                            }
                                        } else {

                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $errors = 1;
                                        }
                                    } elseif (array_intersect($cat_to_pro,  $session_proid) && count($cat_to_pro) != 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $errors = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;

                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {

                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } else {

                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $error = 1;
                                        }
                                    } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {

                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } elseif ($apply_shipping == 'both') {

                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } else {
                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $error = 1;
                                        }
                                    }
                                }
                            } else {
                                $error_msg = '<span class="text-danger">This Coupon already Used.</span>';
                                $error = 1;
                            }
                        } else {
                            $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                            $error = 1;
                        }
                    } else {
                        $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                        $error = 1;
                    }
                }
                else
                {
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
                    // $uses_per_cpn = CouponHistory::where('coupon_id', $Couponcode->coupon_id)->where('customer_id', $userid)->count();
                    if ($Couponcode->on_off == 1 && $Couponcode->status == 1) {
                        if ($Couponcode->uses_total >  $count_user_per_cpn || $Couponcode->uses_total == 0) {
                            // if ($Couponcode->uses_customer > $uses_per_cpn) {
                                if (!empty($session_proid) ||  $session_proid != '') {
                                    if (array_intersect($product_check,  $session_proid) && count($product_check) != 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $errors = 1;
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;

                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $errors = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;
                                            }
                                        } else {

                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $errors = 1;
                                        }
                                    } elseif (array_intersect($cat_to_pro,  $session_proid) && count($cat_to_pro) != 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $errors = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $errors = 1;
                                            }
                                        } elseif ($apply_shipping == 'both') {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;

                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {

                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } else {

                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $error = 1;
                                        }
                                    } elseif (count($product_check) == 0 && count($cat_to_pro) == 0) {
                                        if ($apply_shipping == $shipping_method) {
                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {

                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } elseif ($apply_shipping == 'both') {

                                            if ($Couponcode->total <= $subtotal) {
                                                if ($current_date >= $start_date && $current_date < $end_date) // Coupon Not Expired
                                                {
                                                    $apply_coupon = $Couponcode;
                                                    $success_message_coupon = '<span class="text-success">Coupon has been Applied Successfully..</span>';
                                                    $success = 1;
                                                } else // Expired Coupon
                                                {
                                                    $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                                                    $error = 1;
                                                }
                                            } else {
                                                $error_msg = '<span class="text-danger">Minimum Amount is ' . $currency . '' . number_format($Couponcode->total, 0) . ' for Apply This Coupon.</span>';
                                                $error = 1;
                                            }
                                        } else {
                                            $error_msg = '<span class="text-danger"> Sorry Coupon is Expired!</span>';
                                            $error = 1;
                                        }
                                    }
                                }
                            // } else {
                            //     $error_msg = '<span class="text-danger">This Coupon already Used.</span>';
                            //     $error = 1;
                            // }
                        } else {
                            $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                            $error = 1;
                        }
                    } else {
                        $error_msg = '<span class="text-danger">Sorry Coupon is Expired!</span>';
                        $error = 1;
                    }
                }
            } else {
                $error_msg = '<span class="text-danger">Login Required.</span>';
                $error = 1;
            }
        }
        else // Invalid Coupon
        {
            $error_msg = '<span class="text-danger">Please enter valid Coupon Code</span>';
            $error = 1;
        }
       }

        $error_msg_voucher ='';
        $message_voucher = '';
        $voucheramount = 0;
        $errors = '';
        $success_message_voucher = '';
        $vouchercode ='';
        if(!empty($voucher) || $voucher !=  ''){
            if (!empty($get_voucher) || $get_voucher != '') {
                if ($get_voucher['status'] == 1) {
                    if ($shipping_method == $type) {
                        $voucheramount = isset($get_voucher['amount']) ? $get_voucher['amount'] : 0;
                        $vouchercode = isset($get_voucher['code']) ? $get_voucher['code'] : '';
                        $success_message_voucher = '<span class="text-success">Voucher has been Applied Successfully..</span>';
                        $message_voucher = 1;
                    } elseif ($type == 'both') {
                        $voucheramount = isset($get_voucher['amount']) ? $get_voucher['amount'] : 0;
                        $vouchercode = isset($get_voucher['code']) ? $get_voucher['code'] : '';
                        $success_message_voucher = '<span class="text-success">Voucher has been Applied Successfully..</span>';
                        $message_voucher = 1;
                    }
                } else {

                    $error_msg_voucher = '<span class="text-danger">Please valid Not Voucher Code</span>';
                    $errors = 1;
                }
            } else {

                $error_msg_voucher = '<span class="text-danger">Please enter valid Voucher Code</span>';
                $errors = 1;
            }
        }

        $couponcode =0;
        if (isset($apply_coupon->type) ? $apply_coupon->type :'' == 'P') {
            $couponcode = ($subtotal * $apply_coupon->discount) / 100;
        }
        if (isset($apply_coupon->type) ? $apply_coupon->type :'' == 'F') {
            $couponcode = $apply_coupon->discount;
        }



        $total = $subtotal - (isset($couponcode) ? $couponcode : 0) - (isset($voucheramount) ? $voucheramount : 0);
        $couponname = isset($apply_coupon->code) ? $apply_coupon->code : '';

        if ($method_type == 1) {
            $all_total =  round($total + $stripe_charge, 2);
            $service_charge =$stripe_charge;
        } elseif ($method_type == 2) {
            $all_total =  round($total + $paypal_charge, 2);
            $service_charge =$paypal_charge;
        } elseif ($method_type == 3) {
            $all_total =  round($total + $cod_charge, 2);
            $service_charge =$cod_charge;
        } else {
            $all_total = round($total, 2);
        }

        session()->put('admin_couponcode',$couponcode);
        session()->put('admin_couponcode_name',$couponname);
        session()->put('admin_vouchers_name',$vouchercode);
        session()->put('admin_vouchers_amount',$voucheramount);
        session()->put('service',$service_charge);
        session()->put('totals',$all_total);
        $subtotals = '';
        $coupons = '';
        $vouchers = '';
        $service = '';
        $totals ='';



        $subtotals .= '<td colspan="4"></td>';
        $subtotals .= '<td><b>Subtotal</b></td>';
        $subtotals .= '<td>' . $subtotal . '</td>';

        if((!empty($couponname)  || $couponname != '') && (!empty($couponcode)  || $couponcode != '')){
            $coupons .= '<td colspan="4"></td>';
            $coupons .= '<td><b>Coupon('.$couponname.')</b></td>';
            $coupons .= '<td>-' . $couponcode . '</td>';
        }



        if((!empty($voucheramount) || $voucheramount != '') && (!empty($vouchercode) || $vouchercode != '')){
            $vouchers .= '<td colspan="4"></td>';
            $vouchers .= '<td><b>Voucher('.$vouchercode.')</b></td>';
            $vouchers .= '<td> -' . $voucheramount . '</td>';
        }

        if(!empty($service_charge) || $service_charge != ''){

            $service .= '<td colspan="4"></td>';
            $service .= '<td><b>service_charge</b></td>';
            $service .= '<td>' . $service_charge . '</td>';
        }


        if(!empty($all_total) || $all_total != ''){
            $totals .= '<td colspan="4"></td>';
            $totals .= '<td><b>Total</b></td>';
            $totals .= '<td>' . $all_total . '</td>';
        }




        return response()->json([
            'success' =>$success,
            'message_voucher' => $message_voucher,
            'success_message_coupon' => $success_message_coupon,
            'success_message_voucher' => $success_message_voucher,
            'error_msg_voucher' => $error_msg_voucher,
            'error_msg' => isset($error_msg) ? $error_msg : '',
            'error' => $error,
            'errors' =>$errors,
            'subtotal' => $subtotals,
            'coupons' => $coupons,
            'vouchers' => $vouchers,
            'service' => $service,
            'totals' => $totals,
        ]);


    }
}
