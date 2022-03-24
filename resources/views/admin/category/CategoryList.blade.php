{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Category List
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(55) == 1)
                                        <a href="{{ route('newcategory') }}" class="btn btn-sm btn-primary ml-auto">
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
                                    @if(Session::has('success'))
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                                            {{ Session::get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    {{-- Table Head --}}
                                    <thead class="text-center">
                                        <tr>
                                            <th><input type="checkbox" id="delall"></th>
                                            <th>Category Name</th>
                                            <th>Sort Order</th>
                                            <th>Action</th>
                                        </tr>
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

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}



{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">

    $(document).ready(function()
    {
        getallcategory();
    });

    // Get All Category
    function getallcategory()
    {
        var table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        // "scrollX": true,
        ajax: "{{ route('getcategory') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
            {data: 'cat_name', name:'cat_name'},
            {data: 'sort_order', name: 'sort_order'},
            {data: 'action', name: 'action'},
        ]
        });
    }
    // End Get All Category

    // Select All Checkbox
    $('#delall').on('click', function(e)
    {
        if ($(this).is(':checked', true))
        {
            $(".del_all").prop('checked', true);
        }
        else
        {
            $(".del_all").prop('checked', false);
        }
    });
    // End Select All Checkbox

    // Delete Multiple User
    $('.deletesellected').click(function()
    {
        var checkValues = $('.del_all:checked').map(function()
        {
            return $(this).val();
        }).get();

        if(checkValues != '')
        {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    text: "Once deleted, you will not be able to recover this Record",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) =>
                {
                    if(willDelete)
                    {
                        $.ajax({
                                type: "POST",
                                url: '{{ url('categorydelete') }}',
                                data: {
                                        "_token": "{{ csrf_token() }}",
                                        'id': checkValues
                                      },
                                dataType: 'JSON',
                                success: function(data)
                                {
                                    if(data.success == 1)
                                    {
                                        swal("Your Record has been deleted!", {
                                            icon: "success",
                                        });

                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                    }
                                }
                        });

                    }
                    else
                    {
                        swal("Cancelled", "", "error");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
        }
        else
        {
            swal("Please select atleast One Catgory", "", "warning");
        }
    });
    // End Delete User

</script>
