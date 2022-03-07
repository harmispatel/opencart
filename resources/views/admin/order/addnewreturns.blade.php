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
                        <h1>Product Returns</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('returns') }}">Product Returns</a>
                            </li>
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

                                <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                        <button type="submit" form="form-return" id="submit" class="btn btn-primary"><i
                                                class="fa fa-save">Save</i></button>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                        <a href="{{ route('returns') }}" class="btn btn-danger"><i
                                                class="fa fa-arrow-left">
                                                Back</i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}


                                {{-- Order return --}}

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="return-tab" data-toggle="tab" href="#return"
                                            role="tab" aria-controls="return" aria-selected="true">General</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="return" role="tabpanel"
                                        aria-labelledby="return-tab">
                                        <div class="tab-pane active" id="tab-general">
                                            <form action="{{ route('returnform') }}" method="post"
                                                enctype="multipart/form-data" id="form-return" class="form-horizontal">
                                                {{ @csrf_field() }}
                                                <fieldset>
                                                    <legend>Order Information</legend>
                                                    <div class="form-group required">
                                                        <label class="col-sm-2 control-label" for="input-order-id">Order
                                                            ID</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="order_id" value="{{ old('order_id') }}"
                                                                placeholder="Order ID" id="input-order-id"
                                                                class="form-control">
                                                                @if ($errors->has('order_id'))
                                                                <div style="color: red">
                                                                    {{ $errors->first('order_id') }}.</div>
                                                            @endif                                                        
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-date-ordered">Order Date</label>
                                                        <div class="col-sm-5">
                                                            <div class="input-group date">
                                                                <input type="date" name="date_ordered" value="{{ old('date_ordered') }}"
                                                                    placeholder="Order Date"
                                                                    data-date-format="YYYY-MM-DD"
                                                                    id="input-date-ordered" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-return-action">Customer</label>
                                                        <div class="col-sm-12">
                                                            <select name="customer_id" class="form-control"
                                                                id="customer_id" onchange="getcustomer()">
                                                                <option value="0">Select Customer</option>
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->customer_id }}" {{ (old('customer_id') == $customer->customer_id) ? 'selected' : '' }}>
                                                                        {{ $customer->firstname }}
                                                                        {{ $customer->lastname }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-firstname">First Name</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="firstname" value="{{ old('firstname') }}"
                                                                placeholder="First Name" id="input-firstname"
                                                                class="form-control">
                                                                @if ($errors->has('firstname'))
                                                                <div style="color: red">
                                                                    {{ $errors->first('firstname') }}.</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label class="col-sm-2 control-label" for="input-lastname">Last
                                                            Name</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="lastname" value="{{ old('lastname') }}"
                                                                placeholder="Last Name" id="input-lastname"
                                                                class="form-control">
                                                                @if ($errors->has('lastname'))
                                                                <div style="color: red">
                                                                    {{ $errors->first('lastname') }}.</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-email">E-Mail</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="email" value="{{ old('email') }}"
                                                                placeholder="E-Mail" id="input-email"
                                                                class="form-control">
                                                                @if ($errors->has('email'))
                                                                <div style="color: red">
                                                                    {{ $errors->first('email') }}.</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-telephone">Telephone</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="telephone" value="{{ old('telephone') }}"
                                                                placeholder="Telephone" id="input-telephone"
                                                                class="form-control">
                                                                @if ($errors->has('telephone'))
                                                                <div style="color: red">
                                                                    {{ $errors->first('telephone') }}.</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                    <legend>Product Information &amp; Reason for Return</legend>


                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-return-action">Product</label>
                                                        <div class="col-sm-12">
                                                            <select name="product" onchange="getproduct()"
                                                                class="form-control" id="product_id">
                                                                {{-- <option value="{{ old('product') }}"></option> --}}
                                                                <option value="0">Select Product</option>
                                                                @foreach ($orderproduct as $product)
                                                                    <option value="{{ $product->order_product_id }}">
                                                                        {{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('product'))
                                                            <div style="color: red">
                                                                {{ $errors->first('product') }}.</div>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group required">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-model">Model</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="model" value="" placeholder="Model"
                                                                id="input-model" class="form-control">
                                                                @if ($errors->has('model'))
                                                                <div style="color: red">
                                                                    {{ $errors->first('model') }}.</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-quantity">Quantity</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="quantity" value="{{ old('quantity') }}"
                                                                placeholder="Quantity" id="input-quantity"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-return-reason">Return Reason</label>
                                                        <div class="col-sm-12">
                                                            <select name="return_reason_id" id="input-return-reason"
                                                                class="form-control">
                                                                <option value="0">Select Reason</option>
                                                                @foreach ($returnreason as $reason)
                                                                    <option value="{{ $reason->return_reason_id }}" >
                                                                        {{ $reason->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-opened">Opened</label>
                                                        <div class="col-sm-12">
                                                            <select name="opened" id="input-opened"
                                                                class="form-control">
                                                                <option value="1">Opened</option>
                                                                <option value="0" selected="selected">Unopened</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-comment">Comment</label>
                                                        <div class="col-sm-12">
                                                            <textarea name="comment" rows="5" placeholder="Comment"
                                                                id="input-comment" class="form-control">{{ old('comment') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-return-action">Return Action</label>
                                                        <div class="col-sm-12">
                                                            <select name="return_action_id" id="input-return-action"
                                                                class="form-control">
                                                                @foreach ($returnaction as $action)
                                                                    <option value="{{ $action->return_action_id }}" >
                                                                        {{ $action->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"
                                                            for="input-return-status">Return Status</label>
                                                        <div class="col-sm-12">
                                                            <select name="return_status_id" id="input-return-status"
                                                                class="form-control">
                                                                @foreach ($return as $status)
                                                                    <option value="{{ $status->return_status_id }}" >{{ $status->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>







                                {{-- Order return end --}}

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
                $('#input-firstname').val(response.firstname);
                $('#input-lastname').val(response.lastname);
                $('#input-email').val(response.email);
                $('#input-telephone').val(response.telephone);


            }
        });

    }

    function getproduct() {
        console.log("HEllo");
        var product_id = $('#product_id :selected').val();

        $.ajax({
            type: "POST",
            url: "{{ url('getcustomer') }}",
            data: {
                'product': product_id,
                "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function(response) {
                $('#input-model').val(response.model);
                $('#input-model').val(response.model);




            }
        });

    }
</script>
