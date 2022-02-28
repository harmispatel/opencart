<?php

namespace App\Http\Controllers;
use App\Models\RecurringProfiles;
use Illuminate\Http\Request;

class RecurringProfilesController extends Controller
{
    public function recurring()
    {
        // Check User Permission
        if(check_user_role(62) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.Recurring Profiles.recurringprofiles');
    }

    public function index(){
        return view('admin.Recurring Profiles.addRecurring');
    }

    public function addRecurring(Request $request){
         
        //   print_r($request->price);die;

         $recurring= new RecurringProfiles();

        return view('admin.Recurring Profiles.addRecurring');
    }
}
