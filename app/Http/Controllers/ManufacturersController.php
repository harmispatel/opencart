<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturers;

class ManufacturersController extends Controller
{
    public function manufacturer()
    {

        // Check User Permission
        if(check_user_role(70) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $manufacturer=Manufacturers::select('*')->get();
        return view('admin.Manufacturers.manufacturer',['manufacturer'=>$manufacturer]);
    }
}
