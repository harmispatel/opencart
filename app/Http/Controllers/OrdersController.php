<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerGroupDescription;
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
    // View Order List
    public function index()
    {
        return view('admin.order.list');
    }





    // Function of Get Orders By Current Store
    public function getorders(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $columns = array(
            0 =>'order_id',
            1 =>'order_id',
            4 =>'firstname',
            2 => 'flag_post_code',
            7 => 'date_added',
        );

        // Get Orders
        $totalData = Orders::with(['hasOneOrderStatus','hasOneStore'])->whereHas('hasOneStore', function ($query) use ($current_store_id){
            $query->where('store_id',$current_store_id);
        })->count();

        $totalFiltered = $totalData;
        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(!empty($request->input('search.value')))
        {
            $search = $request->input('search.value');

            $posts =  Orders::with(['hasOneOrderStatus','hasOneStore'])->where(function ($query) use ($search){
                $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
            })->whereHas('hasOneStore', function ($query) use ($current_store_id){
                $query->where('store_id',$current_store_id);
            })->offset($start)->orderBy($order,$dir)->limit($limit)->get();


            $totalFiltered = Orders::with(['hasOneStore'])->where(function ($query) use ($search){
                $query->where('order_id','LIKE',"%{$search}%")->orWhere('firstname','LIKE',"%{$search}%")->orWhere('lastname','LIKE',"%{$search}%")->orWhere('flag_post_code','LIKE',"%{$search}%")->orWhere('date_added','LIKE',"%{$search}%");
            })->whereHas('hasOneStore', function ($query) use ($current_store_id){
                $query->where('store_id',$current_store_id);
            })->offset($start)->orderBy($order,$dir)->limit($limit)->count();
        }
        else
        {
            $posts = Orders::with(['hasOneOrderStatus','hasOneStore'])->whereHas('hasOneStore', function ($query) use ($current_store_id){
                $query->where('store_id',$current_store_id);
            })->offset($start)->limit($limit)->orderBy($order,$dir)->get();

            // echo '<pre>';
            // print_r($posts);
            // exit();
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

                $data['total'] = number_format($post->total,2);
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

                $data['action'] = '<a href="'. $edit_url .'" class="btn btn-sm btn-primary"><i class="fa fa-eye text-white"></i><a>';

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





    // View order
    public function vieworder($id)
    {
        // Get Order Details By Order ID
        $orders = Orders::with(['hasOneOrderStatus','hasOneCustomerGroupDescription','hasOneCountry','hasOneRegion'])->where('order_id', '=', $id)->first();

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

    public function ordersinsert()
    {
        // Get All Stores
        $data['stores'] = Store::get();

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


    // Add new order
    public function addneworders(Request $request)
    {
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
        ]);

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


    // Order History Insert
    public function orderhistoryinsert(Request $request)
    {
        $orderhisins = new OrderHistory;
        $orderhisins->order_status_id = $request->order_status_id;
        $orderhisins->order_id = $request->order_id;
        $orderhisins->notify  = isset($request->notify) ? $request->notify : "0";
        $orderhisins->comment = isset($request->comment) ? $request->comment : "";

        $orderhisins->date_added = date("Y-m-d h:i:s");
        $orderhisins->save();

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

    public function deleteorder(Request $request)
    {
        $ids = $request->id;
        // echo '<pre>';
        // print_r($request->id);
        // exit();
        if (count($ids) > 0) {
            Orders::whereIn('order_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
        return view('admin.order.list');
    }





    // Print Orders Invoice
    public function invoice($id)
    {

        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();

        $productorders = OrderProduct::where('oc_order_product.order_id', '=', $id)->get();

        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->get();

        return view('admin.order.invoice', ["orders" => $orders, 'productorders' => $productorders, 'ordertotal' => $ordertotal]);
    }






    public function shipping($id)
    {
        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();
        return view('admin.order.shippinglist', ["orders" => $orders]);
    }






    public function returns()
    {
        $returns = OrderReturn::join('oc_return', 'oc_return_status.return_status_id', '=', 'oc_return.return_status_id')->get();
        return view('admin.order.returns', ['returns' => $returns]);
    }






    public function addnewreturns()
    {
        $return = OrderReturn::get();
        $returnaction = ReturnAction::get();
        $returnreason = ReturnReason::get();
        $customers = Customer::get();
        $orderproduct = OrderProduct::get();
        return view('admin.order.addnewreturns', ['return' => $return, 'returnaction' => $returnaction, 'returnreason' => $returnreason, 'customers' => $customers, 'orderproduct' => $orderproduct]);
    }





    public function returnform(Request $request)
    {

        $request->validate([
            'order_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'product' => 'required',
            'model' => 'required',
        ]);

        $product = OrderProduct::where('order_product_id', $request->product)->first();
        $productname = $product->name;

        $proreturn = new ReturnProduct;
        $proreturn->order_id = $request->order_id;
        $proreturn->product_id = $request->product;
        $proreturn->customer_id = $request->customer_id;
        $proreturn->date_ordered = $request->date_ordered;
        $proreturn->return_status_id = $request->return_status_id;
        $proreturn->firstname = $request->firstname;
        $proreturn->lastname = $request->lastname;
        $proreturn->email = $request->email;
        $proreturn->telephone = $request->telephone;
        $proreturn->product = $productname;
        $proreturn->model = $request->model;
        $proreturn->quantity                        = isset($request->quantity) ? $request->quantity : 0;
        $proreturn->opened = $request->opened;
        $proreturn->comment                         = isset($request->comment) ? $request->comment : '';
        $proreturn->return_reason_id = $request->return_reason_id;
        $proreturn->return_action_id = $request->return_action_id;

        $proreturn->date_added = date("Y-m-d h:i:s");
        $proreturn->date_modified = date("Y-m-d h:i:s");
        $proreturn->save();

        $errors = "Insert success";

        return redirect()->route('returns')->withErrors($errors);
    }






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
        // @foreach ($ordertotal as $total)
        // <tbody id="totals">
        //     <tr>
        //         <td colspan="4" class="right">{{ $total->code }}</td>
        //         <td class="right">{{ $total->text }}</td>
        //     </tr>
        // </tbody>
        // @endforeach

        return response()->json($html);
    }





    // Get Customer By Search
    public function autocomplete(Request $request)
    {
        $res = Customer::where('firstname', 'LIKE', "%{$request->term}%")->orWhere('lastname','LIKE', "%{$request->term}%")->get();
        return response()->json($res);
    }






    public function autocompleteproduct(Request $request)
    {

        $pro = ProductDescription::where("name", "LIKE", '%' . $request->product . '%')
            ->get();

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






    // Get Payment & Shipping Address By Customer Address ID
    public function payment_and_shipping_address($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }
}
