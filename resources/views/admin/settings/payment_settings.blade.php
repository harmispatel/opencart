{{-- Header --}}
@include('header')
{{-- End Header --}}

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
                            <div class="card-header" style="background: #f6f6f6">
                                <div class="container" style="text-align: right">
                                    {{-- <button type="submit" form="openclosetime" class="btn btn-sm btn-primary ml-auto"><i class="fa fa-save"></i></button> --}}
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openclosetimeset') }}" method="POST" id="openclosetime">
                                    {{ csrf_field() }}
                                    <h5><a href="{{ route('cashpaysetting') }}" style="cursor: pointer;">Cash</a></h5><hr>
                                    {{-- <h5><a href="#" style="cursor: pointer;">Cash on Delivery</a></h5><hr> --}}
                                    <h5><a href="#" style="cursor: pointer;">Paypal</a></h5><hr>
                                    <h5><a href="#" style="cursor: pointer;">Strip</a></h5><hr>
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

{{-- Script Section --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- End Script Section --}}
