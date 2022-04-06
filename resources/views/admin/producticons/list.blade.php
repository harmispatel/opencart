{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Product Icons --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
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
                        <h1>Product Icons</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product Icons </li>
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
                        {{-- Card --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Product Icons List
                                </h3>

                                <div class="container" style="text-align: right">
                                    @if(check_user_role(101) == 1)
                                        <a href="{{ route('addproducticon') }}" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                    @endif

                                    @if(check_user_role(103) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    {{-- Table --}}
                                <table class="table table-bordered table-striped">
                                    {{-- Table Head Start --}}
                                    <thead>
                                        <th>
                                            <input type="checkbox" name="checkall" id="delall">
                                        </th>
                                        <th>Icon</th>
                                        <th>Name</th>
                                        <th>Alt Description</th>
                                        <th>Icon URL</th>
                                        <th>Sort Order</th>
                                        <th>Action</th>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body Start --}}
                                    <tbody>
                                        @if (isset($producticons))
                                            @foreach ($producticons as $picon)
                                                <tr>
                                                    <td><input type="checkbox" name="del_all" class="del_all" value="{{ $picon->id }}"></td>
                                                    <td>
                                                        @if(isset($picon->icon_url))
                                                            <img src="{{$picon->icon_url}}" width="60">
                                                        @else
                                                            Not Found
                                                        @endif
                                                    </td>
                                                    <td>{{ $picon->icon_name }}</td>
                                                    <td>{{ $picon->icon_desc }}</td>
                                                    <td>{{ $picon->icon_url }}</td>
                                                    <td>{{ $picon->icon_sort }}</td>
                                                    <td>
                                                        <a href="{{ route('editproducticons',$picon->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    {{-- End Table Body --}}
                                </table>
                                {{-- End Table --}}
                                </div>
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
{{-- End Section of List Product Icons --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        $('.table').DataTable({
            "columnDefs": [ {
                "orderable": false, targets: [0,1,6] ,
            } ]
        });
    } );


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


    // Delete Product Icons
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
                            url: '{{ url("deleteproducticons") }}',
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
            swal("Please select atleast One Product Icon", "", "warning");
        }
    });
    // End Delete Product Icons

</script>
{{-- END SCRIPT --}}
