<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $data['countries'] = Country::get();
        return view('admin.countries.list', $data);
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


        return redirect()->route('countries')->with('success', 'Country Added successfully!');
    }
    function deletecountry(Request $request)
    {

        $ids = $request['id'];

        if (count($ids) > 0) {
            Country::whereIn('country_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }


    public function edit($id)
    {
        // Check Country Permission
        if (check_user_role(84) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $country = Country::where('country_id', $id)->first();
        if (empty($country)) {
            return redirect()->route('countries');
        }

        //   $data['usersgroup'] = UserGroup::get();

        $data['country'] = Country::where('country_id', $id)->first();
        return view('admin.countries.edit', $data);
    }




    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required',
            'iso_code_2' => 'required',
            'iso_code_3' => 'required',
            'address_format' => 'required',
            'postcode_required' => 'required',
            'status' => 'required'
        ]);

        $country_id = $request->id;
        $country = Country::find($country_id);
        $country->name = $request['name'];
        $country->iso_code_2 = $request['iso_code_2'];
        $country->iso_code_3 = $request['iso_code_3'];
        $country->address_format = $request['address_format'];
        $country->postcode_required = $request['postcode_required'];
        $country->status = $request['status'];
        $country->update();
        return redirect()->route('countries')->with('success', 'Country Updated successfully!');
    }

    public function delete()
    {
        //
    }
}
