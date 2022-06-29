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

    // Get Current Header ID & Header Settings
    $current_header_id = layoutID($currentURL,'header_id');
    $header_id = $current_header_id['header_id'];
    $front_store_id =  $current_header_id['store_id'];
    $store_header_settings = storeLayoutSettings($header_id,$front_store_id,'header_settings','header_id');

    // Get Current Slider ID & Slider Settings
    $current_slider_id = layoutID($currentURL,'slider_id');
    $slider_id = $current_slider_id['slider_id'];
    $front_store_id =  $current_slider_id['store_id'];
    $store_slider_settings = storeLayoutSettings($slider_id,$front_store_id,'slider_settings','slider_id');

    // Get Current About ID & About Settings
    $current_about_id = layoutID($currentURL,'about_id');
    $about_id = $current_about_id['about_id'];
    $front_store_id =  $current_about_id['store_id'];
    $store_about_settings = storeLayoutSettings($about_id,$front_store_id,'about_settings','about_id');

    // Get Current BestCategory ID & BestCategory Settings
    $current_bestcategory_id = layoutID($currentURL,'bestcategory_id');
    $bestcategory_id = $current_bestcategory_id['bestcategory_id'];
    $front_store_id =  $current_bestcategory_id['store_id'];
    $store_bestcategory_settings = storeLayoutSettings($bestcategory_id,$front_store_id,'bestcategory_settings','bestcategory_id');

    $store_theme_settings = '';


@endphp

<!doctype html>
<html>
<head>
    {{-- Include Style --}}
    @include('frontend.include.head')
    {{-- End Include Style --}}


    {{-- Custom CSS  --}}
        {{-- Header 1 --}}
        <?php
            if($header_id == 1)
            {
        ?>
                <style>
                    /* Menu Background Color */
                    .header .header-bottom
                    {
                        background-color: <?php echo $store_header_settings['menu_background_color'] ?>!important;
                    }

                    /* Menu Links Color */
                    .header .header-bottom .menu li a, .menu-shopping-cart .price-box strong, .menu-shopping-cart .number i, .menu-shopping-cart .price-box .price h3, .menu-shopping-cart .price-box .price h3 span
                    {
                        color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                    }

                    /* Menu Active Button Color */
                    .header .header-bottom .menu li.active, .header .header-bottom .menu li.active:before, .header .header-bottom .menu li:hover:before, .header .header-bottom .menu li.active:after, .header .header-bottom .menu li:hover:after
                    {
                        background-color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                    }

                    /* Menu Active Buttons Links Color */
                    .header .header-bottom .menu li.active a, .header .header-bottom .menu li a:hover,.header .header-bottom .menu li:hover a
                    {
                        color: <?php echo $store_header_settings['menu_button_text_color'] ?>!important;
                    }

                    /* Menu Active Button Hover Color */
                    .header .header-bottom .menu li:hover
                    {
                        background-color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
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
                    background-color: <?php echo $store_header_settings['menu_background_color'] ?>!important;
                }

                /* Menu Link Color */
                .header-v2 .header-bottom .menu li a, .header-v2 .header-bottom .authentication-links li a span, .header-v2 .header-bottom .menu-shopping-cart .price-box strong, .header-v2 .header-bottom .menu-shopping-cart .price-box i, .header-v2 .header-bottom .menu-shopping-cart .price-box span
                {
                    color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                }
                .authentication-links li a span,.header-v2 .header-bottom .menu-shopping-cart .price-box strong,.header-v2 .header-bottom .menu-shopping-cart .price-box .price i, .header-v2 .header-bottom .menu-shopping-cart .price-box .price span
                {
                    font-size: 15px!important;
                }

                /* Menu Button Color */
                .header-v2 .header-bottom .menu li:hover:after, .header-v2 .header-bottom .menu li.active:after, .header-v2 .header-bottom .menu-shopping-cart i.fa-shopping-basket
                {
                    background-color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                }
                .header-v2 .header-bottom .authentication-links li a i
                {
                    color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                }
                .menu-shopping-cart .number span
                {
                    color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                    background: <?php echo $store_header_settings['menu_button_text_color'] ?>!important;
                }

                /* Menu Button Active Link Color */
                .header-v2 .header-bottom .menu li.active a, .header-v2 .header-bottom .menu li a:hover,.header-v2 .header-bottom .menu li:hover a, .header-v2 .header-bottom .menu-shopping-cart i.fa-shopping-basket
                {
                    color: <?php echo $store_header_settings['menu_button_text_color'] ?>!important;
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
                    background-color: <?php echo $store_header_settings['menu_background_color'] ?>!important;
                }

                /* Menu Link Color */
                .header-v3 .header-bottom .menu li a
                {
                    color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                }

                /* Menu Active Button Color */
                .header-v3 .header-bottom .menu li:hover a, .header-v3 .header-bottom .menu li.active a
                {
                    color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
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
                    background-color: <?php echo $store_header_settings['menu_background_color'] ?>!important;
                }

                /* Menu Link Color */
                .header-v4 .header-bottom .menu li a
                {
                    color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                }

                /* Menu Button Color */
                .header-v4 .header-bottom .menu li.active a, .header-v4 .header-bottom .menu li:hover a, .header-v4 .header-bottom .__btn-group a.__purple, .header-v4 .header-bottom .__btn-group a.__green
                {
                    background-color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                }

                /* Menu Button Active Link Color */
                .header-v4 .header-bottom .menu li.active a, .header-v4 .header-bottom .menu li:hover a, .header-v4 .header-bottom .__btn-group a i, .header-v4 .header-bottom .__btn-group a.__purple, .header-v4 .header-bottom .__btn-group a.__green
                {
                    color: <?php echo $store_header_settings['menu_button_text_color'] ?>!important;
                }

                .productcountitem span{
                    background-color: <?php echo $store_header_settings['menu_button_text_color'] ?>!important;
                    color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
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
                        background-color: <?php echo $store_header_settings['menu_background_color'] ?>!important;
                    }
                    .header-v5 .header-bottom .menu-shopping-cart .number span
                    {
                        color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                        background-color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                    }

                    /* Menu Links Color */
                    .header-v5 .header-bottom .menu li a, .header-v5 .header-bottom .menu-shopping-cart .price-box strong, .header-v5 .header-bottom .menu-shopping-cart .price-box .price i, .header-v5 .header-bottom .menu-shopping-cart .price-box .price span
                    {
                        color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                    }

                    /* Menu Button Color */
                    .header-v5 .header-bottom .menu li:hover a, .header-v5 .header-bottom .menu li.active a
                    {
                        background-color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                    }
                    .header-v5 .header-bottom .menu-shopping-cart .number i
                    {
                        color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                    }

                    /* Menu Buttons Text Color */
                    .header-v5 .header-bottom .menu li.active a,.header-v5 .header-bottom .menu li:hover a
                    {
                        color: <?php echo $store_header_settings['menu_button_text_color'] ?>!important;
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
                        background-color: <?php echo $store_header_settings['menu_background_color'] ?>!important;
                    }

                    /* Menu Links Color */
                    .header-v6 .header-center .menu li a, .header-v6 .header-bottom .working-time strong, .header-v6 .header-top .authentication-links li a span, .header-v6 .header-top .menu-shopping-cart .price-box strong, .header-v6 .header-top .menu-shopping-cart .price-box i, .header-v6 .header-top .menu-shopping-cart .price-box span
                    {
                        color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                    }
                    .header-v6 .header-top .menu-shopping-cart .number span
                    {
                        background-color: <?php echo $store_header_settings['menu_text_color'] ?>!important;
                        color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                    }

                    /* Menu Button Color */
                    .header-v6 .header-center .menu li.active a, .header-v6 .header-center .menu li:hover a, .header-v6 .header-bottom .working-time i, .header-v6 .header-top .authentication-links li a i, .header-v6 .header-top .menu-shopping-cart .number i
                    {
                        color: <?php echo $store_header_settings['menu_button_color'] ?>!important;
                    }
                </style>
        <?php
            }
        ?>


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


        {{-- About US 1--}}
        <?php
            if($about_id == 1)
            {
                if($store_about_settings['about_background_option'] == 1)
                {
        ?>
                    <style>
                        .welcome{
                            background: url("<?php echo $store_about_settings['about_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_about_settings['about_background_color'] ?>;
                        }

                        .welcome:hover
                        {
                            background-color: <?php echo $store_about_settings['about_background_hover_color'] ?>;
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
                if($store_about_settings['about_background_option'] == 1)
                {
        ?>
                    <style>
                        .about-us{
                            background: url("<?php echo $store_about_settings['about_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_about_settings['about_background_color'] ?>;
                        }

                        .about-us:hover
                        {
                            background-color: <?php echo $store_about_settings['about_background_hover_color'] ?>;
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
                if($store_about_settings['about_background_option'] == 1)
                {
        ?>
                    <style>
                        .who-are-we{
                            background: url("<?php echo $store_about_settings['about_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_about_settings['about_background_color'] ?>;
                        }

                        .who-are-we:hover
                        {
                            background-color: <?php echo $store_about_settings['about_background_hover_color'] ?>;
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
                if($store_about_settings['about_background_option'] == 1)
                {
        ?>
                    <style>
                        .who-are-we-v4{
                            background: url("<?php echo $store_about_settings['about_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_about_settings['about_background_color'] ?>;
                        }

                        .who-are-we-v4:hover
                        {
                            background-color: <?php echo $store_about_settings['about_background_hover_color'] ?>;
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
                if($store_about_settings['about_background_option'] == 1)
                {
        ?>
                    <style>
                        .who-are-we-v5{
                            background: url("<?php echo $store_about_settings['about_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_about_settings['about_background_color'] ?>;
                        }

                        .who-are-we-v5:hover
                        {
                            background-color: <?php echo $store_about_settings['about_background_hover_color'] ?>;
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
                if($store_about_settings['about_background_option'] == 1)
                {
        ?>
                    <style>
                        .who-are-we-v6{
                            background: url("<?php echo $store_about_settings['about_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_about_settings['about_background_color'] ?>;
                        }

                        .who-are-we-v6:hover
                        {
                            background-color: <?php echo $store_about_settings['about_background_hover_color'] ?>;
                        }
                    </style>
        <?php
                }
            }
        ?>



        {{-- Category 1 --}}
        <?php
            if($bestcategory_id == 1)
            {
                if($store_bestcategory_settings['bestcategory_background_option'] == 1)
                {
        ?>
                    <style>
                        .categories{
                            background: url("<?php echo $store_bestcategory_settings['bestcategory_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_color'] ?>;
                        }

                        .categories:hover
                        {
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_hover_color'] ?>;
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
                if($store_bestcategory_settings['bestcategory_background_option'] == 1)
                {
        ?>
                    <style>
                        .categories-v2{
                            background: url("<?php echo $store_bestcategory_settings['bestcategory_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_color'] ?>;
                        }

                        .categories-v2:hover
                        {
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_hover_color'] ?>;
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
                if($store_bestcategory_settings['bestcategory_background_option'] == 1)
                {
        ?>
                    <style>
                        .best-categories-icon{
                            background: url("<?php echo $store_bestcategory_settings['bestcategory_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_color'] ?>;
                        }

                        .best-categories-icon:hover
                        {
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_hover_color'] ?>;
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
                if($store_bestcategory_settings['bestcategory_background_option'] == 1)
                {
        ?>
                    <style>
                        .best-categories-v4{
                            background: url("<?php echo $store_bestcategory_settings['bestcategory_background_image'] ?>") no-repeat center;
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
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_color'] ?>;
                        }

                        .best-categories-v4:hover
                        {
                            background-color: <?php echo $store_bestcategory_settings['bestcategory_background_hover_color'] ?>;
                        }
                    </style>
        <?php
                }
            }
        ?>


    {{-- End Custom CSS --}}
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
