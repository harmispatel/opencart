<link
    href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&amp;family=Playfair+Display:wght@400;700&amp;display=swap"
    rel="stylesheet" />

    @php
        $template_setting = session('template_settings');
        $social_site = session('social_site');
        $store_setting = session('store_settings');
        $template_setting = session('template_settings');
        $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;
        $online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
    @endphp

<div class="mobile-menu-shadow"></div>
<sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
        href="#slide"><img class="img-fluid"
            src="{{ asset('public/assets/theme5/img/logo/black-logo.svg') }}" /></a>
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
            <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
            <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
            <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
            <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
        </ul>
    </div>
</sidebar>
<section class="home-slide-v5 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                <div class="order-online-v5">
                    <h2 class="__title"><span class="color-orange">Lorem ipsum</span><span>dolar</span><span
                            class="color-yellow">sit amet</span><span>consectetur</span><span
                            class="color-green">elit!</span></h2>
                    @if ($online_order_permission == 1)
                        <div class="order-online wow animate__fadeInUp" data-wow-duration="1s">
                            <strong class="title text-uppercase ">order online</strong>
                            <input class="form-control" placeholder="Eg. AA11AA" />
                            <p>Please enter your postcode to view our<br> menu and place an order</p>
                            <div class="btn__group">
                                <a class="btn btn-red text-uppercase">collection</a>
                                <a class="btn btn-yellow text-uppercase">delivery</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-7 wow animate__fadeInRight position-relative" data-wow-duration="1s">
                <div class="home-slide-v5-swiper swiper">
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
                                    src="{{ asset('public/assets/theme5/demo-data/slider.png') }}" /></div>
                        </div>
                    @endif
                    <div class="happy-customers"><strong class="text-uppercase">our happy customers</strong>
                        <div class="__img-list">
                            <div class="__img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/girl.jpeg') }}" /></div>
                            <div class="__img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/girl.jpeg') }}" /></div>
                            <div class="__img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/girl.jpeg') }}" /></div>
                            <div class="__count">8+</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-slide-category">
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-slide-item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" /></div>
                        <div class="__text-content">
                            <h4 class="text-uppercase">waldorf salad with</h4><strong class="text-uppercase">category
                                name</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-prev"><i class="fas fa-long-arrow-alt-left"></i></div>
        <div class="swiper-button-next"><i class="fas fa-long-arrow-alt-right"></i></div>
    </div>
</section>
<section class="who-are-we-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6"><img class="img-fluid"
                    src="{{ asset('public/assets/theme5/img/bg/about-us.png') }}" /></div>
            <div class="col-sm-12 col-md-6">
                <div class="default-title-v5"><strong class="sub-title color-orange text-uppercase">about us</strong>
                    <h3 class="title">The Best restaurant <br> in <br> the city</h3>
                    <p>{{ $store_setting['config_meta_description'] }}</p>
                </div><a class="btn btn-orange text-uppercase" href="">read more</a>
            </div>
        </div>
    </div>
</section>
<section class="best-categories-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v5 text-center container"><strong class="sub-title text-uppercase color-green">best
            categories</strong>
        <h3 class="title text-capitalize">best categories</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa earum excepturi fugit, <br> maiores
            praesentium qui, quidem rerum sed suscipit tempora temporibus totam voluptatibus.</p>
    </div>
    <div class="container">
        <div class="best-categories-v5-swiper">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
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
    </div>
</section>
<section class="popular-foods-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v5 text-center container"><strong class="sub-title text-uppercase color-orange">popular
            foods</strong>
        <h3 class="title text-capitalize">Popular foods in restaurant</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa earum excepturi fugit, <br> maiores
            praesentium qui, quidem rerum sed suscipit tempora temporibus totam voluptatibus.</p>
    </div>
    <div class="container">
        <div class="popular-foods-v5-swiper">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/1.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fruits Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div>
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
    </div>
</section>
<section class="user-comments-v5 pt-75 pb-75">
    <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <div class="default-title-v5"><strong class="sub-title text-uppercase color-orange">Recent Web
                Reviews</strong>
            <h3 class="title">What costumers says about best <br> food in restaurant</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.</p>
        </div>
        <div class="user-comments-v5-swiper position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><strong>Selçuk Aker 0</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            0</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 1</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            1</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 2</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            2</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 3</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            3</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 4</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            4</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 5</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            5</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 6</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            6</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 7</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            7</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 8</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            8</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 9</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            9</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 10</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            10</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 11</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            11</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 12</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            12</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 13</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            13</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 14</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            14</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 15</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            15</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 16</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            16</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 17</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            17</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 18</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            18</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 19</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            19</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 20</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            20</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 21</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            21</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 22</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            22</p><span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 23</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            23</p><span>UX Designer</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-comments-v5-swiper-control">
            <div class="number-of-slide"><span class="__text">Number of slide</span>
                <div class="swiper-scrollbar"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
<div class="photo-gallery-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-3 offset-lg-1">
                <div class="default-title-v5"><strong
                        class="sub-title color-red text-uppercase color-orange">gallery</strong>
                    <h3 class="title text-capitalize mb-5">Our gallery in the restaurant and you can see them.</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Culpa earum excepturi fugit,
                        maiores praesentium qui</p>
                </div>
                <div class="user-comments-v5-swiper-info">
                    <div class="number-of-slide"><span class="__text">Number of slide</span>
                        <div class="swiper-scrollbar"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}" /></div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item"><a class="fas fa-search-plus"
                                    href="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}"
                                    data-fancybox="photoGallery"></a><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}" /></div>
                        </div>
                    </div>
                </div>
                <div class="photo-gallery-v5-swiper-control">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="reservation-v5 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <form class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                <div class="default-title-v5"><strong
                        class="sub-title color-orange text-capitalize">reservation</strong>
                    <h3 class="title text-capitalize">What costumers says about best food in restaurant</h3>
                </div>
            </div>
            <div class="col-md-12 col-lg-7 wow animate__fadeInRight" data-wow-duration="1s">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-4">
                        <input class="form-control" placeholder="Full Name" type="text" />
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <input class="form-control" placeholder="Phone Number" type="text" />
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
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
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="icon"><i class="fas fa-chevron-down"></i>
                            <input class="form-control icon" placeholder="Date" id="date" type="text" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="icon"><i class="fas fa-chevron-down"></i>
                            <input class="form-control icon" placeholder="Time" id="time" type="text" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <button class="btn btn-orange text-capitalize">make reservation now</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<section class="opening-hours-v5 pt-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v5 text-center"><strong class="sub-title color-orange text-capitalize">opening
            hourse</strong>
        <h3 class="title text-capitalize">open 7 days a week</h3>
    </div>
    <div class="__info">
        <div class="__container"><img class="img-fluid mb-3"
                src="{{ asset('public/assets/theme5/img/icon/time-top-flower.svg') }}" /><strong
                class="__time-title">OPEN NOW</strong>
            <div class="__time"><strong>MONDAY-<br>SATURDAY</strong>
                <div class="__time-box">
                    <div class="__left-time"><span>9</span><span>A<br>M</span></div>
                    <div class="__time-divier"></div>
                    <div class="__right-time"><span>11</span><span>P<br>M</span></div>
                </div>
            </div>
            <div class="__time"><span>SUNDAY 9:30 AM to 11AM</span></div><img class="img-fluid mt-3"
                src="{{ asset('public/assets/theme5/img/icon/time-bottom-flower.svg') }}" />
        </div>
    </div>
</section>
