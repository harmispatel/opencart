{{--
    THIS IS HEADER Product List PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    list.blade.php
    It Displayed All Product List & Storewise Display Products
    ----------------------------------------------------------------------------------------------
--}}
@php
    if(session()->has('current_category_id')){
        $current_category_id = session()->get('current_category_id');
    }else{
        $current_category_id = 0;
    }
@endphp


{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Products --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product List</h1>
                    </div>

                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product List</li>
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
                                <h2 class="card-title pt-2 m-0" style="color: black ;display: flex;
                                align-items: baseline;">
                                    <i class="fa fa-cog fw"></i>&nbsp;&nbsp;
                                    category &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="category" id="categorys" style="width: 70%">
                                        @foreach ($category as $categorys)
                                            <option value="{{ $categorys->category_id }}" {{ ($current_category_id == $categorys->category_id ) ? 'selected' : '' }}>{{ $categorys->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </h2>
                                {{-- <h3>category</h3> --}}
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(49) == 1)
                                        <a href="{{ route('addproduct') }}" class="btn btn-sm btn-success ml-auto"><i
                                                class="fa fa-plus"></i></a>
                                    @endif

                                    @if (check_user_role(52) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                <input type="hidden" name="catid" id="changecatid">
                                {{-- Alert Message div --}}
                                @if (Session::has('success'))
                                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                                        {{ Session::get('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            {{-- End Alert Message div --}}
                            {{-- Table Start --}}
                                <table class="table table-bordered " id="data-table">
                                    {{-- Table Head --}}
                                    <thead class="text-center header" id="header">
                                            <th><input type="checkbox" name="checkall" id="del_all"></th>
                                            <th id="image">Image</th>
                                            <th id="name">Product Name</th>
                                            <th id="price">Price</th>
                                            <th id="status">Status</th>
                                            <th id="sort_order">Sort Order</th>
                                            <th id="action">Action</th>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="text-center cat-list" id="cat-list">

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
{{-- End Section of Add Category --}}
@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Select All Checkbox
    $(document).on("click", "#del_all", function (e) {
        if ($(this).is(':checked', true)) {
            $(".del_all").prop('checked', true);
        } else {
            $(".del_all").prop('checked', false);
        }
    });
    // End Select All Checkbox


    // Delete User
    $('.deletesellected').click(function() {

        var checkValues = $('.del_all:checked').map(function()
        {
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
                            url: '{{ url('deleteproduct') }}',
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
            swal("Please select atleast One Product", "", "warning");
        }
    });
</script>


{{--  Start Get Product  --}}
<script>
    $(document).ready(function() {
        var catval = $('#categorys :selected').val();
        var table =  $('#data-table').DataTable();
        table.destroy();

        $(function() {
            $.ajax({
                url: "{{ route('productsizeprice') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cat_id: catval,
                    // category_id:categoryval,
                },
                success: function (response) {
                    $("#header").replaceWith(response.subheader);
                }
            });
        });


        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            // scrollY: false,
            scrollX: true,
            "ajax": {
                "url": "{{ route('getproduct') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    cat_id: catval,
                    // category_id:categoryval,
                },
            },
            "order": [0, 'asc'],
            columns: [{
                    "data": "checkbox",
                    "orderable": false,
                    "bSortable": true,
                    "width":"5%"
                },
                {
                    "data": "image",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
                {
                    "data": "name",
                    "orderable": false,
                    "bSortable": true,
                    "width":"20%"
                },
                {
                    "data": "price",
                    "orderable": false,
                    "bSortable": true,
                    "width":"35%"
                },
                {
                    "data": "status",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
                {
                    "data": "sort_order",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
            ]
        });
    });

    $('#categorys').change(function() {

        var table =  $('#data-table').DataTable();
          table.destroy();
        var categoryval = this.value;

        $(function() {
            $.ajax({
                url: "{{ route('productsizeprice') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cat_id: categoryval,
                    // category_id:categoryval,
                },
                success: function (response) {
                    $("#header").replaceWith(response.subheader);
                }
            });
        });
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            // scrollY: false,
            scrollX: true,
            "ajax": {
                "url": "{{ route('getproduct') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    cat_id: categoryval,
                    // category_id:categoryval,
                },
            },
            columns: [{
                    "data": "checkbox",
                    "orderable": false,
                    "bSortable": true,
                    "width":"5%"
                },
                {
                    "data": "image",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
                {
                    "data": "name",
                    "orderable": false,
                    "bSortable": true,
                    "width":"20%"
                },
                {
                    "data": "price",
                    "orderable": false,
                    "bSortable": true,
                    "width":"35%"
                },
                {
                    "data": "status",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
                {
                    "data": "sort_order",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "bSortable": true,
                    "width":"10%"
                },
            ]
        });
    });
</script>

{{--  End Get Product  --}}
