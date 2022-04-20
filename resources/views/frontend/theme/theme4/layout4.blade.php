@php
$temp_set = session('template_settings');
$template_setting = isset($temp_set) ? $temp_set : '';

$store_set = session('store_settings');
$store_setting = isset($store_set) ? $store_set : '';

$social = session('social_site');
$social_site = isset($social) ? $social : '#';

$slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;

$online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
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
            <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
            <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
            <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
            <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
        </ul>
    </div>
</sidebar>
<section class="home-slide-v4 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-7 position-relative">
                <div class="__circle">
                    <div class="__thumbs-item"><a href="#"
                            style="background-image: url({{ asset('public/assets/theme4/demo-data/home-slide/0.jpg') }})"
                            data-index="0"></a><a href="#"
                            style="background-image: url({{ asset('public/assets/theme4/demo-data/home-slide/1.jpg') }})"
                            data-index="1"></a><a href="#"
                            style="background-image: url({{ asset('public/assets/theme4/demo-data/home-slide/2.jpg') }})"
                            data-index="2"></a></div>
                </div>
                <div class="__circle"></div>
                <div class="__circle"></div>
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/slider.jpg') }}" /></div>
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/slider.jpg') }}" /></div>
                        <div class="swiper-slide"><img class="img-fluid"
                                src="{{ asset('public/assets/theme4/demo-data/slider.jpg') }}" /></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div class="order-online-v4">
                    {{-- <h1 class="__title">Welcome to <br>
                        <span>STAR KEBAB & PIZZA</span>
                    </h1>
                    <strong class="title text-uppercase">order online</strong>
                    <input class="form-control" placeholder="Eg. AA11AA" />
                    <p>Please enter your postcode to view our<br> menu and place an order</p>
                    <div class="btn__group"><a class="btn btn-purple text-uppercase">collection</a><a
                            class="btn btn-green text-uppercase">delivery</a></div> --}}
                    {{-- Online Order --}}
                    <h1 class="__title">Welcome to <br>
                        <span>STAR KEBAB & PIZZA</span>
                    </h1>
                    @if ($online_order_permission == 1)
                        <div class="order-online wow animate__fadeInUp" data-wow-duration="1s">
                            {{-- <h1 class="__title">Welcome to <br>
                            <span>STAR KEBAB & PIZZA</span>
                        </h1> --}}
                            <strong class="title text-uppercase">order online</strong>
                            <input class="form-control" placeholder="Eg. AA11AA" />
                            <p>Please enter your postcode to view our<br> menu and place an order</p>
                            <div class="btn__group">
                                <a class="btn btn-green text-uppercase">collection</a>
                                <a class="btn btn-red text-uppercase">delivery</a>
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
                <div class="default-title-v4"><strong class="sub-title color-green">About Us</strong>
                    <h3 class="title">Who are we?</h3>
                </div>
                <p>{{ $store_setting['config_meta_description'] }}</p>
            </div>
            <div class="col-12 col-md-12 col-lg-6 img"><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/img/bg/who-are-we.png') }}" /></div>
        </div>
    </div>
</section>
<section class="best-categories-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v4 text-center container"><strong class="sub-title color-green">Your Choose</strong>
        <h3 class="title text-capitalize">best categories</h3>
    </div>
    <div class="container">
        <div class="row list-item">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img"><img class="img-fluid"
                            src="{{ asset('public/assets/theme4/demo-data/best-categories/0.jpg') }}" /></div>
                    <div class="text-content"><strong class="text-capitalize">Eggs Chopies</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img"><img class="img-fluid"
                            src="{{ asset('public/assets/theme4/demo-data/best-categories/1.jpg') }}" /></div>
                    <div class="text-content"><strong class="text-capitalize">Chochin Cake</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="item">
                    <div class="img"><img class="img-fluid"
                            src="{{ asset('public/assets/theme4/demo-data/best-categories/2.jpg') }}" /></div>
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
            </div>
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
                                @if (!empty($food->hasOneProduct['image']) || $food->hasOneProduct['image'] != '')
                                    <img class="img-fluid"
                                        src="{{ asset('public/admin/product/' . $food->hasOneProduct['image']) }}">
                                @else
                                    <img class="img-fluid"
                                        src="{{ asset('public/admin/product/no_image.jpg') }}">
                                @endif
                            </div>
                            <div class="text-content">
                                <strong
                                    class="text-capitalize">{{ $food->hasOneProduct->hasOneProductDescription['name'] }}</strong>
                                @php
                                    $desc = html_entity_decode($food->hasOneProduct->hasOneProductDescription['description']);
                                    $description = strip_tags($desc);

                                    if ($description == '') {
                                        echo '<p>Description Not Avavilable.</p>';
                                    } else {
                                        echo '<p>' . $description . '</p>';
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
                src="{{ asset('public/assets/theme4/img/icon/commit-icon.svg') }}" />
        </div>
        <div class="user-comments-v4-swiper position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="message-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud
                                exercitation 0</p>
                        </div>
                        <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="message-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud
                                exercitation 1</p>
                        </div>
                        <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="message-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud
                                exercitation 2</p>
                        </div>
                        <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
<div class="photo-gallery-v4 pt-75 pb-75">
    <div class="container">
        <div class="default-title-v4 text-center"><strong class="sub-title color-purple">Delicious Foods</strong>
            <h3 class="title text-capitalize">photo gallery</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Culpa earum excepturi fugit, maiores
                praesentium qui</p>
        </div>
    </div>
    <div class="list-item-container">
        <div class="list-item">
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/0.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/0.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/1.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/1.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/2.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/2.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/3.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/3.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/4.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/4.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/5.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/5.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/6.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/6.jpg') }}" /></div>
            <div class="item"><a class="fas fa-search-plus"
                    href="{{ asset('public/assets/theme4/demo-data/photo-gallery/7.jpg') }}"
                    data-fancybox="photoGallery"></a><img class="img-fluid"
                    src="{{ asset('public/assets/theme4/demo-data/photo-gallery/7.jpg') }}" /></div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<section class="reservation-v4 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <form class="container" method="POST" action="{{ route('reservation') }}">
        {{ csrf_field() }}
        <div class="default-title-v4 text-center"><strong class="sub-title color-purple text-capitalize">book
                now</strong>
            <h3 class="title text-capitalize">make a reservation</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <input class="form-control" name="fullname" placeholder="Full Name" type="text" />
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <input class="form-control" name="phone" placeholder="Phone Number" type="text" />
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                    <select class="form-control" name="person">
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
                <div class="icon"><i class="fas fa-chevron-down"></i>
                    <input class="form-control icon" name="date" placeholder="Date" id="date" type="text" />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                    <input class="form-control icon" name="time" placeholder="Time" id="time" type="text" />
                </div>
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
        <div class="__time">
            <div class="__time-item"><strong>Mon - Fri</strong>
                <div><span>09AM</span><span>23PM</span></div>
            </div>
            <div class="__time-item"><strong>Sunday</strong>
                <div><span>12AM</span><span>23PM</span></div>
            </div>
        </div>
    </div>
</section>


</body>

</html>
