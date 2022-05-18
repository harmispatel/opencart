
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
    .menu li:hover a{
        color: <?php echo $template_setting['polianna_navbar_link_hover'] ?>!important;
    }

    .login-details-inr {
    display: inline-block;
    position: relative;
    margin-bottom: 10px;
    }
    .login-details-inr::before {
        border-left: 1px solid #ccc;
        color: #ccc;
        float: none;
        font-size: 16px;
        height: 22px;
        line-height: 22px;
        margin: 0;
        padding-left: 5px;
        padding-right: 25px;
        pointer-events: none;
        position: absolute;
        right: 0;
        text-align: center;
        top: 9px;
        width: 22px;
    }
    .login-details-inr input{
        padding: 10px;
    }
    .login-details-inr select{
        padding: 10px;
        appearance: none !important;
        background: none;
    }
    .modal-login h2, .new-account-modal h2{
        font-size: 18px;
    }
    /* .modal-login .btn,.new-account-modal .btn{
        background-color: #4ED58C;
        color: #fff;
    } */


</style>

{{-- Header Start --}}
<header class="header">
    <div class="container">
        <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
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
                            $t = count($item)-1;
                            $firstday = $item[0];
                            $lastday = $item[$t];
                            $today = date('l');
                        @endphp
                        @if ($today == $value)
                            &nbsp;<strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @elseif ($firstday == "Every day")
                            &nbsp;<strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @endif
                    @endforeach
                @endforeach
            </div>

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
                                <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                            </div>
                        @endif
                    @else
                        @if ($currentday == $value)
                            <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                            </div>
                        @endif
                    @endif
                @endforeach
            @endforeach

            <ul class="social-links">
                <li>
                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                </li>
            </ul>
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
            {{-- @guest
            @if (Route::has('customerlogin'))

                <li>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                        <i class="far fa-user"></i><span>{{ __('Login') }}</span>
                    </a>
                </li>
                
            @endif

            @if (Route::has('register'))

                <li>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#login">
                        <i class="fas fa-sign-in-alt"></i><span>{{ __('Register') }}</span>
                    </a>
                </li>
            @endif
        @else
        <li class="nav-item dropdown">
            <a type="button">
                {{ Auth::user()->firstname }}
            </a>

                <a class="dropdown-item" href="{{ route('customerlogout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('customerlogout') }}" method="POST" class="d-none">
                    @csrf
                </form>
        </li>
    @endguest --}}
        </div>
        <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
            <a class="logo" href="{{ route('home') }}">
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}" style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;"/>
            </a>
            <ul class="menu">
                <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                </li>
                <li class="{{ ((request()->is('member'))) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('member') }}" style="color: {{  (request()->is('member')) ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                </li>
                <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color:{{  (request()->is('menu')) ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                </li>
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
            <a class="menu-shopping-cart" href="{{ route('cart') }}">
                <div class="number">
                    <i class="fas fa-shopping-basket"></i><span id="cart_products">{{ $cart_products }}</span>
                </div>
                <div class="price-box">
                    <strong>Shopping Cart</strong>
                    <div class="price">
                        <i class="fas fa-pound-sign"></i> <span class="pirce-value">{{ $headertotal }}</span>
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