<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function mapandcategory()
    {
        return view('admin.settings.map_and_category');
    }


    public function shopsettings()
    {
        return view('admin.settings.shop_settings');
    }


    public function appsettings()
    {
        return view('admin.settings.app_settings');
    }


    public function openclosetime()
    {
        return view('admin.settings.open_close_time_settings');
    }


    public function deliverycollectionsetting()
    {
        return view('admin.settings.delivery_collection_setting');
    }


    public function paymentsettings()
    {
        return view('admin.settings.payment_settings');
    }


    public function sociallinks()
    {
        return view('admin.settings.social_links_settings');
    }

    public function updatesociallinks(Request $request)
    {
        $current_store_id = currentStoreId();

        $data['polianna_facebook_id'] = $request->polianna_facebook_id;
        $data['polianna_twitter_username'] = $request->polianna_twitter_username;
        $data['polianna_gplus_id'] = $request->polianna_gplus_id;
        $data['polianna_linkedin_id'] = $request->polianna_linkedin_id;
        $data['polianna_youtube_id'] = $request->polianna_youtube_id;

        foreach($data as $key => $new)
        {
            $query = Settings::where('store_id',$current_store_id)->where('key',$key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';

            if(!empty($setting_id) || $setting_id != '')
            {
                $social_update = Settings::find($setting_id);
                $social_update->value = $new;
                $social_update->update();
            }
        }

        return redirect()->route('sociallinks')->with('success','Settings Updated..');

    }
}
