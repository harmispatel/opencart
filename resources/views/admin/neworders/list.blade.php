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
                                            <div class="btn-group btn-group-toggle" dat-toggle="buttons">
                                                <button class="btn btn-primary btn-sm" autocomplete="off">DAILY</button>
                                                <button class="btn btn-primary btn-sm" autocomplete="off" style="border-left:1px solid white">WEEKLY</button>
                                                <button class="btn btn-primary btn-sm" autocomplete="off" style="border-left:1px solid white">MONTHLY</button>
                                                <button class="btn btn-primary btn-sm" autocomplete="off" style="border-left:1px solid white">YEARLY</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container" style="text-align: right">
                                                <input type="text" name="daterange" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="row">

                                        {{-- Card 1 --}}
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-light">
                                              <div class="inner">
                                                <h3 style="color: #2c9ea9">£0.00</h3>
                                                    <div class="col-md-6">
                                                        <p style="font-size: 12px; margin: 0">
                                                            Delivery: £0.00 <br>
                                                            Cash Order: £0.00 <br>
                                                            Collection: £0.00 <br>
                                                            Card Order: £0.00
                                                        </p>
                                                    </div>
                                              </div>
                                              <div class="icon" style="color: #2c9ea9">
                                                <i class="ion ion-bag"></i>
                                              </div>
                                              <div class="small-box-footer" style="background: #2c9ea9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Sales
                                                    </div>
                                                    <div class="col-md-6">
                                                        <i class="fa fa-arrow-circle-up"></i>  0.00%
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
                                                <h3 style="color: #2c9ea9">£0.00</h3>
                                                    <div class="col-md-6">
                                                        <p style="font-size: 12px; margin: 0">
                                                            Delivery: £0.00 <br>
                                                            Cash Order: £0.00 <br>
                                                            Collection: £0.00 <br>
                                                            Card Order: £0.00
                                                        </p>
                                                    </div>
                                              </div>
                                              <div class="icon" style="color: #2c9ea9">
                                                <i class="ion ion-bag"></i>
                                              </div>
                                              <div class="small-box-footer" style="background: #2c9ea9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Sales
                                                    </div>
                                                    <div class="col-md-6">
                                                        <i class="fa fa-arrow-circle-up"></i>  0.00%
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
                                                <h3 style="color: #2c9ea9">£0.00</h3>
                                                    <div class="col-md-6">
                                                        <p style="font-size: 12px; margin: 0">
                                                            Delivery: £0.00 <br>
                                                            Cash Order: £0.00 <br>
                                                            Collection: £0.00 <br>
                                                            Card Order: £0.00
                                                        </p>
                                                    </div>
                                              </div>
                                              <div class="icon" style="color: #2c9ea9">
                                                <i class="ion ion-bag"></i>
                                              </div>
                                              <div class="small-box-footer" style="background: #2c9ea9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Sales
                                                    </div>
                                                    <div class="col-md-6">
                                                        <i class="fa fa-arrow-circle-up"></i>  0.00%
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
                                                <h3 style="color: #2c9ea9">£0.00</h3>
                                                    <div class="col-md-6">
                                                        <p style="font-size: 12px; margin: 0">
                                                            Delivery: £0.00 <br>
                                                            Cash Order: £0.00 <br>
                                                            Collection: £0.00 <br>
                                                            Card Order: £0.00
                                                        </p>
                                                    </div>
                                              </div>
                                              <div class="icon" style="color: #2c9ea9">
                                                <i class="ion ion-bag"></i>
                                              </div>
                                              <div class="small-box-footer" style="background: #2c9ea9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        Total Sales
                                                    </div>
                                                    <div class="col-md-6">
                                                        <i class="fa fa-arrow-circle-up"></i>  0.00%
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          {{-- End Card 4 --}}

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            Comming Soon
                                        </div>
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
{{-- End Section of List Trasnsactions --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- Script Section --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

// $(document).ready(function() {
//     $('#transaction').DataTable();
// } );

// Date Range Picker
$(function() {
    $('input[name="daterange"]').daterangepicker();
});


</script>
{{-- End Script Section --}}
