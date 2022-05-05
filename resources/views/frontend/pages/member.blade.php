@php
$openclose = openclosetime();

$template_setting = session('template_settings');
$social_site = session('social_site');
$store_setting = session('store_settings');
$store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
$template_setting = session('template_settings');

$user_delivery_type = session()->has('user_delivery_type') ? session('user_delivery_type') : '';

$mycart = session()->get('cart1');

$userlogin = session('username');

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
        @if (empty($userlogin))
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
          @else
          <section class="check-main ">
            <div class="container">
              <div class="check-inr">
                <div class="row" id="Checkout">
                  <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header accordion-button" id="headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <span>My personal details</span>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <div class="row justify-content-center">
                            <div class="col-md-4">
                              <div class="login-main text-center">
                                  <form action="{{ route('customerdetailupdate') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="login-details-inr fa fa-sort-up w-100">
                                        <select name="title" id="title" class="w-100">
                                            <option disabled selected>Title</option>
                                            <option value="1">Mr.</option>
                                            <option value="2">Mrs.</option>
                                            <option value="3">Ms.</option>
                                            <option value="4">Miss.</option>
                                            <option value="5">Dr.</option>
                                            <option value="6">Prof.</option>
                                        </select>
                                        <div class="invalid-feedback text-start" style="display: none" id="titleerr"></div>
                                    </div>
                                    <div class="login-details-inr fa fa-user w-100">
                                        <div class="w-50 d-inline-block float-start">
                                            <input placeholder="Name" type="text" id="name" name="name" value="{{ isset($customers->firstname) ? $customers->firstname : '' }}" class="w-100">
                                            <div class="invalid-feedback text-start" style="display: none" id="fnameerr"></div>
                                        </div>
                                        <div class="w-50 d-inline-block float-end">
                                            <input placeholder="lastname" type="text" id="lastname" name="lastname" value="{{ isset($customers->lastname) ? $customers->lastname : '' }}" class="w-100">
                                            <div class="invalid-feedback text-start" style="display: none" id="lastnameerr"></div>
                                        </div>
                                    </div>
                                    <div class="login-details-inr fa fa-envelope w-100">
                                        <input placeholder="Email address" type="text" id="email" name="email" value="{{ isset($customers->email) ? $customers->email : '' }}" class="w-100">
                                        <div class="invalid-feedback text-start" style="display: none" id="emailerr"></div>
                                    </div>
                                    <div class="login-details-inr fa fa-phone-alt w-100">
                                        <input placeholder="Phone number" type="text" id="phone" name="phone" value="{{ isset($customers->telephone) ? $customers->telephone : '' }}" class="w-100">
                                        <div class="invalid-feedback text-start" style="display: none" id="phoneerr"></div>
                                    </div>
                                    <div class="login-details-inr fa fa-lock w-100">
                                        <input placeholder="Password" type="password" id="password" name="password" value="" class="w-100">
                                        <div class="invalid-feedback text-start" style="display: none" id="passworderr"></div>
                                    </div>
                                    <div class="login-details-inr fa fa-lock w-100">
                                        <input placeholder="Confirm Password" type="password" id="confirmpassword" name="confirmpassword" value="" class="w-100">
                                        <div class="invalid-feedback text-start" style="display: none" id="confirmpassworderr"></div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header accordion-button" id="headingtwo" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                            <span>My addresses</span>
                        </h2>
                        <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="row justify-content-center">
                              <div class="col-md-10">
                                <div class="login-main text-center">
                                  <div class="login-details w-100">
                                    <div class="row">
                                    @foreach ($customeraddress as $address)
                                      <div class="col-sm-6 mb-3">
                                        <div class="card" style="min-height: 12rem !important;">
                                            <div class="card-body text-start">
                                            <h5 class="card-title">Default Address</h5>
                                            <p><small>{{$address->firstname}} {{$address->firstname}} <br> {{ $address->company }} <br> {{ $address->company_id }} <br>{{ $address->address_1 }} <br> {{ $address->address_2 }} <br> {{ $address->city }}  {{ $address->postcode }}<br> {{ $address->country_id }} <br> {{ $address->zone_id }}</small></p>
                                            </div>
                                            <div class="card-footer bg-transparent border-success">
                                                <a href="{{ route('customeraddressedit',$address->address_id) }}" class="float-start"><i class="far fa-edit"></i>EDIT ADDRESS</a>
                                                <a href="{{ route('customeraddressdelete',$address->address_id)}}" class="float-end"><i class="far fa-edit"></i>DELETE</a>
                                            </div>
                                        </div>
                                        </div>
                                        @endforeach
                                        <div class="col-sm-6 mb-3">
                                          <div class="card" style="min-height: 12rem !important;">
                                            <div class="card-body d-flex align-items-center justify-content-center">
                                                <a href="{{ route('addnewaddress') }}"><h5 class="card-title">+ADD NEW ADDRESS</h5></a>
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
                      <div class="accordion-item">
                        <h2 class="accordion-header accordion-button" id="headingthree" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                        <span>My order history</span>
                        </h2>
                        <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="row justify-content-center">
                              <div class="col-md-10">
                                <div class="login-main text-center">
                                  <div class="login-details w-100">
                                    <div class="col-sm-6 mb-3">
                                        <div class="card">
                                          <div class="card-body">
                                            <h5 class="card-title">Order History</h5>
                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
              </div>
            </div>
        </section>
        @endif
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
