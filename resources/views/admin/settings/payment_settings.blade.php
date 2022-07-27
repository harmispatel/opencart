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


{{-- Section of List Payment Settings --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payment Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payment Settings </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (Session::has('success'))
                <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- <div class="card-header" style="background: #f6f6f6">
                                <div class="container" style="text-align: right">
                                    <button type="submit" form="openclosetime" class="btn btn-sm btn-primary ml-auto"><i class="fa fa-save"></i></button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <form action="{{ route('openclosetimeset') }}" method="POST" id="openclosetime">
                                    {{ csrf_field() }}
                                    <div>
                                        <div class="form-group float-right">
                                            <div class="btn-group">
                                                <input type="radio" class="radioenable p_status" id="cod_enable" name="cod_status" value="1" {{ $paymentstatus['cod_status'] == 1 ? 'checked': '' }}>
                                                <label class="btn btn-sm" style="width: 80px; background: black;color:white;" for="cod_enable">Enable</label>
                                                <input type="radio" class="radiodisable p_status" id="cod_disable" name="cod_status" value="0" {{ $paymentstatus['cod_status'] == 0 ? 'checked': '' }}>
                                                <label class="btn btn-sm" style="width: 80px; background: black;color: white;" for="cod_disable">Disable</label>
                                            </div>
                                        </div>
                                        <h5><a href="{{ route('cashpaysetting') }}" style="cursor: pointer;">Cash</a></h5><hr>
                                    </div>
                                    {{-- <h5><a href="#" style="cursor: pointer;">Cash on Delivery</a></h5><hr> --}}
                                    <div>
                                        <div class="form-group float-right">
                                            <div class="btn-group">
                                                <input type="radio" class="radioenable p_status" id="enable_paypal" name="paypal_status" value="1" {{ $paymentstatus['pp_express_status'] == 1 ? 'checked': '' }}>
                                                <label class="btn btn-sm" style="width: 80px; background: black;color:white;" for="enable_paypal">Enable</label>
                                                <input type="radio" class="radiodisable p_status" id="disable_paypal" name="paypal_status" value="0" {{ $paymentstatus['pp_express_status'] == 0 ? 'checked': '' }}>
                                                <label class="btn btn-sm" style="width: 80px; background: black;color: white;" for="disable_paypal">Disable</label>
                                            </div>
                                        </div>
                                        <h5><a href="{{ route('paypalsetting') }}" style="cursor: pointer;">Paypal</a></h5><hr>
                                    </div>
                                    <div>
                                        <div class="form-group float-right">
                                            <div class="btn-group">
                                                <input type="radio" class="radioenable p_status" id="enable_stripe" name="stripe_status" value="1" {{ $paymentstatus['stripe_status'] == 1 ? 'checked': '' }}>
                                                <label class="btn btn-sm" style="width: 80px; background: black;color:white;" for="enable_stripe">Enable</label>
                                                <input type="radio" class="radiodisable p_status" id="disable_stripe" name="stripe_status" value="0" {{ $paymentstatus['stripe_status'] == 0 ? 'checked': '' }}>
                                                <label class="btn btn-sm" style="width: 80px; background: black;color: white;" for="disable_stripe">Disable</label>
                                            </div>
                                        </div>
                                        <h5><a href="{{ route('stripesetting') }}" style="cursor: pointer;">Strip</a></h5><hr>

                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Payment Settings --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

<script>
    // Change payment Status
    $(".p_status").on('click', function()
    {
        let p_status = $(this).val();
        var p_type = $(this).attr("name");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
                type: "post",
                url: "{{ route('paymentstatus') }}",
                data: {
                    p_status: p_status,
                    p_type: p_type,
                },
                dataType: "json",
                success: function(response)
                {

                }
        });
    });
</script>
