@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Category</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('category') }}">Category List </li>
                            </a>
                            <li class="breadcrumb-item active">All</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex p-2" style="background: #f6f6f6">
                    <h3 class="card-title pt-2 m-0" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Add Category
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('category') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (count($errors) > 0)
                @if ($errors->any())
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ $errors->first() }}
                    </div>
                @endif
            @endif
            <form action="{{ route('categoryinsert') }}" id="catform" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category Name</label>
                        <input type="text" name="category" class="form-control" id="category"
                            placeholder="Category Name">
                        @if ($errors->has('category'))
                            <div style="color: red">{{ $errors->first('category') }}.</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="days" class="form-label">Select the days available:</label>
                        <div class="form-check form-check-inline pl-2">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox1">Sun</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="2" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox2">Mon</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="3" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox3">Tue</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="4" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox4">Wed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="5" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox5">Thu</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="6" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox6">Fri</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="7" name="availibleday[]" checked>
                            <label class="form-check-label" for="inlineCheckbox7">Sat</label>
                        </div>
                        @if ($errors->has('days'))
                            <div style="color: red">{{ $errors->first('days') }}.</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="summernote" class="form-label">Description</label>
                        <textarea class="form-control" placeholder="Leave a comment here" name="description"
                            id="description" style="height: 100px"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image">Image</label>
                        <input type="file" name="image" style="padding:3px;" id="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="banner">Banner</label>
                        <input type="file" name="banner" style="padding:3px;" id="banner" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="sortorder" class="form-label">Sort Order</label>
                        <input type="text" class="form-control" name="sortorder" id="sortorder" value="0">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="slug" id="slug" value="0">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="description" id="description" value="">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="metakey" id="metakey" value="">
                    </div>
                </div>
            </form>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
