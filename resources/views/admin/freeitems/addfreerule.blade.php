@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Reviews --}}
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
                        <h1>Cart rule</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Cart rule</li>
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
                                    Cart rule
                                </h3>

                                <div class="container" style="text-align: right">
                                    @if(check_user_role(71) == 1)
                                        <a href="{{ route('ordersinsert') }}"
                                            class="btn btn-sm btn-primary ml-auto px-1">save</a>
                                    @endif

                                    @if(check_user_role(73) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-auto px-1 deletesellected">Back</a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}

                                <form action="{{ url('cartruleinsert') }}" method="POST">
                                    <div class="form-group">
                                      <label for="name">* Name</label>
                                      <input type="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter email">
                                      @if ($errors->has('name'))
                                      <div style="color: red">{{ $errors->first('name') }}</div>
                                  @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="total_above">*Total Above</label>
                                        <div class="form-check">
                                            {{-- <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Check me out</label> --}}
                                        </div>
                                      </div>
                                    <div class="form-group">
                                      <label for="total_above">*Total Above</label>
                                      <input type="text" class="form-control" name="total_above" id="total_above" placeholder="Password">
                                      @if ($errors->has('total_above'))
                                      <div style="color: red">{{ $errors->first('total_above') }}</div>
                                  @endif
                                    </div>
                                  </form>

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
{{-- End Section of List Manufacturers --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}

