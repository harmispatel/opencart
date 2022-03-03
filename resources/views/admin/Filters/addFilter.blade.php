@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Manufacturers --}}
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
                            <li class="breadcrumb-item"><a href="{{ route('filter') }}">Filters
                                    </a></li>
                            <li class="breadcrumb-item active">AddFilters</li>
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
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    Add Filters
                                </h3>

                                <div class="container" style="text-align: right">
                                    <button type="submit" form="manuForm" class="btn btn-sm btn-primary" onclick="errorMessage()"><i
                                            class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('download') }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('addFilter') }}" id="manuForm" method="POST"
                                enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="tab-content pt-4" id="myTabContent">
                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel"
                                            aria-labelledby="genral-tab">
                                            <h3>Filter Group</h3>
                                            <div class="mb-3">
                                                <label for="filter" class="form-label">Filter Group Name</label>
                                                {{-- <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1"><img
                                                            src="{{ asset('public/admin/image/en-gb.png') }}"></span>
                                                    <input type="text" name="filter" placeholder="Filter Group Name"
                                                        class="form-control">
                                                        @error('filter')
                                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                    @enderror --}}
                                                    
                                                    <input type="text" name="filter" class="form-control" id="filter"
                                                    placeholder="Filter Group Name">
                                                    @error('filter')
                                                    <div class="alert alert-danger mt-1 mb-1">Filter Group Name must be between 1 and 64 characters!</div>
                                                    @enderror
                                                </div>
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
                                            
                                        </div>
                                        {{-- End Genral Tab --}}
                                    </div>
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- Form End --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Manufacturers --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

