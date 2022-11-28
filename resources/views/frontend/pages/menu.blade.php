
{{--
THIS IS View Menu  PAGE FOR FRONTEND
----------------------------------------------------------------------------------------------
menu.blade.php
It's used for View Menu.
----------------------------------------------------------------------------------------------
--}}



@php
    // echo '<pre>';
    // print_r(session()->all());
    // exit();

    // Get Current URL
    $currentURL = URL::to("/");

    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];

    // Social Site Settings
    $social_site = isset($store_data['social_settings']) ? $store_data['social_settings'] : '';

    // Store Settings
    $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

    // Get New Module Status
    $new_module_status = (isset($store_setting['new_module_status']) && !empty($store_setting['new_module_status'])) ? $store_setting['new_module_status'] : 0;

    // Get Currency Details
    $currency = getCurrencySymbol($store_setting['config_currency']);

    // Get Open-Close Time
    $openclose = openclosetime();

    // delivery gap
    $delivery_gap = isset($openclose['delivery_gap']) ? $openclose['delivery_gap'] : '';
    $collection_gap = isset($openclose['collection_gap']) ? $openclose['collection_gap'] : '';

    // Store open time
    $opentime = isset($openclose['from_time']) ? date('H:i',$openclose['from_time']) : '0:00';

    // Store Open / Close
    $store_open_close = isset($openclose['store_open_close']) ? $openclose['store_open_close'] : 'close';

    // Get Current Day
    $current_day = date("N");

    // Get Working Time
    if($store_open_close == 'open')
    {
        $working_from_time = isset($openclose['from_time']) ? date('H:i',$openclose['from_time']) : '0:00';
        $working_to_time = isset($openclose['to_time']) ? date('H:i',$openclose['to_time']) : '0:00';
        $working_time = $working_from_time.' - '.$working_to_time;
    }
    else
    {
        $working_time = '0:00 - 0:00';
    }

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = (session()->has('flag_post_code')) ? session('flag_post_code') : '';
    // End User Delivery Type

    // Get Customer Cart
    if (session()->has('userid'))
    {
        $userid = session()->get('userid');



        // $mycart = getuserCart(session()->get('userid'));
        // cart after login ===---
        $mycart = session()->get('cart1');

        // if(isset($mycart))
        // {
        //     if( ( isset($mycart['withoutSize']) && count($mycart['withoutSize']) == 0) && ( isset($mycart['size']) && count($mycart['size']) == 0 ) )
        //     {
        //         session()->forget('subtotal');
        //         session()->forget('free_item');
        //     }
        // }
    }
    else
    {
        $userid = 0;
        $mycart = session()->get('cart1');

        // if(isset($mycart))
        // {
        //     if( ( isset($mycart['withoutSize']) && count($mycart['withoutSize']) == 0) && ( isset($mycart['size']) && count($mycart['size']) == 0 ) )
        //     {
        //         session()->forget('subtotal');
        //         session()->forget('free_item');
        //     }
        // }

    }
    // End Get Customer Cart

    // echo '<pre>';
    // print_r($mycart);
    // exit();

    if(session()->has('subtotal'))
    {
        $get_sub_total = session()->get('subtotal');
    }
    else
    {
        $get_sub_total = 0;
    }

    if(isset($cart_rule) && !empty($cart_rule))
    {
        $cart_rule_total = $cart_rule['min_total'];
    }
    else
    {
        $cart_rule_total = '';
    }


    if(session()->has('free_item'))
    {
        $session_free_item = session()->get('free_item');
    }
    else
    {
        $session_free_item = '';
    }

    // Current Delivery Type From Session
    $session_flag_code = (session()->has('flag_post_code')) ? (session()->get('flag_post_code')) : '';


    // Get Minimum Spend
    if(isset($minimum_spend_setting) && count($minimum_spend_setting) > 0)
    {
        $minimum_spend_total = isset($minimum_spend_setting['min_spend']) ? $minimum_spend_setting['min_spend'] : 0;
    }
    else
    {
        $minimum_spend_total = 0;
    }


    if(session()->has('delivery_charge'))
    {
        $delivery_charge = session()->get('delivery_charge');
    }
    else
    {
        $delivery_charge = 0;
    }

@endphp


<!doctype html>
<html>
<head>
    <!-- CSS -->
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    <!-- End CSS -->
</head>
<body>

    <style>
        .ui-autocomplete{
            z-index:2147483647;
        }

        .custom_topping_modal .modal-header .item-popup-title{
            font-size: 25px;
        }

        .custom_topping_modal .modal-header .item-popup-title span{
            color: red;
            font-size: 25px;
        }

        .custom_topping_modal .item-option-popup {
            position: relative;
        }

        .custom_topping_modal .t_main_box {
            padding: 20px 20px;
        }

        .custom_topping_modal .item-option-popup .t_main_box .t_box {
            height: 100%;
        }

        .custom_topping_modal .t_box {
            padding: 0 !important;
            margin: 0 0 30px !important;
            background: none !important;
        }

        .t_box {
            word-break: break-word;
        }

        .custom_topping_modal .topping_max_msg {
            background: #85bd3e;
            padding: 5px 10px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }

        .custom_topping_modal .tbox_heading {
            border-bottom: 1px solid #bcb3aa;
            margin-bottom: 20px;
        }

        .custom_topping_modal .tbox_heading h2 {
            margin-bottom: -2px;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            background: #fffff3;
            float: left;
            padding-right: 5px;
            color: #343436 !important;
        }

        .custom_topping_modal .tbox_heading:after {
            clear: both;
            display: block;
            content: '';
        }

        .custom_topping_modal .topping_header_msg, .custom_topping_modal .topping_footer_msg {
            font-size: 16px !important;
            font-weight: bold !important;
        }

        .custom_topping_modal .topping_header_msg {
            padding: 0 0 10px;
        }

        .custom_topping_modal .selectbox_item {
            margin-bottom: 10px;
            position: relative;
        }

        .custom_topping_modal .selectbox_item>input {
            display: none;
        }

        .custom_topping_modal .selectbox_item label {
            display: block;
            background: #fff;
            border: 1px solid #706d68;
            height: 32px;
            font-size: 16px;
            color: #353535;
            line-height: 30px;
            padding: 0 80px 0 10px;
            cursor: pointer;
        }

        .custom_topping_modal .checkbox_list .checkbox label span, .custom_topping_modal .selectbox_list .selectbox_item label span {
            color: red;
            font-weight: 600;
            font-size: 13px;
        }

        .custom_topping_modal .selectbox_item label {
            line-height: 30px;
        }

        .custom_topping_modal .selectbox_item .selectbox_action {
            position: absolute;
            top: 7px;
            right: 10px;
            display: none;
        }

        .custom_topping_modal .selectbox_item .selectbox_action .no_btn {
            background: #fff;
            width: 18px;
            height: 18px;
            line-height: 18px;
            min-height: 18px;
            font-size: 18px;
            padding: 0;
            font-weight: bold;
        }

        .custom_topping_modal .selectbox_item .selectbox_action .count_no {
            width: 24px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            color: #fff;
        }

        .custom_topping_modal .selectbox_item>input:checked+label {
            background: #fe5e00;
            color: #fff;
            font-weight: bold;
        }

        .custom_topping_modal .selectbox_item>input:checked+label span{
            color: #fff;
            font-weight: bold;
        }

        .custom_topping_modal .selectbox_item>input:checked+label+.selectbox_action .no_btn {
            color: #fe5e00;
        }

        .custom_topping_modal .selectbox_item>input:checked+label+.selectbox_action {
            display: block;
        }

        .custom_topping_modal .item-option-popup .control_btns {
            position: absolute;
            left: -15px;
            bottom: -12px;
            width: 105%;
            margin: 0;
        }

        .custom_topping_modal .control_btns {
            background: #000;
            color: #fff;
            padding: 10px;
        }

        .custom_topping_modal .control_btns .btn {
            background: #5a9b3f!important;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            border-radius: 0;
            text-transform: uppercase;
            padding: 5px 20px;
        }

        .btn_next {
            float: right;
        }

        .custom_topping_modal .control_btns .mob-add-to-cart {
            background: none;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            display: block;
            padding: 9px 120px 0;
        }

        .custom_topping_modal .control_btns:after {
            display: block;
            content: '';
            clear: both;
        }

        .custom_topping_modal .control_btns .mob-add-to-cart:before {
            content: 'Total:';
            display: inline-block;
            margin-right: 5px;
        }

        .modal_loader {
            text-align: center;
            font-size: 15px;
            padding: 15px;
        }

        .custom_topping_modal .checkbox_list:after {
            clear: both;
            display: block;
            content: '';
        }

        .custom_topping_modal .checkbox_list .checkbox>input {
            display: none;
        }

        .custom_topping_modal .checkbox_list .checkbox {
            margin-bottom: 10px;
            width: 33.333333%;
            float: left;
        }

        .custom_topping_modal .checkbox_list .checkbox label {
            font-size: 15px;
            color: #353535;
            position: relative;
            padding-left: 35px;
            height: 20px;
            line-height: 16px;
            display: inline-block;
        }

        .custom_topping_modal .checkbox_list .checkbox label:before {
            content:"\f0c8";
            color: #353535;
            position: absolute;
            left: 0;
            top: -2px;
            display: block;
            font-family: "Font Awesome 5 Free";
            font-weight: 400;
            font-size: 26px;
            line-height: 1;
        }

        .custom_topping_modal .checkbox_list .checkbox>input:checked+label:before {
            content:"\f14a";
            color: #05522e;
            position: absolute;
            left: 0;
            top: -2px;
            display: block;
            font-family: "Font Awesome 5 Free";
            font-weight: 400;
            font-size: 26px;
            line-height: 1;
        }


    </style>

    <!-- Category Popup -->
    <div class="modal fade custom_topping_modal" id="infopopup" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="item-popup-title"></div>
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body item-option-popup">
                </div>
            </div>
        </div>
    </div>
    <!-- Category Popup -->

    <!-- Store Open Close Message Modal -->
    <div class="modal fade" id="pricemodel" tabindex="-1" aria-labelledby="pricemodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-25">
            <div class="modal-content">
                <div class="modal-body p-5 text-danger">
                    Sorry we are close now!
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Store Open Close Message Modal -->


    <!-- User Delivery Type -->
    <input type="hidden" name="user_delivery_val" id="user_delivery_val" value="{{ $userdeliverytype }}">
    <!-- End User Delivery Type -->


   {{-- Header --}}
   @include('frontend.theme.all_themes.header')


    <!-- Mobile View -->
    <sidebar class="mobile-menu">
        <a class="close far fa-times-circle" href="#"></a>
        <a class="logo" href="#slide">
            <img class="img-fluid" src="{{ asset('public/assets/theme2/img/logo/logo.svg') }}" />
        </a>
        <div class="top">
            <ul class="menu">
                <li class="active">
                    <a class="text-uppercase" href="{{ route('home') }}">home</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('member') }}">member</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">contact us</a>
                </li>
            </ul>
        </div>
        <div class="center">
            <ul class="authentication-links">
                <li>
                    <a href="#">
                        <i class="far fa-user"></i><span>Login</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom">
            <div class="working-time">
                <strong class="text-uppercase"> Working Time : </strong>
                <strong>{{ $working_time }}</strong>
            </div>
            <ul class="social-links">
                <li>
                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}"
                        target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}"
                        target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                </li>
            </ul>
        </div>
    </sidebar>
    <!-- End Mobile View -->


    <!-- Main Section -->
    <section class="main-innr">
        <div class="container">
            <div class="main-inner-p">
                <div class="row">
                    <div class="col-md-7 col-lg-8">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="cate-part wow animate__fadeInUp cate-list-part" data-wow-duration="1s">
                                    <div class="category-title">
                                        <h2>Categories</h2>
                                    </div>
                                    <div>
                                        <ul class="box-category">
                                            @foreach ($data['category'] as $category)
                                                @php
                                                    $available_day = isset($category->availibleday) ? explode(',',$category->availibleday) : '';
                                                    $demo = $category->category_id;
                                                    $productcount = getproductcount($demo);
                                                    $catname = strtolower($category->hasOneCategory->name);
                                                @endphp

                                                @if(!empty($available_day) || $available_day != '')
                                                    @if (in_array($current_day,$available_day))
                                                        <li>
                                                            <a href="#{{ str_replace(' ', '', $catname) }}"
                                                                class="active">{{ $category->hasOneCategory->name }}
                                                                ({{ $productcount }})
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="cate-part wow animate__fadeInUp cate-part-select-box" data-wow-duration="1s">
                                    <select class="form-control">
                                        <option>Show All Categories</option>
                                        @foreach ($data['category'] as $category)
                                            <option>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="product-list wow animate__fadeInUp" data-wow-duration="1s">
                                    <div class="product-list-innr">
                                        @foreach ($data['category'] as $key => $value)
                                            @php
                                                $available_day = (isset($value->availibleday)) ? explode(',',$value->availibleday) : '';
                                                $cat_id = isset($value->category_id) ? $value->category_id : '';
                                                $product = getproduct($front_store_id, $cat_id);
                                                $catvalue = strtolower($value->hasOneCategory->name);
                                                $get_cat_top_status = getCatTopStatus($cat_id);

                                            @endphp

                                            @if(!empty($available_day) || $available_day != '')
                                                @if (in_array($current_day,$available_day))
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button" id="{{ str_replace(' ', '', $catvalue) }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1{{ $key }}" aria-expanded="true" aria-controls="collapse1{{ $key }}">
                                                                    <span>{{ (isset($value->hasOneCategory->name)) ? $value->hasOneCategory->name : '' }}</span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </button>
                                                            </h2>
                                                            <div id="collapse1{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                @if (count($product) > 0)
                                                                    @foreach ($product as $values)
                                                                        @php
                                                                            $product_available_day = (isset($values->hasOneProduct['availibleday'])) ? explode(',',$values->hasOneProduct['availibleday']) : '';
                                                                            if(isset($get_cat_top_status['enable_option']))
                                                                            {
                                                                                if($get_cat_top_status['enable_option'] == 1)
                                                                                {
                                                                                    $proID = isset($values->product_id) ? $values->product_id : 0;
                                                                                    $get_product_top_opt = getProductTopOpt($proID);
                                                                                }
                                                                                else
                                                                                {
                                                                                    $get_product_top_opt = '';
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                $get_product_top_opt = '';
                                                                            }


                                                                            $producticon = explode(',',$values->hasOneProduct['product_icons']);
                                                                        @endphp

                                                                        @if (!empty($product_available_day) || $product_available_day != '')
                                                                            @if (in_array($current_day,$product_available_day))
                                                                                <div class="accordion-body">
                                                                                    <div class="acc-body-inr">
                                                                                        <div class="row">
                                                                                            <div class="col-md-7">
                                                                                                <div class="acc-body-inr-title">
                                                                                                    <div style="display: flex;align-items:center;flex-wrap: wrap;">
                                                                                                        <h4>
                                                                                                            {{ $values->hasOneDescription['name'] }}
                                                                                                        </h4>
                                                                                                        <div>
                                                                                                            @foreach ($producticon as $icon)
                                                                                                                @php
                                                                                                                    $proicon = DB::table('oc_product_icons')->select('icon_url')->where('id', $icon)->first();
                                                                                                                @endphp
                                                                                                                <img src="{{ isset($proicon->icon_url) ? $proicon->icon_url : '' }}" style="width: 25px !important;margin:0 !important;">
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    @php
                                                                                                        $prodesc = html_entity_decode($values->hasOneDescription['description']);
                                                                                                    @endphp
                                                                                                    <p>
                                                                                                        {{ strip_tags($prodesc) }}
                                                                                                    </p>
                                                                                                    <img src="{{  $values->hasOneProduct['image'] }}" width="80" height="80" class="mt-2 mb-2">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-5">
                                                                                                <div class="options-bt-main">

                                                                                                    @php
                                                                                                        $sizes = getsize($values->product_id);
                                                                                                    @endphp

                                                                                                    @if (count($sizes) > 0)
                                                                                                        @foreach ($sizes as $size)
                                                                                                            @php
                                                                                                                $sizeprice_id = $size->id_product_price_size;
                                                                                                                $productsize = $values->hasOneProduct['product_id'];
                                                                                                                $size_id = isset($size->id_size) ? $size->id_size : '';

                                                                                                                if($userdeliverytype == 'delivery')
                                                                                                                {
                                                                                                                    $setsizeprice = ($size->delivery_price == 0) ? $size->price : $size->delivery_price;
                                                                                                                }
                                                                                                                elseif ($userdeliverytype == 'collection')
                                                                                                                {
                                                                                                                    $setsizeprice = ($size->collection_price == 0) ? $size->price : $size->collection_price;
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    $setsizeprice = $size->price;
                                                                                                                }
                                                                                                            @endphp

                                                                                                            <div class="options-bt">
                                                                                                                <div class="row align-items-center">
                                                                                                                    <div class="col-md-5">
                                                                                                                        <span>{{ html_entity_decode(isset($size->hasOneToppingSize['size']) ? $size->hasOneToppingSize['size'] : '') }}</span>
                                                                                                                    </div>
                                                                                                                    <div class="col-md-7">
                                                                                                                        @if($store_open_close == 'open')
                                                                                                                            @if ($new_module_status == 1)
                                                                                                                                @if ($setsizeprice == 0)
                                                                                                                                    <button class="btn options-btn" style="cursor: not-allowed;pointer-events: auto;opacity:0.5" disabled>
                                                                                                                                        <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                    </button>
                                                                                                                                @else
                                                                                                                                    @if ($session_flag_code != '' || !empty($session_flag_code))
                                                                                                                                        <a class="btn options-btn cartstatus" onclick="show_model(this,event)" data-id_cat="{{ $cat_id }}" data-id_product="{{ $values->product_id }}" rel="{{ $sizeprice_id }}">
                                                                                                                                            <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </a>
                                                                                                                                    @else
                                                                                                                                        <a onclick="$('#Modal').modal('show');" class="btn options-btn cartstatus">
                                                                                                                                            <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </a>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                @if ($get_cat_top_status['enable_option'] == 1)
                                                                                                                                    @if ($setsizeprice == 0)
                                                                                                                                        <button class="btn options-btn" style="cursor: not-allowed;pointer-events: auto;opacity:0.5" disabled>
                                                                                                                                            <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </button>
                                                                                                                                    @else
                                                                                                                                        @if (count($get_product_top_opt) > 0 && $get_product_top_opt != '')
                                                                                                                                            {{-- <a data-bs-toggle="modal" data-bs-target="#freeItem_{{ $sizeprice_id }}" class="btn options-btn cartstatus">
                                                                                                                                                <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                            </a> --}}
                                                                                                                                            @if ($session_flag_code != '' || !empty($session_flag_code))
                                                                                                                                                <a data-bs-toggle="modal" data-bs-target="#freeItem_{{ $sizeprice_id }}" class="btn options-btn cartstatus">
                                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                                </a>
                                                                                                                                            @else
                                                                                                                                                {{-- <a data-bs-toggle="modal" data-bs-target="#newfreeItem_{{ $proID }}" class="btn options-btn cartstatus"> --}}
                                                                                                                                                <a onclick="$('#Modal').modal('show');" class="btn options-btn cartstatus">
                                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                                </a>
                                                                                                                                            @endif

                                                                                                                                            {{-- Dynamic Model --}}
                                                                                                                                            <div class="modal fade free-item-modal_{{ $sizeprice_id }}" id="freeItem_{{ $sizeprice_id }}" tabindex="-1" aria-labelledby="freeItem_{{ $sizeprice_id }}Label" aria-hidden="true">
                                                                                                                                                <div class="modal-dialog">
                                                                                                                                                    <div class="modal-content" id="item-modal">
                                                                                                                                                        <div class="modal-header">
                                                                                                                                                            <h5 class="modal-title text-center" id="freeItem_{{ $sizeprice_id }}Label">{{ $values->hasOneDescription['name'] }}</h5>
                                                                                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="modal-body">
                                                                                                                                                            <form id="top_form_{{ $sizeprice_id }}">
                                                                                                                                                                @csrf
                                                                                                                                                                @foreach ($get_product_top_opt as $proTop)
                                                                                                                                                                    @php
                                                                                                                                                                        $topcount = $loop->iteration;
                                                                                                                                                                        $tName = isset($proTop->hasOneTopping['name_topping']) ? $proTop->hasOneTopping['name_topping'] : '';
                                                                                                                                                                        $typeTopping = isset($proTop->typetopping) ? $proTop->typetopping : '';
                                                                                                                                                                        $top_pro_id = $proTop->id;
                                                                                                                                                                        $id_group_topping = isset($proTop->id_group_topping) ? $proTop->id_group_topping : '';

                                                                                                                                                                        $get_sub_topping = getSubTopping($id_group_topping);

                                                                                                                                                                        $toppingreq = unserialize($get_cat_top_status->group);  // required

                                                                                                                                                                    @endphp

                                                                                                                                                                    <div class="accordion{{ $top_pro_id }}" id="accordionExample{{ $top_pro_id }}">
                                                                                                                                                                        <div class="accordion-item{{ $top_pro_id }}">
                                                                                                                                                                            <h2 class="accordion-header{{ $top_pro_id }}" id="headingOne{{ $top_pro_id }}">
                                                                                                                                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefree{{ $top_pro_id }}" aria-expanded="true" aria-controls="collapsefree{{ $top_pro_id }}">
                                                                                                                                                                                    <span style="width: 100%!important">{{ $tName }}</span>
                                                                                                                                                                                </button>
                                                                                                                                                                            </h2>
                                                                                                                                                                            <div id="collapsefree{{ $top_pro_id }}" class="accordion-collapse collapse" aria-labelledby="headingOne{{ $top_pro_id }}"
                                                                                                                                                                                data-bs-parent="#accordionExample{{ $top_pro_id }}">
                                                                                                                                                                                <div class="accordion-body">
                                                                                                                                                                                    @if ($typeTopping == 'select')
                                                                                                                                                                                        {{-- <select class="form-control" name="select_top[]" {{ ($toppingreq[1]['set_require'] == 1) ? 'required' : ''}}>  required --}}
                                                                                                                                                                                        <select class="form-control" name="select_top[]">
                                                                                                                                                                                            @if (!empty($get_sub_topping) || $get_sub_topping != '')
                                                                                                                                                                                                <option value=""> -- --</option>
                                                                                                                                                                                                @foreach ($get_sub_topping as $stop)
                                                                                                                                                                                                    <option value="{{ $stop->name }}">{{ $stop->name }}</option>
                                                                                                                                                                                                @endforeach
                                                                                                                                                                                            @endif
                                                                                                                                                                                        </select>
                                                                                                                                                                                    @else
                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                            @if (!empty($get_sub_topping) || $get_sub_topping != '')
                                                                                                                                                                                                @foreach ($get_sub_topping as $key=> $stop)
                                                                                                                                                                                                    <div class="col-md-6">
                                                                                                                                                                                                        <label>{{ $stop->name }}</label>
                                                                                                                                                                                                        <input type="checkbox" name="check_top" id="{{ $stop->name }}" value="{{ $stop->name }}">
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                @endforeach
                                                                                                                                                                                            @endif
                                                                                                                                                                                        </div>
                                                                                                                                                                                    @endif
                                                                                                                                                                                </div>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        {{-- <div class="">
                                                                                                                                                                            <b>Add your special request?</b><br>
                                                                                                                                                                            <textarea  name="request" rows="5" style="width: 465px"></textarea>
                                                                                                                                                                        </div> --}}
                                                                                                                                                                    </div>
                                                                                                                                                                @endforeach
                                                                                                                                                            </form>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="modal-footer text-center">
                                                                                                                                                            <button type="button" onclick="addToCart({{ $values->product_id }},{{ $sizeprice_id }},{{ $userid }},'model');" class="btn">Add To Cart</button>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            {{-- End Dynamic Model --}}

                                                                                                                                        @else
                                                                                                                                            <a onclick="addToCart({{ $values->product_id }},{{ $sizeprice_id }},{{ $userid }});"
                                                                                                                                                class="btn options-btn cartstatus">
                                                                                                                                                <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                            </a>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                @else
                                                                                                                                    @if ($setsizeprice == 0)
                                                                                                                                        <button class="btn options-btn" style="cursor: not-allowed;pointer-events: auto;opacity:0.5" disabled>
                                                                                                                                            <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </button>
                                                                                                                                    @else
                                                                                                                                        <a onclick="addToCart({{ $values->product_id }},{{ $sizeprice_id }},{{ $userid }});"
                                                                                                                                            class="btn options-btn cartstatus">
                                                                                                                                            <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </a>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        @else
                                                                                                                            <a class="btn options-btn" data-bs-toggle="modal" data-bs-target="#pricemodel">
                                                                                                                                <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                            </a>
                                                                                                                        @endif

                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                    @else
                                                                                                        @php
                                                                                                            if($userdeliverytype == 'delivery')
                                                                                                            {
                                                                                                                $setprice = ($values->hasOneProduct['delivery_price'] == 0) ? $values->hasOneProduct['price'] : $values->hasOneProduct['delivery_price'];
                                                                                                            }
                                                                                                            elseif ($userdeliverytype == 'collection')
                                                                                                            {
                                                                                                                $setprice = ($values->hasOneProduct['collection_price'] == 0) ? $values->hasOneProduct['price'] : $values->hasOneProduct['collection_price'];
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                $setprice = $values->hasOneProduct['price'];
                                                                                                            }
                                                                                                        @endphp
                                                                                                        <div class="options-bt">
                                                                                                            <div class="row align-items-center">
                                                                                                                <div class="col-md-5">
                                                                                                                    <span>price</span>
                                                                                                                </div>
                                                                                                                <div class="col-md-7">
                                                                                                                    @if($store_open_close == 'open')
                                                                                                                        @if ($new_module_status == 1)
                                                                                                                            @if ($setprice != 0)
                                                                                                                                @if ($session_flag_code != '' || !empty($session_flag_code))
                                                                                                                                    {{-- <a data-bs-toggle="modal" data-bs-target="#newfreeItem_{{ $proID }}" class="btn options-btn cartstatus">
                                                                                                                                        <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                    </a> --}}
                                                                                                                                    <a class="btn options-btn cartstatus" onclick="show_model(this,event)" data-id_cat="{{ $cat_id }}" data-id_product="{{ $proID }}" rel="0">
                                                                                                                                        <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}
                                                                                                                                            <i class="fa fa-shopping-basket"></i>
                                                                                                                                        </span>
                                                                                                                                    </a>
                                                                                                                                @else
                                                                                                                                    {{-- <a data-bs-toggle="modal" data-bs-target="#newfreeItem_{{ $proID }}" class="btn options-btn cartstatus"> --}}
                                                                                                                                    <a onclick="$('#Modal').modal('show');" class="btn options-btn cartstatus">
                                                                                                                                        <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                    </a>
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                <a class="btn options-btn" style="cursor: not-allowed;pointer-events: auto; opacity:0.5;" disabled>
                                                                                                                                    <span class="sizeprice hide-carttext text-white 9">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                </a>
                                                                                                                            @endif
                                                                                                                        @else
                                                                                                                            @if (isset($get_cat_top_status['enable_option']))
                                                                                                                                @if ($get_cat_top_status['enable_option'] == 1)
                                                                                                                                    @if ($setprice != 0)
                                                                                                                                        @if (count($get_product_top_opt) > 0 && $get_product_top_opt != '')
                                                                                                                                            @if ($session_flag_code != '' || !empty($session_flag_code))
                                                                                                                                                <a data-bs-toggle="modal" data-bs-target="#newfreeItem_{{ $proID }}" class="btn options-btn cartstatus">
                                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                                </a>
                                                                                                                                            @else
                                                                                                                                                {{-- <a data-bs-toggle="modal" data-bs-target="#newfreeItem_{{ $proID }}" class="btn options-btn cartstatus"> --}}
                                                                                                                                                <a onclick="$('#Modal').modal('show');" class="btn options-btn cartstatus">
                                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                                </a>
                                                                                                                                            @endif

                                                                                                                                            {{-- Dynamic Model --}}
                                                                                                                                            <div class="modal fade newfree-item-modal_{{ $proID }}" id="newfreeItem_{{ $proID }}" tabindex="-1" aria-labelledby="newfreeItem_{{ $proID }}Label" aria-hidden="true">
                                                                                                                                                <div class="modal-dialog">
                                                                                                                                                    <div class="modal-content" id="item-modal">
                                                                                                                                                        <div class="modal-header">
                                                                                                                                                            <h5 class="modal-title text-center" id="newfreeItem_{{ $proID }}Label">{{ $values->hasOneDescription['name'] }}</h5>
                                                                                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="modal-body">
                                                                                                                                                            <form id="new_top_form_{{ $proID }}">
                                                                                                                                                                @csrf
                                                                                                                                                                @foreach ($get_product_top_opt as $proTop)
                                                                                                                                                                    @php

                                                                                                                                                                        $tName = isset($proTop->hasOneTopping['name_topping']) ? $proTop->hasOneTopping['name_topping'] : '';
                                                                                                                                                                        $typeTopping = isset($proTop->typetopping) ? $proTop->typetopping : '';
                                                                                                                                                                        $top_pro_id = $proTop->id;
                                                                                                                                                                        $id_group_topping = isset($proTop->id_group_topping) ? $proTop->id_group_topping : '';

                                                                                                                                                                        $get_sub_topping = getSubTopping($id_group_topping);

                                                                                                                                                                    @endphp

                                                                                                                                                                    <div class="accordion{{ $top_pro_id }}" id="accordionExample{{ $top_pro_id }}">
                                                                                                                                                                        <div class="accordion-item{{ $top_pro_id }}">
                                                                                                                                                                            <h2 class="accordion-header{{ $top_pro_id }}" id="headingOne{{ $top_pro_id }}">
                                                                                                                                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefree{{ $top_pro_id }}" aria-expanded="true" aria-controls="collapsefree{{ $top_pro_id }}">
                                                                                                                                                                                    <span style="width: 100%!important">{{ $tName }}</span>
                                                                                                                                                                                </button>
                                                                                                                                                                            </h2>
                                                                                                                                                                            <div id="collapsefree{{ $top_pro_id }}" class="accordion-collapse collapse" aria-labelledby="headingOne{{ $top_pro_id }}"
                                                                                                                                                                                data-bs-parent="#accordionExample{{ $top_pro_id }}">
                                                                                                                                                                                <div class="accordion-body">
                                                                                                                                                                                    @if ($typeTopping == 'select')
                                                                                                                                                                                        <select class="form-control" name="select_top[]">
                                                                                                                                                                                            @if (!empty($get_sub_topping) || $get_sub_topping != '')
                                                                                                                                                                                                <option value=""> -- --</option>
                                                                                                                                                                                                @foreach ($get_sub_topping as $stop)
                                                                                                                                                                                                    <option value="{{ $stop->name }}">{{ $stop->name }}</option>
                                                                                                                                                                                                @endforeach
                                                                                                                                                                                            @endif
                                                                                                                                                                                        </select>
                                                                                                                                                                                    @else
                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                            @if (!empty($get_sub_topping) || $get_sub_topping != '')
                                                                                                                                                                                                @foreach ($get_sub_topping as $key=> $stop)
                                                                                                                                                                                                    <div class="col-md-6">
                                                                                                                                                                                                        <label>{{ $stop->name }}</label>
                                                                                                                                                                                                        <input type="checkbox" name="check_top" id="{{ $stop->name }}" value="{{ $stop->name }}">
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                @endforeach
                                                                                                                                                                                            @endif
                                                                                                                                                                                        </div>
                                                                                                                                                                                    @endif
                                                                                                                                                                                </div>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                        {{-- <div class="">
                                                                                                                                                                            <b>Add your special request?</b><br>
                                                                                                                                                                            <textarea  name="request" rows="5" style="width: 465px"></textarea>
                                                                                                                                                                        </div> --}}
                                                                                                                                                                    </div>
                                                                                                                                                                @endforeach
                                                                                                                                                            </form>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="modal-footer text-center">
                                                                                                                                                            <button type="button" onclick="addToCart({{ $values->product_id }},0,{{ $userid }},'model');" class="btn">Add To Cart</button>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            {{-- End Dynamic Model --}}

                                                                                                                                        @else
                                                                                                                                            <a onclick="addToCart({{ $values->product_id }},0,{{ $userid }});" class="btn options-btn cartstatus">
                                                                                                                                                <span class="sizeprice hide-carttext text-white 8">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                            </a>
                                                                                                                                        @endif
                                                                                                                                    @else
                                                                                                                                        <a class="btn options-btn" style="cursor: not-allowed;pointer-events: auto; opacity:0.5;" disabled>
                                                                                                                                            <span class="sizeprice hide-carttext text-white 9">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </a>
                                                                                                                                    @endif
                                                                                                                                @else
                                                                                                                                    @if ($setprice != 0)
                                                                                                                                        <a onclick="addToCart({{ $values->product_id }},0,{{ $userid }});" class="btn options-btn cartstatus">
                                                                                                                                            <span class="sizeprice hide-carttext text-white 10">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </a>
                                                                                                                                    @else
                                                                                                                                        <a class="btn options-btn" style="cursor: not-allowed;pointer-events: auto; opacity:0.5;" disabled>
                                                                                                                                            <span class="sizeprice hide-carttext text-white 11">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                        </a>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                @if ($setprice != 0)
                                                                                                                                    <a onclick="addToCart({{ $values->product_id }},0,{{ $userid }});" class="btn options-btn cartstatus">
                                                                                                                                        <span class="sizeprice hide-carttext text-white 10">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                    </a>
                                                                                                                                @else
                                                                                                                                    <a class="btn options-btn" style="cursor: not-allowed;pointer-events: auto; opacity:0.5;" disabled>
                                                                                                                                        <span class="sizeprice hide-carttext text-white 11">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                    </a>
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        @endif
                                                                                                                    @else
                                                                                                                        <a class="btn options-btn" data-bs-toggle="modal" data-bs-target="#pricemodel">
                                                                                                                            <span class="sizeprice hide-carttext text-white 12">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                        </a>
                                                                                                                    @endif
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4">
                        <div class="cart-part wow animate__fadeInUp" data-wow-duration="1s">

                            @if($store_open_close == 'open')
                                <div class="alert p-1 text-center" style="background: green;">
                                    <h2 class="p-1 text-white mb-0">We are open now.</h2>
                                </div>
                            @else
                                <div class="close-shop text-center">
                                    <h2>Sorry, We are closed now !</h2>
                                    {{-- <span>We will be opening back at {{ $opentime }} Today</span> --}}
                                </div>
                            @endif

                            <div class="mob-view-main">
                                <div class="mob-view" id="mob-view">
                                    <span class="tg-icon" id="tg-icon"><i class="fas fa-angle-double-up"></i></span>
                                    <div class="mob-basket">0 X ITEMS | TOTAL: {{ $currency }}0.00</div>
                                </div>
                                <div class="minicart" id="minicart">
                                    <div class="minibox-title">
                                        <h3>My Basket</h3>
                                        <i class="fa fa-shopping-basket"></i>
                                    </div>
                                    <div class="minibox-content">
                                        <div class="empty-box">
                                            <table class="table">
                                                @php
                                                    $subtotal = 0;
                                                @endphp
                                                @if (!empty($mycart['size']) || !empty($mycart['withoutSize']))
                                                    @if (isset($mycart['size']))
                                                        @foreach ($mycart['size'] as $key => $cart)
                                                            @php
                                                                // Price
                                                                if($userdeliverytype == 'delivery')
                                                                {
                                                                    $price = isset($cart['del_price']) ? $cart['del_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                }
                                                                else if($userdeliverytype == 'collection')
                                                                {
                                                                    $price = isset($cart['col_price']) ? $cart['col_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                }
                                                                else
                                                                {
                                                                    $price = isset($cart['main_price']) ? $cart['main_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                }

                                                                $subtotal += $price;

                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <i onclick="deletecartproduct({{ $cart['product_id'] }},{{ $key }},{{ $userid }})" class="fa fa-times-circle text-danger" style="cursor: pointer"></i>
                                                                </td>
                                                                <td>{{ $cart['quantity'] }}x</td>
                                                                @if (!empty($cart['size']) || $cart['size'] != '')
                                                                <td>{{ html_entity_decode($cart['size']) }}</td>
                                                                @else
                                                                <td>{{'-'}}</td>
                                                                @endif
                                                                <td>{{ $cart['name'] }} <br>
                                                                    @if (isset($cart['topping']) && !empty($cart['topping']))
                                                                        @foreach ($cart['topping'] as $ctop)
                                                                            <span>- {{ $ctop }}</span><br>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td>{{ $currency }}{{ $price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    @if (isset($mycart['withoutSize']))
                                                        @foreach ($mycart['withoutSize'] as $cart)
                                                            @php
                                                                // Price
                                                                if($userdeliverytype == 'delivery')
                                                                {
                                                                    $price = $cart['del_price'] * $cart['quantity'];
                                                                }
                                                                elseif($userdeliverytype == 'collection')
                                                                {
                                                                    $price = $cart['col_price'] * $cart['quantity'];
                                                                    // $price = isset($cart['col_price']) ? $cart['col_price'] : 1 * $cart['quantity'];
                                                                }
                                                                else
                                                                {
                                                                    $price = $cart['main_price'] * $cart['quantity'];

                                                                }
                                                                $subtotal += $price;


                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <i class="fa fa-times-circle text-danger" onclick="deletecartproduct({{ $cart['product_id'] }},0,{{ $userid }})" style="cursor: pointer"></i>
                                                                </td>
                                                                <td>{{ $cart['quantity'] }}x</td>
                                                                <td colspan="2">{{ $cart['name'] }}<br>
                                                                    @if (isset($cart['topping']) && !empty($cart['topping']))
                                                                        @foreach ($cart['topping'] as $ctop)
                                                                            <span>- {{ $ctop }}</span><br>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td>{{ $currency }}{{ $price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <span>Your shopping cart is empty!</span>
                                                @endif
                                            </table>
                                        </div>
                                        @php

                                            $couponcode = 0;
                                            if (!empty($Coupon) || $Coupon != '')
                                            {
                                                if( $Coupon['total'] <= $subtotal){
                                                    if ($Coupon['type'] == 'P')
                                                    {
                                                        $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                    }
                                                    if ($Coupon['type'] == 'F')
                                                    {
                                                        $couponcode = $Coupon['discount'];
                                                    }
                                                }
                                                $total = $subtotal - $couponcode;
                                            }
                                            else
                                            {

                                                $total = $subtotal;
                                            }
                                            // echo '<pre>';
                                            // print_r($couponcode);
                                            // exit();
                                        @endphp
                                        <div class="minicart-total">
                                            <ul class="minicart-list">
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr sub-total">
                                                        <label>Sub-Total</label>
                                                        @if (isset($subtotal))
                                                            <span>{{ $currency }} {{ $subtotal }}</span>
                                                        @else
                                                            <span>{{ $currency }} {{ $subtotal }}</span>
                                                        @endif
                                                    </div>
                                                </li>

                                                @if ($userdeliverytype == 'delivery')
                                                    <li class="minicart-list-item">
                                                        <div class="minicart-list-item-innr">
                                                            <label>Delivery</label>
                                                                <span class="del-charge">{{ $currency }} {{ $delivery_charge }}</span>
                                                        </div>
                                                    </li>
                                                @endif

                                                @if (($Coupon != '' || !empty($Coupon)) && (isset($mycart['size']) && !empty($mycart['size'])) || (isset($mycart['withoutSize']) && !empty($mycart['withoutSize'])) && ($couponcode != 0))
                                                    <li class="minicart-list-item">
                                                        {{-- @if (($Coupon != '' || !empty($Coupon)))
                                                            @if ($couponcode != 0) --}}
                                                                <div class="minicart-list-item-innr coupon_code d-flex">
                                                                    @if (($Coupon != '' || !empty($Coupon)) && $couponcode !== 0)
                                                                        <label id="coupontext">Coupon({{ $Coupon['code'] }})</label>
                                                                        <span>{{ $currency }}-{{   (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2))  }}</span>
                                                                    @endif
                                                                </div>
                                                             {{-- @endif
                                                        @endif --}}
                                                        <div class="minicart-list-item-innr addcoupon">
                                                            <label>
                                                                @if ($couponcode != 0)
                                                                    <a style="color: #ff0000;font-size:14px;"
                                                                        onclick="showcoupon();">
                                                                        Change Coupon Code
                                                                    </a>
                                                                @else
                                                                    <a class="Applynew_coupon" style="color: #ff0000;font-size:14px;"
                                                                        onclick="showcoupon();">
                                                                        Apply Coupon Code
                                                                    </a>
                                                                @endif
                                                                </label>
                                                            </div>
                                                        {{-- <div class="minicart-list-item-innr d-flex coupon_code 2"></div> --}}
                                                        {{-- <div class="minicart-list-item-innr addcoupon addnewcoupon" style="display: none">
                                                            <label>
                                                                <a style="color: #ff0000;font-size:14px;" onclick="showcoupon();">
                                                                    Change Coupon Code
                                                                </a>
                                                            </label>
                                                        </div> --}}
                                                        <div class="minicart-list-item-innr">
                                                            <div class="showcoupons">
                                                                <form method="POST" id="from_showcoupon">
                                                                    @csrf
                                                                    <div class="myDiv" style="display: none;">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <input style="float:left;padding:5px 2px" type="text" name="coupon" value="" id="searchcoupon" placeholder="Enter your coupon here" class="coupon-val ">
                                                                            </div>
                                                                            <div class="col-md-4 text-right">
                                                                                <input style="text-transform: uppercase;" type="submit" value="Apply" class="btn btn-danger ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="error"></div>
                                                                                <div id="success"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="minicart-list-item coupon-code">
                                                        <div class="minicart-list-item-innr d-flex coupon_code"></div>
                                                        {{-- <div class="minicart-list-item-innr addcoupon addnewcoupon" style="display: none"> --}}
                                                        <div class="minicart-list-item-innr addcoupon addnewcoupon">
                                                            {{-- <label>
                                                                <a style="color: #ff0000;font-size:14px;" onclick="showcoupon();">Apply Coupon Code</a>
                                                            </label> --}}
                                                            @if ($couponcode != 0)
                                                                <a style="color: #ff0000;font-size:14px;"
                                                                    onclick="showcoupon();">
                                                                    Change Coupon Code
                                                                </a>
                                                            @else
                                                                <a class="Applynew_coupon" style="color: #ff0000;font-size:14px;"
                                                                    onclick="showcoupon();">
                                                                    Apply Coupon Code
                                                                </a>
                                                            @endif
                                                        </div>
                                                        {{-- <div class="minicart-list-item-innr changecoupon" style="display: none">
                                                            <label><a style="color: #ff0000;font-size:14px;" onclick="showcoupon();">Chenge Coupon Code</a></label>
                                                        </div> --}}
                                                        <div class="minicart-list-item-innr addnewcoupon">
                                                            <div class="showcoupons">
                                                                <form method="POST" id="from_showcoupon">
                                                                    <div class="myDiv" style="display:none;">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <input style="float:left;padding:5px 2px" type="text" name="coupon" value="" id="searchcoupon" placeholder="Enter your coupon here" class="coupon-val ">
                                                                            </div>
                                                                            <div class="col-md-4 text-right">
                                                                                <input style="text-transform: uppercase;" type="submit" value="Apply" class="btn btn-danger ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="error"></div>
                                                                                <div id="success"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif


                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr total">
                                                        <label>Total to pay:</label>
                                                        <span>{{ $currency }} {{ ($total <= 0) ? 0 : $total }}</span>
                                                    </div>
                                                </li>
                                                <li class="minicart-list-item" id="freeItem">
                                                    @if(!empty($cart_rule_total) || $cart_rule_total != '')
                                                        @if ($subtotal >= $cart_rule_total)
                                                            @php
                                                                $free_explode = isset($cart_rule['id_item']) ? explode(':',$cart_rule['id_item']) : '';
                                                                $free_items = getFreeItems($free_explode);
                                                            @endphp
                                                            <div class="form-group">
                                                                <label>Please Choose Your Free Items</label>
                                                                <select name="free_item" id="free_item" class="form-control mt-1" onchange="changeFreeItem()">
                                                                    @if (!empty($free_items) || $free_items != '')
                                                                        @foreach ($free_items as $key => $fitem)
                                                                            <option value="{{ $fitem }}" {{ ($session_free_item == $fitem) ? 'selected' : '' }}>{{ $fitem }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="order_type_top" class="order-type">
                                            {{-- If Select Collection and Both --}}
                                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                                <div class="form-check m-auto">
                                                    {{-- When Only Collection Method Then Show this Btn --}}
                                                    @if ($delivery_setting['enable_delivery'] == 'collection')
                                                        <input class="form-check-input collection_delivery_button" uriFrom="menu" type="radio" name="delivery_type" id="collection" {{ $delivery_setting['enable_delivery'] == 'collection' ? 'checked' : '' }} value="collection" typeAttr="collection">

                                                    {{-- When Both Method and collection and Delivery Then show this button --}}
                                                    @else
                                                        <input class="form-check-input collection_delivery_button" uriFrom="menu" type="radio" name="delivery_type" id="collection" value="collection" {{ ($userdeliverytype == 'collection') ? 'checked' : '' }} typeAttr="collection">
                                                    @endif
                                                    <label class="form-check-label" for="collection">
                                                        <h6>Collection</h6>
                                                    </label><br>
                                                    <span>{{ $collection_gap }}  Min</span>
                                                </div>
                                            @endif

                                            {{-- If Select Delivery and Both --}}
                                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                                <div class="form-check m-auto">
                                                    {{-- <input class="form-check-input" type="radio" name="delivery_type" id="delivery" {{ $userdeliverytype == 'delivery' ? 'checked' : '' }}> --}}
                                                    @if ($userdeliverytype == 'delivery')
                                                        <input class="form-check-input" type="radio" value="delivery" name="delivery_type" {{ $userdeliverytype == 'delivery' ? 'checked' : '' }}>
                                                    @else
                                                        <input class="form-check-input" type="radio" value="delivery" name="delivery_type" id="delivery" {{ $userdeliverytype == 'delivery' ? 'checked' : '' }}>
                                                    @endif
                                                    <label class="form-check-label" for="delivery">
                                                        <h6>Delivery</h6>
                                                    </label><br>
                                                    <span>{{ $delivery_gap }} Min</b></span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($store_open_close == 'open')
                                @if (!empty($mycart) && count($mycart) > 0)
                                    @if ($userdeliverytype == 'delivery')
                                        @if ($total >= $minimum_spend_total)
                                            <a href="{{ route('checkout') }}" class="btn checkbt" style="cursor: pointer">Checkout</a>
                                        @else
                                            <div class="disable-cls">
                                                <div class="closed-now pt-0">
                                                    <a class="btn checkbt" style="pointer-events: auto;
                                                    cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                                                </div>
                                                <div class="closed-now minimum_spend">
                                                    <span class="closing-text 1" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend_total,2)}}.</span>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('checkout') }}" class="btn checkbt">Checkout</a>
                                        <div class="closed-now">
                                            <span class="closing-text 2" style="color: green !important;">WE ARE OPEN NOW!</span>
                                        </div>
                                    @endif
                                @else
                                    @if ($userdeliverytype == 'delivery')
                                        <div class="disable-cls">
                                            <div class="closed-now pt-0">
                                                <a class="btn checkbt" style="pointer-events: auto;
                                                cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                                            </div>
                                            <div class="closed-now minimum_spend">
                                                <span class="closing-text 1" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend_total,2)}}.</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="closed-now pt-0">
                                           <div class="disable-cls">
                                                <a class="btn checkbt" style="pointer-events: auto; cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                                           </div>
                                        </div>
                                    @endif
                                @endif
                            @else
                                <div class="closed-now">
                                    <button class="btn w-100 checkbt" disabled style="cursor: not-allowed; pointer-events: auto; color:black;">Checkout</button>
                                    <div class="closed-now">
                                        <span class="closing-text 5">We are closed now !</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Section -->


    <!-- Delivery Type Modal -->
    <div class="modal fade csmodal" id="pricemodel" tabindex="-1" aria-labelledby="pricemodelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="pricemodelLabel">Order Now</h5>
                    <p>Minimum delivery is {{ $currency }}15.00</p>
                    <button class="btn csmodal-btn" onclick="showmodal();">Deliver my order</button>
                    <button class="btn csmodal-btn" data-bs-dismiss="modal">I will come and collect</button>
                    <button type="button" class="btn csmodal-btn-close" data-bs-dismiss="modal">Cancel and go
                        back</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delivery Type Modal -->


    <!-- Delivery Type Modal -->
    <input type="hidden" name="total" id="total" value="{{ $subtotal }}">
    <div class="modal fade csmodal" id="Modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="delete" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <h5 class="modal-title" id="ModalLabel">Please Enter Your Post Code</h5>
                        <div class="controls">
                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                <div class="srch-input">
                                    @if ($delivery_setting['delivery_option'] == 'area')
                                        <select name="search_input2" class="form-control" id="search_store">
                                            <option value="">Select Areas</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area }}">{{ $area }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input id="search_input1" placeholder="AB10 1BW" type="text" />
                                        <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                    @endif

                                    <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>

                                </div>
                                <div class="enter_postcode">
                                    <p>Please enter your postcode to view our menu and place an order</p>
                                </div>
                            @endif
                        </div>
                        @if ($delivery_setting['enable_delivery'] != 'delivery')
                            <a class="btn csmodal-btn collection_delivery_button" uriFrom="menu" typeAttr="collection">I will come and Collect</a>
                        @endif
                        @if ($delivery_setting['enable_delivery'] != 'collection')
                            @if($delivery_setting['delivery_option'] == 'area')
                                <a class="btn csmodal-btn collection_delivery_button" typeAttr="delivery" uriFrom="menu" delOpt="areaname">Deliver my order</a><br>
                            @else
                                <a class="btn csmodal-btn collection_delivery_button" typeAttr="delivery" uriFrom="menu" delOpt="postcodes">Deliver my order</a><br>
                            @endif
                        @endif
                        <button type="button" class="btn csmodal-btn-close" id="tested" data-bs-dismiss="modal">Cancel and go back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delivery Type Modal -->


    {{-- Footer --}}
    @include('frontend.theme.all_themes.footer')

    <!-- JS -->
    @include('frontend.include.script')
    <!-- End JS -->





    <!-- Custom JS -->
    <script type="text/javascript">

        var ordertype = $("input[name='delivery_type']:checked").val();

        var coll1 = $("input[name='delivery_type']:checked").val();

        var loader_data = '<div class="modal_loader">';
        loader_data += '<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>';
        loader_data += '</div>';
        var categories_arr = {};
        var toppings = {};
        categories_arr = <?= json_encode($categories_arr) ?>;
        toppings = <?= json_encode($p_toppings) ?>;

        var user_id = 0;
        user_id = <?= json_encode($userid) ?>;


        // New Module
        function show_model(el,event)
        {
            var product_id = $(el).attr('data-id_product');
            var category_id = $(el).attr('data-id_cat');
            var size_id = $(el).attr('rel');

            $.ajax({
                type: 'post',
                url: '{{ url('newModulegetTopping') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'size_id': size_id,
                    'product_id': product_id,
                    'category_id': category_id,
                },
                dataType: 'json',
                success: function(data)
                {
                    if(data.noresults)
                    {
                        addToCart(product_id,size_id,user_id);
                    }
                    else
                    {
                        $('.item-option-popup').html(loader_data);
                        $('#infopopup').modal('show');
                        $('.popup-chk').addClass('modal-open');
                        $(this).closest('.item').find('div.enablepopup').after('<div class="ui-widget-overlay" style="width: 1284px; height: 6110px; z-index: 1001;"></div>');
                        products = data;
                        html_data = create_option_html(el, products);
                        $('.item-option-popup').css("display","block");
                        $('.item-option-popup').html(html_data);
                    }

                }
            });
        }


        // Create Option HTML Function
        function create_option_html(el, products)
        {
            var product_id = $(el).attr('data-id_product');
            var category = categories_arr[product_id];
            var product_detail = products['product_detail'];
            var topping_price_id = $(el).attr('rel');

            if(typeof(category) == 'undefined')
            {
                $('#infopopup').modal('hide');
                addToCart(product_id,topping_price_id,user_id);
                return false;
            }

            if(typeof(products) == 'undefined')
            {
                $('#infopopup').modal('hide');
                addToCart(product_id,topping_price_id,user_id);
                return false;
            }

            var product_topings = products.toppings;
            var loop_counter = 0;
            var html_data = '<form id="newModuleForm" onsubmit="return false;"><input type="hidden" name="id_cat" id="id_cat" value="'+category.category_id+'" />';
            html_data += '<input type="hidden" name="quantity" class="qty" value="1" />';
            html_data += '<input type="hidden" id="size_base" name="size_base" value=""  />';
            html_data += '<input type="hidden" id="finl_price" name="finl_price" value=""  />';
            html_data += '<input type="hidden" id="extra_price" name="extra_price" value="0"  />';

            var html_header = '<span>'+products.name+'</span> > '+products.product_name;
            $('.item-popup-title').html(html_header);

            var p_length = Object.keys(products.options_group).length;

            var max_key = Math.max(...Object.keys(products.options_group));

            if(products.enable_boxcomment == '1' &&  products['options_group'][max_key + 1] != 'textarea_div')
            {
                products['options_group'][max_key + 1] = ['textarea_div'];
            }

            p_length = Object.keys(products.options_group).length;


            $.each(products['options_group'], function(index,product_arr)
            {
                var pre_div = loop_counter - 1;
                var next_div = loop_counter + 1;

                html_data += '<div class="t_main_box" iam="div_'+loop_counter+'"';
                if(loop_counter != 0 )
                {
                    html_data += 'style="display:none;"';
                }

                html_data += '>';
                html_data += '<div class = "t_middle_box">';

                show_disable = 0;

                $.each(product_arr,function(i, product)
                {
                    if(product.set_require == 1)
                    {
                        show_disable = 1;
                    }

                    if(product != 'textarea_div')
                    {
                        var topping_detail = products.toppings_detail[product.id_group_option];
                        html_data +='<div class="t_box" topping_id = "'+product.id_group_option+'">';

                        if(product.set_type == 'button_box')
                        {
                            html_data += create_select(product.id_group_option, product_id,topping_price_id, i+1, products.toppings[product.id_group_option], topping_detail, product,product.id);
                        }

                        if(product.set_type == 'tick_boxes')
                        {
                            html_data += create_checkbox(product.id_group_option,{max:product.max_check,min:product.min_check}, products.toppings[product.id_group_option], topping_detail, product, topping_price_id,product.id);
                            html_data += '<div class="sub_option"></div>';

                            if(product.min_check>0)
                            {
                                error = true;
                            }
                        }

                        html_data += "</div>";
                    }
                    else
                    {
                        html_data +='<div class="t_box">';
                        html_data += create_textarea(product_id);
                        html_data += '</div>';
                    }
                });

                html_data += "</div>";
                html_data += '<div class="control_btns">';

                if(loop_counter != '0')
                {
                    html_data += '<button onclick="show_div(this,\'back\')" target_is="div_'+pre_div+'" class="btn btn_back">Back</button>';
                }

                var disabled = '';

                if(show_disable)
                {
                    disabled = 'disabled = "disabled"';
                }

                if(loop_counter != p_length - 1)
                {
                    html_data += '<button onclick="show_div(this,\'next\')" target_is="div_'+next_div+'" class="btn btn_next ';

                    if(show_disable)
                    {
                        html_data += "btn_disabled";
                    }
                    html_data += '" '+disabled+'>Next</button>';
                }
                else
                {
                    html_data += '<button type="button" class="btn btn_next" onclick="addToCartTest('+product_id+','+topping_price_id+', '+el+')">Add</button>'
                }

                var product_price = $(el).find('.sizeprice').text();

                html_data += '<div class="button mob-add-to-cart" data-id_cat="'+ category +'" data-id_product="'+ product_id +'" title="Add" >';
                html_data += '<span class="sizeprice text-white hide-carttext total_pay_price" base_price="'+product_price+'">'+product_price +'</span><span class="show-carttext sizeprice" style="display: none;">Added</span>';
                html_data += '</div>';
                html_data += '</div>';
                html_data += "</div></form>";
                loop_counter++;
            });
            return html_data;
        }


        function addToCartTest(product_id,size,el)
        {
            var myFormData = new FormData(document.getElementById('newModuleForm'));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'post',
                url: '{{ url('addToCartTests') }}',
                data:myFormData ,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if(data.success == 1)
                    {
                        var select_check_array = data.topping_names;
                        var extra_price = data.extra_price;
                        var new_model = 1;

                        $.ajax({
                            type: 'post',
                            url: '{{ route("getid") }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'size_id': size,
                                'product_id': product_id,
                                'user_id': user_id,
                                'select_check_array': select_check_array,
                                'topping': 1,
                                'new_model':1,
                                'extra_price':extra_price,
                            },
                            dataType: 'json',
                            success: function(result)
                            {
                                $('#infopopup').modal('hide');

                                // Cart Data
                                $('.empty-box').html('');
                                $('.empty-box').append(result.html);

                                // Sub Total
                                $('.sub-total').html('');
                                $('.sub-total').append(result.subtotal);

                                // Cart Products
                                $('#cart_products').html('');
                                $('#cart_products').append(result.cart_products);

                                // Total Amount
                                $('.total').html('');
                                $('.total').append(result.total);

                                $('#total').val(result.sub_total);

                                // Header Total
                                $('.pirce-value').text('');
                                $('.pirce-value').append(result.headertotal);

                                if (result.couponcode_name != '' && result.couponcode_amount != '')
                                {
                                    $('.coupon_code').html('');
                                    $('.coupon_code').html('<label id="coupontext">Coupon('+ result.couponcode_name +')</label><span>-'+ result.couponcode_amount +'</span>');
                                    $('.Applynew_coupon').css('display','block');
                                    // $('.changecoupon').css('display','block');
                                    $('.addnewcoupon').css('display','block');

                                }
                                else
                                {
                                    $('.coupon_code').css('display','none');
                                    $('.addnewcoupon').css('display','block');
                                }


                                // Free Items
                                $('#freeItem').html('');
                                $('#freeItem').append(result.cart_rule_html);

                                // $('#top_form_'+sizeprice).trigger("reset");
                                // $('#freeItem_'+sizeprice).modal('hide');

                                if (result.min_spend == 'true')
                                {
                                    var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(newBtn);
                                }
                                else if(result.min_spend == 'false')
                                {
                                    var html = `<div class="closed-now pt-0">
                                        <a class="btn checkbt" style="pointer-events: auto;
                                        cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                                    </div>
                                    <div class="closed-now minimum_spend">
                                        <span class="closing-text 1" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend_total,2)}}.</span>
                                    </div>`;
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(html);
                                }
                                else
                                {
                                    var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(newBtn);
                                }

                                // Delivery Charge
                                $('.del-charge').html('');
                                $('.del-charge').append(result.delivery_charge);
                            }
                        });
                    }
                }
            });

        }

        // Create Select
        function create_select(id, product_id , topping_price_id = '', group_key, toppings_arr, topping_detail, option_group,p_id)
        {
            var data = '';

            if(option_group.topping_rename!='')
            {
                var topping_name = option_group.topping_rename;
            }
            else{
                var topping_name = topping_detail['name_topping'];
            }

            var topping_header_message = topping_detail['topping_header_message']
            var topping_message_color  = topping_detail['group_title_color'];
            var topping_footer_message = topping_detail['topping_footer_message'];
            var topping_id = topping_detail['id_topping_option'];
            var topping_options = '';
            var topping = toppings[id];
            var topping_id = '';

            var category = categories_arr[product_id];
            var topping_price = '';
            var no_free = option_group.no_free;

            if(topping_price_id != '' && topping_price_id != 'undefined' && category.group != 'undefined' && typeof(category.group[group_key]) != 'undefined' && typeof(category.group[group_key]['size']) != 'undefined')
            {
                topping_price = category.group[group_key]['size'][topping_price_id];
            }

            if(typeof(toppings_arr) != 'undefined')
            {
                $.each(toppings_arr, function(i, t){

                    topping_options += '<div class="selectbox_item ets-option-'+id+'_'+topping_id;

                    if(option_group.set_option == 2)
                    {
                        topping_options += " option_two "
                    }

                    if(option_group.set_require == 1)
                    {
                        topping_options += " required_optn ";
                    }

                    if(option_group.price != 0)
                    {
                        topping_price_main = option_group.price;
                    }
                    else
                    {
                        topping_price_main = t.price_main;
                    }

                    if(topping_price_main == '0.00')
                    {
                        topping_price = 'free'
                    }
                    else
                    {
                        topping_price = topping_price_main
                    }

                    topping_options += '"';
                    topping_options += ' max_check = "'+option_group.max_check+'"';
                    topping_options += ' min_check = "'+option_group.min_check+'"';

                    topping_options += '>';
                    topping_options += '<input type="radio" id="radio'+t["id_topping_option"]+'" name="topping['+id+'][id]" value="'+t["id_topping_option"]+'" onchange="set_error(this);" price="'+topping_price_main+'" no_free="'+option_group.no_free+'"><label for="radio'+t["id_topping_option"]+'">'+t["name"]+' <span class="red">+'+topping_price+'</span></label>';
                    topping_options += '<div class="selectbox_action">'
                    topping_options += '<input type="hidden" name="count['+id+'][]" min="1" value="1" price="'+topping_price_main+'">';
                    topping_options += '<button onclick="change_no(this,\'dec\', '+group_key+','+ option_group.max_check +','+option_group.min_check+')" class="no_btn dec">-</button>';
                    topping_options += '<span class="count_no">1</span>';
                    topping_options += '<button onclick="change_no(this,\'inc\', '+group_key+','+ option_group.max_check +','+ option_group.min_check+')" class="no_btn inc">+</button>';
                    topping_options += '</div>';
                    topping_options += '</div>';
                });

                data += '<input type="hidden" class="mapping_ids" name="mapping_ids['+id+']" value="'+p_id+'">';
                data += '<input type="hidden" class="topping-qty" name="topping['+id+'][qty]" value="0"/>';

                data += '<div class="row">';

                if(option_group.max_check>0)
                {
                    data += '<div class="col-md-6 text-center topping_max_msg"> Please select up to '+option_group.max_check+' quantity</div>';
                }

                if(no_free > 0)
                {
                    data += '<div data-val='+no_free+' id = "free-option" class="col-md-6 text-center topping_max_msg"> Please select up to '+no_free+' options free</div>';
                }

                data += '</div>';

                data += '<div class="tbox_heading"><h2>'+topping_name+'</h2></div>' ;
                data += '<div class="topping_header_msg" style="color:'+topping_message_color+'">'+topping_header_message+'</div>';
                data += '<div class="selectbox_list" topping_price="'+topping_price+'">';
                data += '<button onclick="reset_radio(this);" style="margin:10px 0;"> Reset</button>';
                data += topping_options;
                data += '</div>';
                data += '<div class="topping_footer_msg" style="color:'+topping_message_color+'">'+topping_footer_message+'</div>';
            }
            return data;
        }


        // Set Error Function
        function set_error(elem)
        {
            var div = $('.t_main_box:visible');
            var required_names = [];
            var error_counts = 0;

            var required_divs = div.find('.required_optn');

            $.each(required_divs, function(i, ele )
            {
                var ele_name = $(ele).find('input').attr('name');
                if(required_names.indexOf(ele_name) == -1)
                {
                    required_names.push(ele_name);
                }
            });

            $.each(required_names, function(i, name)
            {
                if($('input[name="'+name+'"]:checked').length < 1){
                    error_counts++;
                }
            });


            var checkbox_list_arr = div.find('.checkbox_list');

            $(checkbox_list_arr).each(function(i, check_list)
            {
                var min_no = $(check_list).attr('min-check');
                var max_no = $(check_list).attr('max-check');
                var checked_box = $(check_list).find('input[type="checkbox"]:checked').length;

                if(checked_box < min_no && $(check_list).attr('check-required') == 'true')
                {
                    error_counts++;
                }

                if( checked_box > max_no && max_no!=0 && $(check_list).attr('check-required') == 'true')
                {
                    error_counts++;
                }

                if(checked_box == max_no && max_no != 0)
                {
                    $(check_list).find('input[type="checkbox"]:not(:checked)').siblings('label').addClass('checkbox_disabled');
                    $(check_list).find('input[type="checkbox"]:not(:checked)').attr('disabled', true);
                }

                if(checked_box < max_no)
                {
                    $(check_list).find('input[type="checkbox"]:not(:checked)').siblings('label').removeClass('checkbox_disabled');
                    $(check_list).find('input[type="checkbox"]:not(:checked)').attr('disabled', false);
                }

                var free_val = $('#free-option').attr('data-val');

                if(free_val > 0)
                {
                    if(free_val > checked_box)
                    {
                        $('#free-option').css('display','inline-block');
                        var new_free_val = parseInt(free_val) - parseInt(checked_box);
                        var freemsg = 'Please select up to '+new_free_val+' options free';
                        $('#free-option').text(freemsg);
                    }
                    else
                    {
                        $('#free-option').css('display','none');
                    }
                }
            });

            if($(elem).attr("type") == "radio")
            {
                var count_no = $(elem).parent('div.selectbox_item').find('.selectbox_action').find('span').html()
                var select_min_no = $(elem).parent('.selectbox_item').attr('min_check');
                var select_max_no = $(elem).parent('.selectbox_item').attr('max_check');

                if(count_no < select_min_no)
                {
                    error_counts++;
                }

                if(count_no == select_max_no)
                {
                    $(elem).parent('div.selectbox_item').find('.selectbox_action').find('button.inc').attr("disabled","disabled")
                }
            }

            if(error_counts > 0)
            {
                error = true;
                set_next_button(0);
            }
            else
            {
                error = false;
                set_next_button(1);
            }
            calculate_total_price();
        }


        // Create Checkbox
        function create_checkbox(id,obj, toppings_arr, topping_detail, option_group,size_id='',p_id)
        {
            var topping_name = topping_detail['name_topping'];
            var topping_header_message = topping_detail['topping_header_message']
            var topping_message_color  = topping_detail['group_title_color'];
            var topping_footer_message = topping_detail['topping_footer_message'];
            var topping_id = topping_detail['id_topping_option'];
            var data = '';

            var topping_rename = option_group.topping_rename;
            var no_free = option_group.no_free;

            if(topping_rename !='')
            {
                topping_name = topping_rename;
            }

            var topping_options = '';
            var lineTitle = '';

            if(typeof(toppings_arr) != 'undefined')
            {
                var requiredCheck = false;

                $.each(toppings_arr, function(i, t)
                {

                    topping_options += '<div class="checkbox ';

                    if(option_group.set_require == 1)
                    {
                        topping_options += " required_optn ";
                        requiredCheck = true;
                    }

                    if(option_group.price != 0)
                    {
                        topping_price = option_group.price;
                    }
                    else
                    {
                        topping_price = t.price_main;
                    }

                    if(topping_price == '0.00')
                    {
                        topping_price_name = 'free'
                    }
                    else
                    {
                        topping_price_name = topping_price
                    }

                    topping_options += '"';
                    topping_options += ' max_check = "'+option_group.max_check+'"';
                    topping_options += ' min_check = "'+option_group.min_check+'"';
                    topping_options += '>';
                    topping_options += '<input type="checkbox" id="check_'+id+'_'+i+'" class="topping_check   topping_count_'+id+'" toppin-atr = "'+id+'" name="topping['+id+'][]" value="'+t['id_topping_option']+'" onchange="set_error(this);" price = "'+topping_price+'" no_free="'+option_group.no_free+'"><label class="" for="check_'+id+'_'+i+'">'+t['name']+' <span class="red">+'+topping_price_name+'</span></label>';
                    topping_options += '</div>';
                });

                // data += '<input type="hidden" class="mapping_ids" name="mapping_ids['+id+']" value="'+p_id+'">';

                data += '<div class="row">';

                if(obj.max>0)
                {
                    data += '<div class="col-md-6 text-center topping_max_msg"> Please select up to '+obj.max+' options</div>';
                }

                if(no_free > 0)
                {
                    data += '<div data-val='+no_free+' id = "free-option" class="col-md-6 text-center topping_max_msg"> Please select up to '+no_free+' options free</div>';
                }

                data += '</div>';

                data += '<div class="tbox_heading"><h2>'+topping_name+'</h2></div>' ;
                data += '<div class="topping_header_msg" style="color:'+topping_message_color+'">'+topping_header_message+'</div>';
                data += '<div class="checkbox_list ets-option-'+id+'_'+topping_id;

                if(option_group.set_option == 2)
                {
                    data += " option_two ";
                }

                data += '" max-check="'+obj.max+'" min-check="'+obj.min+'" check-required="'+requiredCheck+'">';
                data += topping_options;
                data += '</div>';
            }
            return data;
        }


        // Create Sub Option
        function create_sub_option(ele)
        {
            id = $(ele).attr('topping_id');
            id_arr = id.split('_');
            html_data = create_checkbox(id);
            $(ele).closest('.t_box').find('.sub_option').html(html_data);
        }


        // Create TextArea
        function create_textarea(product_id)
        {
            var data = '';
            data += '<div class="request-'+product_id+' etsproduct_'+product_id+'">';
            data += '<b class="request_ets">Add your special request?</b>';
            data += '<textarea maxlength="100" name="request" rows="5"></textarea>' ;
            data += '</div>';
            return data;
        }


        // Reset New Module Topping
        function reset_radio(el)
        {
            $(el).closest('.t_box').find('input[type="radio"]').prop('checked',false);
            $(el).closest('.t_box').find('.selectbox_action input[type="hidden"]').val('1');
            $(el).closest('.t_box').find('.selectbox_action .count_no').html('1');
            // set_error(el);
        }


        // New Module Quantity
        function change_no(ele,action, index, max_check, min_check)
        {
            var hidden = $(ele).siblings('input:hidden');
            var count_ele = $(ele).siblings('span.count_no');

            var no = parseInt(hidden.val());

            var select = $(ele).siblings('select');
            var price = select.attr('topping_price');
            var total_price = parseFloat($('.total_pay_price').html().substr(1));

            $(ele).siblings('button').removeAttr("disabled")

            current_topping_id = $(ele).closest('.t_box').attr("topping_id")

            if(action == 'inc')
            {
                no++;
                if(no == max_check)
                {
                    $(ele).attr("disabled","disabled")
                }

                $('input[name="topping['+current_topping_id+'][qty]"]').val(no);

                if(price != "")
                {
                    updated_price = parseFloat(price) * parseFloat(no);
                    total_price = total_price + updated_price;
                }
            }

            if(action == 'dec' && no > 1)
            {
                no--;
                $('input[name="topping['+current_topping_id+'][qty]"]').val(no);

                if(price != "")
                {
                    updated_price = parseFloat(price) * no;
                    total_price = total_price - updated_price;
                }
            }


            if(no < min_check)
            {
                error = true;
                set_next_button(0);
            }
            else
            {
                error = false;
                set_next_button(1);
            }

            $('.total_pay_price').html('£'+total_price);
            hidden.val(no);
            count_ele.html(no);
            calculate_total_price();
        }


        // New Module Set Next Button
        function set_next_button(status)
        {
            var div = $('.t_main_box:visible');

            var next_btn = div.find('.btn_next');

            if(status == 0)
            {
                next_btn.attr('disabled', true);
                next_btn.addClass('btn_disabled');
            }

            if(status == 1)
            {
                next_btn.attr('disabled', false);
                next_btn.removeClass('btn_disabled');
            }
        }


        // Function for Show Div
        function show_div(ele, action)
        {
            var div = $(ele);
            var all_div = $('.t_main_box');
            var target_div = $("[iam="+div.attr('target_is')+"");
            all_div.hide();
            target_div.show();
        }


        // Document Script
        $(document).ready(function()
        {
            var status = $('#user_delivery_val').val();
            var coll = $("input[name='delivery_type']:checked").val();

            if (coll == 'collection')
            {
                $('#Modal').modal('hide');
                return false;
            }

            if (status == '')
            {
                $('#Modal').modal('show');
            }

            updateCart(ordertype);

        });
        // End Document Script


        // Calculate Total Pricr
        function calculate_total_price()
        {
            var total_price = parseFloat($('.total_pay_price').attr('base_price').substr(1));
            var checked_checkbox = $('.item-option-popup input[type="checkbox"]:checked');
            var checked_radio = $('.item-option-popup input[type="radio"]:checked');
            var extra_price = 0;

            $(checked_checkbox).each(function(i, e)
            {
                var getid = $(e).attr('toppin-atr');
                var new_checkbox = $('.topping_count_'+getid+':checked').length;
                no_free = $('.topping_count_'+getid).attr('no_free');

                if(new_checkbox > no_free && new_checkbox > i)
                {
                    if(i == no_free || i > no_free)
                    {
                        price = $(e).attr('price');
                        total_price += parseFloat(price);
                        extra_price +=  parseFloat(price);
                    }
                }
            });

            $(checked_radio).each(function(i, e)
            {
                price = $(e).attr('price');
                var count_no = parseFloat($(e).siblings('.selectbox_action').find('.count_no').html());
                no_free = $(e).attr('no_free');
                if(count_no > no_free)
                {
                    var to_add_price = price * (count_no - no_free) ;
                    total_price += parseFloat(to_add_price);
                    extra_price += parseFloat(to_add_price);
                }
            });

            $('.total_pay_price').html('£'+total_price);
            $('#extra_price').val('');
            $('#extra_price').val(extra_price);
        }


        // Show Modal
        function showmodal()
        {
            $('#Modal').modal('show');
            $('#pricemodel').modal('hide');
        }
        // End Show Modal


        // Show Modal Product
        function showmodalproduct()
        {
            $('#Modal').modal('show');
        }
        // End Show Modal


        // Add to Cart
        function addToCart(product, sizeprice, uid ,str)
        {
            var model = str;
            var sizeid = sizeprice;
            var productid = product;
            var userid = uid;
            var status = $('#user_delivery_val').val();
            var coll = $("input[name='delivery_type']:checked").val();


            if (coll == 'collection')
            {
                $('#Modal').modal('hide');
            }
            else
            {
                if (status == '')
                {
                    $('#Modal').modal('show');
                    return false;
                }
            }

            if(model == 'model')
            {
                if(sizeprice != 0)
                {
                    var form_data = new FormData(document.getElementById('top_form_'+sizeprice));

                    var chckbox = form_data.getAll('check_top');
                    var drpdwn = form_data.getAll('select_top[]');

                    if(chckbox != '' || drpdwn != '')
                    {

                        $.ajax({
                            type: 'post',
                            url: '{{ route("getid") }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'size_id': sizeid,
                                'product_id': productid,
                                'user_id': userid,
                                'checkbox': chckbox,
                                'drpdwn': drpdwn,
                                'topping': 1,
                            },
                            dataType: 'json',
                            success: function(result)
                            {

                                // Cart Data
                                $('.empty-box').html('');
                                $('.empty-box').append(result.html);

                                // Sub Total
                                $('.sub-total').html('');
                                $('.sub-total').append(result.subtotal);

                                // Cart Products
                                $('#cart_products').html('');
                                $('#cart_products').append(result.cart_products);

                                // Total Amount
                                $('.total').html('');
                                $('.total').append(result.total);

                                $('#total').val(result.sub_total);

                                // Header Total
                                $('.pirce-value').text('');
                                $('.pirce-value').append(result.headertotal);

                                if (result.couponcode_name != '' && result.couponcode_amount != '')
                                {
                                    $('.coupon_code').html('');
                                    $('.coupon_code').html('<label id="coupontext">Coupon('+ result.couponcode_name +')</label><span>-'+ result.couponcode_amount +'</span>');
                                    $('.Applynew_coupon').css('display','block');
                                    // $('.changecoupon').css('display','block');
                                    $('.addnewcoupon').css('display','block');

                                }
                                else
                                {
                                    $('.coupon_code').css('display','none');
                                    $('.addnewcoupon').css('display','block');
                                }


                                // Free Items
                                $('#freeItem').html('');
                                $('#freeItem').append(result.cart_rule_html);

                                $('#top_form_'+sizeprice).trigger("reset");
                                $('#freeItem_'+sizeprice).modal('hide');

                                if (result.min_spend == 'true')
                                {
                                    var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(newBtn);
                                }
                                else if(result.min_spend == 'false')
                                {
                                    var html = `<div class="closed-now pt-0">
                                        <a class="btn checkbt" style="pointer-events: auto;
                                        cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                                    </div>
                                    <div class="closed-now minimum_spend">
                                        <span class="closing-text 1" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend_total,2)}}.</span>
                                    </div>`;
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(html);
                                }
                                else
                                {
                                    var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(newBtn);
                                }

                                // Delivery Charge
                                $('.del-charge').html('');
                                $('.del-charge').append(result.delivery_charge);
                            }
                        });
                    }
                    else
                    {
                        $('#top_form_'+sizeprice).trigger("reset");
                        $('#freeItem_'+sizeprice).modal('hide');
                    }

                    return false;
                }
                else
                {
                    var form_data = new FormData(document.getElementById('new_top_form_'+product));

                    var chckbox = form_data.getAll('check_top');
                    var drpdwn = form_data.getAll('select_top[]');

                    if(chckbox != '' || drpdwn != '')
                    {
                        $.ajax({
                            type: 'post',
                            url: '{{ route("getid") }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'size_id': sizeid,
                                'product_id': productid,
                                'user_id': userid,
                                'checkbox': chckbox,
                                'drpdwn': drpdwn,
                                'topping': 1,
                            },
                            dataType: 'json',
                            success: function(result)
                            {
                                console.log(result);

                                // Cart Data
                                $('.empty-box').html('');
                                $('.empty-box').append(result.html);

                                // Sub Total
                                $('.sub-total').html('');
                                $('.sub-total').append(result.subtotal);

                                // Cart Products
                                $('#cart_products').html('');
                                $('#cart_products').append(result.cart_products);

                                // Total Amount
                                $('.total').html('');
                                $('.total').append(result.total);
                                $('#total').val(result.sub_total);

                                // Header Total
                                $('.pirce-value').text('');
                                $('.pirce-value').append(result.headertotal);

                                 // Delivery Charge
                                $('.del-charge').html('');
                                $('.del-charge').append(result.delivery_charge);

                                if (result.couponcode_name != '' && result.couponcode_amount != '')
                                {
                                    $('.coupon_code').html('');
                                    $('.coupon_code').html('<label id="coupontext">Coupon('+ result.couponcode_name +')</label><span>-'+ result.couponcode_amount +'</span>');
                                    $('.Applynew_coupon').css('display','block');
                                    // $('.changecoupon').css('display','block');
                                    $('.addnewcoupon').css('display','block');

                                }
                                else
                                {
                                    $('.coupon_code').css('display','none');
                                    $('.addnewcoupon').css('display','block');
                                }

                                // Free Items
                                $('#freeItem').html('');
                                $('#freeItem').append(result.cart_rule_html);

                                $('#new_top_form_'+product).trigger("reset");
                                $('#newfreeItem_'+product).modal('hide');

                                if (result.min_spend == 'true')
                                {
                                    var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(newBtn);
                                }
                                else if(result.min_spend == 'false')
                                {
                                    var html = `<div class="closed-now pt-0">
                                        <a class="btn checkbt" style="pointer-events: auto;
                                        cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                                    </div>
                                    <div class="closed-now minimum_spend">
                                        <span class="closing-text 1" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend_total,2)}}.</span>
                                    </div>`;
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(html);
                                }
                                else
                                {
                                    var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                                    $('.disable-cls').html('');
                                    $('.disable-cls').html(newBtn);
                                }
                            }
                        });
                    }
                    else
                    {
                        $('#new_top_form_'+product).trigger("reset");
                        $('#newfreeItem_'+product).modal('hide');
                    }

                    return false;
                }

            }

            $.ajax({
                type: 'post',
                url: '{{ route("getid") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'size_id': sizeid,
                    'product_id': productid,
                    'user_id': userid,
                },
                dataType: 'json',
                success: function(result)
                {
                    $('#infopopup').modal('hide');

                    // Cart Data
                    $('.empty-box').html('');
                    $('.empty-box').append(result.html);

                    // Sub Total
                    $('.sub-total').html('');
                    $('.sub-total').append(result.subtotal);

                    // Cart Products
                    $('#cart_products').html('');
                    $('#cart_products').append(result.cart_products);

                    // Total Amount
                    $('.total').html('');
                    $('.total').append(result.total);

                    $('#total').val(result.sub_total);

                    // Header Total
                    $('.pirce-value').text('');
                    $('.pirce-value').append(result.headertotal);

                    // Delivery Charge
                    $('.del-charge').html('');
                    $('.del-charge').append(result.delivery_charge);

                    if (result.couponcode_name != '' && result.couponcode_amount != '')
                    {
                        $('.coupon_code').html('');
                        $('.coupon_code').html('<label id="coupontext">Coupon('+ result.couponcode_name +')</label><span>-'+ result.couponcode_amount +'</span>');
                        $('.Applynew_coupon').css('display','block');
                        $('.addnewcoupon').css('display','block');
                    }
                    else
                    {
                        $('.coupon_code').css('display','none');
                        $('.addnewcoupon').css('display','block');
                    }

                    // Free Items
                    $('#freeItem').html('');
                    $('#freeItem').append(result.cart_rule_html);

                    if (result.min_spend == 'true')
                    {
                        var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                        $('.disable-cls').html('');
                        $('.disable-cls').html(newBtn);
                    }
                    else if(result.min_spend == 'false')
                    {
                        var html = `<div class="closed-now pt-0">
                            <a class="btn checkbt" style="pointer-events: auto;
                            cursor: not-allowed; opacity: 0.5!important;" disabled>Checkout</a>
                        </div>
                        <div class="closed-now minimum_spend">
                            <span class="closing-text 1" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend_total,2)}}.</span>
                        </div>`;
                        $('.disable-cls').html('');
                        $('.disable-cls').html(html);
                    }
                    else
                    {
                        var newBtn = '<a href="{{ route("checkout") }}" class="btn checkbt" style="cursor: pointer">Checkout</a>';
                        $('.disable-cls').html('');
                        $('.disable-cls').html(newBtn);
                    }
                }
            });
        }
        // End Add to Cart


        $('#delivery').on('click', function()
        {
            $(this).prop('checked', false);
            if (!$('#collection').is(':checked') && coll1 != undefined) {
                $('#collection').prop('checked', true);
            }

            $('#delivery').filter(':radio').removeAttr('checked');
            $('#Modal').modal('show');
        });
        // End Delivery Button


        // Delete Cart Product
        function deletecartproduct(prod_id, size_id, uid)
        {
            var sizeid = size_id;
            var productid = prod_id;
            var userid = uid;

            $.ajax({
                type: 'post',
                url: '{{ url('deletecartproduct') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'size_id': sizeid,
                    'product_id': productid,
                    'user_id': userid,
                },
                dataType: 'json',
                success: function(result)
                {
                    location.reload();
                }
            });
        }
        // End Delete Cart Product



        // Show & Hide Coupon Toggle
        function showcoupon()
        {
            $('.myDiv').toggle();
        }
        // End Show & Hide Coupon Toggle


        // Apply Coupon
        $('#from_showcoupon').submit(function(e)
        {
            $('#applycpn').css('display' , 'inline-block');
            e.preventDefault();
            var coupon = $("input[name='coupon']").val();
            let subtotal = $('#total').val();
            //   alert(total)


            $.ajax({
                type: 'post',
                url: '{{ url('getcoupon') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'coupon': coupon,
                    'total': subtotal,
                },
                dataType: 'json',
                success: function(result)
                {
                    console.log(result.min_spend)
                    console.log(result.headertotal)
                    $('#applycpn').css('display', 'none');
                    if (result.errors == 1)
                    {
                        $('#error').html('');
                        $('#error').append(result.errors_message);
                        $('#from_showcoupon').trigger('reset');
                        setTimeout(() => {
                            $('#error').html('');
                        }, 5000);
                    }



                    if (result.success == 1)
                    {

                            if (result.headertotal >= result.min_spend) {

                                $('.disabled_checkout_btn').removeClass('disabled');
                                $('.minimum_spend').html('');
                            }
                            else{

                                    $('.disabled_checkout_btn').addClass('disabled');
                                    // $('.minimum_spend').html('<span class="closing-text" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format(0,2)}}.</span>');
                            }


                        // console.log(result);
                        // alert(result.couponcode)
                        $('#success').html('');
                        $('#success').append(result.success_message);

                        // Coupon Code
                        // $('.coupon_code').html('');
                        // $('.coupon_code').append(result.couponcode);
                        if (result.couponcode_name != '' && result.couponcode_amount != '') {

                            $('.coupon_code').html('');
                            // $('.coupon_code').css('display','block');
                            $('.coupon_code').html('<label id="coupontext">Coupon('+ result.couponcode_name +')</label><span>-'+ result.couponcode_amount +'</span>');
                            $('.Applynew_coupon').css('display','block');
                            // $('.addnewcoupon').css('display','block');
                            // $('.changecoupon').css('display','block');
                        }
                        else{
                            $('.coupon_code').css('display','none');
                            $('.addnewcoupon').css('display','block');
                        }


                        // Total
                        $('.total').html('');
                        $('.total').append(result.total);

                        $('#total').val(result.subtotal);
                        // Header Total
                        $('.pirce-value').text('');
                        $('.pirce-value').append(result.headertotal);

                        $('#from_showcoupon').trigger('reset');

                        setTimeout(() => {
                            $('#success').html('');
                            $('.myDiv').hide();
                        }, 2000);
                    }
                }
            });
        });
        // End Apply Coupon


        // Mobile View
        $("#mob-view").click(function()
        {
            TestsFunction();
            myFunction();
        });
        // End Mobile View


        function TestsFunction()
        {
            var T = document.getElementById("minicart"),
                displayValue = "";
            if (T.style.display == "")
                displayValue = "block";

            T.style.display = displayValue;
            myFunction();
        }

        function myFunction()
        {
            if ($("#minicart").is(":visible")) {
                $("#tg-icon").html('<i class="fas fa-angle-double-down"></i>');
            } else {
                $("#tg-icon").html('<i class="fas fa-angle-double-up"></i>');
            }
        }



        // Change Free Item
        function changeFreeItem(){
            var item = $('#free_item :selected').val();

            $.ajax({
                type: 'post',
                url: '{{ url("changeFreeItem") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'item': item,
                },
                dataType: 'json',
                success: function(result)
                {
                    if(result.success == 1)
                    {
                        console.log('Free Item Change Successfully..');
                    }

                    if(result.error == 0)
                    {
                        console.log('Free Item Change Successfully..');
                    }
                }
            });
        }


    </script>
    <!-- End Custom JS -->


</body>
</html>
