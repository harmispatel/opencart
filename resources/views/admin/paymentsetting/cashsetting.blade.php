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

{{-- Custom CSS for Radio Buttons --}}
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
{{-- End Custom CSS for Radio Buttons --}}

<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
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
                                        <a href="{{ route('paymentsettings') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group float-right">
                                        <div class="btn-group">
                                            <input type="radio" class="radioenable" id="enable" name="cod_status" value="1" {{ $cod['cod_status'] == 1 ? 'checked': '' }}>
                                            <label class="btn btn-sm" style="width: 80px;background: black; color: white;" for="enable">Enable</label>
                                            <input type="radio" class="radiodisable" id="disable" name="cod_status" value="0" {{ $cod['cod_status'] == 0 ? 'checked': '' }}>
                                            <label class="btn btn-sm" style="width: 80px;background: black; color: white;" for="disable">Disable</label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">

                                        <div class="form-group mt-3">
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


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
