@php
    $openclose = openclosetime();
    $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $social = session('social_site');
    $social_site = isset($social) ? $social : '';

    $store_set = session('store_settings');
    $store_setting = isset($store_set) ? $store_set : '';
    
    $store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
  
    $userlogin = session('username');

    $Coupon = getCoupon();

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

<header class="header-v3">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
        <div class="container">
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong>
                {{-- <span>{{ $openclose['fromtime'] }} - {{ $openclose['totime'] }}</span> --}}
                @php
                $openday =$openclose['openday'];
                $fromtime = $openclose['fromtime'];
                $totime = $openclose['totime'];
                @endphp
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
          @php

            @endphp
                    @php
                    $t = count($item)-1;
                    $firstday = $item[0];
                    $lastday = $item[$t];
                    $today = date('l');
                    @endphp
                        @if ($today == $value)
                        <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @elseif ($firstday == "Every day")
                        <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @endif
                        @endforeach
                @endforeach
            </div>
            <div class="__right-content">
                {{-- <ul class="authentication-links">
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="far fa-user"></i><span>Login</span></a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
                </ul> --}}
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
                <a class="menu-shopping-cart" href="{{ route('cart') }}">
                    <div class="number"><i class="fas fa-shopping-basket"></i><span id="cart_products">{{ ($cart_products) }}</span></div>
                    <div class="price-box"><strong>Shopping Cart:</strong>
                        <div class="price"><i class="fas fa-dollar-sign"></i><span class="pirce-value">{{ $headertotal }}</span></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container">
            <a class="logo" href="{{route('home')}}">
                <img class="attach img-fluid" src="{{ asset('public/assets/theme3/img/icon/logo-attach.svg') }}" />
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}"
                    style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;" />
                <ul class="menu">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('home') }}" style="color:{{ request()->is('home') ? 'red' : $template_setting['polianna_navbar_link'] }};">home</a>
                    </li>
                    <li class="{{ request()->is('member') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('member') }}" style="color:{{ request()->is('member') ? 'red' : $template_setting['polianna_navbar_link'] }};">member</a>
                    </li>
                    <li class="{{ request()->is('menu') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('menu') }}" style="color:{{ request()->is('menu') ? 'red' : $template_setting['polianna_navbar_link'] }};">menu</a>
                    </li>
                    {{-- <li class="{{ request()->is('checkout') ? 'active' : '' }}">
                        <a class="text-uppercase" href="#" style="color:{{ request()->is('checkout') ? 'red' : $template_setting['polianna_navbar_link'] }};">check out</a>
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
                    <li class="{{ request()->is('contact') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('contact') }}" style="color:{{ request()->is('contact') ? 'red' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                    </li>
                </ul>
                <!-- restaurant açık ise open kapalı ise closed clas'ını kullanın-->
                @foreach ($openday as $key => $item)

                @foreach ($item as $value)
                    @php

                    $firsttime = strtotime($fromtime[$key]);
                    $lasttime = strtotime($totime[$key]);
                    $today = time();
                    $currentday = date('l');

                    @endphp

                    @if ($today >= $firsttime && $today <= $lasttime)
                        @if ($currentday == $value)
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}"
                                    style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                            </div>
                        @endif
                    @else
                        @if ($currentday == $value)
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}"
                                    style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                            </div>
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
                <a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i
                        class="fas fa-bars"></i></a>
        </div>
    </div>
</header>
