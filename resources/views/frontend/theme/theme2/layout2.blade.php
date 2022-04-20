    <link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;700&amp;family=Oswald:wght@400;500&amp;family=Raleway:wght@400;700&amp;display=swap" rel="stylesheet" />

    <style>
        .grid-header
        {
            text-align: center;
        }

        .grid
        {
            margin: 1rem auto;
        }

        .grid-item
        {
            width: 250px;
            height: auto;
            margin-bottom: 10px;
        }

        img
        {
            width: 100%;
            height: 100%;
        }
    </style>

    @php
        $template_setting = session('template_settings');
        $social_site = session('social_site');
        $store_setting = session('store_settings');
        $template_setting = session('template_settings');
        $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;
    @endphp

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
                    <a class="text-uppercase" href="#">check out</a>
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
                <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
                <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
                <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
                <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
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
                            <a class="fab fa-facebook" href="#" target="_blank"></a>
                        </li>
                        <li>
                            <a class="fab fa-twitter" href="#" target="_blank"></a>
                        </li>
                        <li>
                            <a class="fab fa-pinterest-p" href="#" target="_blank"></a>
                        </li>
                        <li>
                            <a class="fab fa-instagram" href="#" target="_blank"></a>
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
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo voluptates adipisci omnis
                            excepturi inventore ducimus corrupti beatae quibusdam hic molestias sit modi iste commodi
                            atque rem magni perspiciatis provident magnam quidem eligendi, tenetur ut laboriosam,
                            voluptate sequi! Veritatis modi aspernatur, mollitia culpa vero quis optio aut quasi
                            laudantium, porro possimus.</p>
                        <a class="text-uppercase" href="#">read more<span></span></a>
                    </div>
                </div>
                <div class="swiper-slide"
                    style="background-image: url({{ $template_setting['polianna_slider_2'] }})">
                    <div class="container">
                        <h3 class="text-capitalize">{{ $template_setting['polianna_slider_2_title'] }}</h3>
                        <img class="img-fluid __icon"
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                            commodo consequat. Duis aute irure dolor in reprehenderit in nulla pariatur anim id est
                            laborum sunt in dolor in reprehenderit in.</p>
                        <a class="text-uppercase" href="#">read more<span></span></a>
                    </div>
                </div>
                <div class="swiper-slide"
                    style="background-image: url({{ $template_setting['polianna_slider_3'] }})">
                    <div class="container">
                        <h3 class="text-capitalize">{{ $template_setting['polianna_slider_3_title'] }}</h3>
                        <img class="img-fluid __icon"
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
                        <p>It is a long established fact that a reader will be distracted by the readable content of a
                            page when looking at its layout. The point of using Lorem Ipsum is that it has a
                            more-or-less normal distribution of letters, as opposed to using 'Content here, content
                            here', making it look like readable English.</p>
                        <a class="text-uppercase" href="#">read more<span></span></a>
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
                        <h3 class="text-capitalize">star kebab & pizza 0</h3>
                        <img class="img-fluid __icon"
                            src="{{ asset('public/assets/theme2/img/icon/slide-divider.svg') }}" />
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo voluptates adipisci omnis
                            excepturi inventore ducimus corrupti beatae quibusdam hic molestias sit modi iste commodi
                            atque rem magni perspiciatis provident magnam quidem eligendi, tenetur ut laboriosam,
                            voluptate sequi! Veritatis modi aspernatur, mollitia culpa vero quis optio aut quasi
                            laudantium, porro possimus.</p>
                        <a class="text-uppercase" href="#">read more<span></span></a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="about-us container wow animate__fadeInUp" data-wow-duration="1s">
        <div class="row">
            <div class="col-md-12 col-lg-6 img">
                <img class="img-fluid" src="{{ asset('public/assets/theme2/demo-data/about-us.jpg') }}" />
            </div>
            <div class="col-md-12 col-lg-6 content">
                <strong class="sub-title text-capitalize">star kebab & pizza</strong>
                <h3 class="title text-uppercase">about us</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Bibendum est ultricies integer quis. Iaculis urna id volutpat lacus laoreet.
                    Mauris vitae ultricies leo integer malesuada. Ac odio tempor orci dapibus ultrices in. Egestas diam
                    in arcu cursus</p>
                <div class="about-us-swiper swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/1.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/2.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/3.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/1.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/2.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/3.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/1.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/2.jpg') }}" />
                        </div>
                        <div class="swiper-slide">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme2/demo-data/about-us-slider/3.jpg') }}" />
                        </div>
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
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 0</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 0</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 1</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 1</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/2.jpg') }}" />
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
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 6</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 6</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 7</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 7</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/3.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 8</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 8</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/4.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 9</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 9</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 10</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 10</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 11</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 11</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 12</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 12</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/3.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 13</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 13</p>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="img">
                                <img class="img-fluid"
                                    src="{{ asset('public/assets/theme2/demo-data/best-categories/4.jpg') }}" />
                            </div>
                            <strong>Breakfast Chef 14</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur 14</p>
                        </a>
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
                                            <img class="img-fluid"
                                                src="{{ asset('public/admin/product/' . $food->hasOneProduct['image']) }}">
                                        @else
                                            <img class="img-fluid"
                                                src="{{ asset('public/admin/product/no_image.jpg') }}">
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
                <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br>
                    dolore eu fugiat nulla pariatur.</p>
            </div>
            <div class="user-comments-v2-swiper position-relative">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 0</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis
                                    nostrud exercitation 0</p>
                            </div>
                            <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 1</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis
                                    nostrud exercitation 1</p>
                            </div>
                            <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 2</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis
                                    nostrud exercitation 2</p>
                            </div>
                            <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                        </div>
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
            <form class="row" method="" action="">
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                    <input class="form-control" placeholder="Full Name" type="text" />
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                    <input class="form-control" placeholder="Phone Number" type="text" />
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                    <div class="icon"><i class="fas fa-chevron-down"></i>
                        <select class="form-control">
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
                    <div class="icon"><i class="fas fa-chevron-down"></i>
                        <input class="form-control icon" placeholder="Date" id="date" type="text" />
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                    <div class="icon"><i class="fas fa-chevron-down"></i>
                        <input class="form-control icon" placeholder="Time" id="time" type="text" />
                    </div>
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
        <div class="container-fluid wow animate__fadeInUp" data-wow-duration="1s">

            <div class="row">
                @if(isset($photos))
                    <div class="grid">
                        @foreach ($photos as $photo)
                            <div class="grid-item">
                                @if(file_exists($photo->image))
                                    <img src="{{ $photo->image }}">
                                @else
                                    <img src="{{ asset('public/frontend/other/no-image.jpg') }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="grid">
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
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section class="opening-hours-v2 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
        <div class="container"><img class="img-fluid"
                src="{{ asset('public/assets/theme2/img/icon/opening-hours-top-divider.svg') }}" />
            <h3 class="title text-uppercase">opening hours</h3>
            <div class="_divider"></div><a href="tel:03254769875">TEL: 03254769875</a>
            <h3 class="title text-uppercase __divider">hours</h3>
            <div class="__time"><span>MON-FRI</span><span>9.30AM-11PM</span></div>
            <div class="__time"><span>SUN</span><span>9.30AM-11PM</span></div><img class="img-fluid"
                src="{{ asset('public/assets/theme2/img/icon/opening-hours-bottom-divider.svg') }}" />
        </div>
    </section>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>
    <script src="{{ asset('public/assets/js/gallary.js') }}"></script>

