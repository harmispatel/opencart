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


    public function uploadgallary()
    {
        return view('admin.gallary.upload_gallary');
    }

}
