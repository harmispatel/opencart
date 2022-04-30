<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;700&amp;display=swap" rel="stylesheet" />
@php
$openclose = openclosetime();
$review = storereview();

$temp_set = session('template_settings');
$template_setting = isset($temp_set) ? $temp_set : '';

$store_set = session('store_settings');
$store_setting = isset($store_set) ? $store_set : '';

$social = session('social_site');
$social_site = isset($social) ? $social : '#';

$slider_permission = isset($template_setting['polianna_slider_permission']) ? $template_setting['polianna_slider_permission'] : 0;

$online_order_permission = isset($template_setting['polianna_online_order_permission']) ? $template_setting['polianna_online_order_permission'] : 0;
@endphp

<div class="mobile-menu-shadow"></div>
<sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
        href="#slide"><img class="img-fluid"
            src="{{ asset('public/assets/theme6/img/logo/black-logo.svg') }}" /></a>
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
        <div class="working-time">
            <strong class="text-uppercase">Working Time:</strong>
            {{-- <span>09:00 - 23:00</span> --}}
            @php
            $openday =$openclose['openday'];
            $fromtime = $openclose['fromtime'];
            $totime = $openclose['totime'];
        @endphp
        @foreach ($openday as $key => $item)
            @foreach ($item as $value)
                @php
                    $t = count($item)-1;
                    $firstday = $item[0];
                    $lastday = $item[$t];
                    $today = date('l');
                @endphp
                @if ($today == $value)
                    @if (!empty($value))
                        <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                    @else
                    {{-- <strong class="text-white">Today Close</strong> --}}
                    @endif
                @endif
            @endforeach
        @endforeach
        </div>
        <ul class="social-links">
            <li><a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a></li>
            <li><a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a></li>
            <li><a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a></li>
        </ul>
    </div>
</sidebar>
<section class="home-slide-v6 wow animate__fadeInUp" data-wow-duration="1s">

    <div class="home-slide-v6-swiper">
        @if ($slider_permission == 1)
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"
                    style="background-image: url('{{ $template_setting['polianna_slider_1'] }}')">
                    <div class="container">
                        <div class="slide-logo"><img class="img-fluid"
                                src="{{ asset('public/assets/theme6/img/logo/slider-logo.svg') }}" /></div>
                        <h2 class="__title">{{ $template_setting['polianna_slider_1_title'] }}</h2>
                        <p>
                            {{ $template_setting['polianna_slider_1_description'] }}
                        </p>
                    </div>
                </div>
                <div class="swiper-slide"
                    style="background-image: url('{{ $template_setting['polianna_slider_2'] }}')">
                    <div class="container">
                        <h2 class="__title">{{ $template_setting['polianna_slider_2_title'] }}</h2>
                        <p>
                            {{ $template_setting['polianna_slider_2_description'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="swiper-slide" style="background-image: url('public/assets/theme6/demo-data/photo-gallery/placehold 5.jpg')">
            <div class="container">
                <div class="slide-logo">
                    <img class="img-fluid" src="{{ asset('public/assets/theme6/img/logo/slider-logo.svg') }}" />
                </div>
                <h2 class="__title">Our restaurant offers amazing dishes from around the world!</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aut dolorum eius
                    eligendi est ipsa iste, magnam nesciunt non nostrum odit, omnis quam reprehenderit vitae
                    voluptatem. Culpa mollitia placeat rem.</p>
            </div>
        </div>
        @endif
    </div>

    @if ($online_order_permission == 1)
        <div class="order-online-v6">
            <strong class="title text-uppercase">order online</strong>
            @if ($delivery_setting['enable_delivery'] != 'collection')
                <div class="srch-input">
                    @if($delivery_setting['delivery_option'] == 'area')
                        <select name="search_input2" class="form-control"  id="search_store" style="width: 300px;">
                            <option value="">Select Area</option>
                            @foreach($areas as $area)
                                <option value="{{ $area }}">{{ $area }}</option>
                            @endforeach
                        </select>
                    @else
                        <input id="search_input1" placeholder="AB10 1BW" type="text"/>
                        <img id="loading_icon1" src="{{ asset('public/admin/gif/gif4.gif') }}" style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                    @endif
                </div>
                <div class="enter_postcode">
                    <p>Please enter your postcode to view our menu and place an order</p>
                </div>
            @endif
            <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
            <div class="button_content1" style ="">
                @if ($delivery_setting['enable_delivery'] != 'delivery')
                    <a class="btn btn-red text-uppercase collection_button1">collection</a>
                @endif

                @if ($delivery_setting['enable_delivery'] != 'collection')
                    <a class="btn btn-red text-uppercase delivery_button1">delivery</a>
                @endif
            </div>
        </div>
    @endif
    <div class="__btn-bottom"><i class="fas fa-arrow-down"></i></div>
</section>
<section class="who-are-we-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container">
        <div style="height: 300px; overflow: hidden;" id="shopDescription">
            @if (!empty($template_setting['polianna_store_description']))
                {!! $template_setting['polianna_store_description'] !!}
            @else
                <div class="default-title-v6">
                    <strong class="sub-title color-orange text-uppercase">about us</strong>
                    <h3 class="title text-uppercase">SEE WHO WE ARE AND WHAT WE OFFER!</h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquid consectetur deleniti dolorum est facilis labore maiores molestias odio officiis quam qui quisquam repellendus sapiente sequi suscipit tempora, ut.</p>
                <p>Magnam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>At autem consequatur consequuntur dolor dolorum eligendi error excepturi facere illum, inventore laudantium, <br>libero minima mollitia nihil nobis quis quod tenetur vitae?</p>
            @endif
        </div>
        <a class="btn mt-2 text-uppercase" id="readmore" onclick="ShowMoreDescription()">read more</a>
        <a style="display: none;" class="btn mt-2 text-uppercase" id="readless" onclick="HideMoreDescription()">read less</a>
    </div>
</section>
<section class="reservation-v6 pt-90 pb-90 wow animate__fadeInUp" data-wow-duration="1s">
    <form class="container" method="POST" action="{{ route('reservation') }}">
        {{ csrf_field() }}
        <div class="default-title-v6"><strong class="sub-title color-orange text-uppercase">reservation</strong>
            <h3 class="title text-uppercase">BOOK A TABLE NOW!</h3>
        </div>
        <div class="row">
            <div class="col">
                <input class="form-control" name="fullname" placeholder="Full Name" type="text" required/>
            </div>
            <div class="col">
                <input class="form-control" name="phone" placeholder="Phone Number" type="text" required/>
            </div>
            <div class="col">
                <div class="icon"><i class="fas fa-chevron-down"></i>
                    <select class="form-control select2" name="person" required>
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
            <div class="col">
                <div class="icon">
                    <input class="form-control icon" name="time" placeholder="Date &amp; Time"  type="datetime-local" required/>
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
            @if(isset($photos))
                @foreach ($photos as $photo)
                    <div class="col">
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
                <div class="col">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 1.jpg') }}" data-fancybox="photoGallery"></a>
                        <img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 1.jpg') }}" />
                    </div>
                </div>
                <div class="col">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" data-fancybox="photoGallery"></a>
                        <img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" />
                    </div>
                </div>
                <div class="col">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 3.jpg') }}" data-fancybox="photoGallery"></a>
                        <img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 3.jpg') }}" />
                    </div>
                </div>
                <div class="col">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 4.jpg') }}" data-fancybox="photoGallery"></a>
                        <img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 4.jpg') }}" />
                    </div>
                </div>
                <div class="col">
                    <div class="item">
                        <a class="fas fa-search-plus" href="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 5.jpg') }}" data-fancybox="photoGallery"></a>
                        <img class="img-fluid" src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 5.jpg') }}" />
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="popular-foods-v6 pt-75 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v6"><strong class="sub-title color-orange text-uppercase">Popular Foods</strong>
        <h3 class="title text-uppercase">CHECK OUT OUR MENU AND SELECT SOMETHING FOR EVERYONE</h3>
    </div>
    <div class="container">
        <div class="row list-item">
            @if (count($popular_foods) > 0)
                @foreach ($popular_foods as $food)
                    <div class="col-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class="item">
                                <div class="img">
                                    @if (!empty($food->hasOneProduct['image']) || $food->hasOneProduct['image'] != '')
                                        <img class="img-fluid" src="{{ $food->hasOneProduct['image'] }}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                    @endif
                                </div>
                                <div class="text-content">
                                    <strong
                                        class="text-capitalize">{{ $food->hasOneProduct->hasOneProductDescription['name'] }}</strong>
                                    @php
                                        $desc = html_entity_decode($food->hasOneProduct->hasOneProductDescription['description']);
                                        $description = strip_tags($desc);

                                        if ($description == '') {
                                            echo '<p>-</p>';
                                        } else {
                                            echo '<p>'.substr($description,0,30).'</p>';
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="item">
                        <div class="img">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" />
                        </div>
                        <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="item">
                        <div class="img">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" />
                        </div>
                        <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="item">
                        <div class="img">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" />
                        </div>
                        <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="item">
                        <div class="img">
                            <img class="img-fluid"
                                src="{{ asset('public/assets/theme6/demo-data/photo-gallery/placehold 2.jpg') }}" />
                        </div>
                        <div class="text-content"><strong class="text-capitalize">Alvarado</strong>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<section class="popular-categories-v6 pt-90 pb-75 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="default-title-v6 text-center container"><strong class="sub-title text-uppercase">popular categories</strong>
        <h3 class="title text-capitalize">CHECK OUT OUR MENU AND SELECT SOMETHING FOR EVERYONE</h3>
    </div>
    <div class="container">
        <div class="popular-categories-v6-swiper">
            <div class="__btn-list">
                <a class="text-uppercase active" href="" data-filter="all">all</a>
                @if(count($best_categories) > 0)
                    @foreach ($best_categories as $category)
                    @php
                        $product = $category->category_id;
                    @endphp
                    <a class="text-uppercase" href="" data-filter="{{$product}}">{{ strtolower($category->hasOneCategoryDetails->hasOneCategory['name']) }}</a>
                    @php
                        $allproducts = getallproduct($product);
                        echo $product;
                    @endphp
                    @endforeach
                @endif
            </div>
            <div class="swiper">
                <div class="swiper-wrapper">
                    @if(count($allproducts) > 0)
                        @foreach ($allproducts as $categorydet)
                        @php
                            $catimage = $categorydet->hasOneProduct['image'];
                            $catname = $categorydet->hasOneDescription['name'];
                            $catdesc = $categorydet->hasOneDescription['description'];
                        @endphp
                        <div class="swiper-slide" data-slide-filter="{{$categorydet->category_id}}">
                            <div class="item">
                                <div class="img">
                                    @if (!empty($catimage))
                                        <img class="img-fluid" src="{{ asset('public/admin/product/'.$catimage) }}" />
                                    @else
                                        <img class="img-fluid" src="{{ asset('public/admin/product/no_image.jpg') }}">
                                    @endif
                                </div>
                                <div class="text-content">
                                    <strong class="text-capitalize">{{ html_entity_decode($catname) }}</strong>
                                    <p>@php echo html_entity_decode($catdesc) @endphp</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
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
                    {{-- <div class="swiper-slide">
                        <p>Aliquam auctor, elit id imperdiet sollicitudin, diam dui viverra lorem, in maximus eros
                            mauris in lacus. Phasellus malesuada posuere urna, ut imperdiet quam.Duis finibus mi ac
                            velit posuere venenatis.</p><strong>Selçuk Aker 0</strong>
                    </div> --}}
                    @foreach ($review['reviews'] as $item)
                        <div class="swiper-slide">
                            <p>{{ $item->message }}</p>
                            <strong>{{ isset($item->hasOneCustomer['firstname']) ? $item->hasOneCustomer['firstname'] : '' }} {{ isset($item->hasOneCustomer['lastname']) ? $item->hasOneCustomer['lastname'] : '' }}</strong>
                        </div>
                    @endforeach
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
        <div class="__container"><img class="img-fluid mb-3"
                src="{{ asset('public/assets/theme6/img/icon/time-clock.svg') }}" />
            <div class="__divider"></div><strong class="__time-title">OPEN NOW</strong>
            <div class="__divider"></div>
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


            {{-- <div class="__time"><strong>{{ $openclose['days1'] }} - {{$openclose['days2']}}</strong>
                <div class="__time-box">
                    <div class="__left-time"><span>09:00</span><span>AM</span></div>
                    <div class="__left-time"><span>{{ $openclose['fromtime'] }}</span></div>
                    <div class="__time-divier"></div>
                    <div class="__right-time"><span>11:00</span><span>PM</span></div>
                    <div class="__right-time"><span>{{ $openclose['totime'] }}</span></div>
                </div>
            </div> --}}
            {{-- <div class="__time"><strong>Sunday</strong>
                <div class="__time-box">
                    <div class="__left-time"><span>12:00</span><span>AM</span></div>
                    <div class="__time-divier"></div>
                    <div class="__right-time"><span>11:30</span><span>PM</span></div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
