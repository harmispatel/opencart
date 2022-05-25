<?php

namespace App\Http\Controllers;

use App\Models\AllUser;
use App\Models\Store;
use App\Models\Users;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class AllUserController extends Controller
{

    // Function of Get all User By Current Store
    public function index()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Check User Permission
        if (check_user_role(97) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        if ($current_store_id == 0) {
            $data['users'] = Users::get();
        } else {
            $data['users'] = Users::where('user_shop', $current_store_id)->get();
        }

        return view('admin.users.list', $data);
    }





    // Function of Add New User View
    public function add()
    {
        // Check User Permission
        if (check_user_role(96) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Get Users Group
        $data['usersgroup'] = UserGroup::get();
        $data['stores'] = Store::get();
        return view('admin.users.add', $data);
    }





    // Function of Store New User
    function store(Request $request)
    {
        $current_store_id = currentStoreId();

        // Validation
        $request->validate([
            'username' => 'required',
            'usersgroup' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:oc_user',
            'image' => 'required',
            'store' => 'required',
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
        $data->user_shop = $current_store_id;
        $data->status = $request['status'];
        $data->salt = genratetoken(9);
        $data->code = '';
        $data->user_shop = $request->store;
        $data->ip = $request->ip();
        $data->accessdirectory = isset($request->accessdirectory) ? $request->accessdirectory : '';
        $data->date_added = date('Y-m-d');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/users/'), $imageName);
            $data->image = $imageName;
        }

        $data->save();
        return redirect()->route('users')->with('success', 'Users created successfully!');
    }





    // Function of Delete User
    function deletemultiuser(Request $request)
    {
        // Check User Permission
        if (check_user_role(99) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $ids = $request['id'];

        if (count($ids) > 0) {

            foreach ($ids as $id) {
                $user = Users::where('user_id', $id)->first();

                $image = $user->image;

                if (file_exists('public/admin/users/' . $image)) {
                    unlink('public/admin/users/' . $image);
                }
            }

            Users::whereIn('user_id', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }





    // Function of Edit User View
    function edit($id)
    {
        // Check User Permission
        if (check_user_role(98) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $user = Users::where('user_id', $id)->first();
        if (empty($user)) {
            return redirect()->route('users');
        }

        $data['usersgroup'] = UserGroup::get();
        $data['stores'] = Store::get();

        $data['users'] = Users::where('user_id', $id)->first();
        return view('admin.users.edit', $data);
    }





    // Function of Update User
    function update(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required',
            'usersgroup' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'store' => 'required',
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
        $data->user_shop = $request['store'];

        if ((!empty($_POST['password'])) && (!empty($_POST['confirm']))) {
            $request->validate([
                'password' => 'min:6|required_with:confirm|same:confirm',
                'confirm' => 'min:6|required_with:password|same:password',
            ]);

            $data->password = bcrypt($request['password']);
        }

        if ($request->hasFile('image')) {
            if (!empty($old_img)) {
                unlink('public/admin/users/' . $old_img);
            }

            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/users/'), $imageName);
            $data->image = $imageName;
        }

        $data->update();
        return redirect()->route('users')->with('success', 'Users Updated successfully!');
    }





    // Function of Edit User Profile
    function userprofile($id)
    {
        // Check User Permission
        if (check_user_role(105) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $user = Users::where('user_id', $id)->first();
        if (empty($user)) {
            return redirect()->route('dashboard');
        }

        $data['users'] = $user;
        return view('admin.users.profile_view', $data);
    }





    // Function of Update User Profile
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

        if ((!empty($_POST['password'])) && (!empty($_POST['confirm']))) {
            $request->validate([
                'password' => 'min:6|required_with:confirm|same:confirm',
                'confirm' => 'min:6|required_with:password|same:password',
            ]);

            $data->password = bcrypt($request['password']);
        }

        if ($request->hasFile('image')) {
            if (!empty($old_img)) {
                if (file_exists('public/admin/users/' . $old_img)) {
                    unlink('public/admin/users/' . $old_img);
                }
            }

            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/users/'), $imageName);
            $data->image = $imageName;
        }

        $data->update();
        return redirect()->route('dashboard')->with('success', 'Your Profile has been Updated.');
    }
}
