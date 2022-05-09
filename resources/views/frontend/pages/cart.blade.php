@php
    $openclose = openclosetime();
    $template_setting = session('template_settings');
    $social_site = session('social_site');
    $store_setting = session('store_settings');
    $store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
    $template_setting = session('template_settings');
    $user_delivery_type = session()->has('user_delivery_type') ? session('user_delivery_type') : '';


    if(session()->has('userid'))
    {
        $userid = session()->get('userid');
        $mycart = getuserCart(session()->get('userid'));
    }
    else
    {
        $userid = 0;
        $mycart = session()->get('cart1');
    }

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
                    <button type="button" class="btn-close  float-end" data-bs-dismiss="modal"
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
        if (session()->has('theme_id'))
        {
            $theme_id = session()->get('theme_id');
        }
        else
        {
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

    <section class="basket-main">
        <div class="container">
            <div class="basket-inr">
                <div class="basket-title">
                    <h2>SHOPPING CART</h2>
                </div>
                @if (!empty($mycart['size']) || !empty($mycart['withoutSize']))
                    <div class="basket-product-detail">
                        <form>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @if (isset($mycart['size']))
                                        @foreach ($mycart['size'] as $key => $cart)
                                            @php
                                                $price = ($cart['price']) * ($cart['quantity']);
                                                $couponcode=($subtotal*$Coupon->discount)/100;
                                                $total=$subtotal-$couponcode;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('public/admin/product/'.$cart['image']) }}" width="80" height="80">
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['size'] }} - {{ $cart['name'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="qu-inr">
                                                        <input type="number" name="qty" id="qty_{{ $key }}" value="{{ $cart['quantity'] }}" style="max-width: 65px!important;">
                                                        <a onclick="updatecart({{ $cart['product_id'] }},{{ $key }},{{ $userid }})" class="px-2">
                                                            <img src="{{ asset('public/images/update.png') }}">
                                                        </a>
                                                        <a onclick="deletecartproduct({{ $cart['product_id'] }},{{ $key }},{{ $userid }})">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['price'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ number_format($price,2) }}</b>
                                                </td>
                                            </tr>
                                            @php
                                                $subtotal += $price;
                                                $couponcode=($subtotal*$Coupon->discount)/100;
                                                $total=$subtotal-$couponcode;
                                            @endphp
                                        @endforeach
                                    @endif

                                    @if (isset($mycart['withoutSize']))
                                        @foreach ($mycart['withoutSize'] as $key=> $cart)
                                            @php
                                                $price = $cart['price'] * $cart['quantity'];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('public/admin/product/'.$cart['image']) }}" width="80" height="80">
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['name'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="qu-inr">
                                                        <input type="number" name="qty" id="qty_{{ $key }}" value="{{ $cart['quantity'] }}" style="max-width: 65px!important;">
                                                        <a onclick="updatecart({{ $key }},0,{{ $userid }})" class="px-2">
                                                            <img src="{{ asset('public/images/update.png') }}">
                                                        </a>
                                                        <a onclick="deletecartproduct({{ $cart['product_id'] }},0,{{ $userid }})">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['price'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ number_format($price,2) }}</b>
                                                </td>
                                            </tr>
                                            @php
                                                $subtotal += $price;
                                                $couponcode=($subtotal*$Coupon->discount)/100;
                                                $total=$subtotal-$couponcode;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="coupon-inr">
                        <div class="coupon-title">
                          <h2>What would you like to do next?</h2>
                          <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
                        </div>
                        <div class="coupon-apply">
                          <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header accordion-button collapsed" id="panelsStayOpen-headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                Use Coupon Code
                              </h2>
                              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                   <form id="coupon">
                                    Enter your coupon here:&nbsp;
                                    <input type="text" name="coupon" value="">
                                    <input type="hidden" name="next" value="coupon">
                                    &nbsp;
                                    <input type="submit" value="Apply" class="btn btn-danger">
                                   </form>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header accordion-button collapsed" id="panelsStayOpen-headingTwo" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                Use Gift Voucher
                              </h2>
                              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                  <form id="gift-voucher">
                                    Enter your gift voucher code here:&nbsp;
                                    <input type="text" name="voucher" value="">
                                    <input type="hidden" name="next" value="voucher">
                                    &nbsp;
                                    <input type="submit" value="Apply" class="btn btn-danger">
                                   </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="basket-total">
                        <table class="table table-responsive">
                          <tbody>
                            <tr>
                              <td><b>Sub-Total:</b></td>
                              <td><span><b>£{{ $subtotal }}</b></span></td>
                            </tr>
                            <tr>
                                <td><b>Coupon({{ $Coupon->code }}):</b></td>
                                <td><span><b>£-{{ $couponcode  }}</b></span></td>
                              </tr>
                            <tr>
                              <td><b>Total to pay:</b></td>
                              <td><span><b>£{{ $total  }}</b></span></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="basket-bt">
                        <a href="{{ route('home') }}"> <button class="btn">Continue Shopping</button></a>
                        <a href="{{ route('checkout') }}"><button class="btn">Checkout</button></a>
                      </div>
                @else
                    <div class="pb-4">
                        <h6>Your shopping cart is empty!</h6>
                    </div>
                    <div class="emty-bt">
                        <a href="{{ route('home') }}"> <button class="btn text-white" style="background: rgb(250, 146, 146);">Continue Shopping</button></a>
                    </div>
                @endif

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
    function updatecart(product,sizeprice,uid)
    {
        var sizeid = sizeprice;
        var productid = product;
        var userid = uid;

        if(sizeid == 0)
        {
            var loop_id = $('#qty_'+product).val();
        }
        else
        {
            var loop_id = $('#qty_'+sizeid).val();
        }


        $.ajax({
            type: 'post',
            url: '{{ route('getid') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_id': sizeid,
                'product_id': productid,
                'loop_id': loop_id,
                'user_id': userid,
            },
            dataType: 'json',
            success: function(result)
            {
                location.reload();
            }
        });
    }

    function deletecartproduct(prod_id,size_id,uid)
    {
        var sizeid = size_id;
        var productid = prod_id;
        var userid = uid;

        $.ajax({
            type: 'post',
            url: '{{ url("deletecartproduct") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_id': sizeid,
                'product_id': productid,
                'user_id': userid,
            },
            dataType: 'json',
            success: function(result)
            {
                location.reload();
            }
        });
    }
</script>

