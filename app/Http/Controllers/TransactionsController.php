<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
 
        return view('admin.transactions.list');
    }

    public function getdaterange(Request $request)
    {

        $startdate = $request->start;
        $enddate = $request->end;

        // echo $startdate .' to '. $enddate;
        // die;

        $customerorder = CustomerOrder::with(['hasOneStore'])->whereBetween('order_date', [$startdate, $enddate])->groupBy('customer_order.store_id')->get();

        // echo '<pre>';
        // print_r($customerorder);
        // exit();

        $html = '';
        if(count($customerorder) > 0)
        {
            foreach($customerorder as $order)
            {
                $html .= '<tr>';
                $html .= '<td>'.$order->hasOneStore->name.'</td>';
                $html .= '<td>'. 0 .'</td>';
                $html .= '<td>'. 0 .'</td>';
                $html .= '<td>'. 0 .'</td>';
                $html .= '<td>'. 0 .'</td>';
                $html .= '<td>'. 0 .'</td>';
                $html .= '<td>'. 0 .'</td>';
                $html .= '</tr>';
            }

            return response()->json([
                'customerorder' => $html,
            ]);
        }
        else
        {
            $html .= '<tr>';
            $html .= '<td colspan="3" class="text-center">Rewards Not Avavilable</td>';
            $html .= '</tr>';

            return response()->json([
                'customerorder' => $html,
            ]);
        }

        echo '<pre>';
        print_r($customerorder->toArray());
        exit();
        return response()->json([
            'customerorder' => $customerorder,
        ]);

    }

}
