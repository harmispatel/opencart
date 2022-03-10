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
}
