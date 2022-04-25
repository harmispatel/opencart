<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\DeliverySettings;
use App\Models\Language;
use App\Models\Postcodes;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Store;
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

    public function openclosetime(Request $request)
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
        $times = $this->times = $timearray;

        //
        $current_store_id = currentStoreId();
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

        foreach($key as $row)
        {
            $query = Settings::select('value')->where('store_id',$current_store_id)->where('key',$row)->first();

            $open_close[$row] = isset($query->value) ? $query->value : '';
        }

        $closedate = unserialize($open_close['closing_dates']);
        $delivery = unserialize($open_close['delivery']);
        $collection = unserialize($open_close['collection']);
        $timesetting = $open_close;
        $bussines = unserialize($open_close['bussines']);
        $days = $this->days;

        return view('admin.settings.open_close_time_settings', compact(['days','timesetting','times','bussines','closedate','delivery','collection']) );
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

        // Update in Store
        $store = Store::find($current_store_id);
        $store->name = $data['config_name'];
        $store->url =  $data['config_url'];
        $store->ssl =  $data['config_ssl'];
        $store->update();

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

    public function deliverycollectionsetting()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $data['enable_delivery'] = Settings::select('value')->where('store_id',$current_store_id)->where('key','enable_delivery')->first();

        $data['delivery_option'] = Settings::select('value')->where('store_id',$current_store_id)->where('key','delivery_option')->first();

        $data['is_distance_option'] = Settings::select('value')->where('store_id',$current_store_id)->where('key','is_distance_option')->first();

        $data['road_mileage_percentage'] = Settings::select('value')->where('store_id',$current_store_id)->where('key','road_mileage_percentage')->first();

        $data['google_distance_api_key'] = Settings::select('value')->where('store_id',$current_store_id)->where('key','google_distance_api_key')->first();

        $data['deliverysettings'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store',$current_store_id)->where('delivery_type','post_codes')->get();

        $data['deliverydistance'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store',$current_store_id)->where('delivery_type','distance')->get();

        $data['deliveryareas'] = DeliverySettings::with(['hasManyDeliveryFeeds'])->where('id_store',$current_store_id)->where('delivery_type','area')->get();

        return view('admin.settings.delivery_collection_setting',$data);
    }


    public function calculateDistance(Request $request)
    {
        $current_store_id = currentStoreId();
        $keyword = $request->distance_postcode;
        $data = [];

        if(!empty($keyword) || $keyword != '')
        {
            $keyword = str_replace(' ', '', $keyword);
            $keyword = substr_replace($keyword, ' ' . substr($keyword, -3), -3);
			$keyword = strtoupper($keyword);

            $postcode_setting = Settings::where('group','config')->where('store_id',$current_store_id)->where('key','map_post_code')->first();
            $admin_postcode = isset($postcode_setting->value) ? $postcode_setting->value : '';

            $milage_setting = Settings::where('group','deliverysetting')->where('store_id',$current_store_id)->where('key','road_mileage_percentage')->first();
            $mileage_percentage = isset($milage_setting->value) ? $milage_setting->value : '';

            $distance_setting = Settings::where('group','deliverysetting')->where('store_id',$current_store_id)->where('key','is_distance_option')->first();
            $is_distance_option = isset($distance_setting->value) ? $distance_setting->value : '';

            $res = Postcodes::where('Postcode',$keyword)->first();

            if(isset($res))
            {
                $res2 = Postcodes::where('Postcode',$admin_postcode)->first();
                $destinationLat = $res->Latitude;
				$destinationLon = $res->Longitude;
				$originLat      = $res2->Latitude;
				$originLong     = $res2->Longitude;

                if($is_distance_option == 2)
                {
                    $distance_key =  Settings::where('group','deliverysetting')->where('store_id',$current_store_id)->where('key','google_distance_api_key')->first();
                    $google_distance_api_key = isset($distance_key->value) ? $distance_key->value : '';

                    if(isset($google_distance_api_key) && !empty($google_distance_api_key))
                    {
						$result = calculationDistanceMatrix($originLat, $originLong, $destinationLat, $destinationLon,$google_distance_api_key);

						if($result['status'] == 'OK')
                        {
							$result = $result['rows']['0']['elements']['0'];
							$distanceNew = str_replace(',','.',$result['distance']['text']);
							$json['success'] = number_format((float)$distanceNew,2,'.',',').' Miles';
						}
						else
                        {
							$json['error'] = $result['error_message'];
						}
					}
					else
                    {
						$json['error'] = 'Invalid google distance api key.';
					}
				}
                else
                {
                    if(!empty($mileage_percentage) || $mileage_percentage != '')
                    {
                        $distance 		= distance($originLat, $originLong, $destinationLat, $destinationLon, "M");
                        $distanceNew 	= ($distance + ($mileage_percentage / 100) * $distance);
                        $json['success'] = number_format((float)$distanceNew,2,'.',',').' Miles';
                    }
                    else
                    {
                        $json['error'] = 'Please Enter Mileage Percentage.';
                    }
				}

            }
            else
            {
                $json['error'] = 'Sorry! The postcode you entered doesn\'t exist. Please try another.';
            }

        }
        else
        {
            $json['error'] = 'Please enter postcode';
        }

        return response()->json([
            'json' => $json,
        ]);

    }


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

    public function deleteGroup(Request $request)
    {
        $delivery_setting_id = $request->id_delivery_settings;

        DeliverySettings::where('id_delivery_settings',$delivery_setting_id)->delete();

        return response()->json([
            'success' => 1,
        ]);

    }


    public function manageDeliveryCollection(Request $request)
    {
        echo '<pre>';
        print_r($request->all());
        exit();
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
            else
            {
                $social_add = new Settings;
                $social_add->store_id = $current_store_id;
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
        $current_store_id = currentStoreId();

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

        foreach($data as $key => $new)
        {
            $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';

            if (!empty($setting_id) || $setting_id != '')
            {
                $timesetting = Settings::find($setting_id);
                $timesetting->value = $new;
                $timesetting->update();
            }
            else
            {
                $timesetting = new Settings();
                $timesetting->store_id = $current_store_id;
                $timesetting->group = 'timesetting';
                $timesetting->key = $key;
                $timesetting->value = $new;
                $timesetting->serialized = 1;
                $timesetting->save();
            }
        }
        return redirect()->route('openclosetime')->with('success', 'Open/Close time Updated..');
    }

    public function daytime(Request $request)
    {
        $number = $request->number;
        $type = $request->type;

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
        $html .= '<div class="col-sm-12" id="'.$type.'_'.$number.'">';
        $html .= '<div class="d-flex justify-content-between">';
            $html .= '<div class="form-group col-sm-6">';
            $html .= '<select class="selectday form-control" name="'.$type.'[day]['.$number.'][]" class="form-control" multiple="multiple">';
            foreach($days as $key => $day)
            {
                $html .= '<option value="'.$key.'">'.$day.'</option>';
            }
            $html .= '</select>';
            $html .= '</div>';
            $html .= '<div class="d-flex">';
            $html .= '<div class="form-group">';
            $html .= '<select class="selectday form-control" name="'.$type.'[from]['.$number.']" class="form-control" style="width: 100% !importent;">';
            foreach($times1 as $key => $time)
            {
                // $html .= '<option '.($key == "0:00") ? "selected" : "".' value="'.$key.'">'.$time.'</option>';
                $html .= '<option >'.$time.'</option>';
            }
            $html .= '</select>';
            $html .= '</div>';
            $html .= '<div class="form-group px-3">';
            $html .= '<select class="selectday form-control" name="'.$type.'[to]['.$number .']" class="form-control" style="width: 100% !importent;">';
            foreach($times1 as $key => $time)
            {
                $html .= '<option ';
                if ($key == "23:50") {
                    $html .= "selected";
                }
                else{
                    $html .= "";
                }
                $html .= '>'.$time.'</option>';
                // $html .= '<option  '.($key == "23:50") ? "selected" : "".' value="'.$key.'">'.$time.'</option>';
            }
            $html .= '</select>';
            $html .= '</div>';
            $html .= '<div class="form-group">';
            $html .= '<span class="btn btn-default" onclick="$(\'#'.$type.'_'.$number.' \').remove();">X</span>';
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
