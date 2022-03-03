<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\OrderTotal;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // View Order List
    public function index()
    {
        $orders = Orders::join('oc_order_status','oc_order.order_status_id', '=' , 'oc_order_status.order_status_id')->get();
        
        return view('admin.order.list', ['orders' => $orders]);
    }

    // View order 
    public function vieworder($id)
    {
        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();
        $orderstatus = OrderStatus::all();
        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=' , $id)->get();
        // echo '<pre>';
        // print_r($ordertotal->toArray());
        // exit();
        
        return view('admin.order.view', ['orders' => $orders, 'orderstatus' => $orderstatus, 'ordertotal' => $ordertotal]);
    }

    // Get Order History
    public function getorderhistory($id)
    {
        $orderhistory = OrderHistory::where('order_id',$id)->join('oc_order_status','oc_order_history.order_status_id', '=' , 'oc_order_status.order_status_id')->get();
    
        if ($orderhistory) {
            return response()->json([
                "status" => 200,
                "orderhistory" => $orderhistory,
            ]);
        }
    
    }

    // Order History Insert
    public function orderhistoryinsert(Request $request)
    {
        $orderhisins = new OrderHistory;
        // $orderstuid = new Orders;
        $orderhisins->order_status_id = $request->order_status_id;
        $orderhisins->order_id = $request->order_id;
        // $orderhisins->override = isset($request->override) ? $request->override : "0";
        $orderhisins->notify = isset($request->notify) ? $request->notify : "0";
        $orderhisins->comment = isset($request->comment) ? $request->comment : "";
        date_default_timezone_set('Asia/Kolkata');
        $orderhisins->date_added = date("Y-m-d h:i:s");
        $orderhisins->save();

        return response()->json([
            'success'  => 200,
            'message'   => "Success: You have modified orders!",
        ]);

    }

    public function editorder()
    {
        return view('admin.order.edit');
    }

    public function updateorder()
    {
        return view('admin.order.update');
    }


    public function deleteorder()
    {
        return view('admin.order.list');
    }




}
