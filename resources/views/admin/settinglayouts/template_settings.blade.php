@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Template Setting --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Template Setting</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Template Setting </li>
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
                        <div class="container">
                            <h4>Themes</h4>
                            <hr>
                            <div class="row">
                                @if (isset($themes))
                                    @foreach ($themes as $theme)
                                        <div class="col-md-4 mt-1 mb-3">
                                            <div class="card h-100" style="border: 1px solid black;">
                                                <div class="card-header bg-dark text-center pt-1 pb-0">
                                                    <h3>{{ $theme->theme_name }}</h3>
                                                </div>
                                                <div class="card-body">
                                                    <img src="{{ asset('public/admin/theme_view/'.$theme->theme_image) }}" class="w-100">
                                                </div>
                                                <div class="card-footer bg-dark">
                                                    @php
                                                        $theme_active = themeActive();
                                                    @endphp

                                                    @if($theme->theme_id == $theme_active)
                                                        <button type="button" class="btn btn-secondary w-100" disabled>ACTIVATED &nbsp;<i class="fa fa-check-circle"></i></button>
                                                    @else
                                                        <a href="{{ route('activetheme',$theme->theme_id) }}" class="btn btn-success w-100">ACTIVE</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Template Setting --}}



@include('footer')

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
