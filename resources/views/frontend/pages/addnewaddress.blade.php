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
    <section class="register-main">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <div class="register-inr">
            <div class="register-title">
              <h2>ADDRESS BOOK</h2>
            </div>
            <div class="reg-details">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
              <form action="{{ route('newaddress') }}" method="POST">
                {{ csrf_field() }}
                <div class="reg-details-inr">
                  <h3>Edit address</h3>
                </div>
                <div class="reg-details-inr">
                  <table class="table">
                    <tbody>
                        <tr>
                        <td><span class="required">*</span>First Name :</td>
                        <td><input type="text" class="@error('title', 'post') is-invalid @enderror" name="name" value=""></td>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        </tr>
                        <tr>
                        <td><span class="required">*</span>Last Name :</td>
                        <td><input type="text" class="@error('title', 'post') is-invalid @enderror" name="lastname" value=""></td>
                        @error('lastname')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        </tr>
                      <tr>
                        <td>Company :</td>
                        <td><input type="text" name="company" value=""></td>
                      </tr>
                      <tr>
                        <td>Company ID :</td>
                        <td><input type="text" name="company_id" value=""></td>
                      </tr>
                      <tr>
                        <td><span class="required">*</span>Address line 1 :</td>
                        <td><input type="text" class="@error('title', 'post') is-invalid @enderror" name="address_1" value=""></td>
                        @error('address_1')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </tr>
                      <tr>
                        <td>Address line 2 :</td>
                        <td><input type="text" name="address_2" value=""></td>
                      </tr>
                      <tr>
                        <td><span class="required">*</span>City :</td>
                        <td><input type="text" class="@error('title', 'post') is-invalid @enderror" name="city" value=""></td>
                        @error('city')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </tr>
                      <tr>
                        <td>Post Code :</td>
                        <td><input type="text" class="@error('title', 'post') is-invalid @enderror" name="postcode" value=""></td>
                        @error('postcode')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </tr>
                      <tr>
                        <td><span class="required @error('title', 'post') is-invalid @enderror">*</span>Country :</td>
                        <td>
                          <select name="country" id="country_id" onchange="getstate();">
                              <option value="" disabled selected>Select Country</option>
                            @foreach ($countries as $countrie)
                                <option value="{{ $countrie->country_id }}">{{ $countrie->name }}</option>
                            @endforeach
                          </select>
                        </td>
                        @error('country')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </tr>
                      <tr>
                        <td><span class="required @error('title', 'post') is-invalid @enderror">*</span>Region / State :</td>
                        <td>
                          <select class="country_region_id" name="country_region_id">
                            <option value="" selected disabled>Select Region/State</option>
                          </select>
                        </td>
                        @error('state')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </tr>
                      <tr>
                        <td><span class="required">*</span>Default Address :</td>
                        <td class="radio-bt">
                          <input type="radio" name="default" value="1">
                          <span>Yes</span>
                          <input type="radio" name="default" value="0" checked="checked">
                          <span>No</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="reg-bt d-flex justify-content-between">
                  <button type="button" class="btn">Back</button>
                  <button type="submit" class="btn">Save</button>
                </div>
              </form>
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
    // START Function Get Stat Country ID
    function getstate()
    {
        var country_id = $('#country_id :selected').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
                type: "POST",
                url: "{{ url('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}"},
                // data: {'country_id': country_id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success: function(response)
                {
                    $('.country_region_id').text('');
                    $('.country_region_id').append(response);
                }
        });
    }
    // End Function Country ID
</script>
