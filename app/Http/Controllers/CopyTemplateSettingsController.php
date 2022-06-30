<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class CopyTemplateSettingsController extends Controller
{
    public function copytemplatesettings(Request $request)
    {
    //     $current_store_id = currentStoreId();
    //     $store_id = $request->store_id;




    //     // General Settings

    //     $general_settings = 'general_settings';
    //     $copy_from_general_id = Settings::where('store_id', $store_id)->where('key', $general_settings)->first();
    //     $general_from_value = isset($copy_from_general_id) ? $copy_from_general_id : '';
    //     $general_from = isset($general_from_value['value']) ? $general_from_value['value'] : '';

    //     if (!empty($general_from) || $general_from != '') {
    //         $copy_to_general_id = Settings::where('store_id', $current_store_id)->where('key', $general_settings)->first();
    //         $general_to_value = isset($copy_to_general_id->setting_id) ? $copy_to_general_id->setting_id : '';

    //         if (!empty($general_to_value) || $general_to_value != '') {
    //             $copy_to_general_id->value = $general_from;
    //             $copy_to_general_id->update();
    //         } else {
    //             $general_setting_new = new Settings;
    //             $general_setting_new->group = 'template';
    //             $general_setting_new->store_id = $current_store_id;
    //             $general_setting_new->key = 'general_settings';
    //             $general_setting_new->value = $general_from;
    //             $general_setting_new->serialized = 1;
    //             $general_setting_new->save();
    //         }
    //     }

    //     // END General Settings


    //     // HEADER SETTINGS

    //     $copy_from_header_id = Settings::where('store_id', $store_id)->where('key', 'header_id')->first();
    //     $copy_from_header_value = isset($copy_from_header_id->value) ? $copy_from_header_id->value : '';
    //     $copy_from_header = Settings::where('store_id', $store_id)->where('header_id', $copy_from_header_value)->where('key', 'header_settings')->first();
    //     $copy_from_header_layout_unserialize= unserialize(isset($copy_from_header->value) ? $copy_from_header->value : '');

    //     if(!empty($copy_from_header) || $copy_from_header != '' ){

    //         $copy_to_header_id = Settings::where('store_id', $current_store_id)->where('key', 'header_id')->first();
    //         $copy_to_header_value = isset($copy_to_header_id->value) ? $copy_to_header_id->value : '';
    //         $copy_to_header = Settings::where('store_id', $current_store_id)->where('header_id', $copy_to_header_value)->where('key', 'header_settings')->first();
    //         $copy_to_header_setting_id = isset($copy_to_header->setting_id) ? $copy_to_header->setting_id : '';

    //         if (!empty($copy_to_header_setting_id) || $copy_to_header_setting_id != '') {

    //             $header_to_unserialize = unserialize(isset($copy_to_header->value) ? $copy_to_header->value : '');
    //             $open_banner = isset($header_to_unserialize['menu_topbar_open_banner']) ? $header_to_unserialize['menu_topbar_open_banner'] : '';

    //             $close_banner = isset($header_to_unserialize['menu_topbar_close_banner']) ? $header_to_unserialize['menu_topbar_close_banner'] : '';


    //             if (!empty($open_banner)  || $open_banner != '') {
    //                 if (file_exists($open_banner)) {
    //                     unlink($open_banner);
    //                 }
    //             }

    //             if (!empty($close_banner)  || $close_banner != '') {
    //                 if (file_exists($close_banner)) {
    //                     unlink($close_banner);
    //                 }
    //             }

    //             // // $copy_to_slider_value = Settings::find($copy_to_header_setting_id);
    //             // $copy_to_slider_id->value = $copy_from_slider_value;
    //             // $copy_to_slider_id->update();

    //             $update_serial_header_setting = serialize($copy_from_header_layout_unserialize);
    //             $header_setting_update = Settings::find($copy_to_header_setting_id);
    //             $header_setting_update->value = $update_serial_header_setting;
    //             $header_setting_update->update();
    //         } else {
    //             $serial_header_setting = serialize($copy_from_header_layout_unserialize);
    //             $header_setting_new = new Settings;
    //             $header_setting_new->group = 'template';
    //             $header_setting_new->store_id = $current_store_id;
    //             $header_setting_new->header_id = $copy_from_header_layout_unserialize['header_layout_id'];
    //             $header_setting_new->key = 'header_settings';
    //             $header_setting_new->value = $serial_header_setting;
    //             $header_setting_new->serialized = 1;
    //             $header_setting_new->save();
    //         }
    //     }


    //     // END HEADER SETTINGS


    //     // HTML BOX

    //     $copy_from_about_id = Settings::where('store_id', $store_id)->where('key', 'about_id')->first();
    //     $copy_from_about_value = isset($copy_from_about_id->value) ? $copy_from_about_id->value : '';
    //     $copy_from_about = Settings::where('store_id', $store_id)->where('about_id', $copy_from_about_value)->where('key', 'about_settings')->first();
    //     $copy_from_about_layout_unserialize= unserialize(isset($copy_from_about->value) ? $copy_from_about->value : '');


    //     if(!empty($copy_from_about) || $copy_from_about != '' ){

    //         $copy_to_about_id = Settings::where('store_id', $current_store_id)->where('key', 'about_id')->first();
    //         $copy_to_about_value = isset($copy_to_about_id->value) ? $copy_to_about_id->value : '';
    //         $copy_to_about = Settings::where('store_id', $current_store_id)->where('about_id', $copy_to_about_value)->where('key', 'about_settings')->first();
    //         $copy_to_about_setting_id = isset($copy_to_about->setting_id) ? $copy_to_about->setting_id : '';

    //         if (!empty($copy_to_about_setting_id) || $copy_to_about_setting_id != '') {

    //             // // $copy_to_slider_value = Settings::find($copy_to_about_setting_id);
    //             // $copy_to_slider_id->value = $copy_from_slider_value;
    //             // $copy_to_slider_id->update();

    //             $update_serial_about_setting = serialize($copy_from_about_layout_unserialize);
    //             $about_setting_update = Settings::find($copy_to_about_setting_id);
    //             $about_setting_update->value = $update_serial_about_setting;
    //             $about_setting_update->update();
    //         } else {
    //             $serial_about_setting = serialize($copy_from_about_layout_unserialize);
    //             $about_setting_new = new Settings;
    //             $about_setting_new->group = 'template';
    //             $about_setting_new->store_id = $current_store_id;
    //             $about_setting_new->about_id = $copy_from_about_layout_unserialize['about_layout_id'];
    //             $about_setting_new->key = 'about_settings';
    //             $about_setting_new->value = $serial_about_setting;
    //             $about_setting_new->serialized = 1;
    //             $about_setting_new->save();
    //         }
    //     }

    //     // END HTML BOX

    //     // Slider Settings

    //     $copy_from_slider_id = Settings::where('store_id', $store_id)->where('key', 'slider_id')->first();
    //     $copy_from_slider_value = isset($copy_from_slider_id->value) ? $copy_from_slider_id->value : '';
    //     $copy_from_slider = Settings::where('store_id', $store_id)->where('slider_id', $copy_from_slider_value)->where('key', 'slider_settings')->first();
    //     $copy_from_slider_layout_unserialize= unserialize(isset($copy_from_slider->value) ? $copy_from_slider->value : '');



    //     if (!empty($copy_from_slider) || $copy_from_slider != '') {
    //         $copy_to_slider_id = Settings::where('store_id', $current_store_id)->where('key', 'slider_id')->first();
    //         $copy_to_slider_value = isset($copy_to_slider_id->value) ? $copy_to_slider_id->value : '';
    //         $copy_to_slider = Settings::where('store_id', $current_store_id)->where('slider_id', $copy_to_slider_value)->where('key', 'slider_settings')->first();
    //         $copy_to_slider_setting_id = isset($copy_to_slider->setting_id) ? $copy_to_slider->setting_id : '';

    //         if (!empty($copy_to_slider_setting_id) || $copy_to_slider_setting_id != '') {

    //             // // $copy_to_slider_value = Settings::find($copy_to_slider_setting_id);
    //             // $copy_to_slider_id->value = $copy_from_slider_value;
    //             // $copy_to_slider_id->update();

    //             $update_serial_slider_setting = serialize($copy_from_slider_layout_unserialize);
    //             $header_setting_update = Settings::find($copy_to_slider_setting_id);
    //             $header_setting_update->value = $update_serial_slider_setting;
    //             $header_setting_update->update();
    //         } else {
    //             $serial_slider_setting = serialize($copy_from_slider_layout_unserialize);
    //             $slider_setting_new = new Settings;
    //             $slider_setting_new->group = 'template';
    //             $slider_setting_new->store_id = $current_store_id;
    //             $slider_setting_new->slider_id = $copy_from_slider_layout_unserialize['slider_layout_id'];
    //             $slider_setting_new->key = 'slider_settings';
    //             $slider_setting_new->value = $serial_slider_setting;
    //             $slider_setting_new->serialized = 1;
    //             $slider_setting_new->save();
    //         }
    //     }

    //     // End Slider Settings


    }
}
