<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\Settings;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    // Cash Setting view
    public function cashpaysetting()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $key = ([
            'cod_order_status_id',
            'cod_total',
            'cod_charge_payment',
            'cod_geo_zone_id',
            'cod_front_text_delivery',
            'cod_printer_text',
            'cod_status',
            'cod_front_text',
            'cod_sort_order',
        ]);

        $cod = [];

        foreach ($key as $row)
        {
            if($user_group_id == 1)
            {
                $query = Settings::select('value')->where('store_id', $current_store_id)->where('key', $row)->first();
            }
            else
            {
                $query = Settings::select('value')->where('store_id', $user_shop_id)->where('key', $row)->first();
            }

            $cod[$row] = isset($query->value) ? $query->value : '';
        }
        return view('admin.paymentsetting.cashsetting', compact('cod'));
    }

    // Cash setting add and update
    public function storecashsetting(Request $request)
    {
       // Current Store ID
       $current_store_id = currentStoreId();

       $user_details = user_details();
       if(isset($user_details))
       {
           $user_group_id = $user_details['user_group_id'];
       }
       $user_shop_id = $user_details['user_shop'];

        $data['cod_order_status_id'] = 1;
        $data['cod_total'] = 0;
        $data['cod_charge_payment'] = $request->paycharge;
        $data['cod_geo_zone_id'] = 0;
        $data['cod_front_text_delivery'] = $request->deliverytext;
        $data['cod_printer_text'] = $request->printertext;
        $data['cod_status'] = $request->cod_status;
        $data['cod_front_text'] = $request->fronttext;
        $data['cod_sort_order'] = $request->sortorder;


        foreach ($data as $key => $new)
        {
            if($user_group_id == 1)
            {
                $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            }
            else
            {
                $query = Settings::where('store_id', $user_shop_id)->where('key', $key)->first();
            }

            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '') {
                $cod_update = Settings::find($setting_id);
                $cod_update->value = $new;
                $cod_update->update();
            } else {
                $cod_add = new Settings();
                if($user_group_id == 1)
                {
                    $cod_add->store_id = $current_store_id;
                }
                else
                {
                    $cod_add->store_id = $user_shop_id;
                }
                $cod_add->group = 'cod';
                $cod_add->key = $key;
                $cod_add->value = $new;
                $cod_add->serialized = 0;
                $cod_add->save();
            }
        }
        return redirect()->back()->with('success', 'Settings Updated..');

    }

    // paypal setting view
    public function paypalsetting()
    {
         // Current Store ID
         $current_store_id = currentStoreId();

         $user_details = user_details();
         if(isset($user_details))
         {
             $user_group_id = $user_details['user_group_id'];
         }
         $user_shop_id = $user_details['user_shop'];

        $key = ([
            'pp_express_completed_status_id',
            'pp_express_pending_status_id',
            'pp_express_failed_status_id',
            'pp_express_expired_status_id',
            'pp_express_denied_status_id',
            'pp_express_canceled_reversal_status_id',
            'pp_express_profile_cancel_status',
            'pp_express_currency',
            'pp_express_geo_zone_id',
            'pp_express_method',
            'pp_express_total',
            'pp_express_debug',
            'pp_express_logo',
            'pp_express_border_colour',
            'pp_express_processed_status_id',
            'pp_express_refunded_status_id',
            'pp_express_reversed_status_id',
            'pp_express_voided_status_id',
            'pp_express_allow_note',
            'pp_express_voided_status_id',
            'pp_express_reversed_status_id',
            'curren_store_id',
            'pp_express_debug',
            'pp_express_method',
            'pp_express_geo_zone_id',
            'pp_express_currency',
            'pp_express_profile_cancel_status',
            'pp_express_canceled_reversal_status_id',
            'pp_express_completed_status_id',
            'pp_express_expired_status_id',
            'pp_express_failed_status_id',
            'pp_express_pending_status_id',
            'pp_express_processed_status_id',
            'pp_express_refunded_status_id',
            'pp_printer_text',
            'pp_express_page_colour',
            'pp_express_password',
            'pp_express_username',
            'pp_express_header_colour',
            'cod_status',
            'pp_express_sort_order',
            'pp_front_text',
            'pp_express_signature',

            'pp_express_status',
            'pp_charge_payment',
            'pp_express_test',
            'pp_sandbox_secret',
            'pp_sandbox_clint',
        ]);

        $paypal = [];

        foreach ($key as $row)
        {
            if($user_group_id == 1)
            {
                $query = Settings::select('value')->where('store_id', $current_store_id)->where('key', $row)->first();
            }
            else
            {
                $query = Settings::select('value')->where('store_id', $user_shop_id)->where('key', $row)->first();
            }

            $paypal[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.paymentsetting.paypalsetting', compact('paypal'));
    }

    // paylal setting store/update
    public function storepaypalsetting(Request $request)
    {
        $request->validate([
            'clint_id' => 'required',
            'clint_secret' => 'required',
        ]);
        // Current Store ID
       $current_store_id = currentStoreId();

       $user_details = user_details();
       if(isset($user_details))
       {
           $user_group_id = $user_details['user_group_id'];
       }
       $user_shop_id = $user_details['user_shop'];

        $data['pp_express_username'] = $request->apiusername;
        $data['pp_express_password'] = $request->apipassword;
        $data['pp_express_signature'] = $request->apisignature;
        // $data['cod_order_status_id'] = 1;
        $data['pp_express_total'] = 1;
        $data['pp_charge_payment'] = $request->paycharge;
        $data['pp_express_geo_zone_id'] = 0;
        // $data['pp_front_text'] = $request->deliverytext;
        $data['pp_printer_text'] = $request->printertext;
        $data['cod_status'] = 1;
        $data['current_store_id'] = $current_store_id ;
        $data['pp_front_text'] = $request->fronttext;
        $data['pp_express_sort_order'] = $request->sortorder;
        $data['pp_sandbox_secret'] = $request->clint_secret;
        $data['pp_sandbox_clint'] = $request->clint_id;
        $data['pp_express_test'] = $request->paypalmod;
        $data['pp_express_status'] = $request->paypal_status;


        foreach ($data as $key => $new)
        {
            if($user_group_id == 1)
            {
                $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            }
            else
            {
                $query = Settings::where('store_id', $user_shop_id)->where('key', $key)->first();
            }

            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '') {
                $cod_update = Settings::find($setting_id);
                $cod_update->value = $new;
                $cod_update->update();
            } else {
                $cod_add = new Settings();
                if($user_group_id == 1)
                {
                    $cod_add->store_id = $current_store_id;
                }
                else
                {
                    $cod_add->store_id = $user_shop_id;
                }
                $cod_add->group = 'pp_express';
                $cod_add->key = $key;
                $cod_add->value = $new;
                $cod_add->serialized = 0;
                $cod_add->save();
            }
        }
        return redirect()->back()->with('success', 'Settings Updated..');
    }

    // stripe setting view
    public function stripesetting()
    {
        $orderstatus = OrderStatus::get();

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $key = ([
            'stripe_publickey',
            'stripe_secretkey',
            'stripe_charge_payment',
            'stripe_geo_zone_id',
            'stripe_printer_text',
            'stripe_order_status',
            'stripe_orderstatus_faild',
            'stripe_status',
        ]);

        $stripe = [];

        foreach ($key as $row)
        {
            if($user_group_id == 1)
            {
                $query = Settings::select('value')->where('store_id', $current_store_id)->where('key', $row)->first();
            }
            else
            {
                $query = Settings::select('value')->where('store_id', $user_shop_id)->where('key', $row)->first();
            }

            $stripe[$row] = isset($query->value) ? $query->value : '';
        }
        return view('admin.paymentsetting.stripesetting', compact('orderstatus','stripe'));
    }

    public function storestripesetting(Request $request)
    {
        $request->validate([
            'public_key' => 'required',
            'secret_key' => 'required',
        ]);
        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $data['stripe_publickey'] = $request->public_key;
        $data['stripe_secretkey'] = $request->secret_key;
        $data['stripe_charge_payment'] = $request->paycharge;
        $data['stripe_geo_zone_id'] = 0;
        $data['stripe_printer_text'] = $request->printertext;
        // $data['stripe_order_status'] = $request->order_status;
        // $data['stripe_orderstatus_faild'] = $request->orderstatus_faild;
        $data['stripe_status'] = $request->stripe_status;


        foreach ($data as $key => $new)
        {
            if($user_group_id == 1)
            {
                $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            }
            else
            {
                $query = Settings::where('store_id', $user_shop_id)->where('key', $key)->first();
            }

            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '') {
                $stripe_update = Settings::find($setting_id);
                $stripe_update->value = $new;
                $stripe_update->update();
            } else {
                $stripe_add = new Settings();
                if($user_group_id == 1)
                {
                    $stripe_add->store_id = $current_store_id;
                }
                else
                {
                    $stripe_add->store_id = $user_shop_id;
                }
                $stripe_add->group = 'stripe';
                $stripe_add->key = $key;
                $stripe_add->value = $new;
                $stripe_add->serialized = 0;
                $stripe_add->save();
            }
        }
        return redirect()->back()->with('success', 'Settings Updated..');
    }

    public function paymentstatus(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // cod status
        if ($request->p_type == 'cod_status') {
            $data['cod_status'] = $request->p_status;
        }

        // paypal status
        if ($request->p_type == 'paypal_status') {
            $data['pp_express_status'] = $request->p_status;
        }

        // stripe status
        if ($request->p_type == 'stripe_status') {
            $data['stripe_status'] = $request->p_status;
        }

        foreach ($data as $key => $new)
        {
            if($user_group_id == 1)
            {
                $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            }
            else
            {
                $query = Settings::where('store_id', $user_shop_id)->where('key', $key)->first();
            }

            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '') {
                $stripe_update = Settings::find($setting_id);
                $stripe_update->value = $new;
                $stripe_update->update();
            } else {
                $stripe_add = new Settings();
                if($user_group_id == 1)
                {
                    $stripe_add->store_id = $current_store_id;
                }
                else
                {
                    $stripe_add->store_id = $user_shop_id;
                }
                $stripe_add->group = 'stripe';
                $stripe_add->key = $key;
                $stripe_add->value = $new;
                $stripe_add->serialized = 0;
                $stripe_add->save();
            }
        }
    }

}
