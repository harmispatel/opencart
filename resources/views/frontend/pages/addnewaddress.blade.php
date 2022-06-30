<!--
    THIS IS NEW CUSTOMER ADDRESS PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    addnewaddress.blade.php
    It's used Add Customers New Address From Frontend Site.
    ----------------------------------------------------------------------------------------------
-->


@php

    / // Get Current URL
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

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

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


    <!-- User Delivery Type -->
    <input type="hidden" name="user_delivery_val" id="user_delivery_val" value="{{ $userdeliverytype }}">
    <!-- End User Delivery Type -->


    {{-- header --}}
    @include('frontend.theme.all_themes.header')


    <!-- Customer Address Section -->
    <section class="register-main">
        <div class="container">
            <div class="register-inr">
                <div class="register-title">
                    <h2>ADDRESS BOOK</h2>
                </div>
                <div class="reg-details">
                    <form action="{{ route('newaddress') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="reg-details-inr">
                            <h3>Edit address</h3>
                        </div>
                        <div class="reg-details-inr">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><span class="required">*</span>First Name :</td>
                                        <td>
                                            <input type="text" class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}">
                                            @if ($errors->has('firstname'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('firstname') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Last Name :</td>
                                        <td>
                                            <input type="text" class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}">
                                            @if ($errors->has('lastname'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('lastname') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Company :</td>
                                        <td><input type="text" name="company" value="{{ old('company') }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Company ID :</td>
                                        <td><input type="text" name="company_id" value="{{ old('company_id') }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Address line 1 :</td>
                                        <td>
                                            <input type="text" class="form-control {{ ($errors->has('address_1')) ? 'is-invalid' : '' }}" name="address_1" value="{{old('address_1')}}">
                                            @if ($errors->has('address_1'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address_1') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address line 2 :</td>
                                        <td><input type="text" name="address_2" value=""></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>City :</td>
                                        <td>
                                            <input type="text" class="form-control {{ ($errors->has('city')) ? 'is-invalid' : '' }}" name="city" value="{{ old('city') }}">
                                            @if ($errors->has('city'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('city') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Post Code :</td>
                                        <td><input type="text" name="postcode" value="{{ old('postcode') }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span  class="required">*</span>Country :</td>
                                        <td>
                                            <select name="country" id="country_id" class="{{ ($errors->has('country')) ? 'is-invalid' : '' }}" onchange="getstate();">
                                                <option value="" disabled selected>Select Country</option>
                                                @foreach ($countries as $countrie)
                                                    <option value="{{ $countrie->country_id }}">{{ $countrie->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('country') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span  class="required">*</span>Region / State :</td>
                                        <td>
                                            <select class="country_region_id {{ ($errors->has('region')) ? 'is-invalid' : '' }}" name="region">
                                                <option value="" selected disabled>Select Region/State</option>
                                            </select>
                                            @if ($errors->has('region'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('region') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Default Address :</td>
                                        <td class="radio-bt">
                                            <input type="radio" name="default" value="1"><span>Yes</span>
                                            <input type="radio" name="default" value="0" checked="checked"><span>No</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="reg-bt d-flex justify-content-between">
                            <a href="{{ route('member') }}" type="button" class="btn">Back</a>
                            <button type="submit" class="btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Customer Address Section -->


    {{-- footer --}}
    @include('frontend.theme.all_themes.footer')


    <!-- JS -->
    @include('frontend.include.script')
    <!-- End JS -->


    <!-- Custom JS -->
    <script type="text/javascript">

        // Get Regions By Country ID
        function getstate()
        {
            var country_id = $('#country_id :selected').val();

            $.ajax({
                type: "POST",
                url: "{{ url('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success: function(response)
                {
                    $('.country_region_id').text('');
                    $('.country_region_id').append(response);
                }
            });
        }
        // End Get Regions By Country ID

    </script>
    <!-- End Custom JS -->

</body>
</html>

