@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Filters</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('filter') }}">Filters</a></li>
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
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list"></i>
                                    Filters
                                </h3>

                                <div class="container" style="text-align: right">
                                    @if(check_user_role(67) == 1)
                                        <a href="addFilter" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                    @endif

                                    @if(check_user_role(69) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>

                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <table class="table">
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert" style="display: none" role="alert">
                                            <p id="success-message" class="mb-0"></p>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                        </div>
                                        <thead class="text-center">
                                            <th><input type="checkbox" name="checkall" id="delall"></th>
                                            <th>Filter Group</th>
                                            <th>Sort Order</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody class="text-center cat-list">
                                            <tr>
                                                <td><input type="checkbox" name="checkall" class="del_all"></td>
                                                <td>name</td>
                                                <td>Sort Order</td>
                                                <td>
                                                    @if(check_user_role(68) == 1)
                                                        <a href="#" class="btn btn-sm btn-primary rounded"><i class="fa fa-edit"></i></a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
@include('footer')
<script>
   $(document).ready( function () {
    $('.table').DataTable();
} );
</script>


