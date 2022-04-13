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

            'polianna_bg_footer',
            'footer_bg_status',
            'footer_bg_repeat',
            'footer_bg_mobile_status',
            'footer_bg_tablet_status',
            'ybc_bgfooter_positions_x',
            'ybc_bgfooter_positions_y',

            'ybc_module_bg',
            'ybc_module_bg_status',
            'ybc_module_bg_repeat',
            'ybc_module_bg_mobile_status',
            'ybc_module_bg_tablet_status',

            'polianna_top_main_bg',
            'top_main_bg_status',
            'top_main_bg_repeat',
            'top_main_bg_mobile_status',
            'top_main_bg_tablet_status',
            'ybc_bg_top_main_positions_x',
            'ybc_bg_top_main_positions_y',
            'polianna_backgr_color',

            'polianna_blog_enable',
            'polianna_custom_icon1',
            'banner_open_img',
            'banner_close_img',
            'polianna_img1_menu',
            'ybc_baner_bg_repeat',
            'ybc_baner_bg_mobile_status',
            'ybc_baner_bg_tablet_status',

            'logo_tablet_enable',
            'bg_banner',
            'bg_banner_tranparent',
            'polianna_custom_topinfo1',
            'ybc_wide_banner_fullwidth',
            'ybc_banner_box_shadow',
            'ybc_banner_positions_x',
            'ybc_banner_positions_y',

            'polianna_widthmenu',
            'polianna_bar_color',
            'polianna_line1_color',
            'polianna_hover_color',
            'polianna_subbar_color',
            'polianna_toplinksize',
            'polianna_wide_menu_font_color1',
            'polianna_hover2_color',
            'polianna_menulink2_color',
            'polianna_fonlink2_color',
            'polianna_toplinksize2',
            'polianna_categorysize',

            'main_content_fullwidth',
            'polianna_contentwidth',
            'polianna_contentimage_pattern',
            'polianna_img1_main_content',
            'polianna_contentbackgr_repeat',
            'ybc_main_content_bg_mobile_status',
            'ybc_main_content_bg_tablet_status',
            'polianna_shadowcontent',
            'polianna_contentbackgr_color',
            'polianna_contentbackgr_transparent',

            'footer_background_image',
            'footer_bg_enable',
            'footer_background_repeat',
            'footer_bg_mobile_status2',
            'footer_bg_tablet_status2',

            'polianna_button_color',
            'polianna_buttonhov_color',
            'ybc_mousehover_color',
            'ybc_click_color',
            'ybc_error_color',
            'ybc_general_color',
            'ybc_active_color',
            'ybc_unactive_color',
            'polianna_categ_color',
            'polianna_hovercateg_color',
            'polianna_titleitem_color',
            'polianna_allprice_color',
            'polianna_oprice_color',

            'polianna_custom_submenu_1',
            'polianna_footertitle_color',
            'polianna_footer_color',
            'polianna_footerhover_color',
            'polianna_custom_submenu_2',
            'polianna_footerfon_color',
            'polianna_footertext_color',
            'polianna_footertext_hover_color',

            'polianna_title_font',
            'polianna_body_font',
            'polianna_bodysize',
            'ybc_polianna_title_h1',
            'polianna_title_h2',
            'polianna_title_h3',
            'polianna_title_h4',
            'polianna_title_box',
            'polianna_title_column',
            'polianna_title_product',
            'polianna_pricesize',

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

            $polianna_custom_pattern = time().'.'.$request->file('polianna_custom_pattern')->getClientOriginalName();
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

            $polianna_bg_footer = time().'.'.$request->file('polianna_bg_footer')->getClientOriginalName();
            $request->file('polianna_bg_footer')->move(public_path('frontend/patterns'),$polianna_bg_footer);
            $data['polianna_bg_footer'] = 'public/frontend/patterns/'.$polianna_bg_footer;
        }

        $data['footer_bg_status'] = isset($request->footer_bg_status) ? $request->footer_bg_status : '';
        $data['footer_bg_repeat'] = isset($request->footer_bg_repeat) ? $request->footer_bg_repeat : '';
        $data['footer_bg_mobile_status'] = isset($request->footer_bg_mobile_status) ? $request->footer_bg_mobile_status : '';
        $data['footer_bg_tablet_status'] = isset($request->footer_bg_tablet_status) ? $request->footer_bg_tablet_status : '';
        $data['ybc_bgfooter_positions_x'] = isset($request->ybc_bgfooter_positions_x) ? $request->ybc_bgfooter_positions_x : '';
        $data['ybc_bgfooter_positions_y'] = isset($request->ybc_bgfooter_positions_y) ? $request->ybc_bgfooter_positions_y : '';


        if($request->hasFile('ybc_module_bg'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','ybc_module_bg')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $ybc_module_bg = time().'.'.$request->file('ybc_module_bg')->getClientOriginalName();
            $request->file('ybc_module_bg')->move(public_path('frontend/patterns'),$ybc_module_bg);
            $data['ybc_module_bg'] = 'public/frontend/patterns/'.$ybc_module_bg;
        }

        $data['ybc_module_bg_status'] = isset($request->ybc_module_bg_status) ? $request->ybc_module_bg_status : '';
        $data['ybc_module_bg_repeat'] = isset($request->ybc_module_bg_repeat) ? $request->ybc_module_bg_repeat : '';
        $data['ybc_module_bg_mobile_status'] = isset($request->ybc_module_bg_mobile_status) ? $request->ybc_module_bg_mobile_status : '';
        $data['ybc_module_bg_tablet_status'] = isset($request->ybc_module_bg_tablet_status) ? $request->ybc_module_bg_tablet_status : '';


        if($request->hasFile('polianna_top_main_bg'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','polianna_top_main_bg')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_top_main_bg = time().'.'.$request->file('polianna_top_main_bg')->getClientOriginalName();
            $request->file('polianna_top_main_bg')->move(public_path('frontend/patterns'),$polianna_top_main_bg);
            $data['polianna_top_main_bg'] = 'public/frontend/patterns/'.$polianna_top_main_bg;
        }

        $data['top_main_bg_status'] = isset($request->top_main_bg_status) ? $request->top_main_bg_status : '';
        $data['top_main_bg_repeat'] = isset($request->top_main_bg_repeat) ? $request->top_main_bg_repeat : '';
        $data['top_main_bg_mobile_status'] = isset($request->top_main_bg_mobile_status) ? $request->top_main_bg_mobile_status : '';
        $data['top_main_bg_tablet_status'] = isset($request->top_main_bg_tablet_status) ? $request->top_main_bg_tablet_status : '';
        $data['ybc_bg_top_main_positions_x'] = isset($request->ybc_bg_top_main_positions_x) ? $request->ybc_bg_top_main_positions_x : '';
        $data['ybc_bg_top_main_positions_y'] = isset($request->ybc_bg_top_main_positions_y) ? $request->ybc_bg_top_main_positions_y : '';
        $data['polianna_backgr_color'] = isset($request->polianna_backgr_color) ? $request->polianna_backgr_color : '';


        $data['polianna_blog_enable'] = isset($request->polianna_blog_enable) ? $request->polianna_blog_enable : '';

        if($request->hasFile('polianna_custom_icon1'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','polianna_custom_icon1')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_custom_icon1 = time().'.'.$request->file('polianna_custom_icon1')->getClientOriginalName();
            $request->file('polianna_custom_icon1')->move(public_path('frontend/banners'),$polianna_custom_icon1);
            $data['polianna_custom_icon1'] = 'public/frontend/banners/'.$polianna_custom_icon1;
        }

        if($request->hasFile('banner_open_img'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','banner_open_img')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $banner_open_img = time().'.'.$request->file('banner_open_img')->getClientOriginalName();
            $request->file('banner_open_img')->move(public_path('frontend/banners'),$banner_open_img);
            $data['banner_open_img'] = 'public/frontend/banners/'.$banner_open_img;
        }

        if($request->hasFile('banner_close_img'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','banner_close_img')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $banner_close_img = time().'.'.$request->file('banner_close_img')->getClientOriginalName();
            $request->file('banner_close_img')->move(public_path('frontend/banners'),$banner_close_img);
            $data['banner_close_img'] = 'public/frontend/banners/'.$banner_close_img;
        }

        $data['polianna_img1_menu'] = isset($request->polianna_img1_menu) ? $request->polianna_img1_menu : '';
        $data['ybc_baner_bg_repeat'] = isset($request->ybc_baner_bg_repeat) ? $request->ybc_baner_bg_repeat : '';
        $data['ybc_baner_bg_mobile_status'] = isset($request->ybc_baner_bg_mobile_status) ? $request->ybc_baner_bg_mobile_status : '';
        $data['ybc_baner_bg_tablet_status'] = isset($request->ybc_baner_bg_tablet_status) ? $request->ybc_baner_bg_tablet_status : '';


        $data['logo_tablet_enable'] = isset($request->logo_tablet_enable) ? $request->logo_tablet_enable : '';
        $data['bg_banner'] = isset($request->bg_banner) ? $request->bg_banner : '';
        $data['bg_banner_tranparent'] = isset($request->bg_banner_tranparent) ? $request->bg_banner_tranparent : '';
        $data['polianna_custom_topinfo1'] = isset($request->polianna_custom_topinfo1) ? $request->polianna_custom_topinfo1 : '';
        $data['ybc_wide_banner_fullwidth'] = isset($request->ybc_wide_banner_fullwidth) ? $request->ybc_wide_banner_fullwidth : '';
        $data['ybc_banner_box_shadow'] = isset($request->ybc_banner_box_shadow) ? $request->ybc_banner_box_shadow : '';
        $data['ybc_banner_positions_x'] = isset($request->ybc_banner_positions_x) ? $request->ybc_banner_positions_x : '';
        $data['ybc_banner_positions_y'] = isset($request->ybc_banner_positions_y) ? $request->ybc_banner_positions_y : '';


        $data['polianna_widthmenu'] = isset($request->polianna_widthmenu) ? $request->polianna_widthmenu : '';
        $data['polianna_bar_color'] = isset($request->polianna_bar_color) ? $request->polianna_bar_color : '';
        $data['polianna_line1_color'] = isset($request->polianna_line1_color) ? $request->polianna_line1_color : '';
        $data['polianna_hover_color'] = isset($request->polianna_hover_color) ? $request->polianna_hover_color : '';
        $data['polianna_subbar_color'] = isset($request->polianna_subbar_color) ? $request->polianna_subbar_color : '';
        $data['polianna_toplinksize'] = isset($request->polianna_toplinksize) ? $request->polianna_toplinksize : '';
        $data['polianna_wide_menu_font_color1'] = isset($request->polianna_wide_menu_font_color1) ? $request->polianna_wide_menu_font_color1 : '';
        $data['polianna_hover2_color'] = isset($request->polianna_hover2_color) ? $request->polianna_hover2_color : '';
        $data['polianna_menulink2_color'] = isset($request->polianna_menulink2_color) ? $request->polianna_menulink2_color : '';
        $data['polianna_fonlink2_color'] = isset($request->polianna_fonlink2_color) ? $request->polianna_fonlink2_color : '';
        $data['polianna_toplinksize2'] = isset($request->polianna_toplinksize2) ? $request->polianna_toplinksize2 : '';
        $data['polianna_categorysize'] = isset($request->polianna_categorysize) ? $request->polianna_categorysize : '';


        $data['main_content_fullwidth'] = isset($request->main_content_fullwidth) ? $request->main_content_fullwidth : '';
        $data['polianna_contentwidth'] = isset($request->polianna_contentwidth) ? $request->polianna_contentwidth : '';

        if($request->hasFile('polianna_contentimage_pattern'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','polianna_contentimage_pattern')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $polianna_contentimage_pattern = time().'.'.$request->file('polianna_contentimage_pattern')->getClientOriginalName();
            $request->file('polianna_contentimage_pattern')->move(public_path('frontend/backgrounds'),$polianna_contentimage_pattern);
            $data['polianna_contentimage_pattern'] = 'public/frontend/backgrounds/'.$polianna_contentimage_pattern;
        }

        $data['polianna_img1_main_content'] = isset($request->polianna_img1_main_content) ? $request->polianna_img1_main_content : '';
        $data['polianna_contentbackgr_repeat'] = isset($request->polianna_contentbackgr_repeat) ? $request->polianna_contentbackgr_repeat : '';
        $data['ybc_main_content_bg_mobile_status'] = isset($request->ybc_main_content_bg_mobile_status) ? $request->ybc_main_content_bg_mobile_status : '';
        $data['ybc_main_content_bg_tablet_status'] = isset($request->ybc_main_content_bg_tablet_status) ? $request->ybc_main_content_bg_tablet_status : '';
        $data['polianna_shadowcontent'] = isset($request->polianna_shadowcontent) ? $request->polianna_shadowcontent : '';
        $data['polianna_contentbackgr_color'] = isset($request->polianna_contentbackgr_color) ? $request->polianna_contentbackgr_color : '';
        $data['polianna_contentbackgr_transparent'] = isset($request->polianna_contentbackgr_transparent) ? $request->polianna_contentbackgr_transparent : '';


        if($request->hasFile('footer_background_image'))
        {
            $old = Settings::select('value')->where('store_id',$current_store_id)->where('key','footer_background_image')->first();
            $old_name = isset($old->value) ? $old->value : '';

            if(!empty($old_name) || $old_name != '')
            {
                if(file_exists($old_name))
                {
                    unlink($old_name);
                }
            }

            $footer_background_image = time().'.'.$request->file('footer_background_image')->getClientOriginalName();
            $request->file('footer_background_image')->move(public_path('frontend/backgrounds'),$footer_background_image);
            $data['footer_background_image'] = 'public/frontend/backgrounds/'.$footer_background_image;
        }

        $data['footer_bg_enable'] = isset($request->footer_bg_enable) ? $request->footer_bg_enable : '';
        $data['footer_background_repeat'] = isset($request->footer_background_repeat) ? $request->footer_background_repeat : '';
        $data['footer_bg_mobile_status2'] = isset($request->footer_bg_mobile_status2) ? $request->footer_bg_mobile_status2 : '';
        $data['footer_bg_tablet_status2'] = isset($request->footer_bg_tablet_status2) ? $request->footer_bg_tablet_status2 : '';


        $data['polianna_button_color'] = isset($request->polianna_button_color) ? $request->polianna_button_color : '';
        $data['polianna_buttonhov_color'] = isset($request->polianna_buttonhov_color) ? $request->polianna_buttonhov_color : '';
        $data['ybc_mousehover_color'] = isset($request->ybc_mousehover_color) ? $request->ybc_mousehover_color : '';
        $data['ybc_click_color'] = isset($request->ybc_click_color) ? $request->ybc_click_color : '';
        $data['ybc_error_color'] = isset($request->ybc_error_color) ? $request->ybc_error_color : '';
        $data['ybc_general_color'] = isset($request->ybc_general_color) ? $request->ybc_general_color : '';
        $data['ybc_active_color'] = isset($request->ybc_active_color) ? $request->ybc_active_color : '';
        $data['ybc_unactive_color'] = isset($request->ybc_unactive_color) ? $request->ybc_unactive_color : '';
        $data['polianna_categ_color'] = isset($request->polianna_categ_color) ? $request->polianna_categ_color : '';
        $data['polianna_hovercateg_color'] = isset($request->polianna_hovercateg_color) ? $request->polianna_hovercateg_color : '';
        $data['polianna_titleitem_color'] = isset($request->polianna_titleitem_color) ? $request->polianna_titleitem_color : '';
        $data['polianna_allprice_color'] = isset($request->polianna_allprice_color) ? $request->polianna_allprice_color : '';
        $data['polianna_oprice_color'] = isset($request->polianna_oprice_color) ? $request->polianna_oprice_color : '';


        $data['polianna_custom_submenu_1'] = isset($request->polianna_custom_submenu_1) ? $request->polianna_custom_submenu_1 : '';
        $data['polianna_footertitle_color'] = isset($request->polianna_footertitle_color) ? $request->polianna_footertitle_color : '';
        $data['polianna_footer_color'] = isset($request->polianna_footer_color) ? $request->polianna_footer_color : '';
        $data['polianna_footerhover_color'] = isset($request->polianna_footerhover_color) ? $request->polianna_footerhover_color : '';
        $data['polianna_custom_submenu_2'] = isset($request->polianna_custom_submenu_2) ? $request->polianna_custom_submenu_2 : '';
        $data['polianna_footerfon_color'] = isset($request->polianna_footerfon_color) ? $request->polianna_footerfon_color : '';
        $data['polianna_footertext_color'] = isset($request->polianna_footertext_color) ? $request->polianna_footertext_color : '';
        $data['polianna_footertext_hover_color'] = isset($request->polianna_footertext_hover_color) ? $request->polianna_footertext_hover_color : '';


        $data['polianna_title_font'] = isset($request->polianna_title_font) ? $request->polianna_title_font : '';
        $data['polianna_body_font'] = isset($request->polianna_body_font) ? $request->polianna_body_font : '';
        $data['polianna_bodysize'] = isset($request->polianna_bodysize) ? $request->polianna_bodysize : '';
        $data['ybc_polianna_title_h1'] = isset($request->ybc_polianna_title_h1) ? $request->ybc_polianna_title_h1 : '';
        $data['polianna_title_h2'] = isset($request->polianna_title_h2) ? $request->polianna_title_h2 : '';
        $data['polianna_title_h3'] = isset($request->polianna_title_h3) ? $request->polianna_title_h3 : '';
        $data['polianna_title_h4'] = isset($request->polianna_title_h4) ? $request->polianna_title_h4 : '';
        $data['polianna_title_box'] = isset($request->polianna_title_box) ? $request->polianna_title_box : '';
        $data['polianna_title_column'] = isset($request->polianna_title_column) ? $request->polianna_title_column : '';
        $data['polianna_title_product'] = isset($request->polianna_title_product) ? $request->polianna_title_product : '';
        $data['polianna_pricesize'] = isset($request->polianna_pricesize) ? $request->polianna_pricesize : '';


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
