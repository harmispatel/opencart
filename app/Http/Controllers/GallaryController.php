<?php

namespace App\Http\Controllers;

use App\Models\Gallary;
use Illuminate\Http\Request;
use App\Models\Settings;


class GallaryController extends Controller
{

    public function gallarysettings()
    {
        // Check User Permission
        if (check_user_role(68) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.gallary.gallarysettings');
    }

    public function gallarysettingsstore(Request $request){

        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $data['enable_gallery_module'] = $request->enable_gallery_module;
        $data['enable_home_gallery'] = $request->enable_home_gallery;
        $data['gallery_background_options'] = $request->gallery_background_options;
        $data['gallery_header_text'] = $request->gallery_header_text;
        $data['gallery_header_desc'] = $request->gallery_header_desc;
        $data['gallery_background_color'] = $request->gallery_background_color;
        $data['gallery_background_image'] = $request->gallery_background_image;
        foreach ($data as $key => $new)
        {
            if($user_group_id == 1)
            {
                $query = Settings::where('store_id', $current_store_id)->where('key', $key)->first();

                $setting_id = isset($query->setting_id) ? $query->setting_id : '';

                if (!empty($setting_id) || $setting_id != '') {
                    $gallery_update = Settings::find($setting_id);
                    $gallery_update->value = $new;
                    $gallery_update->update();
                }
                else
                {
                    $gallery_add = new Settings;
                    $gallery_add->store_id = $current_store_id;
                    $gallery_add->group = 'gallery';
                    $gallery_add->key = $key;
                    $gallery_add->value = isset($new) ? $new : '';
                    $gallery_add->serialized = 0;
                    $gallery_add->save();
                }
            }
            else
            {
                $query = Settings::where('store_id', $user_shop_id)->where('key', $key)->first();

                $setting_id = isset($query->setting_id) ? $query->setting_id : '';

                if (!empty($setting_id) || $setting_id != '') {
                    $gallery_update = Settings::find($setting_id);
                    $gallery_update->value = $new;
                    $gallery_update->update();
                }
                else
                {
                    $gallery_add = new Settings;
                    $gallery_add->store_id = $user_shop_id;
                    $gallery_add->group = 'gallery';
                    $gallery_add->key = $key;
                    $gallery_add->value = isset($new) ? $new : '';
                    $gallery_add->serialized = 0;
                    $gallery_add->save();
                }
            }
        }

        return redirect()->route('gallarysettings')->with('success', 'Settings Updated..');



    }

    public function uploadgallary()
    {
        return view('vendor.laravel-filemanager.index');
    }

    public function store(Request $request)
    {
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        $images = isset($request->image) ? $request->image : '';

        if($images != '' || !empty($images))
        {
            if($user_group_id == 1)
            {
                Gallary::where('store_id',$current_store_id)->delete();

                foreach($images as $key => $image)
                {
                        $img = isset($image['img']) ? $image['img'] : '';
                        $desc = isset($image['desc']) ? $image['desc'] : '';

                        $gallery = new Gallary;
                        $gallery->store_id = $current_store_id;
                        $gallery->image = $img;
                        $gallery->description = $desc;
                        $gallery->status = 1;
                        $gallery->save();
                }
            }
            else
            {
                Gallary::where('store_id',$user_shop_id)->delete();

                foreach($images as $key => $image)
                {
                        $img = isset($image['img']) ? $image['img'] : '';
                        $desc = isset($image['desc']) ? $image['desc'] : '';

                        $gallery = new Gallary;
                        $gallery->store_id = $user_shop_id;
                        $gallery->image = $img;
                        $gallery->description = $desc;
                        $gallery->status = 1;
                        $gallery->save();
                }
            }
        }

       return redirect('uploadgallary');

    }




}
