<?php

use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;
use App\Models\CategoryDetail;
use App\Models\CustomerBanIp;
use App\Models\CustomerIP;
use App\Models\Option;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Store;
use App\Models\Topping;
use App\Models\ToppingProductPriceSize;
use App\Models\Product_to_category;
use App\Models\ToppingSize;



// Function of User Details
function user_details()
{
    $user_dt = auth()->user();
    return $user_dt;
}


// Get Total Ip Count
function gettotalip($ip)
{
    $ip = CustomerIP::where('ip',$ip)->count();
    return $ip;
}


//
function themeActive()
{
    // Current Store ID
    $current_store_id = currentStoreId();

    $key = 'theme_id';

    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    $theme_id = isset($setting->value) ? $setting->value : '';

    return $theme_id;

}


function storeThemeSettings($theme_id,$store_id)
{
    // Template Settings
    $key = ([
        'polianna_navbar_background',
        'polianna_navbar_link',
        'polianna_navbar_link_hover',
        'polianna_main_logo',
        'polianna_main_logo_width',
        'polianna_main_logo_height',

        'polianna_slider_permission',
        'polianna_slider_1',
        'polianna_slider_2',
        'polianna_slider_3',
        'polianna_slider_1_title',
        'polianna_slider_2_title',
        'polianna_slider_3_title',

        'polianna_online_order_permission',
        'polianna_open_close_store_permission',

        'polianna_open_banner',
        'polianna_close_banner',
        'polianna_open_close_banner_width',
        'polianna_open_close_banner_height',

        'polianna_store_fonts',

        'polianna_footer_background',
        'polianna_footer_text_color',
        'polianna_footer_title_color',
        'polianna_footer_logo',
    ]);

    $template_settings = [];

    foreach($key as $row)
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('theme_id',$theme_id)->where('key',$row)->first();
        $template_settings[$row] = isset($query->value) ? $query->value : '';
    }

    if(session()->has('template_settings'))
    {
        session()->forget('template_settings');
        session()->put('template_settings',$template_settings);
    }
    else
    {
        session()->put('template_settings', $template_settings);
    }
    // End Template Settings

    // Social Site
    $social_key = ([
        'polianna_facebook_id',
        'polianna_twitter_username',
        'polianna_gplus_id',
        'polianna_linkedin_id',
        'polianna_youtube_id',
    ]);

    $social_settings = [];

    foreach($social_key as $row)
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('key',$row)->first();
        $social_settings[$row] = isset($query->value) ? $query->value : '';
    }

    if(session()->has('social_site'))
    {
        session()->forget('social_site');
        session()->put('social_site',$social_settings);
    }
    else
    {
        session()->put('social_site', $social_settings);
    }
    // End Social Site


    // Store Settings
    $store_key = ([
        'config_name',
        'config_owner',
        'config_address',
        'map_ifram',
        'sitemap_url',
        'config_telephone',
        'config_email',
        'config_meta_description',
    ]);

    $store_settings = [];

    foreach($store_key as $row)
    {
        $query = Settings::select('value')->where('store_id',$store_id)->where('key',$row)->first();
        $store_settings[$row] = isset($query->value) ? $query->value : '';
    }

    if(session()->has('store_settings'))
    {
        session()->forget('store_settings');
        session()->put('store_settings',$store_settings);
    }
    else
    {
        session()->put('store_settings', $store_settings);
    }
    // End Store Settings

}

function public_url()
{
    return asset('');
}

function themeID($url)
{
    $slash = substr($url, -1);

    if($slash != '/')
    {
        $new_url = $url .= '/';
    }
    else
    {
        $new_url = $url;
    }

    $storeDetails = Store::where('url',$new_url)->orWhere('ssl',$new_url)->first();
    $store_id = isset($storeDetails->store_id) ? $storeDetails->store_id : '';

    $key = 'theme_id';
    $setting = Settings::select('value')->where('store_id',$store_id)->where('key',$key)->first();
    $theme_id = isset($setting->value) ? $setting->value : '';

	if(session()->has('front_store_id'))
    {
        session()->forget('front_store_id');
        session()->put('front_store_id',$store_id);
    }
    else
    {
        session()->put('front_store_id', $store_id);
    }

    if(session()->has('theme_id'))
    {
        session()->forget('theme_id');
        session()->put('theme_id', $theme_id);
    }
    else
    {
        session()->put('theme_id', $theme_id);
    }

}

function getproductcount($demo){
	$productcount=Product_to_category::where('category_id',$demo)->count();

	return $productcount;


}

function getproduct($front_store_id,$cat_id){

	$product=Product_to_category::with(['hasOneProduct','hasOneDescription','hasOneToppingProductPriceSize'])->whereHas('hasOneProduct', function ($query) use ($cat_id) {
		$query->where('category_id', $cat_id);
	})->get();
	$size =ToppingSize::where('id_category',$cat_id)->get();

	$result['product']=$product;
	$result['size']=$size;
	return $result;
}
function getprice($sizeprice,$productsize){

	$setsizeprice=ToppingProductPriceSize::where('id_size',$sizeprice)->where('id_product',$productsize)->get();
	return $setsizeprice;
}


function getFonts()
{
    $fonts = array(
        ''                  => '- default -',
        'Arial'             => 'Arial',
        'Verdana'           => 'Verdana',
        'Helvetica'         => 'Helvetica',
        'Cursive'           => 'cursive',
        'Calibri'           => 'Calibri',
        'Noto'              => 'Noto',
        'Lucida Sans'       => 'Lucida Sans',
        'Gill Sans'       => 'Gill Sans',
        'Candara'       => 'Candara',
        'Futara'       => 'Futara',
        'Geneva'       => 'Geneva',
        'Segoe UI'       => 'Segoe UI',
        'Optima'       => 'Optima',
        'Avanta Garde'       => 'Avanta Garde',
	);

    return $fonts;
}


// Function to Get Store Details
function getStoreDetails($storeid,$key)
{
    $gedetails = Settings::where('key',$key)->where('store_id',$storeid)->first();
    $new = isset($gedetails->value) ? $gedetails->value : '';
    return $new;
}

function getLoyaltyDetails($storeid,$key){

    $gedetails = Settings::where('store_id',$storeid)->where('key',$key)->first();

        $point = Settings::select('value')->where('store_id',$storeid)->where('key','point')->first();
        $unserializepoint =unserialize(isset($point['value']) ? $point['value'] :'');

        $money = Settings::select('value')->where('store_id',$storeid)->where('key','money')->first();
        $unserializemoney =unserialize(isset($money['value']) ? $money['value'] :'');



    $value = isset($gedetails->value) ? $gedetails->value : '';
    $data['value'] = $value;
    $data['unserializepoint'] =$unserializepoint;
    $data['unserializemoney'] =$unserializemoney;


    return $data;
}

function currentStoreId()
{
    if(session()->has('store_id'))
    {
        $storeID = session()->get('store_id');
    }
    else
    {
        $storeID = 0;
    }
    return $storeID;
}


// Check Ban IP
function checkBanIp($ip)
{
    $ip = CustomerBanIp::select('ip')->where('ip',$ip)->first();
    return $ip;
}


// Check New Model
function checkNewModel()
{
    $setting = Settings::where('key','new_module_status')->first();
    if($setting != '' || !empty($setting))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}



function getStores()
{
    $stores = Store::get();
    return $stores;
}


function getCurrentStoreURL($id)
{
    $store = Store::select('ssl')->where('store_id',$id)->first();
    $url = isset($store->ssl) ? $store->ssl : '';
    return $url;
}


function get_sub_opt_names($sub_opt_ids)
{
    $arr = array();
    $ids = explode(',',$sub_opt_ids);

    foreach($ids as $id)
    {
        $getname = Topping::select('name_topping')->where('id_topping',$id)->first();
        $name = isset($getname->name_topping) ? $getname->name_topping : '';
        $arr[] = $name;
    }

    $names = implode(',',$arr);
    return $names;
}



function getZonebyId($zid)
{
    $zone = Region::where('zone_id',$zid)->first();
    return $zone;
}


// Function of Genrate Token
function genratetoken($length = 32) {
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $max = strlen($string) - 1;

    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $string[mt_rand(0, $max)];
    }

    return $token;
}



// Function of Sidebar Menu
function sidebar()
{
    $all_menu = MainMenu::orderBy('menu_order','ASC')->get();
    return $all_menu;
}




// Function of Sidebar Menu of Submenu
function submenu($menu_id)
{
    $sub_menu = Submenu::where('menu_id',$menu_id)->get();
    return $sub_menu;
}




function submenuofsubmenu($submenu_id)
{
    $submenu_of_submenu = Submenu::where('parent_id',$submenu_id)->get();
    return $submenu_of_submenu;
}




// Function of Submenu Actions
function submenuaction($smenu_id)
{
    $sub_menu = Submenu::where('parent_id',$smenu_id)->get();
    return $sub_menu;
}




// Function of Get User Role Action
function get_rel_userrole_action($where)
{
    $user_role_action = Permission::where($where)->first();
    return $user_role_action;
}




// Function of Fetch Other Users Sidebar Menu
function fetch_otherusers_mainmenu($where)
{
    $resultset = MainMenu::where($where)->select('oc_main_menu.*')->join('oc_userrole_actions','oc_userrole_actions.menu_id','=','oc_main_menu.id')->orderBy('oc_main_menu.menu_order')->get();
    return $resultset;
}




// Function of Fetch Other Users Sidebar Menu of Submenu
function fetch_otherusers_mainmenu_submenu($where)
{
    $resultset = Permission::where($where)->where('oc_menu_actions.is_hidden','!=',4)->select('oc_menu_actions.*')->join('oc_menu_actions','oc_menu_actions.id','=','oc_userrole_actions.action_id')->orderBy('oc_menu_actions.id')->get();
    return $resultset;
}


function getProductSize($sizeid,$productid)
{
    $size = ToppingProductPriceSize::where('id_size',$sizeid)->where('id_product',$productid)->first();
    return $size;
}


// Function of Check Userrole of Submenus
function check_user_role($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('subaction_id','=',$action_id)->where('role_id','=',$uaccess)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }

}




// Function of Check Userrole for Single Menu
function check_user_role_for_single_menu($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('action_id','=',$action_id)->where('role_id','=',$uaccess)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }

}

function getmaincat()
{
    $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

    foreach ($fetchparent as $main) {
        $subcat = CategoryDetail::where('oc_category.parent_id',$main->category_id)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
    }

    return $fetchparent;
}



//Function of Get Sub Category
function get_subcat($parentid)
{
    $subcat = CategoryDetail::where('oc_category.parent_id',$parentid)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
    return $subcat;
}




// Function of Subcategory of Category
function depend_subcat($value1)
{
    $subcat1 = CategoryDetail::where('oc_category.parent_id',$value1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();;
    return $subcat1;
}




//
function fetch_mainmenu_submenucolumn($id)
{
    $subMenu = SubMenu::where('menu_id',$id)->where('oc_menu_actions.is_hidden','!=',4)->select('slugurl')->get()->toArray();

    $arr = array_map(function ($value) {
        return $value['slugurl'];
    }, $subMenu);

    return $arr;

}


?>
