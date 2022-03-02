<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Orders;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {

        $orders = Orders::select('order_id', 'firstname', 'lastname', 'order_status_id', 'total', 'date_added', 'date_modified')->get();
        return view('admin.order.list', ['orders' => $orders]);
    }

    public function vieworder($id)
    {
        // $orders = Orders::where('order_id',$id)->first();
        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();
        // $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->join('oc_order_history','oc_order_history.order_status_id','=','oc_order.order_status_id')->first();
        $orderstatus = OrderStatus::all();


        // $orderhistory = OrderHistory::where('order_id',$id)->first();

        // $html = '';
        // foreach ($orderhistory as $history) {
        //     $html .= '<tr>';
        //     $html .= '<td>' . date('d-m-Y', strtotime($history->date_added)) . '</td>';
        //     $html .= '<td>' . $history->comment . '</td>';
        //     $html .= '<td>' . $history->order_status_id . '</td>';
        //     $html .= '<td>' . $history->notify . '</td>';
        //     $html .= '</tr>';
        // }
        // return response()->json([
        //     'success' => 1,
        //     'orderdetail' => $html,
        //     'orders' => $orders,
        //     'orderstatus' => $orderstatus
        // ]);


        // echo '<pre>';
        // print_r($orderhistory->toArray());
        // exit();
        // return view('admin.order.view', ['orders' => $orders, 'orderstatus' => $orderstatus]);
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

    // public function getorderhistory()
    // {
    //     $orderhistory = OrderHistory::all();

    //     echo '<pre>';
    //     print_r($orderhistory->toArray());
    //     exit();
    //     if ($orderhistory) {
    //         return response()->json([
    //             "status" => 200,
    //             "orderhistory" => $orderhistory,
    //         ]);
    //     }

    // }



}
