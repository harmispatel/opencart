<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;700&amp;display=swap" rel="stylesheet"/>

    <div class="mobile-menu-shadow"></div>
    <sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo" href="#slide"><img class="img-fluid" src="{{ asset('public/assets/theme6/img/logo/black-logo.svg') }}"/></a>
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
    <section class="home-slide-v6 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="home-slide-v6-swiper">
        <div class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url({{ asset('public/assets/theme6/demo-data/slider.jpg') }})">
              <div class="container">
                <div class="slide-logo"><img class="img-fluid" src="{{ asset('public/assets/theme6/img/logo/slider-logo.svg') }}"/></div>
                <h2 class="__title">Our restaurant offers amazing dishes from around the world!</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aut dolorum eius eligendi est ipsa iste, magnam nesciunt non nostrum odit, omnis quam reprehenderit vitae voluptatem. Culpa mollitia placeat rem.</p>
              </div>
            </div>
            <div class="swiper-slide" style="background-image: url({{ asset('public/assets/theme6/demo-data/slider.jpg')}})">
              <div class="container">
                <h2 class="__title">Our restaurant offers amazing dishes from around the world!</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aut dolorum eius eligendi est ipsa iste, magnam nesciunt non nostrum odit, omnis quam reprehenderit vitae voluptatem. Culpa mollitia placeat rem.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="order-online-v6"><strong class="title text-uppercase">order online</strong>
        <input class="form-control" placeholder="Eg. AA11AA"/>
        <p>Please enter your postcode to view our<br> menu and place an order</p>
        <div class="btn__group"><a class="btn btn-white text-uppercase">collection</a><a class="btn btn-red text-uppercase">delivery</a></div>
      </div>
      <div class="__btn-bottom"><i class="fas fa-arrow-down"></i></div>
    </section>
    <section class="who-are-we-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="container">
        <div class="default-title-v6"><strong class="sub-title color-orange text-uppercase">about us</strong>
          <h3 class="title text-uppercase">SEE WHO WE ARE AND WHAT WE OFFER!</h3>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid consectetur deleniti dolorum est facilis labore maiores molestias odio officiis quam qui quisquam repellendus sapiente sequi suscipit tempora, ut.</p>
        <p>Magnam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>At autem consequatur consequuntur dolor dolorum eligendi error excepturi facere illum, inventore laudantium, <br>libero minima mollitia nihil nobis quis quod tenetur vitae?</p><a class="btn text-uppercase" href="">read more</a>
      </div>
    </section>
    <section class="reservation-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s">
      <form class="container">
        <div class="default-title-v6"><strong class="sub-title color-orange text-uppercase">reservation</strong>
          <h3 class="title text-uppercase">BOOK A TABLE NOW!</h3>
        </div>
        <div class="row">
          <div class="col">
            <input class="form-control" placeholder="Full Name" type="text"/>
          </div>
          <div class="col">
            <input class="form-control" placeholder="Phone Number" type="text"/>
          </div>
          <div class="col">
            <div class="icon"><i class="fas fa-chevron-down"></i>
              <select class="form-control select2">
                <option value="" selected="selected">Person</option>
                <option value="10">10</option>
              </select>
            </div>
          </div>
          <div class="col">
            <div class="icon"><i class="fas fa-chevron-down"></i>
              <input class="form-control icon" placeholder="Date &amp; Time" id="date" type="text"/>
            </div>
          </div>
          <div class="col">
            <button class="btn btn-red text-capitalize">book now</button>
          </div>
        </div>
      </form>
    </section>
    <section class="photo-gallery-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="default-title-v6"><strong class="sub-title color-orange text-uppercase">gallery</strong>
        <h3 class="title text-uppercase">OUR RESTAURANT AND THE FOOD THEY SERVE THEIR GUESTS</h3>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 1.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 1.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 3.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 3.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 4.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 4.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 5.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 5.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 6.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 6.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 7.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 7.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 8.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 8.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 9.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 9.jpg') }}"/></div>
          </div>
          <div class="col">
            <div class="item"><a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 10.jpg') }}" data-fancybox="photoGallery"></a><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 10.jpg') }}"/></div>
          </div>
        </div>
      </div>
    </section>
    <section class="popular-foods-v6 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="default-title-v6"><strong class="sub-title color-orange text-uppercase">Popular Foods</strong>
        <h3 class="title text-uppercase">CHECK OUT OUR MENU AND SELECT SOMETHING FOR EVERYONE</h3>
      </div>
      <div class="container">
        <div class="row list-item">
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6">
            <div class="item">
              <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}"/></div>
              <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="popular-categories-v6 pt-90 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="default-title-v6 text-center container"><strong class="sub-title text-uppercase">popular categories</strong>
        <h3 class="title text-capitalize">CHECK OUT OUR MENU AND SELECT SOMETHING FOR EVERYONE</h3>
      </div>
      <div class="container">
        <div class="popular-categories-v6-swiper">
          <div class="__btn-list"><a class="text-uppercase active" href="" data-filter="all">all</a><a class="text-uppercase" href="" data-filter="breakfast">breakfast</a><a class="text-uppercase" href="" data-filter="soup">soup</a></div>
          <div class="swiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="breakfast">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/0.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">breakfast</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
              <div class="swiper-slide" data-slide-filter="soup">
                <div class="item">
                  <div class="img"><img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/best-categories/1.jpg') }}"/></div>
                  <div class="text-content"><strong class="text-capitalize">soup</strong>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section>
    <section class="user-comments-v6 pt-90 pb-90">
      <div class="container pt-110 pb-110 wow animate__fadeInUp" data-wow-duration="1s">
        <div class="default-title-v6"><strong class="sub-title text-uppercase">Testimonials</strong>
          <h3 class="title">WHAT OUR CUSTOMERS SAY</h3>
        </div>
        <div class="user-comments-v6-swiper position-relative">
          <div class="swiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac velit posuere venenatis.</p><strong>Selçuk Aker 0</strong>
              </div>
              <div class="swiper-slide">
                <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac velit posuere venenatis.</p><strong>Selçuk Aker 1</strong>
              </div>
              <div class="swiper-slide">
                <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac velit posuere venenatis.</p><strong>Selçuk Aker 2</strong>
              </div>
              <div class="swiper-slide">
                <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac velit posuere venenatis.</p><strong>Selçuk Aker 3</strong>
              </div>
              <div class="swiper-slide">
                <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac velit posuere venenatis.</p><strong>Selçuk Aker 4</strong>
              </div>
              <div class="swiper-slide">
                <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac velit posuere venenatis.</p><strong>Selçuk Aker 5</strong>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section>
    <section class="opening-hours-v6 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
      <div class="default-title-v6 text-center"><strong class="sub-title text-capitalize">opening hourse</strong>
        <h3 class="title text-capitalize">open 7 days a week</h3>
      </div>
      <div class="__info">
        <div class="__container"><img class="img-fluid mb-3" src="{{ asset('public/assets/theme6/img/icon/time-clock.svg') }}"/>
          <div class="__divider"></div><strong class="__time-title">OPEN NOW</strong>
          <div class="__divider"></div>
          <div class="__time"><strong>Monday - Friday</strong>
            <div class="__time-box">
              <div class="__left-time"><span>09:00</span><span>AM</span></div>
              <div class="__time-divier"></div>
              <div class="__right-time"><span>11:00</span><span>PM</span></div>
            </div>
          </div>
          <div class="__time"><strong>Sunday</strong>
            <div class="__time-box">
              <div class="__left-time"><span>12:00</span><span>AM</span></div>
              <div class="__time-divier"></div>
              <div class="__right-time"><span>11:30</span><span>PM</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>