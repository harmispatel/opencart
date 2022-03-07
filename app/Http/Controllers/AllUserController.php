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

        // Check User Permission
        if(check_user_role(82) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }
    
        $data['users'] = Users::get();
        return view('admin.users.list',$data);
    }

    public function add()
    {
        // Check User Permission
        if(check_user_role(83) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

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
            'email' => 'required|unique:oc_user',
            'image' => 'required',
            'password' => 'min:6|required_with:confirm|same:confirm',
            'confirm' => 'min:6|required_with:password|same:password',
        ]);

        $data = new Users;
        $data->user_group_id = $request['usersgroup'];
        $data->username = $request['username'];
        $data->password = bcrypt($request['password']);
        $data->firstname = $request['firstname'];
        $data->lastname = $request['lastname'];
        $data->email = $request['email'];
        $data->status = $request['status'];
        $data->salt = genratetoken(9);
        $data->code = '';
        $data->ip = '';
        $data->date_added = date('Y-m-d');

        if($request->hasFile('image'))
        {
            $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/users/'),$imageName);
            $data->image = $imageName;
        }

        $data->save();
        return redirect()->route('users')->with('success','Users created successfully!');

    }


    function deletemultiuser(Request $request)
    {

        // Check User Permission
        if(check_user_role(85) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $ids = $request['id'];

        if(count($ids) > 0)
        {

            foreach($ids as $id)
            {
                $user = Users::where('user_id',$id)->first();

                $image = $user->image;

                if(file_exists('public/admin/users/'.$image))
                {
                    unlink('public/admin/users/'.$image);
                }

            }

            Users::whereIn('user_id',$ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }

    function edit($id)
    {

        // Check User Permission
        if(check_user_role(84) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $user = Users::where('user_id',$id)->first();
        if(empty($user))
        {
            return redirect()->route('users');
        }

        $data['usersgroup'] = UserGroup::get();

        $data['users'] = Users::where('user_id',$id)->first();
        return view('admin.users.edit',$data);
    }


    function update(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'usersgroup' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
        ]);

        $user_id = $request->id;
        $data = Users::find($user_id);
        $old_img = $data->image;
        $data->user_group_id = $request['usersgroup'];
        $data->username = $request['username'];
        $data->firstname = $request['firstname'];
        $data->lastname = $request['lastname'];
        $data->email = $request['email'];
        $data->status = $request['status'];

        if( (!empty($_POST['password'])) && (!empty($_POST['confirm'])) )
        {
            $request->validate([
                'password' => 'min:6|required_with:confirm|same:confirm',
                'confirm' => 'min:6|required_with:password|same:password',
            ]);

            $data->password = bcrypt($request['password']);
        }

        if($request->hasFile('image'))
        {
            if(!empty($old_img))
            {
                unlink('public/admin/users/'.$old_img);
            }

            $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/users/'),$imageName);
            $data->image = $imageName;
        }

        $data->update();
        return redirect()->route('users')->with('success','Users Updated successfully!');

    }


    function userprofile($id)
    {

        // Check User Permission
        if(check_user_role(91) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $user = Users::where('user_id',$id)->first();
        if(empty($user))
        {
            return redirect()->route('dashboard');
        }

        $data['users'] = $user;
        return view('admin.users.profile_view',$data);
    }


    function updateprofile(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
        ]);

        $user_id = $request->id;

        $data = Users::find($user_id);

        $old_img = $data->image;

        $data->username = $request['username'];
        $data->firstname = $request['firstname'];
        $data->lastname = $request['lastname'];
        $data->email = $request['email'];

        if( (!empty($_POST['password'])) && (!empty($_POST['confirm'])) )
        {
            $request->validate([
                'password' => 'min:6|required_with:confirm|same:confirm',
                'confirm' => 'min:6|required_with:password|same:password',
            ]);

            $data->password = bcrypt($request['password']);
        }

        if($request->hasFile('image'))
        {
            if(!empty($old_img))
            {
                unlink('public/admin/users/'.$old_img);
            }

            $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/users/'),$imageName);
            $data->image = $imageName;
        }

        $data->update();
        return redirect()->route('dashboard')->with('success','Your Profile has been Updated.');

    }


}
