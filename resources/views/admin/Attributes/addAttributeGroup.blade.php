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
                        <h1>Attribute Groups</h1>
                        
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('attributegroup') }}">Attribute Groups
                                    </li>
                            </a>
                            {{-- <li class="breadcrumb-item active">All</li> --}}
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('addRecurring') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Add Attribute Groups
                    </h3>

                </div>
                </section>
        {{-- End Header Section --}}

                {{-- List Section Start --}}
                {{-- <section class="content"> --}}
                <form action="{{ route('addAttributeGroup') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="attributeGroup" class="form-label">Attribute Group Name</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><img
                                    src="{{ asset('public/admin/image/en-gb.png') }}"></span>
                            <input type="text" name="attributeGroup" placeholder="Attribute Group Name"
                                class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sortorder" class="form-label">Sort Order</label>
                        <input type="text" name="sortorder" class="form-control" id="sortorder" 
                            placeholder="Sort Order">
                    </div>
                </form>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
