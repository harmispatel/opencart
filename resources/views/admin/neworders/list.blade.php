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
        justify-content: space-between;
    }

    .calender_tabs ul li {
        padding: 5px 10px;
        color: #000;
        background-color: #fff;
        border-radius: 10px;
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
    $orderdetails = getorderdetails($range);
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

{{-- <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div> --}}

        {{-- modal open --}}
        {{-- <div class="modal fade" id="orderreceipt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="orderreceiptLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-3" id="ordermodal">
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- modal colose --}}
        {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #424e64">


                                <div class="div">
                                    <div class="row">
                                        <div class="col-md-8">
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
                                            {{-- <div class="btn-group btn-group-toggle" dat-toggle="buttons">
                                                <button class="btn btn-primary btn-sm" autocomplete="off">DAILY</button>
                                                <button class="btn btn-primary btn-sm" autocomplete="off" style="border-left:1px solid white">WEEKLY</button>
                                                <button class="btn btn-primary btn-sm" autocomplete="off" style="border-left:1px solid white">MONTHLY</button>
                                                <button class="btn btn-primary btn-sm" autocomplete="off" style="border-left:1px solid white">YEARLY</button>
                                            </div> --}}
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container" style="text-align: right">
                                                <input type="text" name="daterange" value="" />
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

                                        <div class="row" id="card-stats">

                                            {{-- Card 1 --}}
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-light">
                                                    <div class="inner">
                                                        <div class="d-flex justify-content-between box-title">
                                                            <h3 style="color: #2c9ea9">
                                                                £{{ number_format(isset($orderdetails['total']) ? $orderdetails['total'] : 0, 2) }}</h3>
                                                            <i class="fa fa-chart-area"></i>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">Delivery:
                                                                    £{{ number_format(isset($orderdetails['delivery_total']) ? $orderdetails['delivery_total'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Cash Order: £ {{ number_format(isset($orderdetails['total']) ? $orderdetails['total'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Collection: £
                                                                    {{ number_format(isset($orderdetails['collection_total']) ? $orderdetails['collection_total'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Card Order: £0.00
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="icon" style="color: #2c9ea9">
                                                        <i class="ion ion-bag"></i>
                                                    </div> --}}
                                                    <div class="small-box-footer" style="background: #2c9ea9">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                Total Sales
                                                            </div>
                                                            <div class="col-md-6">
                                                                <i class="fa fa-arrow-circle-up"></i> 0.00%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Card 1 --}}

                                            {{-- Card 2 --}}
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-light">
                                                    <div class="inner">
                                                        <div class="d-flex justify-content-between box-title">
                                                            <h3 style="color: #2c9ea9">
                                                                {{ number_format(isset($orderdetails['accepted_order']) ? $orderdetails['accepted_order'] : 0, 0) }}</h3>
                                                            <i class="fa fa-shopping-basket "></i>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Delivery:
                                                                    £{{ number_format(isset($orderdetails['delivery_count']) ? $orderdetails['delivery_count'] : 0, 0) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Cash Order:
                                                                    £{{ number_format(isset($orderdetails['accepted_order']) ? $orderdetails['accepted_order'] : 0, 0) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Collection:
                                                                    £{{ number_format(isset($orderdetails['collection_count']) ? $orderdetails['collection_count'] :0, 0) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    Card Order: £0.00
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="icon" style="color: #2c9ea9">
                                                        <i class="ion ion-bag"></i>
                                                    </div> --}}
                                                    <div class="small-box-footer" style="background: #2c9ea9">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                Number of Sales
                                                            </div>
                                                            <div class="col-md-6">
                                                                <i class="fa fa-arrow-circle-up"></i> 0.00%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Card 2 --}}

                                            {{-- Card 3 --}}
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-light">
                                                    <div class="inner">
                                                        <div class="d-flex justify-content-between box-title">
                                                            <h3 style="color: #2c9ea9">0.00</h3>
                                                            <i class="fa fa-tags"></i>
                                                        </div>
                                                        <div class="col-md-6">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="icon" style="color: #2c9ea9">
                                                        <i class="ion ion-bag"></i>
                                                    </div> --}}
                                                    <div class="small-box-footer" style="background: #2c9ea9">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                Number of Sold Items
                                                            </div>
                                                            <div class="col-md-6">
                                                                <i class="fa fa-arrow-circle-up"></i> 0.00%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Card 3 --}}

                                            {{-- Card 4 --}}
                                            <div class="col-lg-3 col-6">
                                                <!-- small box -->
                                                <div class="small-box bg-light">
                                                    <div class="inner">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    customer: £{{ number_format(isset($orderdetails['C_total']) ? $orderdetails['C_total'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    No of orders:
                                                                    £{{ number_format(isset($orderdetails['C_count']) ? $orderdetails['C_count'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    guest user:
                                                                    £{{ number_format(isset($orderdetails['G_total']) ? $orderdetails['G_total'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p style="font-size: 12px; margin: 0">
                                                                    No of orders:
                                                                    £{{ number_format(isset($orderdetails['G_count']) ? $orderdetails['G_count'] : 0, 2) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="icon" style="color: #2c9ea9">
                                                        <i class="ion ion-bag"></i>
                                                    </div> --}}
                                                    <div class="small-box-footer" style="background: #2c9ea9">
                                                        <div class="row">
                                                            <div class="col-md-6">Top {{ isset($orderdetails['C_count']) ? $orderdetails['C_count'] : 0 }} Customer.
                                                            </div>
                                                            <div class="col-md-6">
                                                                <i class="fa fa-arrow-circle-up"></i> 0.00%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Card 4 --}}

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
                                        <table class="table table-striped" border="1">
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
                                                @foreach ($orderdetails['query'] as $value)
                                                @php

                                                    $edit_url = route('vieworder', $value['order_id']);
                                                @endphp
                                                    <tr>
                                                        <td><input type="checkbox" name="checkall" class="delall"
                                                                value="{{ $value['order_id'] }}"></td>
                                                        @if ($value['shipping_method'] == 'collection')
                                                            <td><i class="fa fa-shopping-basket"></i></td>
                                                        @else
                                                            <td><i class="fa fa-motorcycle"></i></td>
                                                        @endif
                                                        <td>{{ $value['order_id'] }}</td>
                                                        <td>{{ $value['store_name'] }}</td>
                                                        <td>{{ $value['firstname'] }}</td>
                                                        <td>{{ number_format($value['total'], 2) }}</td>
                                                        <td>{{ $value['date_added'] }}</td>
                                                        @if ($value['order_status_id'] == 15)
                                                            <td><i class="fa fa-check-circle" title="Accepted"
                                                                    style="color:#14bd07;"></td>
                                                        @elseif ($value['order_status_id'] == 5)
                                                            <td><i class="fa fa-thumbs-up" title="Complete"
                                                                    style="color:#51a351;"></i></td>
                                                        @elseif ($value['order_status_id'] == 2)
                                                            <td><i class="fa fa-loader" title="Complete"
                                                                    style="color:#51a351;"></i></td>
                                                        @elseif ($value['order_status_id'] == 7)
                                                            <td><i class="fa fa-times-circle" title="Complete"
                                                                    style="color:red;"></i></td>
                                                        @elseif ($value['order_status_id'] == 11)
                                                            <td><i class="fa fa-check" title="Complete"
                                                                    style="color:#51a351;"></i></td>
                                                        @elseif ($value['order_status_id'] == 1)
                                                            <td><i class="fa fa-fa fa-search" title="Complete"
                                                                    style="color:#51a351;"></i></td>
                                                        @endif
                                                        <td><button class="orderdetail" value="{{ $value['order_id'] }}"><i class="fa fa-print"></i></button></td>
                                                        <td><i class="fa fa-mobile"></i></td>
                                                        <td><a href="{{$edit_url}}" style="color: #000000"><i class="fa fa-reply"></i></a></td>
                                                    </tr>
                                                @endforeach
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

    function calender_tabs(values) {

        $.ajax({
            type: "post",
            url: "{{ route('getallorderdetails') }}",
            data: {
                values: values,
            },
            dataType: "json",
            success: function(response) {

                var table ='';
                $('#card-stats').html('');
                $('#card-stats').html(response.html);

                $.each(response.tabledata, function (index, val) {
                    table +='<tr>';
                    table +='<td><input type="checkbox" name="checkall" class="delall" value='+val.order_id+'></td>';
                    if (val.shipping_method == 'collection'){
                        table +='<td><i class="fa fa-shopping-basket"></i></td>';
                    }else{
                        table +='<td><i class="fa fa-motorcycle"></i></td>';
                    }
                    table +='<td>'+ val.order_id +'</td>';
                    table +='<td>'+ val.store_name +'</td>';
                    table +='<td>'+ val.firstname +'</td>';
                    table +='<td>'+ val.total+ '</td>';
                    table +='<td>'+ val.date_added +'</td>';
                    if(val.order_status_id == 15){
                        table +='<td><i class="fa fa-check-circle" title="Accepted" style="color:#14bd07;"></td>';
                    }else if (val.order_status_id == 5) {
                        table +='<td><i class="fa fa-thumbs-up" title="Complete" style="color:#51a351;"></i></td>';
                    }else if (val.order_status_id == 2) {
                        table +='<td><i class="fa fa-loader" title="Complete" style="color:#51a351;"></i></td>';
                    }else if (val.order_status_id == 7) {
                        table +='<td><i class="fa fa-times-circle" title="Complete" style="color:red;"></i></td>';
                    }else if (val.order_status_id == 11) {
                        table +='<td><i class="fa fa-check" title="Complete" style="color:#51a351;"></i></td>';
                    }else if (val.order_status_id == 1) {
                        table +='<td><i class="fa fa-fa fa-search" title="Complete" style="color:#51a351;"></i></td>';
                    }
                    table +='<td><i class="fa fa-print"></i></td>';
                    table +='<td><i class="fa fa-mobile"></i></td>';
                    table +='<td><i class="fa fa-reply"></td>';
                    table +='</tr>';
                });

                $('.tbody').html('');
                $('.tbody').html(table);
            }
        });
    }

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
