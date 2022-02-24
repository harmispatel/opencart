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
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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

       @if(Session::has('error'))
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
                    <h3>{{ (isset($users)) ? count($users) : 0 }}</h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-alt"></i>
                </div>
                <a href="{{ route('users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- col start -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>0</h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- col start -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-green">
                <div class="inner">
                    <h3>0</h3>
                    <p>Sub Categories</p>
                </div>
                <div class="icon">
                    <i class="fa fa-columns"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

          <!-- col start -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ (isset($products)) ? count($products) : 0 }}</h3>
                <p>Product</p>
              </div>
              <div class="icon">
                <i class="fab fa-product-hunt"></i>
              </div>
              <a href="{{ route('productlist') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <hr>

    <!-- Categories Section Start -->
    <section class="content">
        <div class="container mt-5">
          <div class="row mt-2">
            {{-- @foreach($categories as $category)
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
    </section>

    <!-- End Categories Section -->

  </div>
  <!-- /.content-wrapper -->

  @include('footer')
