@php
$openclose = openclosetime();

$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');
$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
$template_setting = session('template_settings');


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
                {{-- <span>09:00 - 23:00</span> --}}
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
                                                @endphp
                                                <li>
                                                    <a href="#" class="active">{{ $category->name }}
                                                        ({{ $productcount }})
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
                                            @endphp
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse{{ $key }}">
                                                            <span>{{ $value->name }}</span>
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                    </h2>

                                                    @foreach ($result['product'] as $values)
                                                        @php
                                                            echo $values->product_id;
                                                        @endphp
                                                        <div id="collapse{{ $key }}"
                                                            class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOne"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="acc-body-inr">
                                                                    <div class="row">
                                                                        <div class="col-md-7">
                                                                            <div class="acc-body-inr-title">
                                                                                <h4>{{ $values->hasOneDescription['name'] }}
                                                                                </h4>
                                                                                <p>{{ strip_tags($values->hasOneDescription['description']) }}
                                                                                </p>
                                                                                <img src="{{ asset('public/admin/product/' . $values->hasOneProduct['image']) }}"
                                                                                    width="80" height="80"
                                                                                    class="mt-2 mb-2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="options-bt-main">
                                                                                @if (count($result['size']) > 0)
                                                                                    @foreach ($result['size'] as $size)
                                                                                        @php
                                                                                            $sizeprice = $size->id_size;
                                                                                            print_r($size->id_size);
                                                                                            $productsize = $values->hasOneProduct['product_id'];
                                                                                            $setsizeprice = getprice($sizeprice, $productsize);
                                                                                        @endphp
                                                                                        <div class="options-bt">
                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="col-md-5">
                                                                                                    <span>{{ $size->size }}</span>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-7">
                                                                                                    @foreach ($setsizeprice as $setsizeprices)
                                                                                                        <a onclick="showId({{ $values->product_id }},{{ $sizeprice }});"
                                                                                                            class="btn options-btn">

                                                                                                            <span
                                                                                                                class="sizeprice hide-carttext">£{{ $setsizeprices->price }}<i
                                                                                                                    class="fa fa-shopping-basket"></i></span>
                                                                                                            <span
                                                                                                                class="show-carttext sizeprice"
                                                                                                                style="display: none;">Added<i
                                                                                                                    class="fa fa-check"></i></span>
                                                                                                        </a>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @else
                                                                                    <div class="options-bt">
                                                                                        <div class="row">
                                                                                            <div class="col-md-5">
                                                                                                <span>price</span>
                                                                                            </div>
                                                                                            <div class="col-md-7">
                                                                                                <a onclick="showId({{ $values->product_id }},0);"
                                                                                                    class="btn options-btn">
                                                                                                    <span
                                                                                                        class="sizeprice hide-carttext">£{{ $values->hasOneProduct['price'] }}<i
                                                                                                            class="fa fa-shopping-basket"></i></span>
                                                                                                    <span
                                                                                                        class="show-carttext sizeprice"
                                                                                                        style="display: none;">Added<i
                                                                                                            class="fa fa-check"></i></span>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
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
                            <div class="close-shop">
                                <h2>Sorry we are closed now!</h2>
                                {{-- <span>We will be opening back at 16:00 Today</span> --}}
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
                                            {{-- <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong> --}}
                                            <span>We will be opening back at {{ $fromtime[$key] }} Today</span>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="mob-view-main">
                                <div class="mob-view" id="mob-view">
                                    <span class="tg-icon" id="tg-icon"><i
                                            class="fas fa-angle-double-up"></i></span>
                                    <div class="mob-basket">
                                        0 X ITEMS | TOTAL: £0.00</div>
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
                                        <div class="order-type">
                                            <div class="order-type-innr">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                        id="collection">
                                                    <label class="form-check-label" for="collection">
                                                        <h4>Delivery</h4>
                                                        {{-- <span>Starts at 16:50</span> --}}
                                                        @php
                                                            // $openday =$openclose['openday'];
                                                            // $fromtime = $openclose['fromtime'];
                                                            // $totime = $openclose['totime'];
                                                            
                                                            // Collection
                                                            $deliverydays = $openclose['deliverydays'];
                                                            $collectionfrom = $openclose['collectionfrom'];
                                                            $deliveryto = $openclose['deliveryto'];
                                                        @endphp
                                                        @foreach ($deliverydays as $key => $item)
                                                            @foreach ($item as $value)
                                                                @php
                                                                    $t = count($item) - 1;
                                                                    $firstday = $item[0];
                                                                    $lastday = $item[$t];
                                                                    $today = date('l');
                                                                @endphp
                                                                @if ($today == $value)
                                                                    {{-- <span>{{ $collectionfrom[$key] }} - {{ $deliveryto[$key] }}</span> --}}
                                                                    <span>Starts at
                                                                        {{ $collectionfrom[$key] }}</span>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="order-type-innr">
                                                <div class="form-check">

                                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                        id="delivery">
                                                    <label class="form-check-label" for="delivery">
                                                        <h4>Collection</h4>
                                                        {{-- <span>Starts at 16:50</span> --}}
                                                        @php
                                                            // $openday =$openclose['openday'];
                                                            // $fromtime = $openclose['fromtime'];
                                                            // $totime = $openclose['totime'];
                                                            
                                                            // delivery
                                                            $deliverydays = $openclose['deliverydays'];
                                                            $deliveryfrom = $openclose['deliveryfrom'];
                                                            $deliveryto = $openclose['deliveryto'];
                                                        @endphp
                                                        @foreach ($deliverydays as $key => $item)
                                                            @foreach ($item as $value)
                                                                @php
                                                                    $t = count($item) - 1;
                                                                    $firstday = $item[0];
                                                                    $lastday = $item[$t];
                                                                    $today = date('l');
                                                                @endphp
                                                                @if ($today == $value)
                                                                    {{-- <span>{{ $deliveryfrom[$key] }} - {{ $deliveryto[$key] }}</span> --}}
                                                                    <span>Starts at {{ $deliveryfrom[$key] }}</span>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="" class="btn disabled checkbt">Checkout</a>
                            <div class="closed-now">
                                <span class="closing-text ">We are closed now!</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- <button type="button" class="btn btn-primary text1" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
    </button> --}}

    <!-- Modal -->
    <div class="modal fade csmodal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">Order Now</h5>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"><i
                            class="fas fa-times"></i></button>
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
    function showmodal() {

        $('#Modal').modal('show');
        $('#exampleModal').modal('hide');
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
</script>

<script>
    // $(document).ready(function() {
    //     $('.options-btn').on('click', function(e) {
    //         e.preventDefault()
    //         $('.hide-carttext').hide();

    //         $('.show-carttext').show(function() {
    //             setTimeout(function() {
    //                 $('.hide-carttext').hide();
    //             }, 2000);
    //         });
    //         // $('.hide-carttext').show();

    //         // $('.hide-carttext').show();

    //     });

    // });
</script>
<script>
    function showId(product,sizeprice) {

        var sizeid = sizeprice;
      
        var productid = product;
       
        $.ajax({
            type: 'post',
            url: '{{ route('getid') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_id': sizeid,
                'product_id': productid,
            },
            dataType: 'json',
            success: function(result) {
                $('.empty-box').html('');
                $('.empty-box').append(result.html);
                }
        });
    }
</script>
