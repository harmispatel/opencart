<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Star Kebab & Pizza</title>

@php
    $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    if(session()->has('theme_id'))
    {
        $theme_id = session()->get('theme_id');
    }
    else
    {
        $theme_id = 1;
    }

    if(session()->has('front_store_id'))
    {
        $front_store_id = session()->get('front_store_id');
    }

    $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);

@endphp


@if (!empty($theme_id) || $theme_id != '')
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/bootstrap/dist/css/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/fontawesome/css/all.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/swiper-js/swiper-bundle.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/ui/dist/fancybox.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/animate.css/animate.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/select2/dist/css/select2.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/css/app.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/css/responsive.css')  }}">
@else
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/plugins/bootstrap/dist/css/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/plugins/fontawesome/css/all.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/plugins/swiper-js/swiper-bundle.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/plugins/ui/dist/fancybox.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/plugins/animate.css/animate.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/select2/dist/css/select2.min.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/css/app.css')  }}">
    <link rel="stylesheet" href="{{  asset('public/assets/theme1/css/responsive.css')  }}">
@endif
