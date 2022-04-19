<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet"/>

@php
    $template_setting = session('template_settings');
    $store_setting = session('store_settings');
    $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;
    $online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
@endphp

    <div class="mobile-menu-shadow"></div>
    <sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo" href="#slide"><img class="img-fluid" src="{{ asset('public/assets/theme3/img/logo/logo.svg') }}"/></a>
      <div class="top">
        <ul class="menu">
          <li class="active"><a class="text-uppercase" href="#">home</a></li>
          <li><a class="text-uppercase" href="#">member</a></li>
          <li><a class="text-uppercase" href="#">menu</a></li>
          <li><a class="text-uppercase" href="#">check out</a></li>
          <li><a class="text-uppercase" href="#">contact us</a></li>
        </ul>
      </div>
      <div class="center">
        <ul class="authentication-links">
          <li><a href="#"><i class="far fa-user"></i><span>Login</span></a></li>
          <li><a href="#"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
        </ul>
      </div>
      <div class="bottom">
        <div class="working-time"><strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span></div>
        <ul class="social-links">
          <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
          <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
          <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
          <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
        </ul>
      </div>
    </sidebar>
    <section class="home-slide-v3 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="container">
        <div class="row">
          {{-- <div class="col-md-12 col-lg-6 wow animate__fadeInLeft" data-wow-duration="1s">
            <div class="order-online-v3">
              <h1 class="__title">Welcome to <br><span>STAR KEBAB & PIZZA</span></h1><strong class="title text-uppercase">order online</strong>
              <input class="form-control" placeholder="Eg. AA11AA"/>
              <p>Please enter your postcode to view our<br> menu and place an order</p>
              <div class="btn__group"><a class="btn btn-red text-uppercase">collection</a><a class="btn btn-orange text-uppercase">delivery</a></div>
            </div>
          </div> --}}
          @if ($online_order_permission == 1)
          <div class="col-md-12 col-lg-6 wow animate__fadeInLeft" data-wow-duration="1s">
            <div class="order-online-v3">
              <h1 class="__title">Welcome to <br><span>STAR KEBAB & PIZZA</span></h1><strong class="title text-uppercase">order online</strong>
              <input class="form-control" placeholder="Eg. AA11AA"/>
              <p>Please enter your postcode to view our<br> menu and place an order</p>
              <div class="btn__group"><a class="btn btn-red text-uppercase">collection</a><a class="btn btn-orange text-uppercase">delivery</a></div>
            </div>
          </div>
      @endif
          <div class="col-md-12 col-lg-6 wow animate__fadeInRight position-relative" data-wow-duration="1s">
            <div class="swiper-text-content">
              <div class="text-content"><strong class="__title">Lorem Ipsum</strong>
                <p>Lorem Ipsum Dolar</p>
              </div>
              <div class="swiper-buttons">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>
            </div>
            {{-- <div class="swiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url({{ asset('public/assets/theme3/demo-data/slider.jpg')}})" data-title="Lorem Ipsum 1" data-text="Lorem Ipsum Dolar 1"></div>
                <div class="swiper-slide" style="background-image: url({{ asset('public/assets/theme3/demo-data/slider.jpg')}})" data-title="Lorem Ipsum 2" data-text="Lorem Ipsum Dolar 2"></div>
                <div class="swiper-slide" style="background-image: url({{ asset('public/assets/theme3/demo-data/slider.jpg')}})" data-title="Lorem Ipsum 3" data-text="Lorem Ipsum Dolar 3"></div>
              </div>
            </div> --}}
                {{-- Slider --}}
            @if($slider_permission == 1)
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_1'] }}')")" data-title="Lorem Ipsum 1" data-text="{{ $template_setting['polianna_slider_1_title'] }}"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide" style="background-image: url('{{ $template_setting['polianna_slider_2'] }}')" data-title="Lorem Ipsum 2" data-text="{{ $template_setting['polianna_slider_2_title'] }}"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="swiper-slide" style="background-image: url('{{$template_setting['polianna_slider_3']}}')" data-title="Lorem Ipsum 3" data-text="{{ $template_setting['polianna_slider_3_title'] }}"></div>
                    </div>
                </div>
                {{-- <div class="swiper-button-next">
                    <i class="fas fa-arrow-right"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="fas fa-arrow-left"></i>
                </div> --}}
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
          </div>
        </div>
      </div>
    </section>
    <section class="who-are-we pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="container text-center">
        <div class="default-title-v3">
          <h3 class="title color-green">Who are we?</h3>
        </div>
        <h4 class="__title">"Star Kebab & Pizza WANT TO BE LIMITED."</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid consectetur deleniti dolorum est facilis labore maiores molestias odio officiis quam qui quisquam repellendus sapiente sequi suscipit tempora, ut. <br>Magnam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>At autem consequatur consequuntur dolor dolorum eligendi error excepturi facere illum, inventore laudantium, <br>libero minima mollitia nihil nobis quis quod tenetur vitae?</p>
      </div>
    </section>
    <section class="best-categories-icon pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="default-title-v3 text-center container">
        <h3 class="title text-capitalize">best categories</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa earum excepturi fugit, <br> maiores praesentium qui, quidem rerum sed suscipit tempora temporibus totam voluptatibus.</p>
      </div>
      <div class="container">
        <div class="row list-item">
          <div class="col-6 col-md-4 col-lg-2">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/0.svg') }}"/></div><strong class="text-capitalize">burger</strong>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/1.svg') }}"/></div><strong class="text-capitalize">pizza</strong>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/2.svg') }}"/></div><strong class="text-capitalize">chicken</strong>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/3.svg') }}"/></div><strong class="text-capitalize">cake</strong>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/4.svg') }}"/></div><strong class="text-capitalize">noodle</strong>
            </div>
          </div>
          <div class="col-6 col-md-4 col-lg-2">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/best-categories/5.svg') }}"/></div><strong class="text-capitalize">drink</strong>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="popular-foods-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="container">
        <div class="default-title-v3 text-center">
          <h3 class="title text-capitalize color-green">popular foods</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Culpa earum excepturi fugit, maiores praesentium qui</p>
        </div>
        <div class="row list-item">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/popular-foods/1.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">appetizers</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/popular-foods/2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">seafood</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/popular-foods/3.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">soups</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
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
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>
    </section>
    <div class="photo-gallery-v3 pt-75 pb-75">
      <div class="container">
        <div class="default-title-v3 text-center">
          <h3 class="title text-capitalize color-red">photo gallery</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Culpa earum excepturi fugit, maiores praesentium qui</p>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row list-item">
          <div class="col-12 col-md-6 col-lg-3">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/1.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/1.jpg') }}"/></div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/2.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/2.jpg') }}"/></div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/3.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/3.jpg') }}"/></div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme3/demo-data/photo-gallery/4.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme3/demo-data/photo-gallery/4.jpg') }}"/></div>
          </div>
        </div>
      </div>
    </div>
    <section class="reservation-v3 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <form class="container">
        <div class="row align-items-center">
              {{-- Online Order --}}
            @if ($online_order_permission == 1)
            <div class="col-md-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                <div class="default-title-v3">
                  <h3 class="title color-green text-capitalize">make a <br>reservation</h3>
                  <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum <br> dolore eu fugiat nulla pariatur.</p>
                </div>
                <button class="btn btn-red text-capitalize">make reservation now</button>
              </div>
        @endif
{{-- End Online Order --}}
          <div class="col-md-12 col-lg-7 wow animate__fadeInRight" data-wow-duration="1s">
            <div class="row">
              <div class="col-12 col-sm-6 mb-4">
                <input class="form-control" placeholder="Full Name" type="text"/>
              </div>
              <div class="col-12 col-sm-6 mb-4">
                <input class="form-control" placeholder="Phone Number" type="text"/>
              </div>
              <div class="col-12 col-sm-6 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                  <select class="form-control select2">
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
                  <input class="form-control icon" placeholder="Date" id="date" type="text"/>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                  <input class="form-control icon" placeholder="Time" id="time" type="text"/>
                </div>
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
        <div class="__time">
          <div class="__time-item"><strong>Monday - Friday</strong><span>09:00 - 23:00</span></div>
          <div class="__time-item"><strong>Sunday</strong><span>12:00 - 23:00</span></div>
        </div>
      </div>
    </section>
