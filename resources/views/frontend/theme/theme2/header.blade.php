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

{{-- Header --}}
<header class="header-v2">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
        <div class="container">
            <!-- restaurant açık ise open kapalı ise closed clas'ını kullanın-->
            @php
            $openday =$openclose['openday'];
            $fromtime = $openclose['fromtime'];
            $totime = $openclose['totime'];
            $closedate = $openclose['close_date'];
            $currentdate = strtotime(date("Y-m-d"));
            $closedates = explode(',',$closedate);
            $date_close1 = array();
            foreach ($closedates as $value) {
                $date_close = strtotime($value);
                $date_close1[] = $date_close;
            }
            @endphp
            @if (in_array($currentdate,$date_close1))
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @else
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
                        @php
                            $firstday = $item[0];
                            $firsttime = strtotime($fromtime[$key]);
                            $lasttime = strtotime($totime[$key]);
                            $today = time();
                            $currentday = date('l');

                        @endphp
                            @if ($today >= $firsttime && $today <= $lasttime)
                                @if ($currentday == $value || $firstday == "Every day")
                                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                        <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                                    </div>
                                @endif
                            @else
                                @if ($currentday == $value || $firstday == "Every day")
                                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                                        <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                                    </div>
                                @endif
                            @endif
                    @endforeach
                @endforeach
            @endif
            {{-- @if ($store_open_close == 1)
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @else
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @endif --}}

            <a class="logo" href="{{ route('home') }}">
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}" style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;"/>
            </a>
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong>
                {{-- <span>{{ $openclose['fromtime'] }} - {{ $openclose['totime'] }}</span> --}}
                @if (in_array($currentdate,$date_close1))
                    <strong>Close</strong>
                @else
                    @foreach ($openday as $key => $item)
                        @foreach ($item as $value)
                        @php
                        $t = count($item)-1;
                        $firstday = $item[0];
                        $lastday = $item[$t];
                        $today = date('l');
                        $currentdate = strtotime(date("Y-m-d"));
                        @endphp
                            @if ($today == $value)
                                <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                            @elseif ($firstday == "Every day")
                                <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                            @endif                        
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container">
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
                    <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contactUs')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                </li>
            </ul>
            <div class="__right">
                {{-- <ul class="authentication-links">
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#login">
                            <i class="far fa-user"></i><span>Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#login">
                            <i class="fas fa-sign-in-alt"></i><span>Register</span>
                        </a>
                    </li>
                </ul> --}}
                @if (!empty($userlogin))
                <ul class="authentication-links">
                    <li class="d-flex"><p class="m-0 text-white"></p>&nbsp;<a href="{{ route('member') }}"> ({{ $userlogin }})</a></li>
                    <li>
                        <form method="POST" action="{{ route('customerlogout') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="bg-transparent border-0"><i class="fas fa-sign-out-alt" style="color: {{ isset($template_setting['polianna_navbar_link']) ? $template_setting['polianna_navbar_link'] : 'white'; }}"></i><span style="color: {{ isset($template_setting['polianna_navbar_link']) ? $template_setting['polianna_navbar_link'] : 'white'; }}">Logout</span></button>
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
                {{-- <a class="menu-shopping-cart" href="{{ route('cart') }}">
                    <div class="number">
                        <i class="fas fa-shopping-basket"></i><span id="cart_products">0</span>
                    </div>
                    <div class="price-box">
                        <strong>My Cart : </strong>
                        <div class="price">
                            <i class="fas fa-euro-sign"></i><span class="pirce-value"> {{ $headertotal }}</span>
                        </div>
                    </div>
                </a> --}}
                <a class="menu-shopping-cart" href="{{ route('cart') }}">
                    <div class="number">
                        <i class="fas fa-shopping-basket"></i><span id="cart_products" class="bg-danger">{{ ($cart_products) }}</span>
                    </div>
                    <div class="price-box">
                        <strong>Shopping Cart</strong>
                        <div class="price">
                            <i class="fas fa-pound-sign"></i> <span class="pirce-value">{{ $headertotal }}</span>
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
{{-- End Header --}}


{{-- @php
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
        $currentdate = strtotime(date("Y-m-d"));
        // if (in_array($currentdate,$date_close1)) {
        //     echo "Close";
        // }
        // else {
        //     echo "Open";
        // }
        // die;

        $firstday = $item[0];
        $firsttime = strtotime($fromtime[$key]);
        $lasttime = strtotime($totime[$key]);
        $today = time();
        $currentday = date('l');
            // echo '<pre>';
            // print_r($date_close1);
            // echo "<br>";
            // print_r($currentdate);
            // exit();
    @endphp
    @if (in_array($currentdate,$date_close1))
        {{ "Close" }}
        <div class="open wow animate__bounceInDown" data-wow-duration="1s">
            <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
        </div>
    @else
        @if ($today >= $firsttime && $today <= $lasttime)
            @if ($currentday == $value || $firstday == "Every day")
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @endif
        @else
            @if ($currentday == $value || $firstday == "Every day")
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @endif
        @endif
    @endif
@endforeach
@endforeach
@php
    exit;
@endphp --}}