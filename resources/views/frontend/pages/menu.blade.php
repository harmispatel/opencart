@php
    // Open Close Time
    $openclose = openclosetime();

    // Get Template Settings
    $template_setting = session('template_settings');
    $social_site = session('social_site');
    $store_setting = session('store_settings');
    $store_open_close = isset($template_setting['polianna_open_close_store_permission']) ? $template_setting['polianna_open_close_store_permission'] : 0;
    $template_setting = session('template_settings');

    // User Delivery Type
    $user_delivery_type = session()->has('flag_post_code') ? session('flag_post_code') : '';

    if (session()->has('userid'))
    {
        $userid = session()->get('userid');
        $mycart = getuserCart($userid);
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
    <div class="modal fade" id="storeclose" tabindex="-1" aria-labelledby="storecloseLabel" aria-hidden="true">
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
                    <a class="text-uppercase" href="{{ route('member') }}">member</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('menu') }}">menu</a>
                </li>
                <li>
                    <a class="text-uppercase" href="{{ route('checkout') }}">check out</a>
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

    <!-- free item modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Freeitem">
    Launch demo modal
  </button> --}}

  <!-- Modal -->
  <div class="modal fade" id="Freeitem" tabindex="-1" aria-labelledby="FreeitemLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="FreeitemLabel">1/4 Pounder</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Accordion Item #1
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

    <section class="main-innr">
        <div class="container">
            <div class="main-inner-p">
                <div class="row">
                    <div class="col-md-7 col-lg-8">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="cate-part wow animate__fadeInUp cate-list-part" data-wow-duration="1s">
                                    <div class="category-title">
                                        <h2>Categories</h2>
                                    </div>
                                    <div>
                                        <ul class="box-category">
                                            @foreach ($data['category'] as $category)
                                                @php
                                                    $demo = $category->category_id;
                                                    $productcount = getproductcount($demo);

                                                    $catname = strtolower($category->name);
                                                @endphp
                                                <li>
                                                    <a href="#{{ str_replace(' ', '', $catname) }}"
                                                        class="active">{{ $category->name }}
                                                        ({{ $productcount }})
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="cate-part wow animate__fadeInUp cate-part-select-box"
                                    data-wow-duration="1s">
                                    <select class="form-control">
                                        <option>Show All Categories</option>
                                        @foreach ($data['category'] as $category)
                                            <option>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="product-list wow animate__fadeInUp" data-wow-duration="1s">
                                    <div class="product-list-innr">
                                        @foreach ($data['category'] as $key => $value)
                                            @php
                                                $cat_id = $value->category_id;
                                                $front_store_id = session('front_store_id');
                                                $product = getproduct($front_store_id, $cat_id);

                                                $catvalue = strtolower($value->name);
                                            @endphp
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button"
                                                            id="{{ str_replace(' ', '', $catvalue) }}" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse1{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse1{{ $key }}">
                                                            <span>{{ $value->name }}</span>
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                    </h2>

                                                    <div id="collapse1{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    @foreach ($product as $values)
                                                            <div class="accordion-body">
                                                                <div class="acc-body-inr">
                                                                    <div class="row">
                                                                        <div class="col-md-7">
                                                                            <div class="acc-body-inr-title">
                                                                                <h4>
                                                                                    {{ $values->hasOneDescription['name'] }}
                                                                                </h4>
                                                                                @php
                                                                                    $prodesc = html_entity_decode($values->hasOneDescription['description']);
                                                                                @endphp
                                                                                <p>
                                                                                    {{ strip_tags($prodesc) }}
                                                                                </p>
                                                                                <img src="{{ asset('public/admin/product/' . $values->hasOneProduct['image']) }}"
                                                                                    width="80" height="80"
                                                                                    class="mt-2 mb-2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="options-bt-main">
                                                                                @php
                                                                                    $sizes = getsize($values->product_id);
                                                                                @endphp
                                                                                @if (count($sizes) > 0)
                                                                                    @foreach ($sizes as $size)
                                                                                        @php
                                                                                            $sizeprice = $size->id_product_price_size;
                                                                                            $productsize = $values->hasOneProduct['product_id'];
                                                                                            $setsizeprice = $size->price;
                                                                                        @endphp
                                                                                        <div class="options-bt">
                                                                                            <div
                                                                                                class="row align-items-center">
                                                                                                <div
                                                                                                    class="col-md-3">
                                                                                                    <span>{{ html_entity_decode(isset($size->hasOneToppingSize['size']) ? $size->hasOneToppingSize['size'] : '') }}</span>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-9">
                                                                                                    @foreach ($openday as $key => $item)
                                                                                                        @foreach ($item as $value)
                                                                                                            @php
                                                                                                                $firsttime = strtotime($fromtime[$key]);
                                                                                                                $lasttime = strtotime($totime[$key]);
                                                                                                                $today = time();
                                                                                                                $date = date('Y-m-d');
                                                                                                                $currentday = date('l');
                                                                                                            @endphp
                                                                                                            @if ($today >= $firsttime && $today <= $lasttime)
                                                                                                                @if ($currentday == $value)
                                                                                                                    <a onclick="showId({{ $values->product_id }},{{ $sizeprice }},{{ $userid }});" class="btn options-btn">
                                                                                                                        <span class="sizeprice hide-carttext">£{{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                        <span class="show-carttext sizeprice" style="display: none;">Added<i class="fa fa-check"></i></span>
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            @else
                                                                                                                @if ($currentday == $value)
                                                                                                                    <a class="btn options-btn" data-bs-toggle="modal" data-bs-target="#storeclose">
                                                                                                                        <span class="sizeprice hide-carttext">£ {{ $setsizeprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                        <span class="show-carttext sizeprice" style="display: none;">Added<i class="fa fa-check"></i></span>
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @else
                                                                                    <div class="options-bt">
                                                                                        <div
                                                                                            class="row align-items-center">
                                                                                            <div class="col-md-3">
                                                                                                <span>price</span>
                                                                                            </div>
                                                                                            <div class="col-md-9">
                                                                                                @foreach ($openday as $key => $item)
                                                                                                    @foreach ($item as $value)
                                                                                                        @php
                                                                                                            $firsttime = strtotime($fromtime[$key]);
                                                                                                            $lasttime = strtotime($totime[$key]);
                                                                                                            $today = time();
                                                                                                            $currentday = date('l');
                                                                                                            $setprice = $values->hasOneProduct['price'];
                                                                                                        @endphp

                                                                                                        @if ($today >= $firsttime && $today <= $lasttime)
                                                                                                            @if ($currentday == $value)
                                                                                                                <a onclick="showId({{ $values->product_id }},0,{{ $userid }});" class="btn options-btn">
                                                                                                                    <span class="sizeprice hide-carttext">£{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                    <span class="show-carttext sizeprice" style="display: none;">Added<i class="fa fa-check"></i></span>
                                                                                                                </a>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            @if ($currentday == $value)
                                                                                                                <a class="btn options-btn"
                                                                                                                    data-bs-toggle="modal"
                                                                                                                    data-bs-target="#storeclose">
                                                                                                                    <span class="sizeprice hide-carttext">£{{ $setprice }}<i class="fa fa-shopping-basket"></i></span>
                                                                                                                    <span class="show-carttext sizeprice" style="display: none;">Added<i class="fa fa-check"></i></span>
                                                                                                                </a>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-4">
                        <div class="cart-part wow animate__fadeInUp" data-wow-duration="1s">

                            @foreach ($openday as $key => $item)
                                @foreach ($item as $value)
                                    @php

                                        $firsttime = strtotime($fromtime[$key]);
                                        $lasttime = strtotime($totime[$key]);
                                        $today = time();
                                        $currentday = date('l');

                                    @endphp

                                    @if ($today >= $firsttime && $today <= $lasttime)
                                        @if ($currentday == $value)
                                            <div class="alert p-1 text-center" style="background: green;">
                                                <h2 class="p-1 text-white mb-0">We are open now!</h2>
                                            </div>
                                        @endif
                                    @else
                                        @if ($currentday == $value)
                                            <div class="close-shop">
                                                <h2>Sorry we are closed now!</h2>
                                                <span>We will be opening back at {{ $fromtime[$key] }} Today</span>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                            {{-- </div> --}}
                            <div class="mob-view-main">
                                <div class="mob-view" id="mob-view">
                                    <span class="tg-icon" id="tg-icon"><i
                                            class="fas fa-angle-double-up"></i></span>
                                    <div class="mob-basket">0 X ITEMS | TOTAL: £0.00</div>
                                </div>
                                <div class="minicart" id="minicart">
                                    <div class="minibox-title">
                                        <h3>My Basket</h3>
                                        <i class="fa fa-shopping-basket"></i>
                                    </div>
                                    <div class="minibox-content">
                                        <div class="empty-box">
                                            <table class="table">
                                                @php
                                                    $subtotal = 0;
                                                    $delivery_charge = 0;
                                                @endphp
                                                @if (!empty($mycart['size']) || !empty($mycart['withoutSize']))
                                                    @if (isset($mycart['size']))
                                                        @foreach ($mycart['size'] as $key => $cart)
                                                            @php
                                                                $price = isset($cart['main_price']) ? $cart['main_price'] * $cart['quantity'] : 0 * $cart['quantity'];
                                                                $subtotal += $price;

                                                                if (isset($cart['del_price']) && !empty($cart['del_price']))
                                                                {
                                                                    $delivery_charge += $cart['del_price'];
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <i onclick="deletecartproduct({{ $cart['product_id'] }},{{ $key }},{{ $userid }})"
                                                                        class="fa fa-times-circle text-danger"
                                                                        style="cursor: pointer"></i>
                                                                </td>
                                                                <td>{{ $cart['quantity'] }}x</td>
                                                                <td>{{ html_entity_decode($cart['size']) }}</td>
                                                                <td>{{ $cart['name'] }}</td>
                                                                <td>£{{ $price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    @if (isset($mycart['withoutSize']))
                                                        @foreach ($mycart['withoutSize'] as $cart)
                                                            @php
                                                                $price = $cart['main_price'] * $cart['quantity'];
                                                                $subtotal += $price;

                                                                if (isset($cart['del_price']) && !empty($cart['del_price']))
                                                                {
                                                                    $delivery_charge += $cart['del_price'];
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <i class="fa fa-times-circle text-danger"
                                                                        onclick="deletecartproduct({{ $cart['product_id'] }},0,{{ $userid }})"
                                                                        style="cursor: pointer"></i>
                                                                </td>
                                                                <td>{{ $cart['quantity'] }}x</td>
                                                                <td colspan="2">{{ $cart['name'] }}</td>
                                                                <td>£{{ $price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <span>Your shopping cart is empty!</span>
                                                @endif
                                            </table>
                                        </div>
                                        @php
                                            if (!empty($Coupon) || $Coupon != '')
                                            {
                                                if ($Coupon['type'] == 'P')
                                                {
                                                    $couponcode = ($subtotal * $Coupon['discount']) / 100;
                                                }
                                                if ($Coupon['type'] == 'F')
                                                {
                                                    $couponcode = $Coupon['discount'];
                                                }
                                                $total = $subtotal - $couponcode + $delivery_charge;
                                            }
                                            else
                                            {
                                                $total = $subtotal + $delivery_charge;
                                            }
                                        @endphp
                                        <div class="minicart-total">
                                            <ul class="minicart-list">
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr sub-total">
                                                        <label>Sub-Total</label>
                                                        @if (isset($subtotal))
                                                            <span>£ {{ $subtotal }}</span>
                                                        @else
                                                            <span>£ {{ $subtotal }}</span>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr del_charge">
                                                        <label>Delivery Charge</label>
                                                        <span>£ {{ $delivery_charge }}</span>
                                                    </div>
                                                </li>
                                                @if ( (isset($mycart['size']) && !empty($mycart['size'])) || (isset($mycart['withoutSize']) && !empty($mycart['withoutSize'])) )
                                                        <li class="minicart-list-item">
                                                            <div class="minicart-list-item-innr coupon_code">
                                                                @if ($Coupon != '' || !empty($Coupon))
                                                                    <label id="coupontext">Coupon({{ $Coupon['code'] }})</label>
                                                                    <span>£ -{{ isset($couponcode) ? $couponcode : '' }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="minicart-list-item-innr addcoupon">
                                                                <label>
                                                                    @if ($Coupon != '' || !empty($Coupon))
                                                                        <a style="color: #ff0000;font-size:14px;" onclick="showcoupon();">
                                                                            Change Coupon Code
                                                                        </a>
                                                                    @else
                                                                        <a style="color: #ff0000;font-size:14px;" onclick="showcoupon();">
                                                                            Apply New Coupon Code
                                                                        </a>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            <div class="minicart-list-item-innr">
                                                                <div class="showcoupons">
                                                                    <form method="POST" id="from_showcoupon">
                                                                        @csrf
                                                                        <div class="myDiv" style="display:none;">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <input style="float:left;padding:5px 2px" type="text" name="coupon" value="" id="searchcoupon" placeholder="Enter your coupon here" class="coupon-val ">
                                                                                </div>
                                                                                <div class="col-md-4 text-right">
                                                                                    <input style="text-transform: uppercase;" type="submit" value="Apply" class="btn btn-danger ">
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div id="error"></div>
                                                                                    <div id="success"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                @else
                                                    <li class="minicart-list-item">
                                                        <div class="minicart-list-item-innr coupon_code">

                                                        </div>
                                                    </li>
                                                @endif
                                                <li class="minicart-list-item">
                                                    <div class="minicart-list-item-innr total">
                                                        <label>Total to pay:</label>
                                                        <span>£ {{ isset($total) ? $total : '' }}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="order_type_top" class="order-type">
                                            @if ($delivery_setting['enable_delivery'] != 'delivery')
                                                <div class="form-check m-auto">
                                                    @if ($delivery_setting['enable_delivery'] == 'collection')
                                                        <input class="form-check-input" type="radio"
                                                            name="delivery_type" id="collection"
                                                            {{ $delivery_setting['enable_delivery'] == 'collection' ? 'checked' : '' }}
                                                            value="collection">
                                                    @else
                                                        <input class="form-check-input" type="radio"
                                                            name="delivery_type" id="collection" value="collection"
                                                            {{ $user_delivery_type == 'collection' ? 'checked' : '' }}>
                                                    @endif
                                                    <label class="form-check-label" for="collection">
                                                        <h6>Collection</h6>
                                                    </label><br>
                                                    @php
                                                        $collectiondays = $openclose['collectiondays'];
                                                        $collectionfrom = $openclose['collectionfrom'];

                                                        $collection_same_bussiness = isset($openclose['collection_same_bussiness']) ? $openclose['collection_same_bussiness'] : '';
                                                    @endphp
                                                    @if ($collection_same_bussiness == 1)
                                                        <span>{{ $openclose['collection_gaptime'] ? $openclose['collection_gaptime'] : 'Select' }}
                                                            Min</span>
                                                    @else
                                                        @foreach ($collectiondays as $key => $item)
                                                            @foreach ($item as $value)
                                                                @php
                                                                    $t = count($item) - 1;
                                                                    $firstday = $item[0];
                                                                    $lastday = $item[$t];
                                                                    $today = date('l');
                                                                @endphp
                                                                @if ($today == $value)
                                                                    <span>Starts at -
                                                                        <b>{{ $collectionfrom[$key] }}</b></span>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                                <div class="form-check m-auto">
                                                    <input class="form-check-input" type="radio" name="delivery_type"
                                                        id="delivery"
                                                        {{ $user_delivery_type == 'delivery' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="delivery">
                                                        <h6>Delivery</h6>
                                                    </label><br>
                                                    @php
                                                        $deliverydays = $openclose['deliverydays'];
                                                        $deliveryfrom = $openclose['deliveryfrom'];

                                                        $delivery_same_bussiness = isset($openclose['delivery_same_bussiness']) ? $openclose['delivery_same_bussiness'] : '';
                                                    @endphp
                                                    @if ($delivery_same_bussiness == 1)
                                                        <span>{{ $openclose['delivery_gaptime'] ? $openclose['delivery_gaptime'] : 'Select' }}
                                                            Min</b></span>
                                                    @else
                                                        @foreach ($deliverydays as $key => $item)
                                                            @foreach ($item as $value)
                                                                @php
                                                                    $t = count($item) - 1;
                                                                    $firstday = $item[0];
                                                                    $lastday = $item[$t];
                                                                    $today = date('l');
                                                                @endphp
                                                                @if ($today == $value)
                                                                    <span>Starts at -
                                                                        <b>{{ $deliveryfrom[$key] }}</b></span>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach ($openday as $key => $item)
                                @foreach ($item as $value)
                                    @php
                                        $firsttime = strtotime($fromtime[$key]);
                                        $lasttime = strtotime($totime[$key]);
                                        $today = time();
                                        $currentday = date('l');
                                    @endphp
                                    @if ($today >= $firsttime && $today <= $lasttime)
                                        @if ($currentday == $value)
                                            @if (!empty($mycart) || $mycart != '')
                                                <a href="{{ route('checkout') }}" class="btn checkbt"
                                                    style="background-color: green; color:white;">Checkout</a>
                                            @else
                                                <a href="{{ route('cart') }}" class="btn checkbt"
                                                    style="background-color: green; color:white;">Checkout</a>
                                            @endif
                                            <div class="closed-now">
                                                <span class="closing-text" style="color: green !important;">We are
                                                    open now!</span>
                                            </div>
                                        @endif
                                    @else
                                        @if ($currentday == $value)
                                            <div class="closed-now">
                                                <button class="btn w-100 checkbt" disabled
                                                    style="cursor: not-allowed; pointer-events: auto; color:black;">Checkout</button>
                                                <div class="closed-now">
                                                    <span class="closing-text">We are closed now!</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade csmodal" id="pricemodel" tabindex="-1" aria-labelledby="pricemodelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="pricemodelLabel">Order Now</h5>
                    <p>Minimum delivery is £15.00</p>
                    <button class="btn csmodal-btn" onclick="showmodal();">Deliver my order</button>
                    <button class="btn csmodal-btn" data-bs-dismiss="modal">I will come and collect</button>
                    <button type="button" class="btn csmodal-btn-close" data-bs-dismiss="modal">Cancel and go
                        back</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade csmodal" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <h5 class="modal-title" id="ModalLabel">Please Enter Your Post Code</h5>
                        <div class="controls">
                            @if ($delivery_setting['enable_delivery'] != 'collection')
                                <div class="srch-input">
                                    @if ($delivery_setting['delivery_option'] == 'area')
                                        <select name="search_input2" class="form-control" id="search_store">
                                            <option value="">Select Area</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area }}">{{ $area }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input id="search_input1" placeholder="AB10 1BW" type="text" />
                                        <img id="loading_icon1" src="{{ asset('public/admin/gif/gif4.gif') }}"
                                            style="float: left; position: absolute; top: 50%; left: 48%; display: none;" />
                                    @endif
                                    <div class="text-danger mb-3" style="display: none;" id="search_result1"></div>
                                </div>
                                <div class="enter_postcode">
                                    <p>Please enter your postcode to view our menu and place an order</p>
                                </div>
                            @endif
                        </div>
                        @if ($delivery_setting['enable_delivery'] != 'delivery')
                            <a class="btn csmodal-btn collection_button2">I will come and Collect</a>
                        @endif
                        @if ($delivery_setting['enable_delivery'] != 'collection')
                            <a class="btn csmodal-btn delivery_button2">Deliver my order</a><br>
                        @endif
                        <button type="button" class="btn csmodal-btn-close" data-bs-dismiss="modal">Cancel and go
                            back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
    $(document).ready(function()
    {
        var status = $('#user_delivery_val').val();
        var coll = $("input[name='delivery_type']:checked").val();

        if(coll == 'collection')
        {
            $('#Modal').modal('hide');
            return false;
        }

        if (status == '') {
            $('#Modal').modal('show');
        }

    });

    function showmodal() {

        $('#Modal').modal('show');
        $('#pricemodel').modal('hide');
    }

    function showmodalproduct() {
        $('#Modal').modal('show');
    }
</script>

<script type="text/javascript">
    $("#mob-view").click(function() {
        TestsFunction();
        myFunction();
    });

    function TestsFunction() {
        var T = document.getElementById("minicart"),
            displayValue = "";
        if (T.style.display == "")
            displayValue = "block";

        T.style.display = displayValue;
        myFunction();
    }

    function myFunction() {
        if ($("#minicart").is(":visible")) {
            $("#tg-icon").html('<i class="fas fa-angle-double-down"></i>');
        } else {
            $("#tg-icon").html('<i class="fas fa-angle-double-up"></i>');
        }
    }
</script>

<script>
    function showId(product, sizeprice, uid)
    {
        var sizeid = sizeprice;
        var productid = product;
        var userid = uid;
        var status = $('#user_delivery_val').val();

        var coll = $("input[name='delivery_type']:checked").val();

        if (coll == 'collection')
        {
            $('#Modal').modal('hide');
        }
        else
        {
            if (status == '')
            {
                $('#Modal').modal('show');
                return false;
            }
        }


        $.ajax({
            type: 'post',
            url: '{{ route('getid') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'size_id': sizeid,
                'product_id': productid,
                'user_id': userid,
            },
            dataType: 'json',
            success: function(result)
            {
                // Cart Data
                $('.empty-box').html('');
                $('.empty-box').append(result.html);

                // Sub Total
                $('.sub-total').html('');
                $('.sub-total').append(result.subtotal);

                // Delivery Charge
                $('.del_charge').html('');
                $('.del_charge').append(result.delivery_charge);

                // Cart Products
                $('#cart_products').html('');
                $('#cart_products').append(result.cart_products);

                // Total Amount
                $('.total').html('');
                $('.total').append(result.total);

                // Header Total
                $('.pirce-value').text('');
                $('.pirce-value').append(result.headertotal);

                // Coupon
                $('.coupon_code').html('');
                $('.coupon_code').append(result.couponcode);

            }
        });
    }

    $('#collection').on('click', function() {
        var d_type = $(this).val();

        $.ajax({
            type: "POST",
            url: "{{ url('setDeliveyType') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'd_type': d_type,
            },
            dataType: "json",
            success: function(response) {
                location.reload();
            }
        });

    });

    $('#delivery').on('click', function() {
        $('#Modal').modal('show');
    });

    function deletecartproduct(prod_id, size_id, uid) {
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

    // $(".showcoupons").hide();
    function showcoupon() {

        $('.myDiv').toggle();
    }

    $('#from_showcoupon').submit(function(e) {
        e.preventDefault();
        var coupon = $("input[name='coupon']").val();

        $.ajax({
            type: 'post',
            url: '{{ url('getcoupon') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'coupon': coupon,
            },
            dataType: 'json',
            success: function(result)
            {
                if(result.errors == 1)
                {
                    $('#error').html('');
                    $('#error').append(result.errors_message);
                    $('#from_showcoupon').trigger('reset');
                    setTimeout(() => {
                        $('#error').html('');
                    }, 5000);
                }

                if(result.success == 1)
                {
                    $('#success').html('');
                    $('#success').append(result.success_message);

                    // Coupon Code
                    $('.coupon_code').html('');
                    $('.coupon_code').append(result.couponcode);

                    // Total
                    $('.total').html('');
                    $('.total').append(result.total);

                    // Header Total
                    $('.pirce-value').text('');
                    $('.pirce-value').append(result.headertotal);

                    $('#from_showcoupon').trigger('reset');

                    setTimeout(() => {
                        $('#success').html('');
                        $('.myDiv').hide();
                    }, 2000);
                }

            }
        });
    });
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> --}}
<script>

    // $('#searchcoupon').autocomplete({
    //     source: function(request, reponse) {

    //         $.ajax({
    //             url: "{{ url('searchcouponcode') }}",
    //             data: {
    //                 coupon: request.term
    //             },
    //             dataType: 'json',
    //             success: function(data) {
    //                 reponse($.map(data, function(object) {
    //                     // alert(object.code)
    //                     return {
    //                         label: object.code,
    //                         code: object.code,

    //                     };
    //                 }));
    //             }
    //         });
    //     },

    //     minLength: 1,
    //     delay: 500,

    //     select: function(event, ui) {
    //         $('#searchcoupon').val(ui.item.code);
    //         //  return false;
    //     },

    //     messages: {
    //         noResults: '',
    //         results: function() {}
    //     }

    // });

</script>

</html>
