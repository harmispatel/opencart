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
@endphp


<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/bootstrap/dist/css/bootstrap.min.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/fontawesome/css/all.min.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/swiper-js/swiper-bundle.min.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/ui/dist/fancybox.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/plugins/animate.css/animate.min.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/select2/dist/css/select2.min.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/css/app.css')  }}">
<link rel="stylesheet" href="{{  asset('public/assets/theme'.$theme_id.'/css/responsive.css')  }}">
