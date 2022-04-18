@php
$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');

$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;

@endphp
<style>
    .menu li:hover a {
        color: <?php echo $template_setting['polianna_navbar_link_hover']; ?> !important;
    }

</style>

<header class="header-v3">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
        <div class="container">
            <div class="working-time"><strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span>
            </div>
            <div class="__right-content">
                <ul class="authentication-links">
                    <li><a href="#"><i class="far fa-user"></i><span>Login</span></a></li>
                    <li><a href="#"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
                </ul><a class="menu-shopping-cart" href="">
                    <div class="number"><i class="fas fa-shopping-basket"></i><span>2</span></div>
                    <div class="price-box"><strong>Shopping Cart:</strong>
                        <div class="price"><i class="fas fa-dollar-sign"></i><span
                                class="pirce-value">32.10</span></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container"><a class="logo" href="#slide">
                {{-- <img class="attach img-fluid" src="{{ asset('public/assets/theme3/img/icon/logo-attach.svg') }}" />
            <img class="img-fluid" src="{{ asset('public/assets/theme3/img/logo/logo.svg') }}" /></a> --}}
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}"
                    style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;" />

                <ul class="menu">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('home') }}" style="color:{{ request()->is('menu') ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                    </li>
                    <li>
                        <a class="text-uppercase" href="#" style="color:{{ request()->is('menu') ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                    </li>
                    <li class="{{ request()->is('menu') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('menu') }}" style="color:{{ request()->is('menu') ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                    </li>
                    <li>
                        <a class="text-uppercase" href="#" style="color:{{ request()->is('menu') ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                    </li>
                    <li class="{{ request()->is('contact') ? 'active' : '' }}">
                        <a class="text-uppercase" href="{{ route('contact') }}" style="color:{{ request()->is('menu') ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                    </li>
                </ul>
                <!-- restaurant açık ise open kapalı ise closed clas'ını kullanın-->
                {{-- <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ asset('public/assets/theme3/img/icon/open.svg') }}" />
                    <img class="img-fluid" src="{{ asset('public/assets/theme3/img/icon/closed.svg') }}" />
                </div> --}}
                @if ($store_open_close == 1)
                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                        <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}"
                            style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                    </div>
                @else
                    <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                        <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}"
                            style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;" />
                    </div>
                @endif
                <a class="open-mobile-menu" href="javascript:void(0)"><span class="text-uppercase">menu</span><i
                        class="fas fa-bars"></i></a>
        </div>
    </div>
</header>
