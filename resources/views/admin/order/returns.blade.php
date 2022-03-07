@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Reviews --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Returns</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product Returns </li>
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
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Product Returns
                                </h3>

                                <div class="container" style="text-align: right">
                                    <a href="{{ route('addnewreturns') }}" class="btn btn-sm btn-success ml-auto"><i
                                            class="fa fa-plus"></i></a>

                                    <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                            class="fa fa-trash"></i></a>
                                </div>
                            </div>
                            {{-- End Card Header --}}
                            @if (count($errors) > 0)
                                @if ($errors->any())
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                            @endif
                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Table --}}
                                    <table class="table table-bordered" id="table">
                                        {{-- Alert  Message Div --}}
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                            style="display: none" role="alert">
                                            <p id="success-message" class="mb-0"></p>
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        {{-- End Alert Message Div --}}

                                        {{-- Table Head Start --}}
                                        <thead class="text-center">
                                            <th><input type="checkbox" name="checkall" id="delall"></th>
                                            <th>Return Id</th>
                                            <th>Order Id</th>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Model</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Date Modified</th>
                                            <th>Action</th>
                                        </thead>
                                        {{-- End Table Head --}}

                                        {{-- Table Body Start --}}
                                        <tbody class="text-center review-list">
                                            {{-- @foreach ($orders as $order) --}}
                                            @foreach ($returns as $return)
                                                <tr>
                                                    <td><input type="checkbox" name="del_all"
                                                            value="{{ 'sd' }}" class="del_all"></td>
                                                    <td>{{ $return->return_id }}</td>
                                                    <td>{{ $return->order_id }}</td>
                                                    <td>{{ $return->firstname }} {{ $return->lastname }}</td>
                                                    <td>{{ $return->product }}</td>
                                                    <td>{{ $return->model }}</td>
                                                    <td>{{ $return->name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($return->date_added)) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($return->date_modified)) }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-primary"><i
                                                                class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    // Data Table of Manufacturers List
    $(document).ready(function() {
        $('#table').DataTable();


        // Select All Checkbox
        $('#delall').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".del_all").prop('checked', true);
            } else {
                $(".del_all").prop('checked', false);
            }
        });
        // End Select All Checkbox

    });
</script>
