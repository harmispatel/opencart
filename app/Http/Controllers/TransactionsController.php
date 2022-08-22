<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\Orders;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

    // Function for Get all Transaction Details
    public function index()
    {
        // Check User Permission
        if (check_user_role(43) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }
        return view('admin.transactions.list');
    }





    // Function for get Transaction By Date
    public function getdaterange(Request $request)
    {
        // Start Date
        $startdate = $request->start;

        // End Date
        $enddate = $request->end;

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        if($user_group_id == 1)
        {
            if ($current_store_id == 0) {
                $customerorder = CustomerOrder::with(['hasOneStore'])->whereBetween('customer_order.order_date', [$startdate, $enddate])->groupBy('customer_order.store_id')->get();
            }
            else {
                $customerorder = CustomerOrder::where('store_id',$current_store_id)->with(['hasOneStore'])->whereBetween('customer_order.order_date', [$startdate, $enddate])->groupBy('customer_order.store_id')->get();
            }
        }
        else
        {
            $user_shop_id = $user_details['user_shop'];
            $customerorder = CustomerOrder::where('store_id',$user_shop_id)->with(['hasOneStore'])->whereBetween('customer_order.order_date', [$startdate, $enddate])->groupBy('customer_order.store_id')->get();
        }



        $html = '';
        if (count($customerorder) > 0) {
            $rejected_count_tot = 0;
            $rejected_sum_amt = 0;
            $accepted_count_tot = 0;
            $accepted_tot = 0;
            $commission_tot = 0;
            $totle = 0;
            foreach ($customerorder as $order) {
                $html .= '<tr class="text-center">';
                $html .= '<td>' . $order->hasOneStore->name . '</td>';
                $html .= '<td>';
                $rejected_count = CustomerOrder::where('store_id', $order->store_id)->where('order_status', 7)->whereBetween('customer_order.order_date', [$startdate, $enddate])->count();
                $html .= $rejected_count;
                $html .= '</td>';
                $html .= '<td>';
                $rejected_sum = CustomerOrder::where('store_id', $order->store_id)->where('order_status', 7)->whereBetween('customer_order.order_date', [$startdate, $enddate])->sum('order_amount');
                $html .= '£'.number_format($rejected_sum,2);
                $html .= '</td>';
                $html .= '<td>';
                $accepted_count = CustomerOrder::where('store_id', $order->store_id)->where('order_status', 15)->whereBetween('customer_order.order_date', [$startdate, $enddate])->count();
                $html .= $accepted_count;
                $html .= '</td>';
                $html .= '<td>';
                $accepted_totle = CustomerOrder::where('store_id', $order->store_id)->where('order_status', 15)->whereBetween('customer_order.order_date', [$startdate, $enddate])->sum('order_amount');
                $html .= '£'.number_format($accepted_totle,2);
                $html .= '</td>';
                $html .= '<td>';
                $commission = CustomerOrder::where('store_id', $order->store_id)->whereBetween('customer_order.order_date', [$startdate, $enddate])->sum('commission_fee');
                $html .= '£'.number_format($commission,2);
                $html .= '</td>';
                $html .= '<td>£' . number_format($accepted_totle - $commission,2) . '</td>';
                $html .= '</tr>';

                $rejected_count_tot += $rejected_count;
                $rejected_sum_amt += $rejected_sum;
                $accepted_count_tot += $accepted_count;
                $accepted_tot += $accepted_totle;
                $commission_tot += $commission;
                $totle +=  $accepted_totle - $commission;
                // echo $rejected_count;die;

            }

            print_r($rejected_count_tot);
            exit();

            return response()->json([
                'customerorder' => $html,
                'reject' => $rejected_count_tot,
                'reject_amt' => '£'.number_format($rejected_sum_amt,2),
                'accept' => $accepted_count_tot,
                'accept_tot' => '£'.number_format($accepted_tot,2),
                'commission' => '£'.number_format($commission_tot,2),
                'totle' => '£'.number_format($totle,2),
            ]);
        }
        else
        {
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
