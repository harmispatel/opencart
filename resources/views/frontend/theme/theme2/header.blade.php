@php
    $openclose = openclosetime();
    $template_setting = session('template_settings');
    $social_site = session('social_site');
    $store_setting = session('store_settings');
    $store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
    $template_setting = session('template_settings');
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
            @endphp
            @foreach ($openday as $key => $item)
            @foreach ($item as $value)
                @php
                    date_default_timezone_set("Asia/kolkata");
                    $t = count($item)-1;
                    $firstday = $item[0];
                    $firsttime = date('G', strtotime($fromtime[$key]));
                    $lastday = $item[$t];
                    $lasttime = date('G', strtotime($totime[$key]));
                    $today = date('G');
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
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
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
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container">
            <ul class="menu">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                </li>
                <li class="{{ (request()->is('member')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('member')) ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                </li>
                <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('menu')) ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                </li>
                <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                </li>
                <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contactUs')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                </li>
            </ul>
            <div class="__right">
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
                <a class="menu-shopping-cart" href="">
                    <i class="fas fa-shopping-basket"></i>
                    <div class="price-box">
                        <strong>Shopping Cart:</strong>
                        <div class="price">
                            <i class="fas fa-dollar-sign"></i><span class="pirce-value">32.10</span>
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
