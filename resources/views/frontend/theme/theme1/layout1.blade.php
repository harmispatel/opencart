<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;800&amp;display=swap" rel="stylesheet"/>

@php
    $openclose = openclosetime();
    $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $store_set = session('store_settings');
    $store_setting = isset($store_set) ? $store_set : '';

    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';

    $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;

    $online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
@endphp

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
            <input class="form-control" placeholder="Eg. AA11AA"/>
            <p>Please enter your postcode to view our<br> menu and place an order</p>
            <div class="btn__group">
                <a class="btn btn-green text-uppercase">collection</a>
                <a class="btn btn-red text-uppercase">delivery</a>
            </div>
        </div>
    @endif
    {{-- End Online Order --}}

</section>

<section class="welcome pt-110 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 wow animate__fadeInLeft" data-wow-duration="1s">
                <div style="height: 300px; overflow: hidden;" id="shopDescription">
                    {!! $template_setting['polianna_store_description'] !!}
                </div>
                <a class="btn mt-2 btn-green text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                <a style="display: none;" class="btn mt-2 btn-green text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
            </div>
            <div class="col-sm-12 col-md-6 wow animate__fadeInRight" data-wow-duration="1s">
                <div class="img-box">
                    <img class="img-fluid" src="{{ $template_setting['polianna_banner_image'] }}"/>
                </div>
            </div>
        </div>
    </div>
</section>

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
                <a class="swiper-slide" href="#">
                    <div class="img">
                        <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/0.jpg') }}"/>
                    </div>
                    <strong>Breakfast Chef 0</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur 0</p>
                </a>
                <a class="swiper-slide" href="#">
                    <div class="img">
                        <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/1.jpg') }}"/>
                    </div>
                    <strong>Breakfast Chef 1</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur 1</p>
                </a>
                <a class="swiper-slide" href="#">
                    <div class="img">
                        <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/2.jpg') }}"/>
                    </div>
                    <strong>Breakfast Chef 2</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur 2</p>
                </a>
                <a class="swiper-slide" href="#">
                    <div class="img">
                        <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/3.jpg') }}"/>
                    </div>
                    <strong>Breakfast Chef 3</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur 3</p>
                </a>
                <a class="swiper-slide" href="#">
                    <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/4.jpg') }}"/>
                    </div>
                    <strong>Breakfast Chef 4</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur 4</p>
                </a>
                <a class="swiper-slide" href="#">
                    <div class="img">
                        <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/0.jpg') }}"/></div><strong>Breakfast Chef 5</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 5</p></a>
                <a class="swiper-slide" href="#">
                    <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/1.jpg') }}"/></div><strong>Breakfast Chef 6</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 6</p></a>
                <a class="swiper-slide" href="#">
                    <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/2.jpg') }}"/></div><strong>Breakfast Chef 7</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 7</p></a>
                <a class="swiper-slide" href="#">
                    <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/3.jpg') }}"/></div><strong>Breakfast Chef 8</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 8</p></a><a class="swiper-slide" href="#">
                <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/4.jpg') }}"/></div><strong>Breakfast Chef 9</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 9</p></a><a class="swiper-slide" href="#">
                <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/0.jpg') }}"/></div><strong>Breakfast Chef 10</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 10</p></a><a class="swiper-slide" href="#">
                <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/1.jpg') }}"/></div><strong>Breakfast Chef 11</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 11</p></a><a class="swiper-slide" href="#">
                <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/2.jpg') }}"/></div><strong>Breakfast Chef 12</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 12</p></a><a class="swiper-slide" href="#">
                <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/3.jpg') }}"/></div><strong>Breakfast Chef 13</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 13</p></a><a class="swiper-slide" href="#">
                <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/best-categories/4.jpg') }}"/></div><strong>Breakfast Chef 14</strong>
                <p>Lorem ipsum dolor sit amet, consectetur 14</p></a>
            </div>
        </div>
    </div>
    </div>
</section>

        <section class="popular-foods">
          <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
            <h3 class="section-title color-green">Popular Foods</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
            <div class="popular-foods-swiper">
              <div class="swiper">
                <div class="swiper-wrapper">
                    @if (count($popular_foods) > 0)
                        @foreach ($popular_foods as $food)
                            <a class="swiper-slide" href="#">
                                <div class="box">
                                    <div class="img">
                                        @if (isset($food->hasOneProduct['image']))
                                            <img class="img-fluid" src="{{ asset('public/admin/product/'.$food->hasOneProduct['image']) }}">
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
                        @endforeach
                    @else
                        <a class="swiper-slide" href="#">
                            <div class="box">
                                <div class="img">
                                    <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}"/>
                                </div>
                                <strong>DEMO CAT 1</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur 1</p>
                            </div>
                        </a>
                        <a class="swiper-slide" href="#">
                            <div class="box">
                                <div class="img">
                                    <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}"/>
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
        <section class="user-comments pt-110 pb-110">
          <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
            <h3 class="section-title color-red">Recent Web Reviews</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
            <div class="user-comments-swiper">
              <div class="swiper">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 0</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud exercitation 0</p>
                    </div>
                    <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 1</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud exercitation 1</p>
                    </div>
                    <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="message-text"><strong>THAT’S AN AWESOME RESTAURANT & FOOD 2</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, <br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad <br>minim veniam, quis nostrud exercitation 2</p>
                    </div>
                    <div class="message-info"><strong>Selçuk Aker</strong><span>UX Designer</span></div>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </section>
        <section class="reservation pt-110 pb-110">
          <div class="container wow animate__fadeInUp" data-wow-duration="1s">
            <h3 class="section-title color-green divider-white text-capitalize">make a reservation</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
            <form class="row" method="POST" action="{{ route('reservation') }}">
                {{ csrf_field() }}
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" name="fullname" placeholder="Full Name" type="text"/>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" name="phone" placeholder="Phone Number" type="text"/>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                  <select class="form-control bg-dark" name="person">
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
                <input class="form-control text-white" style="color-scheme: dark;" name="date" id="date" type="date"/>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" style="color-scheme: dark;" name="time" id="time" type="time"/>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <button class="btn btn-green text-capitalize">make reservation now<i class="fas fa-arrow-right"></i></button>
              </div>
            </form>
          </div>
        </section>
        <section class="photo-gallery pt-110 pb-110">
          <div class="container wow animate__fadeInUp" data-wow-duration="1s">
            <h3 class="section-title color-green divider-white text-capitalize">photo gallery</h3>
            <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
          </div>
          <div class="container-fluid wow animate__fadeInUp" data-wow-duration="1s">
            <div class="row">
                @if(isset($photos))
                   @foreach ($photos as $photo)
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="box">
                            <a class="fas fa-search-plus" href="{{ $photo->image }}" data-fancybox="photoGallery"></a>
                            <img class="img-fluid" src="{{ $photo->image }}"/>
                        </div>
                    </div>
                   @endforeach
                @else
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="box">
                            <a class="fas fa-search-plus" href="./assets/theme1/demo-data/photo-gallery/1.jpg" data-fancybox="photoGallery"></a>
                            <img class="img-fluid" src="./assets/theme1/demo-data/photo-gallery/1.jpg"/>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="box">
                            <a class="fas fa-search-plus" href="./assets/theme1/demo-data/photo-gallery/2.jpg" data-fancybox="photoGallery"></a>
                            <img class="img-fluid" src="./assets/theme1/demo-data/photo-gallery/2.jpg"/>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="box">
                            <a class="fas fa-search-plus" href="./assets/theme1/demo-data/photo-gallery/3.jpg" data-fancybox="photoGallery"></a>
                            <img class="img-fluid" src="./assets/theme1/demo-data/photo-gallery/3.jpg"/>
                        </div>
                    </div>
                @endif
            </div>
          </div>
        </section>
        <section class="opening-hours pt-110 wow animate__fadeInUp" data-wow-duration="1s" style="background-image: url({{ asset('public/assets/theme1/img/bg/opening-hours-bg.jpg')}}">
          <div class="container text-center">
            <h3 class="title">Visit us</h3>
            <h3 class="sub-title">Opening Hours</h3><img class="img-fluid" src="{{ asset('public/assets/theme1/img/icon/opening-hours.svg') }}"/>
            <p>{{ $openclose['days1'] }} to {{ $openclose['days2'] }} {{ $openclose['fromtime'] }} - {{ $openclose['totime'] }}  |  Sunday 08:00 – 23:00</p>
          </div>
        </section>
