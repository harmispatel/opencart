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
        // echo '<pre>';
        // print_r($request->all());
        // exit();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                // "amount" => 100 * 100,
                "amount" => ceil($request->total) * 100,
                "currency" => $request->currency_code,
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose phpcodingstuff.com"
        ]);

        Orders::stripestoreOrder($request);

        Session::flash('success', 'Payment successful!');

        // return back();
        return redirect()
        ->route('success')
        ->with('success', 'Payment successful!');
    }
}
