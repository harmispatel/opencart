<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use App\Models\Settings;
use App\Models\Themes;
use Illuminate\Http\Request;

class LayoutController extends Controller
{

    public function templatesettings()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Current Store Theme ID
        $current_store_theme = themeActive();

        // Get All Themes
        $themes = Themes::get();


        $key = ([
            'polianna_navbar_background',
            'polianna_navbar_link',
            'polianna_main_logo',
            'polianna_main_logo_width',
            'polianna_main_logo_height',

            'polianna_slider_permission',
            'polianna_slider_1',
            'polianna_slider_2',
            'polianna_slider_3',
            'polianna_slider_1_title',
            'polianna_slider_2_title',
            'polianna_slider_3_title',

            'polianna_online_order_permission',

        ]);

        $template_settings = [];

        foreach($key as $row)
        {
            $query = Settings::select('value')->where('store_id',$current_store_id)->where('theme_id',$current_store_theme)->where('key',$row)->first();
            $template_settings[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settinglayouts.template_settings',compact(['themes','template_settings']));
    }


    function updateTemplateSetting(Request $request)
    {

        // Current Store ID
        $current_store_id = currentStoreId();

        // Current Store Theme ID
        $current_store_theme = themeActive();


        // NAVBAR
        $data['polianna_navbar_background'] = isset($request->polianna_navbar_background) ? $request->polianna_navbar_background : '';
        $data['polianna_navbar_link'] = isset($request->polianna_navbar_link) ? $request->polianna_navbar_link : '';
        $data['polianna_main_logo_width'] = isset($request->polianna_main_logo_width) ? $request->polianna_main_logo_width : '';
        $data['polianna_main_logo_height'] = isset($request->polianna_main_logo_height) ? $request->polianna_main_logo_height : '';
        if($request->hasFile('polianna_main_logo'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('theme_id',$current_store_theme)->where('key','polianna_main_logo')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_main_logo = time().'.'.$request->file('polianna_main_logo')->getClientOriginalName();
            $request->file('polianna_main_logo')->move(public_path('frontend/navbar'),$polianna_main_logo);
            $data['polianna_main_logo'] = 'public/frontend/navbar/'.$polianna_main_logo;
        }
        // END NAVBAR


        // SLIDERS
        $data['polianna_slider_permission'] = isset($request->polianna_slider_permission) ? $request->polianna_slider_permission : '';
        $data['polianna_slider_1_title'] = isset($request->polianna_slider_1_title) ? $request->polianna_slider_1_title : '';
        $data['polianna_slider_2_title'] = isset($request->polianna_slider_2_title) ? $request->polianna_slider_2_title : '';
        $data['polianna_slider_3_title'] = isset($request->polianna_slider_3_title) ? $request->polianna_slider_3_title : '';
        if($request->hasFile('polianna_slider_1'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('theme_id',$current_store_theme)->where('key','polianna_slider_1')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_slider_1 = time().'.'.$request->file('polianna_slider_1')->getClientOriginalName();
            $request->file('polianna_slider_1')->move(public_path('frontend/sliders'),$polianna_slider_1);
            $data['polianna_slider_1'] = 'public/frontend/sliders/'.$polianna_slider_1;
        }

        if($request->hasFile('polianna_slider_2'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('theme_id',$current_store_theme)->where('key','polianna_slider_2')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_slider_2 = time().'.'.$request->file('polianna_slider_2')->getClientOriginalName();
            $request->file('polianna_slider_2')->move(public_path('frontend/sliders'),$polianna_slider_2);
            $data['polianna_slider_2'] = 'public/frontend/sliders/'.$polianna_slider_2;
        }

        if($request->hasFile('polianna_slider_3'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('theme_id',$current_store_theme)->where('key','polianna_slider_3')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_slider_3 = time().'.'.$request->file('polianna_slider_3')->getClientOriginalName();
            $request->file('polianna_slider_3')->move(public_path('frontend/sliders'),$polianna_slider_3);
            $data['polianna_slider_3'] = 'public/frontend/sliders/'.$polianna_slider_3;
        }
        // END SLIDERS


        // PERMISSION
        $data['polianna_online_order_permission'] = isset($request->polianna_online_order_permission) ? $request->polianna_online_order_permission : '';
        // END PERMISSION


        foreach($data as $key => $new)
        {
            $query = Settings::where('store_id', $current_store_id)->where('theme_id',$current_store_theme)->where('key', $key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '')
            {
                $template_update = Settings::find($setting_id);
                $template_update->value = $new;
                $template_update->update();
            }
            else
            {
                $new_template = new Settings();
                $new_template->store_id = $current_store_id;
                $new_template->theme_id = $current_store_theme;
                $new_template->group = 'polianna';
                $new_template->key = $key;
                $new_template->value = $new;
                $new_template->serialized = 0;
                $new_template->save();
            }
        }

        return redirect()->route('templatesettings')->with('success', 'Settings Updated..');

    }

    public function activetheme($id)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $theme_id = $id;
        $key = 'theme_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_theme = Settings::find($setting_id);
            $active_theme->value = $theme_id;
            $active_theme->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $theme_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return redirect()->route('templatesettings');

    }

    public function slidersettings()
    {
        return view('admin.settinglayouts.slider_settings');
    }

    public function bannerandblocks()
    {
        return view('admin.settinglayouts.banner_and_blocks');
    }


}
