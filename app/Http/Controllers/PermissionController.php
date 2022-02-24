<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\UserGroup;
use App\Models\SubMenu;
use App\Models\MainMenu;
use App\Models\Users;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index()
    {
        $data['menus'] = MainMenu::orderBy('menu_order','ASC')->get();
        $data['actions'] = SubMenu::get();
        $data['user_roles'] = UserGroup::where('user_group_id','!=',1)->get();
        $data['permissions'] = Permission::get();
        return view('admin.permission.list',$data);
    }


}
