@php
   
   // Get Current Theme ID & Store ID
   $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    $theme_id = $current_theme_id['theme_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings & Other
    $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
    //End Get Store Settings & Theme Settings & Other

    // Template Settings
    $template_setting = $store_theme_settings['template_settings'];
    // End Template Settings

    // Social Site Settings
    $social_site = $store_theme_settings['social_settings'];
    // End Social Site Settings

    // Store Settings
    $store_setting = $store_theme_settings['store_settings'];
    // End Store Settings

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type
  
    // User Details
    $userlogin = session('username');
    // End User Details

    // Get Coupon
    $Coupon = getCoupon();
    // End Get Coupon

    $html = '';
    $headertotal = 0;
    $delivery_charge = 0;
    $price = 0;

    if(session()->has('userid'))
    {
        $cart = getuserCart(session()->get('userid'));
        $cart_products = 0;

        if (isset($cart['size'])) 
        {
            foreach ($cart['size'] as $mycart) 
            {
                $price += isset($mycart['main_price']) ? $mycart['main_price'] * $mycart['quantity'] : 0 * $mycart['quantity'];
                $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                $cart_products += $mycart['quantity'];
            }
        }
        if (isset($cart['withoutSize'])) 
        {
            foreach ($cart['withoutSize'] as $mycart) 
            {
                $price += isset($mycart['main_price']) ? $mycart['main_price'] : 0 * $mycart['quantity'];
                $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                $cart_products += $mycart['quantity'];
            }
        }

        if (!empty($Coupon) || $Coupon != '')
        {
            if ($Coupon['type'] == 'P')
            {
                $couponcode = ($price * $Coupon['discount']) / 100;
            }
            if ($Coupon['type'] == 'F')
            {
                $couponcode = $Coupon['discount'];
            }
            $headertotal += $price - $couponcode + $delivery_charge;
        }
        else
        {
            $headertotal += $price + $delivery_charge;
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
                $price += isset($mycart['main_price']) ? $mycart['main_price'] * $mycart['quantity'] : 0 * $mycart['quantity'];
                $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                $cart_products += $mycart['quantity'];
            }
        }
        if (isset($cart['withoutSize'])) 
        {
            foreach ($cart['withoutSize'] as $mycart) 
            {
                $price += isset($mycart['main_price']) ? $mycart['main_price'] * $mycart['quantity'] : 0 * $mycart['quantity'];
                $delivery_charge += isset($mycart['del_price']) ? $mycart['del_price'] : 0;
                $cart_products += $mycart['quantity'];
            }
        }
       
        if (!empty($Coupon) || $Coupon != '')
        {
            if ($Coupon['type'] == 'P')
            {
                $couponcode = ($price * $Coupon['discount']) / 100;
            }
            if ($Coupon['type'] == 'F')
            {
                $couponcode = $Coupon['discount'];
            }
            $headertotal += $price - $couponcode + $delivery_charge;
        }
        else
        {
            $headertotal += $price + $delivery_charge;
        }
    }

@endphp

<style>
    .menu li:hover a {
        color: <?php echo $template_setting['polianna_navbar_link_hover']; ?> !important;
    }

</style>
<header class="header-v4">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
        <div class="container">
            <div class="social-links">
                <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}"></a>
                <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}"></a>
                <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}"></a>
                <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}"></a>
            </div>
            <!-- restaurant açık ise open kapalı ise closed clas'ını kullanın-->
            <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s">
                @php
                $openday =$openclose['openday'];
                $fromtime = $openclose['fromtime'];
                $totime = $openclose['totime'];
                $closedate = $openclose['close_date'];
                $closedates = explode(',',$closedate);
                $date_close1 = array();
                foreach ($closedates as $value) {
                    $date_close = strtotime($value);
                    $date_close1[] = $date_close;
                }
                @endphp
                @foreach ($openday as $key => $item)
                @foreach ($item as $value)
                    @php

                    $firsttime = strtotime($fromtime[$key]);
                    $lasttime = strtotime($totime[$key]);
                    $today = time();
                    $currentday = date('l');
                    $firstday = $item[0];
                    $currentdate = strtotime(date("Y-m-d"));
                    @endphp
                    @if (in_array($currentdate,$date_close1))
                        <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                            <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}"
                                style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                        </div>
                    @else
                        @if ($today >= $firsttime && $today <= $lasttime)
                            @if ($currentday == $value || $firstday == "Every day")
                                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                    <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}"
                                        style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                                </div>
                            @endif
                        @else
                            @if ($currentday == $value || $firstday == "Every day")
                                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                    <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}"
                                        style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            @endforeach
                {{-- @if ($store_open_close == 1)
                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                        <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}"
                            style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                    </div>
                @else
                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                        <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}"
                            style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                    </div>
                @endif --}}
            </div>
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong>
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
          @php

            @endphp
                    @php
                    $t = count($item)-1;
                    $firstday = $item[0];
                    $lastday = $item[$t];
                    $today = date('l');
                    $currentdate = strtotime(date("Y-m-d"));
                    @endphp
                        @if (in_array($currentdate,$date_close1))
                            <strong>Close</strong>
                        @else
                            @if ($today == $value || $firstday == "Every day")
                                <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                            @elseif ($firstday == "Every day")
                                <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                            @endif
                        @endif
                        @endforeach
                @endforeach
            </div>
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container">
            <a class="logo" href="{{ route('home') }}">
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}"
                    style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;" />
            </a>
            <ul class="menu">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                </li>
                <li class="{{ (request()->is('member')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="{{ route('member') }}" style="color: {{  (request()->is('member')) ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                </li>
                <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('menu')) ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                </li>
                {{-- <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="#" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                </li> --}}
                @if (empty($cart['size']) || empty($cart['withoutSize']))
                    <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('cart') }}" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                    </li>
                @else
                    <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('checkout') }}" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                    </li>
                @endif  
                <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contact')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                </li>
            </ul>
            <div class="__btn-group">
                <div class="number productcountitem">
                    <a class="btn __purple text-capitalize" href="{{ route('cart') }}"><i class="fas fa-shopping-cart"></i>my cart</a>               
                    <span id="cart_products">{{ ($cart_products) }}</span>
                    {{-- <div class="number"><i class="fas fa-shopping-basket"></i><span>{{ ($cart_products) }}</span></div> --}}
                </div>
                @if (!empty($userlogin))
                <ul class="authentication-links" style="list-style: none">
                    <li><p class="m-0"></p><a href="{{ route('member') }}" style="color: {{isset($template_setting['polianna_navbar_link'])? $template_setting['polianna_navbar_link'] : 'white'}} ">({{ $userlogin }})</a></li>
                    <li>
                        <form method="POST" action="{{ route('customerlogout') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt" style="color: {{isset($template_setting['polianna_navbar_link'])? $template_setting['polianna_navbar_link'] : 'white'}} "></i><span style="color: {{isset($template_setting['polianna_navbar_link'])? $template_setting['polianna_navbar_link'] : 'white'}} ">Logout</span></button>
                         </form>
                    </li>
                </ul>            
                @else
                    <a class="btn __green text-capitalize" href="#" data-bs-toggle="modal" data-bs-target="#login">login or signup</a>
                @endif
                {{-- <a class="btn __green text-capitalize" href="#" data-bs-toggle="modal" data-bs-target="#login">login or signup</a> --}}
            </div>
            <a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i class="fas fa-bars"></i></a>
        </div>
    </div>
</header>
