@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Reviews --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
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
                        <h1>orders view</h1>
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
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Order View
                                </h3>

                                <div class="container" style="text-align: right">
                                    <a href="{{ route('invoice', $orders->order_id) }}" target="_blank"
                                        data-toggle="tooltip" title="" class="btn btn-info"
                                        data-original-title="Print Invoice"><i class="fa fa-print"></i></a>
                                    <a href="{{ route('orders') }}" class="btn btn-danger"><i
                                            class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">

                                <nav>
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
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-order" role="tabpanel"
                                        aria-labelledby="nav-order-tab">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Order Id:</td>
                                                    <td>#{{ $orders->order_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Invoice No.:</td>
                                                    <td>{{ $orders->invoice_prefix }}{{ $orders->invoice_no }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Store Name:</td>
                                                    <td>{{ $orders->store_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Store Url:</td>
                                                    <td>{{ $orders->store_url }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Customer:</td>
                                                    <td>{{ $orders->firstname }} {{ $orders->lastname }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Customer Group:</td>
                                                    <td>{{ $orders->customer_group_id == 1 ? 'default' : '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>E-Mail: </td>
                                                    <td>{{ $orders->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Telephone:</td>
                                                    <td>{{ $orders->telephone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total:</td>
                                                    <td>{{ $orders->total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Status</td>
                                                    <td>{{ $orders->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>IP Address:</td>
                                                    <td>{{ $orders->ip }}</td>
                                                </tr>
                                                <tr>
                                                    <td>User Agent:</td>
                                                    <td>{{ $orders->user_agent }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Accept Language:</td>
                                                    <td>{{ $orders->accept_language }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Date Added:</td>
                                                    <td>{{ $orders->date_added }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Date Modified:</td>
                                                    <td>{{ $orders->date_modified }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Method:</td>
                                                    <td>{{ $orders->flag_post_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Free Item:</td>
                                                    <td>{{ htmlspecialchars_decode($orders->free_item) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Time delivery:</td>
                                                    <td>{{ $orders->timedelivery }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-payment" role="tabpanel"
                                        aria-labelledby="nav-payment-tab">

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>First Name:</td>
                                                    <td>{{ $orders->payment_firstname }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Last Name::</td>
                                                    <td>{{ $orders->payment_lastname }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address 1::</td>
                                                    <td>{{ $orders->payment_address_1 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address 2:</td>
                                                    <td>{{ $orders->payment_address_2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>City:</td>
                                                    <td>{{ $orders->payment_city }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Postcode:</td>
                                                    <td>{{ $orders->payment_postcode }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Region / State:</td>
                                                    <td>{{ '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Country:</td>
                                                    <td>{{ $orders->payment_country }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method:</td>
                                                    <td>{{ $orders->payment_method }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-product" role="tabpanel"
                                        aria-labelledby="nav-product-tab">

                                        <table class="list table">
                                            <thead>
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
                                                        <td class="left"><a href="#">{{ htmlspecialchars_decode($order->name) }}</a>
                                                            <br>
                                                            {{-- {{ echo $orders->toppings  }} --}}
                                                            @php
                                                                echo $order->toppings;
                                                            @endphp
                                                        </td>
                                                        <td class="left">{{ $order->model  }}</td>
                                                        <td class="right">{{ $order->quantity  }}</td>
                                                        <td class="right">{{ $order->price  }}</td>
                                                        <td class="right">{{ $order->total  }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tbody id="totals">
                                                <tr>
                                                    <td colspan="4" class="right">Sub-Total:</td>
                                                    <td class="right">{{ $orders->total }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody id="totals">
                                                <tr>
                                                    <td colspan="4" class="right">Coupon(VALEN10):</td>
                                                    <td class="right">£-2.10</td>
                                                </tr>
                                            </tbody>
                                            <tbody id="totals">
                                                <tr>
                                                    <td colspan="4" class="right">Delivery:</td>
                                                    <td class="right">£1.00</td>
                                                </tr>
                                            </tbody>
                                            <tbody id="totals">
                                                <tr>
                                                    <td colspan="4" class="right">Service Charge:</td>
                                                    <td class="right">£0.50</td>
                                                </tr>
                                            </tbody>
                                            <tbody id="totals">
                                                <tr>
                                                    <td colspan="4" class="right">Total to pay:</td>
                                                    <td class="right">£20.40</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="alert alert-success alert-dismissible" role="alert" id="alert"
                                        style="display: none">
                                        <div id="alertmessage"></div>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="tab-pane fade show" id="nav-history" role="tabpanel"
                                        aria-labelledby="nav-history-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered w-100" id="ordertable">
                                                <thead>
                                                    <tr>
                                                        <td class="text-left">Date Added</td>
                                                        <td class="text-left">Comment</td>
                                                        <td class="text-left">Status</td>
                                                        <td class="text-left">Customer Notified</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="orderdetail">

                                                </tbody>
                                            </table>
                                        </div>

                                        <fieldset>
                                            <legend>Add Order History</legend>
                                            <form class="form-horizontal" id="orderhistoryform">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-order-status">Order
                                                        Status</label>
                                                    <div class="col-sm-12">
                                                        <select name="order_status_id" id="input-order-status"
                                                            class="form-control">
                                                            @foreach ($orderstatus as $status)
                                                                <option value="{{ $status->order_status_id }}">
                                                                    {{ $status->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="days" class="form-label">Notify Customer:</label>
                                                    <input type="checkbox" class="ml-2" name="notify"
                                                        value="1" id="input-notify">
                                                    <input type="hidden" name="order_id"
                                                        value="{{ $orders->order_id }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"
                                                        for="input-comment">Comment</label>
                                                    <div class="col-sm-12">
                                                        <textarea name="comment" rows="8" id="input-comment"
                                                            class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button id="button-history" data-loading-text="Loading..."
                                                        class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                                                        Add History</button>
                                                </div>
                                            </form>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- End Table --}}
            </div>
            {{-- End Card Body --}}
    </div>
    {{-- End Card --}}
    </div>
    </div>
    </div>
</section>
{{-- End Form Section --}}

</div>
</section>
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    $(document).ready(function() {
        $('#ordertable').dataTable({
            // "searching": false,
            // "bLengthChange": false,
            // "ordering": false
        });
    });
    $(document).ready(function() {

        getorderdetail();

        function getorderdetail() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "{{ url('orderdata', $orders->order_id) }}",
                dataType: "JSON",
                success: function(response) {
                    if (response.status == 200) {
                        // console.log(response.orderhistory);
                        $('#orderdetail').html(response.orderhistory);
                    }
                }
            });
        }

        // Insert Order History
        $('#button-history').on("click", function(e) {
            e.preventDefault();

            var form_data = new FormData(document.getElementById("orderhistoryform"));
            $.ajax({
                url: "{{ url('orderhistory') }}",
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    // if (response.success == 200) {
                    $('#alert').show();
                    $('#alertmessage').text("Success: You have modified orders!");
                    $('#orderdetail').html('')
                    getorderdetail();
                    $('#orderhistoryform').trigger('reset');
                },
                error: function(response) {
                    $('#alertmessage').text("Error: Facing some error!");
                }
            });
        });
    });
</script>
