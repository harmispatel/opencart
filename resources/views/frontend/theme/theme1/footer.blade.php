@php
    $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $social = session('social_site');
    $social_site = isset($social) ? $social : '#';

    $store_set = session('store_settings');
    $store_setting = isset($store_set) ? $store_set : '';
@endphp

<style>
    footer .info-group
    {
        background: <?php echo $template_setting['polianna_footer_background']; ?> !important;
    }

    footer .info-group .row .title
    {
        color: <?php echo $template_setting['polianna_footer_title_color']; ?> !important;
    }

    footer .info-group .row .foot_content,.foot_link
    {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    }
</style>

{{-- Footer --}}
<footer class="footer wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container info-group wow animate__fadeInUp" data-wow-duration="1s">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-red">Our Address</strong>
                <p class="foot_content"><i class="fa fa-address-card"></i>&nbsp; {{ $store_setting['config_address'] }}</p>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item">
                <strong class="title top-divider-green">Contact Info</strong>
                <a class="foot_link" href="mailto:{{ $store_setting['config_email'] }}"><i class="fa fa-envelope"></i>&nbsp; {{ $store_setting['config_email'] }}</a>
                <a class="foot_link" href="tel:{{  $store_setting['config_telephone'] }}"><i class="fa fa-phone-alt"></i>&nbsp; {{  $store_setting['config_telephone'] }}</a>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item">
                <strong class="title top-divider-orange">Our Reservation</strong>
                <p class="foot_content">You can make a reservation online by <br> clicking on find table link.</p>
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
