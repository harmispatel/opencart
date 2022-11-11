

{{--
    THIS IS LAYOUT(THEME) 1 HEADER PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    header.blade.php
    It Displayed Layout(Theme) 1 Header
    ----------------------------------------------------------------------------------------------
--}}

@php
    
    // Current URL
    $currentURL = URL::to("/");
    
    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];

    // Get Current Header ID & Header Settings
    $current_header_id = layoutID($currentURL,'header_id');
    $header_id = $current_header_id['header_id'];
    $store_header_settings = storeLayoutSettings($header_id,$front_store_id,'header_settings','header_id');
    
    // Menu Topbar Open Close Permission
    $menu_topbar_open_close_permission = isset($store_header_settings['menu_topbar_open_close_permission']) ? $store_header_settings['menu_topbar_open_close_permission'] : '';
    

    // Social Site Settings
    $social_site = isset($store_data['social_settings']) ? $store_data['social_settings'] : '';


    // Store Settings
    $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

    // Store Logo
    $store_logo = isset($store_setting['config_logo']) ? $store_setting['config_logo'] : '';


    // Get Currency Details
    $currency = getCurrencySymbol($store_setting['config_currency']);


    // Get Open-Close Time
    $openclose = openclosetime();

    // Store Open / Close
    $store_open_close = isset($openclose['store_open_close']) ? $openclose['store_open_close'] : 'close';

    // Get Working Time
    if($store_open_close == 'open')
    {
        $working_from_time = isset($openclose['from_time']) ? date('H:i',$openclose['from_time']) : '0:00';
        $working_to_time = isset($openclose['to_time']) ? date('H:i',$openclose['to_time']) : '0:00';
        $working_time = $working_from_time.' - '.$working_to_time;
    }
    elseif($store_open_close == 'close') 
    {
        $working_from_time = isset($openclose['from_time']) ? date('H:i',$openclose['from_time']) : '0:00';
        $working_to_time = isset($openclose['to_time']) ? date('H:i',$openclose['to_time']) : '0:00';
        $working_time = $working_from_time.' - '.$working_to_time;
    }
    else 
    {
        $working_time = "00:00 - 00:00";
    }


    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // echo '<pre>';
    // print_r($userdeliverytype);
    // exit();

    $delivery_type = session()->get('flag_post_code');
    // User Details
    $userlogin = session('username');


    // Get Coupon
    $Coupon = getCoupon();
//    echo '<pre>';
//    print_r($Coupon);
//    exit();

    $html = '';
    $delivery_charge = 0;
    $price = 0;


    // Cart Details
    if(session()->has('userid'))
    {
        // $cart = getuserCart(session()->get('userid')); // Database
        $cart = session()->get('cart1'); // Session
        $cart_products = 0;

        if (isset($cart['size'])) 
        {
            foreach ($cart['size'] as $mycart) 
            {
                // $price += isset($mycart['main_price']) ? $mycart['main_price'] * $mycart['quantity'] : 0 * $mycart['quantity'];
                // $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                if($userdeliverytype == 'delivery')
                {
                    $price += (isset($mycart['del_price'])) ? ($mycart['del_price'] * $mycart['quantity']) : (0 * $mycart['quantity']);
                }
                elseif($userdeliverytype == 'collection')
                {
                    $price += (isset($mycart['col_price'])) ? ($mycart['col_price'] * $mycart['quantity']) : (0 * $mycart['quantity']);
                }
                else
                {
                    $price += $mycart['main_price'] * $mycart['quantity'];
                }
                $cart_products += $mycart['quantity'];
            }
        }
        if (isset($cart['withoutSize'])) 
        {
            foreach ($cart['withoutSize'] as $mycart) 
            {
                if($userdeliverytype == 'delivery')
                {
                    // $price += isset($mycart['del_price']) * $mycart['quantity']);
                    $price += (isset($mycart['del_price'])) ? ($mycart['del_price'] * $mycart['quantity']) : (0 * $mycart['quantity']);

                }
                elseif($userdeliverytype == 'collection')
                {
                    $price += $mycart['col_price'] * $mycart['quantity'];
                }
                else
                {
                    $price += $mycart['main_price'] * $mycart['quantity'];
                }
                // $price += isset($mycart['main_price']) ? $mycart['main_price'] : 0 * $mycart['quantity'];
                // $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                $cart_products += $mycart['quantity'];
            }
        }
    }
    else 
    {
        $cart = session()->get('cart1');
        
        $cart_products = 0;
        
        if (isset($cart['size'])) 
        {
            foreach ($cart['size'] as $mycart) 
            {
                // $price += isset($mycart['col_price']) ? $mycart['col_price'] * $mycart['quantity'] : 0 * $mycart['quantity'];
                
                if($userdeliverytype == 'delivery')
                {
                    $price += $mycart['del_price'] * $mycart['quantity'];
                }
                elseif($userdeliverytype == 'collection')
                {
                    $price +=$mycart['col_price'] * $mycart['quantity'];
                }
                else
                {
                    $price += $mycart['main_price'] * $mycart['quantity'];
                }
               
               
                // $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                $cart_products += $mycart['quantity'];
            }
            
        }
        
        if (isset($cart['withoutSize'])) 
        {
            foreach ($cart['withoutSize'] as $mycart) 
            {
                if($userdeliverytype == 'delivery')
                {
                    $price += $mycart['del_price'] * $mycart['quantity'];
                }
                elseif($userdeliverytype == 'collection')
                {
                    $price +=$mycart['col_price'] * $mycart['quantity'];
                }
                else
                {
                    $price += $mycart['main_price'] * $mycart['quantity'];
                }
                // $price += isset($mycart['main_price']) ? $mycart['main_price'] * $mycart['quantity'] : 0 * $mycart['quantity'];
                // $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                // $delivery_charge =0;
                $cart_products += $mycart['quantity'];
            }
        }
    
    }
    // End Cart Details

    if(session()->has('total'))
    {
        $total = session()->get('total');
    }
    else 
    {
        $total = 0;    
    }

    $currentdate = strtotime(date("Y-m-d")); 
@endphp


{{-- CSS --}}
    {{-- HEADER CSS --}}
    {{------------------------------------------------------------------------------------------------}}
        {{-- Header 1 --}}
        <?php
            if($header_id == 1)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header .header-bottom
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                    }

                    /* Menu Links Color */
                    .header .header-bottom .menu li a, .menu-shopping-cart .price-box strong, .menu-shopping-cart .number i, .menu-shopping-cart .price-box .price h3, .menu-shopping-cart .price-box .price h3 span
                    {
                        color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }

                    /* Menu Active Button Color */
                    .header .header-bottom .menu li.active, .header .header-bottom .menu li.active:before, .header .header-bottom .menu li:hover:before, .header .header-bottom .menu li.active:after, .header .header-bottom .menu li:hover:after
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_button_color']))? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }

                    /* Menu Active Buttons Links Color */
                    .header .header-bottom .menu li.active a, .header .header-bottom .menu li a:hover,.header .header-bottom .menu li:hover a
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                    }

                    /* Menu Active Button Hover Color */
                    .header .header-bottom .menu li:hover
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_button_color']))? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Header 2 --}}
        <?php
            if($header_id == 2)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header-v2 .header-bottom
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                    }

                    /* Menu Link Color */
                    .header-v2 .header-bottom .menu li a, .header-v2 .header-bottom .authentication-links li a span, .header-v2 .header-bottom .menu-shopping-cart .price-box strong, .header-v2 .header-bottom .menu-shopping-cart .price-box i, .header-v2 .header-bottom .menu-shopping-cart .price-box span
                    {
                        color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }
                    .authentication-links li a span,.header-v2 .header-bottom .menu-shopping-cart .price-box strong,.header-v2 .header-bottom .menu-shopping-cart .price-box .price i, .header-v2 .header-bottom .menu-shopping-cart .price-box .price span
                    {
                        font-size: 15px!important;
                    }

                    /* Menu Button Color */
                    .header-v2 .header-bottom .menu li:hover:after, .header-v2 .header-bottom .menu li.active:after, .header-v2 .header-bottom .menu-shopping-cart i.fa-shopping-basket
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                    .header-v2 .header-bottom .authentication-links li a i
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                    .menu-shopping-cart .number span
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        background: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                    }

                    /* Menu Button Active Link Color */
                    .header-v2 .header-bottom .menu li.active a, .header-v2 .header-bottom .menu li a:hover,.header-v2 .header-bottom .menu li:hover a, .header-v2 .header-bottom .menu-shopping-cart i.fa-shopping-basket
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Header 3 --}}
        <?php
            if($header_id == 3)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header-v3 .header-bottom
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                    }

                    /* Menu Link Color */
                    .header-v3 .header-bottom .menu li a
                    {
                        color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }

                    /* Menu Active Button Color */
                    .header-v3 .header-bottom .menu li:hover a, .header-v3 .header-bottom .menu li.active a
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Header 4 --}}
        <?php
            if($header_id == 4)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header-v4 .header-bottom
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                    }

                    /* Menu Link Color */
                    .header-v4 .header-bottom .menu li a
                    {
                        color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }

                    /* Menu Button Color */
                    .header-v4 .header-bottom .menu li.active a, .header-v4 .header-bottom .menu li:hover a, .header-v4 .header-bottom .__btn-group a.__purple, .header-v4 .header-bottom .__btn-group a.__green
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }

                    /* Menu Button Active Link Color */
                    .header-v4 .header-bottom .menu li.active a, .header-v4 .header-bottom .menu li:hover a, .header-v4 .header-bottom .__btn-group a i, .header-v4 .header-bottom .__btn-group a.__purple, .header-v4 .header-bottom .__btn-group a.__green
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                    }

                    .productcountitem span{
                        background-color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Header 5 --}}
        <?php
            if($header_id == 5)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header-v5 .header-bottom
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                    }
                    .header-v5 .header-bottom .menu-shopping-cart .number span
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        background-color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }

                    /* Menu Links Color */
                    .header-v5 .header-bottom .menu li a, .header-v5 .header-bottom .menu-shopping-cart .price-box strong, .header-v5 .header-bottom .menu-shopping-cart .price-box .price i, .header-v5 .header-bottom .menu-shopping-cart .price-box .price span
                    {
                        color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }

                    /* Menu Button Color */
                    .header-v5 .header-bottom .menu li:hover a, .header-v5 .header-bottom .menu li.active a
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                    .header-v5 .header-bottom .menu-shopping-cart .number i
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }

                    /* Menu Buttons Text Color */
                    .header-v5 .header-bottom .menu li.active a,.header-v5 .header-bottom .menu li:hover a
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Header 6 --}}
        <?php
            if($header_id == 6)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header-v6
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                    }

                    /* Menu Links Color */
                    .header-v6 .header-center .menu li a, .header-v6 .header-bottom .working-time strong, .header-v6 .header-top .authentication-links li a span, .header-v6 .header-top .menu-shopping-cart .price-box strong, .header-v6 .header-top .menu-shopping-cart .price-box i, .header-v6 .header-top .menu-shopping-cart .price-box span
                    {
                        color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                    }
                    .header-v6 .header-top .menu-shopping-cart .number span
                    {
                        background-color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }

                    /* Menu Button Color */
                    .header-v6 .header-center .menu li.active a, .header-v6 .header-center .menu li:hover a, .header-v6 .header-bottom .working-time i, .header-v6 .header-top .authentication-links li a i, .header-v6 .header-top .menu-shopping-cart .number i
                    {
                        color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                    }
                </style>
        <?php
            }
        ?>
    {{------------------------------------------------------------------------------------------------}}
    {{-- END HEADER --}}
{{-- END CSS --}}


{{-- Header --}}
    @php
        $menu_topbar_left = (isset($store_header_settings['menu_topbar_left'])) ? $store_header_settings['menu_topbar_left'] : '';
        $menu_topbar_center = (isset($store_header_settings['menu_topbar_center'])) ? $store_header_settings['menu_topbar_center'] : '';
        $menu_topbar_right = (isset($store_header_settings['menu_topbar_right'])) ? $store_header_settings['menu_topbar_right'] : '';
    @endphp

    {{-- Header 1 --}}
    @if ($header_id == 1)
        <header class="header">
            <div class="container">
                <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">

                    {{-- Topbar Left --}}
                    @if ($menu_topbar_left == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            &nbsp;<strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_left == 'social_media_links')
                        <ul class="social-links">
                            @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))
                                <li>
                                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                                </li>
                            @endif  

                            @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                <li>
                                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                                <li>
                                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                <li>
                                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))                                
                                <li>
                                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                                </li>
                            @endif
                        </ul>
                    @else
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0">You are Logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ strtoupper($userlogin) }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif
                    {{-- End Topbar Left --}}

                    {{-- Topbar Center --}}
                    @if ($menu_topbar_center == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            &nbsp;<strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_center == 'social_media_links')
                        <ul class="social-links">
                            @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))
                                <li>
                                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                                </li>
                            @endif  

                            @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                <li>
                                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                                <li>
                                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                <li>
                                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))                                
                                <li>
                                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                                </li>
                            @endif
                        </ul>
                    @else
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0">You are Logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ strtoupper($userlogin) }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif
                    {{-- End Topbar Center --}}

                    {{-- Topbar Right --}}
                    @if ($menu_topbar_right == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            &nbsp;<strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_right == 'social_media_links')
                        <ul class="social-links">
                            @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))
                                <li>
                                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                                </li>
                            @endif  

                            @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                <li>
                                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                                <li>
                                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                <li>
                                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                                </li>
                            @endif

                            @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))                                
                                <li>
                                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                                </li>
                            @endif
                        </ul>
                    @else
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0">You are Logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ strtoupper($userlogin) }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif
                    {{-- End Topbar Right --}}

                </div>

                <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="border-radius:0 0 10px 10px!important;">
                    <a class="logo" href="{{ route('home') }}">
                        <img class="img-fluid" src="{{ get_css_url().$store_logo }}" alt="Logo" style="max-width: 130px;" />
                    </a>
                    <ul class="menu">
                        <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('home') }}">home</a>
                        </li>
                        <li class="{{ ((request()->is('member'))) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('member') }}">member</a>
                        </li>
                        <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                        </li>
                        {{-- @if (empty($cart['size']) || empty($cart['withoutSize']))
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('cart') }}">check out</a>
                            </li>
                        @else --}}
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                            </li>
                        {{-- @endif   --}}
                        <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>
                    <a class="menu-shopping-cart" href="{{ route('cart') }}">
                        <div class="number">
                            <i class="fas fa-shopping-basket"></i><span id="cart_products">{{ $cart_products }}</span>
                        </div>
                        <div class="price-box">
                            <strong>Shopping Cart</strong>
                            <div class="price">
                                <h3 style="color: black">{{ $currency }} <span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></h3>
                            </div>
                        </div>
                    </a>
                    <a class="open-mobile-menu" href="javascript:void(0)">
                        <span class="text-uppercase">menu</span>
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
        </header>
    @endif
    {{-- End Header 1 --}}
    

    {{-- Header 2 --}}
    @if ($header_id == 2)
        <header class="header-v2">
            <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">

                    {{-- topbar left --}}
                    @if ($menu_topbar_left == 'open_close_image')
                        <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                            @if ($menu_topbar_open_close_permission == 1)
                                @if($store_open_close == 'open')
                                    <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                                @else
                                    <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                                @endif
                            @endif
                        </div>                        
                    @elseif ($menu_topbar_left == 'main_logo')
                        <a class="logo" href="{{ route('home') }}">
                            <img class="img-fluid" src="{{ $store_logo }}" alt="logo" style="max-width: 130px;" />
                        </a>
                    @else
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @endif


                    {{-- topbar center --}}
                    @if ($menu_topbar_center == 'open_close_image')                       
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                @if ($menu_topbar_open_close_permission == 1)
                                    @if($store_open_close == 'open')
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                                    @else
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                                    @endif
                                @endif
                            </div>                        
                    @elseif ($menu_topbar_center == 'main_logo')
                        <a class="logo" href="{{ route('home') }}">
                            <img class="img-fluid" src="{{ $store_logo }}" alt="logo" style="max-width: 130px;" />
                        </a>
                    @else
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @endif


                    {{-- topbar right --}}
                    @if ($menu_topbar_right == 'open_close_image')
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                @if ($menu_topbar_open_close_permission == 1)
                                    @if($store_open_close == 'open')
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                                    @else
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                                    @endif
                                @endif
                            </div>
                    @elseif ($menu_topbar_right == 'main_logo')
                        <a class="logo" href="{{ route('home') }}">
                            <img class="img-fluid" src="{{ $store_logo }}" alt="logo" style="max-width: 130px;" />
                        </a>
                    @else
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @endif
        

                </div>
            </div>

            <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">
                    <ul class="menu">
                        <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('home') }}">home</a>
                        </li>
                        <li class="{{ (request()->is('member')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('member') }}">member</a>
                        </li>
                        <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                        </li>
                        {{-- @if (empty($cart['size']) || empty($cart['withoutSize']))
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('cart') }}">check out</a>
                            </li>
                        @else --}}
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                            </li>
                        {{-- @endif   --}}
                        <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>
                    <div class="__right">
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex">
                                    <p class="m-0 text-white"></p>&nbsp;
                                    <a href="{{ route('member') }}"> ({{ $userlogin }})</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" style="background: transparent !important" class="border-0"><i class="fas fa-sign-out-alt"></i></i>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        
                        <a class="menu-shopping-cart" href="{{ route('cart') }}">
                            <div class="number">
                                <i class="fas fa-shopping-basket"></i><span id="cart_products" class="bg-danger">{{ ($cart_products) }}</span>
                            </div>
                            <div class="price-box">
                                <strong>Shopping Cart</strong>
                                <div class="price">
                                    <i class="fas fa-pound-sign"></i> <span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <a class="open-mobile-menu" href="javascript:void(0)">
                        <span class="text-uppercase">menu</span><i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
        </header>
    @endif
    {{-- End Header 2 --}}


    {{-- End Header 3 --}}
    @if ($header_id == 3)
        <header class="header-v3">
            <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">

                    {{-- Topbar left --}}
                    @if ($menu_topbar_left == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_left == 'customer_login')
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0">You are logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @else
                        <div class="__right-content">
                            <a class="menu-shopping-cart" href="{{ route('cart') }}">
                                <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
                                <div class="price-box"><strong>Shopping Cart:</strong>
                                    <div class="price">{{$currency}}<span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></div>
                                </div>
                            </a>
                        </div>
                    @endif


                    {{-- Topbar center --}}
                    @if ($menu_topbar_center == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_center == 'customer_login')
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0">You are logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @else
                        <div class="__right-content">
                            <a class="menu-shopping-cart" href="{{ route('cart') }}">
                                <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
                                <div class="price-box"><strong>Shopping Cart:</strong>
                                    <div class="price">{{$currency}}<span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></div>
                                </div>
                            </a>
                        </div>
                    @endif


                    {{-- Topbar right --}}
                    @if ($menu_topbar_right == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_right == 'customer_login')
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0">You are logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @else
                        <div class="__right-content">
                            <a class="menu-shopping-cart" href="{{ route('cart') }}">
                                <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
                                <div class="price-box"><strong>Shopping Cart:</strong>
                                    <div class="price">{{$currency}}<span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></div>
                                </div>
                            </a>
                        </div>
                    @endif

    
                </div>
            </div>
            <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">
                    <a class="logo" href="{{route('home')}}">
                        <img class="attach img-fluid" src="{{ get_css_url().'public/assets/theme3/img/icon/logo-attach.svg' }}" />
                        <img class="img-fluid" src="{{ $store_logo }}" alt="logo" width="170" />
                    </a>
                    <ul class="menu">
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('home') }}">home</a>
                        </li>
                        <li class="{{ request()->is('member') ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('member') }}">member</a>
                        </li>
                        <li class="{{ request()->is('menu') ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                        </li>
                        {{-- @if (empty($cart['size']) || empty($cart['withoutSize']))
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('cart') }}">check out</a>
                            </li>
                        @else --}}
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                            </li>
                        {{-- @endif   --}}
                        <li class="{{ request()->is('contact') ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>
                    
                    
                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                        @if ($menu_topbar_open_close_permission == 1)
                            @if($store_open_close == 'open')
                                <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                            @else
                                <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                            @endif
                        @endif
                    </div>

                    <a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i class="fas fa-bars"></i></a>
                </div>
            </div>
        </header>
    @endif
    {{-- Header 3 --}}


    {{-- Header 4 --}}
    @if ($header_id == 4)
        <header class="header-v4">
            <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">

                    {{-- Topbar left --}}
                    @if ($menu_topbar_left == 'social_media_links')
                        <div class="social-links">
                            @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))                                    
                                <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                            @endif
                            
                            @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                            @endif

                            @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))
                                <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                            @endif

                            @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                            @endif

                            @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                                <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                            @endif
                        </div>
                    @elseif ($menu_topbar_left == 'open_close_image')
                        <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s" style="display: block;!important">
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                @if ($menu_topbar_open_close_permission == 1)
                                    @if($store_open_close == 'open')
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                                    @else
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @endif


                    {{-- Topbar center --}}
                    @if ($menu_topbar_center == 'social_media_links')
                        <div class="social-links">
                            <a class="fab fa-facebook-f" href="{{ isset($social_site['polianna_facebook_id']) ? $social_site['polianna_facebook_id'] : 'https://www.twitter.com' }}"></a>
                            <a class="fab fa-twitter" href="{{ isset($social_site['polianna_twitter_username']) ? $social_site['polianna_twitter_username'] : 'https://www.twitter.com' }}"></a>
                            <a class="fab fa-linkedin" href="{{ isset($social_site['polianna_linkedin_id']) ? $social_site['polianna_linkedin_id'] : 'https://www.twitter.com' }}"></a>
                            <a class="fab fa-youtube" href="{{ isset($social_site['polianna_youtube_id']) ? $social_site['polianna_youtube_id'] : 'https://www.twitter.com' }}"></a>
                        </div>
                    @elseif ($menu_topbar_center == 'open_close_image')
                        <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s" style="display: block;!important">                            
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                @if ($menu_topbar_open_close_permission == 1)
                                    @if($store_open_close == 'open')
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                                    @else
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @endif


                    {{-- Topbar right --}}
                    @if ($menu_topbar_right == 'social_media_links')
                        <div class="social-links">
                            <a class="fab fa-facebook-f" href="{{ isset($social_site['polianna_facebook_id']) ? $social_site['polianna_facebook_id'] : 'https://www.twitter.com' }}"></a>
                            <a class="fab fa-twitter" href="{{ isset($social_site['polianna_twitter_username']) ? $social_site['polianna_twitter_username'] : 'https://www.twitter.com' }}"></a>
                            <a class="fab fa-linkedin" href="{{ isset($social_site['polianna_linkedin_id']) ? $social_site['polianna_linkedin_id'] : 'https://www.twitter.com' }}"></a>
                            <a class="fab fa-youtube" href="{{ isset($social_site['polianna_youtube_id']) ? $social_site['polianna_youtube_id'] : 'https://www.twitter.com' }}"></a>
                        </div>
                    @elseif ($menu_topbar_right == 'open_close_image')
                        <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s" style="display: block;!important">                            
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                @if ($menu_topbar_open_close_permission == 1)
                                    @if($store_open_close == 'open')
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                                    @else
                                        <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @endif

                </div>
            </div>
            <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">
                    <a class="logo" href="{{ route('home') }}">
                        <img class="img-fluid" src="{{ $store_logo }}" alt=" Logo" style="max-width: 130px;" />
                    </a>
                    <ul class="menu">
                        <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('home') }}">home</a>
                        </li>
                        <li class="{{ (request()->is('member')) ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('member') }}">member</a>
                        </li>
                        <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                        </li>
                        {{-- @if (empty($cart['size']) || empty($cart['withoutSize']))
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('cart') }}">check out</a>
                            </li>
                        @else --}}
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                            </li>
                        {{-- @endif   --}}
                        <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>
                    <div class="__btn-group">
                        <div class="number productcountitem">
                            <a class="btn __purple text-capitalize" href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i>my cart</a>               
                            <span id="cart_products">{{ ($cart_products) }}</span>
                        </div>
                        @if (!empty($userlogin))
                            <ul class="authentication-links" style="list-style: none">
                                <li><p class="m-0"></p><a href="{{ route('member') }}">({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt" ></i><span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else
                            <a class="btn __green text-capitalize" href="#" data-bs-toggle="modal" data-bs-target="#login">login or signup</a>
                        @endif
                    </div>
                    <a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i class="fas fa-bars"></i></a>
                </div>
            </div>
        </header>
    @endif
    {{-- End Header 4 --}}


    {{-- Header 5 --}}
    @if ($header_id == 5)
        <header class="header-v5">
            <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">

                    {{-- Topbar left --}}
                    @if ($menu_topbar_left == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_left == 'main_logo')
                        <a class="logo" href="{{ route('home') }}">
                            <img class="img-fluid" src="{{ $store_logo }}" alt="Logo" style="max-width: 130px;" />
                        </a>
                    @else
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0 text-white">You are logged in as</p>&nbsp;<a href="{{ route('member') }}" class="text-success"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt text-white"></i><span class="text-white">Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif
                    

                    {{-- Topbar center --}}
                    @if ($menu_topbar_center == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_center == 'main_logo')
                        <a class="logo" href="{{ route('home') }}">
                            <img class="img-fluid" src="{{ $store_logo }}" alt="Logo" style="max-width: 130px;" />
                        </a>
                    @else
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0 text-white">You are logged in as</p>&nbsp;<a href="{{ route('member') }}" class="text-success"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt text-white"></i><span class="text-white">Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif


                    {{-- Topbar right --}}
                    @if ($menu_topbar_right == 'opening_times')
                        <div class="working-time">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>
                    @elseif ($menu_topbar_right == 'main_logo')
                        <a class="logo" href="{{ route('home') }}">
                            <img class="img-fluid" src="{{ $store_logo }}" alt="Logo" style="max-width: 130px;" />
                        </a>
                    @else
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0 text-white">You are logged in as</p>&nbsp;<a href="{{ route('member') }}" class="text-success"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt text-white"></i><span class="text-white">Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @endif


                </div>
            </div>

            <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">
                    <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s" style="display: block;">
                        @if ($menu_topbar_open_close_permission == 1)
                            @if($store_open_close == 'open')
                                <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                            @else
                                <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                            @endif
                        @endif
                    </div>
                    
                    <ul class="menu">
                        <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="{{ (request()->is('member')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('member') }}">member</a>
                        </li>
                        <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                        </li>
                        {{-- @if (empty($cart['size']) || empty($cart['withoutSize']))
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('cart') }}">check out</a>
                            </li>
                        @else --}}
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                            </li>
                        {{-- @endif --}}
                        <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>

                    <a class="menu-shopping-cart" href="{{ route('cart') }}">
                        <div class="number">
                            <i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span>
                        </div>
                        <div class="price-box"><strong>Shopping Cart:</strong>
                            <div class="price"><i class="fas fa-pound-sign"></i><span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></div>
                        </div>
                    </a>
                    <a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i class="fas fa-bars"></i></a>
                </div>
            </div>
        </header>
    @endif
    {{-- End Header 5 --}}


    {{-- Header 6 --}}
    @if ($header_id == 6)
        <header class="header-v6">
            <div class="header-top wow animate__fadeInDown" data-wow-duration="1s" >
                <div class="container">

                    {{-- Topbar left --}}
                    @if ($menu_topbar_left == 'customer_login')
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0 text-white">You are logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt text-white"></i><span class="text-white">Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @elseif ($menu_topbar_left == 'shopping_cart')
                        <a class="menu-shopping-cart" href="{{ route('cart') }}">
                            <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
                            <div class="price-box"><strong>Shopping Cart:</strong>
                                <div class="price">{{$currency}}<span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></div>
                            </div>
                        </a>
                    @endif


                    {{-- Topbar right --}}
                    @if ($menu_topbar_right == 'customer_login')
                        @if (!empty($userlogin))
                            <ul class="authentication-links">
                                <li class="d-flex"><p class="m-0 text-white">You are logged in as</p>&nbsp;<a href="{{ route('member') }}"> ({{ $userlogin }})</a></li>
                                <li>
                                    <form method="POST" action="{{ route('customerlogout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt text-white"></i><span class="text-white">Logout</span></button>
                                    </form>
                                </li>
                            </ul>            
                        @else            
                            <ul class="authentication-links">
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="far fa-user"></i><span>Login</span>
                                    </a>
                                </li>
                                <li>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    @elseif ($menu_topbar_right == 'shopping_cart')
                        <a class="menu-shopping-cart" href="{{ route('cart') }}">
                            <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
                            <div class="price-box"><strong>Shopping Cart:</strong>
                                <div class="price">{{$currency}}<span class="pirce-value">{{ (($total <= 0) ? 0 : $total) }}</span></div>
                            </div>
                        </a>
                    @endif
                    
                    
                </div>
            </div>
            <div class="header-center">
                <div class="container">
                    <ul class="menu">
                        <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('home') }}">home</a>
                        </li>
                        <li class="{{ ((request()->is('member'))) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('member') }}">member</a>
                        </li>
                        <li class="{{ ((request()->is('menu'))) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                        </li>
                        {{-- @if (empty($cart['size']) || empty($cart['withoutSize']))
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('cart') }}">check out</a>
                            </li>
                        @else --}}
                            <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
                            </li>
                        {{-- @endif --}}
                        <li class="{{ ((request()->is('contact'))) ? 'active' : '' }}">
                            <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s">
                <div class="container">
                    <div class="working-time"><i class="far fa-clock"></i>
                        <div class="work-innr">
                            <strong class="text-uppercase">Working Time : </strong>
                            <strong>{{ $working_time }}</strong>
                        </div>        
                    </div>

                    <a class="logo" href="{{ route('home') }}">
                        <img class="img-fluid" src="{{ $store_logo }}" alt="Logo" style="max-width: 130px;" />
                    </a>
                   
                    <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s" style="display: block;">
                        @if ($menu_topbar_open_close_permission == 1)
                            @if($store_open_close == 'open')
                                <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_open_banner']) ? $store_header_settings['menu_topbar_open_banner'] : '' }}" style="max-width: 80px;"/>
                            @else
                                <img class="img-fluid" src="{{ isset($store_header_settings['menu_topbar_close_banner']) ? $store_header_settings['menu_topbar_close_banner'] : '' }}" style="max-width: 80px;"/>
                            @endif
                        @endif
                    </div>

                    <a class="open-mobile-menu" href="javascript:void(0)">
                        <span class="text-uppercase">menu</span>
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
        </header>
    @endif
    {{-- End Header 6 --}}

{{-- End Header --}}