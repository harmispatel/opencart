@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category List</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category List </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (count($errors) > 0)
                @if ($errors->any())
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ $errors->first() }}
                    </div>
                @endif
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}

                        <div class="card-header" style="background: #f6f6f6">
                            <h3 class="card-title pt-2 m-0" style="color: black">
                                <i class="fa fa-list"></i>
                                Category List
                            </h3>

                            <div class="container" style="text-align: right">
                                @if (check_user_role(55) == 1)
                                    <a href="{{ route('newcategory') }}" class="btn btn-sm btn-success ml-auto"><i
                                            class="fa fa-plus"></i></a>
                                @endif

                                @if (check_user_role(57) == 1)
                                    <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i
                                            class="fa fa-trash"></i></a>
                                @endif
                            </div>

                        </div>
                        {{-- End Card Header --}}

                        {{-- Card Body --}}
                        <div class="card-body">
                            <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                style="display: none" role="alert">
                                <p id="success-message" class="mb-0"></p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <table class="table table-striped" id="table">
                                <thead class="text-center">
                                    <tr>
                                        <th><input type="checkbox" id="delall"></th>
                                        <th>Category Name</th>
                                        <th>Sort Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center cat-list">

                                    {{-- @foreach ($fetchparent as $data)
                                        <tr>
                                            <td><input type="checkbox" name="del_all" value="{{ $data->category_id }}" class="del_all"></td>
                                            <td>
                                                {{ $data->cat_name }}
                                                @php
                                                    $getsubcat = [];
                                                    $getsubcat = get_subcat($data->category_id);
                                                    
                                                    // echo '<pre>';
                                                    // print_r(count($getsubcat));
                                                    
                                                @endphp
                                                @if (count($getsubcat) > 0)
                                                    @foreach ($getsubcat as $key => $value)
                                                        > {{ $value->cat_name }}
                                                    @endforeach
                                                @endif




                                            </td>


                                            <td>{{ $data->sort_order }}</td>
                                            <td>
                                                @if (check_user_role(56) == 1)
                                                    <a href="{{ 'categoryedit/' . $data->category_id }}"
                                                        class="btn btn-sm btn-primary rounded"><i
                                                            class="fa fa-edit"></i></a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach --}}

                                    @foreach ($fetchparent as $data)
                                        <tr>
                                            <td><input type="checkbox" name="del_all" value="{{ $data->category_id }}"
                                                    class="del_all"></td>
                                            <td>{{ $data->cat_name }}</td>
                                            <td>{{ $data->sort_order }}</td>
                                            <td>
                                                @if (check_user_role(56) == 1)
                                                    <a href="" class="btn btn-sm btn-primary rounded"><i
                                                            class="fa fa-edit"></i></a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        @php
                                            $subcat = get_subcat($data->category_id);
                                        @endphp

                                        @if (!empty($subcat))
                                            @foreach ($subcat as $scat)
                                                <tr>
                                                    <td><input type="checkbox" name="del_all" class="del_all"
                                                            id="del_all" value="{{ $scat->categiry_id }}"></td>
                                                    <td> {{ $data->cat_name }} > {{ $scat->cat_name }} </td>
                                                    <td>{{ $scat->sort_order }}</td>
                                                    <td>
                                                        @if (check_user_role(56) == 1)
                                                            <a href="{{ 'categoryedit/' . $scat->category_id }}"
                                                                class="btn btn-sm btn-primary rounded">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>

                                                @php
                                                    $dsubcat = depend_subcat($scat->category_id);
                                                @endphp

                                                @if (!empty($dsubcat))
                                                    @foreach ($dsubcat as $dcat)
                                                        <tr>
                                                            <td><input type="checkbox" name="del_all"
                                                                    class="del_all" id="del_all"
                                                                    value="{{ $dcat->categiry_id }}"></td>
                                                            <td> {{ $data->cat_name }} > {{ $scat->cat_name }} >
                                                                {{ $dcat->cat_name }} </td>
                                                            <td>{{ $dcat->sort_order }}</td>
                                                            <td>
                                                                @if (check_user_role(56) == 1)
                                                                    <a href="{{ 'categoryedit/' . $dcat->category_id }}"
                                                                        class="btn btn-sm btn-primary rounded">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                                url: '{{ url('categorydelete') }}',
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
        });

        // End Delete User

    });
    // End Delete User
</script>
