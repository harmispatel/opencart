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

    // Get Current Header ID & Header Settings
    $current_header_id = layoutID($currentURL,'header_id');
    $header_id = $current_header_id['header_id'];
    $store_header_settings = storeLayoutSettings($header_id,$front_store_id,'header_settings','header_id');

    // Get Current Slider ID & Slider Settings
    $current_slider_id = layoutID($currentURL,'slider_id');
    $slider_id = $current_slider_id['slider_id'];
    $store_slider_settings = storeLayoutSettings($slider_id,$front_store_id,'slider_settings','slider_id');

    // // Get Current About ID & About Settings
    // $current_about_id = layoutID($currentURL,'about_id');
    // $about_id = $current_about_id['about_id'];
    // $store_about_settings = storeLayoutSettings($about_id,$front_store_id,'about_settings','about_id');

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

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>{{ $store_setting['config_title'] }}</title>

{{-- CUSTOM CSS  --}}
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
    {{------------------------------------------------------------------------------------------------}}
    {{-- END GENERAL --}}
{{-- END CUSTOM CSS --}}

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
