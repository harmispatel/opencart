<!--
    THIS IS LAYOUT(THEME) 1 PAGE FOR FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    layout1.blade.php
    It Displayed Layout(Theme) 1
    ----------------------------------------------------------------------------------------------
-->


<!-- CSS -->
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;800&amp;display=swap" rel="stylesheet"/>
<!-- End CSS -->

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


<!-- Mobile Menu -->
<sidebar class="mobile-menu">
    <a class="close far fa-times-circle" href="#"></a>
    <a class="logo" href="{{ route('home') }}">
        <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}" style="width: {{ $template_setting['polianna_main_logo_width'] }}px; height: {{ $template_setting['polianna_main_logo_height'] }}px;"/>
    </a>
    <div class="top">
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
            <li class="{{ (request()->is('contact')) ? 'active' : '' }}">
                <a class="text-uppercase" href="{{ route('contact') }}" style="color: {{  (request()->is('contact')) ? 'white' : $template_setting['polianna_navbar_link'] }};">contact us</a>
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
    </div>
</sidebar>
<!-- Emd Mobile Menu -->


<!-- Slider Section -->
<section class="home-slide">
    {{-- Slider --}}
    @if($slider_permission == 1)
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <strong class="title text-uppercase">welcome to</strong>
                    <strong class="sub-title text-capitalize">{{ $template_setting['polianna_slider_1_title'] }}</strong>
                    <img class="img-fluid" style="background-image: url('{{ $template_setting['polianna_slider_1'] }}')"/>
                </div>
                <div class="swiper-slide">
                    <strong class="title text-uppercase">welcome to</strong>
                    <strong class="sub-title text-capitalize">{{ $template_setting['polianna_slider_2_title'] }}</strong>
                    <img class="img-fluid" style="background-image: url('{{ $template_setting['polianna_slider_2'] }}')"/>
                </div>
                <div class="swiper-slide">
                    <strong class="title text-uppercase">welcome to</strong>
                    <strong class="sub-title text-capitalize">{{ $template_setting['polianna_slider_3_title'] }}</strong>
                    <img class="img-fluid" style="background-image: url('{{$template_setting['polianna_slider_3']}}')"/>
                </div>
            </div>
            <div class="swiper-button-next">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="swiper-button-prev">
                <i class="fas fa-arrow-left"></i>
            </div>
        </div>
    @else
        <div class="swiper">
            <div class="swiper-slide">
                <strong class="title text-uppercase">welcome to</strong>
                <strong class="sub-title text-capitalize">kebab & pizza</strong>
                <img class="img-fluid" style="background-image: url('{{ asset('public/frontend/sliders/demo.jpg') }}'); background-size: cover;"/>
            </div>
        </div>
    @endif
    {{-- End Slider --}}

    {{-- Online Order --}}
    @if ($online_order_permission == 1)
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
                        <input id="search_input1" placeholder="AB10 1BW" type="text"/>
                        <img id="loading_icon1" src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                    @endif
                </div>
                <div class="enter_postcode">
                    <p>Please enter your postcode to view our menu and place an order</p>
                </div>
            @endif
            <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
            <div class="button_content1" style ="">
                @if ($delivery_setting['enable_delivery'] != 'delivery')
                    {{-- <input type="button" class="collection_button1 btn" value="Collection"> --}}
                    <a class="btn btn-green text-uppercase collection_button1">collection</a>
                @endif

                @if ($delivery_setting['enable_delivery'] != 'collection')
                    <a class="btn btn-green text-uppercase delivery_button1">delivery</a>
                    {{-- <input type="button" class="delivery_button1 btn" value="Delivery"> --}}
                @endif
            </div>
        </div>
    @endif
    {{-- End Online Order --}}

</section>
<!-- End Slider Section -->


<!-- Content Section -->
<section class="welcome pt-110 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 wow animate__fadeInLeft" data-wow-duration="1s">
                <div style="height: 300px; overflow: hidden;" id="shopDescription">
                    @if (!empty($template_setting['polianna_store_description']))
                        {!! $template_setting['polianna_store_description'] !!}
                    @else
                        <h3 class="section-title color-green">Welcome to <br> Star Kebab &amp; Pizza</h3>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br>dolore eu fugiat nulla pariatur.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea <br>commodo consequat.<br>Duis aute irure dolor in reprehenderit in voluptate velit esse dolore eu fugiat nulla pariatur.</p>
                    @endif
                </div>
                <a class="btn mt-2 btn-green text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                <a style="display: none;" class="btn mt-2 btn-green text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
            </div>
            <div class="col-sm-12 col-md-6 wow animate__fadeInRight" data-wow-duration="1s">
                <div class="img-box">
                    @if (!empty($template_setting['polianna_banner_image']))
                        <img class="img-fluid" src="{{ $template_setting['polianna_banner_image'] }}"/>
                    @else
                        <img class="img-fluid" src="<img class="img-fluid" src="{{asset('/public/frontend/banners/wUnZa6jpg')}}"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Content Section -->


<!-- Best Category Section -->
<section class="categories pt-110 pb-110">
    <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <h3 class="section-title color-red">Best Categories</h3>
        <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
        <div class="categories-swiper">
            <div class="swiper-button-next">
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="swiper-button-prev">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="swiper">
                <div class="swiper-wrapper">

                    @if(count($best_categories) > 0)
                        @foreach ($best_categories as $categorydet)
                            <a class="swiper-slide" href="{{route('menu')}}">
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
                    @else
                        <a class="swiper-slide">
                            <h3>Category Not Available</h3>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Best Category Section -->


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
                            <a class="swiper-slide" href="{{route('menu')}}">
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
@if (!empty($store_setting['enable_gallery_module']) || $store_setting['enable_gallery_module'] != 0)   
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

