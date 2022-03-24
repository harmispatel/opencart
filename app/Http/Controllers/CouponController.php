<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\CouponProduct;
use App\Models\ProductDescription;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function index()
    {

        $data['coupons'] = Coupon::get();
        return view('admin.coupons.list',$data);
    }

    public function addcoupon()
    {
        return view('admin.coupons.add');
    }

    public function products(Request $request)
    {

        $cat = ProductDescription::select('product_id','name')->where("name", "LIKE", '%' . $request->product . '%')
            ->get();

        return response()->json($cat);
    }

    public function searchcategory(Request $request)
    {

        $pro = Category::select('category_id','name')->where("name", "LIKE", '%' . $request->category . '%')
            ->get();

        return response()->json($pro);
    }
    public function insertcoupon(Request $request)
    {

        $request->validate([
            'code' => 'required',
            'codename' => 'required',
        ]);

        date_default_timezone_set('Asia/Kolkata');
        $coupon = new Coupon;
        $coupon->store_id = isset($request->storeid) ? $request->storeid : "0" ;
        $coupon->apply_shipping = isset($request->apply) ? $request->apply : "0" ;
        $coupon->name = isset($request->codename) ? $request->codename : "" ;
        $coupon->code = isset($request->code) ? $request->code : "" ;
        $coupon->type = isset($request->type) ? $request->type : "0" ;
        $coupon->discount = isset($request->discount) ? $request->discount : "0" ;
        $coupon->logged = isset($request->clogin) ? $request->clogin : "0" ;
        $coupon->shipping = isset($request->shipping) ? $request->shipping : "0" ;
        $coupon->total = isset($request->tamount) ? $request->tamount : "0" ;
        $coupon->date_start = isset($request->sdate) ? $request->sdate : date("Y-m-d h:i:s") ;
        $coupon->date_end = isset($request->edate) ? $request->edate : date("Y-m-d h:i:s") ;
        $coupon->uses_total = isset($request->usercoupon) ? $request->usercoupon : "0" ;
        $coupon->uses_customer = isset($request->usercostomer) ? $request->usercostomer : "0" ;
        $coupon->status = isset($request->status) ? $request->status : "0" ;
        $coupon->date_added = date("Y-m-d h:i:s");
        $coupon->save();
        $couponid = $coupon->coupon_id;

        // Coupon Category
        $category = $request->catid;
        foreach ($category as $value) 
        {
            $couponcat = new CouponCategory;
            $couponcat->coupon_id = $couponid;
            $couponcat->category_id = $value;
            $couponcat->save();
        }

        // Coupon Product

        $product = $request->proid;
        foreach ($product as $value) 
        {
            $couponpro = new CouponProduct;
            $couponpro->coupon_id = $couponid;
            $couponpro->product_id = $value;
            $couponpro->save();
        }


        return redirect()->route('coupons')->with('success', "Coupon Insert Successfully.");

    }
    public function couponupdate(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // exit();
        $request->validate([
            'code' => 'required',
            'codename' => 'required',
        ]);
        $coupon = Coupon::find($request->couponid );
        $coupon->store_id = isset($request->storeid) ? $request->storeid : "0" ;
        $coupon->apply_shipping = isset($request->apply) ? $request->apply : "0" ;
        $coupon->name = isset($request->codename) ? $request->codename : "" ;
        $coupon->code = isset($request->code) ? $request->code : "" ;
        $coupon->type = isset($request->type) ? $request->type : "0" ;
        $coupon->discount = isset($request->discount) ? $request->discount : "0" ;
        $coupon->logged = isset($request->clogin) ? $request->clogin : "0" ;
        $coupon->shipping = isset($request->shipping) ? $request->shipping : "0" ;
        $coupon->total = isset($request->tamount) ? $request->tamount : "0" ;
        $coupon->date_start = isset($request->sdate) ? $request->sdate : "" ;
        $coupon->date_end = isset($request->edate) ? $request->edate : "" ;
        $coupon->uses_total = isset($request->usercoupon) ? $request->usercoupon : "0" ;
        $coupon->uses_customer = isset($request->usercostomer) ? $request->usercostomer : "0" ;
        $coupon->status = isset($request->status) ? $request->status : "0" ;
        date_default_timezone_set('Asia/Kolkata');
        $coupon->date_added = date("Y-m-d h:i:s");
        $coupon->update();
        // echo '<pre>';
        // print_r($coupon->toArray());
        // exit();

           // Coupon Category
           $category = $request->catid;
           if (!empty($category)) {
               foreach ($category as $value) 
               {
                   $couponcat = CouponCategory::find($request->couponid);
                //    $couponcat->coupon_id = $request->couponid;
                   $couponcat->category_id = $value;
                   $couponcat->update();
               }
           }
   
           // Coupon Product   
           $product = $request->proid;
           if (!empty($product)) {
               foreach ($product as $value) 
               {
                   $couponpro = CouponProduct::find($request->couponid);
                //    $couponpro->coupon_id = $request->couponid;
                   $couponpro->product_id = $value;
                   $couponpro->update();
               }
           }
        return redirect()->route('coupons')->with('success', "Coupon Update Successfully.");

    }

    public function editcoupon($id)
    {
        $data['coupon'] = Coupon::find($id);
        $data['category'] = CouponCategory::join('oc_category_description','oc_coupon_category.category_id' ,'=', 'oc_category_description.category_id')->where('coupon_id',"=", $id)->get();
        $data['products'] = CouponProduct::join('oc_product_description','oc_coupon_product.product_id' ,'=', 'oc_product_description.product_id')->where('coupon_id',"=", $id)->get();
        // $data['history'] = CouponHistory::where('coupon_id', '=', $id)->get();
        // echo '<pre>';
        // print_r($data['history']->toArray());
        // exit();
        return view('admin.coupons.edit',$data);
    }



    public function coupondelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            Coupon::whereIn('coupon_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }

}
