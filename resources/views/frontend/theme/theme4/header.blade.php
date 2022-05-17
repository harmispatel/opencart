@php
 $openclose = openclosetime();
$temp_set = session('template_settings');
$template_setting = isset($temp_set) ? $temp_set : '';

$social = session('social_site');
$social_site = isset($social) ? $social : '';

$store_set = session('store_settings');
$store_setting = isset($store_set) ? $store_set : '';

$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;

@endphp

<style>
    .menu li:hover a {
        color: <?php echo $template_setting['polianna_navbar_link_hover']; ?> !important;
    }

</style>
<header class="header-v4">
    <div class="header-top wow animate__fadeInDown" data-wow-duration="1s">
        <div class="container">
            <div class="social-links">
                <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}"></a>
                <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}"></a>
                <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}"></a>
                <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}"></a>
            </div>
            <!-- restaurant açık ise open kapalı ise closed clas'ını kullanın-->
            <div class="restaurant-status open wow animate__bounceInDown" data-wow-duration="1s">
                @php
                $openday =$openclose['openday'];
                $fromtime = $openclose['fromtime'];
                $totime = $openclose['totime'];
                @endphp
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
            </div>
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong>
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
        </div>
    </div>
    <div class="header-bottom wow animate__fadeInDown" data-wow-duration="1s" style="background: {{ $template_setting['polianna_navbar_background'] }};">
        <div class="container">
            <a class="logo" href="{{ route('home') }}">
                <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}"
                    style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;" />
            </a>
            <ul class="menu">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : $template_setting['polianna_navbar_link'] }};">home</a>
                </li>
                <li class="{{ (request()->is('member')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="#" style="color: {{  (request()->is('member')) ? 'white' : $template_setting['polianna_navbar_link'] }};">member</a>
                </li>
                <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="{{ route('menu') }}" style="color: {{  (request()->is('menu')) ? 'white' : $template_setting['polianna_navbar_link'] }};">menu</a>
                </li>
                <li class="{{ (request()->is('checkout')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="#" style="color: {{  (request()->is('checkout')) ? 'white' : $template_setting['polianna_navbar_link'] }};">check out</a>
                </li>
                <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                  <a class="text-uppercase" href="#" style="color: {{  (request()->is('contact')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
                </li>
            </ul>
            <div class="__btn-group"><a class="btn __purple text-capitalize" href="#"><i
                        class="fas fa-shopping-cart"></i>my cart</a><a class="btn __green text-capitalize"
                    href="#" data-bs-toggle="modal" data-bs-target="#login">login or signup</a></div><a class="open-mobile-menu" href="javascript:void(0)"><span
                    class="text-uppercase">menu</span><i class="fas fa-bars"></i></a>
        </div>
    </div>
</header>
