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

        // Check User Permission
        if(check_user_role(104) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $data['menus'] = MainMenu::orderBy('menu_order','ASC')->get();
        $data['actions'] = SubMenu::get();
        $data['user_roles'] = UserGroup::where('user_group_id','!=',1)->get();
        $data['permissions'] = Permission::get();
        return view('admin.permission.list',$data);
    }

    function storerelation(Request $request)
    {

        $passchedkId = $_POST['passchedkId'];
		$ischeckked = $_POST['ischeckked'];

        if(!empty($passchedkId))
        {
            $menuId=explode("_",$passchedkId);
			$insertArray=array();

			if(count($menuId))
            {
				$insertArray['role_id']=$menuId[0];
				$insertArray['menu_id']=$menuId[1];
				$insertArray['action_id']=$menuId[2];
				$insertArray['subaction_id']=$menuId[3];
			}

            if($ischeckked)
            {

                $permission = new Permission;
                $permission->role_id = $insertArray['role_id'];
                $permission->menu_id = $insertArray['menu_id'];
                $permission->action_id = $insertArray['action_id'];
                $permission->subaction_id = $insertArray['subaction_id'];

                $permission->save();

            }
            else
            {
                $permissiondel = Permission::where('role_id',$insertArray['role_id'])
                ->where('menu_id',$insertArray['menu_id'])
                ->where('action_id',$insertArray['action_id'])
                ->where('subaction_id',$insertArray['subaction_id'])->delete();
            }

        }

        return response()->json([
            'success'=>1,
            'message'=>"Done Successfully!!",
        ]);

    }


}
