{{--
    THIS IS ORDER VIEW PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    view.blade.php
    it is used for View Customers Orders and Other Details Like
    ------------------------------------------------------------
    - Order Details
    - Payment Details
    - Products
    - Order History
    - Print Order Invoice
    ----------------------------------------------------------------------------------------------
--}}

@php
    // $current_store_CurrencySymbol($store_setting['config_currency']);

@endphp

{{-- Header section --}}
@include('header')
{{-- End Header section --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Order View --}}
<section>
    <div class="content-wrapper">
        {{-- Breadcumb Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders View</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> <a href="{{ route('orders') }}">Orders</a></li>
                            <li class="breadcrumb-item active">Orders View</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Breadcumb Section --}}

        {{-- view Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Details
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if(check_user_role(71) == 1)
                                        <a href="{{ route('invoice',$orders->order_id) }}" target="_blank" class="btn btn-sm btn-info ml-auto">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('orders') }}" class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">

                                {{-- Tabs Link --}}
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-order-tab" data-toggle="tab"
                                        href="#nav-order" role="tab" aria-controls="nav-order"
                                        aria-selected="true">Order Details</a>
                                    <a class="nav-item nav-link" id="nav-payment-tab" data-toggle="tab"
                                        href="#nav-payment" role="tab" aria-controls="nav-payment"
                                        aria-selected="false">Payment Details</a>
                                    <a class="nav-item nav-link" id="nav-product-tab" data-toggle="tab"
                                        href="#nav-product" role="tab" aria-controls="nav-product"
                                        aria-selected="false">Products</a>
                                    <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab"
                                        href="#nav-history" role="tab" aria-controls="nav-history"
                                        aria-selected="false">History</a>
                                </div>
                                {{-- End Tabs Link --}}

                                {{-- Tabs Content --}}
                                <div class="tab-content" id="nav-tabContent">

                                    {{-- Order Details Tab --}}
                                    <div class="tab-pane fade show active" id="nav-order" role="tabpanel"
                                    aria-labelledby="nav-order-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3 class="text-center mt-3 mb-3">Order Details</h3>
                                                    {{-- Table --}}
                                                    <table class="table table-bordered table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>Order ID</th>
                                                                <td>
                                                                    #{{ isset($orders->order_id) ? $orders->order_id : "" }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Invoice No.</th>
                                                                <td>
                                                                    @if($orders->invoice_no != 0)

                                                                        {{ isset($orders->invoice_prefix) ? $orders->invoice_prefix : "" }}{{ isset($orders->invoice_no) ? $orders->invoice_no : "" }}
                                                                    @else
                                                                        <div id="Invoice" style="display: flex;">
                                                                            <b>[ <a class="text-primary" onclick="generateinvoice({{ isset($orders->order_id) ? $orders->order_id : "" }})" style="cursor: pointer">Generate</a> ]</b>
                                                                            <div class="gif-div ml-2" style="display: none;">
                                                                                <img src="{{ asset('public/admin/gif/gif3.gif') }}" width="30" class="text-danger">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Store Name</th>
                                                                <td>
                                                                    {{ isset($orders->store_name) ? $orders->store_name : ""}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Store Url</th>
                                                                <td><a href="{{ asset($orders->store_url) }}" target="_blank">{{ isset($orders->store_url) ? $orders->store_url : "" }}</a></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <td>
                                                                    {{ isset($orders->firstname) ? $orders->firstname : "" }} {{ isset($orders->lastname) ? $orders->lastname : "" }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="200">Customer Group</th>
                                                                <td>
                                                                    {{ isset($orders->hasOneCustomerGroupDescription->name) ?  $orders->hasOneCustomerGroupDescription->name : ""}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>E-Mail</th>
                                                                <td>{{ isset($orders->email) ? $orders->email : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Telephone</th>
                                                                <td>{{ isset($orders->telephone) ? $orders->telephone : "" }}</td>
                                                            </tr>
                                                            @php
                                                                $ordertotle = number_format($orders->total,2);
                                                            @endphp
                                                            <tr>
                                                                <th>Total</th>
                                                                <td>{{ $orders->hasOneCurrency['symbol_left'] }} {{ isset($ordertotle) ? $ordertotle : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Order Status</th>
                                                                <td>{{ isset($orders->hasOneOrderStatus->name) ? $orders->hasOneOrderStatus->name : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>IP Address</th>
                                                                <td>{{ isset($orders->ip) ? $orders->ip : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>User Agent</th>
                                                                <td>{{ isset($orders->user_agent) ? $orders->user_agent : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Accept Language</th>
                                                                <td>{{ isset($orders->accept_language) ? $orders->accept_language : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date Added</th>
                                                                <td>{{ isset($orders->date_added) ? $orders->date_added : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date Modified</th>
                                                                <td>{{ isset($orders->date_modified) ? $orders->date_modified : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Shipping Method</th>
                                                                <td>{{ isset($orders->flag_post_code) ? $orders->flag_post_code : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Free Item</th>
                                                                <td>{{ htmlspecialchars_decode($orders->free_item) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Time delivery</th>
                                                                <td>{{ isset($orders->timedelivery) ? $orders->timedelivery : "" }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- End Table --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Order Detail Tab --}}

                                    {{-- Payment Details --}}
                                    <div class="tab-pane fade" id="nav-payment" role="tabpanel"
                                    aria-labelledby="nav-payment-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3 class="text-center mt-3 mb-3">Payment Details</h3>
                                                    {{-- Table --}}
                                                    <table class="table table-bordered table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>First Name</th>
                                                                <td>{{ isset($orders->payment_firstname) ? $orders->payment_firstname : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Last Name</th>
                                                                <td>{{ isset($orders->payment_lastname) ? $orders->payment_lastname : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address 1</th>
                                                                <td>{{ isset($orders->payment_address_1) ? $orders->payment_address_1 : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address 2</th>
                                                                <td>{{ isset($orders->payment_address_2) ? $orders->payment_address_2 : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>City</th>
                                                                <td>{{ isset($orders->payment_city) ? $orders->payment_city : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Postcode</th>
                                                                <td>{{ isset($orders->payment_postcode) ? $orders->payment_postcode : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Country</th>
                                                                <td>{{ isset($orders->hasOneCountry->name) ? $orders->hasOneCountry->name : "" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Region / State</th>
                                                                <td>{{ isset($orders->hasOneRegion->name) ? $orders->hasOneRegion->name : ""  }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="200">Payment Method</th>
                                                                <td>{{ isset($orders->payment_method) ? $orders->payment_method : "" }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- End Table --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Payment Details --}}


                                    {{-- Products Tab --}}
                                    <div class="tab-pane fade" id="nav-product" role="tabpanel"
                                    aria-labelledby="nav-product-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3 class="text-center mt-3 mb-3">Products</h3>
                                                    {{-- Table --}}
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="bg-dark">
                                                            <tr>
                                                                <td class="left">Product</td>
                                                                <td class="left">Model</td>
                                                                <td class="right">Quantity</td>
                                                                <td class="right">Unit Price</td>
                                                                <td class="right">Total</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($productorders as $order)
                                                                <tr>
                                                                    <td>
                                                                        @if (!empty($order->name_size_base))
                                                                            <span class="text-info">{{ html_entity_decode($order->name_size_base) }}</span> -
                                                                        @endif
                                                                        <a class="text-primary">
                                                                            {{ htmlspecialchars_decode($order->name) }}
                                                                        </a>
                                                                        @php
                                                                        $strip = strip_tags($order->toppings);
                                                                        $replace = str_replace('+','</br> + ',$strip);
                                                                        echo $replace
                                                                        @endphp

                                                                    </td>
                                                                    <td>{{ $order->model  }}</td>
                                                                    <td>{{ $order->quantity  }}</td>
                                                                    <td>{{ $orders->hasOneCurrency['symbol_left'] }} {{ number_format($order->price,2)  }}</td>
                                                                    <td>{{ $orders->hasOneCurrency['symbol_left'] }} {{ number_format($order->total,2)  }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        @foreach ($ordertotal as $total)
                                                        <tfoot style="background: rgba(80, 80, 80, 0.788); color: white;">
                                                            <tr>
                                                                <td colspan="4" class="right"><b>{{ strtoupper($total->code) }}</b></td>
                                                                <td class="right">{{ $total->text }}</td>
                                                            </tr>
                                                        </tfoot>
                                                        @endforeach
                                                    </table>
                                                    {{-- End Table --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Products Tab --}}

                                    {{-- History Tab --}}
                                    <div class="tab-pane fade show" id="nav-history" role="tabpanel"
                                    aria-labelledby="nav-history-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-success pt-1 pb-1 alert-dismissible mt-2" role="alert" id="alert" style="display: none;">
                                                        <div id="alertmessage"></div>
                                                        <button type="button" class="close pt-1" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <h3 class="text-center mt-3 mb-3">Orders History</h3>
                                                    {{-- Table --}}
                                                    <table class="table table-bordered table-striped" id="orderHistory">
                                                        <thead class="bg-dark">
                                                            <tr>
                                                                <th>Date Added</th>
                                                                <th>Comment</th>
                                                                <th>Status</th>
                                                                <th>Customer Notified</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="ohistory">
                                                            @foreach ($ordershistory as $ohistory)
                                                                <tr>
                                                                    <td>{{ $ohistory->date_added }}</td>
                                                                    <td>{{ $ohistory->comment }}</td>
                                                                    <td>{{ $ohistory->oneOrderHistoryStatus->name }}</td>
                                                                    <td>{{ ($ohistory->notify == 1) ? "Yes" : 'No' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    {{-- End Table --}}
                                                </div>
                                            </div>
                                            <hr style="background: black">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Add Order History</h3>
                                                    <form class="form-horizontal" id="orderhistoryform">
                                                        {{ csrf_field() }}
                                                       <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="input-order-status">
                                                                    Order Status
                                                                </label>
                                                                <select name="order_status_id" id="input-order-status" class="form-control">
                                                                        @foreach ($orderstatus as $status)
                                                                            <option value="{{ $status->order_status_id }}">
                                                                                {{-- Old order status selected --}}
                                                                            {{-- <option value="{{ $status->order_status_id }}" {{ $status->order_status_id ==  $orders->order_status_id ? 'selected' : ''}}> --}}
                                                                                {{ $status->name }}
                                                                            </option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="days">
                                                                    Notify Customer
                                                                </label><br>
                                                                <input type="checkbox" class="ml-2" name="notify" value="1" id="input-notify">
                                                                <input type="hidden" name="order_id"
                                                                value="{{ isset($orders->order_id) ? $orders->order_id : "" }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="input-comment">
                                                                    Comment
                                                                </label>
                                                                <textarea name="comment" id="input-comment" class="form-control"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                {{-- <a id="button-history" class="btn btn-primary">ADD HISTORY</a> --}}
                                                                <button class="btn btn-primary" id="button-history" type="button">
                                                                    ADD HISTORY
                                                                    <span class="spinner-border spinner-border-sm" id="loder" role="status" aria-hidden="true" style="display: none"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                       </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End History Tab --}}
                                </div>
                                {{-- End Tabs Content --}}
                            </div>
                            {{-- End Card Body --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End view Section --}}
    </div>
</section>
{{-- End Section of Order View --}}


{{-- Footer Section --}}
@include('footer')
{{-- End Footer Section --}}


{{-- SCRIPT --}}


<script type="text/javascript">

    $(document).ready(function() {
        $('#orderHistory').dataTable();
    });

    // Insert Order History
    $('#button-history').on("click", function()
    {
        // $('#loder').css('dispay', 'inline-block');
        $("#loder").css("display", "inline-block");
        var form_data = new FormData(document.getElementById("orderhistoryform"));
        $.ajax({
                url: "{{ url('orderhistory') }}",
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response)
                {
                    if (response.success == 200)
                    {
                        $("#loder").css("display", "none");
                        $('#alert').show();
                        $('#alertmessage').text("Success: You have modified orders!");

                        setTimeout(() =>
                        {
                            $('#alert').hide();
                        }, 5000);

                        $('#orderhistoryform').trigger('reset');

                        $('#ohistory').html('');
                        let test = $('#ohistory').append(response.html);

                    }

                },
                error: function(response)
                {
                    $('#alertmessage').text("Error: Facing some error!");
                }
        });
    });
    // End Insert Order History


    // Generate Invoice
    function generateinvoice(orderID)
    {
        $('.gif-div').show();
        var order_id = orderID;

        $.ajaxSetup({
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });

        $.ajax({
                url: "{{ url('generateinvoice') }}",
                type: "POST",
                data: { 'order_id' : order_id },
                success: function(response)
                {
                    $('#Invoice').html('');
                    $('#Invoice').append(response);
                },
        });
    }
    // End Genrate Invoice

</script>
{{-- END SCRIPT --}}
