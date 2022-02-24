<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filters;
class FiltersController extends Controller
{
    public function filters(){
        return view('admin.Filters.filter');
    }
}
