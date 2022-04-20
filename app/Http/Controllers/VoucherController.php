<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherHistory;
use App\Models\VoucherThemeDescription;
use App\Models\Voucherthemes;
use App\Models\VoucherThemenames;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    // Function of Get All Gift Vouchers by Current Store
    public function voucherlist()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Gift Vouchers
        $data['vouchers'] = Voucher::where('store_id',$current_store_id)->join('oc_voucher_theme_description','oc_voucher.voucher_theme_id', 'oc_voucher_theme_description.voucher_theme_id')->get();

        return view('admin.vouchers.voucherlist', $data);
    }





    // Function of Add New Gift Voucher View
    public function giftvoucher()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Get Voucher Themes
        $data['themes'] = VoucherThemeDescription::get();

        return view('admin.vouchers.giftvoucher', $data);
    }





    // Function of Get All Voucher Themes
    public function vouchertheme()
    {
        $data = VoucherThemenames::all();
        return view('admin.vouchers.voucherthemelist',['data'=>$data]);
    }





    // Function of Gift Voucher Edit View
    public function voucheredit($id)
    {
        $data['vouchers'] = Voucher::where('voucher_id',"=",$id)->first();

        if(empty($data['vouchers']))
        {
            return redirect()->route('voucherlist');
        }

        // Voucher Themes
        $data['themes'] = VoucherThemeDescription::get();

        // Vouchers History
        $data['history'] = VoucherHistory::where('voucher_id','=',$id)->get();

        return view('admin.vouchers.voucheredit',$data);
    }





    //Function of Update Gift Vouchers
    public function voucherupdate(Request $request)
    {
        // Validation
        $request->validate([
            'code' => 'required|max:10',
            'apply' => 'required',
            'formname' => 'required',
            'email' => 'required',
            'name' => 'required',
            'toemail' => 'required',
            'theme' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        $voucher = Voucher::find($request->voucherid);
        $voucher->order_id = isset($request->orderid) ? $request->orderid : "0";
        $voucher->code = $request->code;
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





    // Function of Delete Gift Voucher
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





    // Function of Store Gift Vouchers
    public function voucherinsert(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Validation
        $request->validate([
            'code' => 'required|max:10',
            'apply' => 'required',
            'formname' => 'required',
            'email' => 'required',
            'name' => 'required',
            'toemail' => 'required',
            'theme' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        // Sore New Gift Voucher
        $voucher = new Voucher;
        $voucher->store_id = $current_store_id;
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





    // Function of Insert new Voucher Theme
    public function voucherthemeinsert(Request $request)
    {
        return view('admin.vouchers.addvouchertheme');
    }





    // Function of Store New Voucher Theme
    public function voucherthemestore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = $request->image->getClientOriginalName();
        $request->image->move(public_path('admin/voucherthemes'),$imageName);

        $vouchertheme = new Voucherthemes;
        $vouchertheme->image = $imageName;
        $vouchertheme->save();

        $Voucherthemename = new VoucherThemenames;
        $Voucherthemename->voucher_theme_id =$vouchertheme->voucher_theme_id;
        $Voucherthemename->name = $request->name;
        $Voucherthemename->language_id = '1';
        $Voucherthemename->save();

        return redirect()->route('vouchertheme')->with("success", "Voucher Theme has been Inserted Successfully..");
    }





    // Function of Voucher Themes View
    public function voucherthemeshow()
    {
        // Vouchers Themes
        $data = VoucherThemenames::get();
        return view('admin.vouchers.voucherthemelist',['data'=>$data]);
    }





    // Function of Edit Voucher Themes View
    public function voucherthemeedit($id)
    {
        $voucherthemenameedit = VoucherThemenames::find($id);

        if(empty($voucherthemenameedit))
        {
            return redirect()->route('vouchertheme');
        }

        $vouchertheme = Voucherthemes::find($id);

        return view('admin.vouchers.voucherthemeedit',['voucherthemenameedit'=>$voucherthemenameedit,'vouchertheme'=>$vouchertheme]);

    }





    // Function of Update Voucher Theme
    public function voucherthemeupdate(Request $request)
    {

        $vouchertheme_id = $request->id;

        // Validation
        $request->validate([
            'name' => 'required',
        ]);

        $vouchertheme = Voucherthemes::find($vouchertheme_id);

        if ($request->hasFile('image'))
        {
            $image = isset($vouchertheme['image']) ? $vouchertheme['image'] : '';

            if(!empty($image) || $image != '')
            {
                if(file_exists(public_path('admin/voucherthemes/').$image))
                {
                    unlink(public_path('admin/voucherthemes/').$image);
                }
            }
            $imgname = time().".". $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(public_path('admin/voucherthemes/'),$imgname);
            $vouchertheme->image = $imgname;
        }

        $vouchertheme->update();

        $Voucherthemename = VoucherThemenames::find($vouchertheme_id);
        $Voucherthemename->voucher_theme_id =$vouchertheme->voucher_theme_id;
        $Voucherthemename->name = $request->name;
        $Voucherthemename->update();

        return redirect()->route('voucherthemelist')->with('success','Voucher Theme has been updated Successfully');

    }





    // Function of Delete Voucher Theme
    public function voucherthemedelete(Request $request)
    {
        $ids = $request['id'];

        if (count($ids) > 0)
        {
            foreach($ids as $id)
            {
                $vouchertheme = Voucherthemes::where('voucher_theme_id',$id)->first();

                $image = $vouchertheme->image;

                if(!empty($image) || $image != '')
                {
                    if(file_exists('public/admin/voucherthemes/'.$image))
                    {
                        unlink('public/admin/voucherthemes/'.$image);
                    }
                }

            }

            Voucherthemes::whereIn('voucher_theme_id', $ids)->delete();

            VoucherThemenames::whereIn('voucher_theme_id', $ids)->delete();


            return response()->json([
                'success' => 1,
            ]);
        }
    }


}
