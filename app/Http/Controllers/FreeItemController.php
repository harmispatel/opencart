<?php

namespace App\Http\Controllers;

use App\Models\FreeItem;
use Illuminate\Http\Request;

class FreeItemController extends Controller
{

    public function freeitems()
    {
        return view('admin.freeitems.freeitem');
    }


    public function cartrule()
    {
        return view('admin.freeitems.cartrule');
    }


}
