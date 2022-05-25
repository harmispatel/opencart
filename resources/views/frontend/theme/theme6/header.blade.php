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
    .menu li:hover a{
        color: <?php echo $template_setting['polianna_navbar_link_hover'] ?>!important;
    }


</style>

<header class="header-v6" style="background: {{ $template_setting['polianna_navbar_background'] }};">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s" >
      <div class="container">
        {{-- <ul class="authentication-links">
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="far fa-user"></i><span>Login</span></a></li>
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
        </ul> --}}
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
        <a class="menu-shopping-cart" href="{{ route('cart') }}">
          <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
          <div class="price-box"><strong>Shopping Cart:</strong>
            <div class="price"><i class="fas fa-dollar-sign"></i><span class="pirce-value">{{ $headertotal }}</span></div>
          </div></a>
      </div>
    </div>
    <div class="header-center">
      <div class="container">
        <ul class="menu">
            <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'red' : $template_setting['polianna_navbar_link'] }};">home</a>
            </li>
            <li class="{{ ((request()->is('member'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('member') }}" style="color: {{  (request()->is('member')) ? 'red' : $template_setting['polianna_navbar_link'] }};">member</a>
            </li>
            <li class="{{ ((request()->is('menu'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('menu')) ? 'red' : $template_setting['polianna_navbar_link'] }};">menu</a>
            </li>
            {{-- <li class="{{ ((request()->is('checkout'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('checkout') }}" style="color: {{  (request()->is('checkout')) ? 'red' : $template_setting['polianna_navbar_link'] }};">check out</a>
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
            <li class="{{ ((request()->is('contact'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contact')) ? 'red' : $template_setting['polianna_navbar_link'] }};">contact us</a>
            </li>
        </ul>
      </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s">
      <div class="container">
        <div class="working-time"><i class="far fa-clock"></i>
            <div>
                <strong class="text-uppercase">Working Time:</strong>
                @php
                    $openday =$openclose['openday'];
                    $fromtime = $openclose['fromtime'];
                    $totime = $openclose['totime'];
                @endphp
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
                        @php
                            $t = count($item)-1;
                            $firstday = $item[0];
                            $lastday = $item[$t];
                            $today = date('l');
                        @endphp
                        @if ($today == $value || $firstday == "Every day")
                            <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }} </strong>
                        @elseif ($firstday == "Every day")
                            <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @elseif ($value == "")
                            <strong>Close</strong>
                        @endif
                    @endforeach
                @endforeach
            </div>


        </div><a class="logo" href="{{ route('home') }}"><img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}" style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;"/></a>
        @foreach ($openday as $key => $item)
            @foreach ($item as $value)
                @php

                    $firsttime = strtotime($fromtime[$key]);
                    $lasttime = strtotime($totime[$key]);
                    $today = time();
                    $currentday = date('l');
                    $firstday = $item[0];

                @endphp

                @if ($today >= $firsttime && $today <= $lasttime)
                    @if ($currentday == $value || $firstday == "Every day")
                        <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s">
                            <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}"/>
                        </div>
                    @endif
                @else
                    @if ($currentday == $value || $firstday == "Every day")
                        <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s">
                            <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}"/>
                        </div>
                    @endif
                @endif
            @endforeach
        @endforeach
        <a class="open-mobile-menu" href="javascript:void(0)">
            <span class="text-uppercase">menu</span>
            <i class="fas fa-bars"></i></a>
      </div>
    </div>
  </header>
