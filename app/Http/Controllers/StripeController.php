<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Session;
use Stripe;
use Stripe\Order;

class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('frontend.pages.stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $payment_details = paymentdetails();

        if(session()->has('total'))
        {
            $total = session()->get('total');
        }
        else
        {
            $total = 0.00;
        }

        $service_charge = isset($request->stripe_service_charge) ? $request->stripe_service_charge : 0.00;

        $total += $service_charge;

        // dynamic stripe secret key
        $stripesecret = $payment_details["stripe"]["stripe_secretkey"] ? $payment_details["stripe"]["stripe_secretkey"] : '';
        

        Stripe\Stripe::setApiKey($stripesecret);
        Stripe\Charge::create ([
                "amount" => round($total,2) * 100,
                "currency" => $request->currency_code,
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose"
        ]);

        Orders::stripestoreOrder($request);

        Session::flash('success', 'Payment successful!');

        // return back();
        return redirect()
        ->route('success')
        ->with('success', 'Payment successful!');
    }
}
