<?php

namespace App\Http\Controllers;

use App\Models\Country;
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
use App\Models\ProductDescription;
use App\Models\ReturnAction;
use App\Models\ReturnProduct;
use App\Models\ReturnReason;
use App\Models\Settings;
use App\Models\Store;
use App\Models\VoucherThemeDescription;
use Illuminate\Http\Request;
use DataTables;

class OrdersController extends Controller
{
    // Function for Order List
    public function index()
    {
        // Check User Permission
        if (check_user_role(39) != 1)
        {
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

        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }

        $columns = array(
            0 =>'order_id',
            1 =>'order_id',
            4 =>'firstname',
            2 => 'flag_post_code',
            7 => 'date_added',
        );

        if($user_group_id == 1)
        {
            if($current_store_id == 0){
                $totalData = Orders::with(['hasOneOrderStatus','hasOneStore'])->count();

                $totalFiltered = $totalData;
                $limit = $request->request->get('length');
                $start = $request->request->get('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(!empty($request->input('search.value')))
                {
                    $search = $request->input('search.value');

                    $posts =  Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where(function ($query) use ($search){
                        $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
                    })->offset($start)->orderBy($order,$dir)->limit($limit)->get();


                    $totalFiltered = Orders::with(['hasOneStore','hasOneCurrency'])->where(function ($query) use ($search){
                        $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
                    })->offset($start)->orderBy($order,$dir)->limit($limit)->count();
                }
                else
                {
                    $posts = Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->offset($start)->limit($limit)->orderBy($order,$dir)->get();

                }
            }
            else
            {
                $totalData = Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where('store_id',$current_store_id)->count();

                $totalFiltered = $totalData;
                $limit = $request->request->get('length');
                $start = $request->request->get('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if(!empty($request->input('search.value')))
                {
                    $search = $request->input('search.value');

                    $posts =  Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where(function ($query) use ($search){
                        $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
                    })->where('store_id',$current_store_id)->offset($start)->orderBy($order,$dir)->limit($limit)->get();


                    $totalFiltered = Orders::with(['hasOneStore','hasOneCurrency'])->where(function ($query) use ($search){
                        $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
                    })->where('store_id',$current_store_id)->offset($start)->orderBy($order,$dir)->limit($limit)->count();
                }
                else
                {
                    $posts = Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where('store_id',$current_store_id)->offset($start)->limit($limit)->orderBy($order,$dir)->get();

                }
            }

        }
        else
        {
            $user_shop_id = $user_details['user_shop'];

            // Get Orders
            $totalData = Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where('store_id',$user_shop_id)->count();

            $totalFiltered = $totalData;
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(!empty($request->input('search.value')))
            {
                $search = $request->input('search.value');

                $posts =  Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where(function ($query) use ($search){
                    $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
                })->where('store_id',$user_shop_id)->offset($start)->orderBy($order,$dir)->limit($limit)->get();


                $totalFiltered = Orders::with(['hasOneStore','hasOneCurrency'])->where(function ($query) use ($search){
                    $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
                })->where('store_id',$user_shop_id)->offset($start)->orderBy($order,$dir)->limit($limit)->count();
            }
            else
            {
                $posts = Orders::with(['hasOneOrderStatus','hasOneStore','hasOneCurrency'])->where('store_id',$user_shop_id)->offset($start)->limit($limit)->orderBy($order,$dir)->get();

            }
        }


        $data = array();
        $data1=array();

        if($posts)
        {
            foreach ($posts as $post)
            {
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
                $data['customer_name'] = $firstname.' '.$lastname;

                if($status == "Accepted")
                {
                    $data['status'] = '<span class="badge badge-info">'.$status.'</div>';
                }
                elseif($status == "Rejected")
                {
                    $data['status'] = '<span class="badge badge-danger">'.$status.'</div>';
                }
                elseif($status == "Processing")
                {
                    $data['status'] = '<span class="badge badge-warning">'.$status.'</div>';
                }
                elseif($status == "Complete")
                {
                    $data['status'] = '<span class="badge badge-success">'.$status.'</div>';
                }
                elseif($status == "Refunded")
                {
                    $data['status'] = '<span class="badge badge-primary">'.$status.'</div>';
                }
                elseif($status == "Charge Back")
                {
                    $data['status'] = '<span class="badge badge-dark">'.$status.'</div>';
                }
                else
                {
                    $data['status'] = '-';
                }

                $data['total'] = $currency.' '.number_format($post->total,2);
                $data['date_added'] = date('Y-m-d',strtotime($post->date_added));

                if ($post->payment_code == "worldpayhp")
                {
                    $data['payment_type'] = "World Pay";
                }
                elseif ($post->payment_code == "ccod")
                {
                    $data['payment_type'] = "Chip & Pin";
                }
                elseif ($post->payment_code == "pp_express")
                {
                    $data['payment_type'] = "PayPal";
                }
                elseif ($post->payment_code == "cod")
                {
                    $data['payment_type'] = "Cash";
                }
                elseif ($post->payment_code == "myfoodbasketpayments_gateway")
                {
                    $data['payment_type'] = "Paid by Card";
                }
                else
                {
                    $data['payment_type'] = $post->payment_code;
                }

                if(check_user_role(42) == 1)
                {
                    $data['action'] = '<a href="'. $edit_url .'" class="btn btn-sm btn-primary"><i class="fa fa-eye text-white"></i><a>';
                }
                else
                {
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
        if (check_user_role(42) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Get Order Details By Order ID
        $orders = Orders::with(['hasOneOrderStatus','hasOneCustomerGroupDescription','hasOneCountry','hasOneRegion','hasOneCurrency'])->where('order_id', '=', $id)->first();

        // Get All Status
        $orderstatus = OrderStatus::all();

        // Get Totals By Order ID
        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->orderBy('order_total_id','DESC')->get();

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
        if (check_user_role(38) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }

        if($user_group_id == 1)
        {
            // Get All Stores
            $data['stores'] = Store::get();
        }
        else
        {
            $user_shop_id = $user_details['user_shop'];
            $data['stores'] = Store::where('store_id',$user_shop_id)->get();
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
        $order = Orders::where('order_id',$orderID)->first();
        $html = '';

        if(!empty($order) || $order!= '')
        {
            if($order->invoice_no == 0 || $order->invoice_no == '')
            {
                $query = Orders::max('invoice_no');
                if(!empty($query) || $query != '')
                {
                    $invoice_no = $query + 1;
                    $html .= $order->invoice_prefix.''.$invoice_no;
                }
                else
                {
                    $invoice_no = 1;
                    $html .= $order->invoice_prefix.''.$invoice_no;
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
        // Validation
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'payment_firstname' => 'required',
            'payment_lastname' => 'required',
            'payment_region_id' => 'required',
            'payment_country_id' => 'required',
            'payment_city' => 'required',
            'payment_address_1' => 'required',
            'shipping_firstname' => 'required',
            'shipping_lastname' => 'required',
            'shipping_region_id' => 'required',
            'shipping_country_id' => 'required',
            'shipping_city' => 'required',
            'shipping_address_1' => 'required',
            'storename' => 'required',
        ]);

        // Insert New Order
        $neworder = new Orders;
        $neworder->store_id                = isset($request->storename) ? $request->storename : "0";
        $neworder->invoice_prefix          = "INV-2013-00";
        $neworder->store_name              = isset($request->store_name) ? $request->store_name : "";
        $neworder->firstname               = $request->firstname;
        $neworder->lastname                = $request->lastname;
        $neworder->email                   = $request->email;
        $neworder->telephone               = $request->phone;
        $neworder->fax                     = isset($request->fax) ? $request->fax : "";
        $neworder->payment_firstname       = $request->payment_firstname;
        $neworder->payment_lastname        = $request->payment_lastname;
        $neworder->payment_company         = isset($request->payment_company) ? $request->payment_company : "";
        $neworder->payment_company_id      = isset($request->payment_company_id) ? $request->payment_company_id : "";
        // $neworder->payment_tax_id          = isset($request->firstname) ? $request->firstname : "";
        $neworder->payment_address_1       = $request->payment_address_1;
        $neworder->payment_address_2       = isset($request->payment_address_2) ? $request->payment_address_2 : "";
        $neworder->payment_city            = isset($request->payment_city) ? $request->payment_city : "";
        $neworder->payment_postcode        = isset($request->payment_postcode) ? $request->payment_postcode : "";
        $neworder->payment_country         = $request->payment_country_id;
        // $neworder->payment_country      = isset($request->payment_region_id) ? $request->pcountry : "";
        // $neworder->payment_zone            = $request->payment_region_id;
        $neworder->payment_zone_id         = $request->payment_region_id;
        // $neworder->payment_address_format  = isset($request->firstname) ? $request->firstname : "";
        // $neworder->payment_method          = isset($request->firstname) ? $request->firstname : "";
        $neworder->shipping_firstname      = $request->shipping_firstname;
        $neworder->shipping_lastname       = $request->shipping_lastname;
        $neworder->shipping_company        = isset($request->shipping_company) ? $request->shipping_company : "";
        $neworder->shipping_address_1      = $request->shipping_address_1;
        $neworder->shipping_address_2      = isset($request->shipping_address_2) ? $request->shipping_address_2 : "";
        $neworder->shipping_city           = $request->shipping_city;
        $neworder->shipping_postcode       = isset($request->shipping_postcode) ? $request->shipping_postcode : "";
        $neworder->shipping_country        = $request->shipping_country_id;
        $neworder->shipping_country_id     = isset($request->shipping_country_id) ? $request->shipping_country_id : "";
        // $neworder->shipping_zone           = isset($request->firstname) ? $request->firstname : "";
        $neworder->shipping_zone_id        = $request->shipping_region_id;
        // $neworder->shipping_address_format = isset($request->firstname) ? $request->firstname : "";
        // $neworder->shipping_method         = isset($request->firstname) ? $request->firstname : "";
        // $neworder->shipping_code           = isset($request->firstname) ? $request->firstname : "";
        // $neworder->comment                 = isset($request->comment) ? $request->comment : "";
        // $neworder->total                   = isset($request->firstname) ? $request->firstname : "";
        // $neworder->order_status_id         = isset($request->firstname) ? $request->firstname : "";
        // $neworder->message                 = isset($request->firstname) ? $request->firstname : "";
        // $neworder->affiliate_id            = isset($request->affiliate) ? $request->affiliate : "";
        // $neworder->commission           = isset($request->firstname) ? $request->firstname : "";
        // $neworder->language_id          = isset($request->firstname) ? $request->firstname : "";
        // $neworder->currency_id          = isset($request->firstname) ? $request->firstname : "";
        // $neworder->currency_code        = isset($request->firstname) ? $request->firstname : "";
        // $neworder->currency_value       = isset($request->firstname) ? $request->firstname : "";

        $neworder->date_added = date("Y-m-d h:i:s");
        $neworder->date_modified = date("Y-m-d h:i:s");
        $neworder->save();
        // return redirect()->route('orders');
        echo '<pre>';
        print_r($neworder->toArray());
        exit();

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
        if($orderhisins->notify == 1)
        {
            $data['cust_mail'] = $order->email;
            $data['cust_name'] = $order->firstname.' '.$order->lastname;
            $data['order_id'] = $order->order_id;
            $data['pay_method'] = $order->payment_method;
            $data['store_name'] = $order->store_name;

            $status = OrderStatus::select('name')->where('order_status_id',$request->order_status_id)->first();
            $logo = Settings::where('key','polianna_main_logo')->where('store_id',$order->store_id)->first();
            $store_mail = Settings::where('key','config_email')->where('store_id',$order->store_id)->first();
            $store_addr = Settings::where('key','config_address')->where('store_id',$order->store_id)->first();
            $store_tele = Settings::where('key','config_telephone')->where('store_id',$order->store_id)->first();

            $data['status_code'] = isset($status->name) ? $status->name : '';
            $data['store_logo'] = isset($logo->value) ? $logo->value : '';
            $data['storeMail'] = isset($store_mail->value) ? $store_mail->value : '';
            $data['storeAddr'] = isset($store_addr->value) ? $store_addr->value : '';
            $data['storePhone'] = isset($store_tele->value) ? $store_tele->value : '';

            \Mail::send('admin.mail_format.orderstatus', ['data' => $data],
            function ($message) use ($data)
            {
                $message->from('hasankaradiya1626@gmail.com');
                $message->to($data['cust_mail']);
                $message->subject('Order Status');
            });

        }

        $html = '';

        // Get Total Order History By Order ID
        $ordershistory = OrderHistory::with(['oneOrderHistoryStatus'])->where('order_id', $request->order_id)->get();

        foreach ($ordershistory as $key => $value)
        {
            $html .= '<tr>';
            $html .= '<td>'.$value->date_added.'</td>';
            $html .= '<td>'.$value->comment.'</td>';
            $html .= '<td>'.$value->oneOrderHistoryStatus->name.'</td>';
            $html .= '<td>'.$value->notify.'</td>';
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
        if (check_user_role(41) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $ids = $request->id;

        if (count($ids) > 0)
        {
            // Delete Orders
            Orders::whereIn('order_id', $ids)->delete();

            // Delete Order Cart
            OrderCart::whereIn('order_id',$ids)->delete();

            // Delete Order History
            OrderHistory::whereIn('order_id',$ids)->delete();

            // Delete Orders Products
            OrderProduct::whereIn('order_id',$ids)->delete();

            // Delete Orders Total
            OrderTotal::whereIn('order_id',$ids)->delete();
        }

        return response()->json([
            'success' => 1,
        ]);

        return view('admin.order.list');
    }





    // Function for Print Invoice
    public function invoice($id)
    {

        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();

        $productorders = OrderProduct::where('oc_order_product.order_id', '=', $id)->get();

        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->get();

        return view('admin.order.invoice', ["orders" => $orders, 'productorders' => $productorders, 'ordertotal' => $ordertotal]);
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
            $html .= '<td class="right">' . number_format($order->total,2)  . '</td>';
            $html .= '</tr>';
        }

        return response()->json($html);
    }





    // Function for Get Customer By Searching Customer Name
    public function autocomplete(Request $request)
    {
        $user_details = user_details();

        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }

        if($user_group_id == 1)
        {
            $res = Customer::where('firstname', 'LIKE', "%{$request->term}%")->orWhere('lastname','LIKE', "%{$request->term}%")->get();
        }
        else
        {
            $user_shop_id = $user_details['user_shop'];
            $res = Customer::where('firstname', 'LIKE', "%{$request->term}%")->where('store_id',$user_shop_id)->get();
        }
        return response()->json($res);
    }





    // Function For Get Product By Searching Product Name
    public function autocompleteproduct(Request $request)
    {
        $user_details = user_details();

        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }

        if($user_group_id == 1)
        {
            $pro = ProductDescription::where("name", "LIKE", "%{$request->product}%")->get();
        }
        else
        {
            $user_shop_id = $user_details['user_shop'];
            $pro = ProductDescription::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore',function($q) use($user_shop_id)
            {
                $q->where('store_id',$user_shop_id);
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
        foreach ($addresses as $address)
        {
            $html .= '<option value="'.$address->address_id.'">'.$address->address_1.', '.$address->city.'</option>';
        }
        return response()->json($html);
    }





    // Function for Get Payment & Shipping Address By Customer Address ID
    public function payment_and_shipping_address($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }



}
