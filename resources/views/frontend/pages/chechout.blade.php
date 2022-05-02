@php
$openclose = openclosetime();

$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');
$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
$template_setting = session('template_settings');
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
<sidebar class="mobile-menu">
        <a class="close far fa-times-circle" href="#"></a>
        <a class="logo" href="#slide">
            <img class="img-fluid" src="{{ asset('public/assets/theme2/img/logo/logo.svg') }}" />
        </a>
        <div class="top">
            <ul class="menu">
                <li class="active">
                    <a class="text-uppercase" href="{{ route('home') }}">home</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('home') }}">member</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">check out</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">contact us</a>
                </li>
            </ul>
        </div>
        <div class="center">
            <ul class="authentication-links">
                <li>
                    <a href="#">
                        <i class="far fa-user"></i><span>Login</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-sign-in-alt"></i><span>Register</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom">
            <div class="working-time">
                <strong class="text-uppercase">Working Time:</strong>
                {{-- <span>09:00 - 23:00</span> --}}
                @php
                    $openday = $openclose['openday'];
                    $fromtime = $openclose['fromtime'];
                    $totime = $openclose['totime'];
                @endphp
                @foreach ($openday as $key => $item)
                    @foreach ($item as $value)
                        @php
                            $t = count($item) - 1;
                            $firstday = $item[0];
                            $lastday = $item[$t];
                            $today = date('l');
                        @endphp
                        @if ($today == $value)
                            <strong>{{ $fromtime[$key] }} - {{ $totime[$key] }}</strong>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <ul class="social-links">
                <li>
                    <a class="fab fa-facebook" href="{{ $social_site['polianna_facebook_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-twitter" href="{{ $social_site['polianna_twitter_username'] }}"
                        target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-google" href="mailto:{{ $social_site['polianna_gplus_id'] }}"
                        target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-linkedin" href="{{ $social_site['polianna_linkedin_id'] }}" target="_blank"></a>
                </li>
                <li>
                    <a class="fab fa-youtube" href="{{ $social_site['polianna_youtube_id'] }}" target="_blank"></a>
                </li>
            </ul>
        </div>
    </sidebar>
    <section class="check-main">
        <div class="container"> 
          <div class="check-inr">
            <div class="row">
              <div class="col-md-12">
                <div class="check-progress">
                  <h2>Checkout - step 1/3</h2>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header accordion-button" id="headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <span>Accordion Item #1</span>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="row justify-content-center">
                          <div class="col-md-4">
                            <div class="login-main text-center">
                              <div class="fb-login ">
                                <a href="" class="btn fb-log-bt">
                                  <i class="fab fa-facebook-square"></i> <span>Login with facebook</span>
                                </a>
                              </div>
                              <div class="my-3">
                                <strong>OR</strong>
                              </div>
                              <div class="login-details w-100">
                                <div class="email-detail fa fa-envelope w-100">
                                  <input placeholder="Email address" type="text" name="email" value="" class="w-100">
                                </div>
                                <div class="email-detail fa fa-lock w-100">
                                  <input placeholder="password" type="password" name="email" value="" class="w-100">
                                </div>
                                <div class="email-btn">
                                  <button class="btn">Log in</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header accordion-button" id="headingtwo" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                        <span>Accordion Item #1</span>
                    </h2>
                    <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="row justify-content-center">
                          <div class="col-md-4">
                            <div class="login-main text-center">
                              <div class="login-details w-100">
                                <div class="email-detail fa fa-sort-up w-100">
                                  <select name="gender" class="w-100">
                                    <option value="">Title</option>
                                    <option value="1">Mr.</option> 
                                    <option value="2">Mrs.</option> 
                                    <option value="3">Ms.</option> 
                                    <option value="4">Miss.</option> 
                                    <option value="5">Dr.</option> 
                                    <option value="6">Prof.</option>    
                                  </select>
                                </div>
                                <div class="email-detail fa fa-user w-100 d-flex">
                                  <input placeholder="Name" type="text" name="name" value="" class="w-50">
                                  <input placeholder="Surname" type="text" name="surname" value="" class="w-50">
                                </div>
                                <div class="email-detail fa fa-envelope w-100">
                                  <input placeholder="Email address" type="text" name="email" value="" class="w-100">
                                </div>
                                <div class="email-detail fa fa-phone-alt w-100">
                                  <input placeholder="phone number" type="text" name="email" value="" class="w-100">
                                </div>
                                <div class="email-btn">
                                  <button class="btn">Checkout</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header accordion-button" id="headingthree" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                        <span>Accordion Item #1</span>
                    </h2>
                    <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="row justify-content-center">
                          <div class="col-md-4">
                            <div class="login-main text-center">
                              <div class="login-details w-100">
                                <div class="email-detail fa fa-sort-up w-100">
                                  <select name="gender" class="w-100">
                                    <option value="">Title</option>
                                    <option value="1">Mr.</option> 
                                    <option value="2">Mrs.</option> 
                                    <option value="3">Ms.</option> 
                                    <option value="4">Miss.</option> 
                                    <option value="5">Dr.</option> 
                                    <option value="6">Prof.</option>    
                                  </select>
                                </div>
                                <div class="email-detail fa fa-user w-100 d-flex">
                                  <input placeholder="Name" type="text" name="name" value="" class="w-50">
                                  <input placeholder="Surname" type="text" name="surname" value="" class="w-50">
                                </div>
                                <div class="email-detail fa fa-envelope w-100">
                                  <input placeholder="Email address" type="text" name="email" value="" class="w-100">
                                </div>
                                <div class="email-detail fa fa-phone-alt w-100">
                                  <input placeholder="phone number" type="text" name="number" value="" class="w-100">
                                </div>
                                <div class="email-detail fa fa-lock w-100">
                                  <input placeholder="password" type="password" name="password" value="" class="w-100">
                                </div>
                                <div class="email-detail fa fa-lock w-100">
                                  <input placeholder="Confirm Password" type="password" name="confirm" value="" class="w-100">
                                </div>
                                <div class="email-btn">
                                  <button class="btn">Create</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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