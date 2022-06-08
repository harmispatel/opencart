@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    {{-- <section class="content">
      <div class="container-fluid">
        @if (Session::has('success'))
        <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
       @endif

       @if (Session::has('error'))
        <div class="alert alert-danger del-alert alert-dismissible" id="alert" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
       @endif
        <!-- Small boxes (Stat box) -->
        <div class="row">

            <!-- col start -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ (isset($customers)) ? $customers : 0 }}</h3>
                    <p>Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('customers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- col start -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ (isset($categories)) ? $categories : 0 }}</h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="{{ route('category') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- col start -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ (isset($orders)) ? $orders : 0 }}</h3>
                    <p>Orders</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{{ route('orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

          <!-- col start -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ (isset($product)) ? $product : 0 }}</h3>
                <p>Product</p>
              </div>
              <div class="icon">
                <i class="fab fa-product-hunt"></i>
              </div>
              <a href="{{ route('products') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section> --}}
    <!-- /.content -->

    <!--new dashboard-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- Card Start --}}
                    <div class="card">
                        <div class="dash-main">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="dash-inr-right">
                                        <div class="dash-inr-title">
                                            <h4>STORE SALES REPORTS</h4>
                                            <img src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" width="15" style="display: none;" id="sales-loader">
                                            <select name="" id="range" onchange="getSalesReport(this.value)">
                                                <option value="day">Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="week" selected>This Week</option>
                                                <option value="month">This Month</option>
                                                <option value="year">This Year</option>
                                                <option value="lastweek">Last Week</option>
                                                <option value="lastmonth">Last Month</option>
                                                <option value="lastyear">Last Year</option>
                                                <option value="alltime">All Time</option>
                                            </select>
                                        </div>
                                        <div id="sales-reprt" style="height: 300px;
                                        overflow-y: scroll;">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="dash-inr-left">
                                        <div class="dash-inr-title">
                                            <h4>GENERAL TOTAL</h4>
                                            <img src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" width="15" style="display: none;" id="genral-loader">
                                            <select name="gen-total" id="gen-total" onchange="getGeneralTotal(this.value)">
                                                <option value="day">Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="week" selected>This Week</option>
                                                <option value="month">This Month</option>
                                                <option value="year">This Year</option>
                                                <option value="lastweek">Last Week</option>
                                                <option value="lastmonth">Last Month</option>
                                                <option value="lastyear">Last Year</option>
                                                <option value="alltime">All Time</option>
                                            </select>
                                        </div>
                                        <div class="dash-sales" id="gen-total-reprt">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Card --}}
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- Card Start --}}
                    <div class="card">
                        <div class="dash-main">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dash-inr-left">
                                        <div class="dash-inr-title">
                                            <h4>TOP 10 CUSTOMER'S</h4>
                                            <img src="{{ get_css_url().'public/admin/gif/gif4.gif' }}" width="15" style="display: none;" id="top10-loader">
                                            <select name="top10" id="top10" onchange="getTopTen(this.value)">
                                                <option value="day">Today</option>
                                                <option value="yesterday">Yesterday</option>
                                                <option value="week" selected>This Week</option>
                                                <option value="month">This Month</option>
                                                <option value="year">This Year</option>
                                                <option value="lastweek">Last Week</option>
                                                <option value="lastmonth">Last Month</option>
                                                <option value="lastyear">Last Year</option>
                                                <option value="alltime">All Time</option>
                                            </select>
                                        </div>
                                        <div id="top-ten-cus" style="height: 300px;
                                        overflow-y: scroll;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Card --}}
                </div>
            </div>
        </div>
    </section>
    <!-- end new dasboard-->

    <hr>

    <!-- Categories Section Start -->
    {{-- <section class="content">
        <div class="container mt-5">
          <div class="row mt-2">
            {{-- @foreach ($categories as $category)
            <div class="col-lg-3 col-6 pb-3">
              <div class="card h-100">
                <div class="card-body">
                    <img src="{{ asset('Images/CategoryImages/'.$category->image) }}" alt="Not-Found" class="w-100 h-100">
                </div>
                <div class="card-footer text-center pt-1 pb-1">
                  <h5><a href="{{ route('listByCat',$category->id) }}">{{ $category->name }}</a></h5>
                </div>
              </div>
            </div>
            @endforeach --}}
</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- {{ $categories->links() }} --}}
        </div>
    </div>
</div>
</section> --}}

<!-- End Categories Section -->

</div>
<!-- /.content-wrapper -->

@include('footer')

<script type="text/javascript">

    // Document Ready
    $('document').ready(function()
    {
        // Get Top Sales
        var range = $('#range :selected').val();
        $("#sales-reprt").html('');
        $('#range').attr("disabled",true);

        $.ajax({
            type: "post",
            url: "{{ route('getSalesReport') }}",
            data: {
                SalesReport : range,
            },
            beforeSend: function() {
                $('#sales-loader').show();
            },
            dataType: "json",
            success: function(response)
            {
                if(response.success == 1)
                {
                    $('#sales-loader').hide();
                    $("#sales-reprt").html('');
                    $('#range').removeAttr("disabled");
                    $("#sales-reprt").append(response.html);
                }
            }
        });
        // End Get Top Sales

        // Get Top Customer
        var cust_range = $('#range :selected').val();
        $("#top-ten-cus").html('');
        $('#top10').attr("disabled",true);

        $.ajax({
            type: "post",
            url: "{{ route('getTopTenCustomer') }}",
            data: {
                'range' : cust_range,
            },
            beforeSend: function() {
                $('#top10-loader').show();
            },
            dataType: "json",
            success: function(response)
            {
                $("#top-ten-cus").html('');
                $('#top10').removeAttr("disabled");
                $('#top10-loader').hide();
                $("#top-ten-cus").append(response.html);
            }
        });
        // End Get Top Customer

        // General
        var general_range = $('#range :selected').val();
        $("#gen-total-reprt").html('');
        $('#gen-total').attr("disabled",true);

        $.ajax({
            type: "post",
            url: "{{ route('getGeneralTotal') }}",
            data: {
                'range' : general_range,
            },
            beforeSend: function() {
                $('#genral-loader').show();
            },
            dataType: "json",
            success: function(response)
            {
                $("#gen-total-reprt").html('');
                $('#gen-total').removeAttr("disabled");
                $('#genral-loader').hide();
                $("#gen-total-reprt").append(response.html);
            }
        });
        // End General

    });
    // End Document Ready


    // Get Sales Report
    function getSalesReport(range)
    {
        $("#sales-reprt").html('');
        $('#range').attr("disabled",true);

        $.ajax({
            type: "post",
            url: "{{ route('getSalesReport') }}",
            data: {
                SalesReport : range,
            },
            beforeSend: function() {
                $('#sales-loader').show();
            },
            dataType: "json",
            success: function(response)
            {
                if(response.success == 1)
                {
                    $("#sales-reprt").html('');
                    $('#sales-loader').hide();
                    $('#range').removeAttr("disabled");
                    $("#sales-reprt").append(response.html);
                }
            }
        });
    }
    // End Get Sales Report

    // Get Top 10
    function getTopTen(range)
    {
        $("#top-ten-cus").html('');
        $('#top10').attr("disabled",true);

        $.ajax({
            type: "post",
            url: "{{ route('getTopTenCustomer') }}",
            data: {
                'range' : range,
            },
            beforeSend: function() {
                $('#top10-loader').show();
            },
            dataType: "json",
            success: function(response)
            {
                $("#top-ten-cus").html('');
                $('#top10').removeAttr("disabled");
                $('#top10-loader').hide();
                $("#top-ten-cus").append(response.html);
            }
        });
    }
    // End Get Top 10

    // Get General Total
    function getGeneralTotal(range)
    {
        $("#gen-total-reprt").html('');
        $('#gen-total').attr("disabled",true);

        $.ajax({
            type: "post",
            url: "{{ route('getGeneralTotal') }}",
            data: {
                'range' : range,
            },
            beforeSend: function() {
                $('#genral-loader').show();
            },
            dataType: "json",
            success: function(response)
            {
                $("#gen-total-reprt").html('');
                $('#gen-total').removeAttr("disabled");
                $('#genral-loader').hide();
                $("#gen-total-reprt").append(response.html);
            }
        });
    }
    // End Get General Total

</script>
