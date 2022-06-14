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

    .masonry { /* Masonry container */
        -webkit-column-count: 4;
        -moz-column-count:4;
        column-count: 4;
        -webkit-column-gap: 1em;
        -moz-column-gap: 1em;
        column-gap: 1em;
        margin: 1.5em;
        padding: 0;
    }

    .masonry { /* Masonry container */
        -webkit-column-count: 4;
        -moz-column-count:4;
        column-count: 4;
        -webkit-column-gap: 1em;
        -moz-column-gap: 1em;
        column-gap: 1em;
        margin: 1.5em;
        padding: 0;
        -moz-column-gap: 1.5em;
        -webkit-column-gap: 1.5em;
        column-gap: 1.5em;
        font-size: .85em;
    }

    .item {
        display: inline-block;
        background: #fff;
        padding: 1em;
        margin: 0 0 1.5em;
        width: 100%;
        -webkit-transition:1s ease all;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-shadow: 2px 2px 4px 0 #ccc;
    }
    
    .item img{max-width:100%; height: auto;}

    @media only screen and (max-width: 320px) {
        .masonry {
            -moz-column-count: 1;
            -webkit-column-count: 1;
            column-count: 1;
        }
    }

    @media only screen and (min-width: 321px) and (max-width: 768px){
        .masonry {
            -moz-column-count: 2;
            -webkit-column-count: 2;
            column-count: 2;
        }
    }
    @media only screen and (min-width: 769px) and (max-width: 1200px){
        .masonry {
            -moz-column-count: 3;
            -webkit-column-count: 3;
            column-count: 3;
        }
    }
    @media only screen and (min-width: 1201px) {
        .masonry {
            -moz-column-count: 4;
            -webkit-column-count: 4;
            column-count: 4;
        }
    }

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

<div class="home-slide-v2 swiper wow animate__fadeInDown" data-wow-duration="1s">
    @if ($slider_permission == 1)
        <div class="swiper-wrapper">
            <div class="swiper-slide"
                style="background-image: url({{ $template_setting['polianna_slider_1'] }})">
                <div class="container">
                    <h3 class="text-capitalize">{{ $template_setting['polianna_slider_1_title'] }}</h3>
                    <img class="img-fluid __icon"
                        src="{{ get_css_url().'public/assets/theme2/img/icon/slide-divider.svg' }}" />
                    <p>
                        {{ $template_setting['polianna_slider_1_description'] }}
                    </p>
                    {{-- <a class="text-uppercase" href="#">read more<span></span></a> --}}
                </div>
            </div>
            <div class="swiper-slide"
                style="background-image: url({{ $template_setting['polianna_slider_2'] }})">
                <div class="container">
                    <h3 class="text-capitalize">{{ $template_setting['polianna_slider_2_title'] }}</h3>
                    <img class="img-fluid __icon"
                        src="{{ get_css_url().'public/assets/theme2/img/icon/slide-divider.svg' }}" />
                    <p>
                        {{ $template_setting['polianna_slider_2_description'] }}
                    </p>
                    {{-- <a class="text-uppercase" href="#">read more<span></span></a> --}}
                </div>
            </div>
            <div class="swiper-slide"
                style="background-image: url({{ $template_setting['polianna_slider_3'] }})">
                <div class="container">
                    <h3 class="text-capitalize">{{ $template_setting['polianna_slider_3_title'] }}</h3>
                    <img class="img-fluid __icon"
                        src="{{ get_css_url().'public/assets/theme2/img/icon/slide-divider.svg' }}" />
                    <p>
                        {{ $template_setting['polianna_slider_3_description'] }}
                    </p>
                    {{-- <a class="text-uppercase" href="#">read more<span></span></a> --}}
                </div>
            </div>
        </div>
        <button class="swiper-button-next"><i class="fas fa-chevron-right"></i></button>
        <button class="swiper-button-prev"><i class="fas fa-chevron-left"></i></button>
    @else
        <div class="swiper-wrapper">
            <div class="swiper-slide"
                style="background-image: url('{{ asset('public/frontend/sliders/demo.jpg') }}');">
                <div class="container">
                    <h3 class="text-capitalize">{{ $store_setting['config_name'] }}</h3>
                    <img class="img-fluid __icon"
                        src="{{ get_css_url().'public/assets/theme2/img/icon/slide-divider.svg' }}" />
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo voluptates adipisci omnis
                        excepturi inventore ducimus corrupti beatae quibusdam hic molestias sit modi iste commodi
                        atque rem magni perspiciatis provident magnam quidem eligendi, tenetur ut laboriosam,
                        voluptate sequi! Veritatis modi aspernatur, mollitia culpa vero quis optio aut quasi
                        laudantium, porro possimus.
                    </p>
                    {{-- <a class="text-uppercase" href="#">read more<span></span></a> --}}
                </div>
            </div>
        </div>
    @endif
</div>

<div class="about-us container wow animate__fadeInUp" data-wow-duration="1s">
    <div class="row">
      <div class="col-md-12 col-lg-6 img">
          @if (!empty($template_setting['polianna_banner_image']))
            <img class="img-fluid" src="{{ $template_setting['polianna_banner_image'] }}" />
          @else
            <img class="img-fluid" src="{{ get_css_url().'public/assets/demo-data/popular-foods/1.jpg'}}"/>
          @endif
        </div>
      <div class="col-md-12 col-lg-6 content">
          @if (!empty($template_setting['polianna_store_description']) )
            {!! $template_setting['polianna_store_description'] !!}
          @else
            <strong class="sub-title text-capitalize">star kebab & pizza</strong>
            <h3 class="title text-uppercase">about us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Bibendum est ultricies integer quis. Iaculis urna id volutpat lacus laoreet. Mauris vitae ultricies leo integer malesuada. Ac odio tempor orci dapibus ultrices in. Egestas diam in arcu cursus</p>
            @endif

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

<section class="categories-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v2 text-center">
            <h3 class="title color-red">Best Categories</h3>
            <p class="text">
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla
                pariatur.
            </p>
        </div>
        <div class="categories-swiper-v2 position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @if(count($best_categories) > 0)
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
                                <p>{{ html_entity_decode($categorydet->hasOneCategoryDetails->hasOneCategory['description']) }}</p>
                            </a>
                        @endforeach
                    @else
                        <a class="swiper-slide">
                            <h3>Category Not Available</h3>
                        </a>
                    @endif
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<section class="popular-foods-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v2 text-center">
            <h3 class="title color-red"><span>Popular &nbsp;</span>Foods</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br>
                dolore eu fugiat nulla pariatur.</p>
        </div>
        <div class="popular-foods-swiper-v2 position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @if(count($popular_foods) > 0)
                        @foreach ($popular_foods as $food)
                            <a class="swiper-slide" href="#">
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
                    @else
                        <h3>Foods Not Available</h3>
                    @endif
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<section class="user-comments-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container-fluid">
        <div class="default-title-v2 text-center">
            <h3 class="title">Recent Web Reviews</h3>
            {{-- <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p> --}}
        </div>
        <div class="user-comments-v2-swiper position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    {{-- <div class="swiper-slide">
                        <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 0</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis
                                nostrud exercitation 0</p>
                        </div>
                        <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                    </div> --}}
                    @foreach ($review['reviews'] as $item)
                        <div class="swiper-slide">
                            <div class="message-text"><strong>{{ $item->title }}</strong></div>
                            <div class="message-text">
                                {{-- <strong>THAT’S AN AWESOME RESTAURANT & FOOD 0</strong> --}}
                                <p>{{ $item->message }}</p>
                            </div>
                            <div class="message-info">
                                <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                                {{-- <span>UX Designer</span> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<section class="reservation-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v2 text-center">
            <h3 class="title text-capitalize"><span>make a &nbsp;</span>reservation</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br>
                dolore eu fugiat nulla pariatur.</p>
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

<section class="photo-gallery-v2 pt-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v2 text-center">
            <h3 class="title text-capitalize"><span>photo &nbsp;</span>gallery</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br>
                dolore eu fugiat nulla pariatur.</p>
        </div>
    </div>
    <div class="container-fluid wow animate__fadeInUp mb-3" data-wow-duration="1s">

        <div class="row">
            @if(count($photos) > 0)
                <div class="masonry">
                    @foreach ($photos as $key => $photo)
                        <div class="item">
                                <img src="{{ $photo->image }}" alt="">
                        </div>

                        {{-- <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="row"> --}}
                                {{-- <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                                    </div> --}}
                                {{-- <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                                    </div>
                            </div>
                        </div> --}}
                    @endforeach
                </div>
            @else
                <h1>Image Not Found</h1>
            @endif
        </div>
    </div>
</section>
<section class="opening-hours-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container"><img class="img-fluid" src="{{ get_css_url().'public/assets/theme2/img/icon/opening-hours-top-divider.svg' }}" />
        <h3 class="title text-uppercase">opening hours</h3>
        <div class="_divider"></div><a href="tel:{{ $store_setting['config_telephone'] }}">TEL: {{ $store_setting['config_telephone'] }}</a>
        <h3 class="title text-uppercase __divider">hours</h3>
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
            <div class="__time">
                @if ($firstday == $lastday)
                    <span>{{ $firstday }}</span>
                @else
                    <span>{{ $firstday }}-{{ $lastday }}</span>
                @endif
                    <span>{{ $fromtime[$key] }}-{{ $totime[$key] }}</span>
            </div>
            <br>
        @endforeach
        {{-- <div class="__time"><span>{{ $openclose['days1'] }}-{{ $openclose['days2'] }}</span><span>{{ $openclose['fromtime'] }}-{{ $openclose['totime'] }}</span></div>
        <div class="__time"><span>SUN</span><span>9.30AM-11PM</span></div><img class="img-fluid" src="{{ asset('public/assets/theme2/img/icon/opening-hours-bottom-divider.svg') }}" /> --}}
    </div>
</section>