<?php

namespace App\Http\Controllers;

use App\Models\Loyalty;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductDescription;
use App\Models\Product_to_category;
use App\Models\ProductStore;
use App\Models\Settings;






class LoyaltyController extends Controller
{

    public function index()
    {
        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();

        $product = ProductDescription::join('oc_product_to_store', 'oc_product_description.product_id', '=', 'oc_product_to_store.product_id')->where('store_id', $current_store_id)->get();

        $result['category'] = $category;
        $result['product'] = $product;

        return view('admin.loyalty.loyalty', ['result' => $result]);
    }

    public function store(Request $request)
    {

        // return $request->all();
        $current_store_id = currentStoreId();

        $setting = new Settings();
        $setting->store_id = $current_store_id;
        $setting->group = 'loyality';
        $setting->key = 'rewardtype';
        $setting->value = $request->rewardtype;
        $setting->serialized = 0;
        $setting->save();
        // $data['rewardtype']=$request->rewardtype;

        if ($request->rewardtype == 'money') {

            $data['minimum'] = $request->money['minimum'];
            $data['collectionaward'] = $request->money['collectionaward'];
            $data['deliveryaward'] = $request->money['deliveryaward'];
            $data['pointexpiry'] = $request->money['pointexpiry'];
            $data['expiryday'] = $request->money['expiryday'];
            $data['maximumaward'] = $request->money['maximumaward'];
            $data['maximumorder'] = $request->money['maximumorder'];
            $data['category'] = $request->money['category'];
            $data['product'] = $request->money['product'];
            $data['availibleday'] = $request->money['availibleday'];
            $data['excludeminimumspend'] = $request->money['excludeminimumspend'];
            $data['excludecoupons'] = $request->money['excludecoupons'];




            $moneyserialize = serialize($data);

            $query = Settings::where('store_id', $current_store_id)->where('key', isset($request->rewardtype) ? $request->rewardtype : '')->first();

            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            if ($setting_id) {
                $social_update = Settings::find($setting_id);
                $social_update->value = $moneyserialize;
                $social_update->update();
            } else {
                $settingmoney = new Settings();
                $settingmoney->store_id = $current_store_id;
                $settingmoney->group = 'loyality';
                $settingmoney->key = isset($request->rewardtype) ? $request->rewardtype : 'rewardtype';
                $settingmoney->value = $moneyserialize;
                if ($moneyserialize) {
                    $settingmoney->serialized = 1;
                } else {
                    $settingmoney->serialized = 0;
                }
                $settingmoney->save();
            }
        } else if ($request->rewardtype == 'point') {
            $point['minimum'] = $request->point['minimum'];
            $point['rewardsevery'] = $request->point['rewardsevery'];
            $point['totalspend'] = $request->point['totalspend'];
            $point['award'] = $request->point['award'];
            $point['everypoint'] = $request->point['everypoint'];
            $point['pointexpiry'] = $request->point['pointexpiry'];
            $point['expiryday'] = $request->point['expiryday'];
            $point['category'] = $request->point['category'];
            $point['product'] = $request->point['product'];
            $point['availibleday'] = $request->point['availibleday'];
            $point['excludeminimumspend'] = $request->point['excludeminimumspend'];
            $point['excludecoupons'] = $request->point['excludecoupons'];


            $pointserialize = serialize($point);

            $query = Settings::where('store_id', $current_store_id)->where('key', isset($request->rewardtype) ? $request->rewardtype : '')->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';

            if (!empty($setting_id) || $setting_id != '') {
                $social_update = Settings::find($setting_id);
                $social_update->value = $pointserialize;
                $social_update->update();
            } else {
                $settingpoint = new Settings();
                $settingpoint->store_id = $current_store_id;
                $settingpoint->group = 'loyality';
                $settingpoint->key = isset($request->rewardtype) ? $request->rewardtype : 'rewardtype';
                $settingpoint->value = $pointserialize;
                if ($pointserialize) {
                    $settingpoint->serialized = 1;
                } else {
                    $settingpoint->serialized = 0;
                }
                $settingpoint->save();
            }
        }

        return redirect('loyalty');
    }
}
