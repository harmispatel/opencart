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


    <!-- Register Section -->
    <section class="register-main">
        <div class="container">
            <div class="register-inr">
                <div class="register-title">
                    <h2>REGISTER ACCOUNT</h2>
                    <p>If you already have an account with us, please login at the<a href="{{ route('member') }}"> login page</a>.</p>
                </div>
                <div class="reg-details">
                    <form action="{{ route('customerregister') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="reg-details-inr">
                            <h3>Your Personal Details</h3>
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
                                        <td><input type="text" class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}">
                                            @if ($errors->has('lastname'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('lastname') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span> E-Mail :</td>
                                        <td><input type="text" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Telephone:</td>
                                        <td><input type="text" class="form-control {{ ($errors->has('phone')) ? 'is-invalid' : '' }}" name="phone" value="{{ old('phone') }}">
                                            @if ($errors->has('phone'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('phone') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fax :</td>
                                        <td><input type="text" name="fax" value="{{ old('fax') }}"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="reg-details-inr">
                            <h3>Your Address</h3>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Company :</td>
                                        <td>
                                            <input type="text" name="company" value="{{ old('company') }}">
                                            <input type="hidden" name="address_required" value="1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Company ID :</td>
                                        <td><input type="text" name="company_id" value="{{ old('company_id') }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Address line 1 :</td>
                                        <td><input type="text" class="form-control {{ ($errors->has('address_1')) ? 'is-invalid' : '' }}" name="address_1" value="{{ old('address_1') }}">
                                            @if ($errors->has('address_1'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address_1') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address line 2 :</td>
                                        <td><input type="text" name="address_2" value="{{ old('address_2') }}"></td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>City :</td>
                                        <td><input type="text" class="form-control {{ ($errors->has('city')) ? 'is-invalid' : '' }}" name="city" value="{{ old('city') }}">
                                            @if ($errors->has('city'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('city') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Post Code :</td>
                                        <td><input type="text" class="form-control {{ ($errors->has('postcode')) ? 'is-invalid' : '' }}" name="postcode" value="{{ old('postcode') }}">
                                            @if ($errors->has('postcode'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('postcode') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Country :</td>
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
                                        <td><span class="required">*</span>Region / State :</td>
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
                                </tbody>
                            </table>
                        </div>
                        <div class="reg-details-inr">
                            <h3>Your Password</h3>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><span class="required">*</span>Password :</td>
                                        <td><input type="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}" name="password" value="">
                                            @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="required">*</span>Password Confirm :</td>
                                        <td><input type="password" class="form-control {{ ($errors->has('confirm_password')) ? 'is-invalid' : '' }}" name="confirm_password" value="">
                                            @if ($errors->has('confirm_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="reg-details-inr">
                            <h3>Newsletter</h3>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><span class="required">*</span>Subscribe :</td>
                                        <td class="radio-bt">
                                        <input type="radio" name="newsletter" value="1">
                                        <span>Yes</span>
                                        <input type="radio" name="newsletter" value="0" checked>
                                        <span>No</span>
                                            @if ($errors->has('newsletter'))
                                                <br><small class="text-danger">{{ $errors->first('newsletter') }}</small>
                                            @endif
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
    <!-- End Register Section -->


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


    <!-- Custom JS -->
    <script type="text/javascript">

        // Get Region By Country ID
        function getstate()
        {
            var country_id = $('#country_id :selected').val();
            $.ajax({
                type: "POST",
                url: "{{ url('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                cache: false,
                success: function(response)
                {
                    $('.country_region_id').text('');
                    $('.country_region_id').append(response);
                }
            });
        }
        // End Get Region By Country ID

    </script>
    <!-- End Custom JS -->

</body>
</html>
