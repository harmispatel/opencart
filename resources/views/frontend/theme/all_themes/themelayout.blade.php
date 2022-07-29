{{--
    THIS IS LAYOUT(THEME) 1 PAGE FOR FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    layout1.blade.php
    It Displayed Layout(Theme) 1
    ----------------------------------------------------------------------------------------------
--}}


@php

    // Current URL
    $currentURL = URL::to("/");


    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];


    // Get Current Slider ID & Slider Settings
    $current_slider_id = layoutID($currentURL,'slider_id');
    $slider_id = $current_slider_id['slider_id'];
    $store_slider_settings = storeLayoutSettings($slider_id,$front_store_id,'slider_settings','slider_id');

    // Slider Search Box Permission
    $slider_online_searchbox_permission = isset($store_slider_settings['slider_online_searchbox_permission']) ? $store_slider_settings['slider_online_searchbox_permission'] : '';

    // Get Current About ID & About Settings
    $current_about_id = layoutID($currentURL,'about_id');
    $about_id = $current_about_id['about_id'];
    $store_about_settings = storeLayoutSettings($about_id,$front_store_id,'about_settings','about_id');


    // Get Current BestCategory ID & BestCategory Settings
    $current_bestcategory_id = layoutID($currentURL,'bestcategory_id');
    $bestcategory_id = $current_bestcategory_id['bestcategory_id'];
    $store_bestcategory_settings = storeLayoutSettings($bestcategory_id,$front_store_id,'bestcategory_settings','bestcategory_id');


    // Get Current PopularFood ID & PopularFood Settings
    $current_popularfood_id = layoutID($currentURL,'popularfood_id');
    $popularfood_id = $current_popularfood_id['popularfood_id'];
    $store_popularfood_settings = storeLayoutSettings($popularfood_id,$front_store_id,'popularfood_settings','popularfood_id');


    // Get Current Reviews ID & Reviews Settings
    $current_review_id = layoutID($currentURL,'review_id');
    $review_id = $current_review_id['review_id'];
    $store_review_settings = storeLayoutSettings($review_id,$front_store_id,'review_settings','reviews_id');


    // Get Current Reservation ID & Reservation Settings
    $current_reservation_id = layoutID($currentURL,'reservation_id');
    $reservation_id = $current_reservation_id['reservation_id'];
    $store_reservation_settings = storeLayoutSettings($reservation_id,$front_store_id,'reservation_settings','reservation_id');


    // Get Current Gallary ID & Gallary Settings
    $current_gallary_id = layoutID($currentURL,'gallary_id');
    $gallary_id = $current_gallary_id['gallary_id'];
    $store_gallary_settings = storeLayoutSettings($gallary_id,$front_store_id,'gallary_settings','gallary_id');


    // Get Current OpenHours ID & OpenHours Settings
    $current_openhour_id = layoutID($currentURL,'openhour_id');
    $openhour_id = $current_openhour_id['openhour_id'];
    $store_openhour_settings = storeLayoutSettings($openhour_id,$front_store_id,'openhour_settings','openhours_id');


    // Social Site Settings
    $social_site = isset($store_data['social_settings']) ? $store_data['social_settings'] : '';


    // Store Settings
    $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

    // Get Open-Close Time
    $open_close_data = openclosetime();

    // Store Open / Close
    $store_open_close = isset($openclose['store_open_close']) ? $openclose['store_open_close'] : 'close';

    // get opning_hours_setting
    $opning_hours = isset($open_close_data['opning_hours']) ? $open_close_data['opning_hours'] : '';
    
    // get Opening Hours & Days
    $opning_days = isset($open_close_data['opning_hours']['days']) ? $open_close_data['opning_hours']['days'] : '';
    $opning_from = isset($open_close_data['opning_hours']['from']) ? $open_close_data['opning_hours']['from'] : '';
    $opning_to = isset($open_close_data['opning_hours']['to']) ? $open_close_data['opning_hours']['to'] : '';

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';


    // Stores Reviews
    $review = storereview();

@endphp


{{--  CSS --}}
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;800&amp;display=swap" rel="stylesheet"/>

<?php 
    if($store_setting['gallery_background_options'] == 'transparent')
    {
?>
        <style>
            .photo-gallery, .photo-gallery-v2, .photo-gallery-v3, .photo-gallery-v4, .photo-gallery-v5, .photo-gallery-v6{
                background: transparent;
            }
        </style>
<?php
    }
    elseif ($store_setting['gallery_background_options'] == 'color') 
    {
?>
        <style>
            .photo-gallery, .photo-gallery-v2, .photo-gallery-v3, .photo-gallery-v4, .photo-gallery-v5, .photo-gallery-v6{
                background: <?php echo $store_setting['gallery_background_color']; ?>;
            }
        </style>
<?php
    }
    else 
    {
?>
        <style>
            .photo-gallery, .photo-gallery-v2, .photo-gallery-v3, .photo-gallery-v4, .photo-gallery-v5, .photo-gallery-v6{
                background: url('<?php echo $store_setting["gallery_background_image"] ?>');
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
<?php
    }
?>
{{-- END CSS --}}



<!-- Mobile Menu -->
<sidebar class="mobile-menu">
    <a class="close far fa-times-circle" href="#"></a>
    <a class="logo" href="{{ route('home') }}">
        <img class="img-fluid" src=""/>
    </a>
    <div class="top">
        <ul class="menu">
            <li class="{{ ((request()->is('/'))) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('home') }}">home</a>
            </li>
            <li>
                <a class="text-uppercase" href="#">member</a>
            </li>
            <li class="{{ (request()->is('menu')) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
            </li>
            <li>
                <a class="text-uppercase" href="#">check out</a>
            </li>
            <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('contact') }}">contact us</a>
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
                            <strong class="sub-title text-capitalize">{{ isset($slider->title) ? $slider->title : '' }}</strong>
                            <img class="img-fluid" style="background-image: url('{{ isset($slider->image) ? $slider->image : '' }}')"/>
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
            @if ($slider_online_searchbox_permission == 1)
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
                                <input id="search_input1" placeholder="{{ isset($store_slider_settings['slider_online_searchbox_default']) ? $store_slider_settings['slider_online_searchbox_default'] : '' }}" type="text"/>
                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                            @endif
                        </div>
                        <div class="enter_postcode">
                            <p>{{ isset($store_slider_settings['slider_online_searchbox_text']) ? $store_slider_settings['slider_online_searchbox_text'] : '' }}</p>
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
                    <div class="swiper-slide" style="background-image: url('{{ isset($slider->image) ? $slider->image : '' }}')">
                        <div class="container">
                            <h3 class="text-capitalize">{{ isset($slider->title) ? $slider->title : '' }}</h3>
                            <img class="img-fluid __icon"
                                src="{{ get_css_url().'public/assets/theme2/img/icon/slide-divider.svg' }}" />
                            <p>{{ isset($slider->description) ? $slider->description : '' }}</p>
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
                                <br><span>{{ isset($store_setting['config_name']) ? $store_setting['config_name'] : '' }}</span>
                            </h1>

                            @if ($slider_online_searchbox_permission == 1)
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
                                            <input type="text" id="search_input1" placeholder="{{ isset($store_slider_settings['slider_online_searchbox_default']) ? $store_slider_settings['slider_online_searchbox_default'] : '' }}"/>
                                            <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                        @endif
                                    </div>
                                    <div class="enter_postcode">
                                        <p>{{ isset($store_slider_settings['slider_online_searchbox_text']) ? $store_slider_settings['slider_online_searchbox_text'] : '' }}</p>
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
                                    <div class="swiper-slide" style="background-image: url('{{ isset($slider->image) ? $slider->image : '' }}')" data-title="{{ isset($slider->title) ? $slider->title : '' }}"></div>
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
                                    <a href="#" style="background-image: url('{{ isset($slider->image) ? $slider->image : '' }}')" data-index="{{ $loop->index }}"></a>
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
                                        <img class="img-fluid" src="{{ isset($slider->image) ? $slider->image : '' }}" />
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
                                <span>{{ isset($store_setting['config_name']) ? $store_setting['config_name'] : '' }}</span>
                            </h1>

                            @if ($slider_online_searchbox_permission == 1)
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
                                                <input type="text" id="search_input1" placeholder="{{ isset($store_slider_settings['slider_online_searchbox_default']) ? $store_slider_settings['slider_online_searchbox_default'] : '' }}">
                                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                            @endif
                                        </div>
                                        <div class="enter_postcode">
                                            <p>{{ isset($store_slider_settings['slider_online_searchbox_text']) ? $store_slider_settings['slider_online_searchbox_text'] : '' }}</p>
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
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                        <div class="order-online-v5">
                            <h2 class="__title">{{ isset($store_setting['config_name']) ? $store_setting['config_name'] : '' }}</h2>

                            @if ($slider_online_searchbox_permission == 1)
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
                                                <input id="search_input1" placeholder="{{ isset($store_slider_settings['slider_online_searchbox_default']) ? $store_slider_settings['slider_online_searchbox_default'] : '' }}" type="text"/>
                                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                            @endif
                                        </div>
                                        <div class="enter_postcode">
                                            <p>{{ isset($store_slider_settings['slider_online_searchbox_text']) ? $store_slider_settings['slider_online_searchbox_text'] : '' }}</p>
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
                                        <img class="img-fluid" src="{{ isset($slider->image) ? $slider->image : '' }}" />
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
                            <div class="swiper-slide" style="background-image: url('{{ isset($slider->image) ? $slider->image : '' }}')">
                                <div class="container">
                                    <div class="slide-logo">
                                        <img class="img-fluid" src="{{ isset($slider->logo) ? $slider->logo : '' }}" style="max-width: 150px;" />
                                    </div>
                                    <h2 class="__title">{{ isset($slider->title) ? $slider->title : '' }}</h2>
                                    <p>{{ isset($slider->description) ? $slider->description : '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if ($slider_online_searchbox_permission == 1)
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
                                <input id="search_input1" placeholder="{{ isset($store_slider_settings['slider_online_searchbox_default']) ? $store_slider_settings['slider_online_searchbox_default'] : '' }}" type="text"/>
                                <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                            @endif
                        </div>
                        <div class="enter_postcode">
                            <p>{{ isset($store_slider_settings['slider_online_searchbox_text']) ? $store_slider_settings['slider_online_searchbox_text'] : '' }}</p>
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
                                    {{ isset($store_about_settings['about_title']) ? $store_about_settings['about_title'] : '' }}
                                </h3>
                                <p>
                                    {!! isset($store_about_settings['about_description']) ? $store_about_settings['about_description'] : '' !!}
                                </p>
                            </div>
                            <a class="btn mt-2 btn-green text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                            <a style="display: none;" class="btn mt-2 btn-green text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
                        </div>

                        <div class="col-sm-12 col-md-6 wow animate__fadeInRight" data-wow-duration="1s">
                            <div class="img-box">
                                 <img class="img-fluid" src="{{ isset($store_about_settings['about_image']) ? $store_about_settings['about_image'] : '' }}"/>
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
                        <img class="img-fluid" src="{{ isset($store_about_settings['about_image']) ? $store_about_settings['about_image'] : '' }}" />
                    </div>
                    <div class="col-md-12 col-lg-6 content">
                        <h3 class="title text-uppercase text-center">{{ isset($store_about_settings['about_title']) ? $store_about_settings['about_title'] : '' }}</h3>
                        <p>{!! isset($store_about_settings['about_description']) ? $store_about_settings['about_description'] : '' !!}</p>

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
                        <h3 class="title color-green">{{ isset($store_about_settings['about_title']) ? $store_about_settings['about_title'] : '' }}</h3>
                    </div>
                    <div>{!! isset($store_about_settings['about_description']) ? $store_about_settings['about_description'] : '' !!}</div>
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
                                <strong class="sub-title">{{ isset($store_about_settings['about_title']) ? $store_about_settings['about_title'] : '' }}</strong>
                            </div>
                            <div>{!! isset($store_about_settings['about_description']) ? $store_about_settings['about_description'] : '' !!}</div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <img class="rounded-circle" style="width: 400px;height: 400px;" src="{{ isset($store_about_settings['about_image']) ? $store_about_settings['about_image'] : '' }}" />
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
                            <img class="img-fluid" src="{{ isset($store_about_settings['about_image']) ? $store_about_settings['about_image'] : '' }}" />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div style="height: 300px; overflow: hidden;" id="shopDescription">
                                <div class="default-title-v5">
                                    <strong class="sub-title color-orange text-uppercase">{{ isset($store_about_settings['about_title']) ? $store_about_settings['about_title'] : '' }}</strong>
                                </div>
                                <div>{!! isset($store_about_settings['about_description']) ? $store_about_settings['about_description'] : '' !!}</div>
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
                            <strong class="sub-title color-orange text-uppercase">{{ isset($store_about_settings['about_title']) ? $store_about_settings['about_title'] : '' }}</strong>
                        </div>
                        <div>{!! isset($store_about_settings['about_description']) ? $store_about_settings['about_description'] : '' !!}</div>
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
                <h3 class="section-title color-red">{{ isset($store_bestcategory_settings['bestcategory_title']) ? $store_bestcategory_settings['bestcategory_title'] : '' }}</h3>
                <p class="text">{{ isset($store_bestcategory_settings['bestcategory_description']) ? $store_bestcategory_settings['bestcategory_description'] : '' }}</p>
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
                    <h3 class="title color-red">{{ isset($store_bestcategory_settings['bestcategory_title']) ? $store_bestcategory_settings['bestcategory_title'] : '' }}</h3>
                    <p class="text">{{ isset($store_bestcategory_settings['bestcategory_description']) ? $store_bestcategory_settings['bestcategory_description'] : '' }}</p>
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
                <h3 class="title text-capitalize color-green">{{ isset($store_bestcategory_settings['bestcategory_title']) ? $store_bestcategory_settings['bestcategory_title'] : '' }}</h3>
                <p>{{ isset($store_bestcategory_settings['bestcategory_description']) ? $store_bestcategory_settings['bestcategory_description'] : '' }}</p>
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
                <h3 class="title text-capitalize">{{ isset($store_bestcategory_settings['bestcategory_title']) ? $store_bestcategory_settings['bestcategory_title'] : '' }}</h3>
                <p>{{ isset($store_bestcategory_settings['bestcategory_description']) ? $store_bestcategory_settings['bestcategory_description'] : '' }}</p>
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


    {{-- BEST CATEGORY 5 --}}
    @if ($bestcategory_id == 5)
        <section class="best-categories-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v5 text-center container">
                <h3 class="title text-capitalize color-green">{{ isset($store_bestcategory_settings['bestcategory_title']) ? $store_bestcategory_settings['bestcategory_title'] : '' }}</h3>
                <p>{{ isset($store_bestcategory_settings['bestcategory_description']) ? $store_bestcategory_settings['bestcategory_description'] : '' }}</p>
            </div>
            <div class="container">
                @if(count($best_categories) > 0)
                    <div class="best-categories-v5-swiper">
                        <div class="swiper">
                            <a href="{{route('menu')}}">
                                <div class="swiper-wrapper">
                                    @foreach ($best_categories as $categorydet)
                                        <div class="swiper-slide">
                                            <a href="{{route('menu')}}">
                                                <div class="item">
                                                    <div class="img">
                                                        @if (isset($categorydet->hasOneCategoryDetails['image']))
                                                            <img class="img-fluid" src="{{ $categorydet->hasOneCategoryDetails['image'] }}" />
                                                        @else
                                                            <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                                        @endif
                                                    </div>
                                                        <div class="text-content">
                                                        <strong>{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                                                        <p>{{ html_entity_decode(substr($categorydet->hasOneCategoryDetails->hasOneCategory['description'],0,25)) }}...</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </a>
                        </div>
                        <div class="best-categories-v5-swiper-control">
                            <div class="__empty"></div>
                            <div class="number-of-slide"><span class="__text">Number of slide</span>
                                <div class="swiper-scrollbar"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <div class="best-categories-buttons">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
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
    {{-- END BEST CATEGORY 5 --}}


    {{-- BEST CATEGORY 6 --}}
    @if ($bestcategory_id == 6)
        <section class="popular-categories-v6 pt-90 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v6 text-center container">
                <strong class="sub-title text-uppercase">{{ isset($store_bestcategory_settings['bestcategory_title']) ? $store_bestcategory_settings['bestcategory_title'] : '' }}</strong>
                <h3 class="title text-capitalize">{{ isset($store_bestcategory_settings['bestcategory_description']) ? $store_bestcategory_settings['bestcategory_description'] : '' }}</h3>
            </div>
            <div class="container">
                @if(count($best_categories) > 0)
                    <div class="">
                        <ul class="__btn-list nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($best_categories as $category)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ ($loop->iteration == 1) ? 'active' : '' }}" id="prod-tab{{ $loop->iteration }}" href="#prod{{ $loop->iteration }}"data-bs-toggle="tab" role="tab" aria-controls="prod{{ $loop->iteration }}" aria-selected="false">{{ strtolower($category->hasOneCategoryDetails->hasOneCategory['name']) }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach ($best_categories as $category)
                                @php
                                    $cat_id = $category->category_id;
                                    $allproducts = getallproduct($cat_id);
                                @endphp
                                <div class="tab-pane fade show {{ ($loop->iteration == 1) ? 'active' : '' }}" id="prod{{ $loop->iteration }}" role="tabpanel" aria-labelledby="prod-tab{{ $loop->iteration }}">
                                    <div class="popular-categories-v6-swiper">
                                        <div class="swiper">
                                            <div class="swiper-wrapper">
                                                @foreach ($allproducts as $product)
                                                    <div class="swiper-slide">
                                                        <a href="{{route('menu')}}">
                                                        <div class="item">
                                                            <div class="img">
                                                                @if (!empty($product->hasOneProduct['image']))
                                                                    <img class="img-fluid" src="{{ $product->hasOneProduct['image']; }}" />
                                                                @else
                                                                    <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                                                @endif
                                                            </div>
                                                            <div class="text-content">
                                                                <strong class="text-capitalize">
                                                                    {{ html_entity_decode($product->hasOneDescription['name']) }}
                                                                </strong>
                                                            </div>
                                                            <p>@php echo html_entity_decode($product->hasOneDescription['description']) @endphp</p>
                                                        </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    {{-- END BEST CATEGORY 6 --}}

{{-- END BEST CATEGORY SECTION --}}





{{-- POPULAR FOOD SECTION --}}

    {{-- POPULAR FOOD 1 --}}
    @if ($popularfood_id == 1)
        <section class="popular-foods">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <h3 class="section-title color-green">{{ isset($store_popularfood_settings['popularfood_title']) ? $store_popularfood_settings['popularfood_title'] : '' }}</h3>
                <p class="text">{{ isset($store_popularfood_settings['popularfood_description']) ? $store_popularfood_settings['popularfood_description'] : '' }}</p>

                @if (count($popular_foods) > 0)
                    <div class="popular-foods-swiper">
                        <div class="swiper">
                            <div class="swiper-wrapper">
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
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Popular Foods Not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END POPULAR FOOD 1 --}}


    {{-- POPULAR FOOD 2 --}}
    @if ($popularfood_id == 2)
        <section class="popular-foods-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="default-title-v2 text-center">
                    <h3 class="title color-red">{{ isset($store_popularfood_settings['popularfood_title']) ? $store_popularfood_settings['popularfood_title'] : '' }}</h3>
                    <p class="text">{{ isset($store_popularfood_settings['popularfood_description']) ? $store_popularfood_settings['popularfood_description'] : '' }}</p>
                </div>
                @if(count($popular_foods) > 0)
                    <div class="popular-foods-swiper-v2 position-relative">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($popular_foods as $food)
                                    <a class="swiper-slide" href="{{route('menu')}}">
                                        <div class="img">
                                            @if (isset($food->hasOneProduct['image']))
                                                <img class="img-fluid" src="{{ $food->hasOneProduct['image'] }}">
                                            @else
                                                <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                            @endif
                                        </div>
                                        <strong>{{ isset($food->hasOneProduct->hasOneProductDescription['name']) ? $food->hasOneProduct->hasOneProductDescription['name'] : '' }}</strong>
                                        @php
                                            $desc = html_entity_decode(isset($food->hasOneProduct->hasOneProductDescription['description']) ? $food->hasOneProduct->hasOneProductDescription['description'] : '');
                                            $description = strip_tags($desc);

                                            if ($description == '') {
                                                echo '<p>-</p>';
                                            } else {
                                                echo '<p>'.substr($description,0,30).'</p>';
                                            }
                                        @endphp
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Popular Foods Not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END POPULAR FOOD 2 --}}

    {{-- POPULAR FOOD 3 --}}
    @if ($popularfood_id == 3)
        <section class="popular-foods-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="default-title-v3 text-center">
                    <h3 class="title text-capitalize color-green">{{ isset($store_popularfood_settings['popularfood_title']) ? $store_popularfood_settings['popularfood_title'] : '' }}</h3>
                    <p>{{ isset($store_popularfood_settings['popularfood_description']) ? $store_popularfood_settings['popularfood_description'] : '' }}</p>
                </div>

                <div class="row list-item">
                    @if (count($popular_foods) > 0)
                        @foreach ($popular_foods as $food)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <a href="{{route('menu')}}">
                                <div class="item">
                                    <div class="img">
                                        @if (isset($food->hasOneProduct['image']))
                                            <img class="img-fluid" src="{{ $food->hasOneProduct['image'] }}">
                                        @else
                                            <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                        @endif
                                    </div>
                                    <div class="text-content">
                                        <strong class="text-capitalize">{{ isset($food->hasOneProduct->hasOneProductDescription['name']) ? $food->hasOneProduct->hasOneProductDescription['name'] : '' }}</strong>
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
                                </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Popular Foods Not Found !</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    {{-- END POPULAR FOOD 3 --}}


    {{-- POPULAR FOOD 4 --}}
    @if ($popularfood_id == 4)
        <section class="popular-foods-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="default-title-v4 text-center">
                    <strong class="sub-title color-purple">Delicious Ones</strong>
                    <h3 class="title text-capitalize">{{ isset($store_popularfood_settings['popularfood_title']) ? $store_popularfood_settings['popularfood_title'] : '' }}</h3>
                    <p>{{ isset($store_popularfood_settings['popularfood_description']) ? $store_popularfood_settings['popularfood_description'] : '' }}</p>
                </div>
                <div class="row list-item">
                    @if (count($popular_foods) > 0)
                        @foreach ($popular_foods as $food)
                            <div class="col-12 col-md-6">
                                <a href="{{route('menu')}}">
                                <div class="item">
                                    <div class="img">
                                        @if (isset($food->hasOneProduct['image']))
                                            <img class="img-fluid"
                                                src="{{ $food->hasOneProduct['image'] }}">
                                        @else
                                            <img class="img-fluid"
                                                src="{{ asset('public/admin/product/no_image.jpg') }}">
                                        @endif
                                    </div>
                                    <div class="text-content">
                                        <strong
                                            class="text-capitalize">{{ isset($food->hasOneProduct->hasOneProductDescription['name']) ? $food->hasOneProduct->hasOneProductDescription['name'] : '' }}</strong>
                                        @php
                                            $desc = html_entity_decode(isset($food->hasOneProduct->hasOneProductDescription['description']) ? $food->hasOneProduct->hasOneProductDescription['description'] : '');
                                            $description = strip_tags($desc);
        
                                            if ($description == '') {
                                                echo '<p>-</p>';
                                            } else {
                                                echo '<p>'.substr($description,0,30).'</p>';
                                            }
                                        @endphp
                                    </div>
                                </div>
                            </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Popular Foods Not Found !</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    {{-- END POPULAR FOOD 4 --}}


    {{-- POPULAR FOOD 5 --}}
    @if ($popularfood_id == 5)
        <section class="popular-foods-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v5 text-center container">
                <h3 class="title text-capitalize color-orange">{{ isset($store_popularfood_settings['popularfood_title']) ? $store_popularfood_settings['popularfood_title'] : '' }}</h3>
                <p>{{ isset($store_popularfood_settings['popularfood_description']) ? $store_popularfood_settings['popularfood_description'] : '' }}</p>
            </div>
            <div class="container">
                @if (count($popular_foods) > 0)
                    <div class="popular-foods-v5-swiper">
                        <div class="swiper">
                            <div class="swiper-wrapper">                            
                                @foreach ($popular_foods as $food)
                                    <div class="swiper-slide">
                                        <a href="{{route('menu')}}">
                                            <div class="item">
                                                <div class="img">
                                                    @if (isset($food->hasOneProduct['image']))
                                                        <img class="img-fluid" src="{{ $food->hasOneProduct['image'] }}">
                                                    @else
                                                        <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
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
                                    </div>
                                @endforeach                        
                            </div>
                        </div>
                        <div class="popular-foods-v5-swiper-control">
                            <div class="__empty"></div>
                            <div class="number-of-slide"><span class="__text">Number of slide</span>
                                <div class="swiper-scrollbar"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <div class="best-categories-buttons">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Popular Foods Not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END POPULAR FOOD 5 --}}

    {{-- POPULAR FOOD 6 --}}
    @if ($popularfood_id == 6)
        <section class="popular-foods-v6 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v6">
                <strong class="sub-title color-orange text-uppercase">{{ isset($store_popularfood_settings['popularfood_title']) ? $store_popularfood_settings['popularfood_title'] : '' }}</strong>
                <h3 class="title text-uppercase">{{ isset($store_popularfood_settings['popularfood_description']) ? $store_popularfood_settings['popularfood_description'] : '' }}</h3>
            </div>
            <div class="container">
                <div class="row list-item">
                    @if (count($popular_foods) > 0)
                        @foreach ($popular_foods as $food)
                            <div class="col-12 col-sm-12 col-md-6">
                                <a href="{{route('menu')}}">
                                <div class="item">
                                    <div class="item">
                                        <div class="img">
                                            @if (!empty($food->hasOneProduct['image']) || $food->hasOneProduct['image'] != '')
                                                <img class="img-fluid" src="{{ $food->hasOneProduct['image'] }}">
                                            @else
                                                <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                            @endif
                                        </div>
                                        <div class="text-content">
                                            <strong
                                                class="text-capitalize">{{ $food->hasOneProduct->hasOneProductDescription['name'] }}</strong>
                                            @php
                                                $desc = html_entity_decode($food->hasOneProduct->hasOneProductDescription['description']);
                                                $description = strip_tags($desc);
        
                                                if ($description == '') {
                                                    echo '<p>-</p>';
                                                } else {
                                                    echo '<p>'.substr($description,0,30).'</p>';
                                                }
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Popular Foods Not Found !</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    {{-- END POPULAR FOOD 6 --}}

{{-- END POPULAR FOOD SECTION --}}





{{-- WEB REWVIEWS SECTION --}}

    {{-- REVIEWS 1 --}}
    @if ($review_id == 1)
        <section class="user-comments pt-110 pb-110">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <h3 class="section-title color-red">{{ isset($store_review_settings['review_title']) ? $store_review_settings['review_title'] : '' }}</h3>
                @if (count($review['reviews']) > 0)
                    <div class="user-comments-swiper">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($review['reviews'] as $item)
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
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Reviews not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END REVIEWS 1 --}}


    {{-- REVIEWS 2 --}}
    @if ($review_id == 2)
        <section class="user-comments-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container-fluid">
                <div class="default-title-v2 text-center">
                    <h3 class="title">{{ isset($store_review_settings['review_title']) ? $store_review_settings['review_title'] : '' }}</h3>
                    <p class="text">{{ isset($store_review_settings['review_description']) ? $store_review_settings['review_description'] : '' }}</p>
                </div>
                @if (count($review['reviews']) > 0)
                    <div class="user-comments-v2-swiper position-relative">
                        <div class="swiper">
                            <div class="swiper-wrapper">                            
                                @foreach ($review['reviews'] as $item)
                                    <div class="swiper-slide">
                                        <div class="message-text"><strong>{{ $item->title }}</strong></div>
                                        <div class="message-text">
                                            <p>{{ $item->message }}</p>
                                        </div>
                                        <div class="message-info">
                                            <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Reviews not Found !</code></h3>
                        </div>
                    </div>
                @endif                
            </div>
        </section>
    @endif
    {{-- END REVIEWS 2 --}}


    {{-- REVIEWS 3 --}}
    @if ($review_id == 3)
        <section class="user-comments-v3 pt-75 pb-75">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="default-title-v3 text-center">
                    <h3 class="title color-red">{{ isset($store_review_settings['review_title']) ? $store_review_settings['review_title'] : '' }}</h3>
                    <p>{{ isset($store_review_settings['review_description']) ? $store_review_settings['review_description'] : '' }}</p>
                </div>
                @if (count($review['reviews']) > 0)
                    <div class="user-comments-v3-swiper position-relative">
                        <div class="swiper">
                            <div class="swiper-wrapper">                           
                                @foreach ($review['reviews'] as $item)
                                    <div class="swiper-slide">
                                        <div class="message-text"><strong>{{ $item->title }}</strong></div>
                                        <div class="message-text">
                                            <p>{{ $item->message }}</p>
                                        </div>
                                        <div class="message-info">
                                            <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Reviews Not Found !</code></h3>
                        </div>
                    </div>
                @endif    
            </div>
        </section>
    @endif
    {{-- END REVIEWS 3 --}}


    {{-- REVIEWS 4 --}}
    @if ($review_id == 4)
        <section class="user-comments-v4 pt-75 pb-75">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="default-title-v4 text-center mb-0">
                    <strong class="sub-title color-green">Reviews</strong>
                    <h3 class="title">{{ isset($store_review_settings['review_title']) ? $store_review_settings['review_title'] : '' }}</h3>
                    <img class="img-fluid" src="{{ get_css_url().'public/assets/theme4/img/icon/commit-icon.svg' }}" />
                </div>
                @if (count($review['reviews']) > 0)
                    <div class="user-comments-v4-swiper position-relative">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($review['reviews'] as $item)
                                    <div class="swiper-slide">
                                        <div class="message-text"><strong>{{ $item->title }}</strong></div>
                                        <div class="message-text">
                                            <p>{{ $item->message }}</p>
                                        </div>
                                        <div class="message-info">
                                            <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Reviews not Found !</code></h3>
                        </div>
                    </div>
                @endif                
            </div>
        </section>
    @endif
    {{-- END REVIEWS 4 --}}


    {{-- REVIEWS 5 --}}
    @if ($review_id == 5)
        <section class="user-comments-v5 pt-75 pb-75">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="default-title-v5">
                    <strong class="sub-title text-uppercase color-orange">Recent Web Reviews</strong>
                    <h3 class="title">{{ isset($store_review_settings['review_title']) ? $store_review_settings['review_title'] : '' }}</h3>
                    <p>{{ isset($store_review_settings['review_description']) ? $store_review_settings['review_description'] : '' }}</p>
                </div>
                @if (count($review['reviews']) > 0)
                    <div class="user-comments-v5-swiper position-relative">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($review['reviews'] as $item)
                                    <div class="swiper-slide" style="min-height: 14rem;">
                                        <strong>{{ $item->title }}</strong>
                                        <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                                        <p>{{ $item->message }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="user-comments-v5-swiper-control">
                        <div class="number-of-slide"><span class="__text">Number of slide</span>
                            <div class="swiper-scrollbar"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Reviews not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    {{-- END REVIEWS 5 --}}


    {{-- REVIEWS 6 --}}
    @if ($review_id == 6)
        <section class="user-comments-v6 pt-90 pb-90">
            <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
                <div class="default-title-v6">
                    <strong class="sub-title text-uppercase">{{ isset($store_review_settings['review_title']) ? $store_review_settings['review_title'] : '' }}</strong>
                    <h3 class="title">{{ isset($store_review_settings['review_description']) ? $store_review_settings['review_description'] : '' }}</h3>
                </div>
                @if (count($review['reviews']) > 0)
                    <div class="user-comments-v6-swiper position-relative">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($review['reviews'] as $item)
                                    <div class="swiper-slide">
                                        <p>{{ $item->message }}</p>
                                        <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3><code>Reviews not Found !</code></h3>
                        </div>
                    </div>
                @endif
            </div>
    </section>
    @endif
    {{-- END REVIEWS 6 --}}

{{-- END WEB REWVIEWS SECTION --}}





{{-- RESERVATION SECTION --}}

    {{-- RESERVATION 1 --}}
    @if ($reservation_id == 1)
        <section class="reservation pt-110 pb-110" id="reservation">
            <div class="container wow animate__fadeInUp" data-wow-duration="1s">
                <h3 class="section-title color-green divider-white text-capitalize">{{ isset($store_reservation_settings['reservation_title']) ? $store_reservation_settings['reservation_title'] : '' }}</h3>
                <p class="text">{{ isset($store_reservation_settings['reservation_description']) ? $store_reservation_settings['reservation_description'] : '' }}</p>
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
    @endif
    {{-- END RESERVATION 1 --}}

    {{-- RESERVATION 2 --}}
    @if ($reservation_id == 2)
        <section class="reservation-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s" id="reservation">
            <div class="container">
                <div class="default-title-v2 text-center">
                    <h3 class="title text-capitalize">{{ isset($store_reservation_settings['reservation_title']) ? $store_reservation_settings['reservation_title'] : '' }}</h3>
                    <p class="text">{{ isset($store_reservation_settings['reservation_description']) ? $store_reservation_settings['reservation_description'] : '' }}</p>
                </div>
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
                            <select class="form-control" name="person" required>
                                <option value="" selected="selected">Person</option>
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
                        <input class="form-control"  name="date" id="date" type="date" required/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                            <input class="form-control"  name="time" id="time" type="time" required/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                        <button class="__btn text-capitalize">make reservation now<i
                                class="fas fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </section>
    @endif
    {{-- END RESERVATION 2 --}}

    {{-- RESERVATION 3 --}}
    @if ($reservation_id == 3)
        <section class="reservation-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s" id="reservation">
            <form class="container" method="POST" action="{{ route('reservation') }}">
                {{ csrf_field() }}
                <div class="row align-items-center">
                <div class="col-md-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                    <div class="default-title-v3">
                        <h3 class="title color-green text-capitalize">{{ isset($store_reservation_settings['reservation_title']) ? $store_reservation_settings['reservation_title'] : '' }}</h3>
                        <p>{{ isset($store_reservation_settings['reservation_description']) ? $store_reservation_settings['reservation_description'] : '' }}.</p>
                    </div>
                    <button class="btn btn-red text-capitalize">make reservation now</button>
                    </div>
                    <div class="col-md-12 col-lg-7 wow animate__fadeInRight" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="fullname" placeholder="Full Name" type="text" required/>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="phone" placeholder="Phone Number" type="text" required/>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="icon"><i class="fas fa-chevron-down"></i>
                                    <select class="form-control" name="person" required>
                                        <option value="" selected="selected">Person</option>
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
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="date" id="date" type="date" required/>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input class="form-control" name="time" id="time" type="time" required/>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-red text-capitalize __mobile-show">make reservation now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    @endif
    {{-- END RESERVATION 3 --}}


    {{-- RESERVATION 4 --}}
    @if ($reservation_id == 4)
        <section class="reservation-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s" id="reservation">
            <form class="container" method="POST" action="{{ route('reservation') }}">
                {{ csrf_field() }}
                <div class="default-title-v4 text-center">
                    <strong class="sub-title color-purple text-capitalize">book now</strong>
                    <h3 class="title text-capitalize">{{ isset($store_reservation_settings['reservation_title']) ? $store_reservation_settings['reservation_title'] : '' }}</h3>
                    <p>{{ isset($store_reservation_settings['reservation_description']) ? $store_reservation_settings['reservation_description'] : '' }}</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <input class="form-control" name="fullname" placeholder="Full Name" type="text" required/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <input class="form-control" name="phone" placeholder="Phone Number" type="text" required/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <div class="icon"><i class="fas fa-chevron-down"></i>
                            <select class="form-control" name="person" required>
                                <option value="" selected="selected">Person</option>
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
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <input class="form-control" name="date" id="date" type="date" required/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <input class="form-control" name="time" id="time" type="time" required/>
                    </div>
                    <div class="col-12 col-sm-6 col-md-12 text-center">
                        <button class="btn btn-purple text-capitalize">make reservation now</button>
                    </div>
                </div>
            </form>
        </section>
    @endif
    {{-- END RESERVATION 4 --}}


    {{-- RESERVATION 5 --}}
    @if ($reservation_id == 5)
        <section class="reservation-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s" id="reservation">
            <form class="container" method="POST" action="{{ route('reservation') }}">
                {{ csrf_field() }}
                <div class="row align-items-center">
                    <div class="col-md-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                        <div class="default-title-v5">
                            <strong class="sub-title color-orange text-capitalize">reservation</strong>
                            <h3 class="title text-capitalize">{{ isset($store_reservation_settings['reservation_title']) ? $store_reservation_settings['reservation_title'] : '' }}</h3>
                            <p>{{ isset($store_reservation_settings['reservation_description']) ? $store_reservation_settings['reservation_description'] : '' }}</p>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-7 wow animate__fadeInRight" data-wow-duration="1s">
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="fullname" placeholder="Full Name" type="text" required/>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="phone" placeholder="Phone Number" type="text" required/>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="icon"><i class="fas fa-chevron-down"></i>
                                    <select class="form-control" name="person" required>
                                        <option value="" selected="selected">Person</option>
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
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="date" id="date" type="date" required/>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <input class="form-control" name="time" id="time" type="time" required/>
                            </div>
                            <div class="col-12 col-sm-6">
                                <button class="btn btn-orange text-capitalize">make reservation now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    @endif
    {{-- END RESERVATION 5 --}}
    
    {{-- RESERVATION 6 --}}
    @if ($reservation_id == 6)
        <section class="reservation-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s" id="reservation">
            <form class="container" method="POST" action="{{ route('reservation') }}">
                {{ csrf_field() }}
                <div class="default-title-v6">
                    <strong class="sub-title color-orange text-uppercase">reservation</strong>
                    <h3 class="title text-uppercase">{{ isset($store_reservation_settings['reservation_title']) ? $store_reservation_settings['reservation_title'] : '' }}</h3>
                    <p>{{ isset($store_reservation_settings['reservation_description']) ? $store_reservation_settings['reservation_description'] : '' }}</p>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control" name="fullname" placeholder="Full Name" type="text" required/>
                    </div>
                    <div class="col">
                        <input class="form-control" name="phone" placeholder="Phone Number" type="text" required/>
                    </div>
                    <div class="col">
                        <div class="icon"><i class="fas fa-chevron-down"></i>
                            <select class="form-control select2" name="person" required>
                                <option value="" selected="selected">Person</option>
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
                    <div class="col">
                        <div class="icon">
                            <input class="form-control icon" name="time" placeholder="Date &amp; Time"  type="datetime-local" required/>
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-red text-capitalize">book now</button>
                    </div>
                </div>
            </form>
        </section>
    @endif
    {{-- END RESERVATION 6 --}}

{{-- END RESERVATION SECTION --}}




@if ($store_setting['enable_gallery_module'] == 1)
{{-- GALLARY SECTION --}}

    {{-- GALLARY 1 --}}
    @if ($gallary_id == 1)
        <section class="photo-gallery pt-110 pb-110" id="photo-gallary">
            <div class="container wow animate__fadeInUp" data-wow-duration="1s">
                @if(!empty($store_setting['gallery_header_text']))
                    <h3 class="section-title color-green divider-white text-capitalize">{{ $store_setting['gallery_header_text'] }}</h3>
                @else
                    <h3 class="section-title color-green divider-white text-capitalize">Photo Gallary</h3>
                @endif

                @if(!empty($store_setting['gallery_header_desc']))
                    <p class="text">{{ $store_setting['gallery_header_desc'] }}</p>
                @else
                    <p class="text" style="margin-bottom: 20px!important;">Our Gallary is here...</p>
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
                        <div class="col-md-12 text-center">
                            <h3><code>Images Not Available.</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    {{-- END GALLARY 1 --}}


    {{-- GALLARY 2 --}}
    @if ($gallary_id == 2)
        <section class="photo-gallery-v2 pt-75 wow animate__fadeInUp" data-wow-duration="1s" id="photo-gallary">
            <div class="container">
                <div class="default-title-v2 text-center">
                    @if(!empty($store_setting['gallery_header_text']))
                        <h3 class="title text-capitalize">{{ $store_setting['gallery_header_text'] }}</h3>
                    @else
                        <h3 class="title text-capitalize"><span>photo &nbsp;</span>gallery</h3>
                    @endif

                    @if(!empty($store_setting['gallery_header_desc']))
                        <p class="text">{{ $store_setting['gallery_header_desc'] }}</p>
                    @else
                        <p class="text">This is Our Food Photo Gallary, Best Food In Our Store.</p>
                    @endif
                </div>
            </div>
            <div class="container-fluid wow animate__fadeInUp mb-3" data-wow-duration="1s">
                <div class="row">
                    @if(count($photos) > 0)
                        <div class="masonry">
                            @foreach ($photos as $key => $photo)
                                <div class="item">
                                    <img src="{{ $photo->image }}" alt="Image">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Images Not Available</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    {{-- END GALLARY 2 --}}


    {{-- GALLARY 3 --}}
    @if ($gallary_id == 3)
        <div class="photo-gallery-v3 pt-75 pb-75" id="photo-gallary">
            <div class="container">
                <div class="default-title-v3 text-center">
                    @if(!empty($store_setting['gallery_header_text']))
                        <h3 class="title text-capitalize color-red">{{ $store_setting['gallery_header_text'] }}</h3>
                    @else
                        <h3 class="title text-capitalize color-red">photo gallery</h3>
                    @endif

                    @if(!empty($store_setting['gallery_header_desc']))
                        <p>{{ $store_setting['gallery_header_desc'] }}</p>
                    @else
                        <p>This is Our Food Photo Gallary, Best Food In Our Store.</p>
                    @endif
                </div>
            </div>
            <div class="container-fluid">
                <div class="row list-item">
                    @if(count($photos) > 0)
                        @foreach ($photos as $photo)
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="item">
                                    @if (!empty($photo->image))
                                        <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a>
                                        <img class="img-fluid" src="{{ $photo->image }}" />
                                    @else
                                        <a class="fas fa-search-plus" href="{{ asset('public/frontend/other/no-image.jpg') }}" data-fancybox="photoGallery"></a>
                                        <img src="{{ asset('public/frontend/other/no-image.jpg') }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Images Not Avavilable</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    {{-- END GALLARY 3 --}}


    {{-- GALLARY 4 --}}
    @if ($gallary_id == 4)
        <div class="photo-gallery-v4 pt-75 pb-75" id="photo-gallary">
            <div class="container">
                <div class="default-title-v4 text-center">
                    <strong class="sub-title color-purple text-uppercase">gallary</strong>
                        @if(!empty($store_setting['gallery_header_text']))
                            <h3 class="section-title color-green divider-white text-capitalize">{{ $store_setting['gallery_header_text'] }}</h3>
                        @else
                            <h3 class="section-title color-green divider-white text-capitalize"> My Food Gallary</h3>
                        @endif

                        @if(!empty($store_setting['gallery_header_desc']))
                            <p class="text">{{ $store_setting['gallery_header_desc'] }}</p>
                        @else
                            <p class="text">This is Our Food Photo Gallary, Best Food In Our Store.</p>
                        @endif             
                </div>
            </div>
            @if(count($photos) > 0)
                <div class="list-item-container">
                    <div class="list-item">
                        @foreach ($photos as $photo)
                            <div class="item">
                                @if (!empty($photo->image))
                                    <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a>
                                    <img class="img-fluid" src="{{ $photo->image }}" />
                                @else
                                    <a class="fas fa-search-plus" href="{{ asset('public/frontend/other/no-image.jpg') }}" data-fancybox="photoGallery"></a>
                                    <img src="{{ asset('public/frontend/other/no-image.jpg') }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div style="clear:both;"></div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3><code>Images Not Available</code></h3>
                    </div>
                </div>
            @endif
        </div>
    @endif
    {{-- END GALLARY 4 --}}


    {{-- GALLARY 5 --}}
    @if ($gallary_id == 5)
        <div class="photo-gallery-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s" id="photo-gallary">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-lg-3 offset-lg-1">
                        <div class="default-title-v5">
                            <strong class="sub-title color-red text-uppercase color-orange">gallery</strong>
                            @if(!empty($store_setting['gallery_header_text']))
                                <h3 class="title text-capitalize mb-5">{{ $store_setting['gallery_header_text'] }}</h3>
                            @else
                                <h3 class="title text-capitalize mb-5">My Food Gallary</h3>
                            @endif

                            @if(!empty($store_setting['gallery_header_desc']))
                                <p>{{ $store_setting['gallery_header_desc'] }}</p>
                            @else
                                <p>This is Our Food Photo Gallary, Best Food In Our Store.</p>
                            @endif
                        </div>
                        @if(count($photos) > 0)
                            <div class="user-comments-v5-swiper-info">
                                <div class="number-of-slide"><span class="__text">Number of slide</span>
                                    <div class="swiper-scrollbar"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(count($photos) > 0)
                        <div class="col-md-12 col-lg-8">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($photos as $photo)
                                        <div class="swiper-slide">
                                            <div class="item">
                                                @if (!empty($photo->image))
                                                    <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a>
                                                    <img class="img-fluid" src="{{ $photo->image }}" />
                                                @else
                                                    <a class="fas fa-search-plus" href="{{ asset('public/frontend/other/no-image.jpg') }}" data-fancybox="photoGallery"></a>
                                                    <img src="{{ asset('public/frontend/other/no-image.jpg') }}">
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="photo-gallery-v5-swiper-control">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Images Not Available</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    {{-- END GALLARY 5 --}}


    {{-- GALLARY 6 --}}
    @if ($gallary_id == 6)
        <section class="photo-gallery-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s" id="photo-gallary">
            <div class="default-title-v6">
                @if(!empty($store_setting['gallery_header_text']))
                    <h3 class="section-title color-green divider-white text-capitalize">{{ $store_setting['gallery_header_text'] }}</h3>
                @else
                    <h3 class="section-title color-green divider-white text-capitalize">My Food Gallary</h3>
                @endif

                @if(!empty($store_setting['gallery_header_desc']))
                    <p class="text">{{ $store_setting['gallery_header_desc'] }}</p>
                @else
                    <p class="text">This is Our Food Photo Gallary, Best Food In Our Store.</p>
                @endif
            </div>
            <div class="container">
                <div class="row">
                    @if(count($photos) > 0)
                        @foreach ($photos as $photo)
                            <div class="col">
                                <div class="item">
                                    @if (!empty($photo->image))
                                        <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a>
                                        <img class="img-fluid" src="{{ $photo->image }}" />
                                    @else
                                        <a class="fas fa-search-plus" href="{{ asset('public/frontend/other/no-image.jpg') }}" data-fancybox="photoGallery"></a>
                                        <img src="{{ asset('public/frontend/other/no-image.jpg') }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <h3><code>Images Not Available</code></h3>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    {{-- END GALLARY 6 --}}

{{-- END GALLARY SECTION --}}
@endif





{{-- OPENHOURS SECTION  --}}

    {{-- OPENHOURS 1 --}}
    @if ($openhour_id == 1)
        <section class="opening-hours pt-110 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container text-center">
                <h3 class="title text-uppercase">Visit us</h3>
                <h3 class="sub-title">Opening Hours</h3>
                <img class="img-fluid" src="{{ get_css_url().'public/assets/theme1/img/icon/opening-hours.svg' }}"/>

                @if(!empty($opning_days) || $opning_days != '')
                    @foreach ($opning_days as $key => $oday)
                        @php
                            $day = $oday;
                            $from = $opning_from[$key];
                            $to = $opning_to[$key];
                        @endphp
                        <p>{{ $day }}  {{ $from }} - {{ $to }}</p>
                    @endforeach
                @endif
            </div>
        </section>
    @endif
    {{-- END OPENHOURS 1 --}}


    {{-- OPENHOURS 2 --}}
    @if ($openhour_id == 2)
        <section class="opening-hours-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container"><img class="img-fluid" src="{{ get_css_url().'public/assets/theme2/img/icon/opening-hours-top-divider.svg' }}" />
                <h3 class="title text-uppercase">opening hours</h3>
                <div class="_divider"></div>
                <a href="tel:{{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}">TEL: {{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}</a>

                <h3 class="title text-uppercase __divider">hours</h3>
                @if(!empty($opning_days) || $opning_days != '')
                    @foreach ($opning_days as $key => $oday)
                        @php
                            $day = $oday;
                            $from = $opning_from[$key];
                            $to = $opning_to[$key];
                        @endphp
                        <div class="__time" style="max-width: 500px!important;">
                            <span>{{ $day }}</span>
                            <span>{{ $from }} - {{ $to }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
    @endif
    {{-- END OPENHOURS 2 --}}


    {{-- OPENHOURS 3 --}}
    @if ($openhour_id == 3)
        <section class="opening-hours-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="default-title-v3 text-center">
                    <h3 class="title text-capitalize">opening hours</h3>
                </div>
                <div class="__time">
                    @foreach ($opning_days as $key => $oday)
                        @php
                            $day = $oday;
                            $from = $opning_from[$key];
                            $to = $opning_to[$key];
                        @endphp

                        <div class="__time-item">
                            <span>{{ $day }}</span>
                            <span>{{ $from }} - {{ $to }}</span>
                        </div>
                    @endforeach
                    
                </div><br>
            </div>
        </section>
    @endif
    {{-- END OPENHOURS 3 --}}


    {{-- OPENHOURS 4 --}}
    @if ($openhour_id == 4)
        <section class="opening-hours-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container">
                <div class="default-title-v4">
                    <h3 class="title text-capitalize">opening hours</h3>
                </div>
                <div class="__time">
                    @foreach ($opning_days as $key => $oday)
                        @php
                            $day = $oday;
                            $from = $opning_from[$key];
                            $to = $opning_to[$key];
                        @endphp

                        <div class="__time-item">
                            <strong>{{ $day }}</strong>
                            <span>{{ $from }}</span>
                            <span>{{ $to }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    {{-- END OPENHOURS 4 --}}


    {{-- OPENHOURS 5 --}}
    @if ($openhour_id == 5)
        <section class="opening-hours-v5 pt-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v5 text-center">
                <strong class="sub-title color-orange text-capitalize">opening hourse</strong>
            </div>
            <div class="__info">
                <div class="__container">
                    <img class="img-fluid mb-3" src="{{ get_css_url().'public/assets/theme5/img/icon/time-top-flower.svg' }}" />
                    @if ($store_open_close == 'open')
                        <strong class="__time-title">OPEN NOW</strong>
                    @else
                        <strong class="__time-title">CLOSE NOW</strong>
                    @endif
                    <div class="__time" style="display: block;">
                        @foreach ($opning_days as $key => $oday)
                            @php
                                $day = $oday;
                                $from = $opning_from[$key];
                                $to = $opning_to[$key];
                            @endphp

                            <strong>{{ $day }}</strong>
                            <div class="__time-box">
                                <div class="__left-time"><span>{{ $from }}</span></div>
                                <div class="__time-divier"></div>
                                <div class="__right-time"><span>{{ $to }}</span></div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                </div>
            </div>
        </section>
    @endif
    {{-- END OPENHOURS 5 --}}


    {{-- OPENHOURS 6 --}}
    @if ($openhour_id == 6)
        <section class="opening-hours-v6 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="default-title-v6 text-center">
                <strong class="sub-title text-capitalize">opening hours</strong>
            </div>
            <div class="__info">
                <div class="__container">
                    <img class="img-fluid mb-3" src="{{ get_css_url().'public/assets/theme6/img/icon/time-clock.svg' }}" />
                    <div class="__divider"></div>
                    @if ($store_open_close == 'open')
                        <strong class="__time-title">OPEN NOW</strong>
                    @else
                        <strong class="__time-title">CLOSE NOW</strong>
                    @endif
                    <div class="__divider"></div>
                    <div class="__time">
                        @foreach ($opning_days as $key => $oday)
                            @php
                                $day = $oday;
                                $from = $opning_from[$key];
                                $to = $opning_to[$key];
                            @endphp

                            <strong>{{ $day }}</strong>
                            <div class="__time-box">
                                <div class="__left-time"><span>{{ $from }}</span></div>
                                <div class="__time-divier"></div>
                                <div class="__right-time"><span>{{ $to }}</span></div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                </div>
            </div>
        </section>
    @endif
    {{-- END OPENHOURS 6 --}}

{{-- END OPENHOURS SECTION  --}}

