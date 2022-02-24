<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Downloads;

class DownloadsController extends Controller
{
   public function download(){

    return view('admin.Downloads.download');

   }
}
