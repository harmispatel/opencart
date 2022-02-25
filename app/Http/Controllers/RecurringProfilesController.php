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
}
