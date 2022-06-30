<!--
    THIS IS FORGET CUSTOMER PASSWORD PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    forgotten_password.blade.php
    It's used for change customer password.
    ----------------------------------------------------------------------------------------------
-->


@php

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

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Details
    $userlogin = session('username');
    // End User Details

@endphp

<!doctype html>
<html>
<head>
    <!-- CSS -->
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    <!-- End CSS -->
</head>
<body>

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

    {{-- header --}}
    @include('frontend.theme.all_themes.header')


    <!-- Member Section -->
    <section class="member-main">
        <div class="container">
            @if($errors->any())
                <div class="alert alert-sm alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> Please Check Form Carefully.. For Errors.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="member-inr">
                <div class="member-title">
                    <h2>FORGOT YOUR PASSWORD?</h2>
                    <p>Enter the e-mail address associated with your account. Click submit to have your password e-mailed to you.</p>
                </div>

                <form action="{{ route('sendforgorpasslink') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="forgot-inr" style="border-bottom:1px solid #000;padding:20px;">
                                <div class="forgot-inr-info">
                                    <h3>Your E-Mail Address</h3>
                                </div>
                                <table class="table" style="border:none;">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;border:none;">E-mail Address : </td>
                                            <td style="border: none;">
                                                <input type="text" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" name="email" placeholder="Enter your email"/>
                                                @if($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="reg-bt d-flex justify-content-between">
                                <a href="{{ route('member') }}" type="submit" class="btn">Back</a>
                                <button type="submit" class="btn">Continue</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
    <!-- End Member Section -->


    {{-- footer --}}
    @include('frontend.theme.all_themes.footer')


    <!-- JS -->
    @include('frontend.include.script')
    <!-- End JS -->

</body>
</html>

