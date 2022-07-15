<?php

namespace App\Http\Controllers;


use App\Models\Orders;
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
        if ($paypalmod == 1) {
            Config::set('paypal.mode', "live");
            // Config::set('paypal.live.client_id', $paypalClint);
            // Config::set('paypal.live.client_secret', $paypalSecret);
        }
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
                        "value" => $request->total,
                    ]
                ]
            ]
        ]);

        // echo '<pre>';
        // print_r($response['id']);
        // exit();

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    // $this->successTransaction($request); // Send request to another function
                    // Orders::paypalstoreOrder($request);
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
        $lastorderid = session()->get('last_order_id');
        // echo '<pre>';
        // print_r($lastorderid);
        // exit();
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED')
        {
            Orders::where('order_id',$lastorderid)->update([
                'payment_status' => 1, // 1 payment success
            ]);
            return redirect()
                ->route('success')
                ->with('success', 'Transaction complete.');
        }
        else {
            Orders::where('order_id',$lastorderid)->update([
                'payment_status' => 0, // 0 payment faild
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
