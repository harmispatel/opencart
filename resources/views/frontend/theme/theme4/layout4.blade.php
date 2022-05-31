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
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&amp;family=Playfair+Display:wght@400;700&amp;display=swap"
    rel="stylesheet" />

<div class="mobile-menu-shadow"></div>
<sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
        href="#slide"><img class="img-fluid"
            src="{{ asset('public/assets/theme4/img/logo/black-logo.svg') }}" /></a>
    <div class="top">
        <ul class="menu">
            <li class="active"><a class="text-uppercase" href="{{ route('home') }}">home</a></li>
            <li><a class="text-uppercase" href="#">member</a></li>
            <li><a class="text-uppercase" href="{{ route('menu') }}">menu</a></li>
            <li><a class="text-uppercase" href="#">check out</a></li>
            <li><a class="text-uppercase" href="{{ route('contact') }}">contact us</a></li>
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
            <li><a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a></li>
            <li><a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a></li>
        </ul>
    </div>
</sidebar>
<section class="home-slide-v4 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-7 position-relative">
                <div class="__circle">
                    <div class="__thumbs-item"><a href="#"
                            style="background-image: url({{ $template_setting['polianna_slider_1'] }})"
                            data-index="0"></a><a href="#"
                            style="background-image: url({{ $template_setting['polianna_slider_2'] }})"
                            data-index="1"></a><a href="#"
                            style="background-image: url({{ $template_setting['polianna_slider_3'] }})"
                            data-index="2"></a></div>
                </div>
                <div class="__circle"></div>
                <div class="__circle"></div>
                <div class="swiper">
                    @if ($slider_permission == 1)
                    <div class="swiper-wrapper">

                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ $template_setting['polianna_slider_1'] }}" /></div>
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ $template_setting['polianna_slider_2'] }}" /></div>
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ $template_setting['polianna_slider_3'] }}" /></div>
                    </div>
                    @else
                        
                    <div class="swiper-wrapper">

                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/slider.jpg') }}" /></div>
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/slider.jpg') }}" /></div>
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/slider.jpg') }}" /></div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div class="order-online-v4">
                    <h1 class="__title">Welcome to <br>
                        <span>STAR KEBAB & PIZZA</span>
                    </h1>
                    @if ($online_order_permission == 1)
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
                                        <input type="text" id="search_input1" placeholder="AB10 1BW">
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
                                    <a class="btn btn-green text-uppercase collection_button1">collection</a>
                                @endif

                                @if ($delivery_setting['enable_delivery'] != 'collection')
                                    <a class="btn btn-green text-uppercase delivery_button1">delivery</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    {{-- End Online Order --}}
                </div>
            </div>
        </div>
    </div>
</section>
<section class="who-are-we-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-6">
                <div>
                    @if (!empty( $template_setting['polianna_store_description']))
                        {!! $template_setting['polianna_store_description'] !!}
                    @else
                    <div class="default-title-v4">
                        <strong class="sub-title color-green">About Us</strong>
                        <h3 class="title">Who are we?</h3>
                    </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid consectetur deleniti dolorum est facilis labore maiores molestias odio officiis quam qui quisquam repellendus sapiente sequi suscipit tempora, ut. <br>Magnam. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                @if (!empty($template_setting['polianna_banner_image']))
                    <img class="rounded-circle" style="width: 400px;height: 400px;" src="{{ $template_setting['polianna_banner_image'] }}" />
                @else
                    <img class="rounded-circle" style="width: 400px;height: 400px;" src="{{asset('/public/frontend/banners/wUnZa6jpg')}}" />
                @endif
            </div>
        </div>
    </div>
</section>
<section class="best-categories-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v4 text-center container"><strong class="sub-title color-green">Your Choose</strong>
        <h3 class="title text-capitalize">best categories</h3>
    </div>
    <div class="container">
        <div class="row list-item">
            {{-- <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img"><img class="img-fluid"
                            src="{{ asset('public/assets/theme4/demo-data/best-categories/0.jpg') }}" /></div>
                    <div class="text-content"><strong class="text-capitalize">Eggs Chopies</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div> --}}
            @if(count($best_categories) > 0)
            @foreach ($best_categories as $categorydet)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img">
                        @if (isset($categorydet->hasOneCategoryDetails['image']))
                            {{-- <img class="img-fluid" src="{{$categorydet->hasOneCategoryDetails['image'] }}"/> --}}
                            <img class="img-fluid" src="{{$categorydet->hasOneCategoryDetails['image'] }}" />
                        @else
                            <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                        @endif
                    </div>
                    <strong>{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                    <p>{{ html_entity_decode($categorydet->hasOneCategoryDetails->hasOneCategory['description']) }}</p>
                </div>
            </div>
            @endforeach
            @endif
            {{-- <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme4/demo-data/best-categories/2.jpg') }}" /></div>
                    <div class="text-content"><strong class="text-capitalize">Eggs Chopies</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img"><img class="img-fluid"
                            src="{{ asset('public/assets/theme4/demo-data/best-categories/3.jpg') }}" /></div>
                    <div class="text-content"><strong class="text-capitalize">Buna Kirchi</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
<section class="popular-foods-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v4 text-center"><strong class="sub-title color-purple">Delicious Ones</strong>
            <h3 class="title text-capitalize">popular foods</h3>
        </div>
        <div class="row list-item">
            @if (count($popular_foods) > 0)
                @foreach ($popular_foods as $food)
                    <div class="col-12 col-md-6">
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
                    </div>
                @endforeach
            @else
                <div class="col-12 col-md-6">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/popular-foods/1.jpg') }}" /></div>
                        <div class="text-content"><strong class="text-capitalize">appetizers</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/popular-foods/1.jpg') }}" /></div>
                        <div class="text-content"><strong class="text-capitalize">appetizers</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/popular-foods/1.jpg') }}" /></div>
                        <div class="text-content"><strong class="text-capitalize">appetizers</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/popular-foods/1.jpg') }}" /></div>
                        <div class="text-content"><strong class="text-capitalize">appetizers</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="user-comments-v4 pt-75 pb-75">
    <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <div class="default-title-v4 text-center mb-0"><strong class="sub-title color-green">Reviews</strong>
            <h3 class="title">Recent Web Reviews</h3><img class="img-fluid"
                src="{{ get_css_url().'public/assets/theme4/img/icon/commit-icon.svg' }}" />
        </div>
        <div class="user-comments-v4-swiper position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    {{-- <div class="swiper-slide">
                        <div class="message-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud
                                exercitation 0</p>
                        </div>
                        <div class="message-info">
                            <strong>Selçuk Aker</strong>
                            <span>UX Designer</span>
                        </div>
                    </div> --}}
                    @foreach ($review['reviews'] as $item)
                        <div class="swiper-slide">
                            <div class="message-text"><strong>{{ $item->title }}</strong></div>
                            <div class="message-text">
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
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
@if($store_setting['enable_gallery_module'] == 1)
<div class="photo-gallery-v4 pt-75 pb-75">
    <div class="container">
        <div class="default-title-v4 text-center"><strong class="sub-title color-purple">gallary</strong>
            @if(!empty($store_setting['gallery_header_text']) || $store_setting['gallery_header_text'] != '')
            <h3 class="section-title color-green divider-white text-capitalize">{{ $store_setting['gallery_header_text'] }}</h3>
        @else
            <h3 class="section-title color-green divider-white text-capitalize">gallary</h3>
        @endif

        @if (!empty($store_setting['gallery_header_desc']) || $store_setting['gallery_header_desc'] != '')
            <p class="text">{{ $store_setting['gallery_header_desc'] }}</p>
        @endif
        </div>
    </div>
    <div class="list-item-container">
        <div class="list-item">
            @if(isset($photos))
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
            @else
                <div class="item">
                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme4/demo-data/photo-gallery/0.jpg') }}" data-fancybox="photoGallery"></a>
                    <img class="img-fluid" src="{{ asset('public/assets/theme4/demo-data/photo-gallery/0.jpg') }}" />
                </div>
                <div class="item">
                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme4/demo-data/photo-gallery/1.jpg') }}" data-fancybox="photoGallery"></a>
                    <img class="img-fluid" src="{{ asset('public/assets/theme4/demo-data/photo-gallery/1.jpg') }}" />
                </div>
                <div class="item">
                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme4/demo-data/photo-gallery/2.jpg') }}" data-fancybox="photoGallery"></a>
                    <img class="img-fluid" src="{{ asset('public/assets/theme4/demo-data/photo-gallery/2.jpg') }}" />
                </div>
                <div class="item">
                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme4/demo-data/photo-gallery/3.jpg') }}" data-fancybox="photoGallery"></a>
                    <img class="img-fluid" src="{{ asset('public/assets/theme4/demo-data/photo-gallery/3.jpg') }}" />
                </div>
                <div class="item">
                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme4/demo-data/photo-gallery/4.jpg') }}" data-fancybox="photoGallery"></a>
                    <img class="img-fluid" src="{{ asset('public/assets/theme4/demo-data/photo-gallery/4.jpg') }}" />
                </div>
            @endif
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
@endif
<section class="reservation-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <form class="container" method="POST" action="{{ route('reservation') }}">
        {{ csrf_field() }}
        <div class="default-title-v4 text-center"><strong class="sub-title color-purple text-capitalize">book now</strong>
            <h3 class="title text-capitalize">make a reservation</h3>
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
<section class="opening-hours-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v4"><strong class="sub-title color-orange text-capitalize">Open 7 Days a
                Week</strong>
            <h3 class="title text-capitalize">opening hours</h3>
        </div>
        {{-- <div class="__time">
            <div class="__time-item"><strong>{{ $openclose['days1'] }} - {{ $openclose['days2'] }}</strong>
                <div><span>{{ $openclose['fromtime'] }}</span><span>{{ $openclose['totime'] }}</span></div>
            </div>
            <div class="__time-item"><strong>Sunday</strong>
                <div><span>12AM</span><span>23PM</span></div>
            </div>
        </div> --}}
        <div class="__time">

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
                    <div class="__time-item">
                        @if ($firstday == $lastday)
                        <strong>{{ $firstday }}</strong>
                        @else
                        <strong>{{ $firstday }} - {{ $lastday }}</strong>
                        @endif
                        <div>
                            <span>{{ $fromtime[$key] }}</span>
                            <span>{{ $totime[$key] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        {{-- <div class="__time">
            <div class="__time-item"><strong>{{ $openclose['days1'] }} - {{ $openclose['days2'] }}</strong>
                <div><span>{{ $openclose['fromtime'] }}</span><span>{{ $openclose['totime'] }}</span></div>
            </div>
            <div class="__time-item"><strong>Sunday</strong>
                <div><span>12AM</span><span>23PM</span></div>
            </div>
        </div> --}}
    </div>
</section>


</body>

</html>
