<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use Illuminate\Http\Request;

class LayoutController extends Controller
{

    public function templatesettings()
    {
        return view('admin.settinglayouts.template_settings');
    }

    public function slidersettings()
    {
        return view('admin.settinglayouts.slider_settings');
    }

    public function bannerandblocks()
    {
        return view('admin.settinglayouts.banner_and_blocks');
    }

}
