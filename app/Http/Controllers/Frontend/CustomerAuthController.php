<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CustomerAuthController extends Controller
{
    public function customerlogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $userlogin = new Customer;
        // $userlogin->


    }

    public function customerregister(Request $request)
    {
        // $currentURL = URL::to("/");
        // $current_theme = themeID($currentURL);
        // $current_theme_id = $current_theme['theme_id'];
        // $front_store_id =  $current_theme['store_id'];
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required',
            'confirmpassword' => 'required',
        ]);

        // $userlogin = new Customer;
        // $userlogin-> = $request->$front_store_id;

        return response()->json();
    }
}
