<?php

namespace App\Http\Controllers;

use App\Models\Loyalty;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{

    public function index()
    {
        return view('admin.loyalty.loyalty');
    }

}
