<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function index()
    {
        return view('admin.messages.list');
    }


    public function add()
    {
        return view('admin.messages.add');
    }


}
