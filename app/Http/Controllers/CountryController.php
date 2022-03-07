<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $data['countries'] = Country::get();  
        return view('admin.countries.list',$data);
    }

    public function add()
    {
        return view('admin.countries.add');
        
        
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'iso_code_2' => 'required',
            'iso_code_3' => 'required',
            'address_format' => 'required',
            'postcode_required' => 'required',
            'status' => 'required'
        ]);

        $contry = new Country;
        $contry->name = $request['name'];
        $contry->iso_code_2 = $request['iso_code_2'];
        $contry->iso_code_3 = $request['iso_code_3'];
        $contry->address_format = $request['address_format'];
        $contry->postcode_required = $request['postcode_required'];
        $contry->status = $request['status'];
        $contry->save();


        return redirect()->route('countries')->with('success','Country Added successfully!');

        
    }

   
    public function edit()
    {
        //
    }

    
    public function update(Request $request)
    {
        //
    }

    public function delete()
    {
        //
    }
}
