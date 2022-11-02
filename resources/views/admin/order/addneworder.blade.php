<!--
    THIS IS ADD NEW ORDER PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    addneworder.blade.php
    it is used for add new order from admin.
    There are 6 Tabs in This Page Like
    ----------------------------------------
    - Customer Details
    - Payment Details
    - Shipping Details
    - Products
    - Vouchers
    - Totals
    ----------------------------------------------------------------------------------------------
-->


<!-- Header -->
@include('header')
<!-- End Header -->

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

@php

    $admincartdata=session()->get('admincart');
    $service=session()->get('service');
    $admin_couponcode=session()->get('admin_couponcode');
    $admin_couponcode_name=session()->get('admin_couponcode_name');
    $admin_vouchers_name=session()->get('admin_vouchers_name');
    $admin_vouchers_amount=session()->get('admin_vouchers_amount');

    $sub_total = session()->get('admincarttotal');

    $totals = $sub_total - $admin_couponcode - $admin_vouchers_amount + $service;



@endphp


<!-- Section of Add Order -->
<section>
    <div class="content-wrapper">
        <!-- Breadcumb Section -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                    <!-- Breadcrumb Start -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('orders') }}">Orders</a></li>
                            <li class="breadcrumb-item active">Insert</li>
                        </ol>
                    </div>
                    <!-- End Breadcumb -->
                </div>
            </div>
        </section>
        <!-- End Breadcumb Section -->

        <!-- Insert Data Section -->
        <section class="content">
            <div class="container-fluid">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Warning: Please check the form carefully for errors!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(Session::has('empty_error'))
                        <div class="row mt-1 mb-1">
                            <div class="col-md-12">
                                <div class="alert alert-danger del-alert alert-dismissible" id="alert" role="alert">
                                    {{ Session::get('empty_error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                <div class="row">
                    <div class="col-md-12">
                        <!-- Card -->
                        <div class="card">
                            <!-- Form -->
                            <form action="{{ route('addneworders') }}" id="catform" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                <!-- Card Header -->
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('orders') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Card Header -->

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Tabs Link -->
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab"
                                            href="#nav-customer" role="tab" aria-controls="nav-customer"
                                            aria-selected="true">Customer Details</a>
                                        <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab" href="#nav-payment"
                                            role="tab" aria-controls="nav-payment" aria-selected="false">Payment Details</a>
                                        <a class="nav-item nav-link" id="nav-shipping-tab" data-toggle="tab" href="#nav-shipping"
                                            role="tab" aria-controls="nav-shipping" aria-selected="false">Shipping Details</a>
                                        <a class="nav-item nav-link" id="nav-product-tab" data-toggle="tab" href="#nav-product"
                                            role="tab" aria-controls="nav-product" aria-selected="false">Products</a>
                                        <a class="nav-item nav-link" id="nav-vouchers-tab" data-toggle="tab" href="#nav-vouchers"
                                            role="tab" aria-controls="nav-vouchers" aria-selected="false">Vouchers</a>
                                        <a class="nav-item nav-link" id="nav-totals-tab" data-toggle="tab" href="#nav-totals"
                                            role="tab" aria-controls="nav-totals" aria-selected="false">Totals</a>
                                    </div>
                                    <!-- End Tabs Link -->

                                    <!-- Tabs Content -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- Customer Details Tab -->
                                        <div class="tab-pane fade show active" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
                                            <div class="col-md-12">
                                                <h3 class="mt-3 mb-3">Customer Details</h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="store"><span class="text-danger">*</span>Store</label>
                                                            <select class="form-control {{ ($errors->has('storename')) ? 'is-invalid' : '' }}" name="storename" id="store">
                                                                <option value="">Default</option>
                                                                @foreach ($stores as $store)
                                                                    <option value="{{ $store->store_id }}" {{ (old('storename') == $store->store_id) ? 'selected' : '' }}>
                                                                        {{ htmlspecialchars_decode($store->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('storename'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('storename') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group" id="#search">
                                                            <label for="cname">Customer</label>
                                                            <input type="text" id="cname" name="cname" value="{{ old('cname') }}" class="form-control" placeholder="Search & Select Customer">
                                                            <input type="hidden" name="customerid" id="customerid" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div id="loader" style="margin-top: 35px;display:none;">
                                                            <img src="{{ asset('public/admin/gif/gif4.gif') }}" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="customer_group">Customer Group</label>
                                                            <select class="form-control" name="cgroup" id="customer_group">
                                                                @foreach ($Customers as $Customer)
                                                                    <option value="{{ $Customer->customer_group_id }}" {{ (old('cgroup') == $Customer->customer_group_id) ? 'selected' : '' }}>
                                                                        {{ $Customer->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email"><span class="text-danger">*</span> E-Mail</label>
                                                            <input class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}" type="text"
                                                            placeholder="Email">
                                                            @if($errors->has('email'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('email') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fname"><span class="text-danger">*</span> First Name</label>
                                                            <input class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" name="firstname" id="fname" type="text" value="{{ old('firstname') }}" placeholder="First name">
                                                            @if($errors->has('firstname'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('firstname') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lname"><span class="text-danger">*</span> Last Name</label>
                                                            <input class="form-control {{ ($errors->has('lastname')) ? 'is-invalid' : '' }}" name="lastname" id="lname" value="{{ old('lastname') }}" type="text"
                                                            placeholder="Last name">
                                                            @if($errors->has('lastname'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('lastname') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone"><span class="text-danger">*</span> Telephone</label>
                                                            <input class="form-control {{ ($errors->has('phone')) ? 'is-invalid' : '' }}" name="phone" id="phone" value="{{ old('phone') }}" type="text"
                                                            placeholder="Telehone">
                                                            @if($errors->has('phone'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('phone') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fax">Fax</label>
                                                            <input class="form-control" name="fax" id="fax" value="{{ old('fax') }}" type="text" placeholder="Fax">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Customer Details Tab -->

                                        <!-- Payment Details Tab -->
                                        <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                                            <div class="col-md-12">
                                                <h3 class="mt-3 mb-3">Payment Details</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="payment_address">Choose Address</label>
                                                            <select class="form-control address" id="payment_address" name="payment_address">
                                                                <option>--None--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_firstname"><span class="text-danger">*</span> First Name</label>
                                                            <input class="form-control {{ ($errors->has('payment_firstname')) ? 'is-invalid' : '' }}" name="payment_firstname" id="payment_firstname" value="{{ old('payment_firstname') }}" type="text" placeholder="First name">
                                                            @if($errors->has('payment_firstname'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('payment_firstname') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_lastname"><span class="text-danger">*</span> Last Name</label>
                                                            <input class="form-control {{ ($errors->has('payment_lastname')) ? 'is-invalid' : '' }}" name="payment_lastname" id="payment_lastname" value="{{ old('payment_lastname') }}" type="text" placeholder="Last name">
                                                            @if($errors->has('payment_lastname'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('payment_lastname') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_company">Company</label>
                                                            <input class="form-control" name="payment_company" id="payment_company" value="{{ old('payment_company') }}" type="text" placeholder="Company">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_company_id">Company ID</label>
                                                            <input class="form-control" name="payment_company_id" id="payment_company_id" value="{{ old('payment_company_id') }}" type="text" placeholder="Company id">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_address_1">
                                                                <span class="text-danger">*</span> Address 1
                                                            </label>
                                                            <input class="form-control {{ ($errors->has('payment_address_1')) ? 'is-invalid' : '' }}" name="payment_address_1" id="payment_address_1" value="{{ old('payment_address_1') }}" type="text" placeholder="Address 1">
                                                            @if($errors->has('payment_address_1'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('payment_address_1') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_address_2">Address 2</label>
                                                            <input class="form-control" name="payment_address_2" id="payment_address_2" value="{{ old('payment_address_2') }}" type="text" placeholder="Address 2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_city"><span class="text-danger">*</span> City</label>
                                                            <input class="form-control {{ ($errors->has('payment_city')) ? 'is-invalid' : '' }}" name="payment_city" id="payment_city" value="{{ old('payment_city') }}" type="text"
                                                            placeholder="City">
                                                            @if($errors->has('payment_city'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('payment_city') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_postcode">Postcode</label>
                                                            <input class="form-control" name="payment_postcode" id="payment_postcode" type="text" value="{{ old('payment_postcode') }}" placeholder="Postcode">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_country_id">
                                                                <span class="text-danger">*</span> Country
                                                            </label>
                                                            <select class="form-control payment_country_id {{ ($errors->has('payment_country_id')) ? 'is-invalid' : '' }}" name="payment_country_id" id="payment_country_id"
                                                                onchange="payment_region();">
                                                                <option value="">Select Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('payment_country_id'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('payment_country_id') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_region_id"><span class="text-danger">*</span> Region / State</label>
                                                            <select class="form-control payment_region_id {{ ($errors->has('payment_region_id')) ? 'is-invalid' : '' }}" name="payment_region_id" id="payment_region_id">
                                                                <option value="">Select Region/State</option>
                                                            </select>
                                                            @if($errors->has('payment_region_id'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('payment_region_id') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Payments Detail Tab -->

                                        <!-- Shiping Details Tab -->
                                        <div class="tab-pane fade" id="nav-shipping" role="tabpanel"
                                        aria-labelledby="nav-shipping-tab">
                                            <div class="col-md-12">
                                                <h3 class="mt-3 mb-3">Shiping Details</h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_address">Choose Address</label>
                                                            <select class="form-control address" id="shipping_address" name="shipping_address">
                                                                <option>--None--</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_company">Company</label>
                                                            <input class="form-control" name="shipping_company" id="shipping_company" value="{{ old('shipping_company') }}" type="text" placeholder="Company">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_firstname"><span class="text-danger">*</span> First Name</label>
                                                            <input class="form-control {{ ($errors->has('shipping_firstname')) ? 'is-invalid' : '' }}" name="shipping_firstname" id="shipping_firstname" value="{{ old('shipping_firstname') }}" type="text" placeholder="First name">
                                                            @if($errors->has('shipping_firstname'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('shipping_firstname') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_lastname"><span class="text-danger">*</span> Last Name</label>
                                                            <input class="form-control {{ ($errors->has('shipping_lastname')) ? 'is-invalid' : '' }}" name="shipping_lastname" id="shipping_lastname" value="{{ old('shipping_lastname') }}" type="text" placeholder="Last name">
                                                            @if($errors->has('shipping_lastname'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('shipping_lastname') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_address_1">
                                                                <span class="text-danger">*</span> Address 1
                                                            </label>
                                                            <input class="form-control {{ ($errors->has('shipping_address_1')) ? 'is-invalid' : '' }}" name="shipping_address_1" id="shipping_address_1" value="{{ old('shipping_address_1') }}" type="text" placeholder="Address 1">
                                                            @if($errors->has('shipping_address_1'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('shipping_address_1') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_address_2">Address 2</label>
                                                            <input class="form-control" name="shipping_address_2" id="shipping_address_2" value="{{ old('shipping_address_2') }}" type="text" placeholder="Address 2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_city"><span class="text-danger">*</span> City</label>
                                                            <input class="form-control {{ ($errors->has('shipping_city')) ? 'is-invalid' : '' }}" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" type="text"
                                                            placeholder="City">
                                                            @if($errors->has('shipping_city'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('shipping_city') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_postcode">Postcode</label>
                                                            <input class="form-control" name="shipping_postcode" id="shipping_postcode" type="text" value="{{ old('shipping_postcode') }}" placeholder="Postcode">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_country_id">
                                                                <span class="text-danger">*</span> Country
                                                            </label>
                                                            <select class="form-control shipping_country_id {{ ($errors->has('shipping_country_id')) ? 'is-invalid' : '' }}" name="shipping_country_id" id="shipping_country_id"
                                                                onchange="shipping_region();">
                                                                <option value="">Select Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('shipping_country_id'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('shipping_country_id') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_region_id"><span class="text-danger">*</span> Region / State</label>
                                                            <select class="form-control shipping_region_id {{ ($errors->has('shipping_region_id')) ? 'is-invalid' : '' }}" name="shipping_region_id" id="shipping_region_id">
                                                                <option value="">Select Region/State</option>
                                                            </select>
                                                            @if($errors->has('shipping_region_id'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('shipping_region_id') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Shiping Details Tab -->

                                        <!-- Product Tab -->
                                        <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                                            <div class="col-md-12">
                                                <h3 class="mt-3 mb-3">Products</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Delete</th>
                                                                    <th>Product</th>
                                                                    <th>Model</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit Price</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody">
                                                                @if(isset($admincartdata))
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp

                                                                    @foreach ($admincartdata as $value)
                                                                        <tr>
                                                                            <td>
                                                                                <a class="btn btn-sm btn-danger ml-1 deletesellected" onclick="deleteproductcart({{$value['product_id']}})" >
                                                                                <i class="fa fa-trash" ></i>
                                                                                </a>
                                                                        </td>
                                                                            <td>{{$value['p_name']}}</td>
                                                                            <td>{{ $value['p_model'] ? $value['p_model'] : '-'}}</td>
                                                                            <td>{{ $value['p_quantity'] }}</td>
                                                                            <td>{{ $value['p_price'] }}</td>
                                                                            <td>{{ $value['total'] }}</td>
                                                                        </tr>

                                                                        @php
                                                                            $total +=$value['total'];
                                                                        @endphp

                                                                    @endforeach

                                                                    <tr>
                                                                        <td colspan="4"></td>
                                                                        <td><b>SubTotal</b></td>
                                                                        <td>{{$total}}</td>
                                                                    </tr>

                                                                    @if(!empty($admin_couponcode) || $admin_couponcode != '' &&  !empty($admin_couponcode_name) || $admin_couponcode_name != '')
                                                                        <tr class="coupon">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Coupon({{$admin_couponcode_name}})</b></td>
                                                                            <td> - {{  $admin_couponcode}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if(!empty($admin_vouchers_amount) || $admin_vouchers_amount != '' &&  !empty($admin_vouchers_name) || $admin_vouchers_name != '')
                                                                        <tr class="voucher">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Voucher({{$admin_vouchers_name}})</b></td>
                                                                            <td> - {{  $admin_vouchers_amount}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if(!empty($service) || $service != '')
                                                                        <tr class="service_charge">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Service_Charge</b></td>
                                                                            <td> {{  $service}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if(!empty($totals) || $totals != '')
                                                                        <tr class="Total">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Total</b></td>
                                                                            <td>{{  $totals}}</td>
                                                                        </tr>
                                                                    @endif
                                                                @else
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">
                                                                            Products Not Avavilable
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2">Add Products</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Choose Product</td>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-md-10">
                                                                                <input type="text" id="productname" name="productname" value="" class="form-control" placeholder="Product name">
                                                                                <input type="hidden" id="productid" class="form-control" value="">
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div id="loader2" style="margin-top: 10px;display:none;">
                                                                                    <img src="{{ asset('public/admin/gif/gif4.gif') }}" width="25">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Quantity</td>
                                                                    <td>
                                                                        <input class="form-control" name="quantity" id="quantity" type="text"  placeholder="Qty.">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2" class="text-center">
                                                                        <a class="btn btn-sm btn-primary" onclick="add_product()">
                                                                            ADD PRODUCT
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Product Tab -->

                                        <!-- Vouchers Tab -->
                                        <div class="tab-pane fade show" id="nav-vouchers" role="tabpanel"
                                        aria-labelledby="nav-vouchers-tab">
                                            <div class="col-md-12">
                                                <h3 class="mt-3 mb-3">Vouchers</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Delete</th>
                                                                    <th>Product</th>
                                                                    <th>Model</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit Price</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                                <tbody class="tbody">
                                                                    @if(isset($admincartdata))
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp
                                                                        @foreach ($admincartdata as $value)
                                                                        <tr>
                                                                            <td>
                                                                                <a class="btn btn-sm btn-danger ml-1 deletesellected" onclick="deleteproductcart({{$value['product_id']}})" >
                                                                                <i class="fa fa-trash" ></i>
                                                                                </a>
                                                                           </td>
                                                                            <td>{{$value['p_name']}}</td>
                                                                            <td>{{ $value['p_model'] ? $value['p_model'] : '-'}}</td>
                                                                            <td>{{ $value['p_quantity'] }}</td>
                                                                            <td>{{ $value['p_price'] }}</td>
                                                                            <td>{{ $value['total'] }}</td>
                                                                        </tr>
                                                                        @php
                                                                             $total +=$value['total'];
                                                                        @endphp
                                                                        @endforeach
                                                                        <tr>
                                                                            <td colspan="4"></td>
                                                                            <td><b>SubTotal</b></td>
                                                                            <td>{{$total}}</td>
                                                                        </tr>
                                                                        @if((!empty($admin_couponcode) || $admin_couponcode != '') &&  (!empty($admin_couponcode_name) || $admin_couponcode_name != ''))
                                                                        <tr class="coupon">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Coupon({{$admin_couponcode_name}})</b></td>
                                                                            <td> - {{  $admin_couponcode}}</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if((!empty($admin_vouchers_amount) || $admin_vouchers_amount != '') && ( !empty($admin_vouchers_name) || $admin_vouchers_name != ''))
                                                                        <tr class="voucher">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Voucher({{$admin_vouchers_name}})</b></td>
                                                                            <td> - {{  $admin_vouchers_amount}}</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if(!empty($service) || $service != '')
                                                                        <tr class="service_charge">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Service_Charge</b></td>
                                                                            <td> {{  $service}}</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if(!empty($totals) || $totals != '')
                                                                        <tr class="Total">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Total</b></td>
                                                                            <td>{{  $totals}}</td>
                                                                        </tr>
                                                                        @endif

                                                                    @else
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">
                                                                                Products Not Avavilable
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2">Add Vouchers</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><span class="text-danger">*</span> Recipient's Name</td>
                                                                    <td>
                                                                        <input type="text" name="rname" id="rname" class="form-control" placeholder="To : John Doe">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span class="text-danger">*</span> Recipient's Email</td>
                                                                    <td>
                                                                        <input type="text" name="remail" id="remail" class="form-control" placeholder="To : johndoe@gmail.com">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span class="text-danger">*</span> Sender's Name</td>
                                                                    <td>
                                                                        <input type="text" name="sname" id="sname" class="form-control" placeholder="From : Kim Dew">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span class="text-danger">*</span> Senders's Email</td>
                                                                    <td>
                                                                        <input type="text" name="semail" id="semail" class="form-control" placeholder="From : kimdew@gmail.com">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Gift Certificate Theme</td>
                                                                    <td>
                                                                        <select name="theme" id="theme" class="form-control">
                                                                           @foreach ($voucherthemes as $theme)
                                                                               <option value="{{ $theme->voucher_theme_id }}">{{ $theme->name }}</option>
                                                                           @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Message</td>
                                                                    <td>
                                                                        <textarea name="voucher_message" id="voucher_message" class="form-control" placeholder="Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi, mollitia."></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Amount</td>
                                                                    <td>
                                                                        <input type="number" name="voucher_amount" class="form-control" id="voucher_amount" value="25.00">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2" class="text-center">
                                                                        <a class="btn btn-sm btn-primary">
                                                                            ADD VOUCHER
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Vouchers Tab -->

                                        <!-- Totals Tab -->
                                        <div class="tab-pane fade show" id="nav-totals" role="tabpanel"
                                        aria-labelledby="nav-totals-tab">
                                            <div class="col-md-12">
                                                <h3 class="mt-3 mb-3">Totals</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Delete</th>
                                                                    <th>Product</th>
                                                                    <th>Model</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit Price</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody">
                                                                @if(isset($admincartdata))
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp

                                                                    @foreach ($admincartdata as $value)
                                                                        <tr>
                                                                            <td>
                                                                                <a class="btn btn-sm btn-danger ml-1 deletesellected" onclick="deleteproductcart({{$value['product_id']}})" >
                                                                                    <i class="fa fa-trash" ></i>
                                                                                </a>
                                                                            </td>
                                                                            <td>{{$value['p_name']}}</td>
                                                                            <td>{{ $value['p_model'] ? $value['p_model'] : '-'}}</td>
                                                                            <td>{{ $value['p_quantity'] }}</td>
                                                                            <td>{{ $value['p_price'] }}</td>
                                                                            <td>{{ $value['total'] }}</td>
                                                                        </tr>

                                                                        @php
                                                                            $total +=$value['total'];
                                                                        @endphp
                                                                    @endforeach

                                                                    <tr class="subtotal">
                                                                        <td colspan="4"></td>
                                                                        <td><b>SubTotal</b></td>
                                                                        <td>{{$total}}</td>
                                                                    </tr>

                                                                    @if(!empty($admin_couponcode) || $admin_couponcode != '' &&  !empty($admin_couponcode_name) || $admin_couponcode_name != '')
                                                                        <tr class="coupon">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Coupon({{$admin_couponcode_name}})</b></td>
                                                                            <td> - {{  $admin_couponcode}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if(!empty($admin_vouchers_amount) || $admin_vouchers_amount != '' &&  !empty($admin_vouchers_name) || $admin_vouchers_name != '')
                                                                        <tr class="voucher">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Voucher({{$admin_vouchers_name}})</b></td>
                                                                            <td> - {{  $admin_vouchers_amount}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if(!empty($service) || $service != '')
                                                                        <tr class="service_charge">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Service_Charge</b></td>
                                                                            <td> {{  $service}}</td>
                                                                        </tr>
                                                                    @endif

                                                                    @if(!empty($totals) || $totals != '')
                                                                        <tr class="Total">
                                                                            <td colspan="4"></td>
                                                                            <td><b>Total</b></td>
                                                                            <td>{{  $totals}}</td>
                                                                        </tr>
                                                                    @endif
                                                                @else
                                                                    <tr>
                                                                        <td colspan="6" class="text-center">
                                                                            Products Not Avavilable
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2">Order Details</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Shipping Method</td>
                                                                    <td>
                                                                        <select name="shipping_method" id="shipping_method" class="form-control">
                                                                            <option value=""> -- Select -- </option>
                                                                            <option value="collection" {{ (old('shipping_method') == 'collection') ? 'selected' : "" }}>collection</option>
                                                                            <option value="delivery" {{ (old('shipping_method') == 'delivery') ? 'selected' : "" }}>delivery</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span class="text-danger">*</span>Payment Method</td>
                                                                    <td>
                                                                        <select name="payment_method" id="payment_method" class="form-control {{ ($errors->has('payment_method')) ? 'is-invalid' : '' }}">
                                                                            <option value=""> -- Select -- </option>
                                                                            <option value="3" {{ (old('payment_method') == 3) ? 'selected' : "" }}>cod</option>
                                                                            <option value="2" {{ (old('payment_method') == 2) ? 'selected' : "" }}>paypal</option>
                                                                            <option value="1" {{ (old('payment_method') == 1) ? 'selected' : "" }}>stripe</option>
                                                                        </select>
                                                                        @if($errors->has('payment_method'))
                                                                            <div class="invalid-feedback">
                                                                                {{ $errors->first('payment_method') }}
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Coupon</td>
                                                                    <td>
                                                                        <input type="text" name="coupon" id="coupon" class="form-control">
                                                                        <p class="text-danger" id="couponError" style="text-align: left"></p>
                                                                        <p class="text-success" id="couponSuccess" style="text-align: left"></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Voucher</td>
                                                                    <td>
                                                                        <input type="text" name="voucher" id="voucher" class="form-control">
                                                                        <p class="text-danger" id="voucherError" style="text-align: left"></p>
                                                                        <p class="text-success" id="voucherSuccess" style="text-align: left"></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reward</td>
                                                                    <td>
                                                                        <input type="text" name="reward" id="reward" class="form-control">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Order Status</td>
                                                                    <td>
                                                                        <select name="theme" id="theme" class="form-control">
                                                                        @foreach ($orderstatus as $status)
                                                                            <option value="{{ $status->order_status_id }}" {{ (old('theme') == $status->order_status_id) ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Comment</td>
                                                                    <td>
                                                                        <textarea name="comment" id="comment" class="form-control"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Affiliate</td>
                                                                    <td>
                                                                        <input type="text" name="affiliate" class="form-control" id="affiliate">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2" class="text-center">
                                                                        <a class="btn btn-sm btn-primary" onclick="updateTotal();">
                                                                            UPDATE TOTALS
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Totals Tab -->
                                    </div>
                                    <!-- End Tabs Content -->
                                </div>
                                <!-- End Card Body -->
                            </form>
                            <!-- End Form -->
                        </div>
                        <!-- End Card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Form Section -->
    </div>
</section>
<!-- End Section of Add Category -->


<!-- Footer Section -->
@include('footer')
<!-- End Footer Section -->


<!-- SCRIPT -->
<script type="text/javascript">

    // Function Of Get Payment Region By Country ID
    function payment_region()
    {
        var country_id = $('#payment_country_id :selected').val();
        $.ajax({
                type: "POST",
                url: "{{ url('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}",},
                dataType: "json",
                success: function(response)
                {
                    $('.payment_region_id').text('');
                    $('.payment_region_id').append(response);
                }
        });
    }
    // End Function Of Get Payment Region By Country ID


    // Get Payment Address By Customer Address ID
    $('#payment_address').on('change', function()
    {
        var payment_address_id = $(this).val();
        $.ajax({
                type: "GET",
                url: "{{ url('payment_and_shipping_address') }}/" + payment_address_id,
                dataType: "json",
                success: function(response)
                {
                    $('#payment_firstname').val(response.firstname);
                    $('#payment_lastname').val(response.lastname);
                    $('#payment_company').val(response.company);
                    $('#payment_company_id').val(response.company_id);
                    $('#payment_address_1').val(response.address_1);
                    $('#payment_address_2').val(response.address_2);
                    $('#payment_city').val(response.city);
                    $('#payment_postcode').val(response.postcode);
                }
        });
    });
    // End Get Payment Address By Customer ID


    // Get Shipping Address By Customer Address ID
     $('#shipping_address').on('change', function()
     {
        var shipping_address_id = $(this).val();
        $.ajax({
                type: "get",
                url: "{{ url('payment_and_shipping_address') }}/" + shipping_address_id,
                dataType: "json",
                success: function(response)
                {
                    $('#shipping_firstname').val(response.firstname);
                    $('#shipping_lastname').val(response.lastname);
                    $('#shipping_company').val(response.company);
                    $('#shipping_address_1').val(response.address_1);
                    $('#shipping_address_2').val(response.address_2);
                    $('#shipping_city').val(response.city);
                    $('#shipping_postcode').val(response.postcode);
                }
        });
    });
    // End Get Shipping Address By Customer Address ID


    // Function Of Get Payment Region By Country ID
    function shipping_region()
    {
        var country_id = $('#shipping_country_id :selected').val();
        $.ajax({
                type: "POST",
                url: "{{ url('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}",},
                dataType: "json",
                success: function(response)
                {
                    $('.shipping_region_id').text('');
                    $('.shipping_region_id').append(response);
                }
        });
    }
    // End Function Of Get Payment Region By Country ID

    // Get Customer Details
    $('#cname').autocomplete({
        source: function(requete, reponse) {
            var select_store_id = $('#store :selected').val();

            if(select_store_id != '' || select_store_id != 0)
            {
                $.ajax({
                    url: "{{ url('autocomplete') }}",
                    data: {
                        term: requete.term,
                        select_store_id: select_store_id
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(data) {
                        $('#loader').hide();
                        reponse($.map(data, function(object) {
                            return {
                                customer_id: object.customer_id,
                                label: object.firstname + " " + object.lastname,
                                fname: object.firstname,
                                lname: object.lastname,
                                email: object.email,
                                fax: object.fax,
                                phone: object.telephone,
                            };
                        }));
                    }
                });
            }
            else
            {
                alert('Please Select Store To find Customers !');
                return false;
            }
        },

        minLength: 1,
        delay: 500,

        select: function(event, ui) {
            $(' #fname ').val(ui.item.fname);
            $(' #lname ').val(ui.item.lname);
            $(' #email ').val(ui.item.email);
            $(' #customerid ').val(ui.item.customer_id);
            $(' #fax ').val(ui.item.fax);
            $(' #phone ').val(ui.item.phone);

            // Get address
            var customerid = $(' #customerid ').val();
            $.ajax({
                type: "get",
                url: "{{ url('getaddress') }}/" + customerid,
                dataType: "json",
                success: function(response) {
                    $('.address').html(response);
                }
            });
            var customerid = $(' #customerid ').val();
            $.ajax({
                type: "get",
                url: "{{ url('getproducts') }}/" + customerid,
                dataType: "json",
                success: function(response) {
                    $('.productdata').html(response);
                }
            });
        },

        messages: {
            noResults: '',
            results: function() {}
        }

    });


    // for html code decode
    function htmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }

    // Product AutoComplete
    $('#productname').autocomplete({
        source: function(requete, reponse) {

            var select_store_id = $('#store :selected').val();

            if(select_store_id != '' || select_store_id != 0)
            {
                $.ajax({
                    url: "{{ url('autocompleteproduct') }}",
                    data: {
                        product: requete.term,
                        select_store_id: select_store_id
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loader2').show();
                    },
                    success: function(data) {
                        $('#loader2').hide();
                        reponse($.map(data, function(object) {
                            return {
                                // customer_id: object.,
                                label: htmlDecode(object.name),
                                proid: object.product_id

                            };
                        }));
                    }
                });
            }
            else
            {
                alert('Please Select Store To find Store Products !');
                return false;
            }
        },

        minLength: 1,
        delay: 500,

        select: function(event, ui) {
            $('#productid').val(ui.item.proid);
            //  return false;
        },

        messages: {
            noResults: '',
            results: function() {}
        }
    });


    // Add Product
    function add_product()
    {
        var product_id =$("#productid").val();
        var store_id =$("#store_id").val();
        var quantity = $("input[name=quantity]").val();

        if (product_id != '' && quantity != '')
        {
            $.ajax({
                type: "post",
                url: "{{ route('adminaddtocart') }}",
                data: {
                    product_id : product_id,
                    quantity   : quantity,
                    store_id   : store_id,
                },
                dataType: "json",
                success: function (response)
                {
                    $('.tbody').html('');
                    $('.tbody').html(response.html);
                    $('#productname').val('');
                    $('#productid').val('');
                    $('#quantity').val('');
                }
            });
        }else{
        alert('Product and quantity has been required')
        }
    }

      function deleteproductcart(id){
        var pro_id =id;
         $.ajax({
            type: "post",
            url: "{{ route('deleteproductcart') }}",
            data: {
                pro_id : pro_id,
            },
            dataType: "json",
            success: function (response) {
                $('.tbody').html('');
                $('.tbody').html(response.html);
            }
         });
      }
       function updateTotal(){

          var coupon = $("input[name='coupon']").val();
          var voucher = $("input[name='voucher']").val();
          var store_id =$('#store :selected').val();
          var shipping_method =$('#shipping_method :selected').val();
          var servicecharge =$('#payment_method :selected').val();
          var userid = $("#customerid").val();


          $.ajax({
            type: "post",
            url: "{{ route('applycouponvoucher') }}",
            data: {
                coupon   : coupon,
                voucher  : voucher,
                store_id : store_id,
                userid   : userid,
                shipping_method : shipping_method,
                servicecharge : servicecharge,
            },
            dataType: "json",
            success: function (response)
            {
                if(response.error == 1)
                {
                    $('#couponError').html('');
                    $('#couponError').append(response.error_msg);
                    setTimeout(() => {
                        $('#couponError').html('');
                    }, 10000);
                }
                if(response.errors == 1)
                {
                    $('#voucherError').html('');
                    $('#voucherError').append(response.error_msg_voucher);
                    setTimeout(() => {
                        $('#voucherError').html('');
                    }, 10000);
                }

                $('.subtotal').html('');
                $('.subtotal').html(response.subtotal);
                $('.coupon').html('');
                $('.coupon').html(response.coupons);
                $('.voucher').html('');
                $('.voucher').html(response.vouchers);
                $('.service_charge').html('');
                $('.service_charge').html(response.service);
                $('.Total').html('');
                $('.Total').html(response.totals);

            }
          });

       }

</script>
<!-- END SCRIPT -->
