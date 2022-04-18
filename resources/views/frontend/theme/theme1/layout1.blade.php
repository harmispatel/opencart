<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700;800&amp;display=swap" rel="stylesheet"/>

@php
    $template_setting = session('template_settings');
    $store_setting = session('store_settings');
    $slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;
    $online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
@endphp

<sidebar class="mobile-menu">
    <a class="close far fa-times-circle" href="#"></a>
    <a class="logo" href="#slide">
        <img class="img-fluid" src="{{ asset('public/assets/theme2/img/logo/logo.svg') }}"/>
    </a>
    <div class="top">
        <ul class="menu">
            <li class="active">
                <a class="text-uppercase" href="#">home</a>
            </li>
            <li>
                <a class="text-uppercase" href="#">member</a>
            </li>
            <li>
                <a class="text-uppercase" href="#">menu</a>
            </li>
            <li>
                <a class="text-uppercase" href="#">check out</a>
            </li>
            <li>
                <a class="text-uppercase" href="#">contact us</a>
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
                <h3 class="section-title color-green">Welcome to <br> {{ $store_setting['config_name'] }}</h3>
                <p>
                    {{ $store_setting['config_meta_description'] }}
                </p>
                <a class="btn btn-green text-uppercase" href="">read more</a>
            </div>
            <div class="col-sm-12 col-md-6 wow animate__fadeInRight" data-wow-duration="1s">
                <div class="img-box">
                    <img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/welcome-bg.jpg') }}"/>
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
                <div class="swiper-wrapper"><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}"/></div><strong>Breakfast Chef 0</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 0</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/2.jpg') }}"/></div><strong>Breakfast Chef 1</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 1</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/3.jpg') }}"/></div><strong>Breakfast Chef 2</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 2</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/4.jpg') }}"/></div><strong>Breakfast Chef 3</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 3</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/5.jpg') }}"/></div><strong>Breakfast Chef 4</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 4</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/6.jpg') }}"/></div><strong>Breakfast Chef 5</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 5</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/7.jpg') }}"/></div><strong>Breakfast Chef 6</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 6</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/8.jpg') }}"/></div><strong>Breakfast Chef 7</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 7</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/9.jpg') }}"/></div><strong>Breakfast Chef 8</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 8</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/10.jpg') }}"/></div><strong>Breakfast Chef 9</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 9</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}"/></div><strong>Breakfast Chef 10</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 10</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/2.jpg') }}"/></div><strong>Breakfast Chef 11</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 11</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/3.jpg') }}"/></div><strong>Breakfast Chef 12</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 12</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/4.jpg') }}"/></div><strong>Breakfast Chef 13</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 13</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/5.jpg') }}"/></div><strong>Breakfast Chef 14</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 14</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/6.jpg') }}"/></div><strong>Breakfast Chef 15</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 15</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/7.jpg') }}"/></div><strong>Breakfast Chef 16</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 16</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/8.jpg') }}"/></div><strong>Breakfast Chef 17</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 17</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/9.jpg') }}"/></div><strong>Breakfast Chef 18</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 18</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/10.jpg') }}"/></div><strong>Breakfast Chef 19</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 19</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/1.jpg') }}"/></div><strong>Breakfast Chef 20</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 20</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/2.jpg') }}"/></div><strong>Breakfast Chef 21</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 21</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/3.jpg') }}"/></div><strong>Breakfast Chef 22</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 22</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/4.jpg') }}"/></div><strong>Breakfast Chef 23</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 23</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/5.jpg') }}"/></div><strong>Breakfast Chef 24</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 24</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/6.jpg') }}"/></div><strong>Breakfast Chef 25</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 25</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/7.jpg') }}"/></div><strong>Breakfast Chef 26</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 26</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/8.jpg') }}"/></div><strong>Breakfast Chef 27</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 27</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/9.jpg') }}"/></div><strong>Breakfast Chef 28</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 28</p>
                    </div></a><a class="swiper-slide" href="#">
                    <div class="box">
                      <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/popular-foods/10.jpg') }}"/></div><strong>Breakfast Chef 29</strong>
                      <p>Lorem ipsum dolor sit amet, consectetur 29</p>
                    </div></a>
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
            <form class="row" method="" action="">
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" placeholder="Full Name" type="text"/>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <input class="form-control" placeholder="Phone Number" type="text"/>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                  <select class="form-control">
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
                <div class="icon"><i class="fas fa-chevron-down"></i>
                  <input class="form-control icon" placeholder="Date" id="date" type="text"/>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                  <input class="form-control icon" placeholder="Time" id="time" type="text"/>
                </div>
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
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/1.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/1.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/2.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/2.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/3.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/3.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/4.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/4.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/5.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/5.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/6.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/6.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/7.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/7.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/8.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/8.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/9.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/9.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/10.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/10.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/11.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/11.jpg') }}"/></div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="box"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme1/demo-data/photo-gallery/12.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme1/demo-data/photo-gallery/12.jpg') }}"/></div>
              </div>
            </div>
          </div>
        </section>
        <section class="opening-hours pt-110 wow animate__fadeInUp" data-wow-duration="1s" style="background-image: url({{ asset('public/assets/theme1/img/bg/opening-hours-bg.jpg')}}">
          <div class="container text-center">
            <h3 class="title">Visit us</h3>
            <h3 class="sub-title">Opening Hours</h3><img class="img-fluid" src="{{ asset('public/assets/theme1/img/icon/opening-hours.svg') }}"/>
            <p>Sunday to Tuesday 09.00 – 23:00  |  Sunday 08:00 – 23:00</p>
          </div>
        </section>

