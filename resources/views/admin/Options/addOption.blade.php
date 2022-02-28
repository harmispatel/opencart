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
                        <h1>Options</h1>

                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('option') }}">Options
                            </li>
                            </a>
                            {{-- <li class="breadcrumb-item active">All</li> --}}
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('addOption') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                       Add Options
                    </h3>

                </div>
                {{-- </section>
        {{-- End Header Section --}}

                {{-- List Section Start --}}
                {{-- <section class="content"> --}}
                <form action="{{ route('addOption') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                   <div><h3>Option</h3></div>
                    <div class="mb-3">
                        <label for="option" class="form-label">Option Name</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><img
                                    src="{{ asset('public/admin/image/en-gb.png') }}"></span>
                            <input type="text" name="option" placeholder="Option Name"
                                class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="Type" class="form-label">Type</label>
                        <select name="option" id="type" class="form-control">
                            @foreach ($option as $options )
                            <option value="{{ $options->name }}">{{ $options->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sortorder" class="form-label">Sort Order</label>
                        <input type="text" name="sort_order" class="form-control" id="sortorder"
                            placeholder="Sort Order">
                    </div>

                    <h3>Option Values</h3>

                    <div class="table-responsive">
                        <table id="option" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        Option Value Name</th>
                                        <th>Image</th>
                                    <th class="text-right">Sort Order</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><button type="button" onclick="addoption();"
                                            data-toggle="tooltip" title="option" class="btn btn-primary"><i
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
