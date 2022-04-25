<link
    href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&amp;family=Playfair+Display:wght@400;700&amp;display=swap"
    rel="stylesheet" />

    @php
        $review = storereview();
        $openclose = openclosetime();
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
            <li><a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a></li>
            <li><a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a></li>
        </ul>
    </div>
</sidebar>
<section class="home-slide-v5 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                <div class="order-online-v5">
                    <h2 class="__title">"{{ $store_setting['config_name'] }}"</h2>
                    @if ($online_order_permission == 1)
                        <div class="order-online wow animate__fadeInUp" data-wow-duration="1s" style="text-align: center">
                            <strong class="title text-uppercase " >order online</strong>
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
            <div class="col-sm-12 col-md-6">
                @if ($template_setting['polianna_banner_image'])
                    <img class="img-fluid" src="{{ $template_setting['polianna_banner_image'] }}" /></div>
                @else
                    <img class="img-fluid" height="541" width="457" src="{{ asset('public/assets/demo-data/popular-foods/1.jpg')}}" /></div>
                @endif
            <div class="col-sm-12 col-md-6">
                <div style="height: 300px; overflow: hidden;" id="shopDescription">
                    @if (!empty($template_setting['polianna_store_description']))
                        {!! $template_setting['polianna_store_description'] !!}
                    @else
                    <div class="default-title-v5">
                        <strong class="sub-title color-orange text-uppercase">about us</strong>
                      <h3 class="title">The Best restaurant <br> in <br> the city</h3>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid consectetur deleniti dolorum est facilis labore maiores molestias odio officiis quam qui quisquam repellendus sapiente sequi suscipit tempora, ut.</p>
                      <p>Magnam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>At autem consequatur consequuntur dolor dolorum eligendi error excepturi facere illum, inventore laudantium, <br>libero minima mollitia nihil nobis quis quod tenetur vitae?</p>
                    </div>
                    @endif
                </div>
                <a class="btn mt-2 btn-orange text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
                <a style="display: none;" class="btn mt-2 btn-orange text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
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
                    {{-- <div class="swiper-slide">
                        <div class="item">
                            <div class="img"><img class="img-fluid"
                                    src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                            </div>
                            <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                            </div>
                        </div>
                    </div> --}}
                    @if(count($best_categories) > 0)
                    @foreach ($best_categories as $categorydet)
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="img">
                                @if (isset($categorydet->hasOneCategoryDetails['image']))
                                    <img class="img-fluid" src="{{ $categorydet->hasOneCategoryDetails['image'] }}" />
                                @else
                                    <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                @endif
                            </div>
                                <div class="text-content">
                                <strong>{{ $categorydet->hasOneCategoryDetails->hasOneCategory['name'] }}</strong>
                                <p>{{ html_entity_decode($categorydet->hasOneCategoryDetails->hasOneCategory['description']) }}</p>
                                <a href="">Read more</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    {{-- <div class="swiper-slide">
                        <div class="item">
                            <div class="img">
                                <img class="img-fluid" src="{{ asset('public/assets/theme5/demo-data/best-categories/2.jpg') }}" />
                            </div>
                            <div class="text-content">
                                <strong class="text-capitalize">Soft mix Salad</strong>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <a href="">Read more</a>
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
                    </div> --}}
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
                    @if (count($popular_foods) > 0)
                    @foreach ($popular_foods as $food)
                        <div class="swiper-slide">
                            <div class="item">
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
                    @endforeach
                @else
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
                                src="{{ asset('public/assets/theme5/demo-data/best-categories/0.jpg') }}" />
                        </div>
                        <div class="text-content"><strong class="text-capitalize">Fresh Salad</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p><a href="">Read more</a>
                        </div>
                    </div>
                </div>
                @endif
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
        <div class="default-title-v5"><strong class="sub-title text-uppercase color-orange">Recent Web Reviews</strong>
            <h3 class="title">What costumers says about best <br> food in restaurant</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.</p>
        </div>
        <div class="user-comments-v5-swiper position-relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($review['reviews'] as $item)
                        <div class="swiper-slide" style="min-height: 14rem;">
                            <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                            <p>{{ $item->message }}</p>
                            {{-- <span>UX Designer</span> --}}
                        </div>
                    @endforeach
                    {{-- <div class="swiper-slide">
                        <strong>Selçuk Aker 0</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut 0</p>
                        <span>UX Designer</span>
                    </div>
                    <div class="swiper-slide"><strong>Selçuk Aker 23</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            23</p><span>UX Designer</span>
                    </div> --}}
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
                        @if(isset($photos))
                            @foreach ($photos as $photo)
                                <div class="swiper-slide">
                                    <div class="item">
                                        @if (file_exists($photo->image))
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
                            <div class="swiper-slide">
                                <div class="item">
                                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}" data-fancybox="photoGallery"></a>
                                    <img class="img-fluid" src="{{ asset('public/assets/theme5/demo-data/photo-gallery/0.jpg') }}" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item">
                                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}" data-fancybox="photoGallery"></a>
                                    <img class="img-fluid" src="{{ asset('public/assets/theme5/demo-data/photo-gallery/1.jpg') }}" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item">
                                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}" data-fancybox="photoGallery"></a>
                                    <img class="img-fluid" src="{{ asset('public/assets/theme5/demo-data/photo-gallery/2.jpg') }}" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item">
                                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}" data-fancybox="photoGallery"></a>
                                    <img class="img-fluid" src="{{ asset('public/assets/theme5/demo-data/photo-gallery/3.jpg') }}" />
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="item">
                                    <a class="fas fa-search-plus" href="{{ asset('public/assets/theme5/demo-data/photo-gallery/4.jpg') }}" data-fancybox="photoGallery"></a>
                                    <img class="img-fluid" src="{{ asset('public/assets/theme5/demo-data/photo-gallery/4.jpg') }}" />
                                </div>
                            </div>
                        @endif
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
    <form class="container" method="POST" action="{{ route('reservation') }}">
        {{ csrf_field() }}
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-5 wow animate__fadeInLeft" data-wow-duration="1s">
                <div class="default-title-v5">
                    <strong class="sub-title color-orange text-capitalize">reservation</strong>
                    <h3 class="title text-capitalize">What costumers says about best food in restaurant</h3>
                </div>
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
                    <div class="col-12 col-sm-6 mb-4">
                        <input class="form-control" name="time" id="time" type="time" required/>
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
            {{-- <div class="__time"><strong>{{ $openclose['days1'] }}-<br>{{ $openclose['days2'] }}</strong>
                <div class="__time-box">
                    <div class="__left-time"><span>{{ $openclose['fromtime'] }}</span></div>
                    <div class="__time-divier"></div>
                    <div class="__right-time"><span>{{ $openclose['totime'] }}</span></div>
                </div>
            </div> --}}

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
                            <strong>{{ $firstday }}</strong>
                        @else
                            <strong>{{ $firstday }} - {{ $lastday }}</strong>
                        @endif
                        <div class="__time-box">
                            <div class="__left-time"><span>{{ $fromtime[$key] }}</span></div>
                            <div class="__time-divier"></div>
                            <div class="__right-time"><span>{{ $totime[$key] }}</span></div>
                        </div>
                    </div>
                <br>
            @endforeach
            {{-- <div class="__time"><strong>{{ $openclose['days1'] }}-<br>{{ $openclose['days2'] }}</strong>
                <div class="__time-box">
                    <div class="__left-time"><span>9</span><span>A<br>M</span></div>
                    <div class="__left-time"><span>{{ $openclose['fromtime'] }}</span></div>
                    <div class="__time-divier"></div>
                    <div class="__right-time"><span>11</span><span>P<br>M</span></div>
                    <div class="__right-time"><span>{{ $openclose['totime'] }}</span></div>
                </div>
            </div> --}}
            {{-- <div class="__time"><span>SUNDAY 9:30 AM to 11AM</span></div><img class="img-fluid mt-3" src="{{ asset('public/assets/theme5/img/icon/time-bottom-flower.svg') }}" /> --}}
        </div>
    </div>
</section>
