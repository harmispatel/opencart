<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Downloads;

class DownloadsController extends Controller
{
   public function download()
   {

        // Check User Permission
        if(check_user_role(74) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.Downloads.download');

   }
}
