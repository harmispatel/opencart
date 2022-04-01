<?php

namespace App\Http\Controllers;

use App\Models\Gallary;
use Illuminate\Http\Request;


class GallaryController extends Controller
{

    public function gallarysettings()
    {
        return view('admin.gallary.gallarysettings');
    }
   
    public function gallarysettingsstore(Request $request){
        $data =$request->all();
        return $data;
    }

    public function uploadgallary()
    {
        return view('vendor.laravel-filemanager.index');
    }

    public function store(Request $request){
    
        $data =$request->all();
        return $data;
          
    }



}
