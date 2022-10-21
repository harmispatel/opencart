<!--
    THIS IS HEADER NewOrders List PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    List.blade.php
    It Displayed All NewOrders List & Storewise Display NewOrders
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End  Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
    .calender_tabs ul {
        padding: 0;
        margin: 0;
        list-style: none;
        display: flex;
        justify-content: space-around;
    }

    .calender_tabs ul li {
        padding: 5px 10px;
        color: #000;
        background-color: #fff;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }

    .calender_tabs ul li span {
        font-size: 14px;
        padding-left: 20px;
    }

    .box-title .ion-bag {
        font-size: 40px;
        color: #2c9ea9;
    }

    .small-box .inner {
        min-height: 145px;
    }

</style>

@php
    $range = session()->get('range');
@endphp

{{-- Section of List New Order --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>New Orders</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">New Orders </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}


        {{-- modal open --}}
        <div class="modal fade" id="orderReciept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">

              </div>
            </div>
          </div>
        {{-- modal colose --}}


        {{-- List Section Start --}}
        <section class="content" id="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #424e64">
                                <div class="div">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="calender_tabs">
                                                <ul>
                                                    <li><input type="radio" name="calender_tabs" value="day"
                                                            onclick="calender_tabs(this.value);"
                                                            {{ $range == 'day' ? 'checked' : '' }}><span>DAILY</span>
                                                    </li>
                                                    <li><input type="radio" name="calender_tabs" value="week"
                                                            onclick="calender_tabs(this.value);"
                                                            {{ $range == 'week' ? 'checked' : '' }}><span>WEEKLY</span>
                                                    </li>
                                                    <li><input type="radio" name="calender_tabs" value="month"
                                                            onclick="calender_tabs(this.value);"
                                                            {{ $range == 'month' ? 'checked' : '' }}><span>MONTHLY</span>
                                                    </li>
                                                    <li><input type="radio" name="calender_tabs" value="year"
                                                            onclick="calender_tabs(this.value);"
                                                            {{ $range == 'year' ? 'checked' : '' }}><span>YEARLY</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="container d-flex justify-content-around align-items-center">
                                                <a href="javascript:void(0)" class="mr-2 right-arrow arrow-date arraow-date-slector" onclick="onchangeDatepickerFillter('pre')"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>

                                                <div class="input-group date mr-2 " id="datetimepicker1">
                                                    <label for="date1 mt-2">From : </label>&nbsp;&nbsp;
                                                    <input disabled type="text" id="date1" class="form-control">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" id="btnGroupAddon"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>

                                                <div class="input-group date ml-1" id="datetimepicker2">
                                                    <label for="date2">To : </label>&nbsp;&nbsp;
                                                    <input disabled id="date2" type="text" class="form-control">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" id="btnGroupAddon"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>

                                                <a href="javascript:void(0)" class="ml-2 left-arrow arrow-date arraow-date-slector" onclick="onchangeDatepickerFillter('next')"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            @if (!empty($range) || $range != '')
                                <div class="card-body">
                                    <div class="card p-3">
                                        <div class="spinner text-center"><img src="{{ asset("public/admin/gif/gif5.gif") }}" width="200"></div>
                                        <div class="row" id="card-stats">
                                        </div>
                                    </div>

                                    <div class="card p-3">
                                        <div class="rowbtn">
                                            <div class="buttonsection">
                                                <div class="row justify-content-between"
                                                    style="justify-content: space-between;">
                                                    <div class="col-lg-3 col-xs-3">
                                                        <select name="type" id="type" class="form-control" onchange="filter(this.value,'type')">
                                                            <option value="">select type</option>
                                                            <option value="collection">collection</option>
                                                            <option value="delivery">delivery</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-xs-3">
                                                        <select name="orderpayment" id="orderpayment" class="form-control" onchange="filter(this.value,'orderpayment')">
                                                            <option value =''>Order Total</option>
                                                            <option value ='cod'>cod</option>
                                                            <option value ='paypal'>paypal</option>
                                                            <option value ='stripe'>stripe</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-xs-3">
                                                        <select name="status" id="status" class="form-control" onchange="filter(this.value,'status')">
                                                            <option value="">Status</option>
                                                            <option value="2">Processing</option>
                                                            <option value="7"> Rejected</option>
                                                            <option value="5">Complete</option>
                                                            <option value="11">Refunded</option>
                                                            <option value="1">Charge Back</option>
                                                            <option value="15">Accepted</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-xs-3 text-right pull-right">
                                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card p-3" id="table">
                                        <table class="table table-striped" id="DataTable" border="1">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="checkall" id="delall"></th>
                                                    <th>Type</th>
                                                    <th>Order No</th>
                                                    <th>Shop Name</th>
                                                    <th>Customer</th>
                                                    <th>Order Total</th>
                                                    <th>Order Time</th>
                                                    <th>Status</th>
                                                    <th>Print</th>
                                                    <th>SMS</th>
                                                    <th>Reply</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endif
                        </div>
                        {{-- End Card Body --}}
                    </div>
                    {{-- End Card --}}
                </div>
            </div>
    </div>
</section>
{{-- End Form Section --}}
</section>
{{-- End Section of List Trasnsactions --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- Script Section --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


    $('document').ready(function(){
        // var date = new Date();
        // var strDate = "00:00 " + date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();
        // var endDate = "23:59 " + date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();

		$('#date1').val('Start Date');
		$('#date2').val('End Date');

        var currentRange = $('input[name="calender_tabs"]:checked').val();

        $.ajax({
            type: "POST",
            url: "{{ route('getallorderdetails') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "currentRange":currentRange
            },
            beforeSend: function() {
                $('.spinner').show();
                $('#card-stats').html('');
                $('.arrow-date').hide();
            },
            dataType: "JSON",
            success: function (response) {
                if(response.success == 1)
                {
                    $('.spinner').hide();
                    $('.arrow-date').show();

                    $('#date1').val(response.startDate);
		            $('#date2').val(response.endDate);

                    $('#card-stats').html('');
                    $('#card-stats').html(response.card);

                    // $('#equictntbl').dataTable().fnClearTable();
                    $('.tbody').html('');
                    $('.table').dataTable().fnDestroy();
                    $('.tbody').html(response.table_data);
                    $('.table').dataTable();
                }
            }
        });

    });


    // Get Order Details By Calendar Tabs
    function calender_tabs(range) {

        var currentRange = range;

        $('#card-stats').html('');
        $('.tbody').html('');

        $.ajax({
            type: "POST",
            url: "{{ route('getallorderdetails') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "currentRange":currentRange
            },
            beforeSend: function() {
                $('.spinner').show();
                $('.table').dataTable().fnClearTable();
            },
            dataType: "JSON",
            success: function (response) {
                if(response.success == 1)
                {
                    $('.spinner').hide();

                    $('#date1').val(response.startDate);
		            $('#date2').val(response.endDate);

                    $('#card-stats').html('');
                    $('#card-stats').html(response.card);

                    $('.tbody').html('');
                    $('.table').dataTable().fnDestroy();
                    $('.tbody').html(response.table_data);
                    $('.table').dataTable();
                }
            }
        });
    }


    // Get Orders Details By Date
    function onchangeDatepickerFillter(type){

        var date_type = type;
        var currentRange = $('input[name="calender_tabs"]:checked').val();
        var startDate = $('#date1').val();
		var endDate = $('#date2').val();

        if(currentRange == 'year')
        {
            $.ajax({
                type: "POST",
                url: "{{ route('getallorderdetailsbyYear') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "currentRange":currentRange,
                    "start_date":startDate,
                    "end_date":endDate,
                    "date_type":date_type,
                },
                beforeSend: function() {
                    $('.spinner').show();
                    $('#DataTable').dataTable().fnClearTable();
                    $('#card-stats').html('');
                    $('.arrow-date').hide();
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.success == 1)
                    {
                        var oldTab = $('.table').DataTable();
                        oldTab.destroy();

                        var table = $('.table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                "url":"{{ route('getOrderListByYear') }}",
                                "type":"POST",
                                "data": {
                                    "_token": "{{ csrf_token() }}",
                                    "currentRange":currentRange,
                                    "start_date":startDate,
                                    "end_date":endDate,
                                    "date_type":date_type,
                                    }
                            },
                            columns: [
                                {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
                                {data: 'type', name: 'type'},
                                {data: 'order_id', name: 'order_id'},
                                {data: 'store_name', name: 'store_name'},
                                {data: 'customer_name', name: 'customer_name'},
                                {data: 'order_total', name: 'order_total'},
                                {data: 'date_added', name: 'date_added'},
                                {data: 'order_status', name: 'order_status'},
                                {data: 'order_print', name: 'order_print'},
                                {data: 'order_sms', name: 'order_sms'},
                                {data: 'order_reply', name: 'order_reply'},
                            ],
                        });

                        $('.spinner').hide();
                        $('.arrow-date').show();
                        $('#date1').val(response.startDate);
                        $('#date2').val(response.endDate);
                        $('#card-stats').html('');
                        $('#card-stats').html(response.card);
                    }
                }
            });
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "{{ route('getallorderdetails') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "currentRange":currentRange,
                    "start_date":startDate,
                    "end_date":endDate,
                    "date_type":date_type,
                },
                beforeSend: function() {
                    $('#card-stats').html('');
                    // $('.arrow-date').hide();
                    $('.spinner').show();
                    $('.table').dataTable().fnClearTable();
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.success == 1)
                    {
                        $('.spinner').hide();

                        $('.arrow-date').show();

                        $('#date1').val(response.startDate);
                        $('#date2').val(response.endDate);

                        $('#card-stats').html('');
                        $('#card-stats').html(response.card);

                        // $('#equictntbl').dataTable().fnClearTable();
                        $('.tbody').html('');
                        $('.table').dataTable().fnDestroy();
                        $('.tbody').html(response.table_data);
                        $('.table').dataTable();
                    }
                }
            });
        }


    }



    // Get Order Receipt By Order ID
    function  getOrderReceipt(orderID){

        $.ajax({
            type: "POST",
            url: "{{ route('getReceiptByOrderID') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "order_id":orderID
            },
            dataType: "JSON",
            success: function (response) {
                if(response.success == 1)
                {
                    $('#orderReciept .modal-content').html('');
                    $('#orderReciept .modal-content').html(response.result);
                    $('#orderReciept').modal('show');
                }
            }
        });

    }


    // Select All Checkbox
    $(document).on("click", "#delall", function(e) {
        if ($(this).is(':checked', true)) {
            $(".delall").prop('checked', true);
        } else {
            $(".delall").prop('checked', false);
        }
    });
    // End Select All Checkbox



    // Delete User
    $('.deletesellected').click(function() {

        var checkValues = $('.delall:checked').map(function() {
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
                            url: '{{ url('deleteorder') }}',
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
            swal("Please select atleast One order", "", "warning");
        }
    });
    // Date Range Picker
    $(function() {
        $('input[name="daterange"]').daterangepicker();
    });

    $('.orderdetail').click(function (e) {
        e.preventDefault();
        var orderid = $(this).val();
        $.ajax({
                type: "POST",
                url: '{{ route('orderdetail') }}',
                data: {
                    'orderid': orderid,
                },
                dataType: 'JSON',
                success: function (response)
                {
                    // $('.orderdetailload').css("display", "none");
                    $('#orderreceipt').modal('show');
                    $('#ordermodal').html(response.orders);
                }
            });

    });

    function filter(val,method){
        if(method == 'type')
        {
        var type =val;
        var orderpayment =$("#orderpayment :selected").val();
        var status =$("#status :selected").val();
        }
        else if(method == 'orderpayment')
        {
        var type =$("#type :selected").val();
        var orderpayment = val;
        var status =$("#status :selected").val();
        }
        else if(method == 'status')
        {
        var type =$("#type :selected").val();
        var orderpayment =$("#orderpayment :selected").val();
        var status =val;
        }

        $.ajax({
            type: "post",
            url: "{{route('orderfilterdetail')}}",
            data: {
                "type" : type,
                "orderpayment" : orderpayment ,
                "status" : status,
            },
            dataType: "json",
            success: function (response) {
                $('#table').html('');
                $('#table').html(response.tabledata);
            }
        });

    }
    $('.table').DataTable();
</script>
{{-- End Script Section --}}
