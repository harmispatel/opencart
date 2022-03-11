<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class autocomplete extends Controller
{
    public function index()
    {
    	return view('admin.order.test');
    }
    public function autocompletecustomer(Request $request)
    {
        $query = $request->get('query');
        $data = Customer::select("firstname")
                ->where("firstname","LIKE","%{$query}%")
                ->get();
   
        return response()->json($data);
    }
    // public function autocomplete(Request $request)
    // {
    //     $data = Customer::select("firstname")
    //             ->where("firstname","LIKE","%{$request->query}%")
    //             ->get();
   
    //     return response()->json($data);
    // }
}
