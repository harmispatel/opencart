<?php

use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;

function user_details()
{
    $user_dt = auth()->user();
    return $user_dt;
}

function genratetoken($length = 32) {
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $max = strlen($string) - 1;

    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $string[mt_rand(0, $max)];
    }

    return $token;
}


// Sidebar
function sidebar()
{
    $all_menu = MainMenu::orderBy('menu_order','ASC')->get();
    return $all_menu;
}


function submenu($menu_id)
{
    $sub_menu = Submenu::where('menu_id',$menu_id)->get();
    return $sub_menu;
}

function get_rel_userrole_action($where)
{
    $user_role_action = Permission::where($where)->get();
    return $user_role_action;
}


?>
