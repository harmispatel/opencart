<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    // Function For Make Reservation
    public function index(Request $request)
    {

        $current_store_id = currentStoreId();
        $reservations = new Reservation;
        $reservations->store_id = $current_store_id;
        $reservations->name = isset($request->fullname) ? $request->fullname : '';
        $reservations->phone = isset($request->phone) ? $request->phone  : '';
        $reservations->booking_date = isset($request->date) ? $request->date : '';
        $reservations->booking_time = isset($request->time) ? $request->time : '';
        $reservations->no_of_people = isset($request->person) ? $request->person : '';
        $reservations->comment = isset($request->comment) ? $request->comment : '';
        $reservations->booking_status = isset($request->booking_status) ? $request->booking_status : '';
        $reservations->message = isset($request->message) ? $request->message : '';

        $reservations->created_date = date("Y-m-d h:i:s");
        $reservations->ip =  $request->ip();
        $reservations->save();
        return redirect()->route('home');
    }
}
