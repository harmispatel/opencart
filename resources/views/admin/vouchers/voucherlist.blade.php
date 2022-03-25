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
                        <h1>Gift Voucher</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Gift Voucher</li>
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
                                    Gift Voucher List
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(55) == 1)
                                        <a href="{{ route('giftvoucher') }}" class="btn btn-sm btn-primary ml-auto">
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
                                    {{-- Table Head --}}
                                    <thead class="text-center">
                                        <tr>
                                            <th><input type="checkbox" name="del_all" id="delall"></th>
                                            <th>Code</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Amount</th>
                                            <th>Apply for</th>
                                            <th>Theme</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="text-center cat-list">
                                        @foreach ($vouchers as $voucher)
                                        <tr>
                                                <td><input type="checkbox" name="del_all" class="del_all" value="{{ $voucher->voucher_id }}"></td>
                                                <td>{{ $voucher->code }}</td>
                                                <td>{{ $voucher->from_name }}</td>
                                                <td>{{ $voucher->to_name }}</td>
                                                <td>{{ $voucher->amount }}</td>
                                                <td>
                                                    @if ($voucher->apply_shipping == 1)
                                                        Delivery
                                                    @elseif ($voucher->apply_shipping == 2)
                                                        Collection
                                                    @else
                                                        Both
                                                    @endif                                                    
                                                </td>
                                                <td>{{ $voucher->name }}</td>
                                                <td>{{ ($voucher->status == 1) ? "Enable" : "Desable" }}</td>
                                                <td>{{ date('d-m-Y',strtotime($voucher->date_added)) }}</td>
                                                <td><a class="btn btn-sm btn-primary" href="#"><i class="fa fa-envelope"></i></a><a class="ml-2 btn btn-sm btn-primary" href="{{ url('voucheredit') }}/{{ $voucher->voucher_id }}"><i class="fa fa-edit"></i></a></td>
                                                
                                            </tr>
                                            @endforeach
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


$(document).ready( function () {
    $('#table').DataTable();
} );
    $(document).ready(function() {
        getallcategory();
    });


    // End Get All Category

    // Select All Checkbox
    $('#delall').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".del_all").prop('checked', true);
        } else {
            $(".del_all").prop('checked', false);
        }
    });
    // End Select All Checkbox

    // Delete Multiple User
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
                            url: '{{ url('voucherdelete') }}',
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
            swal("Please select atleast One Record", "", "warning");
        }
    });
    // End Delete User
</script>
