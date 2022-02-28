<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filters;
class FiltersController extends Controller
{
    public function filters()
    {

        // Check User Permission
        if(check_user_role(66) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.Filters.filter');
    }

    public function index(){
        return view('admin.Filters.addFilter');
    }
}
