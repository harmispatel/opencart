@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Filters --}}
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
                            <li class="breadcrumb-item active">Edit</li>
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
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('updatefilter') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{-- Card Body --}}

                                <input type="hidden" name="filter_group_id" value="{{ $filter->filter_group_id }}">



                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="filter" class="form-label">Filter Group Name</label>
                                        <input type="text" name="filter" class="form-control" id="filter"
                                            placeholder="Filter Group Name"
                                            value="{{ $filtergroupdescription->name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="sortorder" class="form-label">Sort Order</label>
                                        <input type="text" name="sort_order" class="form-control" id="sortorder"
                                            placeholder="Sort Order" value="{{ $filter->sort_order }}">
                                    </div>

                                    <div class="form-group">
                                        <h3>Filter Values</h3>
                                        <div class="table-responsive">
                                            {{-- Table --}}
                                            <table id="filter" class="table table-striped table-bordered table-hover">
                                                {{-- Table Head --}}
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Filter Name</th>
                                                        <th class="text-right">Sort Order</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                {{-- End Table Head --}}

                                                {{-- Table Body --}}
                                                <tbody>
                                                    @foreach ($filters as $key => $value)
                                                        <tr id="id=filter-row{{ $key }}">
                                                            <input type="hidden" name="filter_id[]"
                                                                value="{{ $value->filter_id }}">
                                                            <td><input type="text" name="mulfilter[]"
                                                                    class="form-control" placeholder="filter Name"
                                                                    required value="{{ $value->name }}"></td>
                                                            <td class="left"><input type="test"
                                                                    name="mulsort_order[]" class="form-control"
                                                                    value="{{ $value->sort_order }}"
                                                                    placeholder="Sort Order"></td>
                                                            <td class="text-right"><button type="button"
                                                                    onclick="$('#filter-row{{ $key }}').remove();"
                                                                    data-toggle="tooltip" title="Remove"
                                                                    class="btn btn-danger"><i
                                                                        class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                {{-- End Table Body --}}

                                                {{-- Table Footer --}}
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td class="text-right">
                                                            <button type="button" onclick="addfilter();"
                                                                data-toggle="tooltip" title="filter"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-plus-circle"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                {{-- End Table Footer --}}
                                            </table>
                                            {{-- End Table --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- End Card Body --}}

                                {{-- Card Footer --}}
                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                    <a href="{{ route('filter') }}" class="btn btn-sm btn-danger"> <i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>
                                {{-- End Card Footer --}}
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
