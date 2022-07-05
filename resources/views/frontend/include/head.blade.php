{{--
    THIS IS HEAD PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    head.blade.php
    It's Included Some CSS Links with diffrent themes.
    it is used for including styling for frontend site.
    ----------------------------------------------------------------------------------------------
--}}


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

@endphp

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>{{ $store_setting['config_title'] }}</title>

{{-- Style Sheet Links --}}
<link rel="stylesheet" href="{{ get_css_url().'public/plugins/jquery-ui/jquery-ui.min.css' }}">
<link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">

{{-- @if (!empty($theme_id) || $theme_id != '') --}}
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/bootstrap/dist/css/bootstrap.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/header.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/slider.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/about_us.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/category.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/common.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/food.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/reviews.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/reservation.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/gallary.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/openhours.css' }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/frontend_css/footer.css' }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/plugins/bootstrap/dist/css/bootstrap.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/plugins/bootstrap/dist/css/bootstrap.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/plugins/bootstrap/dist/css/bootstrap.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/plugins/bootstrap/dist/css/bootstrap.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/plugins/bootstrap/dist/css/bootstrap.min.css'  }}"> --}}


    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}"> --}}


    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/fontawesome/css/all.min.css'  }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/plugins/fontawesome/css/all.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/plugins/fontawesome/css/all.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/plugins/fontawesome/css/all.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/plugins/fontawesome/css/all.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/plugins/fontawesome/css/all.min.css'  }}"> --}}


    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/swiper-js/swiper-bundle.min.css'  }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/plugins/swiper-js/swiper-bundle.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/plugins/swiper-js/swiper-bundle.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/plugins/swiper-js/swiper-bundle.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/plugins/swiper-js/swiper-bundle.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/plugins/swiper-js/swiper-bundle.min.css'  }}"> --}}


    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/ui/dist/fancybox.css'  }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/plugins/ui/dist/fancybox.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/plugins/ui/dist/fancybox.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/plugins/ui/dist/fancybox.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/plugins/ui/dist/fancybox.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/plugins/ui/dist/fancybox.css'  }}"> --}}


    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/animate.css/animate.min.css'  }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/plugins/animate.css/animate.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/plugins/animate.css/animate.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/plugins/animate.css/animate.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/plugins/animate.css/animate.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/plugins/animate.css/animate.min.css'  }}"> --}}


    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/select2/dist/css/select2.min.css'  }}"> --}}


    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/css/app.css'  }}"> --}}
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/css/app.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/css/app.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/css/app.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/css/app.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/css/app.css'  }}"> --}}


    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/css/responsive.css'  }}">
    {{-- <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme2/css/responsive.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme3/css/responsive.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme4/css/responsive.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme5/css/responsive.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme6/css/responsive.css'  }}"> --}}


{{-- @else
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/bootstrap/dist/css/bootstrap.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/fontawesome/css/all.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/swiper-js/swiper-bundle.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/ui/dist/fancybox.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/plugins/animate.css/animate.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/select2/dist/css/select2.min.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/css/app.css'  }}">
    <link rel="stylesheet" href="{{  get_css_url().'public/assets/theme1/css/responsive.css'  }}">
@endif --}}
<!-- End Style Sheet Links -->

<!-- Customer Register & Login Model -->
<div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="modal-login mb-3">
                    <form id="userlogin" method="POST">
                        {{ csrf_field() }}
                        <h2>LOG IN</h2>
                        <div id="loginerr"></div>
                        <div class="login-details-inr fa fa-envelope w-100">
                            <input placeholder="Email address" type="text" name="Email" value="" class="w-100">
                            <input type="hidden" name="ajaxlogin" value="1">
                            <div class="invalid-feedback text-start" style="display: none" id="loginemailerr"></div>
                        </div>
                            <div class="login-details-inr fa fa-lock w-100">
                            <input placeholder="Password" type="password" name="Password" value="" class="w-100">
                            <div class="invalid-feedback text-start" style="display: none" id="loginpassworderr"></div>
                        </div>
                        <div class="login-modal-last d-flex justify-content-between">
                            <a href="{{ route('forgotten') }}">Forgotten Password?</a>
                            <div class="check-modal">
                                <label for="remember">Remember Me</label>
                                <input type="checkbox" id="remember">
                            </div>
                        </div>
                        <button type="submit" form="userlogin" class="btn btn-success" id="loginform">Login</button>
                    </form>
                </div>
                <div class="new-account-modal">
                    <form action="{{ route('customerregister') }}" id="registerform"  method="POST">
                        {{ csrf_field() }}
                        <h2>Create an account</h2>
                        <div class="login-details-inr fa fa-sort-up w-100">
                            <select name="title" id="title" class="w-100">
                                <option disabled selected>Title</option>
                                <option value="1">Mr.</option>
                                <option value="2">Mrs.</option>
                                <option value="3">Ms.</option>
                                <option value="4">Miss.</option>
                                <option value="5">Dr.</option>
                                <option value="6">Prof.</option>
                            </select>
                            <div class="invalid-feedback text-start" style="display: none" id="titleerr"></div>
                        </div>
                        <div class="login-details-inr fa fa-user w-100">
                            <div class="w-50 d-inline-block float-start">
                                <input placeholder="firstame" type="text" id="name" name="firstname" value="" class="w-100">
                                <div class="invalid-feedback text-start" style="display: none" id="fnameerr"></div>
                            </div>
                            <div class="w-50 d-inline-block float-end">
                                <input placeholder="lastname" type="text" id="lastname" name="lastname" value="" class="w-100">
                                <input type="hidden" name="ajaxregister" value="1">
                                <div class="invalid-feedback text-start" style="display: none" id="lastnameerr"></div>
                            </div>
                        </div>
                        <div class="login-details-inr fa fa-envelope w-100">
                            <input placeholder="Email address" type="text" id="email" name="email" value="" class="w-100">
                            <div class="invalid-feedback text-start" style="display: none" id="emailerr"></div>
                        </div>
                        <div class="login-details-inr fa fa-phone-alt w-100">
                            <input placeholder="Phone number" type="text" id="phone" name="phone" value="" class="w-100">
                            <div class="invalid-feedback text-start" style="display: none" id="phoneerr"></div>
                        </div>
                        <div class="login-details-inr fa fa-lock w-100">
                            <input placeholder="Password" type="password" id="password" name="password" value="" class="w-100">
                            <div class="invalid-feedback text-start" style="display: none" id="passworderr"></div>
                        </div>
                        <div class="login-details-inr fa fa-lock w-100">
                            <input placeholder="Confirm Password" type="password" id="confirmpassword" name="confirm_password" value="" class="w-100">
                            <div class="invalid-feedback text-start" style="display: none" id="confirmpassworderr"></div>
                        </div>
                        <a form="registerform" id="register" class="btn btn-success">Register</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Customer Register & Login Model -->
