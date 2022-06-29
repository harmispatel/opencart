{{-- 
    THIS IS LAYOUT(THEME) 1 PAGE FOR FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    layout1.blade.php
    It Displayed Layout(Theme) 1
    ----------------------------------------------------------------------------------------------
--}}


{{--  CSS --}}
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;800&amp;display=swap" rel="stylesheet"/>
{{-- END CSS --}}

@php
    
    // Current URL
    $currentURL = URL::to("/");

    // Get Current Slider ID & Slider Settings
    $current_slider_id = layoutID($currentURL,'slider_id');
    $slider_id = $current_slider_id['slider_id'];
    $front_store_id =  $current_slider_id['store_id'];
    $store_slider_settings = storeLayoutSettings($slider_id,$front_store_id,'slider_settings','slider_id');

    // Get Current About ID & About Settings
    $current_about_id = layoutID($currentURL,'about_id');
    $about_id = $current_about_id['about_id'];
    $front_store_id =  $current_about_id['store_id'];
    $store_about_settings = storeLayoutSettings($about_id,$front_store_id,'about_settings','about_id');

    // Get Current BestCategory ID & BestCategory Settings
    $current_bestcategory_id = layoutID($currentURL,'bestcategory_id');
    $bestcategory_id = $current_bestcategory_id['bestcategory_id'];
    $front_store_id =  $current_bestcategory_id['store_id'];
    $store_bestcategory_settings = storeLayoutSettings($bestcategory_id,$front_store_id,'bestcategory_settings','bestcategory_id');

    $store_theme_settings = '';


    // Template Settings
    $template_setting = '';
    // End Template Settings

    // Social Site Settings
    $social_site = '';
    // End Social Site Settings

    // Store Settings
    $store_setting = '';
    // End Store Settings

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

    // Stores Reviews
    // $review = storereview();
    // End Stores Reviews

@endphp


<!-- Mobile Menu -->
<sidebar class="mobile-menu">
    <a class="close far fa-times-circle" href="#"></a>
    <a class="logo" href="{{ route('home') }}">
        <img class="img-fluid" src="{{ isset($template_setting['polianna_main_logo']) }}" style="width: {{ isset($template_setting['polianna_main_logo_width']) }}px; height: {{ isset($template_setting['polianna_main_logo_height']) }}px;"/>
    </a>
    <div class="top">
        <ul class="menu">
            <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('home') }}" style="color: {{  (request()->is('/')) ? 'white' : isset($template_setting['polianna_navbar_link']) }};">home</a>
            </li>
            <li>
                <a class="text-uppercase" href="#" style="color: {{  (request()->is('member')) ? 'white' : isset($template_setting['polianna_navbar_link']) }};">member</a>
            </li>
            <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('menu') }}" style="color:{{  (request()->is('menu')) ? 'white' : isset($template_setting['polianna_navbar_link']) }};">menu</a>
            </li>
            <li>
                <a class="text-uppercase" href="#" style="color: {{  (request()->is('checkout')) ? 'white' : isset($template_setting['polianna_navbar_link']) }};">check out</a>
            </li>
            <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contact')) ? 'white' : isset($template_setting['polianna_navbar_link']) }};">contact us</a>
            </li>
        </ul>
    </div>
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
                <a class="fab fa-facebook" href="{{isset( $social_site['polianna_facebook_id']) }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-twitter" href="{{isset( $social_site['polianna_twitter_username']) }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-google" href="mailto:{{isset( $social_site['polianna_gplus_id']) }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-linkedin" href="{{isset( $social_site['polianna_linkedin_id']) }}" target="_blank"></a>
            </li>
            <li>
                <a class="fab fa-youtube" href="{{isset( $social_site['polianna_youtube_id']) }}" target="_blank"></a>
            </li>
        </ul>
    </div>
</sidebar>
<!-- Emd Mobile Menu -->



{{-- SLIDER SECTIONS --}}

    {{-- SLIDER 1 --}}
    @if ($slider_id == 1)
        <section class="home-slide">
            {{-- Slider --}}
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide">
                            <strong class="title text-uppercase">Welcome To</strong>
                            <strong class="sub-title text-capitalize">{{ $slider->title }}</strong>
                            <img class="img-fluid" style="background-image: url('{{ $slider->image }}')"/>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="fas fa-arrow-left"></i>
                </div>
            </div>       
            {{-- End Slider --}}

            {{-- Online Order --}}
            @if ($store_slider_settings['slider_online_searchbox_permission'] == 1)
                <div class="order-online wow animate__fadeInUp" data-wow-duration="1s">
                    <strong class="title text-uppercase">order online</strong>
                    @if ($delivery_setting['enable_delivery'] != 'collection')
                        <div class="srch-input">
                            @if($delivery_setting['delivery_option'] == 'area')
                                <select name="search_input2" class="form-control"  id="search_store">
                                    <option value="">Select Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}">{{ $area }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input id="search_input1" placeholder="{{ $store_slider_settings['slider_online_searchbox_default'] }}" type="text"/>
                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                            @endif
                        </div>
                        <div class="enter_postcode">
                            <p>{{ $store_slider_settings['slider_online_searchbox_text'] }}</p>
                        </div>
                    @endif
                    <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
                    <div class="button_content1" style ="">
                        @if ($delivery_setting['enable_delivery'] != 'delivery')
                            <a class="btn btn-green text-uppercase collection_button1">collection</a>
                        @endif

                        @if ($delivery_setting['enable_delivery'] != 'collection')
                            <a class="btn btn-green text-uppercase delivery_button1">delivery</a>
                        @endif
                    </div>
                </div>
            @endif
            {{-- End Online Order --}}
        </section>
    @endif
    {{-- END SLIDER 1 --}}


    {{-- SLIDER 2 --}}
    @if ($slider_id == 2)
        <div class="home-slide-v2 swiper wow animate__fadeInDown" data-wow-duration="1s">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide" style="background-image: url('{{ $slider->image }}')">
                        <div class="container">
                            <h3 class="text-capitalize">{{ $slider->title }}</h3>
                            <img class="img-fluid __icon"
                                src="{{ get_css_url().'public/assets/theme2/img/icon/slide-divider.svg' }}" />
                            <p>{{ $slider->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="swiper-button-next"><i class="fas fa-chevron-right"></i></button>
            <button class="swiper-button-prev"><i class="fas fa-chevron-left"></i></button>
        </div>
    @endif
    {{-- END SLIDER 2 --}}


    {{-- SLIDER 3 --}}
    @if ($slider_id == 3)
        <section class="home-slide-v3 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-6 wow animate__fadeInLeft" data-wow-duration="1s">
                        <div class="order-online-v3">
                            <h1 class="__title">Welcome to 
                                <br><span>Your Store Name</span>
                            </h1>

                            @if ($store_slider_settings['slider_online_searchbox_permission'] == 1)
                                <strong class="title text-uppercase">order online</strong>
                                @if ($delivery_setting['enable_delivery'] != 'collection')
                                    <div class="srch-input">
                                        @if($delivery_setting['delivery_option'] == 'area')
                                            <select name="search_input2" class="form-control"  id="search_store" style="width: 300px !important;">
                                                <option value="">Select Area</option>
                                                @foreach($areas as $area)
                                                    <option value="{{ $area }}">{{ $area }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" id="search_input1" placeholder="{{ $store_slider_settings['slider_online_searchbox_default'] }}"/>
                                            <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                        @endif
                                    </div>
                                    <div class="enter_postcode">
                                        <p>{{ $store_slider_settings['slider_online_searchbox_text'] }}</p>
                                    </div>
                                @endif
                                <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
                                <div class="button_content1" style ="">
                                    @if ($delivery_setting['enable_delivery'] != 'delivery')
                                        <a class="btn btn-red text-uppercase collection_button1">collection</a>
                                    @endif
        
                                    @if ($delivery_setting['enable_delivery'] != 'collection')
                                        <a class="btn btn-red text-uppercase delivery_button1">delivery</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 wow animate__fadeInRight position-relative" data-wow-duration="1s">
                        <div class="swiper-text-content">
                            <div class="text-content">
                                <strong class="__title">Title</strong>
                            </div>
                            <div class="swiper-buttons">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($sliders as $slider)
                                    <div class="swiper-slide" style="background-image: url('{{ $slider->image }}')" data-title="{{ $slider->title }}"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- END SLIDER 3 --}}


    {{-- SLIDER 4 --}}
    @if ($slider_id == 4)
        <section class="home-slide-v4 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-7 position-relative">
                        <div class="__circle">
                            <div class="__thumbs-item">
                                @foreach ($sliders as $slider)                                    
                                    <a href="#" style="background-image: url('{{ $slider->image }}')" data-index="{{ $loop->index }}"></a>
                                    @if ($loop->iteration == 3)
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($sliders as $slider)                                    
                                    <div class="swiper-slide">
                                        <img class="img-fluid" src="{{ $slider->image }}" />
                                    </div>
                                    @if ($loop->iteration == 3)
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div class="order-online-v4">
                            <h1 class="__title">Welcome to <br>
                                <span>Store Name</span>
                            </h1>

                            @if ($store_slider_settings['slider_online_searchbox_permission'] == 1)
                                <div class="order-online text-center wow animate__fadeInUp" data-wow-duration="1s">
                                    <strong class="title text-uppercase">order online</strong>
                                    @if ($delivery_setting['enable_delivery'] != 'collection')
                                        <div class="srch-input">
                                            @if($delivery_setting['delivery_option'] == 'area')
                                                <select name="search_input2" class="form-control"  id="search_store">
                                                    <option value="">Select Area</option>
                                                    @foreach($areas as $area)
                                                        <option value="{{ $area }}">{{ $area }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" id="search_input1" placeholder="{{ $store_slider_settings['slider_online_searchbox_default'] }}">
                                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                            @endif
                                        </div>
                                        <div class="enter_postcode">
                                            <p>{{ $store_slider_settings['slider_online_searchbox_text'] }}</p>
                                        </div>
                                    @endif
                                    <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
                                    <div class="button_content1" style ="">
                                        @if ($delivery_setting['enable_delivery'] != 'delivery')
                                            <a class="btn btn-green text-uppercase collection_button1">collection</a>
                                        @endif
        
                                        @if ($delivery_setting['enable_delivery'] != 'collection')
                                            <a class="btn btn-green text-uppercase delivery_button1">delivery</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- END SLIDER 4 --}}


    {{-- SLIDER 5 --}}
    @if ($slider_id == 5)
        <section class="home-slide-v5 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                        <div class="order-online-v5">
                            <h2 class="__title">Store Name</h2>

                            @if ($store_slider_settings['slider_online_searchbox_permission'] == 1)
                                <div class="order-online wow animate__fadeInUp" data-wow-duration="1s" style="text-align: center">
                                    <strong class="title text-uppercase">order online</strong>
                                    @if ($delivery_setting['enable_delivery'] != 'collection')
                                        <div class="srch-input">
                                            @if($delivery_setting['delivery_option'] == 'area')
                                                <select name="search_input2" class="form-control"  id="search_store">
                                                    <option value="">Select Area</option>
                                                    @foreach($areas as $area)
                                                        <option value="{{ $area }}">{{ $area }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input id="search_input1" placeholder="{{ $store_slider_settings['slider_online_searchbox_default'] }}" type="text"/>
                                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                            @endif
                                        </div>
                                        <div class="enter_postcode">
                                            <p>{{ $store_slider_settings['slider_online_searchbox_text'] }}</p>
                                        </div>
                                    @endif

                                    <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>

                                    <div class="button_content1" style ="">
                                        @if ($delivery_setting['enable_delivery'] != 'delivery')
                                            <a class="btn btn-yellow text-uppercase collection_button1">collection</a>
                                        @endif
        
                                        @if ($delivery_setting['enable_delivery'] != 'collection')
                                            <a class="btn btn-yellow text-uppercase delivery_button1">delivery</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-lg-7 wow animate__fadeInRight position-relative" data-wow-duration="1s">
                        <div class="home-slide-v5-swiper swiper">
                            <div class="swiper-wrapper">
                                @foreach ($sliders as $slider)                                    
                                    <div class="swiper-slide">
                                        <img class="img-fluid" src="{{ $slider->image }}" />
                                    </div>                                
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- END SLIDER 5 --}}


    {{-- SLIDER 6 --}}
    @if ($slider_id == 6)
        <section class="home-slide-v6 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="home-slide-v6-swiper">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($sliders as $slider)                            
                            <div class="swiper-slide" style="background-image: url('{{ $slider->image }}')">
                                <div class="container">
                                    <div class="slide-logo">
                                        <img class="img-fluid" src="{{ $slider->logo }}" style="max-width: 150px;" />
                                    </div>
                                    <h2 class="__title">{{ $slider->title }}</h2>
                                    <p>{{ $slider->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        
            @if ($store_slider_settings['slider_online_searchbox_permission'] == 1)
                <div class="order-online-v6">
                    <strong class="title text-uppercase">order online</strong>
                    @if ($delivery_setting['enable_delivery'] != 'collection')
                        <div class="srch-input">
                            @if($delivery_setting['delivery_option'] == 'area')
                                <select name="search_input2" class="form-control"  id="search_store" style="width: 300px;">
                                    <option value="">Select Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}">{{ $area }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input id="search_input1" placeholder="{{ $store_slider_settings['slider_online_searchbox_default'] }}" type="text"/>
                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                            @endif
                        </div>
                        <div class="enter_postcode">
                            <p>{{ $store_slider_settings['slider_online_searchbox_text'] }}</p>
                        </div>
                        <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
                        <div class="button_content1" style ="">
                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                <a class="btn btn-red text-uppercase collection_button1">collection</a>
                            @endif
            
                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                <a class="btn btn-red text-uppercase delivery_button1">delivery</a>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            <div class="__btn-bottom"><i class="fas fa-arrow-down"></i></div>
        </section>
    @endif
    {{-- END SLIDER 6 --}}

{{-- END SLIDER SECTIONS --}}





{{-- HTML BOX SECTION --}}

        {{-- HTML BOX 1 --}}
        @if ($about_id == 1)
            <section class="welcome pt-110 pb-110">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 wow animate__fadeInLeft" data-wow-duration="1s">
                            <div style="height: 300px; overflow: hidden;" id="shopDescription">
                                <h3 class="section-title color-green">
                                    {{ $store_about_settings['about_title'] }}
                                </h3>
                                <p>
                                    {!! $store_about_settings['about_description'] !!}
                                </p>
                            </div>
                            <a class="btn mt-2 btn-green text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                            <a style="display: none;" class="btn mt-2 btn-green text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
                        </div>

                        <div class="col-sm-12 col-md-6 wow animate__fadeInRight" data-wow-duration="1s">
                            <div class="img-box">
                                 <img class="img-fluid" src="{{ $store_about_settings['about_image'] }}"/>                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>    
        @endif
        {{-- END HTML BOX 1 --}}


        {{-- HTML BOX 2 --}}
        @if ($about_id == 2)
            <div class="about-us container wow animate__fadeInUp" data-wow-duration="1s">
                <div class="row">
                    <div class="col-md-12 col-lg-6 img">
                        <img class="img-fluid" src="{{ $store_about_settings['about_image'] }}" />                       
                    </div>
                    <div class="col-md-12 col-lg-6 content">
                        <h3 class="title text-uppercase text-center">{{ $store_about_settings['about_title'] }}</h3>
                        <p>{!! $store_about_settings['about_description'] !!}</p>
                
                        <div class="about-us-swiper swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/1.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/2.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/3.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/1.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/2.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/3.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/1.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/2.jpg' }}"/></div>
                                <div class="swiper-slide"><img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/3.jpg' }}"/></div>
                            </div>
                            <button class="swiper-button-next"></button>
                            <button class="swiper-button-prev"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- END HTML BOX 2 --}}


        {{-- HTML BOX 3 --}}
        @if ($about_id == 3)
            <section class="who-are-we pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="container text-center">                    
                    <div class="default-title-v3">
                        <h3 class="title color-green">{{ $store_about_settings['about_title'] }}</h3>
                    </div>
                    <div>{!! $store_about_settings['about_description'] !!}</div>
                </div>
            </section>
        @endif
        {{-- END HTML BOX 3 --}}


        {{-- HTML BOX 4 --}}
        @if ($about_id == 4)
            <section class="who-are-we-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">                            
                            <div class="default-title-v4">
                                <strong class="sub-title">{{ $store_about_settings['about_title'] }}</strong>
                            </div>
                            <div>{!! $store_about_settings['about_description'] !!}</div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <img class="rounded-circle" style="width: 400px;height: 400px;" src="{{ $store_about_settings['about_image'] }}" />
                        </div>
                    </div>
                </div>
            </section>
        @endif
        {{-- END HTML BOX 4 --}}


        {{-- HTML BOX 5 --}}
        @if ($about_id == 5)
            <section class="who-are-we-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <img class="img-fluid" src="{{ $store_about_settings['about_image'] }}" />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div style="height: 300px; overflow: hidden;" id="shopDescription">
                                <div class="default-title-v5">
                                    <strong class="sub-title color-orange text-uppercase">{{ $store_about_settings['about_title'] }}</strong>
                                </div>
                                <div>{!! $store_about_settings['about_description'] !!}</div>
                            </div>
                            <a class="btn mt-2 btn-orange text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                            <a style="display: none;" class="btn mt-2 btn-orange text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        {{-- END HTML BOX 5 --}}


        {{-- HTML BOX 6 --}}
        @if ($about_id == 6)
            <section class="who-are-we-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="container p-4">
                    <div style="height: 300px; overflow: hidden;" id="shopDescription">
                        <div class="default-title-v6">
                            <strong class="sub-title color-orange text-uppercase">{{ $store_about_settings['about_title'] }}</strong>
                        </div>
                        <div>{!! $store_about_settings['about_description'] !!}</div>                    
                    </div>

                    <a class="btn mt-3 text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                    <a style="display: none;" class="btn mt-3 text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
                </div>
            </section>
        @endif
        {{-- END HTML BOX 6 --}}

{{-- END HTML BOX SECTION --}}





{{-- BEST CATEGORY SECTION --}}

    {{-- BEST CATEGORY 1 --}}
    @if ($bestcategory_id == 1)
        <section class="categories pt-110 pb-110">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <h3 class="section-title color-red">{{ $store_bestcategory_settings['bestcategory_title'] }}</h3>
                <p class="text">{{ $store_bestcategory_settings['bestcategory_description'] }}</p>
                @if(count($best_categories) > 0)
                    <div class="categories-swiper">
                        <div class="swiper-button-next">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="swiper-button-prev">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <div class="swiper">
                            <div class="swiper-wrapper">                        
                                @foreach ($best_categories as $categorydet)
                                    <a class="swiper-slide" href="#">
                                        <div class="img">
                                            @if (isset($categorydet->hasOneCategoryDetails['image']))
                                                <img class="img-fluid" src="{{$categorydet->hasOneCategoryDetails['image'] }}"/>
                                            @else
                                                <img class="img-fluid" src="{{ get_css_url().'public/admin/product/no_image.jpg' }}">
                                            @endif
                                        </div>
                                        <strong>{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Best Categories not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END BEST CATEGORY 1 --}}


    {{-- BEST CATEGORY 2 --}}
    @if ($bestcategory_id == 2)
        <section class="categories-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="default-title-v2 text-center">
                    <h3 class="title color-red">{{ $store_bestcategory_settings['bestcategory_title'] }}</h3>
                    <p class="text">{{ $store_bestcategory_settings['bestcategory_description'] }}</p>
                </div>
                <div class="categories-swiper-v2 position-relative">
                    @if(count($best_categories) > 0)
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($best_categories as $categorydet)
                                    <a class="swiper-slide" href="#">
                                        <div class="img">
                                            @if (isset($categorydet->hasOneCategoryDetails['image']))
                                                <img class="img-fluid" src="{{$categorydet->hasOneCategoryDetails['image'] }}"/>
                                            @else
                                                <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                            @endif
                                        </div>
                                        <strong>{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                                        @php
                                            $cat_desc = html_entity_decode($categorydet->hasOneCategoryDetails->hasOneCategory['description']);
                                        @endphp
                                        <p>{{ substr($cat_desc,0,20) }}...</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3><code>Best Categories not Found !</code></h3>
                            </div>
                        </div>
                    @endif                    
                </div>
            </div>
        </section>
    @endif
    {{-- END BEST CATEGORY 2 --}}


    {{-- BEST CATEGORY 3 --}}
    @if ($bestcategory_id == 3)
        <section class="best-categories-icon pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v3 text-center container">
                <h3 class="title text-capitalize color-green">{{ $store_bestcategory_settings['bestcategory_title'] }}</h3>
                <p>{{ $store_bestcategory_settings['bestcategory_description'] }}</p>
            </div>
            <div class="container">
                @if(count($best_categories) > 0)
                    <div class="row list-item">                    
                        @foreach ($best_categories as $categorydet)
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="item">
                                    <div class="img">
                                        @if (isset($categorydet->hasOneCategoryDetails['image']))                                            
                                            <img class="img-fluid" src="{{$categorydet->hasOneCategoryDetails['image'] }}" />
                                        @else
                                            <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                        @endif
                                    </div>
                                    <strong>{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                                </div>
                            </div>
                        @endforeach                   
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Best Categories not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END BEST CATEGORY 3 --}}


    {{-- BEST CATEGORY 4 --}}
    @if ($bestcategory_id == 4)
        <section class="best-categories-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v4 text-center container"><strong class="sub-title color-green">Your Choose</strong>
                <h3 class="title text-capitalize">{{ $store_bestcategory_settings['bestcategory_title'] }}</h3>
                <p>{{ $store_bestcategory_settings['bestcategory_description'] }}</p>
            </div>
            <div class="container">
                <div class="row list-item">
                    @if(count($best_categories) > 0)
                        @foreach ($best_categories as $categorydet)
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="item">
                                    <div class="img">
                                        @if (isset($categorydet->hasOneCategoryDetails['image']))
                                            <img class="img-fluid" src="{{$categorydet->hasOneCategoryDetails['image'] }}" />
                                        @else
                                            <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                        @endif
                                    </div>
                                    <strong class="p-3">{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                                    <p class="p-3">{{ html_entity_decode(substr($categorydet->hasOneCategoryDetails->hasOneCategory['description'],0,20)) }}...</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Best Categories not Found !</code></h3>
                        </div>
                    @endif
            </div>
        </section>
    @endif
    {{-- END BEST CATEGORY 4 --}}

{{-- END BEST CATEGORY SECTION --}}




<!-- Popular Foods Section -->
<section class="popular-foods">
    <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <h3 class="section-title color-green">Popular Foods</h3>
        <p class="text">Pizza is the topmost liked food in the world. Today you can find pizza in almost every corner of the world. This traditional Italian dish is made of flattened round dough topped with cheese, and tomatoes, and additionally garnished with basil, olives, and oregano.</p>
        <div class="popular-foods-swiper">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @if (count($popular_foods) > 0)
                        @foreach ($popular_foods as $food)
                            <a class="swiper-slide" href="#">
                                <div class="box">
                                    <div class="img">
                                        @if (isset($food->hasOneProduct['image']))
                                            <img class="img-fluid" src="{{$food->hasOneProduct['image'] }}">
                                        @else
                                            <img class="img-fluid" src="{{ get_css_url().'public/admin/product/no_image.jpg' }}">
                                        @endif
                                    </div>
                                    <strong>{{ isset($food->hasOneProduct->hasOneProductDescription['name']) ? $food->hasOneProduct->hasOneProductDescription['name'] : '' }}</strong>
                                    @php
                                        $desc = html_entity_decode(isset($food->hasOneProduct->hasOneProductDescription['description']) ? $food->hasOneProduct->hasOneProductDescription['description'] : '');
                                        $description = strip_tags($desc);

                                        if($description == '')
                                        {
                                            echo '<p>-</p>';
                                        }
                                        else
                                        {
                                            echo '<p>'.substr($description,0,30).'</p>';
                                        }
                                    @endphp
                                </div>
                            </a>
                        @endforeach
                    @else
                        <a class="swiper-slide">
                            <h3>Foods NOt Available</h3>
                        </a>
                    @endif
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- End Popular Foods Section -->


<!-- Reviews Section -->
<section class="user-comments pt-110 pb-110">
    <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <h3 class="section-title color-red">Recent Web Reviews</h3>
        <div class="user-comments-swiper">
            <div class="swiper">
                <div class="swiper-wrapper">
                    {{-- @foreach ($review['reviews'] as $item)
                        <div class="swiper-slide">
                            <div class="message-text">
                                <strong>{{isset($item->title) ? $item->title : '' }}</strong>
                            </div>
                            <div class="message-text">
                                <p>{{ $item->message }}</p>
                            </div>
                            <div class="message-info">
                                <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                            </div>
                        </div>
                    @endforeach --}}
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- End Reviews Section -->


<!-- Reservation Section -->
<section class="reservation pt-110 pb-110">
    <div class="container wow animate__fadeInUp" data-wow-duration="1s">
        <h3 class="section-title color-green divider-white text-capitalize">make a reservation</h3>
        <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
        <form class="row" method="POST" action="{{ route('reservation') }}">
            {{ csrf_field() }}
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" name="fullname" placeholder="Full Name" type="text" required/>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" name="phone" placeholder="Phone Number" type="text" required/>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                    <select class="form-control bg-dark" name="person" required>
                        <option value="">Person</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control text-white" style="color-scheme: dark;" name="date" id="date" type="date" required/>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" style="color-scheme: dark;" name="time" id="time" type="time" required/>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <button class="btn btn-green text-capitalize">make reservation now<i class="fas fa-arrow-right"></i></button>
            </div>
        </form>
    </div>
</section>
<!-- End Reservation Section -->


<!-- Galary Section -->
@if (!empty(isset($store_setting['enable_gallery_module'])) || isset($store_setting['enable_gallery_module']) != 0)   
    <section class="photo-gallery pt-110 pb-110">
        <div class="container wow animate__fadeInUp" data-wow-duration="1s">
            @if(!empty($store_setting['gallery_header_text']))
                <h3 class="section-title color-green divider-white text-capitalize">{{ $store_setting['gallery_header_text'] }}</h3>
            @else
                <h3 class="section-title color-green divider-white text-capitalize">Photo Gallary</h3>
            @endif
            
            @if(!empty($store_setting['gallery_header_desc']))
                <p class="text">{{ $store_setting['gallery_header_desc'] }}</p>
            @endif
        </div>
        <div class="container-fluid wow animate__fadeInUp" data-wow-duration="1s">
            <div class="row">
                @if(count($photos) > 0)
                    @foreach ($photos as $photo)
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="box">
                            <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a>
                            <img class="img-fluid" src="{{ $photo->image }}"/>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-md-13 text-center">
                        <h3>Images Not Available.</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif.
<!-- End Galary Section -->


<!-- Time Section -->
<section class="opening-hours pt-110 wow animate__fadeInUp" data-wow-duration="1s" style="background-image: url({{ get_css_url().'public/assets/theme1/img/bg/opening-hours-bg.jpg'}}">
    <div class="container text-center">
        <h3 class="title">Visit us</h3>
        <h3 class="sub-title">Opening Hours</h3><img class="img-fluid" src="{{ get_css_url().'public/assets/theme1/img/icon/opening-hours.svg' }}"/>
        @php
            $openday =$openclose['openday'];
            $fromtime = $openclose['fromtime'];
            $totime = $openclose['totime'];
        @endphp
        @foreach ($openday as $key => $item)
            @php
                $t = count($item)-1;
                $firstday = $item[0];
                $lastday = $item[$t];
            @endphp
            @if ($firstday == $lastday)
                <p>{{ $firstday }} {{ $fromtime[$key] }} - {{ $totime[$key] }}</p>
            @else
                <p>{{ $firstday }} to {{ $lastday }} {{ $fromtime[$key] }} - {{ $totime[$key] }}</p>
            @endif
        @endforeach
    </div>
</section>
<!-- End Time Section -->

