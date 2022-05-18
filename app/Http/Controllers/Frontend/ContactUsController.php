<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\URL;

class ContactUsController extends Controller
{
    public function index()
    {
        //  echo "<pre>";
        //  print_r(session()->all());
        //  exit;
        return view('frontend.pages.contact');
    }

    public function contactstore(Request $request)
    {
        $currentURL = URL::to("/");
        $current_theme = themeID($currentURL);
        $current_theme_id = $current_theme['theme_id'];
        $front_store_id =  $current_theme['store_id'];
        $IP =request()->ip();

        $contact =new ContactUs();
        $contact->store_id =$front_store_id;
        $contact->title =isset($request->Title) ? $request->Title : '';
        $contact->firstname =isset($request->name) ? $request->name : '';
        $contact->lastname =isset($request->surname) ? $request->surname : '';
        $contact->email =$request->email;
        $contact->phone =isset($request->phone) ? $request->phone : '';
        $contact->message =isset($request->enquiry) ? $request->enquiry : '';
        $contact->status =0;
        $contact->response_message ='';
        $contact->date =date('y-m-d H:i:s');
        $contact->ip =$IP;
        $contact->save();

        return redirect()->route('contact');
    }
}
