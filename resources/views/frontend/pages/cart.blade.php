{{--
    THIS IS NEW CART PAGE FOR FRONTEND
    ----------------------------------------------------------------------------------------------
    cart.blade.php
    It's used to show customer's cart.
    ----------------------------------------------------------------------------------------------
--}}



@php


    // Get Current URL
    $currentURL = URL::to("/");


    // Get Store Settings & Other Settings
    $store_data = frontStoreID($currentURL);


    // Get Current Front Store ID
    $front_store_id =  $store_data['store_id'];


    // Social Site Settings
    $social_site = isset($store_data['social_settings']) ? $store_data['social_settings'] : '';


    // Store Settings
    $store_setting = isset($store_data['store_settings']) ? $store_data['store_settings'] :'';

    // Get Currency Details
    $currency = getCurrencySymbol($store_setting['config_currency']);

     // Get Open-Close Time
     $openclose = openclosetime();

    // Store Open / Close
    $store_open_close = $openclose['store_open_close'];

    // Get Working Time
    if($store_open_close == 'open')
    {
        $working_from_time = isset($openclose['from_time']) ? date('H:i',$openclose['from_time']) : '0:00';
        $working_to_time = isset($openclose['to_time']) ? date('H:i',$openclose['to_time']) : '0:00';
        $working_time = $working_from_time.' - '.$working_to_time;
    }
    else
    {
        $working_time = '0:00 - 0:00';
    }

    // User Delivery Type (Collection/Delivery)
    $userdeliverytype = session()->has('flag_post_code') ? session('flag_post_code') : '';
    // End User Delivery Type

    // Get Customer Cart
    if (session()->has('userid'))
    {
        $userid = session()->get('userid');
        // $mycart = getuserCart(session()->get('userid')); // Database
        $mycart = session()->get('cart1'); // Session
    }
    else
    {
        $userid = 0;
        $mycart = session()->get('cart1');
    }
    // End Get Customer Cart


    // Delivery Charge
    if(session()->has('delivery_charge'))
    {
        $delivery_charge = session()->get('delivery_charge');
    }
    else
    {
        $delivery_charge = 0;
    }


@endphp


<!doctype html>
<html>
<head>
    {{-- CSS --}}
    @include('frontend.include.head')
    <link rel="stylesheet" href="{{ get_css_url().'public/assets/frontend/pages/menu.css' }}">
    {{-- End CSS --}}
</head>
<body>

    {{-- User Delivery Type --}}
    <input type="hidden" name="user_delivery_val" id="user_delivery_val" value="{{ $userdeliverytype }}">
    {{-- End User Delivery Type --}}


   {{-- Header  --}}
   @include('frontend.theme.all_themes.header')



    {{-- Cart Section --}}
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
                                                // Price
                                                if($userdeliverytype == 'delivery')
                                                {
                                                    $price = $cart['del_price'];
                                                    $qty_price = ($cart['del_price']) * ($cart['quantity']);
                                                }
                                                elseif($userdeliverytype == 'collection')
                                                {
                                                    $price = $cart['col_price'];
                                                    $qty_price = ($cart['col_price']) * ($cart['quantity']);
                                                }
                                                else
                                                {
                                                    $price = $cart['main_price'];
                                                    $qty_price = ($cart['main_price']) * ($cart['quantity']);
                                                }

                                                $subtotal += $qty_price;

                                            @endphp

                                            <tr>
                                                <td>
                                                    <img src="{{ $cart['image'] }}" width="80" height="80">
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['size'] }} - {{ $cart['name'] }}</b><br>
                                                    @if (isset($cart['topping']) && !empty($cart['topping']))
                                                        @foreach ($cart['topping'] as $ctop)
                                                            <span>- {{ $ctop }}</span><br>
                                                        @endforeach
                                                        @endif
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
                                                    <b>{{ $price }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ number_format($qty_price, 2) }}</b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if (isset($mycart['withoutSize']))
                                        @foreach ($mycart['withoutSize'] as $key => $cart)
                                            @php

                                                // Price
                                                if($userdeliverytype == 'delivery')
                                                {
                                                    $price = (isset($cart['del_price'])) ? $cart['del_price'] : 0;
                                                    $qty_price = $price * $cart['quantity'];
                                                }
                                                elseif($userdeliverytype == 'collection')
                                                {
                                                    $price = (isset($cart['col_price'])) ? $cart['col_price'] : 0;
                                                    $qty_price = $price * $cart['quantity'];
                                                }
                                                else
                                                {
                                                    $price = (isset($cart['main_price'])) ? $cart['main_price'] : 0;
                                                    $qty_price = $price * $cart['quantity'];
                                                }

                                                $subtotal += $qty_price;

                                            @endphp

                                            <tr>
                                                <td>
                                                    <img src="{{ $cart['image'] }}" width="80" height="80">
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ $cart['name'] }}</b><br>
                                                    @if (isset($cart['topping']) && !empty($cart['topping']))
                                                    @foreach ($cart['topping'] as $ctop)
                                                        <span>- {{ $ctop }}</span><br>
                                                    @endforeach
                                                @endif
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
                                                    <b>{{ $price }}</b>
                                                </td>
                                                <td class="align-middle">
                                                    <b>{{ number_format($qty_price, 2) }}</b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @php
                                        if(!empty($Coupon) || $Coupon != '')
                                        {
                                            $couponcode = 0;
                                                if( $Coupon['total'] <= $subtotal){
                                                    if ($Coupon['type'] == 'P')
                                                    {
                                                        $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                    }
                                                    if ($Coupon['type'] == 'F')
                                                    {
                                                        $couponcode = $Coupon['discount'];
                                                    }
                                                }
                                            $total = $subtotal - $couponcode;
                                        }
                                        else
                                        {
                                            $total = $subtotal;
                                        }
                                    @endphp

                                    @php
                                        $total = $total + $delivery_charge;
                                    @endphp
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="basket-total">
                        <table class="table table-responsive">
                            <tbody>
                                <tr>
                                    <td><b>Sub-Total :</b></td>
                                    <td><span><b>{{ $currency }}{{ $subtotal }}</b></span></td>
                                </tr>

                                <tr>
                                    @if(!empty($Coupon) || $Coupon != '')
                                        @if ($couponcode != 0)
                                            <td><b>Coupon({{ $Coupon['code'] }}):</b></td>
                                            <td><span><b>{{ $currency }}-{{ (($couponcode >= $subtotal) ?  $subtotal : number_format($couponcode,2)) }}</b></span></td>
                                        @endif
                                    @endif
                                </tr>

                                @if ($userdeliverytype == 'delivery')
                                    <tr>
                                        <td><b>Delivery : </b></td>
                                        <td><span><b>{{ $currency }}{{ $delivery_charge }}</b></span></td>
                                    </tr>
                                @endif

                                <tr>
                                    <td><b>Total to pay:</b></td>
                                    <td><span><b>{{ $currency }}{{ ($total <= 0) ? 0 : $total }}</b></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="basket-bt">
                        <a href="{{ route('menu') }}"> <button class="btn">Continue Shopping</button></a>
                        @if ($store_open_close == 'open' && $minimum_spend['min_spend'] <= $total)
                            <a href="{{ route('checkout') }}"><button class="btn">Checkout</button></a>
                        @else
                            @if ($userdeliverytype == 'collection')
                                <a href="{{ route('checkout') }}"><button class="btn">Checkout</button></a>
                            @else
                                <button class="btn" disabled style="cursor: not-allowed; pointer-events: auto; color:black;">Checkout</button>
                            @endif
                        @endif
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
    {{-- End Cart Section --}}


    {{-- Footer  --}}
    @include('frontend.theme.all_themes.footer')


    {{-- JS --}}
    @include('frontend.include.script')
    {{-- End JS --}}


    {{-- Custom JS --}}
    <script type="text/javascript">

        // Get User Delivery Type
        deli_type = $('#user_delivery_val').val();

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
                success: function(result)
                {
                    updateCart(deli_type);

                    setTimeout(() =>
                    {
                        location.reload();
                    }, 2000);
                }
            });
        }
        // End Delete Customer Cart Product

    </script>
    {{-- End Custom JS --}}

</body>
</html>

