{{--
    THIS IS HEADER Coupons PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    add.blade.php
    Its Used for Insert New Coupons
    ----------------------------------------------------------------------------------------------
--}}


{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Custom CSS for Radio Buttons --}}
<style>
<style>
    .radioenable {
        display: none;
    }
    .radiodisable {
        display: none;
    }

    .radioenable:checked+label {
        background: green !important;
        color: #fff !important;
    }
    .radiodisable:checked+label {
        background: red !important;
        color: #fff !important;
    }
</style>
</style>
{{-- End Custom CSS for Radio Buttons --}}

{{-- Section of ADD Coupon --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Warning: Please check the form carefully for errors!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Coupons</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('coupons') }}">Coupons</a></li>
                            <li class="breadcrumb-item active">Insert </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Insert Data Section --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card card-primary">
                            {{-- Form --}}
                            <form action="{{ route('insertcoupon') }}" id="voucherform" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        INSERT
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
                                        <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab" href="#nav-customer" role="tab" aria-controls="nav-customer" aria-selected="true">
                                            General
                                        </a>
                                    </div>
                                    {{-- End Tabs Link --}}

                                    {{-- Tabs Content --}}
                                    <div class="tab-content" id="nav-tabContent">
                                        {{-- General Tab --}}
                                        <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">

                                            <div class="form-group">
                                                <label for="coupon_name">
                                                    <span class="text-danger">*</span>
                                                    Coupon Name
                                                </label>
                                                <input type="text" class="form-control {{ ($errors->has('coupon_name')) ? 'is-invalid' : '' }}" name="coupon_name" id="coupon_name" placeholder="Code Name">
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
                                                <input type="text" maxlength="10" class="form-control {{ ($errors->has('code')) ? 'is-invalid' : '' }}" name="code" id="code" placeholder="Code">
                                                @if ($errors->has('code'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('code') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <input type="radio" class="radioenable" id="enable" name="on_off" value="1" />
                                                    <label class="btn btn-sm" style="width: 50px; background: black;color:white;" for="enable">ON</label>
                                                    <input type="radio" class="radiodisable" id="disable" name="on_off" value="0"  checked/>
                                                    <label class="btn btn-sm" style="width: 50px; background: black;color: white;" for="disable">OFF</label>
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
                                                            id="delivery" value="1">
                                                        <label class="form-check-label" for="delivery">Delivery</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply"
                                                            id="collection" value="2">
                                                        <label class="form-check-label" for="collection">Collection</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply" id="both"
                                                            value="3" checked>
                                                        <label class="form-check-label" for="both">Both</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="P">Percentage</option>
                                                    <option value="F">Fixed Amount</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input class="form-control" name="discount" id="discount" type="text" placeholder="Discount">
                                            </div>

                                            <div class="form-group">
                                                <label for="tamount">Total Amount</label>
                                                <input class="form-control" name="tamount" id="tamount" type="text" placeholder="Discount">
                                                <small id="codenamehelp" class="text-muted">
                                                    The total amount that must reached before the coupon is valid.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="clogin">Customer Login</label><br>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="clogin" id="clogin1" value="1">
                                                        <label class="form-check-label" for="clogin1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="clogin" id="clogin2" value="0" checked>
                                                        <label class="form-check-label" for="clogin2">No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="discount">Free Shipping</label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="shipping" id="fshipping" value="1">
                                                        <label class="form-check-label" for="fshipping">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="shipping" id="fshipping1" value="0" checked>
                                                        <label class="form-check-label" for="fshipping1">No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <label for="product">Products</label>
                                                        <input class="form-control" id="product" type="text"
                                                        placeholder="Products">
                                                        <small id="codenamehelp" class="text-muted">
                                                            Choose specific Products the coupon will apply to. Select no products to apply coupon to entire cart.
                                                        </small>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div id="loader2" style="margin-top: 35px;display: none;">
                                                            <img src="{{ asset('public/admin/gif/gif4.gif') }}" width="25">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="overflow-auto p-4" style="height: 150px; background: gainsboro;" id="addproduct">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <label for="category">Category</label>
                                                        <input class="form-control" id="category" type="text"
                                                        placeholder="Category">
                                                        <small id="codenamehelp" class="text-muted">
                                                            Choose specific Category the coupon will apply to. Select no products to apply coupon to entire
                                                            cart.
                                                        </small>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div id="loader1" style="margin-top: 35px;display: none;">
                                                            <img src="{{ asset('public/admin/gif/gif4.gif') }}" width="25">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="overflow-auto p-4" style="height: 150px; background: gainsboro;" id="addcategory">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="sdate">Date Start</label>
                                                <input class="form-control" name="sdate" id="sdate" type="date">
                                            </div>

                                            <div class="form-group">
                                                <label for="edate">Date End</label>
                                                <input class="form-control" name="edate" id="edate" type="date">
                                            </div>

                                            <div class="form-group">
                                                <label for="usercoupon">Uses Per Coupon</label>
                                                <input class="form-control" name="usercoupon" id="usercoupon"
                                                value="1" type="text" placeholder="Uses Per Coupon">
                                                <small id="codenamehelp" class="text-muted">
                                                    The maximum number of times the coupon can be used by any customer. Leave blank for unlimited.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="usercostomer">Uses Per Customer</label>
                                                <input class="form-control" name="usercostomer" id="usercostomer" value="1" type="text" placeholder="Uses Per Customer">
                                                <small id="codenamehelp" class="text-muted">
                                                    The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- End General Tab --}}
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
        {{-- End Insert Data Section --}}
    </div>
</section>
{{-- End Section of ADD Coupon --}}


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
                    beforeSend:function(){
                        $('#loader2').show();
                    },
                    success: function(data)
                    {
                        $('#loader2').hide();
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
            $('#addproduct').append(' <div class="d-block product' + ui.item.proid + '">' + ui.item.label +
            '<i class="float-right fa fa-minus-circle text-danger" onclick="$(\'.product' + ui.item.proid + '\').remove();"></i>\<input type="hidden" value="' + ui.item.proid + '" name="proid[]">\</div>');
            return false;
        },
        messages:
        {
            noResults: '',
            results: function() {}
        }
    });
    // End Search Products

    // Search Category
    $('#category').autocomplete({
        source: function(requete, reponse)
        {
            $.ajax({
                    url: "{{ url('searchcategory') }}",
                    data: {
                            category: requete.term
                    },
                    dataType: 'json',
                    beforeSend:function(){
                        $('#loader1').show();
                    },
                    success: function(data)
                    {
                        $('#loader1').hide();
                        reponse($.map(data, function(object)
                        {
                            return {
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
            '<i class="float-right fa fa-minus-circle text-danger" onclick="$(\'.category' + ui.item.catid + '\').remove();"></i>\<input type="hidden" value="' + ui.item.catid + '" name="catid[]">\</div>');
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
