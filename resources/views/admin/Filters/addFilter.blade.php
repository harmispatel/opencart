@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('filter') }}">Filters
                            </li>
                            </a>
                            {{-- <li class="breadcrumb-item active">All</li> --}}
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('addFilter') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Filters
                    </h3>

                </div>
                {{-- </section>
        {{-- End Header Section --}}

                {{-- List Section Start --}}
                {{-- <section class="content"> --}}
                <form action="{{ route('addFilter') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h3>Filter Group</h3>
                    <div class="mb-3">
                        <label for="filter" class="form-label">Filter Group Name</label>
                        {{-- <img src="{{ asset('public/admin/image/en-gb.png') }}" width="10px"> --}}
                        <input type="text" name="filter" class="form-control" id="filter"
                            placeholder="Filter Group Name">
                    </div>

                    <div class="mb-3">
                        <label for="sortorder" class="form-label">Sort Order</label>
                        <input type="text" name="sort_order" class="form-control" id="sortorder"
                            placeholder="Sort Order">
                    </div>

                    <h3>Filter Values</h3>

                    {{-- <div class="tab-pane fade" id="filter" role="tabpanel" aria-labelledby="filter-tab">
                        <div class="tab-pane" id="tab-filter"> --}}
                    <div class="table-responsive">
                        <table id="filter" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        Filter Name</th>
                                    <th class="text-right">Sort Order</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="text-right"><button type="button" onclick="addfilter();"
                                            data-toggle="tooltip" title="filter" class="btn btn-primary"><i
                                                class="fa fa-plus-circle"></i></button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
