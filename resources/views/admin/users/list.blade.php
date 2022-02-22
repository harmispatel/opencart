@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Users --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users </li>
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
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header d-flex justify-content-between
                            p-2" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list"></i>
                                    Users List
                                </h3>
                                <a href="{{ route('adduser') }}" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                <a href="#" class="btn btn-sm btn-danger ml-1"><i class="fa fa-trash"></i></a>
                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <table class="table table-striped" id="usersGroup">
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert" style="display: none" role="alert">
                                            <p id="success-message" class="mb-0"></p>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                        </div>
                                        <thead class="text-center">
                                            <th>
                                                <input type="checkbox">
                                            </th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody class="text-center cat-list">
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="" id="{{ $user->id }}">
                                                    </td>
                                                    <td>
                                                        {{ $user->username }}
                                                    </td>
                                                    <td>
                                                        @if($user->status == 1)
                                                           @php
                                                             echo '<span class="badge badge-success">Enabled</span>';
                                                           @endphp
                                                        @else
                                                            @php
                                                                echo '<span class="badge badge-danger">Disabled</span>';
                                                            @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ date('d/m/Y',strtotime($user->created_at)) }}
                                                    </td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary rounded">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- End Card Body --}}
                                {{-- Start Card Footer --}}
                                {{-- <div class="card-footer">
                                    {{ $categories->links() }}
                                </div> --}}
                                {{-- End Card Footer --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Users --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#usersGroup').DataTable();
} );

// Delete Category
// function deleteCat(id)
// {

//     swal({
//             title: "Are you sure You want to Delete It ?",
//             text: "Once deleted, you will not be able to recover this Record",
//             icon: "warning",
//             buttons: true,
//             dangerMode: true,
//         })
//         .then((willDelete) => {
//             if (willDelete)
//             {

//                 $.ajax({
//                         type: "POST",
//                         url: '{{ url("/deleteCategory") }}',
//                         data: {"_token": "{{ csrf_token() }}",'id':id},
//                         dataType : 'JSON',
//                         success: function (data)
//                         {
//                             if(data.success == 1)
//                             {
//                                 swal("Your Record has been deleted!", {
//                                     icon: "success",
//                                 });

//                                 $('.cat-list').html('');
//                                 getCategories();
//                             }
//                         }
//                 });

//             }
//             else
//             {
//                 swal("Cancelled");
//             }
//         });


// }
// End Delete Category




</script>
