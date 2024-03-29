<!--
    THIS IS CONTACT PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    contact.blade.php
    It's used for contact to stores.
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
@endphp


<!doctype html>
<html>

<head>
    <!-- CSS -->
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    <!-- End CSS -->

    <!-- Custom CSS -->
    <style>
        /* #map
        {
            width: 100%;
            height: 400px;
        } */

        .map-responsive {
            overflow: hidden;
            padding-bottom: 50%;
            position: relative;
            height: 0;
        }

        .map-responsive iframe {
            left: 0;
            top: 0;
            /* height:100%; */
            width: 100%;
            position: absolute;
        }

    </style>
    <!-- End Custom CSS -->
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


    <!-- Contact Section -->
    <section class="contact-main">
        <div class="container">
            <div class="contact-inr">
                <div class="contact-map">
                    <div class="contact-title">
                        <div class="py-3">
                            <h3>Contact Us</h3>
                        </div>
                    </div>
                    <div class="map-responsive">
                        {{-- <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> --}}
                        <iframe src="{{ $store_setting['map_ifram'] }}" width="600" height="450" frameborder="0"
                            style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="contact-info">
                    <div class="row">
                        <div class="col-md-6 contact-info-left">
                            <div class="map-info">
                                {{-- <h3>Get Directions</h3>
                                <form>
                                    <div class="login-details-inr fa fa-crosshairs w-100">
                                        <input placeholder="Enter your location" type="text" name="map" value=""
                                            class="w-100">
                                    </div>
                                    <button class="btn map-bt w-100">GET DIRECTIONS</button>
                                </form> --}}
                                <div class="shop-location text-center" style="padding: 45px">
                                    <h2>{{ $store_setting['config_name'] }}</h2>
                                    <p>{{ $store_setting['config_address'] }}</p>
                                    <span><b>Tel : </b>{{ $store_setting['config_telephone'] }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="contact-details">
                                <h3>Contact us form</h3>
                                <form action="{{ route('contactstore') }}" method="post" enctype="multipart/form-data"
                                    id="form">
                                    @csrf
                                    <div class="login-details-inr fa fa-envelope w-100">
                                        <select name="title" class="w-100 {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                            style="width: 100%;border-radius:0;">
                                            <option value="">Title</option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Mrs">Mrs.</option>
                                            <option value="Ms">Ms.</option>
                                            <option value="Miss">Miss.</option>
                                            <option value="Dr">Dr.</option>
                                            <option value="Prof">Prof.</option>
                                        </select>
                                        @if ($errors->has('title'))
                                            <div class="text-danger">
                                                {{ $errors->first('title') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-user w-100 d-flex">
                                        <div class="w-100 d-inline-block float-start">
                                            <input placeholder="Name" type="text" name="name"
                                                value="{{ old('name') }}"
                                                class="w-100 {{ $errors->has('firstname') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('name'))
                                                <div class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-100 d-inline-block float-end">
                                            <input placeholder="Surname" type="text" name="surname"
                                                value="{{ old('surname') }}"
                                                class="w-100 {{ $errors->has('surname') ? 'is-invalid' : '' }}">
                                            @if ($errors->has('surname'))
                                                <div class="text-danger">
                                                    {{ $errors->first('surname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="login-details-inr fa fa-envelope w-100">
                                        <input placeholder="Email address" type="text" name="email"
                                            value="{{ old('email') }}"
                                            class="w-100 {{ $errors->has('email') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-phone-alt w-100">
                                        <input placeholder="phone number" type="text" name="phone"
                                            value="{{ old('phone') }}"
                                            class="w-100 {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                                        @if ($errors->has('phone'))
                                            <div class="text-danger">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-file-alt w-100">
                                        <textarea name="enquiry" placeholder="Your enquiry" cols="40" rows="7" spellcheck="false"
                                            class="w-100 {{ $errors->has('enquiry') ? 'is-invalid' : '' }} p-2">{{ old('enquiry') }}</textarea>
                                    </div>
                                    @if ($errors->has('enquiry'))
                                        <div class="text-danger">
                                            {{ $errors->first('enquiry') }}
                                        </div>
                                    @endif
                            </div>
                            <div class="submit-bt">
                                <button type="submit" class="btn sub-bt w-100">SUBMIT</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->


    {{-- footer --}}
    @include('frontend.theme.all_themes.footer')


    {{-- JS --}}
    @include('frontend.include.script')
    {{-- End JS --}}


    <!-- Custom JS -->
    <script type="text/javascript">
        // For Gmap
        function initMap() {
            var myLatLng = {
                lat: 22.3038945,
                lng: 57.149606
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 13
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!',
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(marker) {
                var latLng = marker.latLng;
                document.getElementById('lat-span').innerHTML = latLng.lat();
                document.getElementById('lon-span').innerHTML = latLng.lng();
            });
        }
        // End For Gmap
    </script>
    <!-- End Custom JS -->


</body>

</html>
