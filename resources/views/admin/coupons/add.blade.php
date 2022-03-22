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
                        <h1>Coupon</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('voucherlist') }}">Voucher List</a></li>
                            <li class="breadcrumb-item active">Add </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex p-2" style="background: #f6f6f6">
                    <h3 class="card-title pt-2 m-0" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Gift Voucher
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="voucherform" class="btn btn-primary">Save</button>
                        <a href="{{ route('coupons') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (count($errors) > 0)
                @if ($errors->any())
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ 'Warning: Please check the form carefully for errors!' }}
                    </div>
                @endif
            @endif
            <form action="{{ route('insertcoupon') }}" id="voucherform" method="POST">
                {{ @csrf_field() }}
                <div class="card-body">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab"
                                href="#nav-customer" role="tab" aria-controls="nav-customer"
                                aria-selected="true">General</a>

                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel"
                            aria-labelledby="nav-customer-tab">
                            <div class="form-group">
                                <label for="code">*Code</label>
                                <input type="text" class="form-control" name="code" id="code"
                                    aria-describedby="codehelp" placeholder="Code">
                                @if ($errors->has('code'))
                                    <div style="color: red">{{ $errors->first('code') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="codename">* Coupon Name:</label>
                                <input type="text" class="form-control" name="codename" id="codename"
                                    aria-describedby="codenamehelp" placeholder="Code Name">
                                <small id="codenamehelp" class="form-text text-muted">Enable to add into cart
                                    automatically.</small>
                                @if ($errors->has('code'))
                                    <div style="color: red">{{ $errors->first('code') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="apply" style="min-width: 100px">* Appy for</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="apply" id="delivery" value="1">
                                    <label class="form-check-label" for="delivery">Delivery</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="apply" id="collection" value="2">
                                    <label class="form-check-label" for="collection">Collection</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="apply" id="both" value="3"
                                        checked>
                                    <label class="form-check-label" for="both">Both</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type">Type:</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="P">Percentage</option>
                                    <option value="F">Fixed Amount</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount:</label>
                                <input class="form-control" name="discount" id="discount" type="text"
                                    placeholder="Discount">
                            </div>
                            <div class="form-group">
                                <label for="tamount">Total Amount:</label>
                                <input class="form-control" name="tamount" id="tamount" type="text"
                                    placeholder="Discount">
                                <small id="codenamehelp" class="form-text text-muted">The total amount that must reached
                                    before the coupon is valid.</small>
                            </div>

                            <div class="form-group">
                                <label for="clogin" >Customer Login:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="clogin" id="clogin1"
                                        value="1">
                                    <label class="form-check-label" for="clogin1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="clogin" id="clogin2"
                                        value="2" checked>
                                    <label class="form-check-label" for="clogin2">No</label>
                                </div>
                                <small class="form-text text-muted">Customer must be logged in to
                                    use the coupon.</small>
                            </div>
                            <div class="form-group">
                                <label for="discount" >Free Shipping:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="shipping" id="fshipping"
                                        value="1">
                                    <label class="form-check-label" for="fshipping">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="shipping" id="fshipping1"
                                        value="2" checked>
                                    <label class="form-check-label" for="fshipping1">No</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product">Products:</label>
                                <input class="form-control" name="product" id="product" type="text"
                                    placeholder="Products">
                                <small id="codenamehelp" class="form-text text-muted">Choose specific products the
                                    coupon will apply to. Select no products to apply coupon to entire cart.</small>
                            </div>
                            <div class="form-group">
                                <label for="category">Category:</label>
                                <input class="form-control" name="category" id="category" type="text"
                                    placeholder="Category">
                                <small id="codenamehelp" class="form-text text-muted">Choose specific products the
                                    coupon will apply to. Select no products to apply coupon to entire cart.</small>
                            </div>
                            <div class="form-group">
                                <label for="sdate">Date Start:</label>
                                <input class="form-control" name="sdate" id="sdate" type="date">
                            </div>
                            <div class="form-group">
                                <label for="edate">Date End:</label>
                                <input class="form-control" name="edate" id="edate" type="date">
                            </div>

                            <div class="form-group">
                                <label for="usercoupon">Uses Per Coupon:</label>
                                <input class="form-control" name="usercoupon" id="usercoupon" value="1" type="text"
                                    placeholder="Uses Per Coupon">
                                <small id="codenamehelp" class="form-text text-muted">The maximum number of times the coupon can be used by any customer. Leave blank for unlimited.</small>
                            </div>

                            <div class="form-group">
                                <label for="usercostomer">Uses Per Customer:</label>
                                <input class="form-control" name="usercostomer" id="usercostomer" value="1" type="text"
                                    placeholder="Uses Per Customer">
                                <small id="codenamehelp" class="form-text text-muted">The maximum number of times the coupon can be used by a single customer. Leave blank for unlimited.</small>
                            </div>

                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Enable</option>
                                    <option value="2">disable</option>
                                </select>
                            </div>
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
