<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {

        $orders = Orders::select('order_id', 'firstname','lastname','order_status_id','total','date_added','date_modified')->get();
        return view('admin.order.list', ['orders' => $orders]);
    }

    public function view()
    {
        $orders = Orders::all();
        // echo '<pre>';
        // print_r($orders);
        // exit();
        return view('admin.order.view', ['orders' => $orders]);
    }
    public function edit()
    {
        return view('admin.order.edit');
    }

    public function update()
    {
        return view('admin.order.update');
    }


    public function delete()
    {
        return view('admin.order.list');
    }
   
}
