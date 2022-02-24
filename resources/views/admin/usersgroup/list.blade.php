@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Users Group --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users Group</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users Group</li>
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
                                    Users Group List
                                </h3>

                                @if (check_user_role(10) == 1)
                                    <a href="{{ route('addusergroup') }}" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                @endif

                                <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i class="fa fa-trash"></i></a>
                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <table class="table table-striped" id="usersGroup">
                                       @if(Session::has('success'))
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                       @endif
                                        <thead class="text-center">
                                            <th>
                                                <input type="checkbox" id="delall">
                                            </th>
                                            <th>UserGroup Name</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody class="text-center cat-list">
                                            @foreach ($usersgroup as $usergroup)
                                                <tr>
                                                    <td><input type="checkbox" name="del_all" class="del_all" value="{{ $usergroup->user_group_id }}"></td>
                                                    <td>
                                                        {{ $usergroup->name }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('editusersgroup',$usergroup->user_group_id) }}" class="btn btn-sm btn-primary rounded">
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
{{-- End Section of List Users Group --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


$(document).ready(function() {
    $('#usersGroup').DataTable();
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


// Delete Usergroup
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
                        url: '{{ url("deleteusersgroup") }}',
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
        swal("Please select atleast One UserGroup", "", "warning");
    }
});

// End Delete Usergroup



</script>
