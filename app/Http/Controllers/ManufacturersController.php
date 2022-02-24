<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturers;

class ManufacturersController extends Controller
{
    public function manufacturer(){
        $manufacturer=Manufacturers::select('*')->get();
        return view('admin.Manufacturers.manufacturer',['manufacturer'=>$manufacturer]);
    }
}
