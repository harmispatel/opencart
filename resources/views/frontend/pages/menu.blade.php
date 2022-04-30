@php
$openclose = openclosetime();

$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');
$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
$template_setting = session('template_settings');

$user_delivery_type = session()->has('user_delivery_type') ? session('user_delivery_type') : '';

@endphp

<!doctype html>
<html>

<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/pages/menu.css') }}">
    {{-- End CSS --}}
</head>

<body>


    <!-- Modal -->
    <div class="modal fade" id="pricemodel" tabindex="-1" aria-labelledby="pricemodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-25">
            <div class="modal-content">
                <div class="modal-body p-5 text-danger">
                    Sorry we are close now!
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Model --}}

    {{-- User Delivery --}}
    <input type="hidden" name="user_delivery_val" id="user_delivery_val" value="{{ $user_delivery_type }}">
    {{-- End User Delivery --}}

    @php
        if (session()->has('theme_id')) {
            $theme_id = session()->get('theme_id');
        } else {
            $theme_id = 1;
        }

        $social = session('social_site');
        $social_site = isset($social) ? $social : '#';
    @endphp

    @if (!empty($theme_id) || $theme_id != '')
        {{-- Header --}}
        @include('frontend.theme.theme' . $theme_id . '.header')
        {{-- End Header --}}
    @else
        {{-- Header --}}
        @include('frontend.theme.theme1.header')
        {{-- End Header --}}
    @endif


    <sidebar class="mobile-menu">
        <a class="close far fa-times-circle" href="#"></a>
        <a class="logo" href="#slide">
            <img class="img-fluid" src="{{ asset('public/assets/theme2/img/logo/logo.svg') }}" />
        </a>
        <div class="top">
            <ul class="menu">
                <li class="active">
                    <a class="text-uppercase" href="{{ route('home') }}">home</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('home') }}">member</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">check out</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">contact us</a>
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
                <strong class="text-uppercase">Working Time:</strong>
                @php
                    $openday = $openclose['openday'];
                    $fromtime = $openclose['fromtime'];
                    $totime = $openclose['totime'];
                @endphp
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
                        @php
                            $t = count($item) - 1;
                            $firstday = $item[0];
                            $lastday = $item[$t];
                            $today = date('l');
                        @endphp
                        @if ($today == $value)
                            <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <ul class="social-links">
                <li>
                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}"
                        target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}"
                        target="_blank"></a>
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

    <section class="main-innr">
        <div class="container">
            <div class="main-inner-p">
                <div class="row">
                    <div class="col-md-7 col-lg-8">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="cate-part wow animate__fadeInUp cate-list-part" data-wow-duration="1s">
                                    <div class="category-title">
                                        <h2>Categories</h2>
                                    </div>
                                    <div>
                                        <ul class="box-category">
                                            @foreach ($data['category'] as $category)
                                                @php
                                                    $demo = $category->category_id;
                                                    $productcount = getproductcount($demo);

                                                    $catname = strtolower($category->name)
                                                @endphp
                                                <li>
                                                    <a href="#{{ str_replace(' ', '', $catname) }}" class="active">{{ $category->name }} ({{ $productcount }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="cate-part wow animate__fadeInUp cate-part-select-box"
                                    data-wow-duration="1s">
                                    <select class="form-control">
                                        <option>Show All Categories</option>
                                        @foreach ($data['category'] as $category)
                                            <option>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="product-list wow animate__fadeInUp" data-wow-duration="1s">
                                    <div class="product-list-innr">
                                        @foreach ($data['category'] as $key => $value)
                                            @php
                                                $cat_id = $value->category_id;
                                                $front_store_id = session('front_store_id');
                                                $result = getproduct($front_store_id, $cat_id);

                                                $catvalue = strtolower($value->name);
                                            @endphp
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" id="{{ str_replace(' ','',$catvalue) }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                                                            <span>{{ $value->name }}</span>
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                    </h2>
                                                    @foreach ($result['product'] as $values)
                                                        <div id="collapse{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="acc-body-inr">
                                                                    <div class="row">
                                                                        <div class="col-md-7">
                                                                            <div class="acc-body-inr-title">
                                                                                <h4>
                                                                                    {{ $values->hasOneDescription['name'] }}
                                                                                </h4>
                                                                                @php
                                                                                    $prodesc = html_entity_decode($values->hasOneDescription['description']);
                                                                                @endphp
                                                                                <p>
                                                                                    {{ strip_tags($prodesc) }}
                                                                                </p>
                                                                                <img src="{{ asset('public/admin/product/' . $values->hasOneProduct['image']) }}"
                                                                                    width="80" height="80"
                                                                                    class="mt-2 mb-2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="options-bt-main">
                                                                                @foreach ($result['size'] as $size)
                                                                                    @php
                                                                                        $sizeprice = $size->id_size;
                                                                                        $productsize = $values->hasOneProduct['product_id'];
                                                                                        $setsizeprice = getprice($sizeprice, $productsize);
                                                                                    @endphp

                                                                                    <div class="options-bt">
                                                                                        <div class="row">
                                                                                            <div class="col-md-5">
                                                                                                <span>{{ $size->size }}</span>
                                                                                            </div>
                                                                                            <div class="col-md-7">
                                                                                            @foreach ($openday as $key => $item)
                                                                                                    @foreach ($item as $value)
                                                                                                        @php

                                                                                                            $firsttime = strtotime($fromtime[$key]);
                                                                                                            $lasttime = strtotime($totime[$key]);
                                                                                                            $today = time();
                                                                                                            $currentday = date('l');

                                                                                                        @endphp

                                                                                                        @if ($today >= $firsttime && $today <= $lasttime)
                                                                                                            @if ($currentday == $value)
                                                                                                                @foreach ($setsizeprice as $setsizeprices)
                                                                                                                    <a href="" type="button" class="btn options-btn" onclick="showmodalproduct();">£{{ $setsizeprices->price }}<i class="fa fa-shopping-basket"></i></a>
                                                                                                                @endforeach
                                                                                                            @endif
                                                                                                        @else
                                                                                                            @if ($currentday == $value)
                                                                                                                @foreach ($setsizeprice as $setsizeprices)
                                                                                                                    <a href="" type="button" data-bs-toggle="modal" data-bs-target="#pricemodel" class="btn options-btn">£{{ $setsizeprices->price }}<i class="fa fa-shopping-basket"></i></a>
                                                                                                                @endforeach
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                @endforeach


                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-4">
                        <div class="cart-part wow animate__fadeInUp" data-wow-duration="1s">

                            @foreach ($openday as $key => $item)
                                @foreach ($item as $value)
                                    @php

                                        $firsttime = strtotime($fromtime[$key]);
                                        $lasttime = strtotime($totime[$key]);
                                        $today = time();
                                        $currentday = date('l');

                                    @endphp

                                    @if ($today >= $firsttime && $today <= $lasttime)
                                        @if ($currentday == $value)
                                            <div class="alert p-1 text-center" style="background: green;">
                                                <h2 class="p-1 text-white mb-0">We are open now!</h2>
                                            </div>
                                        @endif
                                    @else
                                        @if ($currentday == $value)
                                            <div class="close-shop">
                                                <h2>Sorry we are closed now!</h2>
                                                <span>We will be opening back at {{ $fromtime[$key] }} Today</span>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                            {{-- </div> --}}
                            <div class="mob-view-main">
                                <div class="mob-view" id="mob-view">
                                    <span class="tg-icon" id="tg-icon"><i
                                            class="fas fa-angle-double-up"></i></span>
                                    <div class="mob-basket">0 X ITEMS | TOTAL: £0.00</div>
                                </div>
                                <div class="minicart" id="minicart">
                                    <div class="minibox-title">
                                        <h3>My Basket</h3>
                                        <i class="fa fa-shopping-basket"></i>
                                    </div>
                                    <div class="minibox-content">
                                        <div class="empty-box">
                                            <span>Your shopping cart is empty!</span>
                                        </div>
                                        <div class="minicart-total">
                                            <ul class="minicart-list">
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr">
                                                        <label>Sub-Total</label>
                                                        <span>£0.00</span>
                                                    </div>
                                                </li>
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr">
                                                        <label>Total to pay:</label>
                                                        <span>£0.00</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="order_type_top" class="order-type">
                                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                                <div class="form-check m-auto">
                                                    @if ($delivery_setting['enable_delivery'] == 'collection')
                                                        <input class="form-check-input" type="radio"
                                                            name="delivery_type" id="collection"
                                                            {{ $delivery_setting['enable_delivery'] == 'collection' ? 'checked' : '' }}
                                                            value="collection">
                                                    @else
                                                        <input class="form-check-input" type="radio"
                                                            name="delivery_type" id="collection" value="collection"
                                                            {{ $user_delivery_type == 'collection' ? 'checked' : '' }}>
                                                    @endif
                                                    <label class="form-check-label" for="collection">
                                                        <h6>Collection</h6>
                                                    </label><br>
                                                    @php
                                                        $collectiondays = $openclose['collectiondays'];
                                                        $collectionfrom = $openclose['collectionfrom'];

                                                        $collection_same_bussiness = isset($openclose['collection_same_bussiness']) ? $openclose['collection_same_bussiness'] : '';
                                                    @endphp
                                                    @if ($collection_same_bussiness == 1)
                                                        <span>{{ ($openclose['collection_gaptime']) ? $openclose['collection_gaptime'] : "Select" }} Min</span>
                                                    @else
                                                        @foreach ($collectiondays as $key => $item)
                                                            @foreach ($item as $value)
                                                                @php
                                                                    $t = count($item) - 1;
                                                                    $firstday = $item[0];
                                                                    $lastday = $item[$t];
                                                                    $today = date('l');
                                                                @endphp
                                                                @if ($today == $value)
                                                                    <span>Starts at - <b>{{ $collectionfrom[$key] }}</b></span>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                                <div class="form-check m-auto">
                                                    <input class="form-check-input" type="radio" name="delivery_type"
                                                        id="delivery">
                                                    <label class="form-check-label" for="delivery">
                                                        <h6>Delivery</h6>
                                                    </label><br>
                                                    @php
                                                        $deliverydays = $openclose['deliverydays'];
                                                        $deliveryfrom = $openclose['deliveryfrom'];

                                                        $delivery_same_bussiness = isset( $openclose['delivery_same_bussiness']) ?  $openclose['delivery_same_bussiness'] : '' ;
                                                    @endphp
                                                    @if ($delivery_same_bussiness == 1)
                                                        <span>{{ ($openclose['delivery_gaptime']) ? $openclose['delivery_gaptime'] : "Select" }} Min</b></span>
                                                    @else
                                                        @foreach ($deliverydays as $key => $item)
                                                            @foreach ($item as $value)
                                                                @php
                                                                    $t = count($item) - 1;
                                                                    $firstday = $item[0];
                                                                    $lastday = $item[$t];
                                                                    $today = date('l');
                                                                @endphp
                                                                @if ($today == $value)
                                                                    <span>Starts at - <b>{{ $deliveryfrom[$key] }}</b></span>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach ($openday as $key => $item)
                                @foreach ($item as $value)
                                    @php

                                        $firsttime = strtotime($fromtime[$key]);
                                        $lasttime = strtotime($totime[$key]);
                                        $today = time();
                                        $currentday = date('l');

                                    @endphp

                                    @if ($today >= $firsttime && $today <= $lasttime)
                                        @if ($currentday == $value)
                                            <a href="" class="btn checkbt"
                                                style="background-color: green; color:white;">Checkout</a>
                                            <div class="closed-now">
                                                <span class="closing-text" style="color: green !important;">We are
                                                    open now!</span>
                                            </div>
                                        @endif
                                    @else
                                        @if ($currentday == $value)
                                            <a href="" class="btn disabled checkbt">Checkout</a>
                                            <div class="closed-now">
                                                <span class="closing-text">We are closed now!</span>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade csmodal" id="pricemodel" tabindex="-1" aria-labelledby="pricemodelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="pricemodelLabel">Order Now</h5>
                    <p>Minimum delivery is £15.00</p>
                    <button class="btn csmodal-btn" onclick="showmodal();">Deliver my order</button>
                    <button class="btn csmodal-btn" data-bs-dismiss="modal">I will come and collect</button>
                    <button type="button" class="btn csmodal-btn-close" data-bs-dismiss="modal">Cancel and go
                        back</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade csmodal" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <h5 class="modal-title" id="ModalLabel">Please Enter Your Post Code</h5>
                        <div class="show_min">To start placing delivery order, please enter your full postcode
                            here:
                        </div>
                        <div class="controls">
                            <input type="text" name="keyword" placeholder="eg.AA1 1bb" required>
                            {{-- <samp>@error('keyword'){{ "Sorry!!!! We don't do delivery to your area" }}@enderror</samp> --}}
                        </div>
                        <button type="submit" class="btn csmodal-btn">Deliver my order</button><br>
                        <button type="button" class="btn csmodal-btn-close" data-bs-dismiss="modal">Cancel and go
                            back</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




    @if (!empty($theme_id) || $theme_id != '')
        {{-- Footer --}}
        @include('frontend.theme.theme' . $theme_id . '.footer')
        {{-- End Footer --}}
    @else
        {{-- Footer --}}
        @include('frontend.theme.theme1.footer')
        {{-- End Footer --}}
    @endif

    {{-- JS --}}
    @include('frontend.include.script')
    {{-- END JS --}}

</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var status = $('#user_delivery_val').val();

        if (status == '') {
            $('#Modal').modal('show');
        }

    });

    function showmodal() {

        $('#Modal').modal('show');
        $('#pricemodel').modal('hide');
    }

    function showmodalproduct() {
        $('#Modal').modal('show');
    }
</script>

<script type="text/javascript">
    $("#mob-view").click(function() {
        TestsFunction();
        myFunction();
    });

    function TestsFunction() {
        var T = document.getElementById("minicart"),
            displayValue = "";
        if (T.style.display == "")
            displayValue = "block";

        T.style.display = displayValue;
        myFunction();
    }

    function myFunction() {
        if ($("#minicart").is(":visible")) {
            $("#tg-icon").html('<i class="fas fa-angle-double-down"></i>');
        } else {
            $("#tg-icon").html('<i class="fas fa-angle-double-up"></i>');
        }
    }

    $('#collection').on('click', function() {
        var d_type = $(this).val();

        $.ajax({
            type: "POST",
            url: "{{ url('setDeliveyType') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'd_type': d_type,
            },
            dataType: "json",
            success: function(response) {
                location.reload();
            }
        });

    });

    $('#delivery').on('click', function() {
        $('#Modal').modal('show');
    });
</script>
