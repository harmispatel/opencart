{{--
    THIS IS HEADER CASHSETTING PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    cashsetting.blade.php
    Its Used for Cash Payment Setting
    ----------------------------------------------------------------------------------------------
--}}


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
                        <h1>Cash</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
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
                            <form action="{{ route('storecashsetting') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-cog pr-2"></i>
                                        CASH SETTING
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('cashpaysetting') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Content --}}
                                    <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">

                                        <div class="form-group">
                                            <label for="fronttext">Front end text for collection</label>
                                            <input type="text" class="form-control" name="fronttext" value="{{ $cod['cod_front_text'] }}" id="fronttext">
                                        </div>

                                        <div class="form-group">
                                            <label for="printertext">Printer Text</label>
                                            <input type="text" class="form-control" name="printertext" value="{{ $cod['cod_printer_text'] }}" id="printertext">
                                        </div>

                                        <div class="form-group">
                                            <label for="deliverytext">Front end text for delivery</label>
                                            <input class="form-control" name="deliverytext" value="{{ $cod['cod_front_text_delivery'] }}" id="deliverytext" type="text">
                                        </div>

                                        <div class="form-group">
                                            <label for="paycharge">Charge for payment</label>
                                            <input class="form-control" name="paycharge" value="{{ $cod['cod_charge_payment'] }}" id="paycharge" type="text">
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="minammount">Minimum Amounth</label>
                                            <input class="form-control" name="minammount" id="minammount" type="text">
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="sortorder">Sort Order</label>
                                            <input class="form-control" name="sortorder" value="{{ $cod['cod_sort_order'] }}" id="sortorder" type="text">
                                        </div>
                                    </div>
                                    {{-- End General Tab --}}

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
