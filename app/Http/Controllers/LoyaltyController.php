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
        $data['money']['minimum']=$request->minimum;

        echo '<pre>';
        print_r($request['money']);
        exit();
        $data['money']['collectionaward']=$request->collectionaward;
        $data['money']['deliveryaward']=$request->deliveryaward;
        $data['money']['pointexpiry']=$request->pointexpiry;
        $data['money']['expiryday']=$request->expiryday;
        $data['money']['maximumaward']=$request->maximumaward;
        $data['money']['maximumorder']=$request->maximumorder;
        $data['money']['category']=$request->category;
        $data['money']['product']=$request->product;
        $data['money']['availibleday']=$request->availibleday;
        $data['money']['excludeminimumspend']=$request->excludeminimumspend;
        $data['money']['excludecoupons']=$request->excludecoupons;

        

        foreach($data as $key=>$value){
            
            $query = Settings::where('store_id',$current_store_id)->where('key',$key)->first();
            echo '<pre>';
            print_r($query);
            exit();
            $setting_id = isset($query->setting_id) ? $query->setting_id : '';
           
            
            // $data = serialize($value);
            
            //  $settingmoney= new Settings();
            //  $settingmoney->store_id =$current_store_id;
            //  $settingmoney->group ='loyality';
            //  $settingmoney->key=isset($request->rewardtype) ? $request->rewardtype :'rewardtype' ;
            //  $settingmoney->value =isset($data) ? $data : 0;
            //  if($data){
            //     $settingmoney->serialized =1;
            //  }else{
            //     $settingmoney->serialized =0;
            //  }
            //  $settingmoney->save();
        }

        // foreach($request['point'] as $key=>$value){
        //     $dataserialize = serialize($value);
            
        //      $settingpoint= new Settings();
        //      $settingpoint->store_id =$current_store_id;
        //      $settingpoint->group ='loyality';
        //      $settingpoint->key=isset($request->rewardtype) ? $request->rewardtype :'rewardtype' ;
        //      $settingpoint->value =isset($dataserialize) ? $dataserialize : 0;
        //      if($dataserialize){
        //         $settingpoint->serialized =1;
        //      }else{
        //         $settingpoint->serialized =0;
        //      }
        //      $settingpoint->save();
        // }

    }

}
