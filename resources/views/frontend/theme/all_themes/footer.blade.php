{{--
    THIS IS LAYOUT(THEME) 1 FOOTER PAGE FRONTEND DESIGN
    ----------------------------------------------------------------------------------------------
    footer.blade.php
    It Displayed Layout(Theme) 1 Foooter
    ----------------------------------------------------------------------------------------------
--}}

@php
    
    // Get Current URL
    $currentURL = URL::to("/");

    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];

    // Get Current Footer ID & Footer Settings
    $current_footer_id = layoutID($currentURL,'footer_id');
    $footer_id = $current_footer_id['footer_id'];
    $store_footer_settings = storeLayoutSettings($footer_id,$front_store_id,'footer_settings','footer_id');

    // Social Site Settings
    $social_site = isset($store_data['social_settings']) ? $store_data['social_settings'] : '';


    // Store Settings
    $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

    // Store Logo
    $store_logo = isset($store_setting['config_logo']) ? $store_setting['config_logo'] : '';

    // Get Open-Close Time
    $openclose = openclosetime();

    // Get Current General Settings
    $store_general_settings = storeLayoutSettings('',$front_store_id,'general_settings','');

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';

    // Copyright Dynamic
    $copyright = (isset($store_general_settings['general_copyright_text'])) ? $store_general_settings['general_copyright_text'] : ''

@endphp


{{-- CSS --}}
    {{-- FOOTER --}}
    {{------------------------------------------------------------------------------------------------}}
        {{-- Footer 1 --}}
        <?php
            if($footer_id == 1)
            {
        ?>
                <style>
                    .footer .info-group
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_color'])) ? $store_footer_settings['footer_background_color'] : '' ?>;
                    }

                    .footer .info-group:hover
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_hover_color'])) ? $store_footer_settings['footer_background_hover_color'] : '' ?>;
                    }

                    .footer .info-group .input-group-item .title, .footer .info-group .input-group-item p   i, .footer .info-group .input-group-item a i
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }

                    .footer .info-group:hover .input-group-item .title
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Footer 2 --}}
        <?php
            if($footer_id == 2)
            {
        ?>
                <style>
                    .footer-v2
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_color'])) ? $store_footer_settings['footer_background_color'] : '' ?>;
                    }

                    .footer-v2:hover
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_hover_color'])) ? $store_footer_settings['footer_background_hover_color'] : '' ?>;
                    }

                    .footer-v2:hover .footer-content .footer-title
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }

                    .footer-v2 .footer-content .footer-title
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }

                    .footer-v2 .footer-content .social-links a
                    {
                        background-color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }

                    .footer-v2:hover .footer-content .social-links a
                    {
                        background-color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }
                </style>
        <?php
            }
        ?>

        {{-- Footer 3 --}}
        <?php
            if($footer_id == 3)
            {
        ?>
                <style>
                    .footer-v3
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_color'])) ? $store_footer_settings['footer_background_color'] : '' ?>;
                    }

                    .footer-v3:hover
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_hover_color'])) ? $store_footer_settings['footer_background_hover_color'] : '' ?>;
                    }

                    .footer-v3 .footer-top .footer-title, .footer-v3 .footer-bottom p
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }


                    .footer-v3:hover .footer-top .footer-title, .footer-v3:hover .footer-bottom p
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }

                </style>
        <?php
            }
        ?>

        {{-- Footer 4 --}}
        <?php
            if($footer_id == 4)
            {
        ?>
                <style>
                    .footer-v4
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_color'])) ? $store_footer_settings['footer_background_color'] : '' ?>;
                    }

                    .footer-v4:hover
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_hover_color'])) ? $store_footer_settings['footer_background_hover_color'] : '' ?>;
                    }

                    .footer-v4 .footer-top .__menu li a, .footer-v4 .footer-top .__social-links a
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }

                    .footer-v4:hover .footer-top .__menu li a, .footer-v4:hover .footer-top .__social-links a
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }

                </style>
        <?php
            }
        ?>

        {{-- Footer 5 --}}
        <?php
            if($footer_id == 5)
            {
        ?>
                <style>
                    .footer-v5
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_color'])) ? $store_footer_settings['footer_background_color'] : '' ?>;
                    }

                    .footer-v5:hover
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_hover_color'])) ? $store_footer_settings['footer_background_hover_color'] : '' ?>;
                    }

                    .footer-v5:hover .footer-title, .footer-v5:hover .copyright p
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }

                    .footer-v5 .footer-title, .footer-v5 .copyright p
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }

                </style>
        <?php
            }
        ?>

        {{-- Footer 6 --}}
        <?php
            if($footer_id == 6)
            {
        ?>
                <style>
                    .footer-v6 .footer-top
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_color'])) ? $store_footer_settings['footer_background_color'] : '' ?>;
                    }

                    .footer-v6 .footer-top:hover
                    {
                        background: <?php echo (isset($store_footer_settings['footer_background_hover_color'])) ? $store_footer_settings['footer_background_hover_color'] : '' ?>;
                    }

                    .footer-v6 .footer-top .__footer-title
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_color'])) ? $store_footer_settings['footer_link_color'] : '' ?>;
                    }

                    .footer-v6 .footer-top:hover .__footer-title
                    {
                        color: <?php echo (isset($store_footer_settings['footer_link_hover_color'])) ? $store_footer_settings['footer_link_hover_color'] : '' ?>;
                    }

                    .footer-v6 .footer-top .__btn-top
                    {
                        background: transparent url("<?php echo get_css_url().'public/admin/footer-top-divider.svg' ?>") no-repeat center center;
                    }

                </style>
        <?php
            }
        ?>
    {{------------------------------------------------------------------------------------------------}}
    {{-- END FOOTER --}}
{{-- END CSS --}}


{{-- FOOTER SECTION --}}

    {{-- FOOTER 1 --}}
    @if ($footer_id == 1)
        <footer class="footer wow animate__fadeInUp" data-wow-duration="1s">
            <div class="container info-group wow animate__fadeInUp" data-wow-duration="1s">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 input-group-item"><strong class="title top-divider-red">Our Address</strong>
                        <p class="foot_content"><i class="fa fa-address-card"></i>&nbsp; {{ isset($store_setting['config_address']) ? $store_setting['config_address'] : '' }}</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 input-group-item">
                        <strong class="title top-divider-green">Contact Info</strong>
                        <a class="foot_link" href="mailto:{{ isset($store_setting['config_email']) ? $store_setting['config_email'] : '' }}"><i class="fa fa-envelope"></i>&nbsp; {{ isset($store_setting['config_email']) ? $store_setting['config_email'] : '' }}</a>
                        <a class="foot_link" href="tel:{{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}"><i class="fa fa-phone-alt"></i>&nbsp; {{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}</a>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 input-group-item">
                        <strong class="title top-divider-orange">Our Reservation</strong>
                        <p class="foot_content">You can make a reservation online by <br> clicking on find table link.</p>
                    </div>
                </div>
            </div>
            <a class="f-logo" href="">
                <img class="img-fluid" src="{{ $store_logo }}" alt="footer_logo" style="max-width: 125px;" />
            </a>
            <ul class="social-links">
                @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))
                    <li>
                        <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                    </li>
                @endif  

                @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                    <li>
                        <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                    </li>
                @endif

                @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                    <li>
                        <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                    </li>
                @endif

                @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                    <li>
                        <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                    </li>
                @endif

                @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))                                
                    <li>
                        <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                    </li>
                @endif
            </ul>
            <div class="copyright">
                <p>{{ $copyright }}</p>
            </div>
        </footer>
    @endif
    {{-- END FOOTER 1 --}}

    {{-- FOOTER 2 --}}
    @if ($footer_id == 2)
        <footer class="footer-v2 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="footer-content">
                <div class="container ">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <a class="f-logo" href="{{ route('home') }}">
                                <img class="img-fluid" src="{{ $store_logo }}" alt="footer_logo" style="max-width: 125px;" />
                            </a>

                            <p class="foot_link">Pizza is the topmost liked food in the world. Today you can find pizza in almost every corner of the world.</p>

                            <div class="social-links">
                                @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))                                    
                                    <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                                @endif
                                
                                @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                                @endif

                                @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))
                                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                                @endif

                                @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                                @endif

                                @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="contact-list">
                                <h5 class="footer-title  text-uppercase">contacts</h5>
                                <p class="foot_link">Address :  {{ isset($store_setting['config_address']) ? $store_setting['config_address'] : '' }}</p>
                                <a class="foot_link" href="tel:{{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}">Phone: {{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}</a>
                                <a class="foot_link" href="mailto:{{ isset($store_setting['config_email']) ? $store_setting['config_email'] : '' }}">Email: {{ isset($store_setting['config_email']) ? $store_setting['config_email'] : '' }}</a>
                            </div>
                        </div>
                    
                        <div class="col-sm-12 col-md-4">
                            <h5 class="footer-title  text-uppercase">quick links</h5>
                            <ul class="row foot_link quick-links ">
                                <li class="col-6">
                                    <a class="text-uppercase foot_link" href="{{ route('home') }}">home</a>
                                </li>
                                <li class="col-6">
                                    <a class="text-uppercase foot_link" href="#photo-gallary">gallery</a>
                                </li>
                                <li class="col-6">
                                    <a class="text-uppercase foot_link" href="{{ route('menu') }}">shop</a>
                                </li>
                                <li class="col-6">
                                    <a class="text-uppercase foot_link" href="{{ route('menu') }}">menu</a>
                                </li>
                                <li class="col-6">
                                    <a class="text-uppercase foot_link" href="{{ route('contact') }}">contact</a>
                                </li>
                                <li class="col-6">
                                    <a class="text-uppercase foot_link" href="#reservation">reservation</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-copyright">
                <div class="container">
                    <p>{{ $copyright }}</p>
                </div>
            </div>
        </footer>
    @endif
    {{-- END FOOTER 2 --}}

    {{-- FOOTER 3 --}}
    @if ($footer_id == 3)
        <footer class="footer-v3 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="footer-top info-group">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-3">
                            <div class="footer-about">
                                <h5 class="footer-title text-capitalize title">{{ isset($store_setting['config_name']) ? $store_setting['config_name'] : '' }}</h5>
                                <p class="foot_content">Pizza is the topmost liked food in the world. Today you can find pizza in almost every corner of the world. This traditional Italian dish is made of flattened round dough topped with cheese, and tomatoes, and additionally garnished with basil, olives, and oregano.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-9">
                            <h5 class="footer-title text-capitalize title">get in touch</h5>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="__info-item"><strong>Office Address</strong>
                                    <p class="foot_content">{{ isset($store_setting['config_address']) ? $store_setting['config_address'] : '' }}</p>
                                    </div>
                                    <div class="__info-item"><strong>Phone Number</strong><a href="tel:{{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}">{{ isset($store_setting['config_telephone']) ? $store_setting['config_telephone'] : '' }}</a></div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="__info-item">
                                        <strong>E-mail Address</strong>
                                        <a href="mailto:{{ isset($store_setting['config_email']) ? $store_setting['config_email'] : '' }}">{{ isset($store_setting['config_email']) ? $store_setting['config_email'] : '' }}</a>
                                    </div>
                                    <div class="__info-item">
                                        <strong>Online Follow Us</strong>
                                        <div class="__social-links">
                                            @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))                                    
                                                <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                                            @endif
                                            
                                            @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                                <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                                            @endif

                                            @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))
                                                <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                                            @endif

                                            @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                                <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                                            @endif

                                            @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                                                <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>{{ $copyright }}</p>
            </div>
        </footer>
    @endif
    {{-- END FOOTER 3 --}}

    {{-- FOOTER 4 --}}
    @if ($footer_id == 4)
        <footer class="footer-v4 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="footer-top">
                <div class="container">
                    <ul class="__menu">
                        <li>
                            <a class="text-uppercase foot_link" href="{{ route('home') }}">home</a>
                        </li>
                        <li>
                            <a class="text-uppercase foot_link" href="{{ route('member') }}">member</a>
                        </li>
                        <li>
                            <a class="text-uppercase foot_link" href="{{ route('menu') }}">menu</a>
                        </li>
                        <li>
                            <a class="text-uppercase foot_link" href="{{ route('checkout') }}">check out</a>
                        </li>
                        <li>
                            <a class="text-uppercase foot_link" href="{{ route('contact') }}">contact us</a>
                        </li>
                    </ul>

                    <div class="__social-links">
                        @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))                                    
                            <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                        @endif
                        
                        @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                            <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                        @endif

                        @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))
                            <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                        @endif

                        @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                            <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                        @endif

                        @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                            <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                        @endif
                    </div>
                </div>
                <a class="f-logo" href="{{ route('home') }}">
                    <img class="img-fluid" src="{{$store_logo }}" alt="footer_logo" style="max-width: 125px;" />
                </a>
            </div>
            <div class="footer-bottom">
                <p>{{ $copyright }}</p>
            </div>
        </footer>
    @endif
    {{-- END FOOTER 4 --}}


    {{-- FOOTER 5 --}}
    @if ($footer_id == 5)
        <footer class="footer-v5 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="footer-about mb-4">
                                <a class="f-logo" href="{{ route('home') }}">
                                    <img class="img-fluid" src="{{ $store_logo }}" alt="footer_logo" style="max-width: 125px;" />
                                </a>
                                <p>Pizza is the topmost liked food in the world. Today you can find pizza in almost every corner of the world. This traditional Italian dish is made of flattened round dough topped with cheese, and tomatoes, and additionally garnished with basil, olives, and oregano.</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-6 offset-lg-2">
                            <h5 class="footer-title text-uppercase">quick links</h5>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-8">
                                    <ul class="__footer-menu row mb-4">
                                        <li class="col-6">
                                            <a class="text-uppercase foot_link" href="{{ route('home') }}">home</a>
                                        </li>
                                        <li class="col-6">
                                            <a class="text-uppercase foot_link" href="#photo-gallary">gallery</a>
                                        </li>
                                        <li class="col-6">
                                            <a class="text-uppercase foot_link" href="{{ route('menu') }}">shop</a>
                                        </li>
                                        <li class="col-6">
                                            <a class="text-uppercase foot_link" href="{{ route('menu') }}">menu</a>
                                        </li>
                                        <li class="col-6">
                                            <a class="text-uppercase foot_link" href="{{ route('contact') }}">contact</a>
                                        </li>
                                        <li class="col-6">
                                            <a class="text-uppercase foot_link" href="#reservation">reservation</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4">
                                    <div class="__social-links mb-4">
                                        @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))                                    
                                            <a class="bg-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank">
                                                <i  class="fab fa-facebook-f"></i><span>Facebook</span>
                                            </a>
                                        @endif
                                        
                                        @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                                            <a class="bg-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank">
                                                <i class="fab fa-twitter"></i><span>Twitter</span>
                                            </a>
                                        @endif

                                        @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))
                                            <a class="bg-instagram" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank">
                                                <i class="fab fa-youtube"></i><span>Youtube</span>
                                            </a>
                                        @endif

                                        @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                                            <a class="bg-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank">
                                                <i class="fab fa-linkedin"></i><span>Linkedin</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>{{ $copyright }}</p>
            </div>
        </footer>
    @endif
    {{-- END FOOTER 5 --}}

    {{-- FOOTER 6 --}}
    @if ($footer_id == 6)
        <footer class="footer-v6 wow animate__fadeInUp" data-wow-duration="1s">
            <div class="footer-top backgroundcolor">
                <h4 class="__footer-title text-uppercase">thank you and welcome back!</h4>
                <p class="copyright">{{ $copyright }}</p>
                <div class="__btn-top">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
            <div class="footer-bottom">
                <a class="f-logo">
                    <img class="img-fluid" src="{{ $store_logo }}" alt="footer_logo" style="max-width: 125px;"/>
                </a>
                <div class="__social-links">
                    @if (isset($social_site['polianna_facebook_id']) && !empty($social_site['polianna_facebook_id']))                                    
                        <a class="fab fa-facebook-f" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                    @endif
                    
                    @if (isset($social_site['polianna_twitter_username']) && !empty($social_site['polianna_twitter_username']))
                        <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}" target="_blank"></a>
                    @endif

                    @if (isset($social_site['polianna_youtube_id']) && !empty($social_site['polianna_youtube_id']))
                        <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                    @endif

                    @if (isset($social_site['polianna_linkedin_id']) && !empty($social_site['polianna_linkedin_id']))
                        <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                    @endif

                    @if (isset($social_site['polianna_gplus_id']) && !empty($social_site['polianna_gplus_id']))
                        <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}" target="_blank"></a>
                    @endif
                </div>
            </div>
        </footer>
    @endif
    {{-- END FOOTER 6 --}}

{{-- END FOOTER SECTION --}}



<a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
