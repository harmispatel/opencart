<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;
use App\Models\Orders;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class NewOrderController extends Controller
{

    // function For New Order List
    public function index()
    {

        // echo '<pre>';
        // print_r(session()->all());
        // exit();
        // Check User Permission
        if (check_user_role(44) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.neworders.list');
    }

    // function For New Order Create
    public function getallorderdetails(Request $request)
    {
        $range = $request->values;
        session()->put('range',$range);
        $orderdetails = getorderdetails($range);


        $html ='';
        $table ='';
          // cart 1
            $html .='<div class="col-lg-3 col-6">';
                $html .='<div class="small-box bg-light">';
                    $html .=' <div class="inner">';
                        $html .='<div class="d-flex justify-content-between box-title">';
                            $html .='<h3 style="color: #2c9ea9"> £ '.number_format($orderdetails['total'],2).'</h3>';
                            $html .='<i class="ion ion-bag"></i>';
                        $html .='</div>';
                        $html .='<div class="row">';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='Delivery: £ '.number_format($orderdetails['delivery_total'],2).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='Cash Order: £ '.number_format($orderdetails['total'],2).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='Collection: £ '.number_format($orderdetails['collection_total'],2).'';
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
                            $html .='<h3 style="color: #2c9ea9"> £ '.number_format($orderdetails['accepted_order'],0).'</h3>';
                            $html .='<i class="ion ion-bag"></i>';
                        $html .='</div>';
                        $html .='<div class="row">';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='Delivery: £ '.number_format($orderdetails['delivery_count'],0).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='Cash Order: £ '.number_format($orderdetails['accepted_order'],0).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='Collection: £ '.number_format($orderdetails['collection_count'],0).'';
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
                            $html .='<i class="fa fa-shopping-basket "></i>';
                        $html .='</div>';
                    $html .='</div>';
                    $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                        $html .=' <div class="row">';
                            $html .='<div class="col-md-6">';
                                $html .='Number of Sold Items';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
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
                                    $html .='customer: £ '.number_format($orderdetails['C_total'],2).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='No of orders: £ '.number_format($orderdetails['C_count'],2).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='guest user: £ '.number_format($orderdetails['G_total'] ,2).'';
                                $html .='</p>';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<p style="font-size: 12px; margin: 0">';
                                    $html .='No of orders:£ '.number_format($orderdetails['G_count'],2).'';
                                $html .='</p>';
                            $html .='</div>';
                        $html .='</div>';
                    $html .='</div>';
                    $html .='<div class="small-box-footer" style="background: #2c9ea9">';
                        $html .=' <div class="row">';
                            $html .='<div class="col-md-6">';
                                $html .='Top '.$orderdetails['C_count'].' Customer';
                            $html .='</div>';
                            $html .='<div class="col-md-6">';
                                $html .='<i class="fa fa-arrow-circle-up"></i> 100.00%';
                            $html .='</div>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
            $table ='';
            // $table .='<table class="table table-striped" border="1">';
            // $table.='<thead>';
            //     $table .='<tr>';
            //         $table .='<th><input type="checkbox" name="checkall" id="delall"></th>';
            //         $table .='<th>Type</th>';
            //         $table .='<th>Order No</th>';
            //         $table .='<th>Shop Name</th>';
            //         $table .='<th>Customer</th>';
            //         $table .='<th>Order Total</th>';
            //         $table .='<th>Order Time</th>';
            //         $table .='<th>Status</th>';
            //         $table .='<th>Print</th>';
            //         $table .='<th>SMS</th>';
            //         $table .='<th>Reply</th>';
            //     $table .='</tr>';
            // $table.='</thead>';

            foreach($orderdetails['query'] as $value){

                $table .='<tr>';
                $table .='<td><input type="checkbox" name="checkall" class="delall"
                value="'.$value['order_id'].'"></td>';
                if ($value['shipping_method'] == 'collection'){
                    $table .='<td><i class="fa fa-shopping-basket"></i></td>';
                }else{
                    $table .='<td><i class="fa fa-motorcycle"></i></td>';
                }
                $table .='<td>'.$value['order_id'].'</td>';
                $table .='<td>'.$value['store_name'].'</td>';
                $table .='<td>'.$value['firstname'].'</td>';
                $table .='<td>'.number_format($value['total'], 2).'</td>';
                $table .='<td>'.$value['date_added'].'</td>';
                if($value['order_status_id'] == 15){
                    $table .='<td><i class="fa fa-check-circle" title="Accepted"
                    style="color:#14bd07;"></td>';
                }elseif ($value['order_status_id'] == 5) {
                    $table .='<td><i class="fa fa-thumbs-up" title="Complete"
                    style="color:#51a351;"></i></td>';
                }elseif ($value['order_status_id'] == 2) {
                    $table .='<td><i class="fa fa-loader" title="Complete"
                    style="color:#51a351;"></i></td>';
                }elseif ($value['order_status_id'] == 7) {
                    $table .='<td><i class="fa fa-times-circle" title="Complete"
                    style="color:red;"></i></td>';
                }elseif ($value['order_status_id'] == 11) {
                    $table .='<td><i class="fa fa-check" title="Complete"
                    style="color:#51a351;"></i></td>';
                }elseif ($value['order_status_id'] == 1) {
                    $table .='<td><i class="fa fa-fa fa-search" title="Complete"
                    style="color:#51a351;"></i></td>';
                }
                $table .='<td><i class="fa fa-print"></i></td>';
                $table .='<td><i class="fa fa-mobile"></i></td>';
                $table .='<td><i class="fa fa-reply"></td>';
                $table .='</tr>';
            }




            return response()->json([
                'success' => 1,
                'html' =>  $html,
                'tabledata' =>  $orderdetails['query'],
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
