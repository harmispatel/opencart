<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\OrderTotal;
use App\Models\Settings;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class NewOrderController extends Controller
{

    // function For New Order List
    public function index()
    {
        // Check User Permission
        if (check_user_role(44) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        if(session()->has('range'))
        {

        }
        else
        {
            session()->put('range','day');
        }

        return view('admin.neworders.list');
    }

    // function For Get Orders Details
    public function getallorderdetails(Request $request)
    {
        $currentRange = $request->currentRange;
        $start_date = isset($request->start_date) ? $request->start_date : '';
        $end_date = isset($request->end_date) ? $request->end_date : '';
        $date_type = isset($request->date_type) ? $request->date_type : '';

        session()->put('range',$currentRange);


        if(empty($start_date) && empty($end_date))
        {
            // Get All Details
            $all_details = getorderdetails($currentRange,'');

            if($currentRange == 'day')
            {
                $startDate = date('00:00 d-m-Y');
                $endDate = date('23:59 d-m-Y');
            }
            elseif($currentRange == 'week'){

                $monday =  strtotime("monday this week");
                $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
                $startDate = date("00:00 d-m-Y",$monday);
                $endDate = date("23:59 d-m-Y",$sunday);
            }
            elseif($currentRange == 'month'){
                // Start Date of This Month
                $startDate = date('00:00 01-m-Y'); // hard-coded '01' for first day
                // End Date of this Month
                $endDate  = date('23:59 t-m-Y');
            }
            elseif($currentRange == 'year'){
                // First Day Of Current Year
                $this_year_ini = new DateTime('first day of January this year');
                // Last Day Of Current Year
                $this_year_end_ini = new DateTime('last day of December this year');

                $startDate = $this_year_ini->format('00:00 d-m-Y');
                $endDate = $this_year_end_ini->format('23:59 d-m-Y');
            }
        }
        else
        {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['date_type'] = $date_type;

            $all_details = getorderdetails($currentRange,$data);

            $startDate = isset($all_details['startDate']) ? $all_details['startDate'] : '';
            $endDate = isset($all_details['endDate']) ? $all_details['endDate'] : '';
        }


        // All Orders
        $orders = isset($all_details['orders']) ? $all_details['orders'] : '';


        // Total of All Orders
        $total = isset($all_details['total']) ? number_format($all_details['total'],2) : 0.00;

        // Total of Delivery Orders
        $delivery_orders_total =  isset($all_details['delivery_total']) ? number_format($all_details['delivery_total'],2) : 0.00;

        // Total of Collection Orders
        $collection_orders_total =  isset($all_details['collection_total']) ? number_format($all_details['collection_total'],2) : 0.00;

        // Total of Customers Orders
        $total_of_customer_orders =  isset($all_details['customer_total']) ? number_format($all_details['customer_total'],2) : 0.00;

        // Total of Guest Customers Orders
        $total_of_guest_customer_orders =  isset($all_details['guest_customer_total']) ? number_format($all_details['guest_customer_total'],2) : 0.00;

        // Total Deliver Orders
        $total_deliver_orders =  isset($all_details['delivery_count']) ? $all_details['delivery_count'] : 0;

        // Total Collection Orders
        $total_collection_orders =  isset($all_details['collection_count']) ? $all_details['collection_count'] : 0;

        // Total Accepted Orders
        $total_accepted_orders =  isset($all_details['accepted_order']) ? $all_details['accepted_order'] : 0;

        // Total Customer Orders
        $total_customer_orders =  isset($all_details['customer_count']) ? $all_details['customer_count'] : 0;

        // Total Guest Customer Orders
        $total_guest_customer_orders =  isset($all_details['guest_customer_count']) ? $all_details['guest_customer_count'] : 0;

        $html ='';
        $table ='';

        $total_products = 0;

        foreach($orders as $order)
        {
            $products = OrderProduct::where('order_id',$order['order_id'])->count();
            $total_products += $products;
            $table .='<tr>';
            $table .='<td><input type="checkbox" name="checkall" class="delall"
            value="'.$order['order_id'].'"></td>';

            if ($order['shipping_method'] == 'collection')
            {
                $table .='<td><i class="fa fa-shopping-basket"></i></td>';
            }
            else
            {
                $table .='<td><i class="fa fa-motorcycle"></i></td>';
            }

            $table .='<td>'.$order['order_id'].'</td>';
            $table .='<td>'.$order['store_name'].'</td>';
            $table .='<td>'.$order['firstname'].'</td>';
            $table .='<td>'.number_format($order['total'], 2).'</td>';
            $table .='<td>'.$order['date_added'].'</td>';

            if($order['order_status_id'] == 15)
            {
                $table .='<td><i class="fa fa-check-circle" title="Accepted"
                style="color:#14bd07;"></td>';
            }
            elseif ($order['order_status_id'] == 5)
            {
                $table .='<td><i class="fa fa-thumbs-up" title="Complete"
                style="color:#51a351;"></i></td>';
            }
            elseif ($order['order_status_id'] == 2)
            {
                $table .='<td><i class="fa fa-hourglass-start" title="Processing"
                style="color:gray;"></i></td>';
            }
            elseif ($order['order_status_id'] == 7)
            {
                $table .='<td><i class="fa fa-times-circle" title="Rejected"
                style="color:#d00300;"></i></td>';
            }
            elseif ($order['order_status_id'] == 11)
            {
                $table .='<td><i class="fa fa-check" title="Refunded"
                style="color:#49afcd;"></i></td>';
            }
            elseif ($order['order_status_id'] == 1)
            {
                $table .='<td><i class="fa fa-search" title="Missing Orders"
                style="color:#858585;"></i></td>';
            }
            $table .='<td><i class="fa fa-print" onclick="getOrderReceipt('.$order['order_id'].')" style="color:blue;cursor:pointer"></i></td>';

            $view_order_route = route('vieworder',$order['order_id']);

            $table .='<td><i class="fa fa-mobile"></i></td>';
            $table .='<td><a target="_blank" href="'.$view_order_route.'"><i class="fa fa-reply" style="color:blue;cursor:pointer;"></a></td>';
            $table .='</tr>';
        }

        // cart 1
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="d-flex justify-content-between box-title">';
                        $html .='<h3 style="color: #2c9ea9"> £ '.$total.'</h3>';
                        $html .='<i class="fa fa-chart-area"></i>';
                    $html .='</div>';
                    $html .='<div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Delivery: £ '.$delivery_orders_total;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Cash Order: £ '.$total;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Collection: £ '.$collection_orders_total;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Card Order:£ 0.00';
                            $html .='</p>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='Total Sales';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 0.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';

        //cart 2
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="d-flex justify-content-between box-title">';
                        $html .='<h3 style="color: #2c9ea9"> £ '.$total_accepted_orders.'</h3>';
                        $html .='<i class="fa fa-shopping-basket"></i>';
                    $html .='</div>';
                    $html .='<div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Delivery: £ '.$total_deliver_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Cash Order: £ '.$total_accepted_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Collection: £ '.$total_collection_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Card Order:£ 0.00';
                            $html .='</p>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='Number of Sales';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 0.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';

        //cart 3
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="d-flex justify-content-between box-title">';
                        $html .='<h3 style="color: #2c9ea9">'.$total_products.'</h3>';
                        $html .='<i class="fa fa-tags"></i>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-8">';
                            $html .='Number of Sold Items';
                        $html .='</div>';
                        $html .='<div class="col-md-4">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 0.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';

        // card 4
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='customer: £ '.$total_of_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='No of orders: £ '.$total_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='guest user: £ '.$total_of_guest_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='No of orders:£ '.$total_guest_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='Top '.$total_customer_orders.' Customer';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 100.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';


        return response()->json([
            'success' => 1,
            'card' =>  $html,
            'table_data' =>  $table,
            'startDate' =>  $startDate,
            'endDate' =>  $endDate,
        ]);


    }


    // Order Receipt By Order ID
    public function getReceiptByOrderID(Request $request)
    {
        $order_id = $request->order_id;

        $order_details = Orders::where('order_id',$order_id)->first();

        $order_products = OrderProduct::where('order_id',$order_id)->get();

        $store_id = isset($order_details['store_id']) ? $order_details['store_id'] : '';

        $coupon_name = 'Coupon';

        if(!empty($store_id))
        {
            $data = ([
                'config_name',
                'config_address',
                'config_telephone',
            ]);

            $total_data = ([
                'total',
                'credit',
                'delivery',
                'sub_total',
                'coupon',
            ]);

            foreach($data as $key)
            {
                // Store Details
                $store_details = Settings::select('value')->where('store_id',$store_id)->where('group','config')->where('key',$key)->first();
                $store_array[$key] = isset($store_details['value']) ? $store_details['value'] : '';
            }

            if(isset($store_array) && count($store_array) > 0)
            {
                $store_name = isset($store_array['config_name']) ? $store_array['config_name'] : '';
                $store_address = isset($store_array['config_address']) ? $store_array['config_address'] : '';
                $store_telephone = isset($store_array['config_telephone']) ? $store_array['config_telephone'] : '';
            }
            else
            {
                $store_name = '';
                $store_address = '';
                $store_telephone = '';
            }

            foreach($total_data as $tdata)
            {
                // Totals Details
                $total_details = OrderTotal::select('value','title')->where('order_id',$order_id)->where('code',$tdata)->first();
                $total_array[$tdata] = isset($total_details['value']) ? $total_details['value'] : '';
                if($tdata == 'coupon')
                {
                    $coupon_name = isset($total_details['title']) ? $total_details['title'] : 'Coupon';
                }
            }

            if(isset($total_array) && count($total_array) > 0)
            {
                $total = isset($total_array['total']) ? $total_array['total'] : 0;
                $service_charge = isset($total_array['credit']) ? $total_array['credit'] : 0;
                $delivery = isset($total_array['delivery']) ? $total_array['delivery'] : 0;
                $sub_total = isset($total_array['sub_total']) ? $total_array['sub_total'] : 0;
                $coupon = isset($total_array['coupon']) ? $total_array['coupon'] : 0;
            }
            else
            {
                $total = 0;
                $service_charge = 0;
                $delivery = 0;
                $sub_total = 0;
                $coupon = 0;
            }


        }
        else
        {
            $store_name = '';
            $store_address = '';
            $store_telephone = '';

            $total = 0;
            $service_charge = 0.00;
            $delivery = 0;
            $sub_total = 0;
            $coupon = 0;
        }

        $invoice_no = isset($order_details['invoice_no']) ? $order_details['invoice_no'] : '';
        $invoice_prefix = isset($order_details['invoice_prefix']) ? $order_details['invoice_prefix'].$invoice_no : '';
        $shipping_firstname = isset($order_details['shipping_firstname']) ? $order_details['shipping_firstname'] : '';
        $shipping_lastname = isset($order_details['shipping_lastname']) ? $order_details['shipping_lastname'] : '';
        $email = isset($order_details['email']) ? $order_details['email'] : '';
        $shipping_telephone = isset($order_details['telephone']) ? $order_details['telephone'] : '';
        $shipping_address_1 = isset($order_details['shipping_address_1']) ? $order_details['shipping_address_1'] : '';
        $shipping_address_2 = isset($order_details['shipping_address_2']) ? $order_details['shipping_address_2'] : '';
        $shipping_city = isset($order_details['shipping_city']) ? $order_details['shipping_city'] : '';
        $shipping_company = isset($order_details['shipping_company']) ? $order_details['shipping_company'] : '';
        $shipping_postcode = isset($order_details['shipping_postcode']) ? $order_details['shipping_postcode'] : '';
        $payment_method = isset($order_details['payment_method']) ? $order_details['payment_method'] : '';
        $shipping_method = isset($order_details['shipping_method']) ? $order_details['shipping_method'] : '';
        $date_added = isset($order_details['date_added']) ? $order_details['date_added'] : '';
        $flag_post_code = isset($order_details['flag_post_code']) ? $order_details['flag_post_code'] : '';
        $html = '';

        $html .= '<div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $html .= '<h1 class="text-center">'.$store_name.'</h1>';
            $html .= '<address class="text-center" style="margin-bottom:0rem!important;">'.$store_address.'</br>'.$store_telephone.'</address>';
            $html .= '<h4 class="text-center">'.strtoupper($flag_post_code).'</h4>';
            $html .= '<div class="container mt-2">';

                $html .= '<div class="row">';
                    $html .= '<div class="col-md-4">'.date('d-m-Y',strtotime($date_added)).'</div>';
                    $html .= '<div class="col-md-4 text-center">'.$invoice_prefix.'</div>';
                    $html .= '<div class="col-md-4 text-right">Order ID : '.$order_id.'</div>';
                $html .='</div>';
                $html .= '<hr style="background:black!important; height:2px;">';

                if(isset($order_products) && count($order_products) > 0)
                {
                    $total_order = count($order_products) - 1;
                    foreach($order_products as $key => $product)
                    {
                        $quantity = isset($product->quantity) ? $product->quantity : '';
                        $name = isset($product->name) ? $product->name : '';
                        $price = isset($product->price) ? $product->price : "";
                        $final_price = ($price * $quantity);

                        $html .= '<div class="row p-0 m-0">';
                            $html .= '<div class="col-md-1">'.$quantity.'</div>';

                            $html .= '<div class="col-md-8">'.$name;

                                if(isset($product->toppings) && !empty($product->toppings))
                                {
                                    // $html .= '</br>';
                                    $html .= $product->toppings;
                                    $html .= '</div>';
                                }
                                else
                                {
                                    $html .= '</div>';
                                }

                            $html .= '<div class="col-md-3 text-right">£ '.number_format($final_price,2).'</div>';
                        $html .='</div>';

                        if($key == $total_order)
                        {
                            $html .= '<hr style="background:black!important; height:2px;">';
                        }
                        else
                        {
                            $html .= '<hr style="margin-top:2px!important;margin-bottom:2px!important;">';
                        }

                    }
                }

                $html .= '<div class="row">';
                    $html .= '<div class="col-md-4"></div>';
                    $html .= '<div class="col-md-8">';
                        $html .= '<table class="table" width="100%">';

                            $html .= '<tr>';
                                $html .= '<th>Sub Total</th>';
                                if($sub_total == 0 || $sub_total == '')
                                {
                                    $html .= '<td>£ 0.00</td>';
                                }
                                else
                                {
                                    $html .= '<td>£ '.number_format($sub_total,2).'</td>';
                                }
                            $html .= '</tr>';

                            $html .= '<tr>';
                                $html .= '<th>Service Charge</th>';
                                if($service_charge == 0 || $service_charge == '')
                                {
                                    $html .= '<td>£ 0.00</td>';
                                }
                                else
                                {
                                    $html .= '<td>£ '.number_format($service_charge,2).'</td>';
                                }
                            $html .= '</tr>';

                            $html .= '<tr>';
                                $html .= '<th>Delivery Charge</th>';
                                if($delivery == 0 || $delivery == '')
                                {
                                    $html .= '<td>£ 0.00</td>';
                                }
                                else
                                {
                                    $html .= '<td>£ '.number_format($delivery,2).'</td>';
                                }
                            $html .= '</tr>';

                            $html .= '<tr>';
                                $html .= '<th>'.$coupon_name.'</th>';
                                if($coupon == 0 || $coupon == '')
                                {
                                    $html .= '<td>£ - 0.00 </td>';
                                }
                                else
                                {
                                    $html .= '<td>£ '.number_format($coupon,2).'</td>';
                                }
                            $html .= '</tr>';

                            $html .= '<tr>';
                                $html .= '<th>Total</th>';
                                $html .= '<td>£ '.number_format($total,2).'</td>';
                            $html .= '</tr>';

                        $html .= '</table>';
                    $html .= '</div>';
                $html .='</div>';


                $html .= '<div class="row mt-4">';
                    $html .= '<div class="col-md-12 text-center">';
                        $html .= '<h4>'.strtoupper($payment_method).'</h4>';
                        $html .= '<pre>';
                            $html .= $shipping_firstname.' '.$shipping_lastname.'</br>';
                            if(!empty($shipping_company))
                            {
                                $html .= $shipping_company.',</br>';
                            }
                            if(!empty($shipping_address_1))
                            {
                                $html .= $shipping_address_1.',</br>';
                            }
                            if(!empty($shipping_address_2))
                            {
                                $html .= $shipping_address_2.',</br>';
                            }
                            if(!empty($shipping_city))
                            {
                                $html .= $shipping_city.' - ';
                            }
                            if(!empty($shipping_postcode))
                            {
                                $html .= $shipping_postcode.'</br>';
                            }
                            if(!empty($shipping_telephone))
                            {
                                $html .= $shipping_telephone.'</br>';
                            }
                            if(!empty($email))
                            {
                                $html .= $email;
                            }
                        $html .= '</pre>';
                    $html .= '</div>';

                    $print_route = route('invoice',$order_id);

                    $html .= '<div class="col-md-12 text-right">';
                        $html .= '<a target="_blank" href="'.$print_route.'" class="btn btn-dark">Print &nbsp;<i class="fa fa-print"></i></a>';
                    $html .= '</div>';
                $html .= '</div>';


            $html .='</div>';
        $html .='</div>';

        // <div class="modal-header">
        //           <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        //           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        //             <span aria-hidden="true">&times;</span>
        //           </button>
        //         </div>
        //         <div class="modal-body">
        //         </div>

        return response()->json([
            'success'=>1,
            'result'=>$html
        ]);

    }


    // Get Order List By Year
    public function getOrderListByYear(Request $request)
    {
        $currentRange = $request->currentRange;
        $start_d = isset($request->start_date) ? $request->start_date : '';
        $end_d = isset($request->end_date) ? $request->end_date : '';
        $date_type = isset($request->date_type) ? $request->date_type : '';

        $current_store_id = currentStoreId();

        if($currentRange == 'year')
        {
            if($date_type == 'next')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("+1 year", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+1 year - 1 day", strtotime($start_date)));
            }
            elseif($date_type == 'pre')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("-1 year", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+1 year - 1 day", strtotime($start_date)));
            }

            if ($request->ajax()) {

                $orders = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,$end_date]);


                return DataTables::of($orders)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function($row){
                        $cid = isset($row->order_id) ? $row->order_id : '';
                        $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$cid.'">';
                        return $checkbox;
                    })
                    ->addColumn('type', function($row){
                        $type = '';
                        if ($row->shipping_method == 'collection')
                        {
                            return $type .='<i class="fa fa-shopping-basket"></i>';
                        }
                        else
                        {
                            return $type .='<i class="fa fa-motorcycle"></i>';
                        }
                    })
                    ->addColumn('customer_name', function($row){
                        $first_name = $row->firstname;
                        $last_name = $row->lastname;
                        $full_name = "$first_name $last_name";
                        return $full_name;
                    })
                    ->addColumn('order_total', function($row){
                        $total = number_format($row->total,2);
                        return $total;
                    })
                    ->addColumn('order_status', function($row){
                        if($row->order_status_id == 15)
                        {
                            $status = '';
                            $status .='<i class="fa fa-check-circle" title="Accepted"
                            style="color:#14bd07;">';
                            return $status;
                        }
                        elseif ($row->order_status_id == 5)
                        {
                            $status = '';
                            $status .='<i class="fa fa-thumbs-up" title="Complete"
                            style="color:#51a351;"></i>';
                            return $status;
                        }
                        elseif ($row->order_status_id == 2)
                        {
                            $status = '';
                            $status .='<i class="fa fa-hourglass-start" title="Processing"
                            style="color:gray;"></i>';
                            return $status;
                        }
                        elseif ($row->order_status_id == 7)
                        {
                            $status = '';
                            $status .='<i class="fa fa-times-circle" title="Rejected"
                            style="color:#d00300;"></i>';
                            return $status;
                        }
                        elseif ($row->order_status_id == 11)
                        {
                            $status = '';
                            $status .='<i class="fa fa-check" title="Refunded"
                            style="color:#49afcd;"></i>';
                            return $status;
                        }
                        elseif ($row->order_status_id == 1)
                        {
                            $status = '';
                            $status .='<i class="fa fa-search" title="Missing Orders"
                            style="color:#858585;"></i>';
                            return $status;
                        }
                    })
                    ->addColumn('order_print', function($row){
                        $print = '';
                        $print .= '<i class="fa fa-print"  onclick="getOrderReceipt('.$row->order_id.')" style="color:blue;cursor:pointer"></i>';
                        return $print;
                    })
                    ->addColumn('order_sms', function($row){
                        $sms = '';
                        $sms .= '<i class="fa fa-mobile"></i>';
                        return $sms;
                    })
                    ->addColumn('order_reply', function($row){
                        $view_order_route = route('vieworder',$row->order_id);
                        $reply = '';
                        $reply .= '<a target="_blank" href="'.$view_order_route.'"><i class="fa fa-reply" style="color:blue;cursor:pointer;"></a>';
                        return $reply;
                    })
                    ->rawColumns(['checkbox','type','customer_name','order_total','order_status','order_print','order_sms','order_reply'])
                    ->make(true);
            }

        }

    }


    // Get Order Details By Selected Year
    public function getallorderdetailsbyYear(Request $request)
    {
        $currentRange = $request->currentRange;
        $start_d = isset($request->start_date) ? $request->start_date : '';
        $end_d = isset($request->end_date) ? $request->end_date : '';
        $date_type = isset($request->date_type) ? $request->date_type : '';

        $current_store_id = currentStoreId();

        if($currentRange == 'year')
        {
            if($date_type == 'next')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("+1 year", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+1 year - 1 day", strtotime($start_date)));
            }
            elseif($date_type == 'pre')
            {
                // Start Date
                $start_date = date('Y-m-d 00:00:00', strtotime("-1 year", strtotime($start_d)));
                // End Date
                $end_date = date('Y-m-d 23:59:00', strtotime("+1 year - 1 day", strtotime($start_date)));
            }

            // Total Accepted Orders
            $accepted_order = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->count();

            // Order Total
            $total = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->sum('total');

            // Total Collections Order
            $collection_count = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('flag_post_code','collection')->count();

            // Total of Collection Orders
            $collection_total = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('flag_post_code','collection')->sum('total');

            // Total Delivery Order
            $delivery_count = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('flag_post_code','delivery')->count();

            // Total of Delivery Orders
            $delivery_total = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('flag_post_code','delivery')->sum('total');

            // Total Guest Customers
            $guest_customer_count = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('customer_group_id',0)->count();

            // Total of Guest Customers
            $guest_customer_total = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('customer_group_id',0)->sum('total');

            // Total Customers
            $customer_count = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('customer_group_id',1)->count();

            // Total of Customers
            $customer_total = Orders::where('store_id',$current_store_id)->whereBetween('date_added', [$start_date,  $end_date])->where('customer_group_id',1)->sum('total');

            // Return Start Date
            $startDate = date('00:00 d-m-Y',strtotime($start_date));
            $endDate = date('23:59 d-m-Y',strtotime($end_date));

        }

        // Total of All Orders
        $total = isset($total) ? number_format($total,2) : 0.00;

        // Total of Delivery Orders
        $delivery_orders_total =  isset($delivery_total) ? number_format($delivery_total,2) : 0.00;

        // Total of Collection Orders
        $collection_orders_total =  isset($collection_total) ? number_format($collection_total,2) : 0.00;

        // Total of Customers Orders
        $total_of_customer_orders =  isset($customer_total) ? number_format($customer_total,2) : 0.00;

        // Total of Guest Customers Orders
        $total_of_guest_customer_orders =  isset($guest_customer_total) ? number_format($guest_customer_total,2) : 0.00;

        // Total Deliver Orders
        $total_deliver_orders =  isset($delivery_count) ? $delivery_count : 0;

        // Total Collection Orders
        $total_collection_orders =  isset($collection_count) ? $collection_count : 0;

        // Total Accepted Orders
        $total_accepted_orders =  isset($accepted_order) ? $accepted_order : 0;

        // Total Customer Orders
        $total_customer_orders =  isset($customer_count) ? $customer_count : 0;

        // Total Guest Customer Orders
        $total_guest_customer_orders =  isset($guest_customer_count) ? $guest_customer_count : 0;


        $html ='';

        // cart 1
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="d-flex justify-content-between box-title">';
                        $html .='<h3 style="color: #2c9ea9"> £ '.$total.'</h3>';
                        $html .='<i class="fa fa-chart-area"></i>';
                    $html .='</div>';
                    $html .='<div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Delivery: £ '.$delivery_orders_total;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Cash Order: £ '.$total;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Collection: £ '.$collection_orders_total;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Card Order:£ 0.00';
                            $html .='</p>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='Total Sales';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 0.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';

        //cart 2
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="d-flex justify-content-between box-title">';
                        $html .='<h3 style="color: #2c9ea9">'.$total_accepted_orders.'</h3>';
                        $html .='<i class="fa fa-shopping-basket"></i>';
                    $html .='</div>';
                    $html .='<div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Delivery: £ '.$total_deliver_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Cash Order: £ '.$total_accepted_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Collection: £ '.$total_collection_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='Card Order:£ 0.00';
                            $html .='</p>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='Number of Sales';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 0.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';

        //cart 3
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="d-flex justify-content-between box-title">';
                        $html .='<h3 style="color: #2c9ea9">0.00</h3>';
                        $html .='<i class="fa fa-tags"></i>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-8">';
                            $html .='Number of Sold Items';
                        $html .='</div>';
                        $html .='<div class="col-md-4">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 0.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';

        // card 4
        $html .='<div class="col-lg-3 col-6">';
            $html .='<div class="small-box bg-light">';
                $html .=' <div class="inner">';
                    $html .='<div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='customer: £ '.$total_of_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='No of orders: £ '.$total_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='guest user: £ '.$total_of_guest_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<p style="font-size: 12px; margin: 0">';
                                $html .='No of orders:£ '.$total_guest_customer_orders;
                            $html .='</p>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                    $html .=' <div class="row">';
                        $html .='<div class="col-md-6">';
                            $html .='Top '.$total_customer_orders.' Customer';
                        $html .='</div>';
                        $html .='<div class="col-md-6">';
                            $html .='<i class="fa fa-arrow-circle-up"></i> 100.00%';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';


        return response()->json([
            'success' => 1,
            'card' =>  $html,
            // 'table_data' =>  $table,
            'startDate' =>  $startDate,
            'endDate' =>  $endDate,
        ]);

    }


    // function For New Order Delete
    public function deleteorder(Request $request)
    {
        $ids = $request['id'];

        if (count($ids) > 0) {
            Orders::whereIn('order_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }

    // function For New orderdetail

    public function orderdetail(Request $request){
        $OrderId = $request->orderid;
        $orders = Orders::with(['hasManyOrderProduct', 'hasOneOrderStatus', 'hasManyOrderTotal','hasOneCurrency'])->where('order_id', $OrderId)->first();

       // Get Current URL
       $currentURL = URL::to("/");

       // Get Store Settings & Other Settings
       $store_data = frontStoreID($currentURL);

       // Get Current Front Store ID
       $front_store_id =  $store_data['store_id'];

       // Store Settings
       $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

       $html = '';
       $html .= '<div id="wrapper">';
       $html .=     '<div id="content" style="text-align: center;">';
       $html .=         '<div id="printthis" style="float: left; width: 100%;">';
       $html .=             '<div class="orderinfo-adress sang" style="text-align: center;">';
       $html .=                 '<div class="contact-info">';
       $html .=                     '<div class="content">';
       $html .=                         '<p class="etsAddress">' . $store_setting["config_address"] . '<br></p>Tel:' . $store_setting["config_telephone"] . '';
       $html .=                     '</div>';
       $html .=                 '</div>';
       $html .=             '</div>';
       $html .=             '<div class="orderinfo-date" style="display: flex; justify-content:space-between">';
       $html .=                 '<span> <b class="order-dates">Date:</b>' . date('d/m/Y', strtotime($orders->date_added)) . '</span>';
       $html .=                 '<span> <b class="order-id">Order ID:</b>' . $orders->order_id . '</span></b>';
       $html .=             '</div>';
       $html .=             '<h3 class="order-delivery" style="border-bottom: 2px solid #777777;  color: #777777;  float: left;  font-size: 30px;  font-weight: bold;  padding-bottom: 10px;  text-align: center;  text-transform: uppercase;  width: 100%;">' . $orders->flag_post_code . '</h3>';
       $html .=             '<table class="list list-item" style="float: left;width:100%;margin: 0;">';
       $html .=                 '<thead>';
       $html .=                     '<tr>';
       $html .=                         '<th>Qty</th>';
       $html .=                         '<th style="text-align:left;">Item</th>';
       $html .=                         '<th style="text-align:right;">price</th>';
       $html .=                     '</tr>';
       $html .=                 '</thead>';
       $html .=                 '<tbody>';
       foreach ($orders['hasManyOrderProduct'] as $value) {
           $html .= '<tr>';
           $html .=     '<td style="text-align:center; border-bottom: 1px solid rgb(221, 221, 221); padding: 7px 0;">' . $value->quantity . 'x</td>';
           $html .=     '<td style="text-align:left; border-bottom: 1px solid rgb(221, 221, 221); padding: 7px 0;"><span class="name-parent">' . $value->name . '</span><br><div class="topping_text"><span class="bg" style="display:block"></span></div></td>';
           $html .=     '<td style="text-align:right; border-bottom: 1px solid rgb(221, 221, 221); padding: 7px 0;">'.$orders->hasOneCurrency["symbol_left"].' '.number_format($value->total, 2) . '</td>';
           $html .= '</tr>';
       }
       $html .=                 '</tbody>';
       $html .=             '</table>';
       $html .=             '<div class="box-order-total" style="float: left;width: 100%;border-bottom: 1px solid #dddddd;">';
       $html .=                 '<table style="float: left;width: 100%;">';
       $html .=                     '<tbody style="float: left;width: 100%;">';
       $html .=                         '<tr style="float: left;width: 100%;">';
       $html .=                             '<td style="width: 50%;border-right: 1px solid #ddd;text-align: center;">';
       $html .=                                 '<strong>' . $orders->payment_code . '</strong>';
       $html .=                             '</td>';
       $html .=                             '<td style="width: 50%;">';
       $html .=                                 '<table>';
       $html .=                                     '<tbody>';
       foreach ($orders['hasManyOrderTotal'] as $total) {
        // echo '<pre>';
        // print_r($total);
        // exit();
           $html .= '<tr class="order-left-right" style="border-bottom: 1px dotted #ddd;  float: left;  padding: 2px 0;  width: 100%;">';
           $html .=     '<td class="left" style="float: left;"><b>' . $total->title . ':</b></td>';
           $html .=     '<td class="right" style="float: right;font-weight: normal;">' . $total->text . '</td>';
           $html .= '</tr>';
       }
       $html .=                                     '</tbody>';
       $html .=                                 '</table>';
       $html .=                             '</td>';
       $html .=                         '</tr>';
       $html .=                     '</tbody>';
       $html .=                 '</table>';
       $html .=             '</div>';
       $html .=             '<div class="delivery-to d-flex justify-content-center" style="width: 100%; display: flex; justify-content:center">';
       $html .=                 '<table class="list" style="width: 80%;margin: 20px 0">';
       $html .=                     '<tbody>';
       $html .=                         '<tr>';
       $html .=                             '<td></td>';
       $html .=                             '<td class="text-start" style="text-transform: uppercase; font-weight: 700; padding-bottom: 10px">' . ucwords($orders->firstname) . '&nbsp;' . ucwords($orders->lastname) . ' </td>';
       $html .=                             '<td></td>';
       $html .=                         '</tr>';
       if ($orders->flag_post_code == 'delivery') {
           $html .= '<tr>';
           $html .=     '<td><b>Delivery to:</b></td>';
           $html .=     '<td class="pb-2">';
           $html .=         '<div class="text-start">' . $orders->firstname . ' ' . $orders->lastname . '<br>' . $orders->payment_company . '<br>' . $orders->payment_address_1 . '<br>' . $orders->payment_address_2 . '<br>' . $orders->payment_city . '<br>' . $orders->payment_city . ' ' . $orders->payment_postcode . '<br></div>';
           $html .=     '</td>';
           $html .=     '<td></td>';
           $html .= '</tr>';
       }
       $html .=                         '<tr>';
       $html .=                             '<td><b>Telephone:</b></td>';
       $html .=                             '<td class="text-start pb-2">';
       $html .=                                 '<a href="tel:' . $orders->telephone . '">' . $orders->telephone . '</a>';
       $html .=                             '</td>';
       $html .=                             '<td></td>';
       $html .=                         '</tr>';
       $html .=                         '<tr>';
       $html .=                             '<td><b>Wanted by:</b></td>';
       $html .=                             '<td class="text-start">';
       $html .=                                 '' . $orders->timedelivery . ' </td>';
       $html .=                             '<td></td>';
       $html .=                         '</tr>';
       $html .=                     '</tbody>';
       $html .=                 '</table>';
       $html .=             '</div>';
       $html .=             '<div class="pt-3" style="float: left;width: 100%;border-top: 1px solid #ddd;margin-bottom: 0;">';
       $html .=                 '<h3 style="color: #777777;  float: left;  font-size: 24px;  font-style: italic;  margin-bottom: 15px;  text-align: center; width: 100%;">Thanks for your custom!</h3>';
       $html .=             '</div>';
       $html .=         '</div>';
       $html .=         '<div class="center" style="float: left;width: 100%;text-align: center;margin-bottom: 20px;">';
       $html .=             '<a onclick="printDiv(`printthis`)" id="Print" class="btn btn-success" href="javascript:void(0)"><i class="fa fa-print" aria-hidden="true"></i> Print</a>';
       $html .=             '<a class="getorderid btn btn-success mx-2 " href="#" class="button action-write-review" value="' . $orders->order_id . '" data-bs-toggle="modal" data-bs-target="#orderreview"><i class="far fa-comment"></i> Review</a>';
       // $html .=             '<a class="btn btn-success" href="#" class="button"><i class="fas fa-redo-alt"></i> Re-Order</a>';
       $html .=         '</div>';
       $html .=     '</div>';
       $html .= '</div>';

       return response()->json(['orders' => $html]);
    }

    // function For New filter
    public function orderfilterdetail(Request $request){
        $type =$request->type;
        $orderpayment =$request->orderpayment;
        $status =$request->status;


        $query = DB::table("oc_order");

        // type
        if (!empty($type)) {
            $query->where(function ($q) use ($type) {
                $q->where("shipping_method", $type);
            });
        }

        // orderpayment
        if(!empty($orderpayment))
        {
            $query->where(function ($q) use ($orderpayment) {
                $q->where("payment_code", [$orderpayment]);
            });
        }


        // status
        if (!empty($status)) {
            $query->where(function ($q) use ($status) {
                $q->where("order_status_id", [$status]);
            });
        }
        $proCheckout = $query->get();

        $table ='';
        $table .='<table class="table table-striped" border="1">';
        $table.='<thead>';
            $table .='<tr>';
                $table .='<th><input type="checkbox" name="checkall" id="delall"></th>';
                $table .='<th>Type</th>';
                $table .='<th>Order No</th>';
                $table .='<th>Shop Name</th>';
                $table .='<th>Customer</th>';
                $table .='<th>Order Total</th>';
                $table .='<th>Order Time</th>';
                $table .='<th>Status</th>';
                $table .='<th>Print</th>';
                $table .='<th>SMS</th>';
                $table .='<th>Reply</th>';
            $table .='</tr>';
        $table.='</thead>';

        foreach($proCheckout as $value){

            $table .='<tr>';
            $table .='<td><input type="checkbox" name="checkall" class="delall"
            value="'.$value->order_id.'"></td>';
            if ($value->shipping_method == 'collection'){
                $table .='<td><i class="fa fa-shopping-basket"></i></td>';
            }else{
                $table .='<td><i class="fa fa-motorcycle"></i></td>';
            }
            $table .='<td>'.$value->order_id.'</td>';
            $table .='<td>'.$value->store_name.'</td>';
            $table .='<td>'.$value->firstname.'</td>';
            $table .='<td>'.number_format($value->total, 2).'</td>';
            $table .='<td>'.$value->date_added.'</td>';
            if($value->order_status_id == 15){
                $table .='<td><i class="fa fa-check-circle" title="Accepted"
                style="color:#14bd07;"></td>';
            }elseif ($value->order_status_id == 5) {
                $table .='<td><i class="fa fa-thumbs-up" title="Complete"
                style="color:#51a351;"></i></td>';
            }elseif ($value->order_status_id == 2) {
                $table .='<td><i class="fa fa-loader" title="Complete"
                style="color:#51a351;"></i></td>';
            }elseif ($value->order_status_id == 7) {
                $table .='<td><i class="fa fa-times-circle" title="Complete"
                style="color:red;"></i></td>';
            }elseif ($value->order_status_id == 11) {
                $table .='<td><i class="fa fa-check" title="Complete"
                style="color:#51a351;"></i></td>';
            }elseif ($value->order_status_id == 1) {
                $table .='<td><i class="fa fa-fa fa-search" title="Complete"
                style="color:#51a351;"></i></td>';
            }
            $table .='<td><i class="fa fa-print"></i></td>';
            $table .='<td><i class="fa fa-mobile"></i></td>';
            $table .='<td><i class="fa fa-reply"></td>';
            $table .='</tr>';
        }




        return response()->json([
            'tabledata' =>  $table,
        ]);




    }
}
