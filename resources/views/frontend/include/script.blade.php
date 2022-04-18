@php
    if(session()->has('theme_id'))
    {
        $theme_id = session()->get('theme_id');
    }
    else
    {
        $theme_id = 1;
    }
@endphp

<!--Js Files-->
   @if (!empty($theme_id) || $theme_id != '')
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/moment/min/locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/wow/dist/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/swiper-js/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/ui/dist/fancybox.umd.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/plugins/select2/dist/js/i18n/tr.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme'.$theme_id.'/js/app.js') }}"></script>
   @else
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/moment/min/locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/wow/dist/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/swiper-js/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/ui/dist/fancybox.umd.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/plugins/select2/dist/js/i18n/tr.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/theme1/js/app.js') }}"></script>
   @endif
<!--Js Files-->
