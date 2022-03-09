@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


<style>

/* Loader CSS */
.loader_div
{
    position: absolute;
    top: 30%;
    bottom: 0%;
    left: 10%;
    right: 0%;
    z-index: 99;
    opacity:0.7;
    display: none;
    background: url('{{ asset('public/admin/gif/gif3.gif') }}') center center no-repeat;
    background-size :150px;
}
/* End Loader CSS */

</style>



{{-- Section of List Customers --}}
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
                        <h1>Customers</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customers</li>
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
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                <table class="table table-bordered">
                                    {{-- Table Head Start --}}
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
                                    {{-- End Table Head --}}

                                    {{-- Table Body Start --}}
                                    <tbody class="customers" id="customers">
                                        {{-- @foreach ($customers as $customer )
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="del_all" class="del_all" value="{{ $customer->customer_id }}">
                                                </td>
                                                <td>{{ $customer->firstname }} {{ $customer->lastname }}</td>
                                                <td>-</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->groupname }}</td>
                                                <td>
                                                    @if($customer->status == 1)
                                                        Enabled
                                                    @else
                                                        Disabled
                                                    @endif
                                                </td>
                                                <td>-</td>
                                                <td> {{ $customer->ip }} </td>
                                                <td> {{ date('d-m-Y',strtotime($customer->date_added)) }} </td>
                                                <td>
                                                    @if(check_user_role(102) == 1)

                                                        <div class="btn-group">
                                                            <a href="{{ route('editcustomer',$customer->customer_id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <button type="button" data-toggle="dropdown" class="btn btn-sm btn-primary dropdown-toggle" aria-expanded="false" style="border-left:1px solid white">
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right">
                                                                <li class="dropdown-header">Login into Store</li>
                                                                <li class="text-center">
                                                                    <a href="" target="_blank">
                                                                        <i class="fa fa-lock"></i> Your Store
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                          </div>

                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach --}}
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
        <div id="loader_div" class="loader_div"></div>

    </div>
</section>
{{-- End Section of List Customers Group --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


    $(document).ready(function(){

        // $(".loader_div").show();

        getallCustomers();

    });


    function getallCustomers(){

        var table = $('.table').DataTable({
        processing: true,
        serverSide: true,
        "scrollX": true,
        ajax: "{{ route('getcustomers') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'shop', name: 'shop'},
            {data: 'email', name: 'email'},
            {data: 'customer_group', name: 'customer_group'},
            {data: 'status', name: 'status'},
            {data: 'approved', name: 'approved'},
            {data: 'ip', name: 'ip'},
            {data: 'date_added', name: 'date_added'},
            {data: 'action', name: 'action'},
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


    // Delete Customer Group
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
                            url: '{{ url("deletecustomergroup") }}',
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
            swal("Please select atleast One Customer Group", "", "warning");
        }
    });

// End Delete Customer Group

</script>


