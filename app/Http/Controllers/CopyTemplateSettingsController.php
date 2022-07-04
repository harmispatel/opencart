<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class CopyTemplateSettingsController extends Controller
{
    public function copytemplatesettings(Request $request)
    {
        $current_store_id = currentStoreId();
        $copy_from_store_id = $request->store_id;

        $keys = ([
            'general_settings',
            'header_settings',
            'slider_settings',
            'about_settings',
            'popularfood_settings',
            'bestcategory_settings',
            'review_settings',
            'reservation_settings',
            'gallary_settings',
            'openhour_settings',
            'footer_settings',
        ]);

        foreach ($keys as $value)
        {
            // General Settings
            if($value == 'general_settings')
            {
                $get_from_general_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->first();
                $from_general_settings_value = isset($get_from_general_settings->value) ? $get_from_general_settings->value : '';

                if(!empty($from_general_settings_value) || $from_general_settings_value != '')
                {
                    $get_to_general_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->first();
                    $to_general_setting_id = isset($get_to_general_settings->setting_id) ? $get_to_general_settings->setting_id : '';

                    if(!empty($to_general_setting_id) || $to_general_setting_id != '')
                    {
                        $update_to_general_settings = Settings::find($to_general_setting_id);
                        $update_to_general_settings->value = $from_general_settings_value;
                        $update_to_general_settings->update();
                    }
                    else
                    {
                        $new_to_general_settings = new Settings;
                        $new_to_general_settings->group = 'template';
                        $new_to_general_settings->store_id = $current_store_id;
                        $new_to_general_settings->key = 'general_settings';
                        $new_to_general_settings->value = $from_general_settings_value;
                        $new_to_general_settings->serialized = 1;
                        $new_to_general_settings->save();
                    }
                }
            }
            //End  General Settings



            // Header Settings
            if($value == 'header_settings')
            {
                $get_from_current_header = Settings::select('value')->where('key','header_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_header_id = isset($get_from_current_header->value) ? $get_from_current_header->value : '';

                if(!empty($get_from_current_header_id) || $get_from_current_header_id != '')
                {
                    $get_from_header_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('header_id',$get_from_current_header_id)->first();
                    $from_header_settings_value = isset($get_from_header_settings->value) ? $get_from_header_settings->value : '';

                    if(!empty($from_header_settings_value) || $from_header_settings_value != '')
                    {
                        $get_to_current_header = Settings::where('key','header_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_header_id = isset($get_to_current_header->value) ? $get_to_current_header->value : '';

                        if(!empty($get_to_current_header_id) || $get_to_current_header_id != '')
                        {
                            if($get_to_current_header_id != $get_from_current_header_id)
                            {
                                $update_to_current_header = Settings::find($get_to_current_header->setting_id);
                                $update_to_current_header->value = $get_from_current_header_id;
                                $update_to_current_header->update();
                            }
                        }
                        else
                        {
                            $new_to_current_header = new Settings;
                            $new_to_current_header->store_id = $current_store_id;
                            $new_to_current_header->group = 'polianna';
                            $new_to_current_header->key = 'header_id';
                            $new_to_current_header->value = $get_from_current_header_id;
                            $new_to_current_header->save();
                        }

                        $get_to_header_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('header_id',$get_from_current_header_id)->first();
                        $to_header_setting_id = isset($get_to_header_settings->setting_id) ? $get_to_header_settings->setting_id : '';

                        if(!empty($to_header_setting_id) || $to_header_setting_id != '')
                        {
                            $update_to_header_settings = Settings::find($to_header_setting_id);
                            $update_to_header_settings->value = $from_header_settings_value;
                            $update_to_header_settings->update();
                        }
                        else
                        {
                            $new_to_header_settings = new Settings;
                            $new_to_header_settings->group = 'template';
                            $new_to_header_settings->store_id = $current_store_id;
                            $new_to_header_settings->header_id = $get_from_current_header_id;
                            $new_to_header_settings->key = 'header_settings';
                            $new_to_header_settings->value = $from_header_settings_value;
                            $new_to_header_settings->serialized = 1;
                            $new_to_header_settings->save();
                        }

                    }
                }

            }
            // End Header Settings



            // Slider Settings
            if($value == 'slider_settings')
            {
                $get_from_current_slider = Settings::select('value')->where('key','slider_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_slider_id = isset($get_from_current_slider->value) ? $get_from_current_slider->value : '';

                if(!empty($get_from_current_slider_id) || $get_from_current_slider_id != '')
                {
                    $get_from_slider_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('slider_id',$get_from_current_slider_id)->first();
                    $from_slider_settings_value = isset($get_from_slider_settings->value) ? $get_from_slider_settings->value : '';

                    if(!empty($from_slider_settings_value) || $from_slider_settings_value != '')
                    {
                        $get_to_current_slider = Settings::where('key','slider_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_slider_id = isset($get_to_current_slider->value) ? $get_to_current_slider->value : '';

                        if(!empty($get_to_current_slider_id) || $get_to_current_slider_id != '')
                        {
                            if($get_to_current_slider_id != $get_from_current_slider_id)
                            {
                                $update_to_current_slider = Settings::find($get_to_current_slider->setting_id);
                                $update_to_current_slider->value = $get_from_current_slider_id;
                                $update_to_current_slider->update();
                            }
                        }
                        else
                        {
                            $new_to_current_slider = new Settings;
                            $new_to_current_slider->store_id = $current_store_id;
                            $new_to_current_slider->group = 'polianna';
                            $new_to_current_slider->key = 'slider_id';
                            $new_to_current_slider->value = $get_from_current_slider_id;
                            $new_to_current_slider->save();
                        }

                        $get_to_slider_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('slider_id',$get_from_current_slider_id)->first();
                        $to_slider_setting_id = isset($get_to_slider_settings->setting_id) ? $get_to_slider_settings->setting_id : '';

                        if(!empty($to_slider_setting_id) || $to_slider_setting_id != '')
                        {
                            $update_to_slider_settings = Settings::find($to_slider_setting_id);
                            $update_to_slider_settings->value = $from_slider_settings_value;
                            $update_to_slider_settings->update();
                        }
                        else
                        {
                            $new_to_slider_settings = new Settings;
                            $new_to_slider_settings->group = 'template';
                            $new_to_slider_settings->store_id = $current_store_id;
                            $new_to_slider_settings->slider_id = $get_from_current_slider_id;
                            $new_to_slider_settings->key = 'slider_settings';
                            $new_to_slider_settings->value = $from_slider_settings_value;
                            $new_to_slider_settings->serialized = 1;
                            $new_to_slider_settings->save();
                        }

                    }
                }

            }
            // End Slider Settings



            // About Settings
            if($value == 'about_settings')
            {
                $get_from_current_about = Settings::select('value')->where('key','about_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_about_id = isset($get_from_current_about->value) ? $get_from_current_about->value : '';

                if(!empty($get_from_current_about_id) || $get_from_current_about_id != '')
                {
                    $get_from_about_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('about_id',$get_from_current_about_id)->first();
                    $from_about_settings_value = isset($get_from_about_settings->value) ? $get_from_about_settings->value : '';

                    if(!empty($from_about_settings_value) || $from_about_settings_value != '')
                    {
                        $get_to_current_about = Settings::where('key','about_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_about_id = isset($get_to_current_about->value) ? $get_to_current_about->value : '';

                        if(!empty($get_to_current_about_id) || $get_to_current_about_id != '')
                        {
                            if($get_to_current_about_id != $get_from_current_about_id)
                            {
                                $update_to_current_about = Settings::find($get_to_current_about->setting_id);
                                $update_to_current_about->value = $get_from_current_about_id;
                                $update_to_current_about->update();
                            }
                        }
                        else
                        {
                            $new_to_current_about = new Settings;
                            $new_to_current_about->store_id = $current_store_id;
                            $new_to_current_about->group = 'polianna';
                            $new_to_current_about->key = 'about_id';
                            $new_to_current_about->value = $get_from_current_about_id;
                            $new_to_current_about->save();
                        }

                        $get_to_about_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('about_id',$get_from_current_about_id)->first();
                        $to_about_setting_id = isset($get_to_about_settings->setting_id) ? $get_to_about_settings->setting_id : '';

                        if(!empty($to_about_setting_id) || $to_about_setting_id != '')
                        {
                            $update_to_about_settings = Settings::find($to_about_setting_id);
                            $update_to_about_settings->value = $from_about_settings_value;
                            $update_to_about_settings->update();
                        }
                        else
                        {
                            $new_to_about_settings = new Settings;
                            $new_to_about_settings->group = 'template';
                            $new_to_about_settings->store_id = $current_store_id;
                            $new_to_about_settings->about_id = $get_from_current_about_id;
                            $new_to_about_settings->key = 'about_settings';
                            $new_to_about_settings->value = $from_about_settings_value;
                            $new_to_about_settings->serialized = 1;
                            $new_to_about_settings->save();
                        }

                    }
                }

            }
            // End About Settings



            // Gallary Settings
            if($value == 'gallary_settings')
            {
                $get_from_current_gallary = Settings::select('value')->where('key','gallary_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_gallary_id = isset($get_from_current_gallary->value) ? $get_from_current_gallary->value : '';

                if(!empty($get_from_current_gallary_id) || $get_from_current_gallary_id != '')
                {
                    $get_from_gallary_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('gallary_id',$get_from_current_gallary_id)->first();
                    $from_gallary_settings_value = isset($get_from_gallary_settings->value) ? $get_from_gallary_settings->value : '';

                    if(!empty($from_gallary_settings_value) || $from_gallary_settings_value != '')
                    {
                        $get_to_current_gallary = Settings::where('key','gallary_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_gallary_id = isset($get_to_current_gallary->value) ? $get_to_current_gallary->value : '';

                        if(!empty($get_to_current_gallary_id) || $get_to_current_gallary_id != '')
                        {
                            if($get_to_current_gallary_id != $get_from_current_gallary_id)
                            {
                                $update_to_current_gallary = Settings::find($get_to_current_gallary->setting_id);
                                $update_to_current_gallary->value = $get_from_current_gallary_id;
                                $update_to_current_gallary->update();
                            }
                        }
                        else
                        {
                            $new_to_current_gallary = new Settings;
                            $new_to_current_gallary->store_id = $current_store_id;
                            $new_to_current_gallary->group = 'polianna';
                            $new_to_current_gallary->key = 'gallary_id';
                            $new_to_current_gallary->value = $get_from_current_gallary_id;
                            $new_to_current_gallary->save();
                        }

                        $get_to_gallary_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('gallary_id',$get_from_current_gallary_id)->first();
                        $to_gallary_setting_id = isset($get_to_gallary_settings->setting_id) ? $get_to_gallary_settings->setting_id : '';

                        if(!empty($to_gallary_setting_id) || $to_gallary_setting_id != '')
                        {
                            $update_to_gallary_settings = Settings::find($to_gallary_setting_id);
                            $update_to_gallary_settings->value = $from_gallary_settings_value;
                            $update_to_gallary_settings->update();
                        }
                        else
                        {
                            $new_to_gallary_settings = new Settings;
                            $new_to_gallary_settings->group = 'template';
                            $new_to_gallary_settings->store_id = $current_store_id;
                            $new_to_gallary_settings->gallary_id = $get_from_current_gallary_id;
                            $new_to_gallary_settings->key = 'gallary_settings';
                            $new_to_gallary_settings->value = $from_gallary_settings_value;
                            $new_to_gallary_settings->serialized = 1;
                            $new_to_gallary_settings->save();
                        }

                    }
                }

            }
            // End Gallary Settings



            // PopularFood Settings
            if($value == 'popularfood_settings')
            {
                $get_from_current_popularfood = Settings::select('value')->where('key','popularfood_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_popularfood_id = isset($get_from_current_popularfood->value) ? $get_from_current_popularfood->value : '';

                if(!empty($get_from_current_popularfood_id) || $get_from_current_popularfood_id != '')
                {
                    $get_from_popularfood_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('popularfood_id',$get_from_current_popularfood_id)->first();
                    $from_popularfood_settings_value = isset($get_from_popularfood_settings->value) ? $get_from_popularfood_settings->value : '';

                    if(!empty($from_popularfood_settings_value) || $from_popularfood_settings_value != '')
                    {
                        $get_to_current_popularfood = Settings::where('key','popularfood_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_popularfood_id = isset($get_to_current_popularfood->value) ? $get_to_current_popularfood->value : '';

                        if(!empty($get_to_current_popularfood_id) || $get_to_current_popularfood_id != '')
                        {
                            if($get_to_current_popularfood_id != $get_from_current_popularfood_id)
                            {
                                $update_to_current_popularfood = Settings::find($get_to_current_popularfood->setting_id);
                                $update_to_current_popularfood->value = $get_from_current_popularfood_id;
                                $update_to_current_popularfood->update();
                            }
                        }
                        else
                        {
                            $new_to_current_popularfood = new Settings;
                            $new_to_current_popularfood->store_id = $current_store_id;
                            $new_to_current_popularfood->group = 'polianna';
                            $new_to_current_popularfood->key = 'popularfood_id';
                            $new_to_current_popularfood->value = $get_from_current_popularfood_id;
                            $new_to_current_popularfood->save();
                        }

                        $get_to_popularfood_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('popularfood_id',$get_from_current_popularfood_id)->first();
                        $to_popularfood_setting_id = isset($get_to_popularfood_settings->setting_id) ? $get_to_popularfood_settings->setting_id : '';

                        if(!empty($to_popularfood_setting_id) || $to_popularfood_setting_id != '')
                        {
                            $update_to_popularfood_settings = Settings::find($to_popularfood_setting_id);
                            $update_to_popularfood_settings->value = $from_popularfood_settings_value;
                            $update_to_popularfood_settings->update();
                        }
                        else
                        {
                            $new_to_popularfood_settings = new Settings;
                            $new_to_popularfood_settings->group = 'template';
                            $new_to_popularfood_settings->store_id = $current_store_id;
                            $new_to_popularfood_settings->popularfood_id = $get_from_current_popularfood_id;
                            $new_to_popularfood_settings->key = 'popularfood_settings';
                            $new_to_popularfood_settings->value = $from_popularfood_settings_value;
                            $new_to_popularfood_settings->serialized = 1;
                            $new_to_popularfood_settings->save();
                        }

                    }
                }

            }
            // End PopularFood Settings



            // BestCategories Settings
            if($value == 'bestcategory_settings')
            {
                $get_from_current_bestcategory = Settings::select('value')->where('key','bestcategory_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_bestcategory_id = isset($get_from_current_bestcategory->value) ? $get_from_current_bestcategory->value : '';

                if(!empty($get_from_current_bestcategory_id) || $get_from_current_bestcategory_id != '')
                {
                    $get_from_bestcategory_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('bestcategory_id',$get_from_current_bestcategory_id)->first();
                    $from_bestcategory_settings_value = isset($get_from_bestcategory_settings->value) ? $get_from_bestcategory_settings->value : '';

                    if(!empty($from_bestcategory_settings_value) || $from_bestcategory_settings_value != '')
                    {
                        $get_to_current_bestcategory = Settings::where('key','bestcategory_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_bestcategory_id = isset($get_to_current_bestcategory->value) ? $get_to_current_bestcategory->value : '';

                        if(!empty($get_to_current_bestcategory_id) || $get_to_current_bestcategory_id != '')
                        {
                            if($get_to_current_bestcategory_id != $get_from_current_bestcategory_id)
                            {
                                $update_to_current_bestcategory = Settings::find($get_to_current_bestcategory->setting_id);
                                $update_to_current_bestcategory->value = $get_from_current_bestcategory_id;
                                $update_to_current_bestcategory->update();
                            }
                        }
                        else
                        {
                            $new_to_current_bestcategory = new Settings;
                            $new_to_current_bestcategory->store_id = $current_store_id;
                            $new_to_current_bestcategory->group = 'polianna';
                            $new_to_current_bestcategory->key = 'bestcategory_id';
                            $new_to_current_bestcategory->value = $get_from_current_bestcategory_id;
                            $new_to_current_bestcategory->save();
                        }

                        $get_to_bestcategory_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('bestcategory_id',$get_from_current_bestcategory_id)->first();
                        $to_bestcategory_setting_id = isset($get_to_bestcategory_settings->setting_id) ? $get_to_bestcategory_settings->setting_id : '';

                        if(!empty($to_bestcategory_setting_id) || $to_bestcategory_setting_id != '')
                        {
                            $update_to_bestcategory_settings = Settings::find($to_bestcategory_setting_id);
                            $update_to_bestcategory_settings->value = $from_bestcategory_settings_value;
                            $update_to_bestcategory_settings->update();
                        }
                        else
                        {
                            $new_to_bestcategory_settings = new Settings;
                            $new_to_bestcategory_settings->group = 'template';
                            $new_to_bestcategory_settings->store_id = $current_store_id;
                            $new_to_bestcategory_settings->bestcategory_id = $get_from_current_bestcategory_id;
                            $new_to_bestcategory_settings->key = 'bestcategory_settings';
                            $new_to_bestcategory_settings->value = $from_bestcategory_settings_value;
                            $new_to_bestcategory_settings->serialized = 1;
                            $new_to_bestcategory_settings->save();
                        }

                    }
                }

            }
            // End BestCategories Settings



            // Reviews Settings
            if($value == 'review_settings')
            {
                $get_from_current_review = Settings::select('value')->where('key','review_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_review_id = isset($get_from_current_review->value) ? $get_from_current_review->value : '';

                if(!empty($get_from_current_review_id) || $get_from_current_review_id != '')
                {
                    $get_from_review_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('reviews_id',$get_from_current_review_id)->first();
                    $from_review_settings_value = isset($get_from_review_settings->value) ? $get_from_review_settings->value : '';

                    if(!empty($from_review_settings_value) || $from_review_settings_value != '')
                    {
                        $get_to_current_review = Settings::where('key','review_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_review_id = isset($get_to_current_review->value) ? $get_to_current_review->value : '';

                        if(!empty($get_to_current_review_id) || $get_to_current_review_id != '')
                        {
                            if($get_to_current_review_id != $get_from_current_review_id)
                            {
                                $update_to_current_review = Settings::find($get_to_current_review->setting_id);
                                $update_to_current_review->value = $get_from_current_review_id;
                                $update_to_current_review->update();
                            }
                        }
                        else
                        {
                            $new_to_current_review = new Settings;
                            $new_to_current_review->store_id = $current_store_id;
                            $new_to_current_review->group = 'polianna';
                            $new_to_current_review->key = 'review_id';
                            $new_to_current_review->value = $get_from_current_review_id;
                            $new_to_current_review->save();
                        }

                        $get_to_review_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('reviews_id',$get_from_current_review_id)->first();
                        $to_review_setting_id = isset($get_to_review_settings->setting_id) ? $get_to_review_settings->setting_id : '';

                        if(!empty($to_review_setting_id) || $to_review_setting_id != '')
                        {
                            $update_to_review_settings = Settings::find($to_review_setting_id);
                            $update_to_review_settings->value = $from_review_settings_value;
                            $update_to_review_settings->update();
                        }
                        else
                        {
                            $new_to_review_settings = new Settings;
                            $new_to_review_settings->group = 'template';
                            $new_to_review_settings->store_id = $current_store_id;
                            $new_to_review_settings->reviews_id = $get_from_current_review_id;
                            $new_to_review_settings->key = 'review_settings';
                            $new_to_review_settings->value = $from_review_settings_value;
                            $new_to_review_settings->serialized = 1;
                            $new_to_review_settings->save();
                        }

                    }
                }

            }
            // End Reviews Settings



            // Reservation Settings
            if($value == 'reservation_settings')
            {
                $get_from_current_reservation = Settings::select('value')->where('key','reservation_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_reservation_id = isset($get_from_current_reservation->value) ? $get_from_current_reservation->value : '';

                if(!empty($get_from_current_reservation_id) || $get_from_current_reservation_id != '')
                {
                    $get_from_reservation_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('reservation_id',$get_from_current_reservation_id)->first();
                    $from_reservation_settings_value = isset($get_from_reservation_settings->value) ? $get_from_reservation_settings->value : '';

                    if(!empty($from_reservation_settings_value) || $from_reservation_settings_value != '')
                    {
                        $get_to_current_reservation = Settings::where('key','reservation_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_reservation_id = isset($get_to_current_reservation->value) ? $get_to_current_reservation->value : '';

                        if(!empty($get_to_current_reservation_id) || $get_to_current_reservation_id != '')
                        {
                            if($get_to_current_reservation_id != $get_from_current_reservation_id)
                            {
                                $update_to_current_reservation = Settings::find($get_to_current_reservation->setting_id);
                                $update_to_current_reservation->value = $get_from_current_reservation_id;
                                $update_to_current_reservation->update();
                            }
                        }
                        else
                        {
                            $new_to_current_reservation = new Settings;
                            $new_to_current_reservation->store_id = $current_store_id;
                            $new_to_current_reservation->group = 'polianna';
                            $new_to_current_reservation->key = 'reservation_id';
                            $new_to_current_reservation->value = $get_from_current_reservation_id;
                            $new_to_current_reservation->save();
                        }

                        $get_to_reservation_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('reservation_id',$get_from_current_reservation_id)->first();
                        $to_reservation_setting_id = isset($get_to_reservation_settings->setting_id) ? $get_to_reservation_settings->setting_id : '';

                        if(!empty($to_reservation_setting_id) || $to_reservation_setting_id != '')
                        {
                            $update_to_reservation_settings = Settings::find($to_reservation_setting_id);
                            $update_to_reservation_settings->value = $from_reservation_settings_value;
                            $update_to_reservation_settings->update();
                        }
                        else
                        {
                            $new_to_reservation_settings = new Settings;
                            $new_to_reservation_settings->group = 'template';
                            $new_to_reservation_settings->store_id = $current_store_id;
                            $new_to_reservation_settings->reservation_id = $get_from_current_reservation_id;
                            $new_to_reservation_settings->key = 'reservation_settings';
                            $new_to_reservation_settings->value = $from_reservation_settings_value;
                            $new_to_reservation_settings->serialized = 1;
                            $new_to_reservation_settings->save();
                        }

                    }
                }

            }
            // End Reservation Settings



            // OpenHours Settings
            if($value == 'openhour_settings')
            {
                $get_from_current_openhour = Settings::select('value')->where('key','openhour_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_openhour_id = isset($get_from_current_openhour->value) ? $get_from_current_openhour->value : '';

                if(!empty($get_from_current_openhour_id) || $get_from_current_openhour_id != '')
                {
                    $get_from_openhour_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('openhours_id',$get_from_current_openhour_id)->first();
                    $from_openhour_settings_value = isset($get_from_openhour_settings->value) ? $get_from_openhour_settings->value : '';

                    if(!empty($from_openhour_settings_value) || $from_openhour_settings_value != '')
                    {
                        $get_to_current_openhour = Settings::where('key','openhour_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_openhour_id = isset($get_to_current_openhour->value) ? $get_to_current_openhour->value : '';

                        if(!empty($get_to_current_openhour_id) || $get_to_current_openhour_id != '')
                        {
                            if($get_to_current_openhour_id != $get_from_current_openhour_id)
                            {
                                $update_to_current_openhour = Settings::find($get_to_current_openhour->setting_id);
                                $update_to_current_openhour->value = $get_from_current_openhour_id;
                                $update_to_current_openhour->update();
                            }
                        }
                        else
                        {
                            $new_to_current_openhour = new Settings;
                            $new_to_current_openhour->store_id = $current_store_id;
                            $new_to_current_openhour->group = 'polianna';
                            $new_to_current_openhour->key = 'openhour_id';
                            $new_to_current_openhour->value = $get_from_current_openhour_id;
                            $new_to_current_openhour->save();
                        }

                        $get_to_openhour_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('openhours_id',$get_from_current_openhour_id)->first();
                        $to_openhour_setting_id = isset($get_to_openhour_settings->setting_id) ? $get_to_openhour_settings->setting_id : '';

                        if(!empty($to_openhour_setting_id) || $to_openhour_setting_id != '')
                        {
                            $update_to_openhour_settings = Settings::find($to_openhour_setting_id);
                            $update_to_openhour_settings->value = $from_openhour_settings_value;
                            $update_to_openhour_settings->update();
                        }
                        else
                        {
                            $new_to_openhour_settings = new Settings;
                            $new_to_openhour_settings->group = 'template';
                            $new_to_openhour_settings->store_id = $current_store_id;
                            $new_to_openhour_settings->openhours_id = $get_from_current_openhour_id;
                            $new_to_openhour_settings->key = 'openhour_settings';
                            $new_to_openhour_settings->value = $from_openhour_settings_value;
                            $new_to_openhour_settings->serialized = 1;
                            $new_to_openhour_settings->save();
                        }

                    }
                }

            }
            // End OpenHours Settings



            // Footer Settings
            if($value == 'footer_settings')
            {
                $get_from_current_footer = Settings::select('value')->where('key','footer_id')->where('store_id',$copy_from_store_id)->first();
                $get_from_current_footer_id = isset($get_from_current_footer->value) ? $get_from_current_footer->value : '';

                if(!empty($get_from_current_footer_id) || $get_from_current_footer_id != '')
                {
                    $get_from_footer_settings = Settings::select('value')->where('key',$value)->where('store_id',$copy_from_store_id)->where('footer_id',$get_from_current_footer_id)->first();
                    $from_footer_settings_value = isset($get_from_footer_settings->value) ? $get_from_footer_settings->value : '';

                    if(!empty($from_footer_settings_value) || $from_footer_settings_value != '')
                    {
                        $get_to_current_footer = Settings::where('key','footer_id')->where('store_id',$current_store_id)->first();
                        $get_to_current_footer_id = isset($get_to_current_footer->value) ? $get_to_current_footer->value : '';

                        if(!empty($get_to_current_footer_id) || $get_to_current_footer_id != '')
                        {
                            if($get_to_current_footer_id != $get_from_current_footer_id)
                            {
                                $update_to_current_footer = Settings::find($get_to_current_footer->setting_id);
                                $update_to_current_footer->value = $get_from_current_footer_id;
                                $update_to_current_footer->update();
                            }
                        }
                        else
                        {
                            $new_to_current_footer = new Settings;
                            $new_to_current_footer->store_id = $current_store_id;
                            $new_to_current_footer->group = 'polianna';
                            $new_to_current_footer->key = 'footer_id';
                            $new_to_current_footer->value = $get_from_current_footer_id;
                            $new_to_current_footer->save();
                        }

                        $get_to_footer_settings = Settings::where('key',$value)->where('store_id',$current_store_id)->where('footer_id',$get_from_current_footer_id)->first();
                        $to_footer_setting_id = isset($get_to_footer_settings->setting_id) ? $get_to_footer_settings->setting_id : '';

                        if(!empty($to_footer_setting_id) || $to_footer_setting_id != '')
                        {
                            $update_to_footer_settings = Settings::find($to_footer_setting_id);
                            $update_to_footer_settings->value = $from_footer_settings_value;
                            $update_to_footer_settings->update();
                        }
                        else
                        {
                            $new_to_footer_settings = new Settings;
                            $new_to_footer_settings->group = 'template';
                            $new_to_footer_settings->store_id = $current_store_id;
                            $new_to_footer_settings->footer_id = $get_from_current_footer_id;
                            $new_to_footer_settings->key = 'footer_settings';
                            $new_to_footer_settings->value = $from_footer_settings_value;
                            $new_to_footer_settings->serialized = 1;
                            $new_to_footer_settings->save();
                        }

                    }
                }

            }
            // End Footer Settings
        }

        return response()->json([
            'success' => 1,
        ]);

    }
}
