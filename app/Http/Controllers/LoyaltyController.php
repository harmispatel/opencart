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

    // Function of Loyality List
    public function index()
    {
        // Check User Permission
        if (check_user_role(62) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();

        $product = ProductDescription::join('oc_product_to_store', 'oc_product_description.product_id', '=', 'oc_product_to_store.product_id')->where('store_id', $current_store_id)->get();

        $result['category'] = $category;
        $result['product'] = $product;

        return view('admin.loyalty.loyalty', ['result' => $result]);
    }



    // Function of Loyality Insert
    public function store(Request $request)
    {

        // return $request->rewardtype;
        $current_store_id = currentStoreId();
        $rewardtype=isset($request->rewardtype) ? $request->rewardtype : '';
         if(!empty($rewardtype) || $rewardtype != ''){

             $setting = new Settings();
             $setting->store_id = $current_store_id;
             $setting->group = 'loyality';
             $setting->key = 'rewardtype';
             $setting->value = $request->rewardtype;
             $setting->serialized = 0;
             $setting->save();
         }

        if($rewardtype == 'money'){
            $query = Settings::where('store_id', $current_store_id)->where('key',$rewardtype)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            $data['minimum'] =isset($request->money['minimum']) ? $request->money['minimum'] : '';
            $data['collectionaward'] = isset($request->money['collectionaward']) ? $request->money['collectionaward'] : '';
            $data['deliveryaward'] =isset($request->money['deliveryaward']) ? $request->money['deliveryaward'] : '';
            $data['pointexpiry'] = isset($request->money['pointexpiry']) ? $request->money['pointexpiry'] : '';
            $data['expiryday'] = isset($request->money['expiryday']) ? $request->money['expiryday'] : '';
            $data['maximumaward'] = isset($request->money['maximumaward']) ? $request->money['maximumaward'] : '';
            $data['maximumorder'] = isset($request->money['maximumorder']) ? $request->money['maximumorder'] : '';
            $data['category'] = isset($request->money['category']) ? $request->money['category'] : '';
            $data['product'] = isset($request->money['product']) ? $request->money['product'] : '';
            $data['availibleday'] = isset($request->money['availibleday']) ? $request->money['availibleday'] : '';
            $data['excludeminimumspend'] = isset($request->money['excludeminimumspend']) ? $request->money['excludeminimumspend'] : '';
            $data['excludecoupons'] =isset($request->money['excludecoupons']) ? $request->money['excludecoupons'] : '';

            $moneyserialize = serialize($data);

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
           }
           else if($rewardtype == 'point')
           {
            $query1= Settings::where('store_id', $current_store_id)->where('key',$rewardtype)->first();
            $setting_id1 = isset($query1->setting_id) ? $query1->setting_id : '';
            $point['minimum'] =isset($request->point['minimum']) ? $request->point['minimum'] : '';
            $point['rewardsevery'] = isset($request->point['rewardsevery']) ? $request->point['rewardsevery'] : '';
            $point['totalspend'] =isset($request->point['totalspend']) ? $request->point['totalspend'] : '';
            $point['award'] = isset($request->point['award']) ? $request->point['award'] : '';
            $point['everypoint'] =isset($request->point['everypoint']) ? $request->point['everypoint'] : '';
            $point['pointexpiry'] = isset($request->point['pointexpiry']) ? $request->point['pointexpiry'] : '';
            $point['expiryday'] =isset($request->point['expiryday']) ? $request->point['expiryday'] : '';
            $point['category'] =isset($request->point['category']) ? $request->point['category'] : '';
            $point['product'] = isset($request->point['product']) ? $request->point['product'] : '';
            $point['availibleday'] =isset($request->point['availibleday']) ? $request->point['availibleday'] : '';
            $point['excludeminimumspend'] =isset($request->point['excludeminimumspend']) ? $request->point['excludeminimumspend'] : '';
            $point['excludecoupons'] =isset($request->point['excludecoupons']) ? $request->point['excludecoupons'] : '';


            $pointserialize = serialize($point);

            if (!empty($setting_id) || $setting_id1 != '') {
                $social_update = Settings::find($setting_id1);
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
