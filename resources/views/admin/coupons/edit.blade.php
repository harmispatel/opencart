{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Coupon</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('voucherlist') }}">Coupon</a></li>
                            <li class="breadcrumb-item active">Coupon</li>
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
                            <div class="card-header d-flex p-2" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    Coupon
                                </h3>
                                <div class="form-group ml-auto">
                                    <button type="submit" form="voucherform" class="btn btn-primary">Save</button>
                                    <a href="{{ route('coupons') }}" class="btn btn-danger">Back</a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            @if (count($errors) > 0)
                            @if ($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{ 'Warning: Please check the form carefully for errors!' }}
                                </div>
                            @endif
                        @endif
                        <form action="{{ route('couponupdate') }}" id="voucherform" method="POST">
                            {{ @csrf_field() }}
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-General-tab" data-toggle="tab"
                                            href="#nav-General" role="tab" aria-controls="nav-General"
                                            aria-selected="true">General</a>
                                        <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history"
                                            role="tab" aria-controls="nav-history" aria-selected="false">History</a>
                                        {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a> --}}
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-General" role="tabpanel"
                                        aria-labelledby="nav-General-tab">
                                        <div class="form-group">
                                            <label for="code">*Code</label>
                                            <input type="text" class="form-control" name="code" value="{{ $coupon->code }}" id="code"
                                                aria-describedby="codehelp" placeholder="Code">
                                            <input type="hidden" name="couponid" value="{{ $coupon->coupon_id }}">
                                            @if ($errors->has('code'))
                                                <div style="color: red">{{ $errors->first('code') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="codename">* Coupon Name:</label>
                                            <input type="text" class="form-control" name="codename" id="codename"
                                                aria-describedby="codenamehelp" value="{{ $coupon->name }}" placeholder="Code Name">
                                            <small id="codenamehelp" class="form-text text-muted">Enable to add into cart
                                                automatically.</small>
                                            @if ($errors->has('code'))
                                                <div style="color: red">{{ $errors->first('code') }}</div>
                                            @endif
                                        </div>
            
                                        <div class="form-group">
                                            <label for="apply" style="min-width: 100px">* Appy for</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="apply" id="delivery" value="1" {{ $coupon->apply_shipping == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delivery">Delivery</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="apply" id="collection" value="2" {{ $coupon->apply_shipping == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="collection">Collection</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="apply" id="both" value="3" {{ $coupon->apply_shipping == 3 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="both">Both</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Type:</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="P" {{ $coupon->type == 'P' ? 'selected' : '' }}>Percentage</option>
                                                <option value="F" {{ $coupon->type == 'F' ? 'selected' : '' }}>Fixed Amount</option>
                                            </select>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="discount">Discount:</label>
                                            <input class="form-control" name="discount" id="discount" value="{{ round($coupon->discount,2) }}" type="text"
                                                placeholder="Discount">
                                        </div>
                                        <div class="form-group">
                                            <label for="tamount">Total Amount:</label>
                                            <input class="form-control" name="tamount" id="tamount" value="{{ round($coupon->total,2) }}" type="text"
                                                placeholder="Discount">
                                            <small id="codenamehelp" class="form-text text-muted">The total amount that must reached
                                                before the coupon is valid.</small>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="clogin" >Customer Login:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="clogin" id="clogin1"
                                                    value="1" {{ $coupon->logged == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="clogin1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="clogin" id="clogin2"
                                                    value="0" {{ $coupon->logged == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="clogin2">No</label>
                                            </div>
                                            <small class="form-text text-muted">Customer must be logged in to
                                                use the coupon.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="discount" >Free Shipping:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="shipping" id="fshipping"
                                                    value="1" {{ $coupon->shipping == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fshipping">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="shipping" id="fshipping1"
                                                    value="0" {{ $coupon->shipping == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fshipping1">No</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="product">Products:</label>
                                            <input class="form-control"  id="product" type="text"
                                                placeholder="Products">
                                            <small id="codenamehelp" class="form-text text-muted">Choose specific
                                                products the
                                                coupon will apply to. Select no products to apply coupon to entire
                                                cart.</small>
                                        </div>
                                        <div class="overflow-auto p-3 mb-3 mb-md-0 mr-md-3 bg-light"
                                            style="width: 300px; height: 100px;" id="addproduct">
                                            @foreach ($products as $product)
                                            <div class="d-block product{{ $product->product_id }}">{{ $product->name }}<i class="float-right fa fa-minus-circle text-danger" onclick="$('.product{{$product->product_id}}').remove();"></i>
                                                <input type="hidden" value="{{ $product->product_id }}" name="proid[]">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Category:</label>
                                            <input class="form-control" id="category" type="text"
                                                placeholder="Category">
                                            <small id="codenamehelp" class="form-text text-muted">Choose specific
                                                products the
                                                coupon will apply to. Select no products to apply coupon to entire
                                                cart.</small>
                                        </div>
                                        <div class="overflow-auto p-3 mb-3 mb-md-0 mr-md-3 bg-light"
                                            style="width: 300px; height: 100px;" id="addcategory">
                                            @foreach ($category as $cat)
                                            <div class="d-block product{{ $cat->category_id }}">{{ $cat->name }}<i class="float-right fa fa-minus-circle text-danger" onclick="$('.product{{$cat->category_id}}').remove();"></i>
                                                <input type="hidden" value="{{ $cat->category_id }}" name="catid[]">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="sdate">Date Start:</label>
                                            <input class="form-control" name="sdate" id="sdate" value="{{ $coupon->date_start }}" type="date">
                                        </div>
                                        <div class="form-group">
                                            <label for="edate">Date End:</label>
                                            <input class="form-control" name="edate" id="edate" value="{{ $coupon->date_end }}" type="date">
                                        </div>
            
                                        <div class="form-group">
                                            <label for="usercoupon">Uses Per Coupon:</label>
                                            <input class="form-control" name="usercoupon" id="usercoupon" value="{{ $coupon->uses_total }}" type="text"
                                                placeholder="Uses Per Coupon">
                                            <small id="codenamehelp" class="form-text text-muted">The maximum number of times the coupon can be used by any customer. Leave blank for unlimited.</small>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="usercostomer">Uses Per Customer:</label>
                                            <input class="form-control" name="usercostomer" id="usercostomer" value="{{ $coupon->uses_customer }}" type="text"
                                                placeholder="Uses Per Customer">
                                            <small id="codenamehelp" class="form-text text-muted">The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited.</small>
                                        </div>
            
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1" {{ $coupon->type == 1 ? 'selected' : '' }}>Enable</option>
                                                <option value="2" {{ $coupon->type == 2 ? 'selected' : '' }}>disable</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                                        History
                                    </div>
                                    {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> --}}
                                </div>
                            </div>
            
                        </form>
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
{{-- End Section of Add Category --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );


    // for html code decode
    function htmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }

    // Search Products
    $('#product').autocomplete({
        source: function(requete, reponse) {

            $.ajax({
                url: "{{ url('searchproduct') }}",
                data: {
                    product: requete.term
                },
                dataType: 'json',
                success: function(data) {

                    reponse($.map(data, function(object) {
                        return {
                            // customer_id: object.,
                            label: htmlDecode(object.name),
                            proid: object.product_id,

                        };
                    }));
                }
            });
        },

        minLength: 1,
        delay: 500,

        select: function(event, ui) {
            $('#product').val("");
            console.log(ui.item.label);
            console.log(ui.item.proid);
            $('#addproduct').append(' <div class="d-block product'+ui.item.proid+'">'+ui.item.label+'<i class="float-right fa fa-minus-circle text-danger" onclick="$(\'.product'+ui.item.proid+'\').remove();"></i>\
                                            <input type="hidden" value="'+ui.item.proid+'" name="proid[]">\
                                        </div>');
            return false;
                                    },

        messages: {
            noResults: '',
            results: function() {}
        }

    });

    // Search category
    $('#category').autocomplete({
        source: function(requete, reponse) {

            $.ajax({
                url: "{{ url('searchcategory') }}",
                data: {
                    category: requete.term
                },
                dataType: 'json',
                success: function(data) {

                    reponse($.map(data, function(object) {
                        return {
                            // customer_id: object.,
                            label: htmlDecode(object.name),
                            catid: object.category_id,

                        };
                    }));
                }
            });
        },

        minLength: 1,
        delay: 500,

        select: function(event, ui) {
            $('#category').val("");
            console.log(ui.item.label);
            console.log(ui.item.catid);
            $('#addcategory').append(' <div class="d-block category'+ui.item.catid+'">'+ui.item.label+'<i class="float-right fa fa-minus-circle text-danger" onclick="$(\'.category'+ui.item.catid+'\').remove();"></i>\
                                            <input type="hidden" value="'+ui.item.catid+'" name="catid[]">\
                                        </div>');
        return false;
        },

        messages: {
            noResults: '',
            results: function() {}
        }
    });
</script>

