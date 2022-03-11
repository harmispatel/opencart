@include('header')

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
                                <h2 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-cog fw"></i>&nbsp;&nbsp;
                                    category &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="category" id="categorys" style="width: 70%">
                                        @foreach ($category as $categorys)
                                            <option value="{{ $categorys->category_id }}">{{ $categorys->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </h2>
                                {{-- <h3>category</h3> --}}
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(59) == 1)
                                        <a href="{{ route('addproduct') }}" class="btn btn-sm btn-success ml-auto"><i
                                                class="fa fa-plus"></i></a>
                                    @endif

                                    @if (check_user_role(61) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table Start --}}
                                <table class="table table-bordered">
                                    {{-- Alert Message div --}}
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
                                    {{-- End Alert Message div --}}

                                    {{-- Table Head --}}
                                    <thead class="text-center">
                                        <th>
                                            <input type="checkbox" name="checkall" id="delall">
                                        </th>
                                        <th>Image</th>
                                        <th id="name">Product Name</th>
                                        <th id="price">Price</th>
                                        <th id="status">Status</th>
                                        <th id="sort_order">Sort Order</th>
                                        <th id="action">Action</th>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="text-center cat-list">
                                        
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

<script>
    $(document).ready(function() {

        $('#categorys').change(function() {
            var categoryval = this.value;
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "post",
                url: "{{ route('getproductbycategory') }}",
                dataType: "json",
                data: {
                    category_id: categoryval
                },
                success: function(result) {
                    $('.table tbody').html('');
                    $('.table tbody').html(result);
                }

            });
        });

    });
</script>

<script>

$(document).ready(function(){

// $(".loader_div").show();

getallproduct();

});

function getallproduct() {

var table = $('.table').DataTable({
    processing: true,
    serverSide: true,
    
    ajax: "{{ route('getproduct') }}",
    columns: [{
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
            searchable: true
        },
        {
            data: 'image',
            name: 'image'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'price',
            name: 'price'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'sort_order',
            name: 'sort_order'
        },
        {
            data: 'action',
            name: 'action'
        },
    ]
});

}
        





</script>
