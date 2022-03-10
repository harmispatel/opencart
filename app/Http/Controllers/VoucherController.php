<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function giftvoucher()
    {
        return view('admin.vouchers.giftvoucher');
    }


    public function vouchertheme()
    {
        return view('admin.vouchers.vouchertheme');
    }


}
