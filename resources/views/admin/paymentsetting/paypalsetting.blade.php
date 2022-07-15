{{--
    THIS IS HEADER PAYPALSETTING PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    paypalsetting.blade.php
    Its Used for Paypal Payment Setting
    ----------------------------------------------------------------------------------------------
--}}


{{-- Header --}}
@include('header')
{{-- End Header --}}

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
                        <h1>Paypal</h1>
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
                            <form action="{{ route('storepaypalsetting') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-cog pr-2"></i>
                                        PAYPAL SETTING
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
                                            <input type="radio" class="radio" id="enable" name="paypal_status" value="1" {{ $paypal['pp_express_status'] == 1 ? 'checked' : '' }}>
                                            <label class="btn btn-sm" style="width: 80px; background: green;color:white;" for="enable">Enable</label>
                                            <input type="radio" class="radio" id="disable" name="paypal_status" value="0" {{ $paypal['pp_express_status'] == 0 ? 'checked' : '' }}>
                                            <label class="btn btn-sm" style="width: 80px; background: red;color: white;" for="disable">Disable</label>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">

                                        <div class="form-group mt-3">
                                            <label for="apiusername">* API Username</label>
                                            <input type="text" class="form-control" name="apiusername" value="{{ $paypal['pp_express_username'] }}" id="apiusername">
                                        </div>

                                        <div class="form-group">
                                            <label for="apipassword">* API Password</label>
                                            <input type="text" class="form-control" name="apipassword" value="{{ $paypal['pp_express_password'] }}" id="apipassword">
                                        </div>

                                        <div class="form-group">
                                            <label for="apisignature">* API Signature</label>
                                            <input type="text" class="form-control" name="apisignature" value="{{ $paypal['pp_express_signature'] }}" id="apisignature">
                                        </div>

                                        <div class="form-group">
                                            <label for="fronttext">Front end text</label>
                                            <input type="text" class="form-control" name="fronttext" value="{{ $paypal['pp_front_text'] }}" id="fronttext">
                                        </div>

                                        <div class="form-group">
                                            <label for="sandbox_clint">Sandbox Clint Id</label>
                                            <input type="text" class="form-control" name="sandbox_clint" value="{{ $paypal['pp_sandbox_clint'] }}" id="sandbox_clint">
                                        </div>

                                        <div class="form-group">
                                            <label for="sandbox_secret">Sandbox Secret Key</label>
                                            <input type="text" class="form-control" name="sandbox_secret" value="{{ $paypal['pp_sandbox_secret'] }}" id="sandbox_secret">
                                        </div>

                                        <div class="form-group">
                                            <label class="mr-4" for="sandbox_secret">Paypal(Sandbox)</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="paypalmod" id="yes" value="1" {{ $paypal['pp_express_test'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="paypalmod"  id="no" value="0" {{ $paypal['pp_express_test'] == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="no">No</label>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="deliverytext">Front end text for delivery</label>
                                            <input class="form-control" name="deliverytext" value="{{ $paypal['cod_front_text'] }}" id="deliverytext" type="text">
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="paycharge">Charge for this payment</label>
                                            <input class="form-control" name="paycharge" value="{{ $paypal['pp_charge_payment'] }}" id="paycharge" type="text">
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="minammount">Minimum Amounth</label>
                                            <input class="form-control" name="minammount" id="minammount" type="text">
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="sortorder">Sort Order</label>
                                            <input class="form-control" name="sortorder" value="{{ $paypal['pp_express_sort_order'] }}" id="sortorder" type="text">
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
