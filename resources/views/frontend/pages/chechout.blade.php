{{--
    THIS IS CHECKOUT PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    checkout.blade.php
    It's used for checkout customer order.
    ----------------------------------------------------------------------------------------------
--}}


@php

    // echo '<pre>';
    // print_r(session()->all());
    // exit();

    // Get Current URL
    $currentURL = URL::to("/");


    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);


    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];


    // Social Site Settings
    $social_site = isset($store_data['social_settings']) ? $store_data['social_settings'] : '';


    // Store Settings
    $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

    // Get Currency Details
    $currency = getCurrencySymbol($store_setting['config_currency']);
    session()->put('currency', $currency);

    // Get Open-Close Time
    $openclose = openclosetime();

    // Collection Times Array
    $collection_array = isset($openclose['collection_gap_time_array']) ? $openclose['collection_gap_time_array'] : '';

    // Delivery Times Array
    $delivery_array = isset($openclose['delivery_gap_time_array']) ? $openclose['delivery_gap_time_array'] : '';

    // Store Open / Close
    $store_open_close = isset($openclose['store_open_close']) ? $openclose['store_open_close'] : 'close';

    // Get Working Time
    if($store_open_close == 'open')
    {
        $working_from_time = isset($openclose['from_time']) ? date('H:i',$openclose['from_time']) : '0:00';
        $working_to_time = isset($openclose['to_time']) ? date('H:i',$openclose['to_time']) : '0:00';
        $working_time = $working_from_time.' - '.$working_to_time;
    }
    else
    {
        $working_time = '0:00 - 0:00';
    }

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

    // Get Customer Cart
    if (session()->has('userid'))
    {
        $userid = session()->get('userid');

        // Database cart
        // $mycart = getuserCart(session()->get('userid'));

        $mycart = session()->get('cart1'); // Session
    }
    else
    {
        $userid = 0;
        $mycart = session()->get('cart1');
        $customer_addr = session()->get('guest_user_address');
    }
    // End Get Customer Cart

    // Get Guest User Detail
    if (session()->has('guest_user'))
    {
        $guestlogin = session()->get('guest_user');
    }
    else
    {
        $guestlogin = '';
    }
    // End Get Guest User Detail



    // Customer Details
    $userlogin = session('username');
    $customerid = session('userid');
    //End Customer Details

    $subtotal = 0;
    $total = 0;

    $session_total = session()->get('total');

    // cash on delevery setting
    $servicecharge = paymentdetails();

    $stripe_charge = $servicecharge["stripe"]["stripe_charge_payment"] ? $servicecharge["stripe"]["stripe_charge_payment"] : '0.00';
    $paypal_charge = $servicecharge["paypal"]["pp_charge_payment"] ? $servicecharge["paypal"]["pp_charge_payment"] : '0.00';
    $cod_charge = $servicecharge["cod"]["cod_charge_payment"] ? $servicecharge["cod"]["cod_charge_payment"] : '0.00';


    // Get time Method
    if(session()->has('time_method'))
    {
        $time_method = session()->get('time_method');
    }
    else
    {
        $time_method = '';
    }

    if(session()->has('subtotal'))
    {
        $get_sub_total = session()->get('subtotal');
    }
    else
    {
        $get_sub_total = 0;
    }

    if(isset($cart_rule) && !empty($cart_rule))
    {
        $cart_rule_total = number_format($cart_rule['min_total'],0);
    }
    else
    {
        $cart_rule_total = '';
    }


    if(session()->has('free_item'))
    {
        $session_free_item = session()->get('free_item');
    }
    else
    {
        $session_free_item = '';
    }


@endphp

<!doctype html>
<html>
<head>
    {{-- CSS  --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    {{-- CSS --}}

    {{-- Custom CSS --}}
    <style>
        .myfoodbasketpayments_gateway,.cod,.pp_express
        {
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

        .login-details input[type="radio"]:checked+.check_btn:after
        {
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

        span.check_btn:before
        {
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

        .checked
        {
            background: #e46161;
        }

        .checkout-content input[type="radio"],.checkout-content input[type="checkbox"]
        {
            margin: 2px 6px 0 0;
            min-width: 20px;
            vertical-align: -2px;
        }

        .myfoodbasketpayments_gateway input[type="radio"]
        {
            top: 23px;
        }

        .myfoodbasketpayments_gateway input[type="radio"],.cod input[type="radio"],.pp_express input[type="radio"]
        {
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
    {{-- End Custom CSS --}}

</head>
<body>

    {{-- Header  --}}
    @include('frontend.theme.all_themes.header')

    @if (empty($userlogin) && empty($guestlogin))
        {{-- Checkout Step 1 --}}
        <section class="check-main" id="checkout1">
            <div class="container">
                <div class="check-inr">
                    <div class="row" id="Checkout">
                        <div class="col-md-12">
                            <div class="check-progress">
                                <h2>Checkout - step 1/3</h2>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header accordion-button" id="headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span> Log in</span>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row justify-content-center">
                                                <div class="col-md-4">
                                                    <div class="login-main text-center">
                                                        <form action="{{ route('customerlogin') }}" method="POST">
                                                            {{ csrf_field() }}
                                                            <div class="login-details w-100">
                                                                <div class="login-details-inr fa fa-envelope w-100">
                                                                    <input placeholder="Email address" type="text" name="Email" value="{{ old('Email') }}" class="w-100 {{ ($errors->has('Email')) ? 'is-invalid' : '' }}">
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
                                    <h2 class="accordion-header accordion-button" id="headingtwo" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                                        <span>Guest checkout</span>
                                    </h2>
                                    <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
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
                                    <h2 class="accordion-header accordion-button" id="headingthree" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                                        <span>Create an account</span>
                                    </h2>
                                    <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionExample">
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
        {{-- End Checkout Step 1 --}}
    @else
        {{-- Checkout Step 2 --}}
        <section class="check-main" id="checkout2">
            <div class="container">
                @if(\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ \Session::get('error') }}
                        <a type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                    </div>
                    {{ \Session::forget('error') }}
                @endif
                @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ \Session::get('success') }}
                        <a type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                    </div>
                    {{ \Session::forget('success') }}
                @endif


                <div class="check-inr">
                    <div class="row justify-content-center" id="demo">
                        <div class="col-md-12">
                            <div class="check-progress">
                                <h2>Checkout - step 2/3</h2>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 66.66%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header accordion-button" id="headingOne" type="button">
                                        <span> Order Type</span>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row justify-content-center">
                                                <div class="col-md-4">
                                                    <div class="login-main text-center">
                                                        <div class="login-details w-100">
                                                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                                                <div class="mb-1">
                                                                    <input class="form-check-input collection_type" type="radio" name="order" id="collect" {{ $userdeliverytype == 'collection' ? 'checked' : '' }} value="collection">
                                                                    <label class="form-check-label" for="collect">
                                                                        I will collect my order
                                                                    </label>
                                                                </div>
                                                            @endif

                                                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                                                <div>
                                                                    <input class="form-check-input collection_type" type="radio" name="order" id="deliver" {{ $userdeliverytype == 'delivery' ? 'checked' : '' }} value="delivery">
                                                                    <label class="form-check-label" for="deliver">Deliver to my address</label><br>
                                                                    {{-- @if ($userdeliverytype == 'delivery')
                                                                        @if ($store_open_close == 'open' && $session_total <= $minimum_spend['min_spend'])
                                                                            <span class="text-danger">Minimum delivery is {{ $currency }}{{ $minimum_spend['min_spend'] }}, you must spend {{ $currency }}{{ $minimum_spend['min_spend']-$session_total }} more for the chekout.</span>
                                                                        @endif
                                                                    @endif --}}
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
                                            @if ($userdeliverytype == 'delivery')
                                                <span>Delivery Time</span>
                                            @else
                                                <span>Collection Time</span>
                                            @endif
                                        </h2>
                                        <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="login-main text-center">
                                                            <div class="login-details w-100">
                                                                <div class="login-details-inr fa fa-sort-up w-100">
                                                                    <select class="time_select w-100"
                                                                        name="time_method" id="col_time">
                                                                        @if ($userdeliverytype == 'delivery')
                                                                            @foreach ($delivery_array as $delArray)
                                                                                <option value="{{ $delArray }}" {{ ($time_method == $delArray) ? 'selected' : '' }}>{{ $delArray }}</option>
                                                                            @endforeach
                                                                        @else
                                                                            @foreach ($collection_array as $collArray)
                                                                                <option value="{{ $collArray }}" {{ ($time_method == $collArray) ? 'selected' : '' }}>{{ $collArray }}</option>
                                                                            @endforeach
                                                                        @endif
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
                                        <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="login-main text-center">
                                                            <div class="login-details w-100">
                                                                @if (empty($guestlogin))
                                                                    <div class="login-details-inr fas fa-address-book w-100">
                                                                        <select name="address" id="address" class="w-100 address"
                                                                        onchange="Getcustomeraddress();">
                                                                        </select>
                                                                        <input type="hidden" id="customerid" name="customerid" value="{{ $customerid }}">
                                                                        <div class="invalid-feedback text-start" style="display: none" id="titleerr"></div>
                                                                    </div>
                                                                @endif
                                                                <div class="login-details-inr fas fa-map-marker-alt w-100">
                                                                    <input placeholder="Address line 1:" type="text" id="address_1" name="address_1" value="{{ isset($customer_addr['address_1']) ? $customer_addr['address_1'] : '' }}" class="w-100">
                                                                    <div class="invalid-feedback" id="address_1err" style="display: none;text-align: left;"></div>
                                                                </div>
                                                                <div class="login-details-inr fas fa-map-marker-alt w-100">
                                                                    <input placeholder="Address line 2:" type="text" id="address_2" name="address_2" value="{{ isset($customer_addr['address_2']) ? $customer_addr['address_2'] : '' }}" class="w-100">
                                                                </div>
                                                                <div class="login-details-inr fas fa-address-card w-100">
                                                                    @if ($delivery_setting['delivery_option'] == 'area')
                                                                        <div class="w-50 d-inline-block float-start">
                                                                            <select name="area" id="area" class="w-100">
                                                                                <option value="">Select Area</option>
                                                                                @php
                                                                                    $old_area = isset($customer_addr['area']) ? $customer_addr['area'] : '';
                                                                                @endphp
                                                                                @foreach ($areas as $area)
                                                                                    <option value="{{ $area }}" {{ $area == $old_area ? 'selected' : '' }}>{{ $area }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback" id="areaerr"
                                                                                style="display: none;text-align: left;">
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="w-50 d-inline-block float-start">
                                                                            <input placeholder="city" type="test" id="city" name="city" value="{{ isset($customer_addr['city']) ? $customer_addr['city'] : '' }}" class="w-100">
                                                                            <div class="invalid-feedback" id="cityerr" style="display: none;text-align: left;">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="w-50 d-inline-block float-end">
                                                                        <input placeholder="Postcode" type="text" id="postcode" name="postcode" value="{{ isset($customer_addr['postcode']) ? $customer_addr['postcode'] : '' }}" class="w-100">
                                                                        <div class="invalid-feedback" id="postcodeerr" style="display: none;text-align: left;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="login-details-inr fas fa-phone-alt w-100">
                                                                    <input placeholder="Phone Number" type="number" id="phone_no" name="phone_no" value="{{ isset($customer_addr['phone_no']) ? $customer_addr['phone_no'] : '' }}" class="w-100">
                                                                    <div class="invalid-feedback" id="phone_noerr" style="display: none;text-align: left;"></div>
                                                                </div>
                                                                <div class="login-details-inr fa fa-road w-100">
                                                                    <textarea placeholder="Aditional directions (optional)" cols="30" rows="5" id="additional_directions" name="additional_directions" class="w-100">{{ isset($customer_addr['additional_directions']) ? $customer_addr['additional_directions'] : '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="backbtn d-flex justify-content-between">
                                <button class="btn disabled" disabled><i class="fa fa-angle-left"></i> Back</button>
                                @if ($userdeliverytype == 'delivery')
                                    @if ($store_open_close == 'open')
                                        <a class="btn back-bt del_next" onclick="DeliveryAddress();">Next</a>
                                    @else
                                        <button class="btn back-bt del_next" disabled>Next</button>
                                    @endif
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
        {{-- End Checkout Step 2 --}}
    @endif

    {{-- Checkout Step 3 --}}
    <section class="check-main" id="checkout3" style="display: none">
        <div class="container">
            <div class="check-inr">
                <div class="row justify-content-center" id="demo">
                    <div class="col-md-12">
                        <div class="check-progress">
                            <h2>Checkout - step 3/3</h2>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100  " aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="min_delivery" style="display: none">
                            <span class="min_delivery"></span>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header accordion-button" id="headingOne" type="button">
                                    <span>My Basket</span>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
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
                                                                                $current_date = strtotime(date('Y-m-d'));
                                                                                $start_date = isset($Coupon['date_start']) ? strtotime($Coupon['date_start']) : '';
                                                                                $end_date = isset($Coupon['date_end']) ? strtotime($Coupon['date_end']) : '';

                                                                            @endphp
                                                                            @if (isset($mycart['size']))
                                                                                @foreach ($mycart['size'] as $key => $cart)
                                                                                    @php
                                                                                        // Price
                                                                                        if($userdeliverytype == 'delivery')
                                                                                        {
                                                                                            $price = isset($cart['del_price']) ? $cart['del_price'] : 0;
                                                                                            $qty_price = (isset($cart['del_price']) ? $cart['del_price'] : 0) * $cart['quantity'];
                                                                                        }
                                                                                        elseif($userdeliverytype == 'collection')
                                                                                        {
                                                                                            $price = isset($cart['col_price']) ? $cart['col_price'] : 0;
                                                                                            $qty_price = (isset($cart['col_price']) ? $cart['col_price'] : 0) * $cart['quantity'];
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $price = isset($cart['main_price']) ? $cart['main_price'] : 0;
                                                                                            $qty_price = (isset($cart['main_price']) ? $cart['main_price'] : 0) * $cart['quantity'];
                                                                                        }
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="{{ $cart['image'] }}" width="80" height="80">
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ $cart['size'] }} - {{ $cart['name'] }}</b><br>
                                                                                            @if (isset($cart['topping']) && !empty($cart['topping']))
                                                                                                @foreach ($cart['topping'] as $ctop)
                                                                                                    <span>- {{ $ctop }}</span><br>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <div class="qu-inr">
                                                                                                <input type="number" name="qty" id="qty_size_{{ $key }}" value="{{ $cart['quantity'] }}" style="max-width: 65px!important;">
                                                                                                <a onclick="updatecart({{ $cart['product_id'] }},{{ $key }},{{ $userid }})" class="px-2">
                                                                                                    <img src="{{ get_css_url().'public/images/update.png' }}">
                                                                                                </a>
                                                                                                <a onclick="deletecartproduct({{ $cart['product_id'] }},{{ $key }},{{ $userid }})">
                                                                                                    <i class="fas fa-times"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ $price }}</b>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ number_format($qty_price, 2) }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $subtotal += $qty_price;


                                                                                        if ($current_date >= $start_date && $current_date < $end_date) {
                                                                                            if (!empty($Coupon) || $Coupon != '') {

                                                                                                 $couponcode = 0;
                                                                                                    if( $Coupon['total'] <= $subtotal){
                                                                                                        if ($Coupon['type'] == 'P')
                                                                                                        {
                                                                                                            $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                                                                        }
                                                                                                        if ($Coupon['type'] == 'F')
                                                                                                        {
                                                                                                            $couponcode = $Coupon['discount'];
                                                                                                        }
                                                                                                    } else {
                                                                                                    session()->forget('couponname');
                                                                                                    session()->forget('currentcoupon');
                                                                                                    session()->forget('couponcode');
                                                                                                    session()->save();
                                                                                                }
                                                                                                $total = $subtotal - $couponcode;
                                                                                            }
                                                                                        } else {
                                                                                            $total = $subtotal;
                                                                                        }

                                                                                    @endphp
                                                                                @endforeach
                                                                            @endif

                                                                            @if (isset($mycart['withoutSize']))
                                                                                @foreach ($mycart['withoutSize'] as $key => $cart)
                                                                                    @php
                                                                                        // Price
                                                                                        if($userdeliverytype == 'delivery')
                                                                                        {
                                                                                            $price = isset($cart['del_price']) ? $cart['del_price'] : 0;
                                                                                            $qty_price = isset($cart['del_price']) ? $cart['del_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                                        }
                                                                                        elseif($userdeliverytype == 'collection')
                                                                                        {
                                                                                            $price = isset($cart['col_price']) ? $cart['col_price'] : 0;
                                                                                            $qty_price = isset($cart['col_price']) ? $cart['col_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $price = isset($cart['main_price']) ? $cart['main_price'] : 0;
                                                                                            $qty_price = isset($cart['main_price']) ? $cart['main_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                                        }
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="{{ $cart['image'] }}"
                                                                                                width="80" height="80">
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ $cart['name'] }}</b><br>
                                                                                            @if (isset($cart['topping']) && !empty($cart['topping']))
                                                                                                @foreach ($cart['topping'] as $ctop)
                                                                                                    <span>- {{ $ctop }}</span><br>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <div
                                                                                                class="qu-inr">
                                                                                                <input type="number" name="qty" id="qty_without_{{ $key }}" value="{{ $cart['quantity'] }}" style="max-width: 65px!important;">
                                                                                                <a onclick="updatecart({{ $key }},0,{{ $userid }})" class="px-2">
                                                                                                    <img src="{{ get_css_url().'public/images/update.png' }}">
                                                                                                </a>
                                                                                                <a onclick="deletecartproduct({{ $cart['product_id'] }},0,{{ $userid }})">
                                                                                                    <i class="fas fa-times"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ $price }}</b>
                                                                                        </td>
                                                                                        <td class="align-middle">
                                                                                            <b>{{ number_format($qty_price, 2) }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $subtotal += $qty_price;
                                                                                        if (!empty($Coupon) || $Coupon != '')
                                                                                        {
                                                                                            $couponcode = 0;
                                                                                                if( $Coupon['total'] <= $subtotal){
                                                                                                    if ($Coupon['type'] == 'P')
                                                                                                    {
                                                                                                        $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                                                                    }
                                                                                                    if ($Coupon['type'] == 'F')
                                                                                                    {
                                                                                                        $couponcode = $Coupon['discount'];
                                                                                                    }
                                                                                                }else{
                                                                                                    session()->forget('couponname');
                                                                                                    session()->forget('currentcoupon');
                                                                                                    session()->forget('couponcode');
                                                                                                    session()->save();
                                                                                                }
                                                                                            $total = $subtotal - $couponcode;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $total = $subtotal;
                                                                                        }

                                                                                    @endphp
                                                                                @endforeach
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </form>
                                                            </div>
                                                            <div class="row mb-2" id="free_item">
                                                                @if (!empty($session_free_item) || $session_free_item != '')
                                                                    <div class="col-md-4" style="text-align: right">
                                                                        <a class="btn mt-1" style="background: red!important; color:white!important;">Free Item</a>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <select class="form-control mt-1" disabled>
                                                                                <option>{{ $session_free_item }}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    @if(!empty($cart_rule_total) || $cart_rule_total != '')
                                                                        @if ($get_sub_total >= $cart_rule_total)
                                                                            @php
                                                                                $free_explode = isset($cart_rule['id_item']) ? explode(':',$cart_rule['id_item']) : '';
                                                                                $free_items = getFreeItems($free_explode);
                                                                            @endphp
                                                                            <div class="col-md-4" style="text-align: right">
                                                                                <a class="btn mt-1" style="background: red!important; color:white!important;">Free Item</a>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <div class="form-group">
                                                                                    <select name="free_item" id="free_item" class="form-control mt-1" onchange="changeFreeItem()">
                                                                                        @if (!empty($free_items) || $free_items != '')
                                                                                            @foreach ($free_items as $key => $fitem)
                                                                                                <option value="{{ $fitem }}" {{ ($session_free_item == $fitem) ? 'selected' : '' }}>{{ $fitem }}</option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div class="basket-total">
                                                                <table class="table table-responsive">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><b>Sub-Total:</b></td>
                                                                            <td><span><b>{{ $currency }} {{ $subtotal }}</b></span></td>
                                                                        </tr>
                                                                        @if (!empty($Coupon) || $Coupon != '')
                                                                            @if ($couponcode != 0)
                                                                                <tr class="coupon_code">
                                                                                    <td><b>Coupon({{ isset($Coupon['code']) ? $Coupon['code'] : '' }}):</b></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <b>{{ $currency }} -{{ (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) }}</b>
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endif
                                                                        <tr class="voucher"></tr>
                                                                        <tr id="servicecharge" style="display: none">
                                                                            <td><b>Service Charge :</b></td>
                                                                            <td>
                                                                                <span id="servicechargeammout">

                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="total">
                                                                            <td><b>Total to pay:</b></td>
                                                                            <td><span><b id="total_pay">{{ $currency }}{{ ($total <= 0) ? 0 : $total }}</b></span></td>
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
                            <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="login-main text-center">
                                                <div class="login-details w-100">
                                                    <div id="voucher" class="content">
                                                        <form action="{{ route('voucher') }}" method="post" enctype="multipart/form-data" id="voucher_form">
                                                            @csrf
                                                            <div style="display: none;">Enter your gift voucher code
                                                                here:&nbsp;</div>
                                                            {{-- <div class="login-details-inr fa fa-caret-up w-100 vouchercode d-flex"> --}}
                                                            <div class="login-details-inr w-100 vouchercode d-flex">
                                                                <input type="text" name="voucher" value="" placeholder="Voucher Code" class="w-75">
                                                                {{-- <input style="text-transform: uppercase;" type="submit" value="Apply" class="ms-2 btn btn-danger"> --}}
                                                                <button class="ms-2 btn" style="text-transform: uppercase;display: inline-block;" type="submit  ">
                                                                    Apply
                                                                  <span class="spinner-border spinner-border-sm ms-2" id="voucherload" role="status" aria-hidden="true" style="display: none"></span>
                                                                </button>
                                                            </div>
                                                            <p class="text-danger" id="voucherError" style="text-align: left"></p>
                                                            <p class="text-success" id="voucherSuccess" style="text-align: left"></p>
                                                        </form>
                                                    </div>
                                                    <div id="coupon" class="content">
                                                        <form action="{{ route('coupon') }}" method="post" enctype="multipart/form-data" id="coupon_form">
                                                            @csrf
                                                            <div style="display: none;">Enter your coupon here:&nbsp;</div>
                                                            <div class="login-details-inr w-100 vouchercode d-flex">
                                                                <input type="text" name="coupon" value="" placeholder="Coupon Code" class="w-75">
                                                                {{-- <input style="text-transform: uppercase;" type="submit" value="Apply" class="ms-2 btn btn-danger"> --}}
                                                                <button class="ms-2 btn" style="text-transform: uppercase;display: inline-block;" type="submit">
                                                                    Apply
                                                                  <span class="spinner-border spinner-border-sm ms-2" id="couponload" role="status" aria-hidden="true" style="display: none"></span>
                                                                </button>
                                                            </div>
                                                            <p class="text-danger" id="couponError" style="text-align: left"></p>
                                                            <p class="text-success" id="couponSuccess" style="text-align: left"></p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" id="paymentoption">
                            <h2 class="accordion-header accordion-button" id="headingtwo" type="button">
                                <span>Payment Options</span>
                            </h2>
                            <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <div class="login-main text-center">
                                                <div class="login-details w-100">
                                                    @if ($servicecharge["stripe"]["stripe_status"] == 1)
                                                        <div class="payment-class myfoodbasketpayments_gateway">
                                                            <input type="radio" name="payment_method" value="1" id="myfoodbasketpayments_gateway" class="text-bold change_color pay_btn"><span class="check_btn"></span><img class="w-100" src="{{get_css_url().'public/frontend/other/checkout-payment-card.png'}}">
                                                        </div>
                                                    @endif
                                                    @if ($servicecharge["paypal"]["pp_express_status"] == 1)
                                                        <div class="payment-class myfoodbasketpayments_gateway">
                                                            <input type="radio" name="payment_method" value="2" id="myfoodbasketpayments_gateway1" class="text-bold change_color pay_btn"><span class="check_btn"></span><img class="w-100" src="{{get_css_url().'public/frontend/other/paypal.png'}}">
                                                        </div>
                                                    @endif
                                                    @if ($servicecharge["cod"]["cod_status"] == 1)
                                                        <div class="payment-class myfoodbasketpayments_gateway">
                                                            <input type="radio" name="payment_method" value="3" id="cod" class="text-bold change_color pay_btn">
                                                            <span class="check_btn"></span>
                                                            <img src="{{ get_css_url().'public/frontend/other/cash.png' }}">
                                                            @if ($userdeliverytype == 'collection')
                                                                <label class="ybc_cod" for="cod">{{ $servicecharge['cod']['cod_front_text'] ? $servicecharge['cod']['cod_front_text'] : 'Cash On Collection' }}</label>
                                                            @endif
                                                            @if ($userdeliverytype == 'delivery')
                                                                <label class="ybc_cod" for="cod">{{ $servicecharge['cod']['cod_front_text_delivery'] ? $servicecharge['cod']['cod_front_text_delivery'] : 'Cash On Delivery' }}</label>
                                                            @endif
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
                    <div class="col-md-4 mt-4">
                        <div class="backbtn d-flex justify-content-between">
                            <button class="btn" onclick="$('#checkout3').hide(); $('#checkout2').show();">
                                <i class="fa fa-angle-left"></i> Back
                            </button>
                             <form action="{{ route('processTransaction') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="subtotal" id="subtotal" value="{{ isset($subtotal) ? $subtotal : '' }}">
                                <input type="hidden" name="service_charge" id="service_charge">
                                <input type="hidden" name="couponcode" id="couponcode" value="{{ isset($couponcode) ? $couponcode : '' }}">
                                <input type="hidden" name="couponname" id="couponname" value="{{ isset($couponname) ? $couponname : '' }}">
                                <input type="button" value="Pay {{ $currency }} {{ ((round($total , 2) <= 0) ? 0 : round($total , 2)) }}" id="button-payment-method" class="btn back-bt" disabled>
                                {{-- <a type="hidden" href="{{ route('stripe') }}">Pay {{ $currency }} {{ isset($total) ? $total : '' }}</a> --}}
                                <input type="hidden" name="currency_code" value="{{ $store_setting['config_currency'] }}">
                                <input type="hidden" name="total" id="total" value="{{$subtotal}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Checkout Step 3 --}}


    {{-- footer  --}}
    @include('frontend.theme.all_themes.footer')


    {{-- JS --}}
    @include('frontend.include.script')
    {{-- End JS --}}

    @php
    // echo '<pre>';
    // // print_r($mycart['size']);
    // echo "<br>";
    // print_r($mycart);
    // exit();
        $cart_size_session = isset($mycart['size']) ? $mycart['size'] : '';
        $cart_withoutsize_session = isset($mycart['withoutSize']) ? $mycart['withoutSize'] : '';
        if(empty($cart_size_session) && empty($cart_withoutsize_session)){
            $emptycarturl = route('cart');
            echo "<script type='text/javascript'>
                    window.location.replace('".$emptycarturl."');
                </script>";
        }
    @endphp

    {{-- Custom JS --}}
    <script type="text/javascript">

        // Document Script
        $('document').ready(function()
        {

            var d_type = $('input[name="order"]:checked').val();
            if (d_type == 'delivery')
            {
                $('#deliveryaddress').show();
            }

            if (d_type == 'collection')
            {
                $('#deliveryaddress').hide();
            }


            // Time Method
            var time = $('.time_select :selected').val();
            $.ajax({
                type: "post",
                url: "{{ url('setTimeMethod') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'time': time,
                },
                dataType: "json",
                success: function(response)
                {
                    if(response.success == 1)
                    {
                        console.log('time set successfully....');
                    }

                    if(response.error == 1)
                    {
                        console.log('Error : Time not set');
                    }
                }
            });

        });
        // End Document Script


        // Time Mehod
        $('.time_select').on('change',function(){

            var time = $('.time_select :selected').val();
            $.ajax({
                type: "post",
                url: "{{ url('setTimeMethod') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'time': time,
                },
                dataType: "json",
                success: function(response)
                {
                    if(response.success == 1)
                    {
                        console.log('time set successfully....');
                    }

                    if(response.error == 1)
                    {
                        console.log('Error : Time not set');
                    }
                }
            });
        });


        // Guest Checkout
        function guestCheckout()
        {
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
                error: function(message)
                {
                    var gender = message.responseJSON.errors.title;
                    var firstname = message.responseJSON.errors.firstname;
                    var lastname = message.responseJSON.errors.lastname;
                    var email = message.responseJSON.errors.email;
                    var phone = message.responseJSON.errors.phone;

                    // Title
                    if (gender)
                    {
                        $('#genderarr').text('').show();
                        $('#gender').attr('class', 'form-control is-invalid');
                        $('#genderarr').text(gender);
                    }
                    else
                    {
                        $('#genderarr').text('').hide();
                        $('#gender').attr('class', 'form-control');
                    }
                    // End Title

                    // FirstName
                    if (firstname)
                    {
                        $('#fnamearr').text('').show();
                        $('#fname').attr('class', 'form-control is-invalid');
                        $('#fnamearr').text(firstname);
                    }
                    else
                    {
                        $('#fnamearr').text('').hide();
                        $('#fname').attr('class', 'form-control');
                    }
                    // End FirstName

                    // LastName
                    if (lastname)
                    {
                        $('#lnamearr').text('').show();
                        $('#lname').attr('class', 'form-control is-invalid');
                        $('#lnamearr').text(lastname);
                    }
                    else
                    {
                        $('#lnamearr').text('').hide();
                        $('#lname').attr('class', 'form-control');
                    }
                    // End LastName

                    // Email
                    if (email)
                    {
                        $('#emailarr').text('').show();
                        $('#email').attr('class', 'form-control is-invalid');
                        $('#emailarr').text(email);
                    }
                    else
                    {
                        $('#emailarr').text('').hide();
                        $('#email').attr('class', 'form-control');
                    }
                    // End Email

                    // Phone No
                    if (phone)
                    {
                        $('#phonearr').text('').show();
                        $('#phone').attr('class', 'form-control is-invalid');
                        $('#phonearr').text(phone);
                    }
                    else
                    {
                        $('#phonearr').text('').hide();
                        $('#phone').attr('class', 'form-control');
                    }
                    // End Phone No
                }
            });

        }
        // End Guest Checkout


        // Delivery Address
        function DeliveryAddress()
        {
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
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#checkout2').hide();
                        $('#checkout3').show();
                    }

                    if (response.errors == 1)
                    {
                        $('#postcodeerr').text('').show();
                        // $('#postcode').attr('class','form-control is-invalid');
                        $('#postcodeerr').text(response.errors_message);
                    }
                },
                error: function(message)
                {
                    if (typeof(message.responseJSON) != "undefined" && message.responseJSON !== null)
                    {
                        var address_1 = message.responseJSON.errors.address_1;
                        var city = message.responseJSON.errors.city;
                        var postcode = message.responseJSON.errors.postcode;
                        var phone_no = message.responseJSON.errors.phone_no;
                        var area = message.responseJSON.errors.area;
                    }

                    // Address 1
                    if (address_1)
                    {
                        $('#address_1err').text('').show();
                        // $('#address_1').attr('class','form-control is-invalid');
                        $('#address_1err').text(address_1);
                    }
                    else
                    {
                        $('#address_1err').text('').hide();
                        $('#address_1').attr('class', 'form-control');
                    }
                    // End Address 1

                    // City
                    if (city)
                    {
                        $('#cityerr').text('').show();
                        $('#cityerr').text(city);
                    }
                    else
                    {
                        $('#cityerr').text('').hide();
                        $('#city').attr('class', 'form-control');
                    }
                    // End City

                    // Postcode
                    if (postcode)
                    {
                        $('#postcodeerr').text('').show();
                        $('#postcodeerr').text(postcode);
                    }
                    else
                    {
                        $('#postcodeerr').text('').hide();
                        $('#postcode').attr('class', 'form-control');
                    }
                    // End Postcode

                    // Phone
                    if (phone_no)
                    {
                        $('#phone_noerr').text('').show();
                        $('#phone_noerr').text(phone_no);
                    }
                    else
                    {
                        $('#phone_noerr').text('').hide();
                        $('#phone_no').attr('class', 'form-control');
                    }
                    // End Phone

                    // Area
                    if (area)
                    {
                        $('#areaerr').text('').show();
                        $('#areaerr').text(area);
                    }
                    else
                    {
                        $('#areaerr').text('').hide();
                        $('#area').attr('class', 'form-control');
                    }
                    // End Area
                }
            });
        }
        // End Delivery Address


        // Change Delivery Type
        $('.collection_type').click(function()
        {
            var d_type = $('input[name="order"]:checked').val();

            $.ajax({
                type: "post",
                url: "{{ url('setDeliveyType') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'd_type': d_type,
                },
                dataType: "json",
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#total_pay').text('');
                        $('#total_pay').text(response.total_pay);
                        location.reload();
                    }
                }
            });
        });
        // End Change Delivery Type


        $('#login').click(function(e)
        {
            e.preventDefault();
            $('#demo').show();
            $('#Checkout').hide();
        });


        // Payment Button JS
        $('.pay_btn').on('click', function()
        {
            // var method_type = $('input[name="payment_method"]:checked').val();

            var method_type = $(this).val();
            // Uncheck others
            $(this).prop('checked', false);
            $('#button-payment-method').prop('disabled', true);
            $.ajax({
                type: "post",
                url: "{{ route('servicecharge') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "method_type" : method_type,
                },
                dataType: "json",
                success: function (response) {
                    if (response.error == 1) {
                        $(this).prop('checked', false);
                        $('#servicecharge').css("display", "none");
                        $('#min_delivery').css('display', 'block');
                        $('.min_delivery').html(response.message);

                        // $('.pirce-value').text('');
                        $('#button-payment-method').val('');
                        // $('#button-payment-method').val("Pay {{ $currency }} "+ response.total +"");
                        $('#button-payment-method').val("CONFIRM");
                        // $('#button-payment-method').removeAttr("type");
                        // $('#total').val(response.subtotal);
                        // $('#service_charge').val(response.service_charge);
                        $('#button-payment-method').prop('disabled', true);


                        let total = response.total-response.service_charge;
                        $('.pirce-value').text('');

                        $('#total_pay').text('');
                        $('#total_pay').text("{{ $currency }} "+ total +"");
                        // $('#servicechargeammout').html('<b id="del_charge">{{ $currency }} '+ response.service_charge +'</b>');

                        $('.pirce-value').append(total);
                    }
                    else{
                        // alert(response.service_charge);
                        if (method_type == 3) {
                            $('#cod').prop('checked',true);
                            $('#min_delivery').css('display', 'none');
                            $('.pirce-value').text('');
                            $('.pirce-value').append(response.headertotal);
                            $('#button-payment-method').val('');
                            $('#button-payment-method').val('CONFIRM');
                            $('#button-payment-method').removeAttr("type").attr("type", "button");
                            $('#servicecharge').css("display", "contents");
                            $('#servicechargeammout').html('<b id="del_charge">{{ $currency }} '+ response.service_charge +'</b>');
                            $('#total_pay').text('');
                            $('#total_pay').text("{{ $currency }} "+ response.total +"");
                            $('#total').val(response.subtotal);
                            $('#service_charge').val(response.service_charge);
                            $('#button-payment-method').prop('disabled', false);
                        }
                        else if (method_type == 2) { // paypal
                            // $('#myfoodbasketpayments_gateway1').prop('checked',true);
                            $('#myfoodbasketpayments_gateway1').prop('checked', true);
                            $('#min_delivery').css('display', 'none');
                            $('.pirce-value').text('');
                            $('.pirce-value').append(response.headertotal);
                            $('#button-payment-method').val('');
                            $('#button-payment-method').val("Pay {{ $currency }} "+ response.total +"");
                            $('#button-payment-method').removeAttr("type").attr("type", "submit");
                            $('#button-payment-method').html("<a href='#'>Pay {{ $currency }} "+ response.total +"</a>");
                            $('#servicecharge').css("display", "contents");
                            $('#servicechargeammout').html('<b id="del_charge">{{ $currency }} '+ response.service_charge +'</b>');
                            $('#total_pay').text('');
                            $('#total_pay').text("{{ $currency }} "+ response.total +"");
                            $('#total').val(response.subtotal);
                            $('#service_charge').val(response.service_charge)
                            $('#button-payment-method').prop('disabled', false);
                        }
                        else if (method_type == 1) {  // stripe
                            // $('#myfoodbasketpayments_gateway').prop('checked',true);
                            $('#myfoodbasketpayments_gateway').prop('checked', true);
                            $('#min_delivery').css('display', 'none');
                            $('.pirce-value').text('');
                            $('.pirce-value').append(response.headertotal);
                            $('#button-payment-method').val('');
                            $('#button-payment-method').val("Pay {{ $currency }} "+ response.total +"");
                            $('#button-payment-method').removeAttr("type").attr("type", "button");
                            $('#servicecharge').css("display", "contents");
                            $('#servicechargeammout').html('<b id="del_charge">{{ $currency }} '+ response.service_charge +'</b>');
                            $('#total_pay').text('');
                            $('#total_pay').text("{{ $currency }} "+ response.total +"");
                            $('#total').val(response.subtotal);
                            $('#service_charge').val(response.service_charge);
                            // $.session.set('total', "+ response.total +");
                            $('#button-payment-method').prop('disabled', false);
                        }
                        else{
                            $('#button-payment-method').val('');
                            $('#button-payment-method').val("Pay {{ $currency }} "+ response.total +"");
                        }
                    }
                }
            });

        });
        // End Payment Button JS


        // Delivery Button JS
        $('#deliver').on("click", function()
        {
            $('#colloctiontime').hide();
            $('#dileverytime').show();
            $('#deliveryaddress').show();
        });
        // End Delivery Button JS


        // Collection Button JS
        $('#collect').on("click", function()
        {
            $('#colloctiontime').show();
            $('#dileverytime').hide();
            $('#deliveryaddress').hide();
        });
        // End Collection Button JS


        var deliver = $('#deliver').val();
        if (deliver == 'on')
        {
            $('#colloctiontime').hide();
            $('#dileverytime').show();
            $('#deliveryaddress').show();
        }
        else
        {
            $('#colloctiontime').show();
            $('#dileverytime').hide();
            $('#deliveryaddress').hide();
        }


        // Next Button JS
        $('#next').on("click", function()
        {
            $('#checkout2').hide();
            $('#checkout3').show();
        });
        // End Next Button JS


        // Checkout
        $('#button-payment-method').on('click', function()
        {
            var method_type = $('input[name="payment_method"]:checked').val();
            var total = $('#total').val();
            var subtotal = $('#subtotal').val();
            var service_charge = $('#service_charge').val();
            var couponcode = $('#couponcode').val();
            var couponname = $('#couponname').val();
            var free_item = $('#free_item :selected').val();

            if (method_type == 1) {
                window.location.href = "{{ route('stripe') }}";
            }

            // if (method_type == 1)
            // {
            //     $.ajax({
            //         type: "post",
            //         url: "{{ url('confirmorder') }}",
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //             'p_method': method_type,
            //             'total': total,
            //             'subtotal': subtotal,
            //             'couponcode': couponcode,
            //             'couponname': couponname,
            //         },
            //         dataType: "json",
            //         success: function(response)
            //         {
            //             if (response.success == 1)
            //             {
            //                 var new_url = response.success_url;
            //                 window.location = new_url;
            //             }
            //         }
            //     });
            // }

            // Paypal Payment Getway
            // if (method_type == 2) {
            //     // window.location.replace("{{ route('processTransaction') }}");
            //     $.ajax({
            //         type: "post",
            //         url: "{{ route('processTransaction') }}",
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //             'currencycode' : "{{ $store_setting['config_currency'] }}",
            //             'total': total,
            //         },
            //         dataType: "json",
            //         success: function (response) {
            //             alert("Success");
            //         }
            //     });
            // }


            if (method_type == 3)
            {
                $.ajax({
                    type: "post",
                    url: "{{ url('confirmorder') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'p_method': method_type,
                        'total': total,
                        'subtotal': subtotal,
                        'service_charge': service_charge,
                        'couponcode': couponcode,
                        'couponname': couponname,
                        'free_item': free_item,
                    },
                    dataType: "json",
                    success: function(response)
                    {
                        if (response.success == 1)
                        {
                            var new_url = response.success_url;
                            window.location = new_url;
                        }
                    }
                });
            }

        });
        // End Checkout


        // Get address
        var customerid = $(' #customerid ').val();
        $.ajax({
            type: "get",
            url: "{{ url('getaddress') }}/" + customerid,
            dataType: "json",
            success: function(response) {
                $('.address').html(response);
            }
        });
        // End Get address


        // Get Payment Address By Customer Address ID
        function Getcustomeraddress()
        {
            var payment_address_id = $('#address').val();
            $.ajax({
                type: "GET",
                url: "{{ url('getcustomeraddress') }}/" + payment_address_id,
                dataType: "json",
                success: function(response)
                {
                    $('#address_1').val(response.address_1);
                    $('#address_2').val(response.address_2);
                    $('#postcode').val(response.postcode);
                    $('#city').val(response.city);
                    $('#phone_no').val(response.phone);
                }
            });
        }
        // End Get Payment Address By Customer ID


        // Customer Cart Product Update
        function updatecart(product, sizeprice, uid)
        {
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

            // Customer Cart Product Update
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
                success: function(result)
                {
                    if(result.required_1 == 1)
                    {
                        alert('Please Enter the valid Number of Quantity');
                        location.reload();
                    }

                    if(result.max_limit == 1)
                    {
                        alert('Sorry, You can\'t Order More Then 50 Quantity of This Product');
                        location.reload();
                    }

                    location.reload();
                }
            });
        }
        // End Customer Cart Product Update


        // Delete Customer Cart Product
        function deletecartproduct(prod_id, size_id, uid)
        {
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
                success: function(result)
                {
                    location.reload();
                }
            });
        }
        // End Delete Customer Cart Product


        // Voucher Apply
        $('#voucher_form').submit(function(e)
        {
            e.preventDefault();
            $('#voucherload').css('display' , 'inline-block');
            var voucher = $("input[name='voucher']").val();

            $.ajax({
                type: 'post',
                url: '{{ url("voucher") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'voucher': voucher,
                },
                dataType: 'json',
                success: function(result)
                {
                    $('#voucherload').css('display' , 'none');
                    if(result.errors == 1)
                    {
                        $('#voucherSuccess').html('');
                        $('#voucherError').html('');
                        $('#voucherError').append(result.errors_message);
                        setTimeout(() => {
                            $('#voucherError').html('');
                        }, 10000);
                    }

                    if(result.success == 1)
                    {
                        $('#voucherError').html('');
                        $('#voucherSuccess').html('');
                        $('#voucherSuccess').append(result.success_message);
                        $('.voucher').html('');
                        $('.voucher').append(result.voucher);
                        $('.total').html('');
                        $('.total').append(result.total);
                        $('.pirce-value').text('');
                        $('.pirce-value').append(result.total);
                        setTimeout(() => {
                            $('#voucherSuccess').html('');
                        }, 10000);
                    }
                }
            });
        });
        // Voucher Apply

        // let method_type = 0;
        // $('.pay_btn').on('click', function()
        // {
        //     // var method_type = $('input[name="payment_method"]:checked').val();
        //     var method_type = $(this).val();
        // });

        // let m_type = method_type;
        // alert(method_type)


        // Coupon Apply
        $('#coupon_form').submit(function(e)
        {
            e.preventDefault();
            var coupon = $("input[name='coupon']").val();
            // var method_type = $('input[name="payment_method"]:checked').val();
            $('#couponload').css('display' , 'inline-block');
            let total = $('#total').val();



            var method_type = $('input[name="payment_method"]:checked').val();
            var order_type = $('input[name="order"]:checked').val();
            // var order_type = $('#deliver').val();

            $.ajax({
                type: 'post',
                url: '{{ url("getcoupon") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'coupon': coupon,
                    'method_type': method_type,
                    'total': total,
                },
                dataType: 'json',
                success: function(result)
                {


                    $('#couponload').css('display' , 'none');


                    // if (order_type == 'delivery' && result.headertotal <= result.min_spend) {
                    //     alert("HI")
                    //     $('#min_delivery').css('display', 'block');
                    //     $('.min_delivery').html('Minimum delivery is {{ $currency }} '+result.min_spend+'');
                    //     // Minimum delivery is {{ $currency }}.;
                    //     // $('.min_delivery').html(response.message);
                    //     // $('input[name="payment_method"]:checked').prop('checked', false);
                    // }


                    if(result.success == 1)
                    {

                        if (order_type == 'delivery') {
                            if (result.min_spend >= result.headertotal) {
                                $('#min_delivery').css('display', 'block');
                                $('.min_delivery').html('Minimum delivery is {{ $currency }} '+result.min_spend+'');
                                $('#button-payment-method').prop('disabled', true);
                            }

                        }

                        if (method_type == 3) {
                            $('#button-payment-method').val('');
                            $('#button-payment-method').val('CONFIRM');
                        }
                        else{
                            $('#button-payment-method').val('');
                            $('#button-payment-method').val("Pay {{ $currency }} "+ result.headertotal +"");
                        }

                        $('#couponError').html('');
                        $('#couponSuccess').html('');
                        $('#couponSuccess').append(result.success_message);
                        $('.coupon_code').html('');
                        if ( $(".coupon_code").length ) {
                            /*EXISTS (greater than 0) */
                            // $('.coupon_code').html('<td colspan="2"><span style="justify-content: space-around;display:flex;"><b>'+result.couponcode+'</b></span></td>');
                            $('.coupon_code').html('');
                            if (result.couponcode_name != '' && result.couponcode_amount != '') {
                                $('.coupon_code').html('<td><b>Coupon('+ result.couponcode_name +'):</b></td><td><span><b>{{ $currency }}-'+ result.couponcode_amount +'</b></span></td>');
                            }
                        }else{
                            if (result.couponcode != '') {
                                $('.coupon_code').html('');
                                $('<td><b>Coupon('+ result.couponcode_name +'):</b></td><td><span><b>{{ $currency }}-'+ result.couponcode_amount +'</b></span></td>').insertBefore(".voucher");
                            }
                        }
                        $('.total').html('');
                        $('.total').append('<td colspan="2"><b style="justify-content: space-around;display:flex;">'+result.total+'</b></td>');
                        $('.pirce-value').text('');
                        $('.pirce-value').append(result.headertotal);
                        setTimeout(() => {
                            $('#couponSuccess').html('');
                        }, 10000);
                    }

                    if(result.errors == 1)
                    {
                        $('#couponSuccess').html('');
                        $('#couponError').html('');
                        $('#couponError').append(result.errors_message);
                        setTimeout(() => {
                            $('#couponError').html('');
                        }, 10000);
                    }

                }
            });
        });
        // End Coupon Apply


    </script>
    {{-- End Custom JS --}}

</body>
</html>
