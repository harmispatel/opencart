@php
    $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';

    $store_set = session('store_settings');
    $store_setting = isset($store_set) ? $store_set : '';
    // echo '<pre>';
    // print_r(session()->all());
    // exit();
@endphp
<!doctype html>
<html>
<style>
    /* #map {
        width: 100%;
        height: 400px;
    } */

    .map-responsive{
        overflow:hidden;
        padding-bottom:50%;
        position:relative;
        height:0;
    }
    .map-responsive iframe{
        left:0;
        top:0;
        /* height:100%; */
        width:100%;
        position:absolute;
    }

</style>

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
                       <iframe src="{{ $store_setting['map_ifram'] }}" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="contact-info">
                    <div class="row">
                        <div class="col-md-6 contact-info-left">
                            <div class="map-info">
                                <h3>Get Directions</h3>
                                <form>
                                    <div class="login-details-inr fa fa-crosshairs w-100">
                                        <input placeholder="Enter your location" type="text" name="map" value=""
                                            class="w-100">
                                    </div>
                                    <button class="btn map-bt w-100">GET DIRECTIONS</button>
                                </form>
                                <div class="shop-location text-center" style="padding: 45px">
                                    @php
                                         $name=session('store_settings');

                                    @endphp
                                    <h2>{{$name['config_name']}}</h2>
                                    <p>{{ $store_setting['config_address'] }}</p>
                                    <span><b>Tel : </b>{{  $store_setting['config_telephone'] }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="contact-details">
                                    <h3>Contact us form</h3>
                                    <form action="{{ route('contactstore') }}" method="post"
                                        enctype="multipart/form-data" id="form">
                                        @csrf
                                        <div class="login-details-inr fa fa-envelope w-100">
                                            <select name="title" class="w-100"
                                                style="width: 100%;border-radius:0;">
                                                <option value="">Title</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Miss.">Miss.</option>
                                                <option value="Dr.">Dr.</option>
                                                <option value="Prof.">Prof.</option>
                                            </select>
                                            @if ($errors->has('title'))
                                            <div class="alert-danger">
                                                {{ $errors->first('title') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="login-details-inr fa fa-user w-100 d-flex">
                                            <input placeholder="Name" type="text" name="name" value="" class="w-50">
                                            @if ($errors->has('name'))
                                            <div class="alert-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                            @endif
                                            <input placeholder="Surname" type="text" name="surname" value=""class="w-50">
                                            @if ($errors->has('surname'))
                                            <div class="alert-danger">
                                                {{ $errors->first('surname') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="login-details-inr fa fa-envelope w-100">
                                            <input placeholder="Email address" type="text" name="email" value=""
                                                class="w-100">
                                                @if ($errors->has('email'))
                                                <div class="alert-danger">
                                                    {{ $errors->first('email') }}
                                                </div>
                                                @endif
                                        </div>
                                        <div class="login-details-inr fa fa-phone-alt w-100">
                                            <input placeholder="phone number" type="text" name="phone" value=""
                                                class="w-100">
                                                @if ($errors->has('phone'))
                                                <div class="alert-danger">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                                @endif
                                        </div>
                                        <div class="login-details-inr fa fa-file-alt w-100">
                                            <textarea name="enquiry" placeholder="Your enquiry" cols="40" rows="7" spellcheck="false"
                                                class="w-100 p-2"></textarea>
                                                @if ($errors->has('enquiry'))
                                                <div class="alert-danger">
                                                    {{ $errors->first('enquiry') }}
                                                </div>
                                                @endif
                                        </div>
                                        {{-- <div class="g-recaptcha login-details-inr" data-sitekey="your_site_key"></div> --}}
                                        <div class="submit-bt">
                                            <button type="submit" class="btn sub-bt w-100" >SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-details">
                                <h3>Contact us form</h3>
                                <form action="{{ route('contactstore') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="login-details-inr fa fa-envelope w-100">
                                        <select name="Title" class="w-100"
                                            style="width: 100%;border-radius:0;">
                                            <option value="">Title</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Miss.">Miss.</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Prof.">Prof.</option>
                                        </select>
                                    </div>
                                    <div class="login-details-inr fa fa-user w-100 d-flex">
                                        <input placeholder="Name" type="text" name="name" value=""
                                            class="w-50">
                                        <input placeholder="Surname" type="text" name="surname" value=""
                                            class="w-50">
                                    </div>
                                    <div class="login-details-inr fa fa-envelope w-100">
                                        <input placeholder="Email address" type="text" name="email" value=""
                                            class="w-100">
                                    </div>
                                    <div class="login-details-inr fa fa-phone-alt w-100">
                                        <input placeholder="phone number" type="text" name="phone" value=""
                                            class="w-100">
                                    </div>
                                    <div class="login-details-inr fa fa-file-alt w-100">
                                        <textarea name="enquiry" placeholder="Your enquiry" cols="40" rows="7" spellcheck="false"
                                            class="w-100 p-2"></textarea>
                                    </div>
                                    {{-- <div class="g-recaptcha login-details-inr" data-sitekey="your_site_key"></div> --}}
                                    <div class="submit-bt">
                                        <button class="btn sub-bt w-100">SUBMIT</button>
                                    </div>
                                </form>
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


    {{-- <script>
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
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js"></script> --}}
</body>

</html>
