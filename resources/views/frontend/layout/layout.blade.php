<!doctype html>
<html>
<head>
   @include('frontend.include.head')
</head>
<body>

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

    {{-- Header --}}
    @include('frontend.theme.theme'.$theme_id.'.header')

    {{-- Content --}}
    @include('frontend.theme.theme'.$theme_id.'.layout'.$theme_id)

    {{-- Footer --}}
    @include('frontend.theme.theme'.$theme_id.'.footer')

    {{-- SCRIPT --}}
    @include('frontend.include.script')

</body>
</html>
