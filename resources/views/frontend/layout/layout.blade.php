{{--
    THIS IS LAYOUT PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    layout.blade.php
    It's Included Some layout like..
    - head
    - header
    - layout
    - footer
    - script
    ----------------------------------------------------------------------------------------------
--}}


@php

    // Current URL
    $currentURL = URL::to("/");

    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);

    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];

    // Get Current Header ID & Header Settings
    $current_header_id = layoutID($currentURL,'header_id');
    $header_id = $current_header_id['header_id'];
    $store_header_settings = storeLayoutSettings($header_id,$front_store_id,'header_settings','header_id');

    // Get Current Slider ID & Slider Settings
    $current_slider_id = layoutID($currentURL,'slider_id');
    $slider_id = $current_slider_id['slider_id'];
    $store_slider_settings = storeLayoutSettings($slider_id,$front_store_id,'slider_settings','slider_id');

    // Get Current About ID & About Settings
    $current_about_id = layoutID($currentURL,'about_id');
    $about_id = $current_about_id['about_id'];
    $store_about_settings = storeLayoutSettings($about_id,$front_store_id,'about_settings','about_id');

    // Get Current BestCategory ID & BestCategory Settings
    $current_bestcategory_id = layoutID($currentURL,'bestcategory_id');
    $bestcategory_id = $current_bestcategory_id['bestcategory_id'];
    $store_bestcategory_settings = storeLayoutSettings($bestcategory_id,$front_store_id,'bestcategory_settings','bestcategory_id');

    // Get Current PopularFood ID & PopularFood Settings
    $current_popularfood_id = layoutID($currentURL,'popularfood_id');
    $popularfood_id = $current_popularfood_id['popularfood_id'];
    $store_popularfood_settings = storeLayoutSettings($popularfood_id,$front_store_id,'popularfood_settings','popularfood_id');

    // Get Current Reviews ID & Reviews Settings
    $current_review_id = layoutID($currentURL,'review_id');
    $review_id = $current_review_id['review_id'];
    $store_review_settings = storeLayoutSettings($review_id,$front_store_id,'review_settings','reviews_id');

    // Get Current Reservation ID & Reservation Settings
    $current_reservation_id = layoutID($currentURL,'reservation_id');
    $reservation_id = $current_reservation_id['reservation_id'];
    $store_reservation_settings = storeLayoutSettings($reservation_id,$front_store_id,'reservation_settings','reservation_id');

    // Get Current OpenHours ID & OpenHours Settings
    $current_openhour_id = layoutID($currentURL,'openhour_id');
    $openhour_id = $current_openhour_id['openhour_id'];
    $store_openhour_settings = storeLayoutSettings($openhour_id,$front_store_id,'openhour_settings','openhours_id');

    // Get Current Footer ID & Footer Settings
    $current_footer_id = layoutID($currentURL,'footer_id');
    $footer_id = $current_footer_id['footer_id'];
    $store_footer_settings = storeLayoutSettings($footer_id,$front_store_id,'footer_settings','footer_id');

    // Get Current General Settings
    $store_general_settings = storeLayoutSettings('',$front_store_id,'general_settings','');

@endphp

<!doctype html>
<html>
<head>
    {{-- Include Style --}}
    @include('frontend.include.head')
    {{-- End Include Style --}}


    {{-- CUSTOM CSS  --}}
        {{-- HEADER CSS --}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- Header 1 --}}
            <?php
                if($header_id == 1)
                {
            ?>
                    <style>
                        /* Menu Background Color */
                        .header .header-bottom
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                        }

                        /* Menu Links Color */
                        .header .header-bottom .menu li a, .menu-shopping-cart .price-box strong, .menu-shopping-cart .number i, .menu-shopping-cart .price-box .price h3, .menu-shopping-cart .price-box .price h3 span
                        {
                            color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }

                        /* Menu Active Button Color */
                        .header .header-bottom .menu li.active, .header .header-bottom .menu li.active:before, .header .header-bottom .menu li:hover:before, .header .header-bottom .menu li.active:after, .header .header-bottom .menu li:hover:after
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_button_color']))? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }

                        /* Menu Active Buttons Links Color */
                        .header .header-bottom .menu li.active a, .header .header-bottom .menu li a:hover,.header .header-bottom .menu li:hover a
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                        }

                        /* Menu Active Button Hover Color */
                        .header .header-bottom .menu li:hover
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_button_color']))? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Header 2 --}}
            <?php
                if($header_id == 2)
                {
            ?>
                    <style>
                        /* Menu Background Color */
                        .header-v2 .header-bottom
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                        }

                        /* Menu Link Color */
                        .header-v2 .header-bottom .menu li a, .header-v2 .header-bottom .authentication-links li a span, .header-v2 .header-bottom .menu-shopping-cart .price-box strong, .header-v2 .header-bottom .menu-shopping-cart .price-box i, .header-v2 .header-bottom .menu-shopping-cart .price-box span
                        {
                            color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }
                        .authentication-links li a span,.header-v2 .header-bottom .menu-shopping-cart .price-box strong,.header-v2 .header-bottom .menu-shopping-cart .price-box .price i, .header-v2 .header-bottom .menu-shopping-cart .price-box .price span
                        {
                            font-size: 15px!important;
                        }

                        /* Menu Button Color */
                        .header-v2 .header-bottom .menu li:hover:after, .header-v2 .header-bottom .menu li.active:after, .header-v2 .header-bottom .menu-shopping-cart i.fa-shopping-basket
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                        .header-v2 .header-bottom .authentication-links li a i
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                        .menu-shopping-cart .number span
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                            background: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                        }

                        /* Menu Button Active Link Color */
                        .header-v2 .header-bottom .menu li.active a, .header-v2 .header-bottom .menu li a:hover,.header-v2 .header-bottom .menu li:hover a, .header-v2 .header-bottom .menu-shopping-cart i.fa-shopping-basket
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Header 3 --}}
            <?php
                if($header_id == 3)
                {
            ?>
                    <style>
                        /* Menu Background Color */
                        .header-v3 .header-bottom
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                        }

                        /* Menu Link Color */
                        .header-v3 .header-bottom .menu li a
                        {
                            color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }

                        /* Menu Active Button Color */
                        .header-v3 .header-bottom .menu li:hover a, .header-v3 .header-bottom .menu li.active a
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Header 4 --}}
            <?php
                if($header_id == 4)
                {
            ?>
                    <style>
                        /* Menu Background Color */
                        .header-v4 .header-bottom
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                        }

                        /* Menu Link Color */
                        .header-v4 .header-bottom .menu li a
                        {
                            color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }

                        /* Menu Button Color */
                        .header-v4 .header-bottom .menu li.active a, .header-v4 .header-bottom .menu li:hover a, .header-v4 .header-bottom .__btn-group a.__purple, .header-v4 .header-bottom .__btn-group a.__green
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }

                        /* Menu Button Active Link Color */
                        .header-v4 .header-bottom .menu li.active a, .header-v4 .header-bottom .menu li:hover a, .header-v4 .header-bottom .__btn-group a i, .header-v4 .header-bottom .__btn-group a.__purple, .header-v4 .header-bottom .__btn-group a.__green
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                        }

                        .productcountitem span{
                            background-color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Header 5 --}}
            <?php
                if($header_id == 5)
                {
            ?>
                    <style>
                        /* Menu Background Color */
                        .header-v5 .header-bottom
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                        }
                        .header-v5 .header-bottom .menu-shopping-cart .number span
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                            background-color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }

                        /* Menu Links Color */
                        .header-v5 .header-bottom .menu li a, .header-v5 .header-bottom .menu-shopping-cart .price-box strong, .header-v5 .header-bottom .menu-shopping-cart .price-box .price i, .header-v5 .header-bottom .menu-shopping-cart .price-box .price span
                        {
                            color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }

                        /* Menu Button Color */
                        .header-v5 .header-bottom .menu li:hover a, .header-v5 .header-bottom .menu li.active a
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                        .header-v5 .header-bottom .menu-shopping-cart .number i
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }

                        /* Menu Buttons Text Color */
                        .header-v5 .header-bottom .menu li.active a,.header-v5 .header-bottom .menu li:hover a
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_text_color'])) ? $store_header_settings['menu_button_text_color'] : '' ?>!important;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Header 6 --}}
            <?php
                if($header_id == 6)
                {
            ?>
                    <style>
                        /* Menu Background Color */
                        .header-v6
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_background_color'])) ? $store_header_settings['menu_background_color'] : '' ?>!important;
                        }

                        /* Menu Links Color */
                        .header-v6 .header-center .menu li a, .header-v6 .header-bottom .working-time strong, .header-v6 .header-top .authentication-links li a span, .header-v6 .header-top .menu-shopping-cart .price-box strong, .header-v6 .header-top .menu-shopping-cart .price-box i, .header-v6 .header-top .menu-shopping-cart .price-box span
                        {
                            color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                        }
                        .header-v6 .header-top .menu-shopping-cart .number span
                        {
                            background-color: <?php echo (isset($store_header_settings['menu_text_color'])) ? $store_header_settings['menu_text_color'] : '' ?>!important;
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }

                        /* Menu Button Color */
                        .header-v6 .header-center .menu li.active a, .header-v6 .header-center .menu li:hover a, .header-v6 .header-bottom .working-time i, .header-v6 .header-top .authentication-links li a i, .header-v6 .header-top .menu-shopping-cart .number i
                        {
                            color: <?php echo (isset($store_header_settings['menu_button_color'])) ? $store_header_settings['menu_button_color'] : '' ?>!important;
                        }
                    </style>
            <?php
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END HEADER --}}



        {{-- SLIDER --}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- Slider 3 --}}
            <?php
                if($slider_id == 3)
                {
            ?>
                    <style>
                        .home-slide-v3
                        {
                            background: transparent url("<?php echo get_css_url().'public/admin/slide.jpg' ?>") no-repeat center center;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Slider 6 --}}
            <?php
                if($slider_id == 6)
                {
            ?>
                    <style>
                        .__btn-bottom
                        {
                            background: transparent url("<?php echo get_css_url().'public/admin/slider-bottom-divider.svg' ?>") no-repeat center center;
                        }
                    </style>
            <?php
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END SLIDER --}}



        {{-- ABOUT US --}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- About US 1--}}
            <?php
                $about_background_option = isset($store_about_settings['about_background_option']) ? $store_about_settings['about_background_option'] : '';
                if($about_id == 1)
                {
                    if($about_background_option == 1)
                    {
            ?>
                        <style>
                            .welcome{
                                background: url("<?php echo (isset($store_about_settings['about_background_image'])) ? $store_about_settings['about_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .welcome
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_color'])) ? $store_about_settings['about_background_color'] : '' ?>;
                            }

                            .welcome:hover
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_hover_color'])) ? $store_about_settings['about_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- About US 2--}}
            <?php
                if($about_id == 2)
                {
                    if($about_background_option == 1)
                    {
            ?>
                        <style>
                            .about-us{
                                background: url("<?php echo (isset($store_about_settings['about_background_image'])) ? $store_about_settings['about_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .about-us
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_color'])) ? $store_about_settings['about_background_color'] : '' ?>;
                            }

                            .about-us:hover
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_hover_color'])) ? $store_about_settings['about_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- About US 3--}}
            <?php
                if($about_id == 3)
                {
                    if($about_background_option == 1)
                    {
            ?>
                        <style>
                            .who-are-we{
                                background: url("<?php echo (isset($store_about_settings['about_background_image'])) ? $store_about_settings['about_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .who-are-we
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_color'])) ? $store_about_settings['about_background_color'] : '' ?>;
                            }

                            .who-are-we:hover
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_hover_color'])) ? $store_about_settings['about_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- About US 4--}}
            <?php
                if($about_id == 4)
                {
                    if($about_background_option == 1)
                    {
            ?>
                        <style>
                            .who-are-we-v4{
                                background: url("<?php echo (isset($store_about_settings['about_background_image'])) ? $store_about_settings['about_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .who-are-we-v4
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_color'])) ? $store_about_settings['about_background_color'] : '' ?>;
                            }

                            .who-are-we-v4:hover
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_hover_color'])) ? $store_about_settings['about_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- About US 5--}}
            <?php
                if($about_id == 5)
                {
            ?>
                    <style>
                        .who-are-we-v5
                        {
                            background: transparent url("<?php echo get_css_url().'public/admin/dots.svg' ?>") no-repeat 120px bottom;
                        }
                    </style>
            <?php
                    if($about_background_option == 1)
                    {
            ?>
                        <style>
                            .who-are-we-v5{
                                background: url("<?php echo (isset($store_about_settings['about_background_image'])) ? $store_about_settings['about_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .who-are-we-v5
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_color'])) ? $store_about_settings['about_background_color'] : '' ?>;
                            }

                            .who-are-we-v5:hover
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_hover_color'])) ? $store_about_settings['about_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- About US 6--}}
            <?php
                if($about_id == 6)
                {
                    if($about_background_option == 1)
                    {
            ?>
                        <style>
                            .who-are-we-v6{
                                background: url("<?php echo (isset($store_about_settings['about_background_image'])) ? $store_about_settings['about_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .who-are-we-v6
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_color'])) ? $store_about_settings['about_background_color'] : '' ?>;
                            }

                            .who-are-we-v6:hover
                            {
                                background-color: <?php echo (isset($store_about_settings['about_background_hover_color'])) ? $store_about_settings['about_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END ABOUT US --}}



        {{-- CATEGORY--}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- Category 1 --}}
            <?php
                $background_option = (isset($store_bestcategory_settings['bestcategory_background_option'])) ? $store_bestcategory_settings['bestcategory_background_option'] : '';
                if($bestcategory_id == 1)
                {
                    if($background_option == 1)
                    {
            ?>
                        <style>
                            .categories{
                                background: url("<?php echo (isset($store_bestcategory_settings['bestcategory_background_image'])) ? $store_bestcategory_settings['bestcategory_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .categories
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_color'])) ? $store_bestcategory_settings['bestcategory_background_color'] : '' ?>;
                            }

                            .categories:hover
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_hover_color'])) ? $store_bestcategory_settings['bestcategory_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Category 2 --}}
            <?php
                if($bestcategory_id == 2)
                {
                    if($background_option == 1)
                    {
            ?>
                        <style>
                            .categories-v2{
                                background: url("<?php echo (isset($store_bestcategory_settings['bestcategory_background_image'])) ? $store_bestcategory_settings['bestcategory_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .categories-v2
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_color'])) ? $store_bestcategory_settings['bestcategory_background_color'] : '' ?>;
                            }

                            .categories-v2:hover
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_hover_color'])) ? $store_bestcategory_settings['bestcategory_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Category 3 --}}
            <?php
                if($bestcategory_id == 3)
                {
                    if($background_option == 1)
                    {
            ?>
                        <style>
                            .best-categories-icon{
                                background: url("<?php echo (isset($store_bestcategory_settings['bestcategory_background_image'])) ? $store_bestcategory_settings['bestcategory_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .best-categories-icon
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_color'])) ? $store_bestcategory_settings['bestcategory_background_color'] : '' ?>;
                            }

                            .best-categories-icon:hover
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_hover_color'])) ? $store_bestcategory_settings['bestcategory_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Category 4 --}}
            <?php
                if($bestcategory_id == 4)
                {
                    if($background_option == 1)
                    {
            ?>
                        <style>
                            .best-categories-v4{
                                background: url("<?php echo (isset($store_bestcategory_settings['bestcategory_background_image'])) ? $store_bestcategory_settings['bestcategory_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .best-categories-v4
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_color'])) ? $store_bestcategory_settings['bestcategory_background_color'] : '' ?>;
                            }

                            .best-categories-v4:hover
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_hover_color'])) ? $store_bestcategory_settings['bestcategory_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Category 5 --}}
            <?php
                if($bestcategory_id == 5)
                {
                    if($background_option == 1)
                    {
            ?>
                        <style>
                            .best-categories-v5
                            {
                                background: url("<?php echo (isset($store_bestcategory_settings['bestcategory_background_image'])) ? $store_bestcategory_settings['bestcategory_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .best-categories-v5
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_color'])) ? $store_bestcategory_settings['bestcategory_background_color'] : '' ?>;
                            }

                            .best-categories-v5:hover
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_hover_color'])) ? $store_bestcategory_settings['bestcategory_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Category 6 --}}
            <?php
                if($bestcategory_id == 6)
                {
                    if($background_option == 1)
                    {
            ?>
                        <style>
                            .popular-categories-v6
                            {
                                background: url("<?php echo (isset($store_bestcategory_settings['bestcategory_background_image'])) ? $store_bestcategory_settings['bestcategory_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-categories-v6
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_color'])) ? $store_bestcategory_settings['bestcategory_background_color'] : '' ?>;
                            }

                            .popular-categories-v6:hover
                            {
                                background-color: <?php echo (isset($store_bestcategory_settings['bestcategory_background_hover_color'])) ? $store_bestcategory_settings['bestcategory_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END CATEGORY --}}



        {{-- POPULAR FOOD--}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- Popular Food 1 --}}
            <?php
                $popularfood_background_option = (isset($store_popularfood_settings['popularfood_background_option'])) ? $store_popularfood_settings['popularfood_background_option'] : '';
                if($popularfood_id == 1)
                {
                    if($popularfood_background_option == 1)
                    {
            ?>
                        <style>
                            .popular-foods
                            {
                                background: url("<?php echo (isset($store_popularfood_settings['popularfood_background_image'])) ? $store_popularfood_settings['popularfood_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-foods
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_color'])) ? $store_popularfood_settings['popularfood_background_color'] : '' ?>;
                            }

                            .popular-foods:hover
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_hover_color'])) ? $store_popularfood_settings['popularfood_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Popular Food 2 --}}
            <?php
                if($popularfood_id == 2)
                {
                    if($popularfood_background_option == 1)
                    {
            ?>
                        <style>
                            .popular-foods-v2
                            {
                                background: url("<?php echo (isset($store_popularfood_settings['popularfood_background_image'])) ? $store_popularfood_settings['popularfood_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-foods-v2
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_color'])) ? $store_popularfood_settings['popularfood_background_color'] : '' ?>;
                            }

                            .popular-foods-v2:hover
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_hover_color'])) ? $store_popularfood_settings['popularfood_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Popular Food 3 --}}
            <?php
                if($popularfood_id == 3)
                {
                    if($popularfood_background_option == 1)
                    {
            ?>
                        <style>
                            .popular-foods-v3
                            {
                                background: url("<?php echo (isset($store_popularfood_settings['popularfood_background_image'])) ? $store_popularfood_settings['popularfood_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-foods-v3
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_color'])) ? $store_popularfood_settings['popularfood_background_color'] : '' ?>;
                            }

                            .popular-foods-v3:hover
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_hover_color'])) ? $store_popularfood_settings['popularfood_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Popular Food 4 --}}
            <?php
                if($popularfood_id == 4)
                {
                    if($popularfood_background_option == 1)
                    {
            ?>
                        <style>
                            .popular-foods-v4
                            {
                                background: url("<?php echo (isset($store_popularfood_settings['popularfood_background_image'])) ? $store_popularfood_settings['popularfood_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-foods-v4
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_color'])) ? $store_popularfood_settings['popularfood_background_color'] : '' ?>;
                            }

                            .popular-foods-v4:hover
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_hover_color'])) ? $store_popularfood_settings['popularfood_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Popular Food 5 --}}
            <?php
                if($popularfood_id == 5)
                {
                    if($popularfood_background_option == 1)
                    {
            ?>
                        <style>
                            .popular-foods-v5
                            {
                                background: url("<?php echo (isset($store_popularfood_settings['popularfood_background_image'])) ? $store_popularfood_settings['popularfood_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-foods-v5
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_color'])) ? $store_popularfood_settings['popularfood_background_color'] : '' ?>;
                            }

                            .popular-foods-v5:hover
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_hover_color'])) ? $store_popularfood_settings['popularfood_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Popular Food 6 --}}
            <?php
                if($popularfood_id == 6)
                {
                    if($popularfood_background_option == 1)
                    {
            ?>
                        <style>
                            .popular-foods-v6
                            {
                                background: url("<?php echo (isset($store_popularfood_settings['popularfood_background_image'])) ? $store_popularfood_settings['popularfood_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .popular-foods-v6
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_color'])) ? $store_popularfood_settings['popularfood_background_color'] : '' ?>;
                            }

                            .popular-foods-v6:hover
                            {
                                background-color: <?php echo (isset($store_popularfood_settings['popularfood_background_hover_color'])) ? $store_popularfood_settings['popularfood_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END POPULAR FOOD --}}



        {{-- REVIEWS --}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- Reviews 1 --}}
            <?php
                $review_background_option = (isset($store_review_settings['review_background_option'])) ? $store_review_settings['review_background_option'] : '';
                if($review_id == 1)
                {
                    if($review_background_option == 1)
                    {
            ?>
                        <style>
                            .user-comments
                            {
                                background: url("<?php echo (isset($store_review_settings['review_background_image'])) ? $store_review_settings['review_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .user-comments
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_color'])) ? $store_review_settings['review_background_color'] : '' ?>;
                            }

                            .user-comments:hover
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_hover_color'])) ? $store_review_settings['review_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Reviews 2 --}}
            <?php
                if($review_id == 2)
                {
                    if($review_background_option == 1)
                    {
            ?>
                        <style>
                            .user-comments-v2
                            {
                                background: url("<?php echo (isset($store_review_settings['review_background_image'])) ? $store_review_settings['review_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .user-comments-v2
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_color'])) ? $store_review_settings['review_background_color'] : '' ?>;
                            }

                            .user-comments-v2:hover
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_hover_color'])) ? $store_review_settings['review_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Reviews 3 --}}
            <?php
                if($review_id == 3)
                {
                    if($review_background_option == 1)
                    {
            ?>
                        <style>
                            .user-comments-v3
                            {
                                background: url("<?php echo (isset($store_review_settings['review_background_image'])) ? $store_review_settings['review_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .user-comments-v3
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_color'])) ? $store_review_settings['review_background_color'] : '' ?>;
                            }

                            .user-comments-v3:hover
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_hover_color'])) ? $store_review_settings['review_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Reviews 4 --}}
            <?php
                if($review_id == 4)
                {
                    if($review_background_option == 1)
                    {
            ?>
                        <style>
                            .user-comments-v4
                            {
                                background: url("<?php echo (isset($store_review_settings['review_background_image'])) ? $store_review_settings['review_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .user-comments-v4
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_color'])) ? $store_review_settings['review_background_color'] : '' ?>;
                            }

                            .user-comments-v4:hover
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_hover_color'])) ? $store_review_settings['review_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Reviews 5 --}}
            <?php
                if($review_id == 5)
                {
                    if($review_background_option == 1)
                    {
            ?>
                        <style>
                            .user-comments-v5
                            {
                                background: url("<?php echo (isset($store_review_settings['review_background_image'])) ? $store_review_settings['review_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .user-comments-v5
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_color'])) ? $store_review_settings['review_background_color'] : '' ?>;
                            }

                            .user-comments-v5:hover
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_hover_color'])) ? $store_review_settings['review_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>

            {{-- Reviews 6 --}}
            <?php
                if($review_id == 6)
                {
                    if($review_background_option == 1)
                    {
            ?>
                        <style>
                            .user-comments-v6
                            {
                                background: url("<?php echo (isset($store_review_settings['review_background_image'])) ? $store_review_settings['review_background_image'] : '' ?>") no-repeat center;
                                background-size: cover;
                            }
                        </style>
            <?php
                    }
                    else
                    {
            ?>
                        <style>
                            .user-comments-v6
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_color'])) ? $store_review_settings['review_background_color'] : '' ?>;
                            }

                            .user-comments-v6:hover
                            {
                                background-color: <?php echo (isset($store_review_settings['review_background_hover_color'])) ? $store_review_settings['review_background_hover_color'] : '' ?>;
                            }
                        </style>
            <?php
                    }
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END REVIEWS --}}



        {{-- RESERVATION --}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- Reservation 1 --}}
            <?php
                if($reservation_id == 1)
                {
            ?>
                    <style>
                        .reservation
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_color'])) ? $store_reservation_settings['reservation_background_color'] : '' ?>;
                        }

                        .reservation:hover
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_hover_color'])) ? $store_reservation_settings['reservation_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Reservation 2 --}}
            <?php
                if($reservation_id == 2)
                {
            ?>
                    <style>
                        .reservation-v2
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_color'])) ? $store_reservation_settings['reservation_background_color'] : '' ?>;
                        }

                        .reservation-v2:hover
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_hover_color'])) ? $store_reservation_settings['reservation_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Reservation 3 --}}
            <?php
                if($reservation_id == 3)
                {
            ?>
                    <style>
                        .reservation-v3
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_color'])) ? $store_reservation_settings['reservation_background_color'] : '' ?>;
                        }

                        .reservation-v3:hover
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_hover_color'])) ? $store_reservation_settings['reservation_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Reservation 4 --}}
            <?php
                if($reservation_id == 4)
                {
            ?>
                    <style>
                        .reservation-v4
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_color'])) ? $store_reservation_settings['reservation_background_color'] : '' ?>;
                        }

                        .reservation-v4:hover
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_hover_color'])) ? $store_reservation_settings['reservation_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Reservation 5 --}}
            <?php
                if($reservation_id == 5)
                {
            ?>
                    <style>
                        .reservation-v5
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_color'])) ? $store_reservation_settings['reservation_background_color'] : '' ?>;
                        }

                        .reservation-v5:hover
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_hover_color'])) ? $store_reservation_settings['reservation_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- Reservation 6 --}}
            <?php
                if($reservation_id == 6)
                {
            ?>
                    <style>
                        .reservation-v6
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_color'])) ? $store_reservation_settings['reservation_background_color'] : '' ?>;
                        }

                        .reservation-v6:hover
                        {
                            background-color: <?php echo (isset($store_reservation_settings['reservation_background_hover_color'])) ? $store_reservation_settings['reservation_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END RESERVATION --}}



        {{-- OPENHOURS --}}
        {{------------------------------------------------------------------------------------------------}}
            {{-- OpenHours 1 --}}
            <?php
                if($openhour_id == 1)
                {
            ?>
                    <style>
                        .opening-hours
                        {
                            background: url("<?php echo (isset($store_openhour_settings['openhour_background_image'])) ? $store_openhour_settings['openhour_background_image'] : '' ?>"), <?php echo (isset($store_openhour_settings['openhour_background_color'])) ? $store_openhour_settings['openhour_background_color'] : '' ?> 80px;
                            background-repeat: no-repeat;
                            background-position: <?php echo (isset($store_openhour_settings['openhour_background_image_position'])) ? $store_openhour_settings['openhour_background_image_position'] : '' ?>;
                            background-size: 120px;
                        }

                        .opening-hours:hover
                        {
                            background-color: <?php echo (isset($store_openhour_settings['openhour_background_hover_color'])) ? $store_openhour_settings['openhour_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- OpenHours 2 --}}
            <?php
                if($openhour_id == 2)
                {
            ?>
                    <style>
                        .opening-hours-v2
                        {
                            background: url("<?php echo (isset($store_openhour_settings['openhour_background_image'])) ? $store_openhour_settings['openhour_background_image'] : '' ?>"), <?php echo (isset($store_openhour_settings['openhour_background_color'])) ? $store_openhour_settings['openhour_background_color'] : '' ?>;
                            background-repeat: no-repeat;
                            background-position: <?php echo (isset($store_openhour_settings['openhour_background_image_position'])) ? $store_openhour_settings['openhour_background_image_position'] : '' ?>;
                            background-size: 120px;
                        }


                        .opening-hours-v2:hover
                        {
                            background-color: <?php echo (isset($store_openhour_settings['openhour_background_hover_color'])) ? $store_openhour_settings['openhour_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- OpenHours 3 --}}
            <?php
                if($openhour_id == 3)
                {
            ?>
                    <style>
                        .opening-hours-v3
                        {
                            background: url("<?php echo (isset($store_openhour_settings['openhour_background_image'])) ? $store_openhour_settings['openhour_background_image'] : '' ?>"), <?php echo (isset($store_openhour_settings['openhour_background_color'])) ? $store_openhour_settings['openhour_background_color'] : '' ?>;
                            background-repeat: no-repeat;
                            background-position: <?php echo (isset($store_openhour_settings['openhour_background_image_position'])) ? $store_openhour_settings['openhour_background_image_position'] : '' ?>;
                            background-size: 120px;
                        }


                        .opening-hours-v3:hover
                        {
                            background-color: <?php echo (isset($store_openhour_settings['openhour_background_hover_color'])) ? $store_openhour_settings['openhour_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- OpenHours 4 --}}
            <?php
                if($openhour_id == 4)
                {
            ?>
                    <style>
                        .opening-hours-v4
                        {
                            background: url("<?php echo (isset($store_openhour_settings['openhour_background_image'])) ? $store_openhour_settings['openhour_background_image'] : '' ?>"), <?php echo (isset($store_openhour_settings['openhour_background_color'])) ? $store_openhour_settings['openhour_background_color'] : '' ?>;
                            background-repeat: no-repeat;
                            background-position: <?php echo (isset($store_openhour_settings['openhour_background_image_position'])) ? $store_openhour_settings['openhour_background_image_position'] : '' ?>;
                            background-size: 120px;
                        }


                        .opening-hours-v4:hover
                        {
                            background-color: <?php echo (isset($store_openhour_settings['openhour_background_hover_color'])) ? $store_openhour_settings['openhour_background_hover_color'] : '' ?>;
                        }

                        .opening-hours-v4 .__time
                        {
                            background-image: url("<?php echo get_css_url().'public/admin/opening-hours.svg' ?>");
                            background-repeat: no-repeat;
                            background-position: center center;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- OpenHours 5 --}}
            <?php
                if($openhour_id == 5)
                {
            ?>
                    <style>
                        .opening-hours-v5
                        {
                            background: url("<?php echo (isset($store_openhour_settings['openhour_background_image'])) ? $store_openhour_settings['openhour_background_image'] : '' ?>"), <?php echo (isset($store_openhour_settings['openhour_background_color'])) ? $store_openhour_settings['openhour_background_color'] : '' ?>;
                            background-repeat: no-repeat;
                            background-position: <?php echo (isset($store_openhour_settings['openhour_background_image_position'])) ? $store_openhour_settings['openhour_background_image_position'] : '' ?>;
                            background-size: 120px;
                        }


                        .opening-hours-v5:hover
                        {
                            background-color: <?php echo (isset($store_openhour_settings['openhour_background_hover_color'])) ? $store_openhour_settings['openhour_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>

            {{-- OpenHours 6 --}}
            <?php
                if($openhour_id == 6)
                {
            ?>
                    <style>
                        .opening-hours-v6
                        {
                            background: url("<?php echo (isset($store_openhour_settings['openhour_background_image'])) ? $store_openhour_settings['openhour_background_image'] : '' ?>"), <?php echo (isset($store_openhour_settings['openhour_background_color'])) ? $store_openhour_settings['openhour_background_color'] : '' ?>;
                            background-repeat: no-repeat;
                            background-position: <?php echo (isset($store_openhour_settings['openhour_background_image_position'])) ? $store_openhour_settings['openhour_background_image_position'] : '' ?>;
                            background-size: 120px;
                        }


                        .opening-hours-v6:hover
                        {
                            background-color: <?php echo (isset($store_openhour_settings['openhour_background_hover_color'])) ? $store_openhour_settings['openhour_background_hover_color'] : '' ?>;
                        }
                    </style>
            <?php
                }
            ?>
        {{------------------------------------------------------------------------------------------------}}
        {{-- END OPENHOURS --}}



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



        {{-- GENERAL --}}
        {{------------------------------------------------------------------------------------------------}}
        <style>
            *{
                font-family: <?php echo (isset($store_general_settings['general_site_fonts'])) ? $store_general_settings['general_site_fonts'] : '' ?>!important;
            }

            .fab {
                font-family: "Font Awesome 5 Brands"!important;
            }

            .fa, .far, .fas {
                font-family: "Font Awesome 5 Free"!important;
            }

            button, a.btn, #go-up{
                background-color : <?php echo (isset($store_general_settings['general_buttons_color'])) ? $store_general_settings['general_buttons_color'] : '' ?>!important;
                color: <?php echo (isset($store_general_settings['general_buttons_fonts_color'])) ? $store_general_settings['general_buttons_fonts_color'] : '' ?>!important;
            }

            button:hover, a.btn:hover{
                background-color : <?php echo (isset($store_general_settings['general_buttons_hover_color'])) ? $store_general_settings['general_buttons_hover_color'] : '' ?>!important;
                color: <?php echo (isset($store_general_settings['general_buttons_fonts_hover_color'])) ? $store_general_settings['general_buttons_fonts_hover_color'] : '' ?>!important;
            }
        </style>
    {{-- END CUSTOM CSS --}}

</head>
<body>
        <!-- Header -->
        @include('frontend.theme.all_themes.header')
        <!-- End Header -->

        <!-- Content -->
        @include('frontend.theme.all_themes.themelayout')
        <!-- End Content -->

        <!-- Footer -->
        @include('frontend.theme.all_themes.footer')
        <!-- End Footer -->

        <!-- Scripts -->
        @include('frontend.include.script')
        <!-- End Scripts -->

</body>
</html>
