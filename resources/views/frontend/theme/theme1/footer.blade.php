@php
    $template_setting = session('template_settings');
    $social_site = session('social_site');
    $store_setting = session('store_settings');
@endphp

{{-- Footer --}}
<footer class="footer wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container info-group wow animate__fadeInUp" data-wow-duration="1s">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-red">Our Address</strong>
                <p><i class="fa fa-address-card"></i>&nbsp; {{ $store_setting['config_address'] }}</p>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item">
                <strong class="title top-divider-green">Contact Info</strong>
                <a href="mailto:{{ $store_setting['config_email'] }}"><i class="fa fa-envelope"></i>&nbsp; {{ $store_setting['config_email'] }}</a>
                <a href="tel:{{  $store_setting['config_telephone'] }}"><i class="fa fa-phone-alt"></i>&nbsp; {{  $store_setting['config_telephone'] }}</a>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item">
                <strong class="title top-divider-orange">Our Reservation</strong>
                <p>You can make a reservation online by <br> clicking on find table link.</p>
            </div>
        </div>
    </div>
    <a class="f-logo" href="">
        <img class="img-fluid" src="{{ $template_setting['polianna_main_logo'] }}"/>
    </a>
    <ul class="social-links">
        <li>
            <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
        </li>
    </ul>
    <div class="copyright">
        <p>Copyright © 2021 Star Kebab Tenterden</p>
    </div>
</footer>
{{-- End Footer --}}

<a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
