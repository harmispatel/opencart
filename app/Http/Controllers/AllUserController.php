<?php

namespace App\Http\Controllers;

use App\Models\AllUser;
use App\Models\Users;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class AllUserController extends Controller
{

    public function index()
    {
        $data['users'] = Users::get();
        return view('admin.users.list',$data);
    }

    public function add()
    {
        $data['usersgroup'] = UserGroup::get();
        return view('admin.users.add',$data);
    }

    function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'usersgroup' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'password' => 'min:6|required_with:confirm|same:confirm',
            'confirm' => 'min:6|required',
        ]);

        $data = new Users;
        $data->user_group_id = $request['usersgroup'];
        $data->username = $request['username'];
        $data->name = $request['username'];
        $data->name = $request['username'];
        $data->save();
        return redirect()->route('usersgroup')->with('success','Users Group created successfully!');

    }

}
