<?php

namespace App\Http\Controllers;
use App\Models\RecurringProfiles;
use Illuminate\Http\Request;

class RecurringProfilesController extends Controller
{
    public function recurring(){
        return view('admin.Recurring Profiles.recurringprofiles');
    }

    public function index(){
        return view('admin.Recurring Profiles.addRecurring');
    }

    public function addRecurring(){
        return view('admin.Recurring Profiles.addRecurring');
    }
}
