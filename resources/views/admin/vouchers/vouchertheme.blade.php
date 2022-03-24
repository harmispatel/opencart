@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Voucher Themes --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Voucher Themes</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Voucher Themes </li>
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
                           {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Gift Voucher Themes List
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(55) == 1)
                                        <a href="{{ route('voucherthemelist') }}" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    @endif

                                    @if (check_user_role(57) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered table-hover" id="table">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                            role="alert">
                                            {{ Session::get('success') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{-- Table Head --}}
                                    <thead class="text-center">
                                        <tr>
                                            <th><input type="checkbox" name="del_all" id="delall"></th>
                                            <th>Name</th>
                                       
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    {{-- <tbody class="text-center cat-list">
                                        @foreach ($vouchers as $voucher)
                                        <tr>
                                                <td><input type="checkbox" name="del_all" class="del_all" value="{{ $voucher->voucher_id }}"></td>
                                                <td>{{ $voucher->code }}</td>
                                                <td>{{ $voucher->from_name }}</td>
                                                <td>{{ $voucher->to_name }}</td>
                                                <td>{{ $voucher->amount }}</td>
                                                <td>
                                                    @if ($voucher->apply_shipping == 1)
                                                        Delivery
                                                    @elseif ($voucher->apply_shipping == 2)
                                                        Collection
                                                    @else
                                                        Both
                                                    @endif                                                    
                                                </td>
                                                <td>{{ $voucher->name }}</td>
                                                <td>{{ ($voucher->status == 1) ? "Enable" : "Desable" }}</td>
                                                <td>{{ strtotime($voucher->date_added) }}</td>
                                                <td>[<a href="#">send</a>][<a href="{{ url('voucheredit') }}/{{ $voucher->voucher_id }}">Edit</a>]</td>
                                                
                                            </tr>
                                            @endforeach --}}
                                    </tbody>
                                    {{-- End Table Body --}}
                                </table>
                                {{-- End Table --}}
                            </div>
                            {{-- End Card Body --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Voucher Themes --}}



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
