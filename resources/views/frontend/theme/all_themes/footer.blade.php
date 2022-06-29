<!--
    THIS IS LAYOUT(THEME) 1 FOOTER PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    footer.blade.php
    It Displayed Layout(Theme) 1 Foooter
    ----------------------------------------------------------------------------------------------
-->

@php
    
    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = layoutID($currentURL,'header_id');
    $theme_id = $current_theme_id['header_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings & Other
    $store_theme_settings ='';
    //End Get Store Settings & Theme Settings & Other

    // Template Settings
    $template_setting ='';
    // End Template Settings

    // Social Site Settings
    $social_site = '';
    // End Social Site Settings

    // Store Settings
    $store_setting = '';
    // End Store Settings

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

@endphp


<!-- Custom CSS -->
<style>
    
</style>
<!-- End Custom CSS -->


<!-- Footer -->
<footer class="footer wow animate__fadeInUp" data-wow-duration="1s">
    <div class="container info-group wow animate__fadeInUp" data-wow-duration="1s">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-red">Our Address</strong>
                <p class="foot_content"><i class="fa fa-address-card"></i>&nbsp; sdsd</p>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item">
                <strong class="title top-divider-green">Contact Info</strong>
                <a class="foot_link" href="mailto:as"><i class="fa fa-envelope"></i>&nbsp; sas</a>
                <a class="foot_link" href="tel:212"><i class="fa fa-phone-alt"></i>&nbsp; sdsd</a>
            </div>
            <div class="col-12 col-sm-12 col-md-4 input-group-item">
                <strong class="title top-divider-orange">Our Reservation</strong>
                <p class="foot_content">You can make a reservation online by <br> clicking on find table link.</p>
            </div>
        </div>
    </div>
    <a class="f-logo" href="">
        <img class="img-fluid" src="" alt="footer_logo" />
    </a>
    <ul class="social-links">
        <li>
            <a class="fab fa-facebook" href="" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-twitter" href="" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-google" href="mailto:" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-linkedin" href="" target="_blank"></a>
        </li>
        <li>
            <a class="fab fa-youtube" href="" target="_blank"></a>
        </li>
    </ul>
    <div class="copyright">
        <p>Copyright © 2021 Star Kebab Tenterden</p>
    </div>
</footer>
<!-- End Footer -->

<a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
