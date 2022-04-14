@php
    $template_setting = session('template_settings');
@endphp

{{-- Header --}}
<header class="header-v2">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
        <div class="container">
            <!-- restaurant açık ise open kapalı ise closed clas'ını kullanın-->
            <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s">
                <img class="img-fluid" src="{{ asset('public/assets/theme2/img/icon/open.svg') }}"/>
                <img class="img-fluid" src="{{ asset('public/assets/theme2/img/icon/closed.svg') }}"/>
            </div>
            <a class="logo" href="#slide">
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}" style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;"/>
            </a>
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span>
            </div>
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container">
            <ul class="menu">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('member')) ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                </li>
                <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('menu')) ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('contactUs')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
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
