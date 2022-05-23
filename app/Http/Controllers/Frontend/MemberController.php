<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Orders;
use App\Models\Reviews;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function member()
    {

        $userlogin = session('userid');

        if (!empty($userlogin)) {
            $customers = Customer::where('customer_id', $userlogin)->first();
            $customeraddress = CustomerAddress::with(['hasOneRegion', 'hasOneCountry'])->where('customer_id', $userlogin)->get();
            $customerorders = Orders::with(['hasManyOrderProduct', 'hasOneOrderStatus'])->where('customer_id', $userlogin)->orderBy('order_id', 'DESC')->get();
            // echo '<pre>';
            // print_r($customerorders);
            // exit();
            return view('frontend.pages.member', compact('customers', 'customeraddress', 'customerorders'));
        } else {
            return view('frontend.pages.member');
        }
    }
    public function memberregister()
    {
        $countries = Country::get();
        return view('frontend.pages.register', compact('countries'));
    }

    public function addnewaddress()
    {
        // Get All Countries
        $countries = Country::get();
        return view('frontend.pages.addnewaddress', compact('countries'));
    }

    public function changeDefAddress(Request $request)
    {
        $addressid = $request->address_id;
        $customerid = $request->customer_id;

        $edit_cust = Customer::find($customerid);
        $edit_cust->address_id = $addressid;
        $edit_cust->update();

        return response()->json([
            'success' => 1
        ]);
    }

    public function newaddress(Request $request)
    {
        $userlogin = session('userid');
        if (!empty($userlogin)) {
            // Validation
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'address_1' => 'required',
                'city' => 'required',
                'country' => 'required',
                'region' => 'required',
            ]);
            $customeraddress = new CustomerAddress;
            $customeraddress->customer_id = $userlogin;
            $customeraddress->firstname = $request->firstname;
            $customeraddress->lastname = $request->lastname;
            $customeraddress->company = isset($request->company) ? $request->company : '';
            $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
            $customeraddress->address_1 = $request->address_1;
            $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
            $customeraddress->city = $request->city;
            $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '0';
            $customeraddress->country_id = $request->country;
            $customeraddress->zone_id = isset($request->region) ? $request->region : '0';
            $customeraddress->phone = isset($request->phone) ? $request->phone : '0';
            $customeraddress->billing = isset($request->billing) ? $request->billing : '0';
            $customeraddress->save();

            if ($request->default == 1) {
                $edit_cust = Customer::find($userlogin);
                $edit_cust->address_id = $customeraddress->address_id;
                $edit_cust->update();
            }

            return redirect()->route('member');
        } else {
            return redirect()->route('home');
        }
    }
    public function customeraddressdelete($id)
    {
        CustomerAddress::find($id)->delete();
        return redirect()->route('member');
    }

    public function customeraddressedit($id)
    {
        // Get All Countries
        $countries = Country::get();
        $customeraddress = CustomerAddress::where('address_id', $id)->first();
        return view('frontend.pages.editcustomeraddress', compact('countries', 'customeraddress'));
    }

    public function updatecustomeraddress(Request $request)
    {
        $userlogin = session('userid');
        $addressid = $request->address_id;
        if (!empty($addressid)) {
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'address_1' => 'required',
                'city' => 'required',
                'country' => 'required',
                'region' => 'required',
            ]);
            $customeraddress = CustomerAddress::find($addressid);
            $customeraddress->firstname = $request->firstname;
            $customeraddress->lastname = $request->lastname;
            $customeraddress->company = isset($request->company) ? $request->company : '';
            $customeraddress->company_id = isset($request->company_id) ? $request->company_id : '';
            $customeraddress->address_1 = $request->address_1;
            $customeraddress->address_2 = isset($request->address_2) ? $request->address_2 : '';
            $customeraddress->city = $request->city;
            $customeraddress->postcode = isset($request->postcode) ? $request->postcode : '0';
            $customeraddress->country_id = $request->country;
            $customeraddress->zone_id = $request->country_region_id;
            $customeraddress->phone = isset($request->phone) ? $request->phone : '0';
            $customeraddress->billing = isset($request->billing) ? $request->billing : '0';
            $customeraddress->update();

            if ($request->defaultaddress == 1) {
                $edit_cust = Customer::find($userlogin);
                $edit_cust->address_id = $customeraddress->address_id;
                $edit_cust->update();
            }

            return redirect()->route('member');
        } else {
            return redirect()->route('home');
        }
    }

    public function getcustomerorderdetail(Request $request)
    {
        $cusromerOrderId = $request->customerorderid;
        $customerorders = Orders::with(['hasManyOrderProduct', 'hasOneOrderStatus', 'hasManyOrderTotal'])->where('order_id', $cusromerOrderId)->first();

        // Get Current Theme ID & Store ID
        $currentURL = URL::to("/");
        $current_theme_id = themeID($currentURL);
        $theme_id = $current_theme_id['theme_id'];
        $front_store_id =  $current_theme_id['store_id'];
        // Get Current Theme ID & Store ID

        // Get Store Settings & Theme Settings & Other
        $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
        //End Get Store Settings & Theme Settings & Other

        // Store Settings
        $store_setting = $store_theme_settings['store_settings'];
        // End Store Settings


        $html = '';
        $html .= '<div id="wrapper">';
        $html .=     '<div id="content" style="text-align: center;">';
        $html .=         '<div id="printthis" style="float: left; width: 100%;">';
        $html .=             '<div class="orderinfo-adress sang" style="text-align: center;">';
        $html .=                 '<div class="contact-info">';
        $html .=                     '<div class="content">';
        $html .=                         '<p class="etsAddress">' . $store_setting["config_address"] . '<br></p>Tel:' . $store_setting["config_telephone"] . '';
        $html .=                     '</div>';
        $html .=                 '</div>';
        $html .=             '</div>';
        $html .=             '<div class="orderinfo-date" style="display: flex; justify-content:space-between">';
        $html .=                 '<span> <b class="order-dates">Date:</b>' . date('d/m/Y', strtotime($customerorders->date_added)) . '</span>';
        $html .=                 '<span> <b class="order-id">Order ID:</b>' . $customerorders->order_id . '</span></b>';
        $html .=             '</div>';
        $html .=             '<h3 class="order-delivery" style="border-bottom: 2px solid #777777;  color: #777777;  float: left;  font-size: 30px;  font-weight: bold;  padding-bottom: 10px;  text-align: center;  text-transform: uppercase;  width: 100%;">delivery</h3>';
        $html .=             '<table class="list list-item" style="float: left;width:100%;margin: 0;">';
        $html .=                 '<thead>';
        $html .=                     '<tr>';
        $html .=                         '<th>Qty</th>';
        $html .=                         '<th style="text-align:left;">Item</th>';
        $html .=                         '<th style="text-align:right;">Total</th>';
        $html .=                     '</tr>';
        $html .=                 '</thead>';
        $html .=                 '<tbody>';
        foreach ($customerorders['hasManyOrderProduct'] as $value) {
            $html .= '<tr>';
            $html .=     '<td style="text-align:center; border-bottom: 1px solid rgb(221, 221, 221); padding: 7px 0;">' . $value->quantity . 'x</td>';
            $html .=     '<td style="text-align:left; border-bottom: 1px solid rgb(221, 221, 221); padding: 7px 0;"><span class="name-parent">' . $value->name . '</span><br><div class="topping_text"><span class="bg" style="display:block"></span></div></td>';
            $html .=     '<td style="text-align:right; border-bottom: 1px solid rgb(221, 221, 221); padding: 7px 0;">£' . number_format($value->total, 2) . '</td>';
            $html .= '</tr>';
        }
        $html .=                 '</tbody>';
        $html .=             '</table>';
        $html .=             '<div class="box-order-total" style="float: left;width: 100%;border-bottom: 1px solid #dddddd;">';
        $html .=                 '<table style="float: left;width: 100%;">';
        $html .=                     '<tbody style="float: left;width: 100%;">';
        $html .=                         '<tr style="float: left;width: 100%;">';
        $html .=                             '<td style="width: 50%;border-right: 1px solid #ddd;text-align: center;">';
        $html .=                                 '<strong>' . $customerorders->payment_code . '</strong>';
        $html .=                             '</td>';
        $html .=                             '<td style="width: 50%;">';
        $html .=                                 '<table>';
        $html .=                                     '<tbody>';
        foreach ($customerorders['hasManyOrderTotal'] as $total) {
            $html .= '<tr class="order-left-right" style="border-bottom: 1px dotted #ddd;  float: left;  padding: 2px 0;  width: 100%;">';
            $html .=     '<td class="left" style="float: left;"><b>' . $total->title . ':</b></td>';
            $html .=     '<td class="right" style="float: right;font-weight: normal;">' . $total->text . '</td>';
            $html .= '</tr>';
        }
        $html .=                                     '</tbody>';
        $html .=                                 '</table>';
        $html .=                             '</td>';
        $html .=                         '</tr>';
        $html .=                     '</tbody>';
        $html .=                 '</table>';
        $html .=             '</div>';
        $html .=             '<div class="delivery-to d-flex justify-content-center" style="width: 100%; display: flex; justify-content:center">';
        $html .=                 '<table class="list" style="width: 80%;margin: 20px 0">';
        $html .=                     '<tbody>';
        $html .=                         '<tr>';
        $html .=                             '<td></td>';
        $html .=                             '<td class="text-start" style="text-transform: uppercase; font-weight: 700; padding-bottom: 10px">' . ucwords($customerorders->firstname) . '&nbsp;' . ucwords($customerorders->lastname) . ' </td>';
        $html .=                             '<td></td>';
        $html .=                         '</tr>';
        if ($customerorders->flag_post_code == 'delivery') {
            $html .= '<tr>';
            $html .=     '<td><b>Delivery to:</b></td>';
            $html .=     '<td class="pb-2">';
            $html .=         '<div class="text-start">' . $customerorders->firstname . ' ' . $customerorders->lastname . '<br>' . $customerorders->payment_company . '<br>' . $customerorders->payment_address_1 . '<br>' . $customerorders->payment_address_2 . '<br>' . $customerorders->payment_city . '<br>' . $customerorders->payment_city . ' ' . $customerorders->payment_postcode . '<br></div>';
            $html .=     '</td>';
            $html .=     '<td></td>';
            $html .= '</tr>';
        }
        $html .=                         '<tr>';
        $html .=                             '<td><b>Telephone:</b></td>';
        $html .=                             '<td class="text-start pb-2">';
        $html .=                                 '<a href="tel:' . $customerorders->telephone . '">' . $customerorders->telephone . '</a>';
        $html .=                             '</td>';
        $html .=                             '<td></td>';
        $html .=                         '</tr>';
        $html .=                         '<tr>';
        $html .=                             '<td><b>Wanted by:</b></td>';
        $html .=                             '<td class="text-start">';
        $html .=                                 '' . $customerorders->timedelivery . ' </td>';
        $html .=                             '<td></td>';
        $html .=                         '</tr>';
        $html .=                     '</tbody>';
        $html .=                 '</table>';
        $html .=             '</div>';
        $html .=             '<div class="pt-3" style="float: left;width: 100%;border-top: 1px solid #ddd;margin-bottom: 0;">';
        $html .=                 '<h3 style="color: #777777;  float: left;  font-size: 24px;  font-style: italic;  margin-bottom: 15px;  text-align: center; width: 100%;">Thanks for your custom!</h3>';
        $html .=             '</div>';
        $html .=         '</div>';
        $html .=         '<div class="center" style="float: left;width: 100%;text-align: center;margin-bottom: 20px;">';
        $html .=             '<a onclick="printDiv(`printthis`)" id="Print" class="btn btn-success" href="javascript:void(0)"><i class="fa fa-print" aria-hidden="true"></i> Print</a>';
        $html .=             '<a class="getorderid btn btn-success mx-2 " href="#" class="button action-write-review" value="' . $customerorders->order_id . '" data-bs-toggle="modal" data-bs-target="#orderreview"><i class="far fa-comment"></i> Review</a>';
        $html .=             '<a class="btn btn-success" href="#" class="button"><i class="fas fa-redo-alt"></i> Re-Order</a>';
        $html .=         '</div>';
        $html .=     '</div>';
        $html .= '</div>';

        return response()->json(['customerorders' => $html]);
    }

    public function orderreviwe(Request $request)
    {
        $this->validate($request, [
            'reviewtitle' => 'required',
            'reviewmessage' => 'required',
        ]);
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];
        $userlogin = session('userid');
        $review = new Reviews;
        $review->customer_id = $userlogin;
        $review->store_id = $front_store_id;
        $review->order_id = $request->o_id;
        $review->title = $request->reviewtitle;
        $review->message = $request->reviewmessage;
        $review->quality = $request->foodquality;
        $review->service = $request->customerservice;
        $review->timing = $request->timing;
        $review->status = 1;
        $review->date_added = date('Y-m-d H:i:s');
        $review->save();
        return response()->json();
    }
}
