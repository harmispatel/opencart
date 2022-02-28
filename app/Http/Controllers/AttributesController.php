<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attributes;
use App\Models\AttributesGroupDescription;
use App\Models\AttributesDescription;


class AttributesController extends Controller
{
    public function attribute()
    {


        // Check User Permission
        if(check_user_role(21) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $attribute = Attributes::join('oc_attribute_description', 'oc_attribute.attribute_id', '=', 'oc_attribute_description.attribute_id')
            ->join('oc_attribute_group_description', 'oc_attribute.attribute_group_id', '=', 'oc_attribute_group_description.attribute_group_id')
            ->select('oc_attribute_group_description.*','oc_attribute_description.*','oc_attribute.*','oc_attribute_group_description.name as groupdesname','oc_attribute_description.name as desname')
            ->get();
        return view('admin.Attributes.attribute', ['attribute' => $attribute]);
    }

    public function attributegroup()
    {
        // Check User Permission
        if(check_user_role(22) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.Attributes.attributegroup');
    }

    public function addAttribute()
    {

    }
}
