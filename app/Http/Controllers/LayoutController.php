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

        // Get All Themes
        $themes = Themes::get();


        $key = ([
            'polianna_topbackgr_color',
            'polianna_bannerbackgr_color',
            'polianna_line_color',

            'polianna_custom_pattern',
            'main_bg_status',
            'polianna_backgr_repeat',
            'main_bg_mobile_status',
            'main_bg_tablet_status',
            'ybc_bgmain_positions_x',
            'ybc_bgmain_positions_y',

        ]);

        $template_settings = [];

        foreach($key as $row)
        {
            $query = Settings::select('value')->where('store_id',$current_store_id)->where('key',$row)->first();
            $template_settings[$row] = isset($query->value) ? $query->value : '';
        }

        return view('admin.settinglayouts.template_settings',compact(['themes','template_settings']));
    }


    function updateTemplateSetting(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $data['polianna_topbackgr_color'] = isset($request->polianna_topbackgr_color) ? $request->polianna_topbackgr_color : '';
        $data['polianna_bannerbackgr_color'] = isset($request->polianna_bannerbackgr_color) ? $request->polianna_bannerbackgr_color : '';
        $data['polianna_line_color'] = isset($request->polianna_line_color) ? $request->polianna_line_color : '';


        if($request->hasFile('polianna_custom_pattern'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','polianna_custom_pattern')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_custom_pattern = time().'.'.$request->file('polianna_custom_pattern')->getClientOriginalExtension();
            $request->file('polianna_custom_pattern')->move(public_path('frontend/patterns'),$polianna_custom_pattern);
            $data['polianna_custom_pattern'] = 'public/frontend/patterns/'.$polianna_custom_pattern;
        }

        $data['main_bg_status'] = isset($request->main_bg_status) ? $request->main_bg_status : '';
        $data['polianna_backgr_repeat'] = isset($request->polianna_backgr_repeat) ? $request->polianna_backgr_repeat : '';
        $data['main_bg_mobile_status'] = isset($request->main_bg_mobile_status) ? $request->main_bg_mobile_status : '';
        $data['main_bg_tablet_status'] = isset($request->main_bg_tablet_status) ? $request->main_bg_tablet_status : '';
        $data['ybc_bgmain_positions_x'] = isset($request->ybc_bgmain_positions_x) ? $request->ybc_bgmain_positions_x : '';
        $data['ybc_bgmain_positions_y'] = isset($request->ybc_bgmain_positions_y) ? $request->ybc_bgmain_positions_y : '';


        if($request->hasFile('polianna_bg_footer'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','polianna_bg_footer')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_bg_footer = time().'.'.$request->file('polianna_bg_footer')->getClientOriginalExtension();
            $request->file('polianna_bg_footer')->move(public_path('frontend/patterns'),$polianna_bg_footer);
            $data['polianna_bg_footer'] = 'public/frontend/patterns/'.$polianna_bg_footer;
        }

        $data['main_bg_status'] = isset($request->main_bg_status) ? $request->main_bg_status : '';


        foreach($data as $key => $new)
        {
            $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if (!empty($setting_id) || $setting_id != '')
            {
                $template_update = Settings::find($setting_id);
                $template_update->value = $new;
                $template_update->update();
            }
            else
            {
                $map_add = new Settings();
                $map_add->store_id = $current_store_id;
                $map_add->group = 'polianna';
                $map_add->key = $key;
                $map_add->value = $new;
                $map_add->serialized = 0;
                $map_add->save();
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
