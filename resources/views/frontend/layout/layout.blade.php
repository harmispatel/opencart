<!--
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
-->


@php

    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    $theme_id = $current_theme_id['theme_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings
    $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
    $template_setting = $store_theme_settings['template_settings'];
    //End Get Store Settings & Theme Settings

@endphp

<!doctype html>
<html>
<head>
    <!-- Include Style -->
    @include('frontend.include.head')
    <!-- End Include Style -->

    <!-- Custom Style -->
    <style>
        *{
            font-family: <?php echo isset($template_setting['polianna_store_fonts']) ? $template_setting['polianna_store_fonts'] : '' ?>!important;
        }
    </style>
    <!-- End Custom Style -->
</head>
<body>

    @if(!empty($theme_id) || $theme_id != '')
        <!-- Header -->
        @include('frontend.theme.theme'.$theme_id.'.header')
        <!-- End Header -->

        <!-- Content -->
        @include('frontend.theme.theme'.$theme_id.'.layout'.$theme_id)
        <!-- End Content -->

        <!-- Footer -->
        @include('frontend.theme.theme'.$theme_id.'.footer')
        <!-- End Footer -->
    @else
        <!-- Header -->
        @include('frontend.theme.theme1.header')
        <!-- End Header -->

        <!-- Content -->
        @include('frontend.theme.theme1.layout1')
        <!-- End Content -->

        <!-- Footer -->
        @include('frontend.theme.theme1.footer')
        <!-- End Footer -->
    @endif

    <!-- Scripts -->
    @include('frontend.include.script')
    <!-- End Scripts -->

</body>
</html>
