{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Order View --}}
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
        {{-- End Header Section --}}

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
                                                                    #{{ $orders->order_id }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Invoice No.</th>
                                                                <td>
                                                                    {{ $orders->invoice_prefix }}{{ $orders->invoice_no }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Store Name</th>
                                                                <td>
                                                                    {{ $orders->store_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Store Url</th>
                                                                <td>{{ $orders->store_url }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <td>
                                                                    {{ $orders->firstname }} {{ $orders->lastname }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="200">Customer Group</th>
                                                                <td>
                                                                    {{ $orders->hasOneCustomerGroupDescription->name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>E-Mail </hd>
                                                                <td>{{ $orders->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Telephone</th>
                                                                <td>{{ $orders->telephone }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <td>{{ $orders->total }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Order Status</th>
                                                                <td>{{ $orders->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>IP Address</th>
                                                                <td>{{ $orders->ip }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>User Agent</th>
                                                                <td>{{ $orders->user_agent }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Accept Language</th>
                                                                <td>{{ $orders->accept_language }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date Added</th>
                                                                <td>{{ $orders->date_added }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Date Modified</th>
                                                                <td>{{ $orders->date_modified }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Shipping Method</th>
                                                                <td>{{ $orders->flag_post_code }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Free Item</th>
                                                                <td>{{ htmlspecialchars_decode($orders->free_item) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Time delivery</th>
                                                                <td>{{ $orders->timedelivery }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- End Table --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Order Detail Tab --}}

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
                                            @foreach ($ordertotal as $total)
                                            <tbody id="totals">
                                                <tr>
                                                    <td colspan="4" class="right">{{ $total->code }}</td>
                                                    <td class="right">{{ $total->text }}</td>
                                                </tr>
                                            </tbody>
                                            @endforeach

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

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
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
                    setTimeout(() => {
                        $('#alert').hide();
                    }, 5000);
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
{{-- END SCRIPT --}}
