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

    // View order
    public function vieworder($id)
    {
        $orders = Orders::where('oc_order.order_id', '=', $id)->join('oc_order_status', 'oc_order.order_status_id', '=', 'oc_order_status.order_status_id')->first();
        $orderstatus = OrderStatus::all();
        $ordertotal = OrderTotal::where('oc_order_total.order_id', '=', $id)->get();
        $productorders = OrderProduct::where('oc_order_product.order_id', '=', $id)->get();

        return view('admin.order.view', ['orders' => $orders, 'orderstatus' => $orderstatus, 'ordertotal' => $ordertotal, 'productorders' => $productorders]);
    }

    public function getorders(Request $request)
    {
        if ($request->ajax()) {
            $data = Orders::join('oc_order_status', 'oc_order.order_status_id', '=', 'oc_order_status.order_status_id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $edit_url = route('vieworder', $row->order_id);
                    $btn = '<a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-eye text-white"></i><a>';


                    return $btn;
                })
                ->addColumn('checkbox', function ($row) {
                    $cid = $row->order_id;
                    $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="' . $cid . '">';
                    return $checkbox;
                })
                ->addColumn('customer_name', function($row){
                    $cname = $row->firstname.' '.$row->lastname;
                    return $cname;
                })
                ->addColumn('date_added', function($row){
                    $cust_date = date('d-m-Y',strtotime($row->date_added));
                    return $cust_date;
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
    }

    public function ordersinsert()
    {
        $data['stores'] = Store::get();
        $data['Customers'] = CustomerGroupDescription::get();
        $data['countries'] = Country::get();
        $data['voucherdesc'] = VoucherThemeDescription::get();
        $data['orderstatus'] = OrderStatus::get();
        return view('admin.order.addneworder', $data);
    }


    // Add new order 
    public function addneworders(Request $request)
    {
        $request->validate([
            // 'firstname' => 'required',
            // 'lastname' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required',
            // 'pfirstname' => 'required',
            // 'plastname' => 'required',
            // 'pcompany' => 'required',
            // 'pcompanyid' => 'required',
            // 'paddress1' => 'required',
            // 'pcity' => 'required',
            // 'ppostcode' => 'required',
            // 'pcountry' => 'required',
            // 'pregion' => 'required',
            // 'sfirstname' => 'required',
            // 'slastname' => 'required',
            // 'scompany' => 'required',
            // 'scompanyid' => 'required',
            // 'saddress1' => 'required',
            // 'scity' => 'required',
            // 'spostcode' => 'required',
            // 'scountry' => 'required',
            // 'sregion' => 'required',
        ]);

        $neworder = new Orders;
        $neworder->store_id                = isset($request->storename) ? $request->storename : "0";
        $neworder->firstname               = isset($request->firstname) ? $request->firstname : "";
        $neworder->lastname                = isset($request->lastname) ? $request->lastname : "";
        $neworder->email                   = isset($request->email) ? $request->email : "";
        $neworder->telephone               = isset($request->phone) ? $request->phone : "";
        $neworder->fax                     = isset($request->fax) ? $request->fax : "";
        $neworder->payment_firstname       = isset($request->pfirstname) ? $request->pfirstname : "";
        $neworder->payment_lastname        = isset($request->plastname) ? $request->plastname : "";
        $neworder->payment_company         = isset($request->pcompany) ? $request->pcompany : "";
        $neworder->payment_company_id      = isset($request->pcompanyid) ? $request->pcompanyid : "";
        // $neworder->payment_tax_id          = isset($request->firstname) ? $request->firstname : "";
        $neworder->payment_address_1       = isset($request->paddress1) ? $request->paddress1 : "";
        $neworder->payment_address_2       = isset($request->paddress2) ? $request->paddress2 : "";
        $neworder->payment_city            = isset($request->pcity) ? $request->pcity : "";
        $neworder->payment_postcode        = isset($request->ppostcode) ? $request->ppostcode : "";
        $neworder->payment_country         = isset($request->pcountry) ? $request->pcountry : "";
        // $neworder->payment_country_id      = isset($request->pcountryid) ? $request->pcountry : "";
        // $neworder->payment_zone            = isset($request->firstname) ? $request->firstname : "";
        // $neworder->payment_zone_id         = isset($request->firstname) ? $request->firstname : "";
        // $neworder->payment_address_format  = isset($request->firstname) ? $request->firstname : "";
        // $neworder->payment_method          = isset($request->firstname) ? $request->firstname : "";
        $neworder->shipping_firstname      = isset($request->sfirstname) ? $request->sfirstname : "";
        $neworder->shipping_lastname       = isset($request->slastname) ? $request->slastname : "";
        $neworder->shipping_company        = isset($request->scompany) ? $request->scompany : "";
        $neworder->shipping_address_1      = isset($request->saddress1) ? $request->saddress1 : "";
        $neworder->shipping_address_2      = isset($request->saddress2) ? $request->saddress2 : "";
        $neworder->shipping_city           = isset($request->scity) ? $request->scity : "";
        $neworder->shipping_postcode       = isset($request->spostcode) ? $request->spostcode : "";
        $neworder->shipping_country        = isset($request->scountry) ? $request->scountry : "";
        $neworder->shipping_country_id     = isset($request->scountryid) ? $request->scountryid : "";
        // $neworder->shipping_zone           = isset($request->firstname) ? $request->firstname : "";
        // $neworder->shipping_zone_id        = isset($request->firstname) ? $request->firstname : "";
        // $neworder->shipping_address_format = isset($request->firstname) ? $request->firstname : "";
        // $neworder->shipping_method         = isset($request->firstname) ? $request->firstname : "";
        // $neworder->shipping_code           = isset($request->firstname) ? $request->firstname : "";
        $neworder->comment                 = isset($request->comment) ? $request->comment : "";
        // $neworder->total                   = isset($request->firstname) ? $request->firstname : "";
        // $neworder->order_status_id         = isset($request->firstname) ? $request->firstname : "";
        // $neworder->message                 = isset($request->firstname) ? $request->firstname : "";
        $neworder->affiliate_id            = isset($request->affiliate) ? $request->affiliate : "";
        // $neworder->commission           = isset($request->firstname) ? $request->firstname : "";
        // $neworder->language_id          = isset($request->firstname) ? $request->firstname : "";
        // $neworder->currency_id          = isset($request->firstname) ? $request->firstname : "";
        // $neworder->currency_code        = isset($request->firstname) ? $request->firstname : "";
        // $neworder->currency_value       = isset($request->firstname) ? $request->firstname : "";

        echo '<pre>';
        print_r($neworder->toArray());
        exit();
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
        // $orderhisins->override                       = isset($request->override) ? $request->override : "0";
        $orderhisins->notify                        = isset($request->notify) ? $request->notify : "0";
        $orderhisins->comment                       = isset($request->comment) ? $request->comment : "";
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
        date_default_timezone_set('Asia/Kolkata');
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
            $html .= '<td class="right">' . $order->total  . '</td>';
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

    public function autocomplete(Request $request)
    {
        $res = Customer::where("firstname", "LIKE", '%' . $request->term . '%')
            ->orWhere("lastname", "LIKE", '%' . $request->term . '%')
            ->get();

        return response()->json($res);
    }
    public function autocompleteproduct(Request $request)
    {

        $pro = ProductDescription::where("name", "LIKE", '%' . $request->product . '%')
            ->get();

        return response()->json($pro);
    }

    public function getaddress($id)
    {
        $addr = CustomerAddress::where('customer_id', '=', $id)->get();
        $html = "";
        $html .= "<option>--None--</option>";
        foreach ($addr as $address) {
            $html .= '<option value="' . $address->address_id . '">' . $address->firstname . ' ' . $address->lastname . ',' . $address->address_1 . ', ' . $address->city . '</option>';
        }
        return response()->json($html);
    }

    public function address($id)
    {
        $address = CustomerAddress::where('address_id', '=', $id)->first();
        return response()->json($address);
    }
}
