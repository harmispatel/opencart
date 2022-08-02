{{--
THIS IS View Menu  PAGE FOR FRONTEND
----------------------------------------------------------------------------------------------
menu.blade.php
It's used for View Menu.
----------------------------------------------------------------------------------------------
--}}



@php

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
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

    // Get Customer Cart
    if (session()->has('userid'))
    {
        $userid = session()->get('userid');
        $mycart = getuserCart(session()->get('userid'));

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

    // echo '<pre>';
    // print_r(session()->all());
    // exit();
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
                                                $available_day = isset($value->availibleday) ? explode(',',$value->availibleday) : '';
                                                $cat_id = $value->category_id;
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
                                                                    <span>{{ $value->hasOneCategory->name }}</span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </button>
                                                            </h2>
                                                            <div id="collapse1{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                @foreach ($product as $values)
                                                                    @php
                                                                        $product_available_day = isset($values->hasOneProduct['availibleday']) ? explode(',',$values->hasOneProduct['availibleday']) : '';
                                                                        if($get_cat_top_status == 1)
                                                                        {
                                                                            $proID = isset($values->product_id) ? $values->product_id : 0;
                                                                            $get_product_top_opt = getProductTopOpt($proID);
                                                                        }
                                                                        else
                                                                        {
                                                                            $get_product_top_opt = '';
                                                                        }
                                                                    @endphp

                                                                    @if (!empty($product_available_day) || $product_available_day != '')
                                                                        @if (in_array($current_day,$product_available_day))
                                                                            <div class="accordion-body">
                                                                                <div class="acc-body-inr">
                                                                                    <div class="row">
                                                                                        <div class="col-md-7">
                                                                                            <div class="acc-body-inr-title">
                                                                                                <h4>
                                                                                                    {{ $values->hasOneDescription['name'] }}
                                                                                                </h4>
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

                                                                                                            if($userdeliverytype == 'delivery')
                                                                                                            {
                                                                                                                $setsizeprice = $size->delivery_price;
                                                                                                            }
                                                                                                            elseif ($userdeliverytype == 'collection')
                                                                                                            {
                                                                                                                $setsizeprice = $size->collection_price;
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
                                                                                                                        @if ($get_cat_top_status == 1)
                                                                                                                            @if ($setsizeprice == 0)
                                                                                                                                <button class="btn options-btn" style="cursor: not-allowed;pointer-events: auto;opacity:0.5" disabled>
                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                </button>
                                                                                                                            @else
                                                                                                                                @if (count($get_product_top_opt) > 0 && $get_product_top_opt != '')
                                                                                                                                    <a data-bs-toggle="modal" data-bs-target="#freeItem_{{ $sizeprice_id }}" class="btn options-btn cartstatus">
                                                                                                                                        <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                    </a>

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
                                                                                                                                                                                <select class="form-control" name="select_top">
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
                                                                                                                                                    <a onclick="addToCart({{ $values->product_id }},{{ $sizeprice_id }},{{ $userid }},'model');" class="btn">Add To Cart</a>
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
                                                                                                                    @else
                                                                                                                        <a class="btn options-btn" data-bs-toggle="modal" data-bs-target="#pricemodel">
                                                                                                                            <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                            <span class="show-carttext sizeprice" style="display: none;">Added<i class="fa fa-check"></i></span>
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
                                                                                                            $setprice = $values->hasOneProduct['delivery_price'];
                                                                                                        }
                                                                                                        elseif ($userdeliverytype == 'collection')
                                                                                                        {
                                                                                                            $setprice = $values->hasOneProduct['collection_price'];
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
                                                                                                                    @if ($get_cat_top_status == 1)
                                                                                                                        @if ($setprice != 0)
                                                                                                                            @if (count($get_product_top_opt) > 0 && $get_product_top_opt != '')

                                                                                                                                <a data-bs-toggle="modal" data-bs-target="#newfreeItem_{{ $proID }}" class="btn options-btn cartstatus">
                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                </a>

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
                                                                                                                                                                            <select class="form-control" name="select_top">
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
                                                                                                                                                <a onclick="addToCart({{ $values->product_id }},0,{{ $userid }},'model');" class="btn">Add To Cart</a>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                {{-- End Dynamic Model --}}

                                                                                                                            @else
                                                                                                                                <a onclick="addToCart({{ $values->product_id }},0,{{ $userid }});" class="btn options-btn cartstatus">
                                                                                                                                    <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                                </a>
                                                                                                                            @endif
                                                                                                                        @else
                                                                                                                            <a class="btn options-btn" style="cursor: not-allowed;pointer-events: auto; opacity:0.5;" disabled>
                                                                                                                                <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                            </a>
                                                                                                                        @endif
                                                                                                                    @else
                                                                                                                        @if ($setprice != 0)
                                                                                                                            <a onclick="addToCart({{ $values->product_id }},0,{{ $userid }});" class="btn options-btn cartstatus">
                                                                                                                                <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                            </a>
                                                                                                                        @else
                                                                                                                            <a class="btn options-btn" style="cursor: not-allowed;pointer-events: auto; opacity:0.5;" disabled>
                                                                                                                                <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                            </a>
                                                                                                                        @endif
                                                                                                                    @endif
                                                                                                                @else
                                                                                                                    <a class="btn options-btn" data-bs-toggle="modal" data-bs-target="#pricemodel">
                                                                                                                        <span class="sizeprice hide-carttext text-white">{{ $currency }}{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
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
                                                                <td>{{ html_entity_decode($cart['size']) }}</td>
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
                                            if (!empty($Coupon) || $Coupon != '')
                                            {
                                                if ($Coupon['type'] == 'P')
                                                {
                                                    $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                }
                                                if ($Coupon['type'] == 'F')
                                                {
                                                    $couponcode = $Coupon['discount'];
                                                }
                                                $total = $subtotal - $couponcode;
                                            }
                                            else
                                            {
                                                $total = $subtotal;
                                            }
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
                                                @if ((isset($mycart['size']) && !empty($mycart['size'])) || (isset($mycart['withoutSize']) && !empty($mycart['withoutSize'])))
                                                    <li class="minicart-list-item">
                                                        <div class="minicart-list-item-innr coupon_code">
                                                            @if ($Coupon != '' || !empty($Coupon))
                                                                <label
                                                                    id="coupontext">Coupon({{ $Coupon['code'] }})</label>
                                                                <span>{{ $currency }}
                                                                    -{{ isset($couponcode) ? $couponcode : '' }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="minicart-list-item-innr addcoupon">
                                                            <label>
                                                                @if ($Coupon != '' || !empty($Coupon))
                                                                    <a style="color: #ff0000;font-size:14px;"
                                                                        onclick="showcoupon();">
                                                                        Change Coupon Code
                                                                    </a>
                                                                @else
                                                                    <a style="color: #ff0000;font-size:14px;"
                                                                        onclick="showcoupon();">
                                                                        Apply New Coupon Code
                                                                    </a>
                                                                @endif
                                                            </label>
                                                        </div>
                                                        <div class="minicart-list-item-innr">
                                                            <div class="showcoupons">
                                                                <form method="POST" id="from_showcoupon">
                                                                    @csrf
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
                                                @else
                                                    <li class="minicart-list-item">
                                                        <div class="minicart-list-item-innr coupon_code">

                                                        </div>
                                                    </li>
                                                @endif
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr total">
                                                        <label>Total to pay:</label>
                                                        <span>{{ $currency }} {{ isset($total) ? $total : '' }}</span>
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
                                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                                <div class="form-check m-auto">
                                                    @if ($delivery_setting['enable_delivery'] == 'collection')
                                                        <input class="form-check-input" type="radio"
                                                            name="delivery_type" id="collection"
                                                            {{ $delivery_setting['enable_delivery'] == 'collection' ? 'checked' : '' }}
                                                            value="collection">
                                                    @else
                                                        <input class="form-check-input" type="radio"
                                                            name="delivery_type" id="collection" value="collection"
                                                            {{ $userdeliverytype == 'collection' ? 'checked' : '' }}>
                                                    @endif
                                                    <label class="form-check-label" for="collection">
                                                        <h6>Collection</h6>
                                                    </label><br>
                                                    <span>{{ $collection_gap }}  Min</span>
                                                </div>
                                            @endif
                                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                                <div class="form-check m-auto">
                                                    <input class="form-check-input" type="radio" name="delivery_type" id="delivery" {{ $userdeliverytype == 'delivery' ? 'checked' : '' }}>
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
                                @if (!empty($mycart['size']))
                                    {{-- <a href="{{ route('checkout') }}" class="btn checkbt">Checkout</a> --}}
                                    @if ($userdeliverytype == 'delivery')
                                        @if ($minimum_spend['min_spend'] >= $total)
                                            <a href="{{ route('checkout') }}" class="btn checkbt disabled_checkout_btn disabled">Checkout</a>
                                            <div class="closed-now minimum_spend">
                                                    <span class="closing-text" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend['min_spend'],2)}}.</span>
                                                    {{-- <span class="closing-text" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend['min_spend'],2)}}, you must spend {{ $currency }}{{number_format($minimum_spend['min_spend'],2) - $total}} more for the chekout.</span> --}}
                                            </div>
                                        @else
                                            <div class="closed-now pt-0">
                                                <a href="{{ route('checkout') }}" class="btn checkbt">Checkout</a>
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('checkout') }}" class="btn checkbt">Checkout</a>
                                        <div class="closed-now">
                                            <span class="closing-text" style="color: green !important;">We are open now!</span>
                                        </div>
                                    @endif
                                @else
                                    @if ($userdeliverytype == 'delivery')
                                        <a href="{{ route('checkout') }}" class="btn checkbt disabled_checkout_btn disabled">Checkout</a>
                                        <div class="closed-now minimum_spend">
                                                <span class="closing-text" style="color: red !important;">Minimum delivery is {{ $currency }}{{number_format($minimum_spend['min_spend'],2)}} </span>
                                        </div>
                                    @else
                                        <a href="{{ route('checkout') }}" class="btn checkbt">Checkout</a>
                                        <div class="closed-now">
                                            <span class="closing-text" style="color: green !important;">We are open now!</span>
                                        </div>
                                    @endif
                                @endif
                            @else
                                <div class="closed-now">
                                    <button class="btn w-100 checkbt" disabled style="cursor: not-allowed; pointer-events: auto; color:black;">Checkout</button>
                                    <div class="closed-now">
                                        <span class="closing-text">We are closed now !</span>
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
    <div class="modal fade csmodal" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <h5 class="modal-title" id="ModalLabel">Please Enter Your Post Code</h5>
                        <span>Minimum delivery is {{ $currency }}{{number_format($minimum_spend['min_spend'],2)}}</span>
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
                                        <input id="search_input1" oninput="this.value = this.value.toUpperCase()" placeholder="AB10 1BW" type="text" />
                                        <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}"
                                            style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                    @endif
                                    <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
                                </div>
                                <div class="enter_postcode">
                                    <p>Please enter your postcode to view our menu and place an order</p>
                                </div>
                            @endif
                        </div>
                        @if ($delivery_setting['enable_delivery'] != 'delivery')
                            <a class="btn csmodal-btn collection_button2">I will come and Collect</a>
                        @endif
                        @if ($delivery_setting['enable_delivery'] != 'collection')
                            <a class="btn csmodal-btn delivery_button2">Deliver my order</a><br>
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
        });
        // End Document Script


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

            if(model == 'model')
            {
                if(sizeprice != 0)
                {
                    var form_data = new FormData(document.getElementById('top_form_'+sizeprice));

                    var chckbox = form_data.getAll('check_top');
                    var drpdwn = form_data.get('select_top');

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

                                // Header Total
                                $('.pirce-value').text('');
                                $('.pirce-value').append(result.headertotal);

                                // Coupon
                                $('.coupon_code').html('');
                                $('.coupon_code').append(result.couponcode);

                                // Modal
                                $('#item-modal').html('');
                                $('#item-modal').append(result.modal);

                                // Free Items
                                $('#freeItem').html('');
                                $('#freeItem').append(result.cart_rule_html);

                                $('#top_form_'+sizeprice).trigger("reset");
                                $('#freeItem_'+sizeprice).modal('hide');

                                if (result.min_spend == 'true') {
                                    // checkeout button status
                                    $('.disabled_checkout_btn').removeClass('disabled');
                                    $('.minimum_spend').html('');
                                }
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
                    var drpdwn = form_data.get('select_top');

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

                                // Header Total
                                $('.pirce-value').text('');
                                $('.pirce-value').append(result.headertotal);

                                // Coupon
                                $('.coupon_code').html('');
                                $('.coupon_code').append(result.couponcode);

                                // Modal
                                $('#item-modal').html('');
                                $('#item-modal').append(result.modal);

                                // Free Items
                                $('#freeItem').html('');
                                $('#freeItem').append(result.cart_rule_html);

                                $('#new_top_form_'+product).trigger("reset");
                                $('#newfreeItem_'+product).modal('hide');

                                if (result.min_spend == 'true') {
                                    // checkeout button status
                                    $('.disabled_checkout_btn').removeClass('disabled');
                                    $('.minimum_spend').html('');
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

                    // Header Total
                    $('.pirce-value').text('');
                    $('.pirce-value').append(result.headertotal);

                    // Coupon
                    $('.coupon_code').html('');
                    $('.coupon_code').append(result.couponcode);

                    // Modal
                    $('#item-modal').html('');
                    $('#item-modal').append(result.modal);

                    // Free Items
                    $('#freeItem').html('');
                    $('#freeItem').append(result.cart_rule_html);

                    if (result.min_spend == 'true') {
                        // checkeout button status
                        $('.disabled_checkout_btn').removeClass('disabled');
                        $('.minimum_spend').html('');
                    }
                }
            });
        }
        // End Add to Cart


        // Collection Button
        $('#collection').on('click', function()
        {
            var d_type = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{ url('setDeliveyType') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'd_type': d_type,
                },
                dataType: "json",
                success: function(response) {
                    location.reload();
                }
            });
        });
        // End Collection Button


        // Delivery Button
        $('#delivery').on('click', function()
        {
            $('#Modal').modal('show');
        });
        // End Delivery Button

        // Cancel and go back
        $('#tested').click(function() {
               location.reload();
        });
        // End Cancel and go back

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
            e.preventDefault();
            var coupon = $("input[name='coupon']").val();

            $.ajax({
                type: 'post',
                url: '{{ url('getcoupon') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'coupon': coupon,
                },
                dataType: 'json',
                success: function(result)
                {
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
                        $('#success').html('');
                        $('#success').append(result.success_message);

                        // Coupon Code
                        $('.coupon_code').html('');
                        $('.coupon_code').append(result.couponcode);

                        // Total
                        $('.total').html('');
                        $('.total').append(result.total);

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
