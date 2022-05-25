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

    //Function of Get Coupons By Current Store
    public function  index()
    {
        // Check User Permission
        if (check_user_role(63) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Current Store ID
        $current_store_id = currentStoreId();

        if ($user_group_id == 1) {
            if ($user_group_id == 0) {

                $data['coupons'] = Coupon::get();
            } else {

                $data['coupons'] = Coupon::where('store_id', $current_store_id)->get();
            }
        } else {
            $data['coupons'] = Coupon::where('store_id', $user_shop_id)->get();
        }

        return view('admin.coupons.list', $data);
    }


    //Function of Add New Coupon View
    public function addcoupon()
    {
        // Check User Permission
        if (check_user_role(64) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.coupons.add');
    }

    // Function of Search Products
    public function products(Request $request)
    {
        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Current Store ID
        $current_store_id = currentStoreId();

        if ($user_group_id == 1) {
            $cat = ProductDescription::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore', function ($q) use ($current_store_id) {
                $q->where('store_id', $current_store_id);
            })->where("name", "LIKE", '%' . $request->product . '%')->get();
        } else {
            $cat = ProductDescription::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore', function ($q) use ($user_shop_id) {
                $q->where('store_id', $user_shop_id);
            })->where("name", "LIKE", '%' . $request->product . '%')->get();
        }

        return response()->json($cat);
    }

    // Function of Search Category
    public function searchcategory(Request $request)
    {
        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Current Store ID
        $current_store_id = currentStoreId();

        if ($user_group_id == 1) {
            $pro = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($q) use ($current_store_id) {
                $q->where('store_id', $current_store_id);
            })->where("name", "LIKE", '%' . $request->category . '%')->get();
        } else {
            $pro = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($q) use ($user_shop_id) {
                $q->where('store_id', $user_shop_id);
            })->where("name", "LIKE", '%' . $request->category . '%')->get();
        }

        return response()->json($pro);
    }


    // Function of Update Coupon Code Status
    public function updonoff(Request $request)
    {
        $couponid = $request->dataid;
        $onoff = Coupon::find($couponid);
        $onoff->on_off = $request->onoff;
        $onoff->update();
        return response()->json([
            "success" => "update status"
        ]);
    }

    // Function of Store New Coupon
    public function insertcoupon(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Validation
        $request->validate([
            'code' => 'required|max:10',
            'coupon_name' => 'required',
        ]);

        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Insert New Coupon
        $coupon = new Coupon;
        if ($user_group_id == 1) {
            $coupon->store_id = $current_store_id;
        } else {
            $coupon->store_id = $user_shop_id;
        }
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

        // Store Coupon Category
        $category = $request->catid;
        if (!empty($category)) {
            foreach ($category as $value) {
                $couponcat = new CouponCategory;
                $couponcat->coupon_id = $couponid;
                $couponcat->category_id = $value;
                $couponcat->save();
            }
        }

        // Store Coupon Product
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

    // Function of Update Coupon
    public function couponupdate(Request $request)
    {
        // Validation
        $request->validate([
            'code' => 'required|max:10',
            'coupon_name' => 'required',
        ]);

        // Update Coupon
        $coupon = Coupon::find($request->couponid);
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

        $coupon->date_added = date("Y-m-d h:i:s");
        $coupon->update();

        // Update & Delete Coupon Category
        $categoryadd = $request->catid;
        $couponid = $request->couponid;

        // Delete Old Coupon Category
        CouponCategory::where('coupon_id', $couponid)->delete();

        // New Coupon Category
        if (!empty($categoryadd)) {
            foreach ($categoryadd as $value) {
                $couponcat = new CouponCategory;
                $couponcat->coupon_id = $request->couponid;
                $couponcat->category_id = $value;
                $couponcat->save();
            }
        }

        $productadd = $request->proid;

        // Delete Old Coupon Product
        CouponProduct::where('coupon_id', $couponid)->delete();

        // New Coupon Product
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

    // Function of Edit Coupon
    public function editcoupon($id)
    {
        // Check User Permission
        if (check_user_role(15) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $data['coupon'] = Coupon::find($id);

        if (empty($data['coupon'])) {
            return redirect()->route('coupons');
        }

        $data['category'] = CouponCategory::join('oc_category_description', 'oc_coupon_category.category_id', '=', 'oc_category_description.category_id')->where('coupon_id', "=", $id)->get();
        $data['products'] = CouponProduct::join('oc_product_description', 'oc_coupon_product.product_id', '=', 'oc_product_description.product_id')->where('coupon_id', "=", $id)->get();

        return view('admin.coupons.edit', $data);
    }





    // Delete Coupon
    public function coupondelete(Request $request)
    {
        // Check User Permission
        if (check_user_role(66) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $ids = $request['id'];
        if (count($ids) > 0) {
            // Delete Coupon
            Coupon::whereIn('coupon_id', $ids)->delete();

            // Delete Coupon Category
            CouponCategory::whereIn('coupon_id', $ids)->delete();

            // Delete Coupon Product
            CouponProduct::whereIn('coupon_id', $ids)->delete();

            // Delete Coupon History
            CouponHistory::whereIn('coupon_id', $ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }

    // Get All Coupons History
    public function getallcouponhistory(Request $request)
    {
        if ($request->ajax()) {
            $couponid = $request->couponid;
            $data = CouponHistory::select('oc_coupon_history.*', 'oc_order.firstname', 'oc_order.lastname')->join('oc_order', 'oc_coupon_history.order_id', '=', 'oc_order.order_id')->where('coupon_id', $couponid)->get();

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('date_added', function ($row) {
                    $date_added = date('d-m-Y', strtotime($row->date_added));
                    return $date_added;
                })
                ->addColumn('customer_name', function ($row) {
                    $cname = $row->firstname . ' ' . $row->lastname;

                    return $cname;
                })
                ->rawColumns(['date_added'])
                ->make(true);
        }
    }
}
