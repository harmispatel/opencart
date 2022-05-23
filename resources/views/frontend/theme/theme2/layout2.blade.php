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
.grid-header {
  text-align: center;
}

.grid {
  margin: 1rem auto;
  &-item {
    width: 250px;
    height: auto;
    margin-bottom: 10px;
    img {
      width: 100%;
      height: 100%;
    }
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
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
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
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
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
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
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
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
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
                <img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/1.jpg')}}"/>
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
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/1.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/2.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/3.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/1.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/2.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/3.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/1.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/2.jpg') }}"/></div>
                    <div class="swiper-slide"><img class="img-fluid" src="{{ asset('public/assets/demo-data/popular-foods/3.jpg') }}"/></div>
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
                            <a class="swiper-slide" href="#">
                                <div class="img">
                                    <img class="img-fluid" src="{{ asset('public/assets/theme2/demo-data/best-categories/2.jpg') }}" />
                                </div>
                                <strong>Breakfast Chef 2</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur 2</p>
                            </a>
                            <a class="swiper-slide" href="#">
                                <div class="img">
                                    <img class="img-fluid"
                                        src="{{ asset('public/assets/theme2/demo-data/best-categories/3.jpg') }}" />
                                </div>
                                <strong>Breakfast Chef 3</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur 3</p>
                            </a><a class="swiper-slide" href="#">
                                <div class="img">
                                    <img class="img-fluid"
                                        src="{{ asset('public/assets/theme2/demo-data/best-categories/4.jpg') }}" />
                                </div>
                                <strong>Breakfast Chef 4</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur 4</p>
                            </a>
                            <a class="swiper-slide" href="#">
                                <div class="img">
                                    <img class="img-fluid"
                                        src="{{ asset('public/assets/theme2/demo-data/best-categories/0.jpg') }}" />
                                </div>
                                <strong>Breakfast Chef 5</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur 5</p>
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
                            <a class="swiper-slide" href="#">
                                <div class="box">
                                    <div class="img">
                                        <img class="img-fluid"
                                            src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}" />
                                    </div>
                                    <strong>DEMO CAT 1</strong>
                                    <p>Lorem ipsum dolor sit amet, consectetur 1</p>
                                </div>
                            </a>
                            <a class="swiper-slide" href="#">
                                <div class="box">
                                    <div class="img">
                                        <img class="img-fluid"
                                            src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}" />
                                    </div>
                                    <strong>DEMO CAT 2</strong>
                                    <p>Lorem ipsum dolor sit amet, consectetur 2</p>
                                </div>
                            </a>
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
                
                    @foreach ($photos as $key => $photo)
                    {{-- @php
                        echo '<pre>';
                        echo $key;
                        echo " ";
                        print_r($photo->toArray());                        
                    @endphp --}}
                        {{-- <div class="grid-item">
                            @if(!empty($photo->image))
                                <img src="{{ $photo->image }}">
                            @else
                                <img src="{{ asset('public/frontend/other/no-image.jpg') }}">
                            @endif
                        </div> --}}
                        {{-- <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="box single">
                                <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                                </div>
                                <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                                </div>
                            </div>
                        </div>
                        </div> --}}

                            
                        {{-- <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="box single">
                                <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                            </div> --}}
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="row">
                                    {{-- <div class="col-12">
                                        <div class="box couple">
                                            <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                                        </div> --}}
                                    <div class="col-12">
                                        <div class="box couple">
                                            <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ $photo->image }}" /></div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @else
                    {{-- <div class="grid">
                        <div class="grid-item">
                            <img src="{{ asset('public/assets/theme2/demo-data/photo-gallery/0.png') }}" alt="">
                        </div>
                        <div class="grid-item">
                            <img src="{{ asset('public/assets/theme2/demo-data/photo-gallery/1.png') }}" alt="">
                        </div>
                        <div class="grid-item">
                            <img src="{{ asset('public/assets/theme2/demo-data/photo-gallery/2.png') }}" alt="">
                        </div>
                        <div class="grid-item">
                            <img src="{{ asset('public/assets/theme2/demo-data/photo-gallery/3.png') }}" alt="">
                        </div>
                        <div class="grid-item">
                            <img src="{{ asset('public/assets/theme2/demo-data/photo-gallery/4.png') }}" alt="">
                        </div>
                    </div> --}}
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="box single">
                                <a class="fas fa-search-plus" href="{{ asset('public/assets/demo-data/photo-gallery/6.jpg')}}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/demo-data/photo-gallery/6.jpg')}}" /></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ asset('public/assets/demo-data/photo-gallery/1.jpg')}}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/demo-data/photo-gallery/1.jpg')}}" /></div>
                                </div>
                                <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ asset('public/assets/demo-data/photo-gallery/2.jpg')}}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/demo-data/photo-gallery/2.jpg')}}" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="box single">
                                <a class="fas fa-search-plus" href="{{ asset('public/assets/demo-data/photo-gallery/3.jpg')}}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/demo-data/photo-gallery/3.jpg')}}" /></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ asset('public/assets/demo-data/photo-gallery/4.jpg')}}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/demo-data/photo-gallery/4.jpg')}}" /></div>
                                </div>
                                <div class="col-12">
                                    <div class="box couple">
                                        <a class="fas fa-search-plus" href="{{ asset('public/assets/demo-data/photo-gallery/5.jpg')}}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/demo-data/photo-gallery/5.jpg')}}" /></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section class="opening-hours-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
        <div class="container"><img class="img-fluid" src="{{ asset('public/assets/theme2/img/icon/opening-hours-top-divider.svg') }}" />
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

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>
    <script src="{{ asset('public/assets/js/gallary.js') }}"></script>

<script>
    var colWidth = $(".grid-item").width();

window.onresize = function(){
  var colWidth = $(".grid-item").width();
}
console.log(colWidth);

var $grid = $(".grid").masonry({
  // options
  itemSelector: ".grid-item",
  columnWidth: ".grid-item",
  // percentPosition: true,
  gutter: 10,
  fitWidth: true
});

$grid.imagesLoaded().progress(function() {
  $grid.masonry("layout");
});

</script>