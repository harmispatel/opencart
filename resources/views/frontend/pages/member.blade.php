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
// echo '<pre>';
// print_r(session()->all());
// exit();
@endphp

<!doctype html>
<html>

<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/pages/menu.css') }}">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    {{-- End CSS --}}
</head>

<body>


    <!-- Close Modal -->
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

  <!-- Order Receipt Modal -->
  <div class="modal fade" id="orderreceipt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="orderreceiptLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderreceiptLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mb-3" id="customerordermodal">

        </div>
      </div>
    </div>
  </div>

  <!-- Order review Modal -->
  <div class="modal fade" id="orderreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="orderreviewLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderreviewLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mb-3">
            <form id="reviewform" action="{{ route('orderreviwe') }}" method="POST">
                @csrf
                {{-- {{ csrf_field() }} --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="reviewtitle" id="title">
                <div class="text-danger" id="titleError"></div>

                {{-- <div class="invalid-feedback" id="reviewtitleerr" style="display: none; text-align:left;"></div> --}}
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="reviewmessage" rows="2"></textarea>
                <div class="text-danger" id="messageError"></div>

                {{-- <span>@error('reviewmessage'){{$message}}@enderror</span> --}}
                {{-- <div class="invalid-feedback" id="reviewmessageerr" style="display: none; text-align:left;"></div> --}}
              </div>
            <div class="mb-3">
                <label for="foodquality" class="form-label">Food Quality</label>
                <input type="number" class="form-control" value="3" name="foodquality" id="foodquality">
            </div>
            <div class="mb-3">
                <label for="customerservice" class="form-label">Customer service</label>
                <input type="number" class="form-control" value="3" name="customerservice" id="customerservice">
            </div>
            <div class="mb-3">
                <label for="timing" class="form-label">Timing</label>
                <input type="number" class="form-control" value="3" name="timing" id="timing">
            </div>
        </div>
           <input type="hidden" name="order_id" id="corderid" value="">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" value="" class="btn btn-primary">Send</button>
        </div>

    </form>
      </div>
    </div>
  </div>

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
                      <input type="email" class="form-control {{ ($errors->has('Email')) ? 'is-invalid' : '' }}" name="Email" value="{{ old('Email') }}" id="email">
                      @if ($errors->has('Email'))
                        <div class="invalid-feedback text-start">
                            {{ $errors->first('Email') }}
                        </div>
                    @endif
                    </div>
                    <div class="mb-2">
                      <label for="password" class="form-label">Password:</label>
                      <input type="password" class="form-control {{ ($errors->has('Password')) ? 'is-invalid' : '' }}" value="{{ old('Password') }}" name="Password" id="password">
                        @if ($errors->has('Password'))
                            <div class="invalid-feedback text-start">
                                {{ $errors->first('Password') }}
                            </div>
                        @endif
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
                                        <select name="title" id="title" class="w-100 {{ ($errors->has('title')) ? 'is-invalid' : '' }}">
                                            <option disabled selected>Title</option>
                                            <option value="1" {{ ($customers->gender_id == 1) ? 'selected' : '' }}>Mr.</option>
                                            <option value="2" {{ ($customers->gender_id == 2) ? 'selected' : '' }}>Mrs.</option>
                                            <option value="3" {{ ($customers->gender_id == 3) ? 'selected' : '' }}>Ms.</option>
                                            <option value="4" {{ ($customers->gender_id == 4) ? 'selected' : '' }}>Miss.</option>
                                            <option value="5" {{ ($customers->gender_id == 5) ? 'selected' : '' }}>Dr.</option>
                                            <option value="6" {{ ($customers->gender_id == 6) ? 'selected' : '' }}>Prof.</option>
                                        </select>
                                        <div class="invalid-feedback text-start" style="display: none" id="titleerr"></div>
                                        @if ($errors->has('title'))
                                            <div class="invalid-feedback text-start">
                                                {{ $errors->first('title') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-user w-100">
                                        <div class="w-50 d-inline-block float-start">
                                            <input placeholder="Name" type="text" id="name" name="firstname" value="{{ isset($customers->firstname) ? $customers->firstname : '' }}" class="w-100 {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}">
                                            <div class="invalid-feedback text-start" style="display: none" id="fnameerr"></div>
                                            @if ($errors->has('firstname'))
                                                <div class="invalid-feedback text-start">
                                                    {{ $errors->first('firstname') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-50 d-inline-block float-end">
                                            <input placeholder="lastname" type="text" id="lastname" name="lastname" value="{{ isset($customers->lastname) ? $customers->lastname : '' }}" class="w-100 {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}">
                                            <div class="invalid-feedback text-start" style="display: none" id="lastnameerr"></div>
                                            @if ($errors->has('lastname'))
                                                <div class="invalid-feedback text-start">
                                                    {{ $errors->first('lastname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="login-details-inr fa fa-envelope w-100">
                                        <input placeholder="Email address" type="text" id="email" name="email" value="{{ isset($customers->email) ? $customers->email : '' }}" class="w-100 {{ ($errors->has('email')) ? 'is-invalid' : '' }}">
                                        <div class="invalid-feedback text-start" style="display: none" id="emailerr"></div>
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback text-start">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-phone-alt w-100">
                                        <input placeholder="Phone number" type="text" id="phone" name="phone" value="{{ isset($customers->telephone) ? $customers->telephone : '' }}" class="w-100 {{ ($errors->has('phone')) ? 'is-invalid' : '' }}">
                                        <div class="invalid-feedback text-start" style="display: none" id="phoneerr"></div>
                                        @if ($errors->has('phone'))
                                            <div class="invalid-feedback text-start">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-lock w-100">
                                        <input placeholder="Password" type="password" id="password" name="password" value="" class="w-100 {{ ($errors->has('password')) ? 'is-invalid' : '' }}">
                                        <div class="invalid-feedback text-start" style="display: none" id="passworderr"></div>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback text-start">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="login-details-inr fa fa-lock w-100">
                                        <input placeholder="Confirm Password" type="password" id="confirmpassword" name="confirm_password" value="" class="w-100 {{ ($errors->has('confirm_password')) ? 'is-invalid' : '' }}">
                                        <div class="invalid-feedback text-start" style="display: none" id="confirmpassworderr"></div>
                                        @if ($errors->has('confirm_password'))
                                            <div class="invalid-feedback text-start">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                        @endif
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
                                      <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body text-start">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="card-title">Address {{ $loop->iteration }}</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="float-end" type="radio" onclick="changeDefaultAddress({{ $address->address_id }},{{ $customers->customer_id }})" name="def_add" id="def_add" style="width: 25px; height: 25px;" {{ ($customers->address_id == $address->address_id) ? 'checked' : '' }}>
                                                    </div>
                                                </div><hr>
                                                <div>
                                                    <table class="table p-0">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>:</th>
                                                            <td>{{$address->firstname}} {{$address->lastname}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Company</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->company)) ? $address->company : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Company ID</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->company_id)) ? $address->company_id : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address 1</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->address_1)) ? $address->address_1 : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address 2</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->address_2)) ? $address->address_2 : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>City</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->city)) ? $address->city : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Postcode</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->postcode)) ? $address->postcode : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Region</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->hasOneRegion['name'])) ? $address->hasOneRegion['name'] : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Country</th>
                                                            <th>:</th>
                                                            <td>{{ (isset($address->hasOneCountry['name'])) ? $address->hasOneCountry['name'] : '-' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <a href="{{ route('customeraddressedit',$address->address_id) }}" class="float-start text-primary"><i class="far fa-edit"></i> EDIT ADDRESS</a>
                                                <a href="{{ route('customeraddressdelete',$address->address_id)}}" class="float-end text-danger"><i class="fa fa-times"></i> DELETE</a>
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
                                    <div class="row">
                                    @foreach ($customerorders as $orders)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body text-start">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h5 class="card-title">Order ID:</h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5 style="text-align: left">#{{ $orders->order_id }}</h5>
                                                    </div>
                                                </div><hr>
                                                <h5 class="orderstatus" style="text-align: center">{{$orders->hasOneOrderStatus['name']}}</h5>
                                                <div>
                                                    <table class="table p-0">
                                                        <tr>
                                                            <th>Date Added</th>
                                                            <th>:</th>
                                                            <td>{{date('d-m-Y',strtotime($orders->date_added))}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>:</th>
                                                            {{-- <td>16:20</td> --}}
                                                            <td>{{ $orders->timedelivery }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Products</th>
                                                            <th>:</th>
                                                            <td>{{ count($orders->hasManyOrderProduct) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Points Earned</th>
                                                            <th>:</th>
                                                            <td>0</td>
                                                        </tr>
                                                    </table>
                                                    <div class="d-flex justify-content-around">
                                                        <a class="btn btn-sm" href="#" class="button"><i class="fas fa-redo-alt"></i> Re-Order </a>
                                                        <button type="button" class="btn btn-sm customerorderdetail" data-bs-toggle="modal"  data-bs-target="#orderreview" value="{{ $orders->order_id }}"><i class="far fa-comment"></i> Review</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <span class="float-start text-bold" style="font-size: 23px"><i class="fa fa-shopping-basket" aria-hidden="true"></i> £{{ number_format($orders->total,2) }}</span>
                                                {{-- <button type="button" class="float-end btn btn-danger" data-bs-toggle="modal" data-bs-target="#orderreceipt">View</button> --}}
                                                <button type="button" value="{{ $orders->order_id }}" class="float-end btn btn-danger customerorderdetail" data-bs-toggle="modal" data-bs-target="#orderreceipt">View</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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

<script>
    function changeDefaultAddress(addressid,custid)
    {
        var address_id = addressid;
        var customer_id = custid;

        $.ajax({
            type: 'post',
            url: '{{ url("changeDefAddress") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'address_id': address_id,
                'customer_id': customer_id,
            },
            dataType: 'json',
            success: function(result) {
                if(result.success == 1)
                {
                    alert('Default Address has been changed Successfully.');
                }
            }
        });

    }


    $('.customerorderdetail').on('click', function () {
       var customerorderid = $(this).val();
       $('#corderid').val(customerorderid);
    //    alert(customerorderid);
       $.ajax({
           type: "POST",
           url: '{{ url("getcustomerorderdetail") }}',
           data:{
               "_token": "{{ csrf_token() }}",
                'customerorderid': customerorderid,
            },
           dataType: 'json',
           success: function (response) {
                // console.log(response.customerorders);
                $('#customerordermodal').html(response.customerorders);
           }
       });
    });


// print
function printDiv(divId,title) {

    let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

    // mywindow.document.write(`<html><head><title>${title}</title>`);
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById(divId).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}


//  Order Review submite

    $('#reviewform').submit(function(e){
        e.preventDefault();
        var  reviewtitle=$("input[name='reviewtitle']").val();
        var  reviewmessage=$("textarea[name='reviewmessage']").val();
        var  foodquality=$("input[name='foodquality']").val();
        var  customerservice=$("input[name='customerservice']").val();
        var  timing=$("input[name='timing']").val();
        var  o_id=$("#corderid").val();
        $.ajax({
                type: 'post',
                url: '{{ url("orderreviwe") }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'reviewtitle': reviewtitle,
                    'reviewmessage': reviewmessage,
                    'foodquality': foodquality,
                    'customerservice': customerservice,
                    'timing': timing,
                    'o_id':o_id,
                },
                dataType: 'json',
                success: function(response)
                {
                    location.reload();
                },
                error: function(response) {
                $('#titleError').text(response.responseJSON.errors.reviewtitle);
                $('#messageError').text(response.responseJSON.errors.reviewmessage);
           }
        });
    });
    // End Order Review submite
</script>
</html>

