{{--
    THIS IS HEADER STRIPESETTING PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    stripesetting.blade.php
    Its Used for Stripe Payment Setting
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
                        <h1>Stripe</h1>
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
                            <form action="{{ route('storestripesetting') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-cog pr-2"></i>
                                        STRIPE SETTING
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

                                <div class="card-body">
                                    <div class="form-group float-right">
                                        <div class="btn-group">
                                            <input type="radio" class="radio" id="enable" name="stripe_status" value="1" {{ $stripe['stripe_status'] == 1  ? 'checked' : ''}}>
                                            <label class="btn btn-sm" style="width: 80px; background: green;color:white;" for="enable">Enable</label>
                                            <input type="radio" class="radio" id="disable" name="stripe_status" value="0"  {{ $stripe['stripe_status'] == 0  ? 'checked' : ''}}>
                                            <label class="btn btn-sm" style="width: 80px; background: red;color: white;" for="disable">Disable</label>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="publickey">* Public Key</label>
                                        <input type="text" class="@error('public_key') is-invalid @enderror form-control" name="public_key" value="{{ $stripe['stripe_publickey'] }}" id="publickey">
                                        @error('public_key')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="secretkey">* Secret Key</label>
                                        <input type="text" class="@error('secret_key') is-invalid @enderror form-control" name="secret_key" value="{{ $stripe['stripe_secretkey'] }}" id="secretkey">
                                        @error('secret_key')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="printertext">Printer Text</label>
                                        <input type="text" class="form-control" name="printertext" value="{{ $stripe['stripe_printer_text'] }}" id="printertext">
                                    </div>

                                    <div class="form-group">
                                        <label for="paycharge">Charge for this payment</label>
                                        <input class="form-control" name="paycharge" value="{{ $stripe['stripe_charge_payment'] }}" id="paycharge" type="text">
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="order_status">* Successful Transaction Order Status</label>
                                        <select class="form-control" id="order_status" name="order_status">
                                            <option selected disabled>Please select an option...</option>
                                            @foreach ($orderstatus as $item)
                                                <option value="{{ $item->order_status_id }}" {{ ($item->order_status_id == $stripe['stripe_order_status']) ? 'selected' : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Select the desired status for a succesful transaction made through the gateway</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="orderstatus_faild">* Failed Transaction Order Status</label>
                                        <select class="form-control" id="orderstatus_faild" name="orderstatus_faild">
                                            <option selected disabled>Please select an option...</option>
                                            @foreach ($orderstatus as $item)
                                                <option value="{{ $item->order_status_id }}" {{ ($item->order_status_id == $stripe['stripe_orderstatus_faild']) ? 'selected' : "" }}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Select the desired status for a failed transaction made through the gateway</small>
                                    </div> --}}
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
