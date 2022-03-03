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
                        <h1>orders</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Orders</li>
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
                                    Order List
                                </h3>

                                {{-- <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                        <a href="" class="btn btn-sm btn-success ml-auto"><i
                                                class="fa fa-plus"></i></a>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div> --}}
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title"><i class="fa fa-shopping-cart"></i> Order
                                                        Details</h5>
                                                </div>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 1%;"><button data-toggle="tooltip"
                                                                    title="" class="btn btn-info btn-xs"
                                                                    data-original-title="Store"><i
                                                                        class="fa fa-shopping-cart fa-fw"></i></button>
                                                            </td>
                                                            <td><a href="#" target="_blank">Your Store</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td><button data-toggle="tooltip" title=""
                                                                    class="btn btn-info btn-xs"
                                                                    data-original-title="Date Added"><i
                                                                        class="fa fa-calendar fa-fw"></i></button></td>
                                                            <td>{{ date('d-m-Y', strtotime($orders->date_added)) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><button data-toggle="tooltip" title=""
                                                                    class="btn btn-info btn-xs"
                                                                    data-original-title="Payment Method"><i
                                                                        class="fa fa-credit-card fa-fw"></i></button>
                                                            </td>
                                                            <td>{{ $orders->payment_method }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><button data-toggle="tooltip" title=""
                                                                    class="btn btn-info btn-xs"
                                                                    data-original-title="Shipping Method"><i
                                                                        class="fa fa-truck fa-fw"></i></button></td>
                                                            <td>{{ $orders->shipping_method }}</td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title"><i class="fa fa-user"></i> Customer
                                                        Details</h5>
                                                </div>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 1%;"><button data-toggle="tooltip"
                                                                    title="" class="btn btn-info btn-xs"
                                                                    data-original-title="Customer"><i
                                                                        class="fa fa-user fa-fw"></i></button></td>
                                                            <td>{{ $orders->firstname }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><button data-toggle="tooltip" title=""
                                                                    class="btn btn-info btn-xs"
                                                                    data-original-title="Customer Group"><i
                                                                        class="fa fa-group fa-fw"></i></button></td>
                                                            <td>Default</td>
                                                        </tr>
                                                        <tr>
                                                            <td><button data-toggle="tooltip" title=""
                                                                    class="btn btn-info btn-xs"
                                                                    data-original-title="E-Mail"><i
                                                                        class="fa fa-envelope-o fa-fw"></i></button>
                                                            </td>
                                                            <td><a
                                                                    href="mailto:{{ $orders->email }}">{{ $orders->email }}</a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td><button data-toggle="tooltip" title=""
                                                                    class="btn btn-info btn-xs"
                                                                    data-original-title="Telephone"><i
                                                                        class="fa fa-phone fa-fw"></i></button></td>
                                                            <td>{{ $orders->telephone }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title"><i class="fa fa-cog"></i> Options
                                                    </h5>
                                                </div>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Invoice</td>
                                                            <td id="invoice" class="text-right"></td>
                                                            <td style="width: 1%;" class="text-center"> <button
                                                                    id="button-invoice" data-loading-text="Loading..."
                                                                    data-toggle="tooltip" title=""
                                                                    class="btn btn-success btn-xs"
                                                                    data-original-title="Generate"><i
                                                                        class="fa fa-cog"></i></button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Reward Points</td>
                                                            <td class="text-right">200</td>
                                                            <td class="text-center"> <button disabled="disabled"
                                                                    class="btn btn-success btn-xs"><i
                                                                        class="fa fa-plus-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Affiliate
                                                            </td>
                                                            <td class="text-right">$0.00</td>
                                                            <td class="text-center"> <button disabled="disabled"
                                                                    class="btn btn-success btn-xs"><i
                                                                        class="fa fa-plus-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><i class="fa fa-info-circle"></i> Order
                                                (#{{ $orders->order_id }})</h5>
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td style="width: 50%;" class="text-left">Payment Address
                                                        </td>
                                                        <td style="width: 50%;" class="text-left">Shipping Address
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left">{{ $orders->firstname }}
                                                            {{ $orders->lastname }}<br>{{ $orders->payment_company }}<br>{{ $orders->payment_address_1 }}<br>{{ $orders->payment_address_2 }}<br>{{ $orders->payment_city }}
                                                            {{ $orders->payment_postcode }}<br>{{ $orders->payment_zone }}<br>{{ $orders->payment_country }}
                                                        </td>
                                                        <td class="text-left">{{ $orders->shipping_firstname }}
                                                            {{ $orders->shipping_lastname }}<br>{{ $orders->shipping_company }}<br>{{ $orders->shipping_address_1 }}<br>{{ $orders->shipping_address_2 }}<br>{{ $orders->shipping_city }}
                                                            {{ $orders->shipping_postcode }}<br>{{ $orders->shipping_zone }}<br>{{ $orders->shipping_country }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td class="text-left">Product</td>
                                                        <td class="text-left">Model</td>
                                                        <td class="text-right">Quantity</td>
                                                        <td class="text-right">Unit Price</td>
                                                        <td class="text-right">Total</td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td class="text-left"><a
                                                                href="#">{{ $orders->name }}</a> <br>
                                                            {{-- &nbsp;
                                                            <small> - Select: Blue</small> --}}
                                                        </td>
                                                        <td class="text-left">{{ $orders->model }}</td>
                                                        <td class="text-right">{{ $orders->quantity }}</td>
                                                        <td class="text-right">{{ $orders->price }}</td>
                                                        <td class="text-right">
                                                            {{ $orders->price * $orders->quantity }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-right">Sub-Total</td>
                                                        <td class="text-right">$80.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-right">Flat Shipping Rate</td>
                                                        <td class="text-right">$5.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-right">Eco Tax (-2.00)</td>
                                                        <td class="text-right">$4.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-right">VAT (20%)</td>
                                                        <td class="text-right">$17.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-right">Total</td>
                                                        <td class="text-right">$106.00</td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Customer Comment</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>new one</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5 class="panel-title"><i class="fa fa-comment-o"></i> Order History
                                            </h5>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab-history"
                                                        data-toggle="tab">History</a></li>
                                                <li><a href="#tab-additional" data-toggle="tab">Additional</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-history">
                                                    <div id="history">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-left">Date Added</td>
                                                                        <td class="text-left">Comment</td>
                                                                        <td class="text-left">Status</td>
                                                                        <td class="text-left">Customer Notified
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left">02/03/2022</td>
                                                                        <td class="text-left"></td>
                                                                        <td class="text-left">Pending</td>
                                                                        <td class="text-left">No</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6 text-left"></div>
                                                            <div class="col-sm-6 text-right">Showing 1 to 1 of 1 (1
                                                                Pages)</div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <fieldset>
                                                        <legend>Add Order History</legend>
                                                        <form class="form-horizontal">
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label"
                                                                    for="input-order-status">Order Status</label>
                                                                <div class="col-sm-10">
                                                                    <select name="order_status_id"
                                                                        id="input-order-status" class="form-control">
                                                                        <option value="7">Canceled</option>
                                                                        <option value="9">Canceled Reversal</option>
                                                                        <option value="13">Chargeback</option>
                                                                        <option value="5">Complete</option>
                                                                        <option value="8">Denied</option>
                                                                        <option value="14">Expired</option>
                                                                        <option value="10">Failed</option>
                                                                        <option value="1" selected="selected">Pending
                                                                        </option>
                                                                        <option value="15">Processed</option>
                                                                        <option value="2">Processing</option>
                                                                        <option value="11">Refunded</option>
                                                                        <option value="12">Reversed</option>
                                                                        <option value="3">Shipped</option>
                                                                        <option value="16">Voided</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label"
                                                                    for="input-override"><span data-toggle="tooltip"
                                                                        title=""
                                                                        data-original-title="If the customers order is being blocked from changing the order status due to an anti-fraud extension enable override.">Override</span></label>
                                                                <div class="col-sm-10">
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" name="override" value="1"
                                                                            id="input-override">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label"
                                                                    for="input-notify">Notify Customer</label>
                                                                <div class="col-sm-10">
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" name="notify" value="1"
                                                                            id="input-notify">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label"
                                                                    for="input-comment">Comment</label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="comment" rows="8" id="input-comment"
                                                                        class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </fieldset>
                                                    <div class="text-right">
                                                        <button id="button-history" data-loading-text="Loading..."
                                                            class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                                                            Add History</button>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab-additional">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="2">Browser</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>IP Address</td>
                                                                    <td>::1</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>User Agent</td>
                                                                    <td>Mozilla/5.0 (X11; Linux x86_64)
                                                                        AppleWebKit/537.36 (KHTML, like Gecko)
                                                                        Chrome/98.0.4758.102 Safari/537.36</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Accept Language</td>
                                                                    <td>en-US,en;q=0.9,ar;q=0.8,hi;q=0.7,es;q=0.6</td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}


                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-history-tab" data-toggle="tab"
                                                href="#nav-history" role="tab" aria-controls="nav-history"
                                                aria-selected="true">History</a>
                                            <a class="nav-item nav-link" id="nav-additional-tab" data-toggle="tab"
                                                href="#nav-additional" role="tab" aria-controls="nav-additional"
                                                aria-selected="false">Additional</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-history" role="tabpanel"
                                            aria-labelledby="nav-history-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-left">Date Added</td>
                                                            <td class="text-left">Comment</td>
                                                            <td class="text-left">Status</td>
                                                            <td class="text-left">Customer Notified
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="orderdetail">
                                                            {{-- <td class="text-left">{{ date('d-m-Y', strtotime($orderhistory->date_added)) }}</td>
                                                            <td class="text-left"></td>
                                                            <td class="text-left">{{ $orders->order_status_id }}</td>
                                                            <td class="text-left">No</td> --}}
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <fieldset>
                                                <legend>Add Order History</legend>
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-order-status">Order Status</label>
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
                                                        <label class="col-sm-2 control-label"
                                                            for="input-override"><span data-toggle="tooltip" title=""
                                                                data-original-title="If the customers order is being blocked from changing the order status due to an anti-fraud extension enable override.">Override</span></label>
                                                        <div class="col-sm-12">
                                                            <div class="checkbox">
                                                                <input type="checkbox" name="override" value="1"
                                                                    id="input-override">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="input-notify">Notify
                                                            Customer</label>
                                                        <div class="col-sm-12">
                                                            <div class="checkbox">
                                                                <input type="checkbox" name="notify" value="1"
                                                                    id="input-notify">
                                                            </div>
                                                        </div>
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
                                        <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                                            aria-labelledby="nav-additional-tab">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td colspan="2">Browser</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>IP Address</td>
                                                        <td>{{ $orders->ip }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>User Agent</td>
                                                        <td>{{ $orders->user_agent }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Accept Language</td>
                                                        <td>{{ $orders->accept_language }}</td>
                                                    </tr>
                                                </tbody>

                                            </table>
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
    getorderdetail();
    function getorderdetail() {
        $.ajax({
            type: "GET",
            url: "{{ url('orderdata') }}",
            dataType: "JSON",
            success: function (response) {
                if(response.success == 1)
                {
                    $('#orderdetail').html(response.orderdetail);
                }
            }
    });
    }
</script>
