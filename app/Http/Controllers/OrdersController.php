<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderHistory;
use App\Models\OrderProduct;
use App\Models\OrderReturn;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\OrderTotal;
use App\Models\ReturnAction;
use App\Models\ReturnProduct;
use App\Models\ReturnReason;
use Illuminate\Http\Request;
use DataTables;
class OrdersController extends Controller
{
    // View Order List
    public function index()
    {
        return view('admin.order.list');
    }

    // View order
    public function vieworder($id)
    {
        // $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_status', 'oc_order.order_status_id', '=', 'oc_order_status.order_status_id')->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id' )->get();
        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_status', 'oc_order.order_status_id', '=', 'oc_order_status.order_status_id')->first();
        $orderstatus = OrderStatus::all();
        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->get();
        $productorders = OrderProduct::where('oc_order_product.order_id', '=' , $id)->get();
        // echo '<pre>';
        // print_r($ordertotal->toArray());
        // exit();

        return view('admin.order.view', ['orders' => $orders, 'orderstatus' => $orderstatus, 'ordertotal' => $ordertotal, 'productorders'=>$productorders]);
    }

    public function getorders(Request $request){
        if ($request->ajax()) {
            $data = Orders::join('oc_order_status', 'oc_order.order_status_id', '=', 'oc_order_status.order_status_id');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $edit_url = route('vieworder',$row->order_id);
                $btn = '<a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-eye text-white"></i><a>';


                return $btn;
            })
            ->addColumn('checkbox', function($row){
                $cid = $row->order_id;
                $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$cid.'">';
                return $checkbox;
            })
            ->rawColumns(['action','checkbox'])
            ->make(true);
        }
    }

    // Get Order History
    public function getorderhistory($id)
    {

        $orderhistory = OrderHistory::where('order_id', $id)->join('oc_order_status', 'oc_order_history.order_status_id', '=', 'oc_order_status.order_status_id')->get();

        $html = '';
        foreach ($orderhistory as $order) {
            $html .= '<tr>';
            $html .= '<td>' . date('d-m-Y', strtotime($order->date_added)) . '</td>';
            $html .= '<td>' . $order->comment . '</td>';
            $html .= '<td>' . $order->name . '</td>';
            $html .= '<td>' . ($order->notify == 1 ? 'Yes' : 'No') . '</td>';
            $html .= '</tr>';
        }
        return response()->json([
            'status' => 200,
            'orderhistory' => $html,
        ]);
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

    public function invoice($id)
    {
        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_product', 'oc_order.order_id', '=', 'oc_order_product.order_id')->first();
        $productorders = OrderProduct::where('oc_order_product.order_id', '=' , $id)->get();
        return view('admin.order.invoice', ["orders" => $orders, 'productorders'=>$productorders]);
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

        $product = OrderProduct::where('order_product_id',$request->product)->first();
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
        $proreturn->quantity = isset($request->quantity) ? $request->quantity : 0;
        $proreturn->opened = $request->opened;
        $proreturn->comment = isset($request->comment) ? $request->comment : '';
        $proreturn->return_reason_id = $request->return_reason_id;
        $proreturn->return_action_id = $request->return_action_id;
        date_default_timezone_set('Asia/Kolkata');
        $proreturn->date_added = date("Y-m-d h:i:s");
        $proreturn->date_modified = date("Y-m-d h:i:s");
        $proreturn->save();

        $errors = "Insert success";

        return redirect()->route('returns')->withErrors($errors);

    }
    public function getcustomer(Request $request)
    {
        $customer_id = $request->customer;

        if (!empty($customer_id)) {
            $cusomers = Customer::select('firstname','lastname','email','telephone')->where('customer_id', $customer_id)->first();
            return response()->json($cusomers);

        }
        $product_id = $request->product;
        if (!empty($product_id)) {
            $product = OrderProduct::select('order_product_id','name','model')->where('order_product_id','=', $product_id)->first();
            return response()->json($product);
        }

    }

}
