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

    public function voucherlist()
    {
        $current_store_id = currentStoreId();
        $data['vouchers'] = Voucher::where('store_id',$current_store_id)->join('oc_voucher_theme_description','oc_voucher.voucher_theme_id', 'oc_voucher_theme_description.voucher_theme_id')->get();
        return view('admin.vouchers.voucherlist', $data);
    }
    public function giftvoucher()
    {
        $data['themes'] = VoucherThemeDescription::get();
        return view('admin.vouchers.giftvoucher', $data);
    }


    public function vouchertheme()
    {
        $data = VoucherThemenames::all();
        return view('admin.vouchers.voucherthemelist',['data'=>$data]);
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
            'code' => 'required|max:10',
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
            'code' => 'required|max:10',
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
     
    public function voucherthemeinsert(Request $request)
    {
        return view('admin.vouchers.addvouchertheme');
    }
    public function voucherthemestore(Request $request)
    {
            $request->validate([
                'name' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

           
            $imageName = $request->image->getClientOriginalName(); 
            $request->image->move(public_path('images'), $imageName);
            
            $vouchertheme = new Voucherthemes;
            $vouchertheme->image = $imageName;
            $vouchertheme->save();

            $Voucherthemename = new VoucherThemenames;
            $Voucherthemename->voucher_theme_id =$vouchertheme->voucher_theme_id;
            $Voucherthemename->name = $request->name;
            $Voucherthemename->language_id = '1';
            $Voucherthemename->save();

            return redirect()->route('voucherthemelist')->with("Success, Voucher thene insert success");
            // return view('admin.vouchers.voucherthemelist');

           

        
    }
    public function voucherthemeshow()
    {
        $data = VoucherThemenames::get();
        return view('admin.vouchers.voucherthemelist',['data'=>$data]);
        
    }
    
    public function voucherthemeedit(Request $request,$id)
    {
        $voucherthemenameedit = VoucherThemenames::find($id);
        $vouchertheme = Voucherthemes::find($id);

        

        return view('admin.vouchers.voucherthemeedit',['voucherthemenameedit'=>$voucherthemenameedit,'vouchertheme'=>$vouchertheme]);

    }
    public function voucherthemeupdate(Request $request,$id)
    {
           
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       
        // $imageName = $request->image->getClientOriginalName(); 
        // $request->image->move(public_path('images'), $imageName);
        $vouchertheme = Voucherthemes::find($id);
    
       
        if ($request->hasFile('image'))
        {
            $image = isset($vouchertheme['image']) ? $vouchertheme['image'] : '';
            // echo '<pre>';
            // print_r($image);
            // exit();
            if(!empty($image) || $image != '')
            {
                if(file_exists(public_path('admin/offers/').$image))
                {
                    unlink(public_path('admin/offers/').$image);
                }
            }

            $imgname = time().".". $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/offers/'), $imgname);
        }
        $vouchertheme->image = $imgname;

        $vouchertheme->update();

        $Voucherthemename = VoucherThemenames::find($id);
        $Voucherthemename->voucher_theme_id =$vouchertheme->voucher_theme_id;
        $Voucherthemename->name = $request->name;
        $Voucherthemename->update();

          return redirect()->route('voucherthemelist');

    }

    public function voucherthemedelete(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            Voucherthemes::whereIn('voucher_theme_id', $ids)->delete();
            VoucherThemenames::whereIn('voucher_theme_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }


}
