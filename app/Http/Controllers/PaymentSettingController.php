<?php

namespace App\Http\Controllers;

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
        // echo '<pre>';
        // print_r($request->all());
        // exit();
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
        $data['cod_status'] = 0;
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

}
