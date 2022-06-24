<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\DeliverySettingFeeds;
use App\Models\DeliverySettings;
use App\Models\Language;
use App\Models\Postcodes;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Store;
use Illuminate\Http\Request;
use DateTime;

use function PHPUnit\Framework\returnSelf;

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





    private $days = array(
        '0' => "Every day",
        '1' => 'Monday',
        '2' => 'Tuesday',
        '3' => 'Wednesday',
        '4' => 'Thursday',
        '5' => 'Friday',
        '6' => 'Saturday',
        '7' => 'Sunday',
    );





     // OpenCloseTime
    public function openclosetime(Request $request)
    {
        // Check User Permission
        if(check_user_role(85) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $minitunes = array('00', '10', '20', '30', '40', '50');
        $timearray = array();
        $timearray['00:00'] = '00:00';
        for ($i = 0; $i <= 23; $i++) {
            foreach ($minitunes as $phut) {
                $timearray[$i . ':' . $phut] = $i . ':' . $phut;
            }
        }
        $timearray['23:59'] = '23:59';
        $times = $this->times = $timearray;


        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $key = ([
            'opening_time_collection',
            'opening_time_delivery',
            'opening_time_bussness',
            'business_closing_dates',
            'order_outof_bussiness_time',
            'collection',
            'collection_gaptime',
            'collection_same_bussiness',
            'delivery',
            'delivery_gaptime',
            'delivery_same_bussiness',
            'closing_dates',
            'bussines',
        ]);

        $open_close = [];

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

            $open_close[$row] = isset($query->value) ? $query->value : '';
        }

        $closedate = unserialize($open_close['closing_dates']);
        $delivery = unserialize($open_close['delivery']);
        $collection = unserialize($open_close['collection']);
        $timesetting = $open_close;
        $bussines = unserialize($open_close['bussines']);
        $days = $this->days;

        return view('admin.settings.open_close_time_settings', compact(['days', 'timesetting', 'times', 'bussines', 'closedate', 'delivery', 'collection']));
    }





    // Create New Store
    public function createstore()
    {
        $language = Language::get();
        $currency = Currency::get();
        $countries = Country::get();
        return view('admin.settings.create_store',compact('countries','language','currency'));
    }





    // Map And Categoty
    public function mapandcategory()
    {



        // Check User Permission
        if(check_user_role(80) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

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

            $map_category[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settings.map_and_category', compact(['map_category', 'language', 'currency', 'countries']));
    }





    // Get Edit  Region By Country
    public function geteditregionbycountry(Request $request)
    {
        $country_id = $request->country_id;

        $edit_zone_id = isset($request->edit_zone_id) ? $request->edit_zone_id : '';

        if (!empty($country_id)) {
            $regions = Region::where('country_id', $country_id)->get();

            $html = "";

            if (count($regions) > 0) {
                foreach ($regions as $region) {
                    $html .= '<option value="' . $region->zone_id . '"';
                    if ($edit_zone_id == $region->zone_id) {
                        $html .= 'selected';
                    } else {
                        $html .= '';
                    }
                    $html .= '>' . $region->name . '</option>';
                }
                return response()->json($html);
            }
        }
    }





    // Get  Region By Country
    public function getregionbycountry(Request $request)
    {
        $country_id = $request->country_id;

        if (!empty($country_id)) {
            $regions = Region::where('country_id', $country_id)->get();

            $html = "";

            if (count($regions) > 0) {
                foreach ($regions as $region) {
                    $html .= '<option value="' . $region->zone_id . '">' . $region->name . '</option>';
                }
                return response()->json($html);
            }
        }
    }




    // Update  Map And Categoty
    public function updatemapandcategory(Request $request)
    {
        // Check User Permission
        if(check_user_role(81) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $request->validate([
            'config_url' => 'required',
            'config_ssl' => 'required',
            'config_name' => 'required',
            'config_owner' => 'required',
            'config_address' => 'required',
            'config_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'map_post_code' => 'required',
            'config_country_id' => 'required',
            'config_zone_id' => 'required',
            'config_telephone' => 'required',
            'config_title' => 'required',
            'file_directory_url' => 'required',
            'config_email' => 'required|email',
            'config_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'suspend_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

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
        if ($request->hasFile('config_logo'))
        {
            if($user_group_id == 1)
            {
                $old = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'config_logo')->first();
            }
            else
            {
                $old = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'config_logo')->first();
            }

            $old_name = isset($old->value) ? $old->value : '';

            if (!empty($old_name) || $old_name != '') {
                if (file_exists($old_name)) {
                    unlink($old_name);
                }
            }

            $logo_name = time() . '.' . $request->file('config_logo')->getClientOriginalExtension();
            $request->file('config_logo')->move(public_path('admin/store_images/logo'), $logo_name);
            $data['config_logo'] = 'public/admin/store_images/logo/' . $logo_name;
        }


        if ($request->hasFile('config_icon'))
        {
            if($user_group_id == 1)
            {
                $old = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'config_icon')->first();
            }
            else
            {
                $old = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'config_icon')->first();
            }

            $old_name = isset($old->value) ? $old->value : '';

            if (!empty($old_name) || $old_name != '') {
                if (file_exists($old_name)) {
                    unlink($old_name);
                }
            }

            $icon_name = time() . '.' . $request->file('config_icon')->getClientOriginalExtension();
            $request->file('config_icon')->move(public_path('admin/store_images/icon'), $icon_name);
            $data['config_icon'] = 'public/admin/store_images/icon/' . $logo_name;
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

        if ($request->hasFile('suspend_logo'))
        {
            if($user_group_id == 1)
            {
                $old = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'suspend_logo')->first();
            }
            else
            {
                $old = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'suspend_logo')->first();
            }

            $old_name = isset($old->value) ? $old->value : '';

            if (!empty($old_name) || $old_name != '') {
                if (file_exists($old_name)) {
                    unlink($old_name);
                }
            }

            $suspend_logo_name = time() . '.' . $request->file('suspend_logo')->getClientOriginalExtension();
            $request->file('suspend_logo')->move(public_path('admin/store_images/suspend_logo'), $suspend_logo_name);
            $data['suspend_logo'] = 'public/admin/store_images/suspend_logo/' . $suspend_logo_name;
        }

        $data['suspend_title'] = isset($request->suspend_title) ? $request->suspend_title : '';
        $data['suspend_description'] = isset($request->suspend_description) ? $request->suspend_description : '';

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
                $map_update = Settings::find($setting_id);
                $map_update->value = $new;
                $map_update->update();
            } else {
                $map_add = new Settings();
                if($user_group_id == 1)
                {
                    $map_add->store_id = $current_store_id;
                }
                else
                {
                    $map_add->store_id = $user_shop_id;
                }
                $map_add->group = 'config';
                $map_add->key = $key;
                $map_add->value = $new;
                $map_add->serialized = 0;
                $map_add->save();
            }
        }

        // Update in Store
        if($user_group_id == 1)
        {
            $store = Store::find($current_store_id);
        }
        else
        {
            $store = Store::find($user_shop_id);
        }
        $store->name = $data['config_name'];
        $store->url =  $data['config_url'];
        $store->ssl =  $data['config_ssl'];
        $store->update();

        if ($setting_page == 'map') {
            return redirect()->route('mapandcategory')->with('success', 'Settings Updated..');
        } else {
            return redirect()->route('shopsettings')->with('success', 'Settings Updated..');
        }
    }





    // Insert Store Data
    public function savestoredata(Request $request)
    {

        $request->validate([
            'config_url' => 'required',
            'config_ssl' => 'required',
            'config_name' => 'required',
            'config_owner' => 'required',
            'config_address' => 'required',
            'config_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'config_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'map_post_code' => 'required',
            'config_country_id' => 'required',
            'config_zone_id' => 'required',
            'config_telephone' => 'required',
            'config_title' => 'required',
            'file_directory_url' => 'required',
            'config_email' => 'required|email',
            'suspend_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        // save in Store
        $store = new Store;
        $store->name = $request['config_name'];
        $store->url =  $request['config_url'];
        $store->ssl =  $request['config_ssl'];
        $store->id_cat_default =  isset($request->id_cat_default) ? $request->id_cat_default : "0";
        $store->date_create = date('Y-m-d H:i:s');
        $store->save();

        $lastinsertid = $store->store_id;

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
        if ($request->hasFile('config_logo')) {

            $logo_name = time() . '.' . $request->file('config_logo')->getClientOriginalExtension();
            $request->file('config_logo')->move(public_path('admin/store_images/logo'), $logo_name);
            $data['config_logo'] = 'public/admin/store_images/logo/' . $logo_name;
        }


        if ($request->hasFile('config_icon')) {
            $icon_name = time() . '.' . $request->file('config_icon')->getClientOriginalExtension();
            $request->file('config_icon')->move(public_path('admin/store_images/icon'), $icon_name);
            $data['config_icon'] = 'public/admin/store_images/icon/' . $logo_name;
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
        $data['bussines'] = 'a:3:{s:3:"day";a:1:{i:0;a:1:{i:0;s:1:"0";}}s:4:"from";a:1:{i:0;s:4:"0:00";}s:2:"to";a:1:{i:0;s:5:"23:50";}}';
        $data['theme_id'] = 1;
        $data['enable_delivery'] = 'both';
        $data['delivery_option'] = 'post_codes';
        $data['enable_gallery_module'] = 1;


        if ($request->hasFile('suspend_logo')) {

            $suspend_logo_name = time() . '.' . $request->file('suspend_logo')->getClientOriginalExtension();
            $request->file('suspend_logo')->move(public_path('admin/store_images/suspend_logo'), $suspend_logo_name);
            $data['suspend_logo'] = 'public/admin/store_images/suspend_logo/' . $suspend_logo_name;
        }

        $data['suspend_title'] = isset($request->suspend_title) ? $request->suspend_title : '';
        $data['suspend_description'] = isset($request->suspend_description) ? $request->suspend_description : '';

        foreach ($data as $key => $new)
        {
            $shopadd = new Settings;
            $shopadd->store_id = $lastinsertid;
            if ($key == 'bussines') {
                $shopadd->group = 'timesetting';
            }
            elseif ($key == 'theme_id') {
                $shopadd->group = 'polianna';
            }
            elseif ($key == 'enable_delivery' || $key == 'delivery_option') {
                $shopadd->group = 'deliverysetting';
            }
            else {
                $shopadd->group = 'config';
            }
            $shopadd->key = $key;
            $shopadd->value = $new;
            $shopadd->serialized = 0;
            $shopadd->save();
        }

        // $dest = 'home/thepublic/public_html/App-Myfood/sites/'.$data['file_directory_url'];

        // shell_exec("cp -R /home/thepublic/public_html/App-Myfood/myfoodbasket/newsite/. /$dest");

        return redirect()->route('dashboard')->with('success', 'Settings Updated..');
    }






    // Shop setting
    public function shopsettings()
    {
        // Check User Permission
        if(check_user_role(82) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

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

            $map_category[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settings.shop_settings', compact(['map_category', 'language', 'currency', 'countries']));
    }





    // App Setting
    public function appsettings()
    {

        // Check User Permission
        if(check_user_role(83) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

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

            $map_category[$row] = isset($query->value) ? $query->value : '';
        }
        return view('admin.settings.app_settings', compact(['map_category']));
    }





    // Update App Setting
    public function updateappsettings(Request $request)
    {
        // Check User Permission
        if(check_user_role(84) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $data['android_app_id'] = isset($request->android_app_id) ? $request->android_app_id : '';
        $data['apple_app_id'] = isset($request->apple_app_id) ? $request->apple_app_id : '';
        $data['app_available'] = isset($request->app_available) ? $request->app_available : '';
        $data['home_bg_color'] = isset($request->home_bg_color) ? $request->home_bg_color : '';

        if ($request->hasFile('menu_background_image'))
        {
            if($user_group_id == 1)
            {
                $old = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'menu_background_image')->first();
            }
            else
            {
                $old = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'menu_background_image')->first();
            }

            $old_name = isset($old->value) ? $old->value : '';

            if (!empty($old_name) || $old_name != '') {
                if (file_exists($old_name)) {
                    unlink($old_name);
                }
            }

            $menu_background_image = time() . '.' . $request->file('menu_background_image')->getClientOriginalExtension();
            $request->file('menu_background_image')->move(public_path('admin/app_backgrounds'), $menu_background_image);
            $data['menu_background_image'] = 'public/admin/app_backgrounds/' . $menu_background_image;
        }

        $data['polianna_logo_bg_color'] = isset($request->polianna_logo_bg_color) ? $request->polianna_logo_bg_color : '';
        $data['polianna_menu_cross_color'] = isset($request->polianna_menu_cross_color) ? $request->polianna_menu_cross_color : '';
        $data['polianna_notification_bg_color'] = isset($request->polianna_notification_bg_color) ? $request->polianna_notification_bg_color : '';
        $data['polianna_notification_font_color'] = isset($request->polianna_notification_font_color) ? $request->polianna_notification_font_color : '';
        $data['title_image_url'] = isset($request->title_image_url) ? $request->title_image_url : '';

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
                $app_setting = Settings::find($setting_id);
                $app_setting->value = $new;
                $app_setting->update();
            } else {
                $app_setting = new Settings();
                if($user_group_id == 1)
                {
                    $app_setting->store_id = $current_store_id;
                }
                else
                {
                    $app_setting->store_id = $user_shop_id;
                }
                $app_setting->group = 'config';
                $app_setting->key = $key;
                $app_setting->value = $new;
                $app_setting->serialized = 0;
                $app_setting->save();
            }
        }
        return redirect()->route('appsettings')->with('success', 'Settings Updated..');
    }





    // Delivery Collection Setting
    public function deliverycollectionsetting()
    {
        // Check User Permission
        if(check_user_role(87) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        if($user_group_id == 1)
        {
            $data['enable_delivery'] = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'enable_delivery')->first();

            $data['delivery_option'] = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'delivery_option')->first();

            $data['is_distance_option'] = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'is_distance_option')->first();

            $data['road_mileage_percentage'] = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'road_mileage_percentage')->first();

            $data['google_distance_api_key'] = Settings::select('value')->where('store_id', $current_store_id)->where('key', 'google_distance_api_key')->first();

            $data['deliverysettings'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $current_store_id)->where('delivery_type', 'post_codes')->get();

            $data['deliverydistance'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $current_store_id)->where('delivery_type', 'distance')->get();

            $data['deliveryareas'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $current_store_id)->where('delivery_type', 'area')->get();
        }
        else
        {
            $data['enable_delivery'] = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'enable_delivery')->first();

            $data['delivery_option'] = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'delivery_option')->first();

            $data['is_distance_option'] = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'is_distance_option')->first();

            $data['road_mileage_percentage'] = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'road_mileage_percentage')->first();

            $data['google_distance_api_key'] = Settings::select('value')->where('store_id', $user_shop_id)->where('key', 'google_distance_api_key')->first();

            $data['deliverysettings'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $user_shop_id)->where('delivery_type', 'post_codes')->get();

            $data['deliverydistance'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $user_shop_id)->where('delivery_type', 'distance')->get();

            $data['deliveryareas'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store', $user_shop_id)->where('delivery_type', 'area')->get();
        }

        return view('admin.settings.delivery_collection_setting', $data);
    }





   // Calculate Distance
    public function calculateDistance(Request $request)
    {
        $current_store_id = currentStoreId();
        $keyword = $request->distance_postcode;
        $data = [];

        if (!empty($keyword) || $keyword != '') {
            $keyword = str_replace(' ', '', $keyword);
            $keyword = substr_replace($keyword, ' ' . substr($keyword, -3), -3);
            $keyword = strtoupper($keyword);

            $postcode_setting = Settings::where('group', 'config')->where('store_id', $current_store_id)->where('key', 'map_post_code')->first();
            $admin_postcode = isset($postcode_setting->value) ? $postcode_setting->value : '';

            $milage_setting = Settings::where('group', 'deliverysetting')->where('store_id', $current_store_id)->where('key', 'road_mileage_percentage')->first();
            $mileage_percentage = isset($milage_setting->value) ? $milage_setting->value : '';

            $distance_setting = Settings::where('group', 'deliverysetting')->where('store_id', $current_store_id)->where('key', 'is_distance_option')->first();
            $is_distance_option = isset($distance_setting->value) ? $distance_setting->value : '';

            $res = Postcodes::where('Postcode', $keyword)->first();

            if (isset($res)) {
                $res2 = Postcodes::where('Postcode', $admin_postcode)->first();
                $destinationLat = $res->Latitude;
                $destinationLon = $res->Longitude;
                $originLat      = $res2->Latitude;
                $originLong     = $res2->Longitude;

                if ($is_distance_option == 2) {
                    $distance_key =  Settings::where('group', 'deliverysetting')->where('store_id', $current_store_id)->where('key', 'google_distance_api_key')->first();
                    $google_distance_api_key = isset($distance_key->value) ? $distance_key->value : '';

                    if (isset($google_distance_api_key) && !empty($google_distance_api_key)) {
                        $result = calculationDistanceMatrix($originLat, $originLong, $destinationLat, $destinationLon, $google_distance_api_key);

                        if ($result['status'] == 'OK') {
                            $result = $result['rows']['0']['elements']['0'];
                            $distanceNew = str_replace(',', '.', $result['distance']['text']);
                            $json['success'] = number_format((float)$distanceNew, 2, '.', ',') . ' Miles';
                        } else {
                            $json['error'] = $result['error_message'];
                        }
                    } else {
                        $json['error'] = 'Invalid google distance api key.';
                    }
                } else {
                    if (!empty($mileage_percentage) || $mileage_percentage != '') {
                        $distance         = distance($originLat, $originLong, $destinationLat, $destinationLon, "M");
                        $distanceNew     = ($distance + ($mileage_percentage / 100) * $distance);
                        $json['success'] = number_format((float)$distanceNew, 2, '.', ',') . ' Miles';
                    } else {
                        $json['error'] = 'Please Enter Mileage Percentage.';
                    }
                }
            } else {
                $json['error'] = 'Sorry! The postcode you entered doesn\'t exist. Please try another.';
            }
        } else {
            $json['error'] = 'Please enter postcode';
        }

        return response()->json([
            'json' => $json,
        ]);
    }




    // Insert Group
    public function addGroup(Request $request)
    {
        $current_store_id = currentStoreId();
        $delivery_type = $request->delivery_type;

        $insert = new DeliverySettings;
        $insert->id_store = $current_store_id;
        $insert->delivery_type = $delivery_type;
        $insert->name = "";
        $insert->min_spend = "0.00";
        $insert->post_codes = "";
        $insert->distance = "";
        $insert->area = "";
        $insert->save();

        $get_max_id = DeliverySettings::select('id_delivery_settings')->max('id_delivery_settings');

        $max_id = isset($get_max_id) ? $get_max_id : 0;

        return response()->json([
            'max_id' => $max_id,
        ]);
    }




    // Delete Group
    public function deleteGroup(Request $request)
    {
        $delivery_setting_id = $request->id_delivery_settings;

        DeliverySettings::where('id_delivery_settings', $delivery_setting_id)->delete();

        return response()->json([
            'success' => 1,
        ]);
    }





    // Menage  Delivery Collection
    public function manageDeliveryCollection(Request $request)
    {
        // Check User Permission
        if(check_user_role(88) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $store_postcode = '';

        $data['enable_delivery'] = isset($request->enable_delivery) ? $request->enable_delivery : 'delivery';
        $data['delivery_option'] = isset($request->delivery_option) ? $request->delivery_option : 'post_codes';
        $data['is_distance_option'] = isset($request->is_distance_option) ? $request->is_distance_option : 1;
        $data['road_mileage_percentage'] = isset($request->road_mileage_percentage) ? $request->road_mileage_percentage : '';
        $data['google_distance_api_key'] = isset($request->google_distance_api_key) ? $request->google_distance_api_key : '';

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

            if (!empty($setting_id) || $setting_id != '')
            {
                $delivery_update = Settings::find($setting_id);
                $delivery_update->value = $new;
                $delivery_update->update();
            }
            else
            {
                $delivery_add = new Settings;
                if($user_group_id == 1)
                {
                    $delivery_add->store_id = $current_store_id;
                }
                else
                {
                    $delivery_add->store_id = $user_shop_id;
                }
                $delivery_add->group = 'deliverysetting';
                $delivery_add->key = $key;
                $delivery_add->value = isset($new) ? $new : '';
                $delivery_add->serialized = 0;
                $delivery_add->save();
            }

        }

        if($user_group_id == 1)
        {
            $results = DeliverySettings::where('id_store',$current_store_id)->get();
        }
        else
        {
            $results = DeliverySettings::where('id_store',$user_shop_id)->get();
        }

        foreach($results as $result)
        {
            $name = 'name_'.$result->id_delivery_settings;

            if(isset($request->$name))
            {

                $id = $result->id_delivery_settings;
                $data = $request->all();

                if($data['delivery_type_'.$id] == 'distance')
                {
                    $postcode = $data['post_codes_'.$id];

                }
                elseif($data['delivery_type_'.$id] == 'area')
                {
                    $postcode = ','.(string)trim($data['post_codes_'.$id], "\,\ ").',';
                }
                else
                {
                    $postcode = ','.(string)trim(str_replace(' ', '',$data['post_codes_'.$id]), "\,\ ").',';
                }

                $sql = DeliverySettings::find($id);
                $sql->name = $data['name_'.$id];
                $sql->min_spend = (float)$data['min_spend_'.$id];
                $sql->delivery_type = $data['delivery_type_'.$id];

                if($data['delivery_type_'.$id] == 'area')
                {
                    $sql->area = $postcode;
                }
                else
                {
                    $sql->post_codes = $postcode;
                }
                $sql->update();

                $postcode_key = 'post_codes_'.$id;

                if($user_group_id == 1)
                {
                    $qry = Settings::where('store_id',$current_store_id)->where('key',$postcode_key)->first();
                }
                else
                {
                    $qry = Settings::where('store_id',$user_shop_id)->where('key',$postcode_key)->first();
                }

                $postcode_setting_id = isset($qry->setting_id) ? $qry->setting_id : '';

                if(!empty($postcode_setting_id) || $postcode_setting_id != '')
                {
                    $update_postcode = Settings::find($postcode_setting_id);
                    $update_postcode->value = trim($data['post_codes_'.$id], ',');
                    $update_postcode->update();
                }
                else
                {
                    $postcode_add = new Settings;
                    if($user_group_id == 1)
                    {
                        $postcode_add->store_id = $current_store_id;
                    }
                    else
                    {
                        $postcode_add->store_id = $user_shop_id;
                    }
                    $postcode_add->group = 'config';
                    $postcode_add->key = $postcode_key;
                    $postcode_add->value = trim($data['post_codes_'.$id], ',');
                    $postcode_add->serialized = 0;
                    $postcode_add->save();
                }

                if(isset($data['price_shipping_'.$id]))
                {
                    DeliverySettingFeeds::where('id_delivery_settings',$id)->delete();

                    foreach($data['price_shipping_'.$id] as $key => $value)
                    {
                        $delivery_feed = new DeliverySettingFeeds;
                        $delivery_feed->id_delivery_settings = $id;
                        $delivery_feed->price_upto = (float)$data['price_upto_'.$id][$key];
                        $delivery_feed->price_shipping = (float)$data['price_shipping_'.$id][$key];
                        $delivery_feed->save();
                    }
                }

                $store_postcode .= ','.(string)trim(str_replace(' ', '',$request['post_codes_'.$result['id_delivery_settings']]), "\,\ ");

                if($user_group_id == 1)
                {
                    $qry1 = Settings::where('store_id',$current_store_id)->where('key','available_zones')->first();
                }
                else
                {
                    $qry1 = Settings::where('store_id',$user_shop_id)->where('key','available_zones')->first();
                }

                $zone_setting_id = isset($qry1->setting_id) ? $qry1->setting_id : '';

                if(!empty($zone_setting_id) || $zone_setting_id != '')
                {
                    $update_zone = Settings::find($zone_setting_id);
                    $update_zone->value = trim($store_postcode, ',');
                    $update_zone->update();
                }
                else
                {
                    $zone_add = new Settings;
                    if($user_group_id == 1)
                    {
                        $zone_add->store_id = $current_store_id;
                    }
                    else
                    {
                        $zone_add->store_id = $user_shop_id;
                    }
                    $zone_add->group = 'config';
                    $zone_add->key = 'available_zones';
                    $zone_add->value = trim($store_postcode, ',');
                    $zone_add->serialized = 0;
                    $zone_add->save();
                }

            }
        }

        return redirect()->route('deliverycollectionsetting')->with('success', 'Settings Updated..');

    }




     // Payment Setting
    public function paymentsettings()
    {
        // Check User Permission
        if(check_user_role(89) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.settings.payment_settings');
    }





    // Social Link
    public function sociallinks()
    {
        // Check User Permission
        if(check_user_role(90) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.settings.social_links_settings');
    }




    // upadate Social Link
    public function updatesociallinks(Request $request)
    {
        // Check User Permission
        if(check_user_role(91) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $data['polianna_facebook_id'] = $request->polianna_facebook_id;
        $data['polianna_twitter_username'] = $request->polianna_twitter_username;
        $data['polianna_gplus_id'] = $request->polianna_gplus_id;
        $data['polianna_linkedin_id'] = $request->polianna_linkedin_id;
        $data['polianna_youtube_id'] = $request->polianna_youtube_id;

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
                $social_update = Settings::find($setting_id);
                $social_update->value = $new;
                $social_update->update();
            } else {
                $social_add = new Settings;
                if($user_group_id == 1)
                {
                    $social_add->store_id = $current_store_id;
                }
                else
                {
                    $social_add->store_id = $user_shop_id;
                }
                $social_add->group = 'polianna';
                $social_add->key = $key;
                $social_add->value = isset($new) ? $new : '';
                $social_add->serialized = 0;
                $social_add->save();
            }
        }

        return redirect()->route('sociallinks')->with('success', 'Settings Updated..');
    }




    // openclosetimeset
    public function openclosetimeset(Request $request)
    {
        // Check User Permission
        if(check_user_role(86) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $bissinessdays = serialize($request['bussines']);
        $closingdate = serialize($request['closing_dates']);
        $delivery = serialize($request['delivery']);
        $collection = serialize($request['collection']);


        $data['bussines'] = isset($bissinessdays) ? $bissinessdays : '';
        $data['closing_dates'] = isset($closingdate) ? $closingdate : '';
        $data['delivery'] = isset($delivery) ? $delivery : '';
        $data['collection'] = isset($collection) ? $collection : '';
        $data['delivery_same_bussiness'] = isset($request->delivery_same_bussiness) ? $request->delivery_same_bussiness : '';
        $data['delivery_gaptime'] = isset($request->delivery_gaptime) ? $request->delivery_gaptime : '';
        $data['collection_same_bussiness'] = isset($request->collection_same_bussiness) ? $request->collection_same_bussiness : '';
        $data['collection_gaptime'] = isset($request->collection_gaptime) ? $request->collection_gaptime : '';
        $data['order_outof_bussiness_time'] = $request->order_outof_bussiness_time;

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
                $timesetting = Settings::find($setting_id);
                $timesetting->value = $new;
                $timesetting->update();
            } else {
                $timesetting = new Settings();
                if($user_group_id == 1)
                {
                    $timesetting->store_id = $current_store_id;
                }
                else
                {
                    $timesetting->store_id = $user_shop_id;
                }
                $timesetting->group = 'timesetting';
                $timesetting->key = $key;
                $timesetting->value = $new;
                $timesetting->serialized = 1;
                $timesetting->save();
            }
        }


        // time bussiness
        $opening_time_bussiness = $opening_time_delivery = $opening_time_collection = '';
        $Everyday = $Monday = $Tuesday = $Wednesday = $Thursday = $Friday = $Saturday = $Sunday = array();

        $timesetting = $request->all();
        if (isset($timesetting['bussines']['day']) && count($timesetting['bussines']['day'])) {
            foreach ($this->days as $keyday => $day) {
                foreach ($timesetting['bussines']['day'] as $keybussines => $bussinesday) {
                    if (in_array($keyday, $bussinesday)) {
                        switch ($keyday) {
                            case 0:
                                $Everyday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 1:
                                $Monday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 2:
                                $Tuesday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 3:
                                $Wednesday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 4:
                                $Thursday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 5:
                                $Friday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 6:
                                $Saturday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                            case 7:
                                $Sunday[] = $timesetting['bussines']['from'][$keybussines] . '-' . $timesetting['bussines']['to'][$keybussines];
                                break;
                        }
                    }
                }
            }
            if (count($Monday) || count($Everyday)) $opening_time_bussiness .= ' Monday,' . implode('|', array_merge($Monday, $Everyday));
            if (count($Tuesday) || count($Everyday)) $opening_time_bussiness .= ' Tuesday,' . implode('|', array_merge($Tuesday, $Everyday));
            if (count($Wednesday) || count($Everyday)) $opening_time_bussiness .= ' Wednesday,' . implode('|', array_merge($Wednesday, $Everyday));
            if (count($Thursday) || count($Everyday)) $opening_time_bussiness .= ' Thursday,' . implode('|', array_merge($Thursday, $Everyday));
            if (count($Friday) || count($Everyday)) $opening_time_bussiness .= ' Friday,' . implode('|', array_merge($Friday, $Everyday));
            if (count($Saturday) || count($Everyday)) $opening_time_bussiness .= ' Saturday,' . implode('|', array_merge($Saturday, $Everyday));
            if (count($Sunday) || count($Everyday)) $opening_time_bussiness .= ' Sunday,' . implode('|', array_merge($Sunday, $Everyday));
        }
        /** time delivery */
        $Everyday = $Monday = $Tuesday = $Wednesday = $Thursday = $Friday = $Saturday = $Sunday = array();
        if (isset($timesetting['delivery_same_bussiness']) && $timesetting['delivery_same_bussiness'] == 1) {
            $opening_time_delivery = $opening_time_bussiness;
        } else if (isset($timesetting['delivery']['day']) && count($timesetting['delivery']['day'])) {
            foreach ($this->days as $keyday => $day) {
                foreach ($timesetting['delivery']['day'] as $keydelivery => $deliveryday) {
                    if (in_array($keyday, $deliveryday)) {
                        switch ($keyday) {
                            case 0:
                                $Everyday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 1:
                                $Monday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 2:
                                $Tuesday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 3:
                                $Wednesday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 4:
                                $Thursday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 5:
                                $Friday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 6:
                                $Saturday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                            case 7:
                                $Sunday[] = $timesetting['delivery']['from'][$keydelivery] . '-' . $timesetting['delivery']['to'][$keydelivery];
                                break;
                        }
                    }
                }
            }
            if (count($Monday) || count($Everyday)) $opening_time_delivery .= ' Monday,' . implode('|', array_merge($Monday, $Everyday));
            if (count($Tuesday) || count($Everyday)) $opening_time_delivery .= ' Tuesday,' . implode('|', array_merge($Tuesday, $Everyday));
            if (count($Wednesday) || count($Everyday)) $opening_time_delivery .= ' Wednesday,' . implode('|', array_merge($Wednesday, $Everyday));
            if (count($Thursday) || count($Everyday)) $opening_time_delivery .= ' Thursday,' . implode('|', array_merge($Thursday, $Everyday));
            if (count($Friday) || count($Everyday)) $opening_time_delivery .= ' Friday,' . implode('|', array_merge($Friday, $Everyday));
            if (count($Saturday) || count($Everyday)) $opening_time_delivery .= ' Saturday,' . implode('|', array_merge($Saturday, $Everyday));
            if (count($Sunday) || count($Everyday)) $opening_time_delivery .= ' Sunday,' . implode('|', array_merge($Sunday, $Everyday));
        }
        //time collection
        $Everyday = $Monday = $Tuesday = $Wednesday = $Thursday = $Friday = $Saturday = $Sunday = array();
        if (isset($timesetting['collection_same_bussiness']) && $timesetting['collection_same_bussiness'] == 1) {
            $opening_time_collection = $opening_time_bussiness;
        } else if (isset($timesetting['collection']['day']) && count($timesetting['collection']['day'])) {
            foreach ($this->days as $keyday => $day) {
                foreach ($timesetting['collection']['day'] as $keycollection => $collectionday) {
                    if (in_array($keyday, $collectionday)) {
                        switch ($keyday) {
                            case 0:
                                $Everyday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 1:
                                $Monday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 2:
                                $Tuesday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 3:
                                $Wednesday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 4:
                                $Thursday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 5:
                                $Friday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 6:
                                $Saturday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                            case 7:
                                $Sunday[] = $timesetting['collection']['from'][$keycollection] . '-' . $timesetting['collection']['to'][$keycollection];
                                break;
                        }
                    }
                }
            }
            if (count($Monday) || count($Everyday)) $opening_time_collection .= ' Monday,' . implode('|', array_merge($Monday, $Everyday));
            if (count($Tuesday) || count($Everyday)) $opening_time_collection .= ' Tuesday,' . implode('|', array_merge($Tuesday, $Everyday));
            if (count($Wednesday) || count($Everyday)) $opening_time_collection .= ' Wednesday,' . implode('|', array_merge($Wednesday, $Everyday));
            if (count($Thursday) || count($Everyday)) $opening_time_collection .= ' Thursday,' . implode('|', array_merge($Thursday, $Everyday));
            if (count($Friday) || count($Everyday)) $opening_time_collection .= ' Friday,' . implode('|', array_merge($Friday, $Everyday));
            if (count($Saturday) || count($Everyday)) $opening_time_collection .= ' Saturday,' . implode('|', array_merge($Saturday, $Everyday));
            if (count($Sunday) || count($Everyday)) $opening_time_collection .= ' Sunday,' . implode('|', array_merge($Sunday, $Everyday));
        }


        //Closing Dates
        if (isset($timesetting['closing_dates'])) {
            $closing_dates = implode(',', array_filter($timesetting['closing_dates']));
            $data['business_closing_dates'] = trim($closing_dates);
        }


        $data['opening_time_bussness'] = trim($opening_time_bussiness);
        $data['opening_time_delivery'] = trim($opening_time_delivery);
        $data['opening_time_collection'] = trim($opening_time_collection);

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
                $timesetting = Settings::find($setting_id);
                $timesetting->value = $new;
                $timesetting->update();
            } else {
                $timesetting = new Settings();
                if($user_group_id == 1)
                {
                    $timesetting->store_id = $current_store_id;
                }
                else
                {
                    $timesetting->store_id = $user_shop_id;
                }
                $timesetting->group = 'config_time';
                $timesetting->key = $key;
                $timesetting->value = $new;
                $timesetting->serialized = 1;
                $timesetting->save();
            }
        }
        return redirect()->route('openclosetime')->with('success', 'Open/Close time Updated..');
    }




    // Day Time
    public function daytime(Request $request)
    {
        $number = $request->number;
        $type = $request->type;

        $pre_drop = $request->pre_drop;

        $days = $this->days;

        $minitunes = array('00', '10', '20', '30', '40', '50');
        $timearray = array();
        $timearray['00:00'] = '00:00';
        for ($i = 0; $i <= 23; $i++) {
            foreach ($minitunes as $phut) {
                $timearray[$i . ':' . $phut] = $i . ':' . $phut;
            }
        }
        $timearray['23:59'] = '23:59';
        $times1 = $this->times = $timearray;

        $html = '';
        $html .= '<div class="col-sm-12" id="' . $type . '_' . $number . '">';
        $html .= '<div class="d-flex justify-content-between">';
        $html .= '<div class="form-group col-sm-6">';
        $html .= '<select class="selectday form-control" name="' . $type . '[day][' . $number . '][]" class="form-control" multiple>';
        foreach ($days as $key => $day) {
            $html .= '<option value="' . $key . '">' . $day . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="d-flex">';
        $html .= '<div class="form-group">';
        $html .= '<select class="selectday form-control" name="' . $type . '[from][' . $number . ']" class="form-control" style="width: 100% !importent;">';
        foreach ($times1 as $key => $time) {
            // $html .= '<option '.($key == "0:00") ? "selected" : "".' value="'.$key.'">'.$time.'</option>';
            $html .= '<option >' . $time . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="form-group px-3">';
        $html .= '<select class="selectday form-control" name="' . $type . '[to][' . $number . ']" class="form-control" style="width: 100% !importent;">';
        foreach ($times1 as $key => $time) {
            $html .= '<option ';
            if ($key == "23:50") {
                $html .= "selected";
            } else {
                $html .= "";
            }
            $html .= '>' . $time . '</option>';
            // $html .= '<option  '.($key == "23:50") ? "selected" : "".' value="'.$key.'">'.$time.'</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<span class="btn btn-default" onclick="$(\'#' . $type . '_' . $number . ' \').remove();">X</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<script type="text/javascript">';
        // $html .= '$("#'.$type.'_'.$number.' .selectday").chosen({width: "100%"});';
        $html .= '$(".selectday").select2();';
        $html .= '</script>';

        return response()->json(['html' => $html,]);
    }
}
