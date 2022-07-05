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
