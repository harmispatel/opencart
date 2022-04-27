<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&amp;family=Playfair+Display:wght@700&amp;display=swap"
    rel="stylesheet" />

@php
    $openclose = openclosetime();
    $review = storereview();
    $template_setting = session('template_settings');
    $store_setting = session('store_settings');
    $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;
    $online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';
@endphp

<div class="mobile-menu-shadow"></div>
<sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
        href="#slide"><img class="img-fluid" src="{{ asset('public/assets/theme3/img/logo/logo.svg') }}" /></a>
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
<section class="home-slide-v3 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6 wow animate__fadeInLeft" data-wow-duration="1s">
                <div class="order-online-v3">
                    <h1 class="__title">Welcome to <br><span>{{ $store_setting['config_name'] }}</span></h1>
                    @if ($online_order_permission == 1)
                        <strong class="title text-uppercase">order online</strong>
                        <input class="form-control" placeholder="Eg. AA11AA" />
                        <p>Please enter your postcode to view our<br> menu and place an order</p>
                        <div class="btn__group"><a class="btn btn-red text-uppercase">collection</a><a class="btn btn-orange text-uppercase">delivery</a></div>
                    @endif
                </div>
            </div>
            <div class="col-md-12 col-lg-6 wow animate__fadeInRight position-relative" data-wow-duration="1s">
                @if ($slider_permission == 1)
                <div class="swiper-text-content">
                  <div class="text-content"><strong class="__title">Lorem Ipsum</strong>
                    {{-- <p>Lorem Ipsum Dolar</p> --}}
                </div>
                  <div class="swiper-buttons">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                  </div>
                </div>
                <div class="swiper">
                  <div class="swiper-wrapper">
                    {{-- <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_1'] }}')" data-title="{{ $template_setting['polianna_slider_1_title'] }}" data-text="Lorem Ipsum Dolar 1"></div> --}}
                    <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_1'] }}')" data-title="{{ $template_setting['polianna_slider_1_title'] }}"></div>
                    {{-- <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_2'] }}')" data-title="{{ $template_setting['polianna_slider_2_title'] }}" data-text="Lorem Ipsum Dolar 2"></div> --}}
                    <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_2'] }}')" data-title="{{ $template_setting['polianna_slider_2_title'] }}"></div>
                    {{-- <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_3'] }}')" data-title="{{ $template_setting['polianna_slider_3_title'] }}" data-text="Lorem Ipsum Dolar 3"></div> --}}
                    <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_3'] }}')" data-title="{{ $template_setting['polianna_slider_3_title'] }}"></div>
                  </div>
                </div>
                @else
                <div class="swiper">
                    <div class="swiper-slide">
                        <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_1'] }}')"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="who-are-we pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container text-center">
        <div>
            @if (!empty($template_setting['polianna_store_description']))
                {!! $template_setting['polianna_store_description'] !!}
            @else
                <div class="default-title-v3">
                    <h3 class="title color-green">Who are we?</h3>
                </div>
                <h4 class="__title">"Star Kebab & Pizza WANT TO BE LIMITED."</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid consectetur deleniti dolorum est facilis labore maiores molestias odio officiis quam qui quisquam repellendus sapiente sequi suscipit tempora, ut. <br>Magnam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>At autem consequatur consequuntur dolor dolorum eligendi error excepturi facere illum, inventore laudantium, <br>libero minima mollitia nihil nobis quis quod tenetur vitae?</p>
            @endif
        </div>
    </div>
</section>
<section class="best-categories-icon pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v3 text-center container">
        <h3 class="title text-capitalize">best categories</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa earum excepturi fugit, <br> maiores
            praesentium qui, quidem rerum sed suscipit tempora temporibus totam voluptatibus.</p>
    </div>
    <div class="container">
        <div class="row list-item">
            @if(count($best_categories) > 0)
                @foreach ($best_categories as $categorydet)
                <div class="col-6 col-md-4 col-lg-2">
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
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="item">
                        <div class="img">
                            <img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/2.svg') }}" />
                        </div>
                            <strong class="text-capitalize">chicken</strong>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme3/demo-data/best-categories/3.svg') }}" /></div><strong
                            class="text-capitalize">cake</strong>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme3/demo-data/best-categories/4.svg') }}" /></div><strong
                            class="text-capitalize">noodle</strong>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="item">
                        <div class="img"><img class="img-fluid"
                                src="{{ asset('public/assets/theme3/demo-data/best-categories/5.svg') }}" /></div><strong
                            class="text-capitalize">drink</strong>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="popular-foods-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v3 text-center">
            <h3 class="title text-capitalize color-green">popular foods</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Culpa earum excepturi fugit, maiores
                praesentium qui</p>
        </div>

        <div class="row list-item">
            @if (count($popular_foods) > 0)
                @foreach ($popular_foods as $food)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
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
                    </div>
                @endforeach
            @else
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="item">
                        <div class="img">
                            <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                        </div>
                        <div class="text-content">
                            <strong class="text-capitalize">
                                Demo Food
                            </strong>
                            <p>This is demo food.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="user-comments-v3 pt-75 pb-75">
    <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <div class="default-title-v3 text-center">
            <h3 class="title color-red">Recent Web <br> Reviews</h3>
        </div>
        <div class="user-comments-v3-swiper position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    {{-- <div class="swiper-slide">
                        <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 0</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud
                                exercitation 0</p>
                        </div>
                        <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                    </div> --}}
                    @foreach ($review['reviews'] as $item)
                        <div class="swiper-slide">
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
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
<div class="photo-gallery-v3 pt-75 pb-75">
    <div class="container">
        <div class="default-title-v3 text-center">
            <h3 class="title text-capitalize color-red">photo gallery</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Culpa earum excepturi fugit, maiores
                praesentium qui</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row list-item">

            @if(isset($photos))
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
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/1.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/1.jpg') }}" />
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/2.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/2.jpg') }}" />
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/3.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/3.jpg') }}" />
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/4.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/4.jpg') }}" />
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<section class="reservation-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <form class="container" method="POST" action="{{ route('reservation') }}">
        {{ csrf_field() }}
        <div class="row align-items-center">
        <div class="col-md-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
            <div class="default-title-v3">
                <h3 class="title color-green text-capitalize">make a <br>reservation</h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
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
<section class="opening-hours-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div class="default-title-v3 text-center">
            <h3 class="title text-capitalize">opening hours</h3>
            <p>Open 7 Days a Week</p>
        </div>

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
                    <div class="__time-item">
                        @if ($firstday == $lastday)
                            <strong>{{ $firstday }}</strong>
                        @else
                            <strong>{{ $firstday }} - {{ $lastday }}</strong>
                        @endif
                        <span>{{ $fromtime[$key] }} - {{ $totime[$key] }}</span>
                    </div>
                    {{-- <div class="__time-item"><strong>Sunday</strong><span>12:00 - 23:00</span></div> --}}
                </div>
            <br>
        @endforeach
        {{-- <div class="__time">
            <div class="__time-item">
                <strong>{{ $openclose['days1'] }} - {{ $openclose['days2'] }}</strong>
                <span>{{ $openclose['fromtime'] }} - {{ $openclose['totime'] }}</span>
            </div>
            <div class="__time-item"><strong>Sunday</strong><span>12:00 - 23:00</span></div>
        </div> --}}
    </div>
</section>
