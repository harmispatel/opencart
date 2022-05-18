@php
$openclose = openclosetime();

$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');
$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
$template_setting = session('template_settings');

if (session()->has('guest_user')) {
    $guestlogin = session()->get('guest_user');
} else {
    $guestlogin = '';
}

$c = session()->get('guest_user_address');

$userlogin = session('username');
$customerid = session('userid');

$userdeliverytype = session('flag_post_code');

$subtotal = '';

if (session()->has('userid')) {
    $userid = session()->get('userid');
    $mycart = getuserCart(session()->get('userid'));
} else {
    $userid = 0;
    $mycart = session()->get('cart1');
    $customer_addr = session()->get('guest_user_address');
}

    // echo '<pre>';
    // print_r(session()->all());
    // exit();

@endphp

<!doctype html>
<html>

<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/pages/menu.css') }}">
    {{-- End CSS --}}
</head>
<style>
    .myfoodbasketpayments_gateway,
    .cod,
    .pp_express {
        text-align: left;
        border-radius: 4px;
        margin: 10px 0px;
        position: relative;
        padding: 20px 10px 15px 35px;
        height: 62px;
        border: solid 1px #d7d7d7;
        display: flex;
        align-items: center;
    }

    .login-details input[type="radio"]:checked+.check_btn:after {
        content: ' ';
        position: absolute;
        z-index: 15;
        left: 12px;
        width: 12px;
        height: 12px;
        background-color: #005cc8;
        top: 26px;
        border-radius: 50%
    }

    span.check_btn:before {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: solid 2px #cacaca;
        position: absolute;
        left: 8px;
        top: 37%;
        content: "";
        border-radius: 100%;
    }

    .checked {
        background: #e46161;
    }

    .checkout-content input[type="radio"],
    .checkout-content input[type="checkbox"] {
        margin: 2px 6px 0 0;
        min-width: 20px;
        vertical-align: -2px;
    }

    .myfoodbasketpayments_gateway input[type="radio"] {
        top: 23px;
    }

    .myfoodbasketpayments_gateway input[type="radio"],
    .cod input[type="radio"],
    .pp_express input[type="radio"] {
        position: absolute;
        left: 0;
        top: 0 !important;
        z-index: 9;
        width: 100%;
        height: 100%;
        margin: 0 !important;
        opacity: 0;
    }

</style>

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
    @if (empty($userlogin) && empty($guestlogin))
    <section class="check-main" id="checkout1">
        <div class="container">
            <div class="check-inr">
                <div class="row" id="Checkout">
                    <div class="col-md-12">
                        <div class="check-progress">
                            <h2>Checkout - step 1/3</h2>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 33%"
                                    aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header accordion-button" id="headingOne" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <span> Log in</span>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="login-main text-center">
                                                    <div class="fb-login ">
                                                        <a href="" class="btn fb-log-bt">
                                                            <i class="fab fa-facebook-square"></i> <span>Login with facebook</span>
                                                        </a>
                                                    </div>
                                                    <div class="my-3">
                                                        <strong>OR</strong>
                                                    </div>
                                                    <form action="{{ route('customerlogin') }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <div class="login-details w-100">
                                                            <div class="login-details-inr fa fa-envelope w-100">
                                                            <input placeholder="Email address" type="text" name="Email" value="{{old('Email')}}" class="w-100 {{ ($errors->has('Email')) ? 'is-invalid' : '' }}">
                                                            @if ($errors->has('Email'))
                                                              <div class="invalid-feedback text-start">
                                                                  {{ $errors->first('Email') }}
                                                              </div>
                                                            @endif
                                                            </div>
                                                            <div class="login-details-inr fa fa-lock w-100">
                                                            <input placeholder="password" type="password" name="Password" value="{{old('Password')}}" class="w-100 {{ ($errors->has('Password')) ? 'is-invalid' : '' }}">
                                                            @if ($errors->has('Password'))
                                                              <div class="invalid-feedback text-start">
                                                                  {{ $errors->first('Password') }}
                                                              </div>
                                                            @endif
                                                            </div>
                                                            <div class="email-btn">
                                                                <button class="btn" id="login">Log in</button>
                                                            </div>
                                                        </div>
                                                      </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header accordion-button" id="headingtwo" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true"
                                    aria-controls="collapsetwo">
                                    <span>Guest checkout</span>
                                </h2>
                                <div id="collapsetwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="login-main text-center">
                                                    <div class="login-details w-100">
                                                        <form enctype="multipart/form-data" id="guestuser">
                                                            @csrf
                                                            <div class="login-details-inr fa fa-sort-up w-100">
                                                                <select name="title" class="w-100" id="gender">
                                                                    <option value="">Title</option>
                                                                    <option value="1">Mr.</option>
                                                                    <option value="2">Mrs.</option>
                                                                    <option value="3">Ms.</option>
                                                                    <option value="4">Miss.</option>
                                                                    <option value="5">Dr.</option>
                                                                    <option value="6">Prof.</option>
                                                                </select>
                                                                <div class="invalid-feedback" id="genderarr" style="display: none; text-align:left;"></div>
                                                            </div>

                                                            <div class="login-details-inr fa fa-user w-100">
                                                                <input placeholder="FirstName" type="text" name="firstname" value="" class="w-100" id="fname">
                                                                <div class="invalid-feedback" id="fnamearr" style="display: none; text-align:left;"></div>
                                                            </div>

                                                            <div class="login-details-inr fa fa-user w-100">
                                                                <input placeholder="lastname" type="text" name="lastname" value="" class="w-100" id="lname">
                                                                <div class="invalid-feedback" id="lnamearr" style="display: none; text-align:left;"></div>
                                                            </div>

                                                            <div class="login-details-inr fa fa-envelope w-100">
                                                                <input placeholder="Email address" type="text" name="email" value="" class="w-100" id="email">
                                                                <div class="invalid-feedback" id="emailarr" style="display: none; text-align:left;"></div>
                                                            </div>

                                                            <div class="login-details-inr fa fa-phone-alt w-100">
                                                                <input placeholder="phone number" type="text" name="phone" value="" class="w-100" id="phone">
                                                                <div class="invalid-feedback" id="phonearr" style="display: none; text-align:left;"></div>
                                                            </div>

                                                            <div class="email-btn">
                                                                <a class="btn" onclick="guestCheckout();">Checkout</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header accordion-button" id="headingthree" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true"
                                    aria-controls="collapsethree">
                                    <span>Create an account</span>
                                </h2>
                                <div id="collapsethree" class="accordion-collapse collapse"
                                    aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="login-main text-center">
                                                    <div class="login-details w-100">
                                                        <form action="{{ route('customerregister') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <div class="login-details-inr fa fa-sort-up w-100">
                                                                <select name="title" class="w-100">
                                                                    <option value="">Title</option>
                                                                    <option value="1">Mr.</option>
                                                                    <option value="2">Mrs.</option>
                                                                    <option value="3">Ms.</option>
                                                                    <option value="4">Miss.</option>
                                                                    <option value="5">Dr.</option>
                                                                    <option value="6">Prof.</option>
                                                                </select>
                                                            </div>
                                                            <div class="login-details-inr fa fa-user w-100 d-flex">
                                                                <div class="w-100 d-inline-block float-start">
                                                                    <input placeholder="firstname" type="text" name="firstname" value="{{ old('firstname') }}" class="w-100 {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}">
                                                                    @if ($errors->has('firstname'))
                                                                        <div class="invalid-feedback text-start">
                                                                            {{ $errors->first('firstname') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="w-100 d-inline-block float-end">
                                                                    <input placeholder="lastname" type="text" name="lastname" value="{{ old('lastname') }}" class="w-100 {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}">
                                                                    @if ($errors->has('lastname'))
                                                                        <div class="invalid-feedback text-start">
                                                                            {{ $errors->first('lastname') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="login-details-inr fa fa-envelope w-100">
                                                                <input placeholder="Email address" type="text" name="email" value="{{ old('email') }}" class="w-100 {{ ($errors->has('email')) ? 'is-invalid' : '' }}">
                                                                @if ($errors->has('email'))
                                                                    <div class="invalid-feedback text-start">
                                                                        {{ $errors->first('email') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="login-details-inr fa fa-phone-alt w-100">
                                                                <input placeholder="phone number" type="text" name="phone" value="{{ old('phone') }}" class="w-100 {{ ($errors->has('email')) ? 'is-invalid' : '' }}">
                                                                @if ($errors->has('phone'))
                                                                    <div class="invalid-feedback text-start">
                                                                        {{ $errors->first('phone') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="login-details-inr fa fa-lock w-100">
                                                                <input placeholder="password" type="password" name="password" value="{{ old('password') }}" class="w-100 {{ ($errors->has('password')) ? 'is-invalid' : '' }}">
                                                                @if ($errors->has('password'))
                                                                    <div class="invalid-feedback text-start">
                                                                        {{ $errors->first('password') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="login-details-inr fa fa-lock w-100">
                                                                <input placeholder="Confirm Password" type="password" name="confirm_password" value="{{ old('confirm_password') }}" class="w-100">
                                                            </div>
                                                            <div class="email-btn">
                                                                <button type="submit" class="btn">Create</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
        <section class="check-main" id="checkout2">
            <div class="container">
                <div class="check-inr">
                    <div class="row justify-content-center" id="demo">
                        <div class="col-md-12">
                            <div class="check-progress">
                                <h2>Checkout - step 2/3</h2>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 66.66%"
                                        aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header accordion-button" id="headingOne" type="button">
                                        <span> Order Type</span>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row justify-content-center">
                                                <div class="col-md-4">
                                                    <div class="login-main text-center">
                                                        <div class="login-details w-100">
                                                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                                                <div>
                                                                    <input class="form-check-input collection_type"
                                                                        type="radio" name="order" id="deliver"
                                                                        {{ $userdeliverytype == 'delivery' ? 'checked' : '' }}
                                                                        value="delivery">
                                                                    <label class="form-check-label" for="deliver">
                                                                        Deliver to my address
                                                                    </label>
                                                                </div>
                                                            @endif

                                                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                                                <div class="mb-1">
                                                                    <input class="form-check-input collection_type"
                                                                        type="radio" name="order" id="collect"
                                                                        {{ $userdeliverytype == 'collection' ? 'checked' : '' }}
                                                                        value="collection">
                                                                    <label class="form-check-label" for="collect">
                                                                        I will collect my order
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" id="delivery_address" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="accordion-item" id="colloctiontime">
                                        <h2 class="accordion-header accordion-button" id="headingtwo" type="button">
                                            <span>Collection Time</span>
                                        </h2>
                                        <div id="collapsetwo" class="accordion-collapse collapse show"
                                            aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="login-main text-center">
                                                            <div class="login-details w-100">
                                                                <div class="login-details-inr fa fa-sort-up w-100">
                                                                    <select class="time_select w-100"
                                                                        name="time_method" id="col_time">
                                                                        <option value="ASAP" selected>ASAP</option>
                                                                        @foreach ($collectionresult as $key => $colecttime)
                                                                            <option id="time_{{ $key }}"
                                                                                value="{{ $colecttime }}">
                                                                                {{ $colecttime }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item" id="dileverytime" style="display: none">
                                        <h2 class="accordion-header accordion-button" id="headingtwo" type="button">
                                            <span>Dilevery Time</span>
                                        </h2>
                                        <div id="collapsetwo" class="accordion-collapse collapse show"
                                            aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="login-main text-center">
                                                            <div class="login-details w-100">
                                                                <div class="login-details-inr fa fa-sort-up w-100">
                                                                    <select class="time_select w-100"
                                                                        name="time_method" id="del_time">
                                                                        <option value="ASAP" selected>ASAP</option>
                                                                        @foreach ($dileveryresult as $key => $deliverytime)
                                                                            <option id="time_{{ $key }}"
                                                                                value="{{ $deliverytime }}">
                                                                                {{ $deliverytime }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item" id="deliveryaddress" style="display: none">
                                        <h2 class="accordion-header accordion-button" id="headingtwo" type="button">
                                            <span>Delivery address</span>
                                        </h2>
                                        <div id="collapsetwo" class="accordion-collapse collapse show"
                                            aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="login-main text-center">
                                                            <div class="login-details w-100">
                                                                @if (empty($guestlogin))
                                                                    <div
                                                                        class="login-details-inr fas fa-address-book w-100">
                                                                        <select name="address" id="address"
                                                                            class="w-100 address"
                                                                            onchange="Getcustomeraddress();">

                                                                        </select>
                                                                        <input type="hidden" id="customerid"
                                                                            name="customerid"
                                                                            value="{{ $customerid }}">
                                                                        <div class="invalid-feedback text-start"
                                                                            style="display: none" id="titleerr"></div>
                                                                    </div>
                                                                @endif
                                                                <div
                                                                    class="login-details-inr fas fa-map-marker-alt w-100">
                                                                    <input placeholder="Address line 1:" type="text"
                                                                        id="address_1" name="address_1"
                                                                        value="{{ isset($customer_addr['address_1']) ? $customer_addr['address_1'] : '' }}"
                                                                        class="w-100">
                                                                    <div class="invalid-feedback" id="address_1err"
                                                                        style="display: none;text-align: left;"></div>
                                                                </div>
                                                                <div
                                                                    class="login-details-inr fas fa-map-marker-alt w-100">
                                                                    <input placeholder="Address line 2:" type="text"
                                                                        id="address_2" name="address_2"
                                                                        value="{{ isset($customer_addr['address_2']) ? $customer_addr['address_2'] : '' }}"
                                                                        class="w-100">
                                                                </div>
                                                                <div
                                                                    class="login-details-inr fas fa-address-card w-100">
                                                                    @if ($delivery_setting['delivery_option'] == 'area')
                                                                        <div class="w-50 d-inline-block float-start">
                                                                            <select name="area" id="area"
                                                                                class="w-100">
                                                                                <option value="">Select Area</option>
                                                                                @php
                                                                                    $old_area = isset($customer_addr['area']) ? $customer_addr['area'] : '';
                                                                                @endphp
                                                                                @foreach ($areas as $area)
                                                                                    <option value="{{ $area }}"
                                                                                        {{ $area == $old_area ? 'selected' : '' }}>
                                                                                        {{ $area }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback" id="areaerr"
                                                                                style="display: none;text-align: left;">
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="w-50 d-inline-block float-start">
                                                                            <input placeholder="city" type="test"
                                                                                id="city" name="city"
                                                                                value="{{ isset($customer_addr['city']) ? $customer_addr['city'] : '' }}"
                                                                                class="w-100">
                                                                            <div class="invalid-feedback" id="cityerr"
                                                                                style="display: none;text-align: left;">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="w-50 d-inline-block float-end">
                                                                        <input placeholder="Postcode" type="text"
                                                                            id="postcode" name="postcode"
                                                                            value="{{ isset($customer_addr['postcode']) ? $customer_addr['postcode'] : '' }}"
                                                                            class="w-100">
                                                                        <div class="invalid-feedback" id="postcodeerr"
                                                                            style="display: none;text-align: left;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="login-details-inr fas fa-phone-alt w-100">
                                                                    <input placeholder="Phone Number" type="number"
                                                                        id="phone_no" name="phone_no"
                                                                        value="{{ isset($customer_addr['phone_no']) ? $customer_addr['phone_no'] : '' }}"
                                                                        class="w-100">
                                                                    <div class="invalid-feedback" id="phone_noerr"
                                                                        style="display: none;text-align: left;"></div>
                                                                </div>
                                                                <div class="login-details-inr fa fa-road w-100">
                                                                    <textarea placeholder="Aditional directions (optional)" cols="30" rows="5" id="additional_directions"
                                                                        name="additional_directions"
                                                                        class="w-100">{{ isset($customer_addr['additional_directions']) ? $customer_addr['additional_directions'] : '' }}</textarea>
                                                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="backbtn d-flex justify-content-between">
                    <button class="btn disabled" disabled><i class="fa fa-angle-left"></i> Back</button>
                    @if ($userdeliverytype == 'delivery')
                        <a class="btn back-bt del_next" onclick="DeliveryAddress();">Next</a>
                    @endif
                    @if ($userdeliverytype == 'collection')
                        <a class="btn back-bt coll_next" id="next">Next</a>
                    @endif
                </div>
            </div>
            </div>
            </div>
            </div>
        </section>
    @endif

    <section class="check-main" id="checkout3" style="display: none">
        <div class="container">
            <div class="check-inr">
                <div class="row justify-content-center" id="demo">
                    <div class="col-md-12">
                        <div class="check-progress">
                            <h2>Checkout - step 3/3</h2>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                    aria-valuenow="100  " aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header accordion-button" id="headingOne" type="button">
                                    <span>My Basket</span>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <div class="login-main text-center">
                                                    <div class="login-details w-100">
                                                        @if (!empty($mycart['size']) || !empty($mycart['withoutSize']))
                                                            <div class="basket-product-detail">
                                                                <form>
                                                                    <table class="table table-responsive">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Image</th>
                                                                                <th>Product Name</th>
                                                                                <th>Quantity</th>
                                                                                <th>Unit Price</th>
                                                                                <th>Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $subtotal = 0;
                                                                                $delivery_charge = 0;
                                                                                $current_date = strtotime(date('Y-m-d'));
                                                                                $start_date = isset($Coupon['date_start']) ? strtotime($Coupon['date_start']) : '';
                                                                                $end_date = isset($Coupon['date_end']) ? strtotime($Coupon['date_end']) : '';

                                                                            @endphp
                                                                            @if (isset($mycart['size']))
                                                                                @foreach ($mycart['size'] as $key => $cart)
                                                                                    @php
                                                                                        $price = (isset($cart['main_price']) ? $cart['main_price'] : 0) * $cart['quantity'];
                                                                                        if (isset($cart['del_price']) && !empty($cart['del_price'])) {
                                                                                            $delivery_charge += $cart['del_price'];
                                                                                        }
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="{{ asset('public/admin/product/' . $cart['image']) }}"
                                                                                                width="80" height="80">
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ $cart['size'] }} -
                                                                                                {{ $cart['name'] }}</b>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <div
                                                                                                class="qu-inr">
                                                                                                <input type="number"
                                                                                                    name="qty"
                                                                                                    id="qty_{{ $key }}"
                                                                                                    value="{{ $cart['quantity'] }}"
                                                                                                    style="max-width: 65px!important;">
                                                                                                <a onclick="updatecart({{ $cart['product_id'] }},{{ $key }},{{ $userid }})"
                                                                                                    class="px-2">
                                                                                                    <img
                                                                                                        src="{{ asset('public/images/update.png') }}">
                                                                                                </a>
                                                                                                <a
                                                                                                    onclick="deletecartproduct({{ $cart['product_id'] }},{{ $key }},{{ $userid }})">
                                                                                                    <i
                                                                                                        class="fas fa-times"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ isset($cart['main_price']) ? $cart['main_price'] : 0 }}</b>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ number_format($price, 2) }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $subtotal += $price;

                                                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                                                            if (!empty($Coupon) || $Coupon != '') {
                                                                                                if ($Coupon['type'] == 'P') {
                                                                                                    $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                                                                }
                                                                                                if ($Coupon['type'] == 'F') {
                                                                                                    $couponcode = $Coupon['discount'];
                                                                                                }
                                                                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                                                            }
                                                                                        } else {
                                                                                            $total = $subtotal + $delivery_charge;
                                                                                        }

                                                                                    @endphp
                                                                                @endforeach
                                                                            @endif

                                                                            @if (isset($mycart['withoutSize']))
                                                                                @foreach ($mycart['withoutSize'] as $key => $cart)
                                                                                    @php
                                                                                        $price = isset($cart['main_price']) ? $cart['main_price'] : 0 * $cart['quantity'];
                                                                                        if (isset($cart['del_price']) && !empty($cart['del_price'])) {
                                                                                            $delivery_charge += $cart['del_price'];
                                                                                        }
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="{{ asset('public/admin/product/' . $cart['image']) }}"
                                                                                                width="80" height="80">
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ $cart['name'] }}</b>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <div
                                                                                                class="qu-inr">
                                                                                                <input type="number"
                                                                                                    name="qty"
                                                                                                    id="qty_{{ $key }}"
                                                                                                    value="{{ $cart['quantity'] }}"
                                                                                                    style="max-width: 65px!important;">
                                                                                                <a onclick="updatecart({{ $key }},0,{{ $userid }})"
                                                                                                    class="px-2">
                                                                                                    <img
                                                                                                        src="{{ asset('public/images/update.png') }}">
                                                                                                </a>
                                                                                                <a
                                                                                                    onclick="deletecartproduct({{ $cart['product_id'] }},0,{{ $userid }})">
                                                                                                    <i
                                                                                                        class="fas fa-times"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ isset($cart['main_price']) ? $cart['main_price'] : 0 }}</b>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ number_format($price, 2) }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $subtotal += $price;

                                                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                                                            if (!empty($Coupon) || $Coupon != '') {
                                                                                                if ($Coupon['type'] == 'P') {
                                                                                                    $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                                                                }
                                                                                                if ($Coupon['type'] == 'F') {
                                                                                                    $couponcode = $Coupon['discount'];
                                                                                                }
                                                                                                $total = $subtotal - $couponcode + $delivery_charge;
                                                                                            } else {
                                                                                            }
                                                                                            $total = $subtotal + $delivery_charge;
                                                                                        }

                                                                                    @endphp
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </form>
                                                            </div>
                                                            <div class="basket-total">
                                                                <table class="table table-responsive">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><b>Sub-Total:</b></td>
                                                                            <td><span><b>£
                                                                                        {{ $subtotal }}</b></span>
                                                                            </td>
                                                                        </tr>
                                                                        @if ((isset($mycart['size']) && !empty($mycart['size'])) || (isset($mycart['withoutSize']) && !empty($mycart['withoutSize'])))
                                                                            @if (!empty($Coupon) || $Coupon != '')
                                                                                @if ($current_date >= $start_date && $current_date < $end_date)
                                                                                    <tr class="coupon_code">
                                                                                        @php
                                                                                            $couponname = isset($Coupon['code']) ? $Coupon['code'] : '';
                                                                                        @endphp
                                                                                        <td><b>Coupon({{ $couponname }}):</b>
                                                                                        </td>
                                                                                        <td><span><b>£
                                                                                                    -{{ isset($couponcode) ? $couponcode : '' }}</b></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        <tr class="voucher">

                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Delivery Charge :</b></td>
                                                                            <td><span><b id="del_charge">£
                                                                                        {{ $delivery_charge }}</b></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="total">
                                                                            <td><b>Total to pay:</b></td>
                                                                            <td><span><b id="total_pay">£
                                                                                        {{ $total }}</b></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="pb-4">
                                                                <h6>Your shopping cart is empty!</h6>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" id="colloctiontime">
                            <h2 class="accordion-header accordion-button" id="headingtwo" type="button">
                                <span>Coupons/Vouchers/Loyalty</span>
                            </h2>
                            <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-5">
                                            <div class="login-main text-center">
                                                <div class="login-details w-100">
                                                    <div id="voucher" class="content">
                                                        <form action="{{ route('voucher') }}" method="post"
                                                            enctype="multipart/form-data" id="voucher_form">
                                                            @csrf
                                                            <div style="display: none;">Enter your gift voucher code
                                                                here:&nbsp;</div>
                                                            <div
                                                                class="login-details-inr fa fa-caret-up w-100 vouchercode d-flex">
                                                                <input type="text" name="voucher" value=""
                                                                    placeholder="Voucher Code" class="w-100">

                                                                <input style="text-transform: uppercase;" type="submit"
                                                                    value="Apply" class="ms-2 btn btn-danger">
                                                                <!-- <input type="hidden" name="voucher" value="voucher"> -->
                                                            </div>
                                                            <p class="couponError"></p>
                                                        </form>
                                                    </div>
                                                    <div id="coupon" class="content">
                                                        <form action="{{ route('coupon') }}" method="post"
                                                            enctype="multipart/form-data" id="coupon_form">
                                                            @csrf
                                                            <div style="display: none;">Enter your coupon here:&nbsp;
                                                            </div>
                                                            <div
                                                                class="login-details-inr fa fa-caret-up w-100 vouchercode d-flex">
                                                                <input type="text" name="coupon" value=""
                                                                    placeholder="Coupon Code" class="w-100">
                                                                <input style="text-transform: uppercase;" type="submit"
                                                                    value="Apply" class="ms-2 btn btn-danger">
                                                            </div>
                                                            <p class="text-danger" id="couponError"></p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" id="dileverytime">
                            <h2 class="accordion-header accordion-button" id="headingtwo" type="button">
                                <span>Payment Options</span>
                            </h2>
                            <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <div class="login-main text-center">
                                                <div class="login-details w-100">
                                                    {{-- <div class="payment-class myfoodbasketpayments_gateway">
                                    <input type="radio" name="payment_method" value="1" id="myfoodbasketpayments_gateway" class="text-bold change_color"><span class="check_btn"></span><img class="w-100" src="{{asset('public/frontend/other/checkout-payment-card.png')}}">
                                </div>
                                <div class="payment-class myfoodbasketpayments_gateway">
                                    <input type="radio" name="payment_method" value="2" id="myfoodbasketpayments_gateway1" class="text-bold change_color"><span class="check_btn"></span><img class="w-100" src="{{asset('public/frontend/other/paypal.png')}}">
                                </div> --}}
                                                    <div class="payment-class myfoodbasketpayments_gateway">
                                                        <input type="radio" name="payment_method" value="3" id="cod"
                                                            class="text-bold change_color pay_btn"><span
                                                            class="check_btn"></span><img
                                                            src="{{ asset('public/frontend/other/cash.png') }}"><label
                                                            class="ybc_cod" for="cod">Cash on Delivery </label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="backbtn d-flex justify-content-between">
                            <button class="btn" onclick="$('#checkout3').hide(); $('#checkout2').show();"><i
                                    class="fa fa-angle-left"></i> Back</button>
                                    <input type="hidden" name="subtotal" id="subtotal"
                                    value="{{ isset($subtotal) ? $subtotal : '' }}">
                                    <input type="hidden" name="delivery_charge" id="delivery_charge"
                                    value="{{ isset($delivery_charge) ? $delivery_charge : '' }}">
                                    <input type="hidden" name="couponcode" id="couponcode"
                                    value="{{ isset($couponcode) ? $couponcode : '' }}">
                                    <input type="hidden" name="couponname" id="couponname"
                                    value="{{ isset($couponname) ? $couponname : '' }}">
                                    <input type="button" value="Pay £ {{ isset($total) ? $total : '' }}"
                                    id="button-payment-method" class="btn back-bt" disabled>
                                    <input type="hidden" name="total" id="total" value="{{ isset($total) ? $total : '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>



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

<script type="text/javascript">
    $('document').ready(function() {
        var d_type = $('input[name="order"]:checked').val();

        if (d_type == 'delivery') {
            $('#colloctiontime').hide();
            $('#dileverytime').show();
            $('#deliveryaddress').show();
        }

        if (d_type == 'collection') {
            $('#colloctiontime').show();
            $('#dileverytime').hide();
            $('#deliveryaddress').hide();
        }

    });

    // Guest Checkout
    function guestCheckout() {
        var form_data = new FormData(document.getElementById('guestuser'));

        $.ajax({
            type: "POST",
            url: "{{ url('registerguestuser') }}",
            data: form_data,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            },
            error: function(message) {
                var gender = message.responseJSON.errors.title;
                var firstname = message.responseJSON.errors.firstname;
                var lastname = message.responseJSON.errors.lastname;
                var email = message.responseJSON.errors.email;
                var phone = message.responseJSON.errors.phone;


                // Title
                if (gender) {
                    $('#genderarr').text('').show();
                    $('#gender').attr('class', 'form-control is-invalid');
                    $('#genderarr').text(gender);
                } else {
                    $('#genderarr').text('').hide();
                    $('#gender').attr('class', 'form-control');
                }

                // FirstName
                if (firstname) {
                    $('#fnamearr').text('').show();
                    $('#fname').attr('class', 'form-control is-invalid');
                    $('#fnamearr').text(firstname);
                } else {
                    $('#fnamearr').text('').hide();
                    $('#fname').attr('class', 'form-control');
                }

                // LastName
                if (lastname) {
                    $('#lnamearr').text('').show();
                    $('#lname').attr('class', 'form-control is-invalid');
                    $('#lnamearr').text(lastname);
                } else {
                    $('#lnamearr').text('').hide();
                    $('#lname').attr('class', 'form-control');
                }

                // Email
                if (email) {
                    $('#emailarr').text('').show();
                    $('#email').attr('class', 'form-control is-invalid');
                    $('#emailarr').text(email);
                } else {
                    $('#emailarr').text('').hide();
                    $('#email').attr('class', 'form-control');
                }

                // Phone No
                if (phone) {
                    $('#phonearr').text('').show();
                    $('#phone').attr('class', 'form-control is-invalid');
                    $('#phonearr').text(phone);
                } else {
                    $('#phonearr').text('').hide();
                    $('#phone').attr('class', 'form-control');
                }

            }
        });

    }
    // End Guest Checkout

    // Delivery Address
    function DeliveryAddress() {
        var form_data = new FormData(document.getElementById('delivery_address'));

        var time_select_del = $('#del_time').val();
        var time_select_col = $('#col_time').val();

        $.ajax({
            type: "POST",
            url: "{{ url('customerdeliveryaddress') }}",
            data: form_data,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.success == 1) {
                    $('#checkout2').hide();
                    $('#checkout3').show();
                }

                if (response.errors == 1) {
                    $('#postcodeerr').text('').show();
                    // $('#postcode').attr('class','form-control is-invalid');
                    $('#postcodeerr').text(response.errors_message);
                }
            },
            error: function(message) {
                if (typeof(message.responseJSON) != "undefined" && message.responseJSON !== null) {
                    var address_1 = message.responseJSON.errors.address_1;
                    var city = message.responseJSON.errors.city;
                    var postcode = message.responseJSON.errors.postcode;
                    var phone_no = message.responseJSON.errors.phone_no;
                    var area = message.responseJSON.errors.area;
                }

                // Address 1
                if (address_1) {
                    $('#address_1err').text('').show();
                    // $('#address_1').attr('class','form-control is-invalid');
                    $('#address_1err').text(address_1);
                } else {
                    $('#address_1err').text('').hide();
                    $('#address_1').attr('class', 'form-control');
                }

                // City
                if (city) {
                    $('#cityerr').text('').show();
                    // $('#city').attr('class','form-control is-invalid');
                    $('#cityerr').text(city);
                } else {
                    $('#cityerr').text('').hide();
                    $('#city').attr('class', 'form-control');
                }

                // Postcode
                if (postcode) {
                    $('#postcodeerr').text('').show();
                    // $('#postcode').attr('class','form-control is-invalid');
                    $('#postcodeerr').text(postcode);
                } else {
                    $('#postcodeerr').text('').hide();
                    $('#postcode').attr('class', 'form-control');
                }

                // Phone
                if (phone_no) {
                    $('#phone_noerr').text('').show();
                    // $('#phone_no').attr('class','form-control is-invalid');
                    $('#phone_noerr').text(phone_no);
                } else {
                    $('#phone_noerr').text('').hide();
                    $('#phone_no').attr('class', 'form-control');
                }

                // Area
                if (area) {
                    $('#areaerr').text('').show();
                    // $('#area').attr('class','form-control is-invalid');
                    $('#areaerr').text(area);
                } else {
                    $('#areaerr').text('').hide();
                    $('#area').attr('class', 'form-control');
                }

            }
        });

    }
    // End Delivery Address

    // Change Delivery Type
    $('.collection_type').click(function() {
        var d_type = $('input[name="order"]:checked').val();

        $.ajax({
            type: "post",
            url: "{{ url('setDeliveyType') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'd_type': d_type,
            },
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    $('#del_charge').text('');
                    $('#del_charge').text(response.delivery_charge);
                    $('#total_pay').text('');
                    $('#total_pay').text(response.total_pay);

                    location.reload();
                }
            }
        });

    });
    // End Change Delivery


    $('#login').click(function(e) {
        e.preventDefault();
        $('#demo').show();
        $('#Checkout').hide();
        //  alert('hello');
    });

    $('.pay_btn').on('click', function() {
        var method_type = $('input[name="payment_method"]:checked').val();

        if (method_type == 3) {
            $('#button-payment-method').val('');
            $('#button-payment-method').val('CONFIRM');
        }

        $('#button-payment-method').removeAttr('disabled');
    });

    $('#deliver').on("click", function() {
        $('#colloctiontime').hide();
        $('#dileverytime').show();
        $('#deliveryaddress').show();
    });
    $('#collect').on("click", function() {
        $('#colloctiontime').show();
        $('#dileverytime').hide();
        $('#deliveryaddress').hide();
    });

    var deliver = $('#deliver').val();
    if (deliver == 'on') {
        $('#colloctiontime').hide();
        $('#dileverytime').show();
        $('#deliveryaddress').show();
    } else {
        $('#colloctiontime').show();
        $('#dileverytime').hide();
        $('#deliveryaddress').hide();
    }

    $('#next').on("click", function() {
        $('#checkout2').hide();
        $('#checkout3').show();
    });


    // Checkout
    $('#button-payment-method').on('click', function() {
        var method_type = $('input[name="payment_method"]:checked').val();
        var total = $('#total').val();
        var subtotal = $('#subtotal').val();
        var delivery_charge = $('#delivery_charge').val();
        var couponcode = $('#couponcode').val();
        var couponname = $('#couponname').val();

        $.ajax({
            type: "post",
            url: "{{ url('confirmorder') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'p_method': method_type,
                'total': total,
                'subtotal': subtotal,
                'delivery_charge': delivery_charge,
                'couponcode': couponcode,
                'couponname': couponname,
            },
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    alert('success');
                    var new_url = response.success_url;
                    window.location = new_url;
                }
            }
        });

    });
    // End Checkout


    // Get address
    var customerid = $(' #customerid ').val();
    // alert(customerid)
    $.ajax({
        type: "get",
        url: "{{ url('getaddress') }}/" + customerid,
        dataType: "json",
        success: function(response) {
            $('.address').html(response);
        }
    });



    // Get Payment Address By Customer Address ID
    function Getcustomeraddress() {
        var payment_address_id = $('#address').val();
        $.ajax({
            type: "GET",
            url: "{{ url('getcustomeraddress') }}/" + payment_address_id,
            dataType: "json",
            success: function(response) {
                $('#address_1').val(response.address_1);
                $('#address_2').val(response.address_2);
                $('#postcode').val(response.postcode);
                $('#city').val(response.city);
                $('#phone_no').val(response.phone);
            }
        });
    }
    // End Get Payment Address By Customer ID

    function updatecart(product, sizeprice, uid) {
        var sizeid = sizeprice;
        var productid = product;
        var userid = uid;

        if(sizeid == 0)
        {
            var loop_id = $('#qty_without_'+product).val();
        }
        else
        {
            var loop_id = $('#qty_size_'+sizeid).val();
        }


        $.ajax({
            type: 'post',
            url: '{{ url("getid") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_id': sizeid,
                'product_id': productid,
                'loop_id': loop_id,
                'user_id': userid,
            },
            dataType: 'json',
            success: function(result) {
                location.reload();
            }
        });
    }

    function deletecartproduct(prod_id, size_id, uid) {
        var sizeid = size_id;
        var productid = prod_id;
        var userid = uid;

        $.ajax({
            type: 'post',
            url: '{{ url('deletecartproduct') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_id': sizeid,
                'product_id': productid,
                'user_id': userid,
            },
            dataType: 'json',
            success: function(result) {
                location.reload();
            }
        });
    }

    $('#voucher_form').submit(function(e) {
        e.preventDefault();
        var voucher = $("input[name='voucher']").val();

        $.ajax({
            type: 'post',
            url: '{{ url('voucher') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'voucher': voucher,
            },
            dataType: 'json',
            success: function(result) {
                $('.voucher').html();
                $('.total').html();
                $('.couponError').html();
                $('#button-payment-method').val();
                $('#button-payment-method').val(result.pay);
                $('.total').html(result.total);
                $('.voucher').html(result.voucher);
                $('.couponError').html(result.success_message);

            }
        });
    });

    $('#coupon_form').submit(function(e) {
        e.preventDefault();
        var coupon = $("input[name='coupon']").val();

        $.ajax({
            type: 'post',
            url: '{{ url('getcoupon') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'coupon': coupon,
            },
            dataType: 'json',
            success: function(result) {
                // $('.coupon_code').html();
                // $('.coupon_code').append(result.coupon_code);
                $('#couponError').text(result.json);
            }
        });
    });
</script>

</html>
