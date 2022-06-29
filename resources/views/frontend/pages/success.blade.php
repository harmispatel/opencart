@php

    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = layoutID($currentURL,'header_id');
    $theme_id = $current_theme_id['header_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings & Other
    $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
    //End Get Store Settings & Theme Settings & Other

    // Template Settings
    $template_setting = $store_theme_settings['template_settings'];
    // End Template Settings

    // Social Site Settings
    $social_site = $store_theme_settings['social_settings'];
    // End Social Site Settings

    // Store Settings
    $store_setting = $store_theme_settings['store_settings'];
    // End Store Settings

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

    // Get Customer Cart
    if (session()->has('userid'))
    {
        $userid = session()->get('userid');
        $mycart = getuserCart(session()->get('userid'));
    }
    else
    {
        $userid = 0;
        $mycart = session()->get('cart1');
    }
    // End Get Customer Cart

    // Order ID
    $order_id = session()->get('last_order_id');

    // Get Order Status
    $order_status = checkOrderStatus($order_id);

@endphp

<!doctype html>
<html>
<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    {{-- End CSS --}}
</head>

<body>
    <input type="hidden" name="order_status" id="order_status" value="{{ $order_status }}">
    <sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
        href="#slide"><img class="img-fluid"
            src="{{ asset('public/assets/theme5/img/logo/black-logo.svg') }}" /></a>
    <div class="top">
        <ul class="menu">
            <li class="active"><a class="text-uppercase" href="{{ route('home') }}">home</a></li>
            <li><a class="text-uppercase" href="{{ route('member')}}">member</a></li>
            <li><a class="text-uppercase" href="{{ route('menu') }}">menu</a></li>
            <li><a class="text-uppercase" href="{{ route('checkout')}}">check out</a></li>
            <li><a class="text-uppercase" href="{{ route('contact') }}">contact us</a></li>
        </ul>
    </div>
    <div class="center">
        <ul class="authentication-links">
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="far fa-user"></i><span>Login</span></a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#login"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
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


    <!-- Header -->
    @if (!empty($theme_id) || $theme_id != '')
        @include('frontend.theme.theme' . $theme_id . '.header')
    @else
        @include('frontend.theme.theme1.header')
    @endif
    <!-- End Header -->


    <!-- Success Section -->
    <section class="basket-main">
        <div class="container">
            <div class="basket-inr">
                <div id="content" class="ybc-statusorder">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>THANK YOU FOR YOUR ORDER</h1>

                            {{-- Processing --}}
                            @if ($order_status == 2)
                                <p>Please wait while we confirm your order.</p>
                            @endif

                            {{-- Rejected --}}
                            @if ($order_status == 7 || $order_status == 11 || $order_status == 1 || $order_status == 5)
                                <h4>Order Rejected Because : </h4>
                            @endif
                            <hr>

                            {{-- Processing --}}
                            @if ($order_status == 2)
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <img src="{{ get_css_url().'public/admin/gif/gif3.gif' }}" alt="">
                                    </div>
                                </div>
                            @endif

                            {{-- Accepted --}}
                            @if($order_status == 15)
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3 class="text-success">
                                            <i class="fa fa-check-circle"></i> ORDER ACCEPTED.
                                        </h3>
                                        <p>We have received your order, and start preparing your order.</p>
                                        <p>For more information about your order you can call us on {{ $store_setting['config_telephone'] }}</p>
                                        <p>Your Order No. is : {{ $order_id }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Rejected --}}
                            @if($order_status == 7 || $order_status == 11 || $order_status == 1 || $order_status == 5)
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3 class="text-danger">
                                            <i class="fa fa-times-circle"></i> ORDER REJECTED.
                                        </h3>
                                        <p>We are Sorry but your order has been rejected by the restaurant. Your Order will not be delivered!</p>
                                        <p>For more information about your order you can call us on {{ $store_setting['config_telephone'] }}</p>
                                        <p>Your Order No. is : {{ $order_id }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    {{-- <a href="{{ route('home') }}">Return to Home</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- End Success Section -->

    <!-- Footer -->
    @if (!empty($theme_id) || $theme_id != '')
        @include('frontend.theme.theme' . $theme_id . '.footer')
    @else
        @include('frontend.theme.theme1.footer')
    @endif
    <!-- End Footer -->


    {{-- JS --}}
    @include('frontend.include.script')
    {{-- End JS --}}

    {{-- CUSTOM SCRIPT --}}
    <script type="text/javascript">

        var order_status = $('#order_status').val();

        if(order_status == 2)
        {
            setInterval(() => {
                $.ajax({
                    type: "post",
                    url: "{{ url('checkorderstatus') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.success == 1)
                        {
                            // clearInterval();
                            location.reload();
                        }
                    }
                });
            }, 5000);
        }

    </script>
    {{-- END CUSTOM SCRIPT --}}


</body>
</html>
