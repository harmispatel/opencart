<!--
    THIS IS HEADER FreeItemsList PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    freeitemlist.blade.php
    It Displayed All FreeItem List & Storewise Display FreeItems
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Free Items --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Free Items</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Free Items </li>
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
                        <div class="card card-primary text-center">
                            <h1>Comming Soon</h1>
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Free Items --}}


{{-- Footer  --}}
@include('footer')
{{-- End Footer  --}}

{{-- Script Section--}}
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

{{-- End Script Section--}}
