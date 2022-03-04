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
                        <h1>orders</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Orders</li>
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
                                    Order List
                                </h3>

                                {{-- <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                        <a href="" class="btn btn-sm btn-success ml-auto"><i
                                                class="fa fa-plus"></i></a>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div> --}}
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered">
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
                                        <th>
                                            <input type="checkbox" name="checkall" id="delall">
                                        </th>
                                        <th>Order Id</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Date Added</th>
                                        <th>Date Modified</th>
                                        <th>Action</th>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body Start --}}
                                    <tbody class="text-center review-list">
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="del_all" class="del_all"
                                                        value="{{ $order->order_id }}">
                                                </td>
                                                <td>{{ $order->order_id }}</td>
                                                <td>{{ $order->firstname }} {{ $order->lastname }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->total }}</td>
                                                <td>{{ date('d-m-Y', strtotime($order->date_added)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($order->date_modified)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="btn-group dropleft" role="group">
                                                            <button type="button"
                                                                class="btn btn-secondary dropdown-toggle dropdown-toggle-split bg-info"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropleft</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('editorder') }}"><i
                                                                        class="fas fa-pencil-alt"> Edit</i></a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('deleteorder') }}"><i
                                                                        class="fa fa-trash"> Delete</i></a>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('vieworder',$order->order_id)}}"><button type="button"
                                                                data-toggle="tooltip" data-placement="top" title="View"
                                                                class="btn btn-secondary bg-info rounded-0" id="view">
                                                                <i class="fa fa-eye text-white"></i>
                                                        </button></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
</section>
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    // Data Table of Manufacturers List
    $(document).ready(function() {
        $('.table').DataTable();
    });



    // Select All Checkbox
    $('#delall').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".del_all").prop('checked', true);
        } else {
            $(".del_all").prop('checked', false);
        }
    });
    // End Select All Checkbox


    // Delete User
    $('.deletesellected').click(function() {

        var checkValues = $('.del_all:checked').map(function() {
            return $(this).val();
        }).get();

        if (checkValues != '') {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    text: "Once deleted, you will not be able to recover this Record",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            type: "POST",
                            url: '{{ url('deleteorder') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': checkValues
                            },
                            dataType: 'JSON',
                            success: function(data) {
                                if (data.success == 1) {
                                    swal("Your Record has been deleted!", {
                                        icon: "success",
                                    });

                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);
                                }
                            }
                        });

                    } else {
                        swal("Cancelled", "", "error");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
        } else {
            swal("Please select atleast One User", "", "warning");
        }

    // End Delete User
</script>
