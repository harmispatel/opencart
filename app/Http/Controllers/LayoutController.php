<?php

namespace App\Http\Controllers;

use App\Models\AboutLayouts;
use App\Models\BestCategoryLayouts;
use App\Models\Footers;
use App\Models\GallaryLayouts;
use App\Models\Headers;
use App\Models\HtmlBox;
use App\Models\Layout;
use App\Models\OpenhourLayouts;
use App\Models\PopularFoodsLayouts;
use App\Models\RecentReviewsLayouts;
use App\Models\ReservationLayouts;
use App\Models\Settings;
use App\Models\Slider;
use App\Models\SlidersLayouts;
use App\Models\Store;
use App\Models\Themes;
use GuzzleHttp\Psr7\Header;
use Illuminate\Http\Request;
use URL;
use Illuminate\Support\Facades\Artisan;

class LayoutController extends Controller
{

    // Delete Slider by Slider ID
    function deleteSlider(Request $request)
    {
        $slider_id = $request->slider_id;

        $slider = Slider::where('id',$slider_id)->first();

        $slider_image = isset($slider->image) ? $slider->image : '';
        $slider_logo = isset($slider->logo) ? $slider->logo : '';

        if(!empty($slider_image) || $slider_image != '')
        {
            if(file_exists($slider_image))
            {
                unlink($slider_image);
            }
        }

        if(!empty($slider_logo) || $slider_logo != '')
        {
            if(file_exists($slider_logo))
            {
                unlink($slider_logo);
            }
        }

        $slider->delete();

        return response([
            'success' => 1,
        ]);

    }


    function deletehtmlbox(Request $request){
        $htmlbox_id =$request->htmlbox_id;

        $htmlbox = HtmlBox::find($htmlbox_id)->delete();

        return response([
            'success' => 1,
        ]);
    }



    // Template Setting For Frontend Layout
    public function templatesettings()
    {
        // Check User Permission
        if (check_user_role(73) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }


        // Get User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        // Get All Stores List
        $stores = Store::where('store_id','!=',$current_store_id)->get();

        // Get All Sliders
        $sliders = Slider::where('store_id',$current_store_id)->orderBy('id','ASC')->get();

        // Get All Sliders
        $htmlbox = HtmlBox::with(['hasoneaboutActive'])->where('store_id',$current_store_id)->orderBy('id','ASC')->get();

        // Get General Settings
        $get_genearl_settings = Settings::select('value')->where('store_id',$current_store_id)->where('key','general_settings')->first();
        $general_settings = isset($get_genearl_settings->value) ? unserialize($get_genearl_settings->value) : '';

        // Get All Headers
        $headers = Headers::get();

        // Get All Footers
        $footers = Footers::get();

        // Get All Gallary Layouts
        $gallary_layouts = GallaryLayouts::get();

        // Get All Best Category Layouts
        $bestcategory_layouts = BestCategoryLayouts::get();

        // Get All Popular Foods Layouts
        $popularfoods_layouts = PopularFoodsLayouts::get();

        // Get All Sliders Layouts
        $sliders_layouts = SlidersLayouts::get();

        // Get All Recent Reviews Layouts
        $reviews_layouts = RecentReviewsLayouts::get();

        // Get All About Layouts
        $about_layouts = AboutLayouts::get();

        // Get All Reservation Layouts
        $reservation_layouts = ReservationLayouts::get();

        // Get All Open Hours Layouts
        $openhours_layouts = OpenhourLayouts::get();


        return view('admin.settinglayouts.template_settings',compact([
            'headers',
            'footers',
            'gallary_layouts',
            'bestcategory_layouts',
            'popularfoods_layouts',
            'sliders_layouts',
            'reviews_layouts',
            'about_layouts',
            'reservation_layouts',
            'openhours_layouts',
            'stores',
            'sliders',
            'htmlbox',
            'general_settings',
        ]));
    }

    // Update Template Settings
    function updateTemplateSetting(Request $request)
    {
        // Get Current URL
        $currentURL = public_url();


        // Get User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        // Add & Update General Settings
        $general_settings = $request->general;

        if(isset($general_settings))
        {
            $serial = serialize($general_settings);

            $check_general_setting = Settings::where('store_id',$current_store_id)->where('key','general_settings')->first();

            $general_setting_id = isset($check_general_setting->setting_id) ? $check_general_setting->setting_id : '';

            if (!empty($general_setting_id) || $general_setting_id != '')
            {
                $general_setting_update = Settings::find($general_setting_id);
                $general_setting_update->value = $serial;
                $general_setting_update->update();
            }
            else
            {
                $general_setting_new = new Settings;
                $general_setting_new->group = 'template';
                $general_setting_new->store_id = $current_store_id;
                $general_setting_new->key = 'general_settings';
                $general_setting_new->value = $serial;
                $general_setting_new->serialized = 1;
                $general_setting_new->save();
            }
        }
        // End Add & Update General Settings


        // Add & Update Header Settings
        $header_settings = $request->header_setting;

        if(isset($header_settings))
        {
            $header_id = $header_settings['header_layout_id'];

            $check_header_setting = Settings::where('store_id',$current_store_id)->where('key','header_settings')->where('header_id',$header_id)->first();

            $old_header_setting = isset($check_header_setting->value) ? unserialize($check_header_setting->value) : '';

            $header_setting_id = isset($check_header_setting->setting_id) ? $check_header_setting->setting_id : '';

            if (!empty($header_setting_id) || $header_setting_id != '')
            {
                if(isset($header_settings['menu_topbar_open_banner']) != ''){
                    $header_settings['menu_topbar_open_banner'];
                }
                else {
                    $header_settings['menu_topbar_open_banner'] = isset($old_header_setting['menu_topbar_open_banner']) ? $old_header_setting['menu_topbar_open_banner'] : '';
                }

                    if(isset($header_settings['menu_topbar_close_banner']) != '')
                    {
                        $close_banner =$header_settings['menu_topbar_close_banner'];
                        $header_settings['menu_topbar_close_banner'] = $close_banner;
                    }
                    else{
                        $header_settings['menu_topbar_close_banner'] = isset($old_header_setting['menu_topbar_close_banner']) ? $old_header_setting['menu_topbar_close_banner'] : '';
                    }

                $update_serial_header_setting = serialize($header_settings);


                $header_setting_update = Settings::find($header_setting_id);
                $header_setting_update->value = $update_serial_header_setting;
                $header_setting_update->update();
            }
            else
            {
                if($header_settings['menu_topbar_open_banner'] != ''){
                    $header_settings['menu_topbar_open_banner'];
                }
                else {
                    $header_settings['menu_topbar_open_banner'] = isset($old_header_setting['menu_topbar_open_banner']) ? $old_header_setting['menu_topbar_open_banner'] : '';
                }

                if($header_settings['menu_topbar_close_banner'] != '')
                {
                    $header_settings['menu_topbar_close_banner'];
                }
                else{
                    $header_settings['menu_topbar_close_banner'] = isset($old_header_setting['menu_topbar_close_banner']) ? $old_header_setting['menu_topbar_close_banner'] : '';
                }

                $serial_header_setting = serialize($header_settings);

                $header_setting_new = new Settings;
                $header_setting_new->group = 'template';
                $header_setting_new->store_id = $current_store_id;
                $header_setting_new->header_id = $header_settings['header_layout_id'];
                $header_setting_new->key = 'header_settings';
                $header_setting_new->value = $serial_header_setting;
                $header_setting_new->serialized = 1;
                $header_setting_new->save();
            }

        }
        // End Add & Update Header Settings


        // Add & Update  Slider Settings
        $slider_settings = $request->slider_setting;

        if(isset($slider_settings))
        {
            $slider_id = $slider_settings['slider_layout_id'];

            $check_slider_setting = Settings::where('store_id',$current_store_id)->where('key','slider_settings')->where('slider_id',$slider_id)->first();

            $slider_setting_id = isset($check_slider_setting->setting_id) ? $check_slider_setting->setting_id : '';

            if (!empty($slider_setting_id) || $slider_setting_id != '')
            {
                $update_serial_slider_setting = serialize($slider_settings);

                $slider_setting_update = Settings::find($slider_setting_id);
                $slider_setting_update->value = $update_serial_slider_setting;
                $slider_setting_update->update();
            }
            else
            {
                $serial_slider_setting = serialize($slider_settings);

                $slider_setting_new = new Settings;
                $slider_setting_new->group = 'template';
                $slider_setting_new->store_id = $current_store_id;
                $slider_setting_new->slider_id = $slider_settings['slider_layout_id'];
                $slider_setting_new->key = 'slider_settings';
                $slider_setting_new->value = $serial_slider_setting;
                $slider_setting_new->serialized = 1;
                $slider_setting_new->save();
            }
        }
        // End Add & Update  Slider Settings.


        // Add & Update HTML BOX Settings
        $about_settings = $request->about_setting;

        if(isset($about_settings))
        {
            foreach($about_settings as $htmlbox_settings)
            {
                $about_settings_edit =  isset($htmlbox_settings['edithtmlbox']) ? $htmlbox_settings['edithtmlbox'] : '';
                $about_layout_id =  isset($htmlbox_settings['about_layout_id']) ? $htmlbox_settings['about_layout_id'] : '';
                $about_background_option =  isset($htmlbox_settings['about_background_option']) ? $htmlbox_settings['about_background_option'] : '';
                $about_image =  isset($htmlbox_settings['about_image']) ? $htmlbox_settings['about_image'] : '';
                $about_background_image =  isset($htmlbox_settings['about_background_image']) ? $htmlbox_settings['about_background_image'] : '';
                // $about_background_hover_color =  isset($htmlbox_settings['about_background_hover_color']) ? $htmlbox_settings['about_background_hover_color'] : '';
                $about_background_image_position =  isset($htmlbox_settings['about_background_image_position']) ? $htmlbox_settings['about_background_image_position'] : '';
                $about_title =  isset($htmlbox_settings['about_title']) ? $htmlbox_settings['about_title'] : '';
                $about_description =  isset($htmlbox_settings['about_description']) ? $htmlbox_settings['about_description'] : '';
                $about_background_color =  isset($htmlbox_settings['about_background_color']) ? $htmlbox_settings['about_background_color'] : '';


                if($about_settings_edit != '' || !empty($about_settings_edit)){
                    $about_setting_htmlbox = HtmlBox::find($about_settings_edit);
                    // $about_setting_htmlbox->store_id = $current_store_id;
                    $about_setting_htmlbox->about_layout_id = $about_layout_id;
                    $about_setting_htmlbox->about_background_option = $about_background_option;
                    if (!empty($about_image) || $about_image != '') {
                        $about_setting_htmlbox->about_image = $about_image;
                    }

                    if (!empty($about_background_image) || $about_background_image != '') {
                        $about_setting_htmlbox->about_background_image = $about_background_image;
                    }

                    // if (!empty($about_background_hover_color) || $about_background_hover_color != '') {
                    //     $about_setting_htmlbox->about_background_hover_color = $about_background_hover_color;
                    // }

                    if (!empty($about_background_color) || $about_background_color != '') {
                        $about_setting_htmlbox->about_background_color = $about_background_color;
                    }

                    $about_setting_htmlbox->about_background_image_position = $about_background_image_position;
                    $about_setting_htmlbox->about_title = $about_title;
                    $about_setting_htmlbox->about_description = $about_description;
                    // $about_setting_htmlbox->created_at = date('Y-m-d H:i:s');
                    $about_setting_htmlbox->update();
                }
                else{
                    $about_setting_htmlbox = new HtmlBox;
                    $about_setting_htmlbox->store_id = $current_store_id;
                    $about_setting_htmlbox->about_layout_id = $about_layout_id;
                    $about_setting_htmlbox->about_background_option = $about_background_option;
                    $about_setting_htmlbox->about_image = $about_image;
                    $about_setting_htmlbox->about_background_image = $about_background_image;
                    // $about_setting_htmlbox->about_background_hover_color = $about_background_hover_color;
                    $about_setting_htmlbox->about_background_image_position = $about_background_image_position;
                    $about_setting_htmlbox->about_title = $about_title;
                    $about_setting_htmlbox->about_description = $about_description;
                    $about_setting_htmlbox->about_background_color = $about_background_color;
                    $about_setting_htmlbox->created_at = date('Y-m-d H:i:s');
                    $about_setting_htmlbox->save();
                }

            }
        }

        // if(isset($about_settings))
        // {
        //     $about_id = $about_settings['about_layout_id'];

        //     $check_about_setting = Settings::where('store_id',$current_store_id)->where('key','about_settings')->where('about_id',$about_id)->first();

        //     $old_about_setting = isset($check_about_setting->value) ? unserialize($check_about_setting->value) : '';

        //     $about_setting_id = isset($check_about_setting->setting_id) ? $check_about_setting->setting_id : '';

        //     if (!empty($about_setting_id) || $about_setting_id != '')
        //     {
        //         if(isset($about_settings['about_background_image']) != ''){
        //             $about_settings['about_background_image'];
        //         }
        //         else{
        //             $about_settings['about_background_image'] = isset($old_about_setting['about_background_image']) ? $old_about_setting['about_background_image'] : '';
        //         }
        //         if(isset($about_settings['about_image']) != ''){
        //             $about_settings['about_image'];
        //         }
        //         else{
        //             $about_settings['about_image'] = isset($old_about_setting['about_image']) ? $old_about_setting['about_image'] :"";
        //         }

        //         $update_serial_about_setting = serialize($about_settings);

        //         $about_setting_update = Settings::find($about_setting_id);
        //         $about_setting_update->value = $update_serial_about_setting;
        //         $about_setting_update->update();
        //     }
        //     else
        //     {
        //         if(isset($about_settings['about_background_image']) != ''){
        //             $about_settings['about_background_image'];
        //         }
        //         else{
        //             $about_settings['about_background_image'] = isset($old_about_setting['about_background_image']) ? $old_about_setting['about_background_image'] : '';
        //         }
        //         if(isset($about_settings['about_image']) != ''){
        //             $about_settings['about_image'];
        //         }
        //         else{
        //             $about_settings['about_image'] = isset($old_about_setting['about_image']) ? $old_about_setting['about_image'] : '';
        //         }

        //         $serial_about_setting = serialize($about_settings);

        //         $htmlbox = new Settings;
        //         $htmlbox->group = 'template';
        //         $htmlbox->store_id = $current_store_id;
        //         $htmlbox->about_id = $about_settings['about_layout_id'];
        //         $htmlbox->key = 'about_settings';
        //         $htmlbox->value = $serial_about_setting;
        //         $htmlbox->serialized = 1;
        //         $htmlbox->save();
        //     }

        // }
        // End Add & Update HTML BOX Settings


        // Add & Update Popular food Settings
        $popularfood_settings = $request->popularfood_setting;

        if(isset($popularfood_settings))
        {
            $popularfood_id = $popularfood_settings['popularfood_layout_id'];

            $check_popularfood_setting = Settings::where('store_id',$current_store_id)->where('key','popularfood_settings')->where('popularfood_id',$popularfood_id)->first();

            $old_popularfood_setting = isset($check_popularfood_setting->value) ? unserialize($check_popularfood_setting->value) : '';

            $popularfood_setting_id = isset($check_popularfood_setting->setting_id) ? $check_popularfood_setting->setting_id : '';

            if (!empty($popularfood_setting_id) || $popularfood_setting_id != '')
            {
                if (isset($popularfood_settings['popularfood_background_image']) != '') {
                    $popularfood_settings['popularfood_background_image'];
                }
                else{
                    $popularfood_settings['popularfood_background_image'] = isset($old_popularfood_setting['popularfood_background_image']) ? $old_popularfood_setting['popularfood_background_image'] : '';
                }


                $update_serial_popularfood_setting = serialize($popularfood_settings);

                $popularfood_setting_update = Settings::find($popularfood_setting_id);
                $popularfood_setting_update->value = $update_serial_popularfood_setting;
                $popularfood_setting_update->update();
            }
            else{
                if (isset($popularfood_settings['popularfood_background_image']) != '') {
                    $popularfood_settings['popularfood_background_image'];
                }
                else{
                    $popularfood_settings['popularfood_background_image'] = isset($old_popularfood_setting['popularfood_background_image']) ? $old_popularfood_setting['popularfood_background_image'] : '';
                }
                $serial_popularfood_setting = serialize($popularfood_settings);

                $popularfood_setting_new = new Settings;
                $popularfood_setting_new->group = 'template';
                $popularfood_setting_new->store_id = $current_store_id;
                $popularfood_setting_new->popularfood_id = $popularfood_settings['popularfood_layout_id'];
                $popularfood_setting_new->key = 'popularfood_settings';
                $popularfood_setting_new->value = $serial_popularfood_setting;
                $popularfood_setting_new->serialized = 1;
                $popularfood_setting_new->save();
            }
        }
        // End Add & Update Popular food Settings


        // Add & Update Best Category Settings
        $bestcategory_settings = $request->bestcategory_setting;

        if(isset($bestcategory_settings))
        {
            $bestcategory_id = $bestcategory_settings['bestcategory_layout_id'];

            $check_bestcategory_setting = Settings::where('store_id',$current_store_id)->where('key','bestcategory_settings')->where('bestcategory_id',$bestcategory_id)->first();

            $old_bestcategory_setting = isset($check_bestcategory_setting->value) ? unserialize($check_bestcategory_setting->value) : '';

            $bestcategory_setting_id = isset($check_bestcategory_setting->setting_id) ? $check_bestcategory_setting->setting_id : '';

            if (!empty($bestcategory_setting_id) || $bestcategory_setting_id != '')
            {
                if(isset($bestcategory_settings['bestcategory_background_image']) != "")
                {
                    $bestcategory_settings['bestcategory_background_image'];
                }
                else{
                    $bestcategory_settings['bestcategory_background_image'] = isset($old_bestcategory_setting['bestcategory_background_image']) ? $old_bestcategory_setting['bestcategory_background_image'] : '';
                }

                $update_serial_bestcategory_setting = serialize($bestcategory_settings);

                $bestcategory_setting_update = Settings::find($bestcategory_setting_id);
                $bestcategory_setting_update->value = $update_serial_bestcategory_setting;
                $bestcategory_setting_update->update();
            }
            else{
                if(isset($bestcategory_settings['bestcategory_background_image']) != "")
                {
                    $bestcategory_settings['bestcategory_background_image'];
                }
                else{
                    $bestcategory_settings['bestcategory_background_image'] = isset($old_bestcategory_setting['bestcategory_background_image']) ? $old_bestcategory_setting['bestcategory_background_image'] : '';
                }

                $serial_bestcategory_setting = serialize($bestcategory_settings);

                $bestcategory_setting_new = new Settings;
                $bestcategory_setting_new->group = 'template';
                $bestcategory_setting_new->store_id = $current_store_id;
                $bestcategory_setting_new->bestcategory_id = $bestcategory_settings['bestcategory_layout_id'];
                $bestcategory_setting_new->key = 'bestcategory_settings';
                $bestcategory_setting_new->value = $serial_bestcategory_setting;
                $bestcategory_setting_new->serialized = 1;
                $bestcategory_setting_new->save();
            }
        }
        // End Add & Update Best Category Settings


        // Add & Update Recent Reviews Settings
        $review_settings = $request->review_setting;

        if(isset($review_settings))
        {
            $review_id = $review_settings['review_layout_id'];

            $check_review_setting = Settings::where('store_id',$current_store_id)->where('key','review_settings')->where('reviews_id',$review_id)->first();

            $old_review_setting = isset($check_review_setting->value) ? unserialize($check_review_setting->value) : '';

            $review_setting_id = isset($check_review_setting->setting_id) ? $check_review_setting->setting_id : '';
            if (!empty($review_setting_id) || $review_setting_id != '')
            {
                if (isset($review_settings['review_background_image']) != "") {
                    $review_settings['review_background_image'];
                } else {
                    $review_settings['review_background_image'] = isset($old_review_setting['review_background_image']) ? $old_review_setting['review_background_image'] : '';
                }

                $update_serial_review_setting = serialize($review_settings);

                $review_setting_update = Settings::find($review_setting_id);
                $review_setting_update->value = $update_serial_review_setting;
                $review_setting_update->update();
            }
            else{
                if (isset($review_settings['review_background_image']) != "") {
                    $review_settings['review_background_image'];
                } else {
                    $review_settings['review_background_image'] = isset($old_review_setting['review_background_image']) ? $old_review_setting['review_background_image'] : '';
                }

                $serial_review_setting = serialize($review_settings);

                $review_setting_new = new Settings;
                $review_setting_new->group = 'template';
                $review_setting_new->store_id = $current_store_id;
                $review_setting_new->reviews_id = $review_settings['review_layout_id'];
                $review_setting_new->key = 'review_settings';
                $review_setting_new->value = $serial_review_setting;
                $review_setting_new->serialized = 1;
                $review_setting_new->save();
            }

        }
        // End Add & Update Recent Reviews Settings


        // Add & Update Reservation Settings
        $reservation_settings = $request->reservation_setting;

        if(isset($reservation_settings))
        {
            $reservation_id = $reservation_settings['reservation_layout_id'];

            $check_reservation_setting = Settings::where('store_id',$current_store_id)->where('key','reservation_settings')->where('reservation_id',$reservation_id)->first();

            $reservation_setting_id = isset($check_reservation_setting->setting_id) ? $check_reservation_setting->setting_id : '';

            if (!empty($reservation_setting_id) || $reservation_setting_id != '')
            {
                $update_serial_reservation_setting = serialize($reservation_settings);

                $reservation_setting_update = Settings::find($reservation_setting_id);
                $reservation_setting_update->value = $update_serial_reservation_setting;
                $reservation_setting_update->update();
            }
            else
            {
                $serial_reservation_setting = serialize($reservation_settings);

                $reservation_setting_new = new Settings;
                $reservation_setting_new->group = 'template';
                $reservation_setting_new->store_id = $current_store_id;
                $reservation_setting_new->reservation_id = $reservation_settings['reservation_layout_id'];
                $reservation_setting_new->key = 'reservation_settings';
                $reservation_setting_new->value = $serial_reservation_setting;
                $reservation_setting_new->serialized = 1;
                $reservation_setting_new->save();
            }

        }
        // End Add & Update Reservation Settings


        // Add & Update Gallary Settings
        $gallary_settings = $request->gallary_setting;

        if(isset($gallary_settings))
        {
            $gallary_id = $gallary_settings['gallary_layout_id'];

            $check_gallary_setting = Settings::where('store_id',$current_store_id)->where('key','gallary_settings')->where('gallary_id',$gallary_id)->first();

            $gallary_setting_id = isset($check_gallary_setting->setting_id) ? $check_gallary_setting->setting_id : '';

            if (!empty($gallary_setting_id) || $gallary_setting_id != '')
            {
                $update_serial_gallary_setting = serialize($gallary_settings);

                $gallary_setting_update = Settings::find($gallary_setting_id);
                $gallary_setting_update->value = $update_serial_gallary_setting;
                $gallary_setting_update->update();
            }
            else
            {
                $serial_gallary_setting = serialize($gallary_settings);

                $gallary_setting_new = new Settings;
                $gallary_setting_new->group = 'template';
                $gallary_setting_new->store_id = $current_store_id;
                $gallary_setting_new->gallary_id = $gallary_settings['gallary_layout_id'];
                $gallary_setting_new->key = 'gallary_settings';
                $gallary_setting_new->value = $serial_gallary_setting;
                $gallary_setting_new->serialized = 1;
                $gallary_setting_new->save();
            }

        }
        // End Add & Update Gallary Settings


        // Add & Update Footer Settings
        $footer_settings = $request->footer_setting;

        if(isset($footer_settings))
        {
            $footer_id = $footer_settings['footer_layout_id'];

            $check_footer_setting = Settings::where('store_id',$current_store_id)->where('key','footer_settings')->where('footer_id',$footer_id)->first();

            $footer_setting_id = isset($check_footer_setting->setting_id) ? $check_footer_setting->setting_id : '';

            if (!empty($footer_setting_id) || $footer_setting_id != '')
            {
                $update_serial_footer_setting = serialize($footer_settings);

                $footer_setting_update = Settings::find($footer_setting_id);
                $footer_setting_update->value = $update_serial_footer_setting;
                $footer_setting_update->update();
            }
            else
            {
                $serial_footer_setting = serialize($footer_settings);

                $footer_setting_new = new Settings;
                $footer_setting_new->group = 'template';
                $footer_setting_new->store_id = $current_store_id;
                $footer_setting_new->footer_id = $footer_settings['footer_layout_id'];
                $footer_setting_new->key = 'footer_settings';
                $footer_setting_new->value = $serial_footer_setting;
                $footer_setting_new->serialized = 1;
                $footer_setting_new->save();
            }

        }
        // End Add & Update Footer Settings


        // Add & Update Open Hours Settings
        // $openhour_settings = $request->openhour_setting;

        // if(isset($openhour_settings))
        // {
        //     $openhour_id = $openhour_settings['openhour_layout_id'];

        //     $check_openhour_setting = Settings::where('store_id',$current_store_id)->where('key','openhour_settings')->where('openhours_id',$openhour_id)->first();

        //     $old_openhour_setting = isset($check_openhour_setting->value) ? unserialize($check_openhour_setting->value) : '';

        //     $openhour_setting_id = isset($check_openhour_setting->setting_id) ? $check_openhour_setting->setting_id : '';

        //     if (!empty($openhour_setting_id) || $openhour_setting_id != '')
        //     {
        //         $openhour_background_image = isset($openhour_settings['openhour_background_image']) ? $openhour_settings['openhour_background_image'] : '';

        //         if(!empty($openhour_background_image) || $openhour_background_image != '')
        //         {
        //             if (isset($openhour_settings['openhour_background_image']) != '') {
        //                 $openhour_settings['openhour_background_image'];
        //             } else {
        //                 $openhour_settings['openhour_background_image'] = isset($old_openhour_setting['openhour_background_image']) ? $old_openhour_setting['openhour_background_image'] : '';
        //             }


        //             $update_serial_openhour_setting = serialize($openhour_settings);

        //             $openhour_setting_update = Settings::find($openhour_setting_id);
        //             $openhour_setting_update->value = $update_serial_openhour_setting;
        //             $openhour_setting_update->update();
        //         }
        //     }
        //     else{
        //         if (isset($openhour_settings['openhour_background_image']) != '') {
        //             $openhour_settings['openhour_background_image'];
        //         } else {
        //             $openhour_settings['openhour_background_image'] = isset($old_openhour_setting['openhour_background_image']) ? $old_openhour_setting['openhour_background_image'] : '';
        //         }

        //         $serial_openhour_setting = serialize($openhour_settings);

        //         $openhour_setting_new = new Settings;
        //         $openhour_setting_new->group = 'template';
        //         $openhour_setting_new->store_id = $current_store_id;
        //         $openhour_setting_new->openhours_id = $openhour_settings['openhour_layout_id'];
        //         $openhour_setting_new->key = 'openhour_settings';
        //         $openhour_setting_new->value = $serial_openhour_setting;
        //         $openhour_setting_new->serialized = 1;
        //         $openhour_setting_new->save();

        //     }

        // }
            // End Add & Update Open Hours Settings


        // Add Sliders & Update Sliders
        $sliders = $request->slider;

        if(isset($sliders))
        {
            foreach($sliders as $slider)
            {
                $slider_title =  isset($slider['title']) ? $slider['title'] : '';
                $slider_desc =  isset($slider['desc']) ? $slider['desc'] : '';
                $slider_image =  isset($slider['image']) ? $slider['image'] : '';
                $slider_logo =  isset($slider['logo']) ? $slider['logo'] : '';
                $slider_edit =  isset($slider['edit']) ? $slider['edit'] : '';

                if($slider_edit != '' || !empty($slider_edit))
                {
                    $edit_slider = Slider::find($slider_edit);
                    $edit_slider->title =  $slider_title;
                    $edit_slider->description = $slider_desc;

                    // Slider Image
                    if($slider_image != '' || !empty($slider_image))
                    {
                        $edit_slider->image = $slider_image;
                    }

                    if($slider_logo != '' || !empty($slider_logo)){
                        $edit_slider->logo = $slider_logo;
                    }

                    $edit_slider->update();


                }
                else
                {
                    $new_slider = new Slider;
                    $new_slider->title = $slider_title;
                    $new_slider->description = $slider_desc;
                    $new_slider->store_id = $current_store_id;


                    // Slider Image
                    if($slider_image != '' || !empty($slider_image))
                    {
                        $new_slider->image = $slider_image;
                    }

                    // Slider Logo
                    if($slider_logo != '' || !empty($slider_logo))
                    {
                        $new_slider->logo = $slider_logo;
                    }

                    $new_slider->save();

                }

            }
        }
        // End Add Sliders & Update Sliders

        // return redirect()->route('templatesettings')->with('success', 'Settings Updated..');
        return response()->json([
            'success' => 1
        ]);
    }




    // Function of Active Current Theme for Frontend
    public function activetheme($id)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $theme_id = $id;
        $key = 'theme_id';

        if($user_group_id == 1)
        {
            $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();
        }
        else
        {
            $setting = Settings::where('store_id',$user_shop_id)->where('key',$key)->first();
        }

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
            if($user_group_id == 1)
            {
                $active_new->store_id = $current_store_id;
            }
            else
            {
                $active_new->store_id = $user_shop_id;
            }
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $theme_id;
            $active_new->serialized = 0;
            $active_new->save();
        }
        // Artisan::call('view:clear');
        return redirect()->route('templatesettings');

    }





    // Function of Active Current Header Layout for Frontend
    public function activeheader($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $header_id = $id;
        $key = 'header_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $header_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $header_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1
        ]);

    }





    // Function of Active Current Footer Layout for Frontend
    public function activefooter($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $footer_id = $id;
        $key = 'footer_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $footer_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $footer_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current Gallary Layout for Frontend
    public function activegallary($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $gallary_id = $id;
        $key = 'gallary_id';
        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $gallary_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $gallary_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }




    // Function of Active Current Best Category Layout for Frontend
    public function activebestcategory($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $bestcategory_id = $id;
        $key = 'bestcategory_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $bestcategory_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $bestcategory_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current Popular Foods Layout for Frontend
    public function activepopularfood($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $popularfood_id = $id;
        $key = 'popularfood_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';
            $active_header = Settings::find($setting_id);
            $active_header->value = $popularfood_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $popularfood_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current Slider Layout for Frontend
    public function activeslider($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $slider_id = $id;
        $key = 'slider_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $slider_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $slider_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current Recent Review Layout for Frontend
    public function activerecentreview($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $review_id = $id;
        $key = 'review_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $review_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $review_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current About Layout for Frontend
    public function activeabout($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $about_id = $id;
        $key = 'about_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $about_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $about_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current Reservation Layout for Frontend
    public function activereservation($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $reservation_id = $id;
        $key = 'reservation_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';

            $active_header = Settings::find($setting_id);
            $active_header->value = $reservation_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $reservation_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }





    // Function of Active Current Open Hours Layout for Frontend
    public function activeopenhours($id)
    {
        // User Details
        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }


        // Current Store ID
        if($user_group_id == 1)
        {
            $current_store_id = currentStoreId();
        }
        else
        {
            $current_store_id = $user_details['user_shop'];
        }


        $openhour_id = $id;
        $key = 'openhour_id';

        $setting = Settings::where('store_id',$current_store_id)->where('key',$key)->first();

        if(!empty($setting) || $setting != '')
        {
            $setting_id = isset($setting->setting_id) ? $setting->setting_id : '';
            $active_header = Settings::find($setting_id);
            $active_header->value = $openhour_id;
            $active_header->update();
        }
        else
        {
            $active_new = new Settings();
            $active_new->store_id = $current_store_id;
            $active_new->group = 'polianna';
            $active_new->key = $key;
            $active_new->value = $openhour_id;
            $active_new->serialized = 0;
            $active_new->save();
        }

        return response()->json([
            'success' => 1,
        ]);

    }

    // public function setbackground(Request $request)
    // {
    //     // echo '<pre>';
    //     // print_r($request->all());
    //     // exit();

    //     $settingkey = $request->itemname;
    //     $settingsvalue = $request->itemvalue;

    //     echo '<pre>';
    //     print_r($settingkey);
    //     exit();

    //     // Get Current URL
    //     $currentURL = public_url();


    //     // Get User Details
    //     $user_details = user_details();
    //     if(isset($user_details))
    //     {
    //         $user_group_id = $user_details['user_group_id'];
    //     }

    //     // Current Store ID
    //     if($user_group_id == 1)
    //     {
    //         $current_store_id = currentStoreId();
    //     }
    //     else
    //     {
    //         $current_store_id = $user_details['user_shop'];
    //     }

    //     // Add & Update HTML BOX Settings
    //     $about_settings = $request->about_setting;

    //     if(isset($about_settings))
    //     {
    //         $about_id = $about_settings['about_layout_id'];

    //         $check_about_setting = Settings::where('store_id',$current_store_id)->where('key','about_settings')->where('about_id',$about_id)->first();

    //         $old_about_setting = isset($check_about_setting->value) ? unserialize($check_about_setting->value) : '';

    //         $about_setting_id = isset($check_about_setting->setting_id) ? $check_about_setting->setting_id : '';

    //         if (!empty($about_setting_id) || $about_setting_id != '')
    //         {
    //             if(isset($about_settings['about_background_image']) != ''){
    //                 $about_settings['about_background_image'];
    //             }
    //             else{
    //                 $about_settings['about_background_image'] = isset($old_about_setting['about_background_image']) ? $old_about_setting['about_background_image'] : '';
    //             }
    //             if(isset($about_settings['about_image']) != ''){
    //                 $about_settings['about_image'];
    //             }
    //             else{
    //                 $about_settings['about_image'] = isset($old_about_setting['about_image']) ? $old_about_setting['about_image'] :"";
    //             }

    //             $update_serial_about_setting = serialize($about_settings);

    //             $about_setting_update = Settings::find($about_setting_id);
    //             $about_setting_update->value = $update_serial_about_setting;
    //             $about_setting_update->update();
    //         }
    //     }
    //     else
    //     {
    //         if(isset($about_settings['about_background_image']) != ''){
    //             $about_settings['about_background_image'];
    //         }
    //         else{
    //             $about_settings['about_background_image'] = isset($old_about_setting['about_background_image']) ? $old_about_setting['about_background_image'] : '';
    //         }
    //         if(isset($about_settings['about_image']) != ''){
    //             $about_settings['about_image'];
    //         }
    //         else{
    //             $about_settings['about_image'] = isset($old_about_setting['about_image']) ? $old_about_setting['about_image'] : '';
    //         }

    //         $serial_about_setting = serialize($about_settings);

    //         $about_setting_new = new Settings;
    //         $about_setting_new->group = 'template';
    //         $about_setting_new->store_id = $current_store_id;
    //         $about_setting_new->about_id = $about_settings['about_layout_id'];
    //         $about_setting_new->key = 'about_settings';
    //         $about_setting_new->value = $serial_about_setting;
    //         $about_setting_new->serialized = 1;
    //         $about_setting_new->save();
    //     }
    // }





    // Function of Slider Setting
    public function slidersettings()
    {
        // Check User Permission
        if (check_user_role(75) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.settinglayouts.slider_settings');
    }



    // Function of Banner And Blocks
    public function bannerandblocks()
    {
        // Check User Permission
        if (check_user_role(76) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.settinglayouts.banner_and_blocks');
    }


}
