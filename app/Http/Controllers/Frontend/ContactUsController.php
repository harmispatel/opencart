<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\URL;

class ContactUsController extends Controller
{
    // Show ContactUS Page
    public function index()
    {
        return view('frontend.pages.contact');
    }



    // Insert ContactUS
    public function contactstore(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'name' => 'required|min:3|max:33',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required|max:10',
            'enquiry' => 'required|max:3000',
        ]);

        $currentURL = URL::to("/");
        $current_theme = themeID;
        $current_theme_id = $current_theme['header_id'];
        $front_store_id =  $current_theme['store_id'];
        $IP = request()->ip();

        $contact = new ContactUs();
        $contact->store_id = $front_store_id;
        $contact->title = isset($request->title) ? $request->title : '';
        $contact->firstname = isset($request->name) ? $request->name : '';
        $contact->lastname = isset($request->surname) ? $request->surname : '';
        $contact->email = $request->email;
        $contact->phone = isset($request->phone) ? $request->phone : '';
        $contact->message = isset($request->enquiry) ? $request->enquiry : '';
        $contact->status = 0;
        $contact->response_message = '';
        $contact->date = date('y-m-d H:i:s');
        $contact->ip = $IP;
        $contact->save();

        return redirect()->route('contact');
    }




}
