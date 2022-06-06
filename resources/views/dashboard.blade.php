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
                                            <select name="" id="getSalesReport">
                                                <option value="day">Today</option>
                                                <option value="Yesterday">Yesterday</option>
                                                <option value="This Week" selected>This Week</option>
                                                <option value="month">This Month</option>
                                                <option value="year">This Year</option>
                                                <option value="lastweek">Last Week</option>
                                                <option value="lastmonth">Last Month</option>
                                                <option value="lastyear">Last Year</option>
                                                <option value="alltime">All Time</option>
                                            </select>
                                        </div>
                                        <div class="dash-sales">
                                            <h5> A Dev - A.K. Spices </h5>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Total Sales</td>
                                                        <td>£9.10</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Orders</td>
                                                        <td>2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Cash Order Amount</td>
                                                        <td>£9.10</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total Card Order Amount</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. of Customers</td>
                                                        <td>1</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="dash-inr-left">
                                        <div class="dash-inr-title">
                                            <h4>GENERAL TOTAL</h4>
                                            <select name="" id="">
                                                <option value="day">Today</option>
                                                <option value="Yesterday">Yesterday</option>
                                                <option value="This Week" selected>This Week</option>
                                                <option value="month">This Month</option>
                                                <option value="year">This Year</option>
                                                <option value="lastweek">Last Week</option>
                                                <option value="lastmonth">Last Month</option>
                                                <option value="lastyear">Last Year</option>
                                                <option value="alltime">All Time</option>
                                            </select>
                                        </div>
                                        <div class="dash-sales">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Cash Total</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Paypal Total</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Worldpay Total</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>MFB Pay Total</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Card on Delivery</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="dash-sales">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Totals</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="dash-sales">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Rejected Orders</td>
                                                        <td>0</td>
                                                        <td>£0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                            <select name="" id="">
                                                <option value="day">Today</option>
                                                <option value="Yesterday">Yesterday</option>
                                                <option value="This Week" selected>This Week</option>
                                                <option value="month">This Month</option>
                                                <option value="year">This Year</option>
                                                <option value="lastweek">Last Week</option>
                                                <option value="lastmonth">Last Month</option>
                                                <option value="lastyear">Last Year</option>
                                                <option value="alltime">All Time</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <table class="table">
                                                <thead>
                                                    <th>Customer</th>
                                                    <th>Total Sales</th>
                                                    <th>Total Cash Order Amount </th>
                                                    <th>Total Card Order Amount </th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Guest User's </td>
                                                        <td>£7,388,280.45 </td>
                                                        <td>£2,912,965.22 </td>
                                                        <td>£4,475,315.23 </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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

<script>
   $('#getSalesReport').change(function (e) {
        e.preventDefault();
        var SalesReport = this.value;

        $.ajax({
            type: "post",
            url: "{{ route('getSalesReport') }}",
            data: {
                SalesReport :SalesReport,
            },
            success: function (response) {
                console.log(response);
            }
        });

    });
</script>
