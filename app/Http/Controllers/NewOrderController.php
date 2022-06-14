<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;
use Illuminate\Http\Request;

class NewOrderController extends Controller
{

    // function For New Order List
    public function index()
    {
        // Check User Permission
        if (check_user_role(44) != 1)
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.neworders.list');
    }

    // function For New Order Create
    public function create()
    {
        //
    }

    // function For New Order store
    public function store(Request $request)
    {
        //
    }

    // function For New Order Show
    public function show(NewOrder $newOrder)
    {
        //
    }


    // function For New Order Edit
    public function edit(NewOrder $newOrder)
    {
        //
    }

    // function For New Order Upadete
    public function update(Request $request, NewOrder $newOrder)
    {
        //
    }

    // function For New Order Delete
    public function destroy(NewOrder $newOrder)
    {
        //
    }
}
