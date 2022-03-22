<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
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

    public function insertcoupon(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'codename' => 'required',
        ]);

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
        $coupon->date_start = isset($request->sdate) ? $request->sdate : "" ;
        $coupon->date_end = isset($request->edate) ? $request->edate : "" ;
        $coupon->uses_total = isset($request->usercoupon) ? $request->usercoupon : "0" ;
        $coupon->uses_customer = isset($request->usercostomer) ? $request->usercostomer : "0" ;
        $coupon->status = isset($request->status) ? $request->status : "0" ;
        date_default_timezone_set('Asia/Kolkata');
        $coupon->date_added = date("Y-m-d h:i:s");
        $coupon->save();
        return redirect()->route('coupons')->with('success', "Coupon Insert Successfully.");

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
