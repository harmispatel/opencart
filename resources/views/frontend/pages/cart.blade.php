@php

    // Get Current Theme ID & Store ID
    $currentURL = URL::to("/");
    $current_theme_id = themeID($currentURL);
    $theme_id = $current_theme_id['theme_id'];
    $front_store_id =  $current_theme_id['store_id'];
    // // Get Current Theme ID & Store ID

    // Get Store Settings & Theme Settings & Other
    $store_theme_settings = storeThemeSettings($theme_id,$front_store_id);
    //End Get Store Settings & Theme Settings & Other

    // Template Settings
    $template_setting = $store_theme_settings['template_settings'];
    // End Template Settings

    // Social Site Settings
    $social_site = $store_theme_settings['social_settings'];
    // End Social Site Settings

    // Store Settings
    $store_setting = $store_theme_settings['store_settings'];
    // End Store Settings

    // Get Open-Close Time
    $openclose = openclosetime();
    // End Open-Close Time

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

    // Get Customer Cart
    if (session()->has('userid'))
    {
        $userid = session()->get('userid');
        $mycart = getuserCart(session()->get('userid'));
    }
    else
    {
        $userid = 0;
        $mycart = session()->get('cart1');
    }
    // End Get Customer Cart

@endphp


<!doctype html>
<html>
<head>
    <!-- CSS -->
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    <!-- End CSS -->
</head>
<body>

    <!-- User Delivery Type -->
    <input type="hidden" name="user_delivery_val" id="user_delivery_val" value="{{ $userdeliverytype }}">
    <!-- End User Delivery Type -->


    <!-- Header -->
    @if (!empty($theme_id) || $theme_id != '')
        @include('frontend.theme.theme' . $theme_id . '.header')
    @else
        @include('frontend.theme.theme1.header')
    @endif
    <!-- End Header -->


    <!-- Cart Section -->
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
                                        $delivery_charge = 0;
                                    @endphp

                                    @if (isset($mycart['size']))
                                        @foreach ($mycart['size'] as $key => $cart)
                                            @php
                                                $price = ($cart['main_price']) * ($cart['quantity']);
                                                $subtotal += $price;
                                                $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0;
                                            @endphp

                                            <tr>
                                                <td>
                                                    <img src="{{ $cart['image'] }}" width="80" height="80">
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['size'] }} - {{ $cart['name'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="qu-inr">
                                                        <input type="number" name="qty" id="qty_size_{{ $key }}" value="{{ $cart['quantity'] }}"
                                                        style="max-width: 65px!important;">
                                                        <a onclick="updatecart({{ $cart['product_id'] }},{{ $key }},{{ $userid }})" class="px-2" style="cursor: pointer">
                                                            <img src="{{ get_css_url().'public/images/update.png' }}">
                                                        </a>
                                                        <a onclick="deletecartproduct({{ $cart['product_id'] }},{{ $key }},{{ $userid }})" style="cursor: pointer">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['main_price'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ number_format($price, 2) }}</b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if (isset($mycart['withoutSize']))
                                        @foreach ($mycart['withoutSize'] as $key => $cart)
                                            @php
                                                $price = $cart['main_price'] * $cart['quantity'];
                                                $subtotal += $price;
                                                $delivery_charge += isset($cart['del_price']) ? $cart['del_price'] : 0;
                                            @endphp

                                            <tr>
                                                <td>
                                                    <img src="{{ $cart['image'] }}" width="80" height="80">
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['name'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="qu-inr">
                                                        <input type="number" name="qty" id="qty_without_{{ $key }}" value="{{ $cart['quantity'] }}"
                                                        style="max-width: 65px!important;">
                                                        <a onclick="updatecart({{ $key }},0,{{ $userid }})" class="px-2" style="cursor: pointer">
                                                            <img src="{{ get_css_url().'public/images/update.png' }}">
                                                        </a>
                                                        <a onclick="deletecartproduct({{ $cart['product_id'] }},0,{{ $userid }})" style="cursor: pointer">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['main_price'] }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ number_format($price, 2) }}</b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @php
                                        if(!empty($Coupon) || $Coupon != '')
                                        {
                                            if ($Coupon['type'] == 'P')
                                            {
                                                $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                            }
                                            if ($Coupon['type'] == 'F')
                                            {
                                                $couponcode = $subtotal - $Coupon['discount'];
                                            }
                                            $total = $subtotal - $couponcode + $delivery_charge;
                                        }
                                        else
                                        {
                                            $total = $subtotal + $delivery_charge;
                                        }
                                    @endphp

                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="basket-total">
                        <table class="table table-responsive">
                            <tbody>
                                <tr>
                                    <td><b>Sub-Total:</b></td>
                                    <td><span><b>£{{ $subtotal }}</b></span></td>
                                </tr>
                                <tr>
                                    <td><b>Delivery Charge:</b></td>
                                    <td><span><b>£{{ $delivery_charge }}</b></span></td>
                                </tr>
                                <tr>
                                    @if(!empty($Coupon) || $Coupon != '')
                                        <td><b>Coupon({{ $Coupon['code'] }}):</b></td>
                                        <td><span><b>£-{{ $couponcode }}</b></span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td><b>Total to pay:</b></td>
                                    <td><span><b>£{{ $total }}</b></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="basket-bt">
                        <a href="{{ route('menu') }}"> <button class="btn">Continue Shopping</button></a>
                        <a href="{{ route('checkout') }}"><button class="btn">Checkout</button></a>
                    </div>
                @else
                    <div class="pb-4">
                        <h6>Your shopping cart is empty!</h6>
                    </div>
                    <div class="emty-bt">
                        <a href="{{ route('menu') }}" class="btn text-white" style="background: rgb(250, 146, 146);">Continue Shopping</a>
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!-- End Cart Section -->


    <!-- Footer -->
    @if (!empty($theme_id) || $theme_id != '')
        @include('frontend.theme.theme' . $theme_id . '.footer')
    @else
        @include('frontend.theme.theme1.footer')
    @endif
    <!-- End Footer -->


    <!-- JS -->
    @include('frontend.include.script')
    <!-- End JS -->


    <!-- Custom JS -->
    <script type="text/javascript">

        // Update Customer Cart
        function updatecart(product, sizeprice, uid)
        {
            var sizeid = sizeprice;
            var productid = product;
            var userid = uid;

            if (sizeid == 0)
            {
                var loop_id = $('#qty_without_' + product).val();
            }
            else
            {
                var loop_id = $('#qty_size_' + sizeid).val();
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
                    if(result.required_1 == 1)
                    {
                        alert('Please Enter the valid Number of Quantity');
                        location.reload();
                    }

                    if(result.max_limit == 1)
                    {
                        alert('Sorry, You can\'t Order More Then 50 Quantity of This Product');
                        location.reload();
                    }

                    location.reload();
                }
            });
        }
        // End Update Customer Cart


        // Delete Customer Cart Product
        function deletecartproduct(prod_id, size_id, uid)
        {
            var sizeid = size_id;
            var productid = prod_id;
            var userid = uid;

            $.ajax({
                type: 'post',
                url: '{{ url('deletecartproduct') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'size_id': sizeid,
                    'product_id': productid,
                    'user_id': userid,
                },
                dataType: 'json',
                success: function(result) {
                    location.reload();
                }
            });
        }
        // End Delete Customer Cart Product

    </script>
    <!-- End Custom JS -->

</body>
</html>

