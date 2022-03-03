<?php

namespace App\Http\Controllers;

use App\Models\RecurringProfiles;
use App\Models\RecurringDescription;

use Illuminate\Http\Request;

class RecurringProfilesController extends Controller
{
    public function index()
    {
        // Check User Permission
        if (check_user_role(62) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $recuring = RecurringProfiles::join('oc_recurring_description', 'oc_recurring.recurring_id', '=', 'oc_recurring_description.recurring_id')->get();
        return view('admin.Recurring Profiles.recurringprofiles', ['recuring' => $recuring]);
    }
    public function add()
    {
        return view('admin.Recurring Profiles.addRecurring');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:64',
        ]);
        $recuring = new RecurringProfiles();
        $recuring->price = $request['price'];
        $recuring->frequency = $request['frequency'];
        $recuring->duration = $request['duration'];
        $recuring->cycle = $request['cycle'];
        $recuring->trial_status = $request['trial_status'];
        $recuring->trial_price = $request['trial_price'];
        $recuring->trial_frequency = $request['trial_frequency'];
        $recuring->trial_duration = $request['trial_duration'];
        $recuring->trial_cycle = $request['trial_cycle'];
        $recuring->status = $request['status'];
        $recuring->sort_order = $request['sort_order'];
        $recuring->save();
        $recuring_description = new RecurringDescription();
        $recuring_description->recurring_id = $recuring->id;
        $recuring_description->language_id = 1;
        $recuring_description->name = $request['name'];
        $recuring_description->save();
        return redirect()->route('addRecurring')->with('success', "Recurring Inserted Successfully..");
    }
    public function deleterecurring(Request $request)
    {
        $ids = $request['id'];
        if (count($ids) > 0) {
            RecurringProfiles::whereIn('recurring_id', $ids)->delete();
            RecurringDescription::whereIn('recurring_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }

    public function edit($id){

        $recuring = RecurringProfiles::where('recurring_id',$id)->first();
        $data['recuring'] = $recuring;
        $data['description'] = RecurringDescription::where('recurring_id',$id)->first();
        return view('admin.Recurring Profiles.edit',['data'=>$data]);
    }

    public function update(Request $request){
 
       $recuring_id = $request->id;
      
        $recurings = RecurringProfiles::find($recuring_id);
        $recurings->price = $request['price'];
        $recurings->frequency = $request['frequency'];
        $recurings->duration = $request['duration'];
        $recurings->cycle = $request['cycle'];
        $recurings->trial_status = $request['trial_status'];
        $recurings->trial_price = $request['trial_price'];
        $recurings->trial_frequency = $request['trial_frequency'];
        $recurings->trial_duration = $request['trial_duration'];
        $recurings->trial_cycle = $request['trial_cycle'];
        $recurings->status = $request['status'];
        $recurings->sort_order = $request['sort_order'];
        $recurings->update();
        $recuring_description =RecurringDescription::find($recuring_id);
        $recuring_description->recurring_id = $recuring_id;
        $recuring_description->language_id = 1;
        $recuring_description->name = $request['name'];
        $recuring_description->update();
        return redirect()->route('recurringprofiles')->with('success', "Recurring Update Successfully..");
    }
}
