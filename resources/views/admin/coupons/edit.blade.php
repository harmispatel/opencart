<!--
    THIS IS HEADER Couponsedit PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    edit.blade.php
    This for Edit Coupons
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Custom CSS for Radio Buttons --}}
<style>
    .radio {
        display: none;
    }

    .radio:checked+label {
        background: rgb(41, 41, 41) !important;
        color: #fff;
    }
</style>
{{-- End Custom CSS for Radio Buttons --}}

{{-- Section of Edit Coupon --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Coupons</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Coupons</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Edit Data Section --}}
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
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('couponupdate') }}" id="voucherform" method="POST">
                            {{ @csrf_field() }}

                            {{-- Card Header --}}
                            <div class="card-header">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    EDIT
                                </h3>
                                <div class="container" style="text-align: right">
                                    <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                        <i class="fa fa-save"></i>
                                    </button>
                                    <a href="{{ route('coupons') }}" class="btn btn-sm btn-danger ml-1">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-General-tab" data-toggle="tab"
                                            href="#nav-General" role="tab" aria-controls="nav-General"
                                            aria-selected="true">General</a>
                                        <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab"
                                            href="#nav-history" role="tab" aria-controls="nav-history"
                                            aria-selected="false">History</a>
                                    </div>
                                    {{-- End Tabs Link --}}

                                    {{-- Tabs Content --}}
                                    <div class="tab-content" id="nav-tabContent">

                                        {{-- General Tab --}}
                                        <div class="tab-pane fade show active mt-4" id="nav-General" role="tabpanel" aria-labelledby="nav-General-tab">

                                            <div class="form-group">
                                                <input type="hidden" name="couponid" id="couponid"
                                                value="{{ $coupon->coupon_id }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="coupon_name">
                                                    <span class="text-danger">*</span>
                                                    Coupon Name
                                                </label>
                                                <input type="text" class="form-control {{ ($errors->has('coupon_name')) ? 'is-invalid' : '' }}" name="coupon_name" id="coupon_name" value="{{ $coupon->name }}">
                                                @if ($errors->has('coupon_name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('coupon_name') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="code">
                                                    <span class="text-danger">*</span>
                                                    Code
                                                </label>
                                                <input type="text" maxlength="10" class="form-control {{ ($errors->has('code')) ? 'is-invalid' : '' }}" name="code" id="code" value="{{ $coupon->code }}">
                                                @if ($errors->has('code'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('code') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <input type="radio" class="radio" id="enable" name="on_off" value="1" {{ $coupon->on_off == 1 ? "checked" : "" }} />
                                                    <label class="btn btn-sm" style="width: 50px; background: green;color:white;" for="enable">ON</label>
                                                    <input type="radio" class="radio" id="disable" name="on_off" value="0"  {{ $coupon->on_off == 0 ? "checked" : "" }}/>
                                                    <label class="btn btn-sm" style="width: 50px; background: red;color: white;" for="disable">OFF</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="apply">
                                                    <span class="text-danger">*</span>
                                                    Appy for
                                                </label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply"
                                                        id="delivery" value="1" {{ $coupon->apply_shipping == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="delivery">Delivery</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply"
                                                        id="collection" value="2" {{ $coupon->apply_shipping == 2 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="collection">Collection</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply" id="both" value="3" {{ $coupon->apply_shipping == 3 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="both">Both</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="P"  {{ $coupon->type == 'P' ? 'selected' : '' }}>Percentage</option>
                                                    <option value="F"  {{ $coupon->type == 'F' ? 'selected' : '' }}>Fixed Amount</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input class="form-control" name="discount" id="discount" type="text" value="{{ number_format($coupon->discount,2) }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="tamount">Total Amount</label>
                                                <input class="form-control" name="tamount" id="tamount" type="text" value="{{ number_format($coupon->total,2) }}">
                                                <small id="codenamehelp" class="text-muted">
                                                    The total amount that must reached before the coupon is valid.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="clogin">Customer Login</label><br>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="clogin" id="clogin1" value="1" {{ $coupon->logged == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="clogin1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="clogin" id="clogin2" value="0" {{ $coupon->logged == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="clogin2">No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="discount">Free Shipping</label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="shipping" id="fshipping" value="1" {{ $coupon->shipping == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="fshipping">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="shipping" id="fshipping1" value="0" {{ $coupon->shipping == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="fshipping1">No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="product">Products</label>
                                                <input class="form-control" id="product" type="text"
                                                placeholder="Products">
                                                <small id="codenamehelp" class="text-muted">
                                                    Choose specific Products the coupon will apply to. Select no products to apply coupon to entire cart.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="overflow-auto p-4" style="height: 150px; background: gainsboro;" id="addproduct">
                                                        @foreach ($products as $product)
                                                            <div class="d-block product{{ $product->product_id }}">
                                                                {{ html_entity_decode($product->name) }}
                                                                <i class="float-right fa fa-minus-circle text-danger" onclick="$('.product{{ $product->product_id }}').remove();"></i>
                                                                <input type="hidden" value="{{ $product->product_id }}" name="proid[]">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <input class="form-control" id="category" type="text"
                                                placeholder="Category">
                                                <small id="codenamehelp" class="text-muted">
                                                    Choose specific Category the coupon will apply to. Select no products to apply coupon to entire
                                                    cart.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="overflow-auto p-4" style="height: 150px; background: gainsboro;" id="addcategory">
                                                        @foreach ($category as $cat)
                                                            <div class="d-block product{{ $cat->category_id }}">
                                                                {{ html_entity_decode($cat->name) }}
                                                                <i class="float-right fa fa-minus-circle text-danger" onclick="$('.product{{ $cat->category_id }}').remove();"></i>
                                                                <input type="hidden" value="{{ $cat->category_id }}" name="catid[]">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="sdate">Date Start</label>
                                                <input class="form-control" name="sdate" id="sdate" type="date" value="{{ $coupon->date_start }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="edate">Date End</label>
                                                <input class="form-control" name="edate" id="edate" type="date" value="{{ $coupon->date_end }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="usercoupon">Uses Per Coupon</label>
                                                <input class="form-control" name="usercoupon" id="usercoupon"
                                                value="{{ $coupon->uses_total }}" type="text">
                                                <small id="codenamehelp" class="text-muted">
                                                    The maximum number of times the coupon can be used by any customer. Leave blank for unlimited.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="usercostomer">Uses Per Customer</label>
                                                <input class="form-control" name="usercostomer" id="usercostomer" value="{{ $coupon->uses_customer }}" type="text">
                                                <small id="codenamehelp" class="text-muted">
                                                    The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Enable</option>
                                                    <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>disable</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- End General Tab --}}

                                        {{-- History Tab --}}
                                        <div class="tab-pane fade" id="nav-history" role="tabpanel"
                                        aria-labelledby="nav-history-tab">
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-striped w-100" id="table">
                                                        <thead class="bg-dark">
                                                            <tr>
                                                                <th scope="col">Order Id</th>
                                                                <th scope="col">Customer</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Date Added</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End History Tab --}}
                                    </div>
                                    {{-- End Tabs Content --}}
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- End Form --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Edit Data Section --}}
    </div>
</section>
{{-- End Section of Edit Coupon --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script type="text/javascript">

    // html code decode
    function htmlDecode(input)
    {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }
    // End html code decode


    // Search Products
    $('#product').autocomplete({
        source: function(requete, reponse)
        {
            $.ajax({
                    url: "{{ url('searchproduct') }}",
                    data: {
                            product: requete.term
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        reponse($.map(data, function(object)
                        {
                            return {
                                    label: htmlDecode(object.name),
                                    proid: object.product_id,
                            };
                        }));
                    }
            });
        },
        minLength: 1,
        delay: 500,
        select: function(event, ui)
        {
            $('#product').val("");
            $('#addproduct').append(' <div class="d-block product' + ui.item.proid + '">' + ui.item.label+'<i class="float-right fa fa-minus-circle text-danger" onclick="$(\'.product' + ui.item.proid + '\').remove();"></i>\<input type="hidden" value="' + ui.item.proid + '" name="proid[]">\</div>');
            return false;
        },
        messages:
        {
            noResults: '',
            results: function() {}
        }

    });
    // End Search Product


    // Search category
    $('#category').autocomplete({
        source: function(requete, reponse)
        {
            $.ajax({
                url: "{{ url('searchcategory') }}",
                data: {
                        category: requete.term
                },
                dataType: 'json',
                success: function(data)
                {
                    reponse($.map(data, function(object)
                    {
                        return
                        {
                            label: htmlDecode(object.name),
                            catid: object.category_id,
                        };
                    }));
                }
            });
        },
        minLength: 1,
        delay: 500,
        select: function(event, ui)
        {
            $('#category').val("");
            $('#addcategory').append(' <div class="d-block category' + ui.item.catid + '">' + ui.item.label +
            '<i class="float-right fa fa-minus-circle text-danger" onclick="$(\'.category' + ui.item
                .catid + '\').remove();"></i>\<input type="hidden" value="' + ui.item.catid + '" name="catid[]">\</div>');
            return false;
        },
        messages:
        {
            noResults: '',
            results: function() {}
        }
    });
    // End Search Category

</script>

<script>
    $(document).ready(function()
    {
        // call Function
        getallcouponhistory();

        // Get AllCouponHistory
        function getallcouponhistory()
        {
            var couponid = $('#couponid').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          var table =  $('#table').DataTable();
          table.destroy();
            var table = $('#table').DataTable({
                    "serverSide": true,
                    "processing": true,

                    "ajax":{
                    "url": "{{ url('getallcouponhistory') }}",
                    "type": "POST",
                    "data":{couponid: couponid,}
                    },
                columns: [{
                        data: 'order_id',
                        name: 'order_id',
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                    },
                    {
                        data: 'date_added',
                        name: 'date_added',
                    },
                ]
            });
        }
    });
</script>
{{-- END SCRIPT --}}
