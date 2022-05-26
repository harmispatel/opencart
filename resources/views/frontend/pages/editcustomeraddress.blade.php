@php

    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    $theme_id = $current_theme_id['theme_id'];
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

@endphp


<!doctype html>
<html>
<head>
    <!-- CSS -->
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/pages/menu.css') }}">
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

    <!-- Header -->
    @if (!empty($theme_id) || $theme_id != '')
        @include('frontend.theme.theme' . $theme_id . '.header')
    @else
        @include('frontend.theme.theme1.header')
    @endif
    <!-- Header -->


    <!-- Address Section -->
    <section class="register-main">
        <div class="container">
            <div class="register-inr">
                <div class="register-title">
                    <h2>ADDRESS BOOK</h2>
                </div>
                <div class="reg-details">
                    <form action="{{ route('updatecustomeraddress') }}" method="POST">
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
                                            <input type="text" class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" name="firstname" value="{{ $customeraddress->firstname }}">
                                            <input type="hidden" name="address_id" value="{{ $customeraddress->address_id }}">
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
                                            <input type="text" class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" name="lastname" value="{{ $customeraddress->lastname }}">
                                            @if ($errors->has('lastname'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('lastname') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Company :</td>
                                        <td><input type="text" name="company" value="{{ $customeraddress->company }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Company ID :</td>
                                        <td><input type="text" name="company_id" value="{{ $customeraddress->company_id }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Address line 1 :</td>
                                        <td>
                                            <input type="text" class="form-control {{ ($errors->has('address_1')) ? 'is-invalid' : '' }}" name="address_1" value="{{ $customeraddress->address_1 }}">
                                            @if ($errors->has('address_1'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('address_1') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address line 2 :</td>
                                        <td><input type="text" name="address_2" value="{{ $customeraddress->address_2 }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>City :</td>
                                        <td>
                                            <input type="text" class="form-control {{ ($errors->has('city')) ? 'is-invalid' : '' }}" name="city" value="{{ $customeraddress->city }}">
                                            @if ($errors->has('city'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('city') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Post Code :</td>
                                        <td><input type="text" name="postcode" value="{{ $customeraddress->postcode }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span>*</span>Country :</td>
                                        <td>
                                            <select name="country" id="country_id" class="form-control {{ ($errors->has('country')) ? 'is-invalid' : '' }}" onchange="getstate();">
                                                <option value="" disabled selected>Select Country</option>
                                                @foreach ($countries as $country)
                                                        <option value="{{ $country->country_id }}" {{ ($customeraddress->country_id == $country->country_id) ? 'selected' : '' }}>{{ $country->name }}</option>
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
                                        <td><span>*</span>Region / State :</td>
                                        <td>
                                            <select class="country_region_id form-control {{ ($errors->has('region')) ? 'is-invalid' : '' }}" name="region">
                                                @php
                                                    $zone_id = $customeraddress->zone_id;
                                                    $zone = getZonebyId($zone_id);
                                                @endphp
                                                @if(!empty($zone))
                                                    <option value="{{ $zone->zone_id }}">{{ $zone->name }}</option>
                                                @else
                                                    <option value=""> -- Select Region -- </option>
                                                @endif
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
                                            <input type="radio" name="defaultaddress" value="1">
                                            <span>Yes</span>
                                            <input type="radio" name="defaultaddress" value="0" checked="checked" >
                                            <span>No</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="reg-bt d-flex justify-content-between">
                            <a href="{{ route('member') }}" type="submit" class="btn">Back</a>
                            <button type="submit" class="btn">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Address Section -->


    <!-- Footer -->
    @if (!empty($theme_id) || $theme_id != '')
        @include('frontend.theme.theme' . $theme_id . '.footer')
    @else
        @include('frontend.theme.theme1.footer')
    @endif
    <!-- Footer -->


    <!-- JS -->
    @include('frontend.include.script')
    <!-- End JS -->


    <!-- Custom JS -->
    <script type="text/javascript">
        // Get Region by Country ID
        function getstate()
        {
            var country_id = $('#country_id :selected').val();
            $.ajax({
                type: "POST",
                url: "{{ route('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}",},
                dataType: "json",
                success: function(response)
                {
                    $('.country_region_id').text('');
                    $('.country_region_id').append(response);
                },
            });
        }
        // End Get Region by Country ID
    </script>
    <!-- End Custom JS -->

</body>
</html>

