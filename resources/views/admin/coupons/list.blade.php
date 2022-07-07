<!--
    THIS IS HEADER Coupons List PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    List.blade.php
    It Displayed All Coupons List & Storewise Display Coupons
    ----------------------------------------------------------------------------------------------
-->


{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Custom CSS for Radio Buttons --}}
<style>
    .radio {
        display: none;
    }

    .radio:checked+label {
        background: rgb(41, 41, 41) !important;
        color: #fff;
    }
</style>
{{-- End Custom CSS for Radio Buttons --}}


{{-- Section of List All Coupons --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Coupons</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
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
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Coupons List
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if (check_user_role(64) == 1)
                                        <a href="{{ route('addcoupon') }}" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    @endif

                                    @if (check_user_role(66) == 1)
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
                                <table class="table table-bordered table-hover" id="myTable">
                                    {{-- Table Head --}}
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="del_all" id="delall"></th>
                                            <th>Coupon Name</th>
                                            <th>Code</th>
                                            <th>Discount</th>
                                            <th>Apply for</th>
                                            <th>Date start</th>
                                            <th>Date end</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="cat-list">
                                        @php $i=1; @endphp
                                        {{-- <form> --}}
                                            @foreach ($coupons as $coupon)
                                                <tr>
                                                    <td><input type="checkbox" name="del_all" class="del_all"
                                                            value="{{ $coupon->coupon_id }}"></td>
                                                    <td>{{ $coupon->name }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            {{ $coupon->code }}
                                                            <form>
                                                                <div class="btn-group ml-2">
                                                                    <input type="radio" class="radio"
                                                                        data-id="{{ $coupon->coupon_id }}"
                                                                        id="enable_{{ $i }}" name="on_off"
                                                                        value="1"
                                                                        {{ $coupon->on_off == 1 ? 'checked' : '' }} />
                                                                    <label class="btn btn-sm"
                                                                        style=" background: green;color:white;"
                                                                        for="enable_{{ $i }}">ON</label>
                                                                    <input type="radio" class="radio"
                                                                        data-id="{{ $coupon->coupon_id }}"
                                                                        id="disable_{{ $i }}" name="on_off"
                                                                        value="0"
                                                                        {{ $coupon->on_off == 0 ? 'checked' : '' }} />
                                                                    <label class="btn btn-sm"
                                                                        style=" background: rgb(248, 9, 9);color: white;"
                                                                        for="disable_{{ $i }}">OFF</label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>{{ $coupon->discount }}</td>
                                                    <td>
                                                        @if ($coupon->apply_shipping == 1)
                                                            Delivery
                                                        @elseif ($coupon->apply_shipping == 2)
                                                            Collection
                                                        @else
                                                            Both
                                                        @endif
                                                    </td>
                                                    <td>{{ $coupon->date_start }}</td>
                                                    <td>{{ $coupon->date_end }}</td>
                                                    <td>{{ $coupon->status == 1 ? 'Enable' : 'Desable' }}</td>
                                                    <td>
                                                        @if (check_user_role(65) == 1)
                                                            <a class="btn btn-sm btn-primary" href="{{ url('editcoupon') }}/{{ $coupon->coupon_id }}"><i class="fa fa-edit"></i></a>
                                                        @else
                                                            <a class="btn btn-sm btn-primary" disabled><i class="fa fa-edit"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php $i++ @endphp
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
        {{-- End List Section --}}

    </div>
</section>
{{-- End Section of List All Coupons --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- END SCRIPT --}}


<script type="text/javascript">

    $(document).ready(function()
    {
        $('#myTable').DataTable();
    });


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

        if (checkValues != '')
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
                    if (willDelete)
                    {
                        $.ajax({
                            type: "POST",
                            url: '{{ url('coupondelete') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': checkValues
                            },
                            dataType: 'JSON',
                            success: function(data)
                            {
                                if (data.success == 1)
                                {
                                    swal("Your Record has been deleted!", {
                                        icon: "success",
                                    });

                                    setTimeout(function()
                                    {
                                        location.reload();
                                    }, 1500);
                                }
                            }
                        });

                    }
                    else
                    {
                        swal("Cancelled", "", "error");

                        setTimeout(function()
                        {
                            location.reload();
                        }, 1000);
                    }
                });
        }
        else
        {
            swal("Please select atleast One Record", "", "warning");
        }
    });
    // End Delete User


    // Change Coupon Status
    $(".radio").on('click', function()
    {
        var onoff = $(this).val();
        var dataid = $(this).attr("data-id");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
                type: "post",
                url: "{{ route('updonoff') }}",
                data: {
                    onoff: onoff,
                    dataid: dataid,
                },
                dataType: "json",
                success: function(response)
                {

                }
        });
    });
    // End Change Coupon Status


</script>
{{-- END SCRIPT --}}
