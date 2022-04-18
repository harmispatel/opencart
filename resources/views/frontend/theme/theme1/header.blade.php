
@php
    $template_setting = session('template_settings');
    $social_site = session('social_site');
    $store_setting = session('store_settings');

    $store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;

@endphp

<style>
    .menu li:hover a{
        color: <?php echo $template_setting['polianna_navbar_link_hover'] ?>!important;
    }


</style>

{{-- Header Start --}}
<header class="header">
    <div class="container">
        <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span>
            </div>

            @if ($store_open_close == 1)
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_open_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @else
                <div class="open wow animate__bounceInDown" data-wow-duration="1s">
                    <img class="img-fluid" src="{{ $template_setting['polianna_close_banner'] }}" style="width: {{ $template_setting['polianna_open_close_banner_width'] }}px; height: {{ $template_setting['polianna_open_close_banner_height'] }}px;"/>
                </div>
            @endif

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
        <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
            <a class="logo" href="#slide">
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}" style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;"/>
            </a>
            <ul class="menu">
                <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                </li>
                <li>
                    <a class="text-uppercase" href="#" style="color: {{  (request()->is('member')) ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                </li>
                <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                    <a class="text-uppercase" href="{{ route('menu') }}" style="color:{{  (request()->is('menu')) ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                </li>
                <li>
                    <a class="text-uppercase" href="#" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contactUs')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                </li>
            </ul>
            <a class="menu-shopping-cart" href="">
                <div class="number">
                    <i class="fas fa-shopping-basket"></i><span>2</span>
                </div>
                <div class="price-box">
                    <strong>Shopping Cart:</strong>
                    <div class="price">
                        <i class="fas fa-dollar-sign"></i><span class="pirce-value">32.10</span>
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
{{-- End Header --}}
