@php

   $temp_set = session('template_settings');
    $template_setting = isset($temp_set) ? $temp_set : '';

    $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    $theme_id = $current_theme_id['theme_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // if(session()->has('theme_id'))
    // {
    //     $theme_id = session()->get('theme_id');
    // }
    // else
    // {
    //     $theme_id = 1;
    // }
@endphp

<!doctype html>
<html>
<head>
   @include('frontend.include.head')
   <style>
       body{
            font-family: <?php echo isset($template_setting['polianna_store_fonts']) ? $template_setting['polianna_store_fonts'] : '' ?>!important;
       }
   </style>
</head>
<body>
    @if(!empty($theme_id) || $theme_id != '')
        {{-- Header --}}
        @include('frontend.theme.theme'.$theme_id.'.header')

        {{-- Content --}}
        @include('frontend.theme.theme'.$theme_id.'.layout'.$theme_id)

        {{-- Footer --}}
        @include('frontend.theme.theme'.$theme_id.'.footer')
    @else
        {{-- Header --}}
        @include('frontend.theme.theme1.header')

        {{-- Content --}}
        @include('frontend.theme.theme1.layout1')

        {{-- Footer --}}
        @include('frontend.theme.theme1.footer')
    @endif

    {{-- SCRIPT --}}
    @include('frontend.include.script')

</body>
</html>
