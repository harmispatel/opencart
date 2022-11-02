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
                        <div class="card">
                            <div class="card-header" style="background: #f6f6f6">
                                <div class="card-title pt-0 m-0" style="color: black;">
                                    <h4><i class="fa fa-image"></i> Import CSV</h4>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(Session::has('file_error'))
                                    <div class="row mt-2 mb-2">
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
                                    <div class="row mt-2 mb-2">
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

                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('imp_pro_cat') }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Import Type</label> <br>
                                                            <input type="radio" name="imp_type" value="categories" checked> Categories
                                                            <input type="radio" name="imp_type" value="products"> Products
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Choose CSV File</label>
                                                            <input type="file" class="form-control p-1 {{ ($errors->has('csvFile')) ? 'is-invalid' : '' }}" name="csvFile">
                                                            @if($errors->has('csvFile'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('csvFile') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <button class="btn btn-success">Import &nbsp;<i class="fa fa-arrow-down"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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


