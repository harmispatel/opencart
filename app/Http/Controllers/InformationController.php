<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\InformationDescription;


class InformationController extends Controller
{
    public function informations(){


      $information =Information::join('oc_information_description','oc_information.information_id','=','oc_information_description.information_id')->get();
    //  echo"<pre>";print_r($information);die;


       return view('admin.Informations.information',['information'=>$information]);
    }
}
