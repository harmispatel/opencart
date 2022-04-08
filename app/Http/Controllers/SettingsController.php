<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Region;
use App\Models\Settings;
use Illuminate\Http\Request;
use DateTime;

class SettingsController extends Controller
{

    private $times = array(
        '00:00' => 'Start day',
        '01:00' => "1:00 AM",
        '02:00' => "2:00 AM",
        '03:00' => "3:00 AM",
        '04:00' => "4:00 AM",
        '05:00' => "5:00 AM",
        '06:00' => "6:00 AM",
        '07:00' => "7:00 AM",
        '08:00' => "8:00 AM",
        '09:00' => "9:00 AM",
        '10:00' => "10:00 AM",
        '11:00' => "11:00 AM",
        '12:00' => "12:00 AM",
        '13:00' => "1:00 PM",
        '14:00' => "2:00 PM",
        '15:00' => "3:00 PM",
        '16:00' => "4:00 PM",
        '17:00' => "5:00 PM",
        '18:00' => "6:00 PM",
        '19:00' => "7:00 PM",
        '20:00' => "8:00 PM",
        '21:00' => "9:00 PM",
        '22:00' => "10:00 PM",
        '23:00' => "11:00 PM",
        '23:59' => 'End day'
    );

    public function openclosetime()
    {
        $minitunes = array('00', '10', '20', '30', '40', '50');
        $timearray = array();
        $timearray['00:00'] = '00:00';
        for ($i = 0; $i <= 23; $i++) {
            foreach ($minitunes as $phut) {
                $timearray[$i . ':' . $phut] = $i . ':' . $phut;
            }
        }
        $timearray['23:59'] = '23:59';
        $data['times'] = $this->times = $timearray;


        $data['days'] = array(
            '0' => "Every day",
            '2' => 'Monday',
            '3' => 'Tuesday',
            '4' => 'Wednesday',
            '5' => 'Thursday',
            '6' => 'Friday',
            '7' => 'Saturday',
            '8' => 'Sunday',
        );
        return view('admin.settings.open_close_time_settings', $data);
    }

    public function mapandcategory()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $language = Language::get();
        $currency = Currency::get();
        $countries = Country::get();

        $key = ([
            'config_url',
            'config_secure',
            'config_ssl',
            'config_name',
            'config_owner',
            'config_address',
            'config_zone_id',
            'map_post_code',
            'config_country_id',
            'map_ifram',
            'sitemap_url',
            'config_telephone',
            'config_fax',
            'config_language',
            'config_currency',
            'config_title',
            'config_meta_description',
            'config_logo',
            'config_icon',
            'grecaptcha',
            'enable_booking_module',
            'file_directory_url',
            'service_charge_type',
            'service_charge',
            'config_email',
            'sms_api_url',
            'sms_notification_status',
            'sms_notification_time',
            'sms_notification_number',
            'config_account_printer',
            'config_password_printer',
            'enable_ajax_checkout',
            'enable_notify_email',
            'enable_res_api',
            'enable_msg_api',
            'suspend_permanently',
            'suspend_for',
            'suspend_logo',
            'suspend_time',
            'suspend_title',
            'suspend_description',
        ]);

        $map_category = [];

        foreach($key as $row)
        {
            $query = Settings::select('value')->where('store_id',$current_store_id)->where('key',$row)->first();

            $map_category[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settings.map_and_category',compact(['map_category','language','currency','countries']));
    }

    public function geteditregionbycountry(Request $request)
    {
        $country_id = $request->country_id;

        $edit_zone_id = isset($request->edit_zone_id) ? $request->edit_zone_id : '';

       if(!empty($country_id))
       {
            $regions = Region::where('country_id',$country_id)->get();

            $html = "";

            if(count($regions) > 0)
            {
                foreach($regions as $region)
                {
                    $html .= '<option value="'.$region->zone_id.'"';
                    if($edit_zone_id == $region->zone_id)
                    {
                        $html .= 'selected';
                    }
                    else
                    {
                        $html .= '';
                    }
                    $html .= '>'.$region->name.'</option>';
                }
                return response()->json($html);
            }
       }
    }


    public function getregionbycountry(Request $request)
    {
        $country_id = $request->country_id;

       if(!empty($country_id))
       {
            $regions = Region::where('country_id',$country_id)->get();

            $html = "";

            if(count($regions) > 0)
            {
                foreach($regions as $region)
                {
                    $html .= '<option value="'.$region->zone_id.'">'.$region->name.'</option>';
                }
                return response()->json($html);
            }
       }
    }

    public function updatemapandcategory(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $setting_page = $request->setting;

        $data['config_url'] = isset($request->config_url) ? $request->config_url : '';
        $data['config_secure'] = isset($request->config_secure) ? $request->config_secure : 0;
        $data['config_ssl'] = isset($request->config_ssl) ? $request->config_ssl : '';
        $data['config_name'] = isset($request->config_name) ? $request->config_name : '';
        $data['config_owner'] = isset($request->config_owner) ? $request->config_owner : '';
        $data['config_address'] = isset($request->config_address) ? $request->config_address : '';
        $data['config_zone_id'] = isset($request->config_zone_id) ? $request->config_zone_id : '';
        $data['map_post_code'] = isset($request->map_post_code) ? $request->map_post_code : '';
        $data['config_country_id'] = isset($request->config_country_id) ? $request->config_country_id : '';
        $data['map_ifram'] = isset($request->map_ifram) ? $request->map_ifram : '';
        $data['sitemap_url'] = isset($request->sitemap_url) ? $request->sitemap_url : '';
        $data['config_telephone'] = isset($request->config_telephone) ? $request->config_telephone : '';
        $data['config_fax'] = isset($request->config_fax) ? $request->config_fax : '';
        $data['config_language'] = isset($request->config_language) ? $request->config_language : '';
        $data['config_currency'] = isset($request->config_currency) ? $request->config_currency : '';
        $data['config_title'] = isset($request->config_title) ? $request->config_title : '';
        $data['config_meta_description'] = isset($request->config_meta_description) ? $request->config_meta_description : '';

        if($request->hasFile('config_logo'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','config_logo')->first();

            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $logo_name = time().'.'.$request->file('config_logo')->getClientOriginalExtension();
            $request->file('config_logo')->move(public_path('admin/store_images/logo'),$logo_name);
            $data['config_logo'] = 'public/admin/store_images/logo/'.$logo_name;
        }


        if($request->hasFile('config_icon'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','config_icon')->first();

            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $icon_name = time().'.'.$request->file('config_icon')->getClientOriginalExtension();
            $request->file('config_icon')->move(public_path('admin/store_images/icon'),$icon_name);
            $data['config_icon'] = 'public/admin/store_images/icon/'.$logo_name;
        }


        $data['grecaptcha'] = isset($request->grecaptcha) ? $request->grecaptcha : '';
        $data['enable_booking_module'] = isset($request->enable_booking_module) ? $request->enable_booking_module : '';
        $data['file_directory_url'] = isset($request->file_directory_url) ? $request->file_directory_url : '';
        $data['service_charge_type'] = isset($request->service_charge_type) ? $request->service_charge_type : '';
        $data['service_charge'] = isset($request->service_charge) ? $request->service_charge : '';
        $data['config_email'] = isset($request->config_email) ? $request->config_email : '';
        $data['sms_api_url'] = isset($request->sms_api_url) ? $request->sms_api_url : '';
        $data['sms_notification_status'] = isset($request->sms_notification_status) ? $request->sms_notification_status : '';
        $data['sms_notification_time'] = isset($request->sms_notification_time) ? $request->sms_notification_time : '';
        $data['sms_notification_number'] = isset($request->sms_notification_number) ? $request->sms_notification_number : '';
        $data['config_account_printer'] = isset($request->config_account_printer) ? $request->config_account_printer : '';
        $data['config_password_printer'] = isset($request->config_password_printer) ? $request->config_password_printer : '';
        $data['enable_ajax_checkout'] = isset($request->enable_ajax_checkout) ? $request->enable_ajax_checkout : '';
        $data['enable_notify_email'] = isset($request->enable_notify_email) ? $request->enable_notify_email : '';
        $data['enable_res_api'] = isset($request->enable_res_api) ? $request->enable_res_api : '';
        $data['enable_msg_api'] = isset($request->enable_msg_api) ? $request->enable_msg_api : '';
        $data['suspend_permanently'] = isset($request->suspend_permanently) ? $request->suspend_permanently : 'no';
        $data['suspend_for'] = isset($request->suspend_for) ? $request->suspend_for : '';
        $data['suspend_time'] = isset($request->suspend_time) ? $request->suspend_time : '';

        if($request->hasFile('suspend_logo'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','suspend_logo')->first();

            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $suspend_logo_name = time().'.'.$request->file('suspend_logo')->getClientOriginalExtension();
            $request->file('suspend_logo')->move(public_path('admin/store_images/suspend_logo'),$suspend_logo_name);
            $data['suspend_logo'] = 'public/admin/store_images/suspend_logo/'.$suspend_logo_name;
        }

        $data['suspend_title'] = isset($request->suspend_title) ? $request->suspend_title : '';
        $data['suspend_description'] = isset($request->suspend_description) ? $request->suspend_description : '';

       foreach($data as $key => $new)
       {
            $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '')
            {
                $map_update = Settings::find($setting_id);
                $map_update->value = $new;
                $map_update->update();
            }
            else
            {
                $map_add = new Settings();
                $map_add->store_id = $current_store_id;
                $map_add->group = 'config';
                $map_add->key = $key;
                $map_add->value = $new;
                $map_add->serialized = 0;
                $map_add->save();
            }
        }

        if($setting_page == 'map')
        {
            return redirect()->route('mapandcategory')->with('success', 'Settings Updated..');
        }
        else
        {
            return redirect()->route('shopsettings')->with('success', 'Settings Updated..');
        }

    }


    public function shopsettings()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $language = Language::get();
        $currency = Currency::get();
        $countries = Country::get();

        $key = ([
            'config_url',
            'config_secure',
            'config_ssl',
            'config_name',
            'config_owner',
            'config_address',
            'config_zone_id',
            'map_post_code',
            'config_country_id',
            'map_ifram',
            'sitemap_url',
            'config_telephone',
            'config_fax',
            'config_language',
            'config_currency',
            'config_title',
            'config_meta_description',
            'config_logo',
            'config_icon',
            'grecaptcha',
            'enable_booking_module',
            'file_directory_url',
            'service_charge_type',
            'service_charge',
            'config_email',
            'sms_api_url',
            'sms_notification_status',
            'sms_notification_time',
            'sms_notification_number',
            'config_account_printer',
            'config_password_printer',
            'enable_ajax_checkout',
            'enable_notify_email',
            'enable_res_api',
            'enable_msg_api',
            'suspend_permanently',
            'suspend_for',
            'suspend_logo',
            'suspend_time',
            'suspend_title',
            'suspend_description',
        ]);

        $map_category = [];

        foreach($key as $row)
        {
            $query = Settings::select('value')->where('store_id',$current_store_id)->where('key',$row)->first();

            $map_category[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settings.shop_settings',compact(['map_category','language','currency','countries']));

    }


    public function appsettings()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $key = ([
            'android_app_id',
            'apple_app_id',
            'app_available',
            'home_bg_color',
            'menu_background_image',
            'polianna_logo_bg_color',
            'polianna_menu_cross_color',
            'polianna_notification_bg_color',
            'polianna_notification_font_color',
            'title_image_url',
        ]);

        $map_category = [];

        foreach($key as $row)
        {
            $query = Settings::select('value')->where('store_id',$current_store_id)->where('key',$row)->first();

            $map_category[$row] = isset($query->value) ? $query->value : '';
        }
        return view('admin.settings.app_settings',compact(['map_category']));
    }

    public function updateappsettings(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $data['android_app_id'] = isset($request->android_app_id) ? $request->android_app_id : '';
        $data['apple_app_id'] = isset($request->apple_app_id) ? $request->apple_app_id : '';
        $data['app_available'] = isset($request->app_available) ? $request->app_available : '';
        $data['home_bg_color'] = isset($request->home_bg_color) ? $request->home_bg_color : '';

        if($request->hasFile('menu_background_image'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','menu_background_image')->first();

            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $menu_background_image = time().'.'.$request->file('menu_background_image')->getClientOriginalExtension();
            $request->file('menu_background_image')->move(public_path('admin/app_backgrounds'),$menu_background_image);
            $data['menu_background_image'] = 'public/admin/app_backgrounds/'.$menu_background_image;
        }

        $data['polianna_logo_bg_color'] = isset($request->polianna_logo_bg_color) ? $request->polianna_logo_bg_color : '';
        $data['polianna_menu_cross_color'] = isset($request->polianna_menu_cross_color) ? $request->polianna_menu_cross_color : '';
        $data['polianna_notification_bg_color'] = isset($request->polianna_notification_bg_color) ? $request->polianna_notification_bg_color : '';
        $data['polianna_notification_font_color'] = isset($request->polianna_notification_font_color) ? $request->polianna_notification_font_color : '';
        $data['title_image_url'] = isset($request->title_image_url) ? $request->title_image_url : '';

        foreach($data as $key => $new)
        {
            $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';

            if (!empty($setting_id) || $setting_id != '')
            {
                $app_setting = Settings::find($setting_id);
                $app_setting->value = $new;
                $app_setting->update();
            }
            else
            {
                $app_setting = new Settings();
                $app_setting->store_id = $current_store_id;
                $app_setting->group = 'config';
                $app_setting->key = $key;
                $app_setting->value = $new;
                $app_setting->serialized = 0;
                $app_setting->save();
            }
        }
        return redirect()->route('appsettings')->with('success', 'Settings Updated..');
    }

    //open close time start
    // public function openclosetime()
    // {
    //     $data['days'] = array(
    //         '0' => "Every day",
    //         '2' => 'Monday',
    //         '3' => 'Tuesday',
    //         '4' => 'Wednesday',
    //         '5' => 'Thursday',
    //         '6' => 'Friday',
    //         '7' => 'Saturday',
    //         '8' => 'Sunday',
    //     );
    // }

    //open close time end

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

        foreach ($data as $key => $new) {
            $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';

            if (!empty($setting_id) || $setting_id != '') {
                $social_update = Settings::find($setting_id);
                $social_update->value = $new;
                $social_update->update();
            }
        }

        return redirect()->route('sociallinks')->with('success', 'Settings Updated..');
    }

    // openclosetimeset
    public function openclosetimeset(Request $request)
    {
        $business = $request['bussines'];
        $bissinessdays = serialize($request['bussines']);
        $closingdate = serialize($request->closingdate);
        $delivery = serialize($request['delivery']);
        $collection = serialize($request['collection']);
        echo '<pre>';
        // print_r($bissinessdays);
        // print_r($closingdate);
        print_r($collection);
        exit();
    }
}
