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

@endphp
<style>
    .footer-v5 {
        background: <?php echo $template_setting['polianna_footer_background']; ?> !important;
    }
    .footer-v5 .__footer-menu{
      list-style: none !important;
    }

    footer .row .footer-title {
        color: <?php echo $template_setting['polianna_footer_title_color']; ?> !important;
    }

    footer .row .foot_link {
        color: <?php echo $template_setting['polianna_footer_text_color']; ?> !important;
    }

</style>
<footer class="footer-v5 wow animate__fadeInUp" data-wow-duration="1s">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="footer-about mb-4">
                        <a class="f-logo" href="{{ route('home') }}"><img class="img-fluid"
                                src="{{ $template_setting['polianna_footer_logo'] }}" /></a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Bibendum est ultricies integer quis. Iaculis urna id</p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-6 offset-lg-2">
                    <h5 class="footer-title text-uppercase">quick links</h5>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-8">
                            <ul class="__footer-menu row mb-4">
                                <li class="col-6"><a class="text-uppercase foot_link"
                                        href="{{ route('home') }}">home</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">gallery</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">about</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">pages</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">shop</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">blog</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link"
                                        href="{{ route('menu') }}">menu</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link"
                                        href="{{ route('contact') }}">contact</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">support</a></li>
                                <li class="col-6"><a class="text-uppercase foot_link" href="">reservation</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="__social-links mb-4">
                                <a class="bg-facebook" href="{{ $social_site['polianna_facebook_id'] }}"><i
                                        class="fab fa-facebook-f"></i><span>Facebook</span></a>
                                <a class="bg-twitter" href="{{ $social_site['polianna_twitter_username'] }}"><i
                                        class="fab fa-twitter"></i><span>Twitter</span></a>
                                <a class="bg-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}"><i
                                        class="fab fa-linkedin"></i><span>Linkedin</span></a>
                                <a class="bg-instagram" href="{{ $social_site['polianna_youtube_id'] }}"><i
                                        class="fab fa-youtube"></i><span>Youtube</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <p>Copyright © 2021 Star Kebab Tenterden</p>
    </div>
</footer>
<a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
