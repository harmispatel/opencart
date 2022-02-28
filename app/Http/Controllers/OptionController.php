<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\OptionDescription;


class OptionController extends Controller
{
    public function options()
    {
        $option = Option::join('oc_option_description', 'oc_option.option_id', '=', 'oc_option_description.option_id')->get();
        return view('admin.Options.option', ['option' => $option]);
    }
    public function index(){
        $option=OptionDescription::all();
        return view('admin.Options.addOption',['option'=>$option]);
    }
}
