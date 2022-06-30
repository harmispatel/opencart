<!--
    THIS IS LAYOUT(THEME) 6 PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    layout6.blade.php
    It Displayed Layout(Theme) 6
    ----------------------------------------------------------------------------------------------
-->

<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;700&amp;display=swap" rel="stylesheet" />
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

<div class="mobile-menu-shadow"></div>
<sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
        href="#slide"><img class="img-fluid"
            src="{{ asset('public/assets/theme6/img/logo/black-logo.svg') }}" /></a>
    <div class="top">
        <ul class="menu">
            <li class="active"><a class="text-uppercase" href="{{ route('home') }}">home</a></li>
            <li><a class="text-uppercase" href="{{ route('member') }}">member</a></li>
            <li><a class="text-uppercase" href="{{ route('menu') }}">menu</a></li>
            <li><a class="text-uppercase" href="{{ route('checkout') }}">check out</a></li>
            <li><a class="text-uppercase" href="{{ route('contact') }}">contact us</a></li>
        </ul>
    </div>
    <div class="center">
        <ul class="authentication-links">
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="far fa-user"></i><span>Login</span></a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
        </ul>
    </div>
    <div class="bottom">
        <div class="working-time">
            <strong class="text-uppercase">Working Time:</strong>
            {{-- <span>09:00 - 23:00</span> --}}
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
                    @if (!empty($value))
                        <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                    @else
                    {{-- <strong class="text-white">Today Close</strong> --}}
                    @endif
                @endif
            @endforeach
        @endforeach
        </div>
        <ul class="social-links">
            <li><a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a></li>
            <li><a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a></li>
        </ul>
    </div>
</sidebar>


