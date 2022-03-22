<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherHistory;
use App\Models\VoucherThemeDescription;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function voucherlist()
    {
        $data['vouchers'] = Voucher::join('oc_voucher_theme_description','oc_voucher.voucher_theme_id', 'oc_voucher_theme_description.voucher_theme_id')->get();
        return view('admin.vouchers.voucherlist', $data);
    }
    public function giftvoucher()
    {
        $data['themes'] = VoucherThemeDescription::get();
        return view('admin.vouchers.giftvoucher', $data);
    }


    public function vouchertheme()
    {
        return view('admin.vouchers.vouchertheme');
    }
    public function voucheredit($id)
    {
        $data['vouchers']= Voucher::where('voucher_id',"=",$id)->first();
        $data['themes'] = VoucherThemeDescription::get();
        $data['history'] = VoucherHistory::where('voucher_id','=',$id);

        return view('admin.vouchers.voucheredit',$data);
    }

    public function voucherupdate(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'apply' => 'required',
            'formname' => 'required',
            'email' => 'required',
            'name' => 'required',
            'toemail' => 'required',
            'theme' => 'required',
            'message' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);
        $voucher = Voucher::find($request->voucherid);
        $voucher->store_id = isset($request->storeid) ? $request->storeid : "0";
        $voucher->on_off = isset($request->onoff) ? $request->onoff : "0";
        $voucher->order_id = isset($request->orderid) ? $request->orderid : "0";
        $voucher->code = $request->code;;
        $voucher->apply_shipping = $request->apply;
        $voucher->from_name = $request->formname;
        $voucher->from_email = $request->email;
        $voucher->to_name = $request->name;
        $voucher->to_email = $request->toemail;
        $voucher->voucher_theme_id = $request->theme;
        $voucher->message = $request->message;
        $voucher->amount = $request->amount;
        $voucher->status = $request->status;
        date_default_timezone_set('Asia/Kolkata');
        $voucher->date_added = date("Y-m-d h:i:s");
        $voucher->update();
        return redirect()->route('voucherlist')->with('success', "Voucher Update Successfully.");
    }
    public function voucherdelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            Voucher::whereIn('voucher_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }


    public function voucherinsert(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'apply' => 'required',
            'formname' => 'required',
            'email' => 'required',
            'name' => 'required',
            'toemail' => 'required',
            'theme' => 'required',
            'message' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        $voucher = new Voucher;
        $voucher->store_id = isset($request->storeid) ? $request->storeid : "0";
        $voucher->on_off = isset($request->onoff) ? $request->onoff : "0";
        $voucher->order_id = isset($request->orderid) ? $request->orderid : "0";
        $voucher->code = $request->code;;
        $voucher->apply_shipping = $request->apply;
        $voucher->from_name = $request->formname;
        $voucher->from_email = $request->email;
        $voucher->to_name = $request->name;
        $voucher->to_email = $request->toemail;
        $voucher->voucher_theme_id = $request->theme;
        $voucher->message = $request->message;
        $voucher->amount = $request->amount;
        $voucher->status = $request->status;
        date_default_timezone_set('Asia/Kolkata');
        $voucher->date_added = date("Y-m-d h:i:s");;
        $voucher->save();

        return redirect()->route('voucherlist');
    }
}
