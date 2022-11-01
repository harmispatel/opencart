<!--
    THIS IS HEADER Import Products & Category PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    importproducts.blade.php
    It Displayed All Import Products & Category & Storewise Display Import Products & Category
    ----------------------------------------------------------------------------------------------
-->

{{--Header--}}
@include('header')
{{-- End Header--}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Import Products & Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Import Products & Category</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Import Products & Category </li>
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
                        <div class="card card-primary ">
                            <div class="card-header" style="background: #f6f6f6">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="card-title pt-2 m-0 text-dark"><i class="fa fa-image"></i> &nbsp;Import CSV</h3>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="{{ public_url().'public/admin/demo_csv/demo.csv' }}" style="color: blue;"><i class="fa fa-download"></i download> (Download Demo File)</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(Session::has('file_error'))
                                    <div class="row mt-1 mb-1">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger del-alert alert-dismissible" id="alert" role="alert">
                                                {{ Session::get('file_error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(Session::has('success'))
                                    <div class="row mt-1 mb-1">
                                        <div class="col-md-12">
                                            <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <form action="{{ route('imp_product_category') }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Your CSV</label>
                                                        <input type="file" name="csvFile" class="form-control p-1 {{ ($errors->has('csvFile')) ? 'is-invalid' : '' }}">
                                                        @if($errors->has('csvFile'))
                                                            <span class="text-danger mt-0">
                                                                {{ $errors->first('csvFile') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary"><i class="fa fa-arrow-down"></i> &nbsp;IMPORT</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <h1>Coming Soon..</h1> --}}
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Trasnsactions --}}

{{--Footer Section --}}
@include('footer')
{{--  End Footer Section --}}

{{--script Section--}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

// $(document).ready(function() {
//     $('#transaction').DataTable();
// } );

// Date Range Picker
$(function() {
    $('input[name="daterange"]').daterangepicker();
});

</script>

{{--End script Section--}}


