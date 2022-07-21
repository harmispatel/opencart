<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Orders;
use App\Models\OrderTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        // return view('transaction');
        return redirect()->route('checkout');
    }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {

        $paypal         = paymentdetails();
        $paypalmod    = $paypal['paypal']['pp_express_test'];

        $paypalClint    = $paypal['paypal']['pp_sandbox_clint'];
        $paypalSecret   = $paypal['paypal']['pp_sandbox_secret'];

        // Paypal Live Mod
        if ($paypalmod == 1) {
            Config::set('paypal.mode', "live");
            // Config::set('paypal.live.client_id', $paypalClint);
            // Config::set('paypal.live.client_secret', $paypalSecret);
        }

        // Paypal Sandbox Mod
        if ($paypalmod == 0) {
            Config::set('paypal.mode', "sandbox");
            Config::set('paypal.sandbox.client_id', $paypalClint);
            Config::set('paypal.sandbox.client_secret', $paypalSecret);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $request->currency_code,
                        "value" => round($request->total,2),
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    Orders::paypalstoreOrder($request);
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('createTransaction')
                ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $paypal         = paymentdetails();
        $paypalmod    = $paypal['paypal']['pp_express_test'];

        $paypalClint    = $paypal['paypal']['pp_sandbox_clint'];
        $paypalSecret   = $paypal['paypal']['pp_sandbox_secret'];

        // Paypal Live Mod
        if ($paypalmod == 1) {
            Config::set('paypal.mode', "live");
            // Config::set('paypal.live.client_id', $paypalClint);
            // Config::set('paypal.live.client_secret', $paypalSecret);
        }
        // Paypal Sandbox Mod
        if ($paypalmod == 0) {
            Config::set('paypal.mode', "sandbox");
            Config::set('paypal.sandbox.client_id', $paypalClint);
            Config::set('paypal.sandbox.client_secret', $paypalSecret);
        }
        $lastorderid = session()->get('last_order_id');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED')
        {
            // Order status
            Orders::where('order_id',$lastorderid)->update([
                'order_status_id' => 2, // 2 Order Prossesing
            ]);

            // Order history status
            OrderHistory::where('order_id',$lastorderid)->update([
                'order_status_id' => 2, // 2 Order Prossesing
            ]);

            $amount = $response['purchase_units']['0']['payments']['captures']['0']['amount']['value'];
            $status = $response['status'];

            // Store Order Transaction Details
            $ordertransaction = new OrderTransaction;
            $ordertransaction->myfoodba_order_id = $lastorderid;
            $ordertransaction->transaction_id = $response['id'];
            $ordertransaction->parent_transaction_id = "";
            $ordertransaction->created = date("Y-m-d h:i:s");
            $ordertransaction->note = "";
            $ordertransaction->msgsubid = "";
            $ordertransaction->receipt_id = "";
            $ordertransaction->payment_type = "";
            $ordertransaction->payment_status = $status;
            $ordertransaction->pending_reason = "None";
            $ordertransaction->transaction_entity = "";
            $ordertransaction->amount = $amount;
            $ordertransaction->debug_data = "";
            $ordertransaction->call_data = null;
            $ordertransaction->order_status_id = 2; // 2 Order Prossesing
            $ordertransaction->save();

            return redirect()
                ->route('success')
                ->with('success', 'Transaction complete.');
        }
        else {
            Orders::where('order_id',$lastorderid)->update([
                'order_status_id' => 7, // 7 Order Rejected
            ]);
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('createTransaction')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
