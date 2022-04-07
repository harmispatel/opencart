<?php

namespace App\Http\Controllers;

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
}
