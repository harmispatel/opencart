<!--
    THIS IS HEADER CUSTOMER LIST PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    list.blade.php
    It's used for Displayed Customer List
    ----------------------------------------------------------------------------------------------
-->


<!-- Header Section -->
@include('header')
<!-- End Header Section -->

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


<!-- Section of List Customers -->
<section>
    <div class="content-wrapper">
        <!-- Breadcumb Section -->
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
                        <h1>Customers</h1>
                    </div>
                    <!-- Breadcrumb Start -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customers</li>
                        </ol>
                    </div>
                    <!-- End Breadcumb -->
                </div>
            </div>
        </section>
        <!-- End Breadcumb Section -->

        <!-- List Section Start -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Card Start -->
                        <div class="card">
                            <!-- Card Header -->
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Customers List
                                </h3>

                                <div class="container" style="text-align: right">
                                    @if(check_user_role(101) == 1)
                                        <a href="{{ route('addcustomer') }}" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                    @endif

                                    @if(check_user_role(103) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            <!-- End Card Header -->

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Table -->
                                <table class="table table-bordered">
                                    <!-- Table Head Start -->
                                    <thead>
                                        <th>
                                            <input type="checkbox" name="checkall" id="delall">
                                        </th>
                                        <th>Customer Name</th>
                                        <th>Shop</th>
                                        <th>E-mail</th>
                                        <th>Customer Group</th>
                                        <th>Status</th>
                                        <th>Approved</th>
                                        <th>IP</th>
                                        <th>Date Added</th>
                                        <th>Action</th>
                                    </thead>
                                    <!-- End Table Head -->

                                    <!-- Table Body Start -->
                                    <tbody class="customers" id="customers">
                                    </tbody>
                                    <!-- End Table Body -->
                                </table>
                                <!-- End Table -->
                            </div>
                            <!-- End Card Body -->
                        </div>
                        <!-- End Card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Form Section -->
    </div>
</section>
<!-- End Section of List Customers Group -->


<!-- Footer Start -->
@include('footer')
<!-- End Footer -->


<!-- SCRIPT -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        getallCustomers();
    });


    // Function for get Customers
    function getallCustomers()
    {
        var table = $('.table').DataTable();
        table.destroy();

        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            "scrollX": true,
            ajax: "{{ route('getcustomers') }}",
            "order": [0, 'desc'],
            columns: [
                {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'shop', name: 'shop', orderable: false, searchable: false},
                {data: 'email', name: 'email'},
                {data: 'customer_group', name: 'customer_group', orderable: false, searchable: false},
                {data: 'status', name: 'status'},
                {data: 'approved', name: 'approved', orderable: false, searchable: false},
                {data: 'ip', name: 'ip'},
                {data: 'date_added', name: 'date_added'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }


    // Select All Checkbox
    $('#delall').on('click', function(e) {
        if($(this).is(':checked',true))
        {
            $(".del_all").prop('checked', true);
        }
        else
        {
            $(".del_all").prop('checked',false);
        }
    });
    // End Select All Checkbox


    // Delete Customers
    $('.deletesellected').click(function()
    {

        var checkValues = $('.del_all:checked').map(function()
        {
            return $(this).val();
        }).get();

        if(checkValues !='')
        {
            swal({
                title: "Are you sure You want to Delete It ?",
                text: "Once deleted, you will not be able to recover this Record",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete)
                {

                    $.ajax({
                            type: "POST",
                            url: '{{ url("deletecustomer") }}',
                            data: {"_token": "{{ csrf_token() }}",'id':checkValues},
                            dataType : 'JSON',
                            success: function (data)
                            {
                                if(data.success == 1)
                                {
                                    swal("Your Record has been deleted!", {
                                        icon: "success",
                                    });

                                    setTimeout(function(){
                                        location.reload();
                                    }, 1500);
                                }
                            }
                    });

                }
                else
                {
                    swal("Cancelled", "", "error");
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            });
        }
        else
        {
            swal("Please select atleast One Customer", "", "warning");
        }
    });
    // End Delete Customers
</script>
<!-- END SCRIPT -->

