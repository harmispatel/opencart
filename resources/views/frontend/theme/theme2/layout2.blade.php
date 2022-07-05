<!--
    THIS IS LAYOUT(THEME) 2 PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    layout2.blade.php
    It Displayed Layout(Theme) 2
    ----------------------------------------------------------------------------------------------
-->

<link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;700&amp;family=Oswald:wght@400;500&amp;family=Raleway:wght@400;700&amp;display=swap" rel="stylesheet" />

@php
   
   // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = layoutID($currentURL,'header_id');
    $theme_id = $current_theme_id['header_id'];
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

    // Slider Permission
    $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;
    // End Slider Permission

    // Online Order Permission
    $online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
    // End Online Order Permission

    // Stores Reviews
    $review = storereview();
    // End Stores Reviews

@endphp

<style>

    

</style>
<div class="mobile-menu-shadow"></div>
<sidebar class="mobile-menu">
    <a class="close far fa-times-circle" href="#"></a>
    <a class="logo" href="#slide">
        <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}"
            style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;" />
    </a>
    <div class="top">
        <ul class="menu">
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('home') }}">home</a>
            </li>
            <li class="{{ request()->is('member') ? 'active' : '' }}">
                <a class="text-uppercase" href="#">member</a>
            </li>
            <li class="{{ request()->is('menu') ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
            </li>
            <li class="{{ request()->is('checkout') ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
            </li>
            <li class="{{ request()->is('contact') ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
            </li>
        </ul>
    </div>
    <div class="center">
        <ul class="authentication-links">
            <li><a href="#"><i class="far fa-user"></i><span>Login</span></a></li>
            <li><a href="#"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
        </ul>
    </div>
    <div class="bottom">
        <div class="working-time"><strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span>
        </div>
        <ul class="social-links">
            <li>
                <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
            </li>
        </ul>
    </div>
    <div class="home-slide-v2 swiper wow animate__fadeInDown" data-wow-duration="1s">
        <div class="swiper-wrapper">
            <div class="center">
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
            <div class="bottom">
                <div class="working-time">
                    <strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span>
                </div>
                <ul class="social-links">
                    <li>
                        <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                    </li>
                    <li>
                        <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                    </li>
                    <li>
                        <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                    </li>
                    <li>
                        <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</sidebar>
