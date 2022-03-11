<!doctype html>
<html>
<head>
   @include('frontend.include.head')
</head>
<body>

   <header class="row">
       @include('frontend.include.header')
   </header>
   <sidebar class="">
       @include('frontend.include.sidebar')
   </sidebar>
   <div id="main" class="row">
           @yield('content')
   </div>
   <footer class="row">
       @include('frontend.include.footer')
   </footer>
    <a id="go-up" href="javascript:void(0)"><i class="fas fa-angle-up"></i></a>
    @include('frontend.include.script')

</body>
</html>
