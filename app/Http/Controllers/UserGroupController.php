<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use Illuminate\Http\Request;
use App\Models\Users;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check User Permission
        if(check_user_role(86) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $data['usersgroup'] = UserGroup::get();
        return view('admin.usersgroup.list',$data);
    }

    public function add()
    {
        // Check User Permission
        if(check_user_role(87) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.usersgroup.add');
    }

    function store(Request $request)
    {
        $request->validate([
            'usergroupName' => 'required',
        ]);

        if(!empty($_POST))
        {
            $data = new UserGroup;
            $data->name = $request['usergroupName'];
            $data->save();
            return redirect()->route('usersgroup')->with('success','Users Group created successfully!');
        }

    }

    function deletemultiusergroup(Request $request)
    {

        // Check User Permission
        if(check_user_role(89) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $ids = $request['id'];

        if(count($ids) > 0)
        {
            UserGroup::whereIn('user_group_id',$ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }

    function edit($id)
    {
        // Check User Permission
        if(check_user_role(88) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $userGroup = UserGroup::where('user_group_id',$id)->first();
        if(empty($userGroup))
        {
            return redirect()->route('usersgroup');
        }
        $data['usergroup'] = UserGroup::where('user_group_id',$id)->first();
        return view('admin.usersgroup.edit',$data);
    }


    function update(Request $request)
    {
        $request->validate([
            'usergroupName' => 'required',
        ]);

        $user_group_id = $request->id;
        $data = UserGroup::find($user_group_id);
        $data->name = $request['usergroupName'];
        $data->update();
        return redirect()->route('usersgroup')->with('success','Users Group Updated successfully!');

    }


}
