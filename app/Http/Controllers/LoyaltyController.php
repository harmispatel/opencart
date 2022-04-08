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
    
          $product =ProductDescription::join('oc_product_to_store','oc_product_description.product_id','=','oc_product_to_store.product_id')->where('store_id',$current_store_id)->get();

        $result['category'] = $category;
        $result['product'] = $product;

        return view('admin.loyalty.loyalty',['result' => $result]);
    }

    public function store(Request $request){

            // return $request->all();
        $current_store_id = currentStoreId();
        
        // $data['rewardtype']=$request->rewardtype;
        
        $data['minimum']=$request->money['minimum'];
        $data['collectionaward']=$request->money['collectionaward'];
        
        $data['deliveryaward']=$request->money['deliveryaward'];
        $data['pointexpiry']=$request->money['pointexpiry'];
        $data['expiryday']=$request->money['expiryday'];
        $data['maximumaward']=$request->money['maximumaward'];
        $data['maximumorder']=$request->money['maximumorder'];
        $data['category']=$request->money['category'];
        $data['product']=$request->money['product'];
        $data['availibleday']=$request->money['availibleday'];
        $data['excludeminimumspend']=$request->money['excludeminimumspend'];
        $data['excludecoupons']=$request->money['excludecoupons'];
        

        
        
         
            
            
            $moneyserialize= serialize($data);
             
            $query = Settings::where('store_id', $current_store_id)->where('key', $request->rewardtype)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            
             
            if ($setting_id) {
               
                $social_update = Settings::find($setting_id);
                $social_update->value = $moneyserialize;
                $social_update->update();
            }else{
             $settingmoney = new Settings();
             $settingmoney->store_id =$current_store_id;
             $settingmoney->group ='loyality';
             $settingmoney->key=isset($request->rewardtype) ? $request->rewardtype :'rewardtype' ;
             $settingmoney->value = $moneyserialize ;
             if($moneyserialize){
                $settingmoney->serialized =1;
             }else{
                $settingmoney->serialized =0;
             }
             
             $settingmoney->save();
            }
           
       

        $point['minimum']=$request->minimum;
        $point['rewardsevery']=$request->rewardsevery;
        $point['totalspend']=$request->totalspend;
        $point['award']=$request->award;
        $point['everypoint']=$request->everypoint;
        $point['pointexpiry']=$request->pointexpiry;
        $point['expiryday']=$request->expiryday;
        $point['category']=$request->category;
        $point['product']=$request->product;
        $point['availibleday']=$request->availibleday;
        $point['excludeminimumspend']=$request->excludeminimumspend;
        $point['excludecoupons']=$request->excludecoupons;


        
            $pointserialize= serialize($point);
           
            $query = Settings::where('store_id', $current_store_id)->where('key',$request->rewardtype)->first();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
            
            
            if (!empty($setting_id) || $setting_id != '') {
                $social_update = Settings::find($setting_id);
                $social_update->value = $pointserialize;
                $social_update->update();
            }else{
            
             $settingpoint= new Settings();
             $settingpoint->store_id =$current_store_id;
             $settingpoint->group ='loyality';
             $settingpoint->key=isset($request->rewardtype) ? $request->rewardtype :'rewardtype' ;
             $settingpoint->value =$pointserialize;
             if($pointserialize){
                $settingpoint->serialized =1;
             }else{
                $settingpoint->serialized =0;
             }
             $settingpoint->save();
            }
           return redirect('loyalty');
        // }
    }

}
