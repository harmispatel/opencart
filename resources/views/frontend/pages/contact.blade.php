<!doctype html>
<html>
<style>
    #map {
        width: 100%;
        height: 400px;
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
                <div id="map" class=""></div>
            </div>
        </div>
        <div class="contact-info">
        <div class="row">
        <div class="col-md-6 contact-info-left">
        <div class="map-info">
        <h3>Get Directions</h3>
        <form>
        <div class="login-details-inr fa fa-crosshairs w-100">
        <input placeholder="Enter your location" type="text" name="map" value="" class="w-100">
        </div>
        <button class="btn map-bt w-100">GET DIRECTIONS</button>
        </form>
        <div class="shop-location text-center">
        <h2>Demo Pizza &amp; Kebab</h2>
        <p>abcd <br>EN8 0LG</p>
        <span><b>Tel : </b> 01291630436</span>
        <span><b>Tel 2 : </b >01291630436</span>
        </div>
        <div class="contact-logo text-center">
        <img src="./assets/img/logo/logo.svg">
        </div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="contact-details">
        <h3>Contact us form</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="login-details-inr fa fa-envelope w-100">
                <select name="name" class="w-100" placeholder="Title" style="width: 100%;border-radius:0;">
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
        <input placeholder="Name" type="text" name="name" value="" class="w-50">
        <input placeholder="Surname" type="text" name="surname" value="" class="w-50">
        </div>
        <div class="login-details-inr fa fa-envelope w-100">
        <input placeholder="Email address" type="text" name="email" value="" class="w-100">
        </div>
        <div class="login-details-inr fa fa-phone-alt w-100">
        <input placeholder="phone number" type="text" name="email" value="" class="w-100">
        </div>
        <div class="login-details-inr fa fa-file-alt w-100">
        <textarea name="enquiry" placeholder="Your enquiry" cols="40" rows="7" spellcheck="false" class="w-100 p-2"></textarea>
        </div>
        <div class="g-recaptcha login-details-inr" data-sitekey="your_site_key"></div>
        <div class="submit-bt">
        <button class="btn sub-bt w-100">SUBMIT</button>
        </div>
        </form>
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


    <script>
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
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>
