<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\CouponCategory;
use App\Models\CouponHistory;
use App\Models\CouponProduct;
use App\Models\ProductDescription;
use Illuminate\Http\Request;
use DataTables;

class CouponController extends Controller
{

    public function index()
    {

        $data['coupons'] = Coupon::get();
        return view('admin.coupons.list', $data);
    }

    public function addcoupon()
    {
        return view('admin.coupons.add');
    }

    public function products(Request $request)
    {

        $cat = ProductDescription::select('product_id', 'name')->where("name", "LIKE", '%' . $request->product . '%')
            ->get();

        return response()->json($cat);
    }

    public function searchcategory(Request $request)
    {

        $pro = Category::select('category_id', 'name')->where("name", "LIKE", '%' . $request->category . '%')
            ->get();

        return response()->json($pro);
    }

    public function insertcoupon(Request $request)
    {

        $request->validate([
            'code' => 'required|max:10',
            'coupon_name' => 'required',
        ]);

        date_default_timezone_set('Asia/Kolkata');
        $coupon = new Coupon;
        $coupon->store_id = isset($request->storeid) ? $request->storeid : "0";
        $coupon->apply_shipping = isset($request->apply) ? $request->apply : "0";
        $coupon->name = $request->coupon_name;
        $coupon->code = $request->code;
        $coupon->type = isset($request->type) ? $request->type : "0";
        $coupon->discount = isset($request->discount) ? $request->discount : "0";
        $coupon->logged = isset($request->clogin) ? $request->clogin : "0";
        $coupon->shipping = isset($request->shipping) ? $request->shipping : "0";
        $coupon->total = isset($request->tamount) ? $request->tamount : "0";
        $coupon->date_start = isset($request->sdate) ? $request->sdate : date("Y-m-d h:i:s");
        $coupon->date_end = isset($request->edate) ? $request->edate : date("Y-m-d h:i:s");
        $coupon->uses_total = isset($request->usercoupon) ? $request->usercoupon : "0";
        $coupon->uses_customer = isset($request->usercostomer) ? $request->usercostomer : "0";
        $coupon->status = isset($request->status) ? $request->status : "0";
        $coupon->on_off = isset($request->on_off) ? $request->on_off : "0";
        $coupon->date_added = date("Y-m-d h:i:s");
        $coupon->save();
        $couponid = $coupon->coupon_id;

        // Coupon Category
        $category = $request->catid;
        if (!empty($category)) {
            foreach ($category as $value) {
                $couponcat = new CouponCategory;
                $couponcat->coupon_id = $couponid;
                $couponcat->category_id = $value;
                $couponcat->save();
            }
        }

        // Coupon Product

        $product = $request->proid;
        if (!empty($product)) {
            foreach ($product as $value) {
                $couponpro = new CouponProduct;
                $couponpro->coupon_id = $couponid;
                $couponpro->product_id = $value;
                $couponpro->save();
            }
        }
        return redirect()->route('coupons')->with('success', "Coupon Insert Successfully.");
    }


    public function couponupdate(Request $request)
    {
            $request->validate([
            'code' => 'required|max:10',
            'coupon_name' => 'required',
        ]);
        $coupon = Coupon::find($request->couponid);
        $coupon->store_id = isset($request->storeid) ? $request->storeid : "0";
        $coupon->apply_shipping = isset($request->apply) ? $request->apply : "0";
        $coupon->name = $request->coupon_name;
        $coupon->code = $request->code;
        $coupon->type = isset($request->type) ? $request->type : "0";
        $coupon->discount = isset($request->discount) ? $request->discount : "0";
        $coupon->logged = isset($request->clogin) ? $request->clogin : "0";
        $coupon->shipping = isset($request->shipping) ? $request->shipping : "0";
        $coupon->total = isset($request->tamount) ? $request->tamount : "0";
        $coupon->date_start = isset($request->sdate) ? $request->sdate : "";
        $coupon->date_end = isset($request->edate) ? $request->edate : "";
        $coupon->uses_total = isset($request->usercoupon) ? $request->usercoupon : "0";
        $coupon->uses_customer = isset($request->usercostomer) ? $request->usercostomer : "0";
        $coupon->status = isset($request->status) ? $request->status : "0";
        $coupon->on_off = isset($request->on_off) ? $request->on_off : "0";
        date_default_timezone_set('Asia/Kolkata');
        $coupon->date_added = date("Y-m-d h:i:s");
        // echo '<pre>';
        // print_r($coupon->toArray());
        // exit();
        $coupon->update();



        // Coupon add Category
        $categoryadd = $request->catid;
        $couponid = $request->couponid;
        CouponCategory::where('coupon_id', $couponid)->delete();
        if (!empty($categoryadd)) {
            foreach ($categoryadd as $value) {
                $couponcat = new CouponCategory;
                $couponcat->coupon_id = $request->couponid;
                $couponcat->category_id = $value;
                $couponcat->save();
            }
        }


        // Coupon add Product
        $productadd = $request->proid;
        CouponProduct::where('coupon_id', $couponid)->delete();
        if (!empty($productadd)) {
            foreach ($productadd as $value) {
                $couponpro = new CouponProduct;
                $couponpro->coupon_id = $request->couponid;
                $couponpro->product_id = $value;
                $couponpro->save();
            }
        }
        return redirect()->route('coupons')->with('success', "Coupon Update Successfully.");
    }

    public function editcoupon($id)
    {
        $data['coupon'] = Coupon::find($id);
        $data['category'] = CouponCategory::join('oc_category_description', 'oc_coupon_category.category_id', '=', 'oc_category_description.category_id')->where('coupon_id', "=", $id)->get();
        $data['products'] = CouponProduct::join('oc_product_description', 'oc_coupon_product.product_id', '=', 'oc_product_description.product_id')->where('coupon_id', "=", $id)->get();
        // $data['history'] = CouponHistory::where('coupon_id', '=', $id)->get();

        return view('admin.coupons.edit', $data);
    }



    public function coupondelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            Coupon::where('coupon_id', $ids)->delete();
            CouponCategory::where('coupon_id', $ids)->delete();;
            CouponProduct::where('coupon_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }


    public function getallcouponhistory(Request $request)
    {
    



        if ($request->ajax()) {
            $couponid = $request->couponid;
            $data = CouponHistory::select('oc_coupon_history.*','oc_order.firstname','oc_order.lastname')->join('oc_order','oc_coupon_history.order_id','=','oc_order.order_id')->where('coupon_id', $couponid)->get();
            // $data = CouponHistory::where('coupon_id', $couponid)->get();
            // echo '<pre>';
            // print_r($data);
            // exit();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('date_added', function ($row) {
                    $date_added = date('d-m-Y', strtotime($row->date_added));
                    return $date_added;
                })
                ->addColumn('customer_name', function($row){
                    $cname = $row->firstname.' '.$row->lastname;
                    
                    return $cname;
                })
                ->rawColumns(['date_added'])
                ->make(true);
        }

        // return view('users');
    }
}
