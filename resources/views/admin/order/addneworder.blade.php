@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">
<link rel="stylesheet" type="text/css"
    href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />


{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Order</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('orders') }}">Category List </a></li>
                            <li class="breadcrumb-item active">All</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex p-2" style="background: #f6f6f6">
                    <h3 class="card-title pt-2 m-0" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Add Order
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary">Save</button>
                        <a href="{{ route('orders') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <form action="{{ route('categoryinsert') }}" id="catform" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card-body">

                    <nav>
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
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-customer" role="tabpanel"
                            aria-labelledby="nav-customer-tab">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Store</label>
                                <select class="form-control">
                                    <option value="0">Default</option>
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->store_id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="#search">
                                <label for="exampleInputEmail1">Customer</label>
                                {{-- <input type="text" id="search" name="search" placeholder="Search"
                                    class="form-control typeahead" /> --}}
                                <select class="form-control">
                                    <option value="0">--None--</option>
                                    {{-- @foreach ($cusomersdetail as $detail)
                                    <option value="{{ $detail->customer_id }}">{{ $detail->firstname }} {{
                                        $detail->lasstname }}</option>
                                    @endforeach --}}
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customer Group</label>
                                <select class="form-control" name="cgroup">
                                    @foreach ($cusomers as $cusomer)
                                    <option value="{{ $cusomer->customer_group_id }}">{{ $cusomer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* First Name</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Last Name</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* E-Mail</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Telephone</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fax</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Choose Address</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* First Name</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Last Name</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company ID</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Address 1</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address 2</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* City</label>
                                <input class="form-control" type="text" placeholder="Default input">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Postcode</label>
                                <input class="form-control" type="text" placeholder="Default input">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Country</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Region / State</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-shipping" role="tabpanel" aria-labelledby="nav-shipping-tab">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Choose Address</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* First Name</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Last Name</label>
                                <input class="form-control" type="text" placeholder="Default input">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Address 1</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address 2</label>
                                <input class="form-control" type="text" placeholder="Default input">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* City</label>
                                <input class="form-control" type="text" placeholder="Default input">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Postcode</label>
                                <input class="form-control" type="text" placeholder="Default input">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Country</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">* Region / State</label>
                                <select class="form-control">
                                    <option>Default select</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="ordertable">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Product</td>
                                            <td class="text-left">Model</td>
                                            <td class="text-left">Quantity</td>
                                            <td class="text-left">Unit Price</td>
                                            <td class="text-left">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody id="orderdetail">

                                    </tbody>
                                </table>
                            </div>

                            <fieldset>
                                <legend>Add Product</legend>
                                <form class="form-horizontal" id="orderhistoryform">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">Choose
                                            Product</label>
                                        <select name="order_status_id" id="input-order-status"
                                            class="form-control"></select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">Quantity</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="text-right">
                                        <button id="button-history" class="btn btn-primary">Add History</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>

                        <div class="tab-pane fade show" id="nav-vouchers" role="tabpanel"
                            aria-labelledby="nav-vouchers-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="ordertable">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Product</td>
                                            <td class="text-left">Model</td>
                                            <td class="text-left">Quantity</td>
                                            <td class="text-left">Unit Price</td>
                                            <td class="text-left">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody id="orderdetail">

                                    </tbody>
                                </table>
                            </div>

                            <fieldset>
                                <legend>Add Product</legend>
                                <form class="form-horizontal" id="orderhistoryform">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">* Recipient's
                                            Name</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">* Recipient's
                                            Email</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">* Senders
                                            Name</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">* Senders
                                            Email</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">* Gift Certificate
                                            Theme</label>
                                        <select class="form-control">
                                            <option>Default select</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">Message</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">* Amount</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="text-right">
                                        <button id="button-history" class="btn btn-primary">Add History</button>
                                    </div>
                                </form>
                            </fieldset>

                        </div>
                        <div class="tab-pane fade show" id="nav-totals" role="tabpanel"
                            aria-labelledby="nav-totals-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="ordertable">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Product</td>
                                            <td class="text-left">Model</td>
                                            <td class="text-left">Quantity</td>
                                            <td class="text-left">Unit Price</td>
                                            <td class="text-left">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody id="orderdetail">

                                    </tbody>
                                </table>
                            </div>

                            <fieldset>
                                <legend>Add Product</legend>
                                <form class="form-horizontal" id="orderhistoryform">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">Shipping
                                            Method</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">Payment
                                            Method</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">Coupon</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">Voucher</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">Reward</label>
                                        <select class="form-control">
                                            <option>Default select</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">Order Status</label>
                                        <select class="form-control">
                                            <option>Default select</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">Comment</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-comment">Affiliate</label>
                                        <input class="form-control" type="text" placeholder="Default input">
                                    </div>
                                    <div class="text-right">
                                        <button id="button-history" class="btn btn-primary">Update Totals</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>

            </form>

        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')

<script type="text/javascript">

$.ajax({
    type: "get",
    url: "{{ url('getcustomername') }}",
    dataType: "json",
    success: function (response) {
        console.log(response.firstname);
    }
});


    function getcustomer() {

var customer_id = $('#customer_id :selected').val();

$.ajax({
    type: "POST",
    url: "{{ url('getcustomer') }}",
    data: {
        'customer': customer_id,
        "_token": "{{ csrf_token() }}",
    },
    dataType: "json",
    success: function(response) {
        // alert("Success");
        console.log(response.firstname);
        // $('#input-firstname').val(response.firstname);
        // $('#input-lastname').val(response.lastname);
        // $('#input-email').val(response.email);
        // $('#input-telephone').val(response.telephone);


    }
});

}

// function getproduct() {
// var product_id = $('#product_id :selected').val();

// $.ajax({
//     type: "POST",
//     url: "{{ url('getcustomer') }}",
//     data: {
//         'product': product_id,
//         "_token": "{{ csrf_token() }}",
//     },
//     dataType: "json",
//     success: function(response) {
//         $('#input-model').val(response.model);
//         $('#input-model').val(response.model);
//     }
// });

// }
</script>