@php
$openclose = openclosetime();

$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');
$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
$template_setting = session('template_settings');

$user_delivery_type = session()->has('user_delivery_type') ? session('user_delivery_type') : '';

$mycart = session()->get('cart1');

@endphp

<!doctype html>
<html>

<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/pages/menu.css') }}">
    {{-- End CSS --}}
</head>

<body>


    <!-- Modal -->
    <div class="modal fade" id="pricemodel" tabindex="-1" aria-labelledby="pricemodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-25">
            <div class="modal-content">
                <div class="modal-body p-5 text-danger">
                    Sorry we are close now!
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Model --}}

    {{-- User Delivery --}}
    <input type="hidden" name="user_delivery_val" id="user_delivery_val" value="{{ $user_delivery_type }}">
    {{-- End User Delivery --}}

    @php
        if (session()->has('theme_id')) {
            $theme_id = session()->get('theme_id');
        } else {
            $theme_id = 1;
        }

        $social = session('social_site');
        $social_site = isset($social) ? $social : '#';
    @endphp

    @if (!empty($theme_id) || $theme_id != '')
        {{-- Header --}}
        @include('frontend.theme.theme' . $theme_id . '.header')
        {{-- End Header --}}
    @else
        {{-- Header --}}
        @include('frontend.theme.theme1.header')
        {{-- End Header --}}
    @endif

    <div class="mobile-menu-shadow"></div>
    <sidebar class="mobile-menu"><a class="close far fa-times-circle" href="#"></a><a class="logo"
            href="#slide"><img class="img-fluid" src="./assets/img/logo/logo.svg" /></a>
        <div class="top">
            <ul class="menu">
                <li class="active"><a class="text-uppercase" href="#">home</a></li>
                <li><a class="text-uppercase" href="#">member</a></li>
                <li><a class="text-uppercase" href="#">menu</a></li>
                <li><a class="text-uppercase" href="#">check out</a></li>
                <li><a class="text-uppercase" href="#">contact us</a></li>
            </ul>
        </div>
        <div class="center">
            <ul class="authentication-links">
                <li><a href="#"><i class="far fa-user"></i><span>Login</span></a></li>
                <li><a href="#"><i class="fas fa-sign-in-alt"></i><span>Register</span></a></li>
            </ul>
        </div>
        <div class="bottom">
            <div class="working-time"><strong class="text-uppercase">Working Time:</strong><span>09:00 - 23:00</span>
            </div>
            <ul class="social-links">
                <li><a class="fab fa-facebook" href="#" target="_blank"></a></li>
                <li><a class="fab fa-twitter" href="#" target="_blank"></a></li>
                <li><a class="fab fa-pinterest-p" href="#" target="_blank"></a></li>
                <li><a class="fab fa-instagram" href="#" target="_blank"></a></li>
            </ul>
        </div>
    </sidebar>
    <section class="member-main">
        <div class="container">
            @if($errors->any())
                <div class="alert alert-sm alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> No match for E-Mail Address and/or Password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
          <div class="member-inr">
            <div class="member-title">
              <h2>ACCOUNT LOGIN</h2>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="new-customer">
                  <h2>New Customer</h2>
                  <label>Register Account</label>
                  <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                  <a class="btn mem-reg-bt" href="{{ route('memberregister') }}">Continue</a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="login-inr">
                  <h2>Returning Customer</h2>
                  <label>I am a returning customer</label>
                  <form action="{{ route('customerlogin') }}" method="POST">
                      {{ csrf_field() }}
                    <div class="mb-2">
                      <label for="email" class="form-label">Email address:</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                      <label for="password" class="form-label">Password:</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" id="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1">
                      <a href="#">Forgotten Password</a>
                    </div>
                    <div class="mb-1">
                      <button type="submit" class="btn log-bt">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    @if (!empty($theme_id) || $theme_id != '')
        {{-- Footer --}}
        @include('frontend.theme.theme' . $theme_id . '.footer')
        {{-- End Footer --}}
    @else
        {{-- Footer --}}
        @include('frontend.theme.theme1.footer')
        {{-- End Footer --}}
    @endif

    {{-- JS --}}
    @include('frontend.include.script')
    {{-- END JS --}}

</body>

</html>

<script>

</script>
