<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\OptionDescription;


class OptionController extends Controller
{
   function index()
   {
       return view('admin.menuoptions.list');
   }
}
