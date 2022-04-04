{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Menu Options --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Group Topping</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu Options</li>
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
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header d-flex" style="background: #f6f6f6">
                                <div class="col-md-2">
                                    <h4 style="color: black">
                                        New Module
                                    </h4>
                                </div>

                                @php
                                    $checknewModel = checkNewModel();
                                @endphp

                                <div class="col-md-4">
                                    <div class="btn-group" role="group" style="height: 30px;" id="newModel">
                                        @if ($checknewModel == 1)
                                            <button class="btn btn-xs btn-success" onclick="newModel(1)">Enabled</button>
                                            <button class="btn btn-xs btn-secondary" onclick="newModel(0)">Disabled</button>
                                        @else
                                            <button class="btn btn-xs btn-secondary" onclick="newModel(1)">Enabled</button>
                                            <button class="btn btn-xs btn-danger" onclick="newModel(0)">Disabled</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6" style="text-align: right">
                                    @if(check_user_role(101) == 1)
                                        <a href="{{ route('addmenuoptions') }}" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                    @endif

                                    @if(check_user_role(103) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered table-hover">
                                    {{-- Table Head --}}
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" name="checkall" id="delall">
                                            </th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="topping" id="topping">

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
{{-- End Section of List Menu Options --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        getallToppings();
    });


    // Get All Toppings
    function getallToppings()
    {
        var table = $('.table').DataTable({
        processing: true,
        serverSide: true,
        "scrollY": true,
        "ajax": {
            "url" : "{{ route('gettoppings') }}",
            "dataType": "json",
            "type": "POST",
            "data":{ _token: "{{csrf_token()}}"},
        },
        columns: [
                    {"data": "checkbox", orderable: false, searchable: false},
                    {"data": "name_topping"},
                    {"data": "action", orderable: false, searchable: false},
                ]
        });
    }
    // End Get All Toppings


    // New Model Enabled Disabled
    function newModel(val)
    {
        $.ajax({
            type: "POST",
            url: "{{ url('newmodel') }}",
            data: {'val':val,"_token": "{{ csrf_token() }}",},
            dataType: "json",
            success: function (response) {
                $('#newModel').html('');
                $('#newModel').html(response.html);
            }
        });
    }
    // End New Model Enabled Disabled


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

// Delete Menu Options
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
                        url: '{{ url("deletetopping") }}',
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
        swal("Please select atleast One Topping", "", "warning");
    }
});
// End Delete Menu Options

</script>
