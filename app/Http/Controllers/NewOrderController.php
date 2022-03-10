<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;
use Illuminate\Http\Request;

class NewOrderController extends Controller
{

    public function index()
    {
        return view('admin.neworders.list');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(NewOrder $newOrder)
    {
        //
    }


    public function edit(NewOrder $newOrder)
    {
        //
    }


    public function update(Request $request, NewOrder $newOrder)
    {
        //
    }


    public function destroy(NewOrder $newOrder)
    {
        //
    }
}
