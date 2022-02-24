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
            <form action="{{ route('categoryupdate') }}" id="catform" method="POST" enctype="multipart/form-data">
                {{ @csrf_field() }}
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab"
                                aria-controls="genral" aria-selected="true">Genral</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="data-tab" data-toggle="tab" href="#data" role="tab"
                                aria-controls="data" aria-selected="false">Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"
                                aria-controls="seo" aria-selected="false">SEO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="design-tab" data-toggle="tab" href="#design" role="tab"
                                aria-controls="design" aria-selected="false">Design</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="myTabContent">

                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english"
                                        role="tab" aria-controls="english" aria-selected="true"><img
                                            src="{{ asset('public/admin/image/en-gb.png') }}"> English</a>
                                </li>
                            </ul>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category Name</label>
                                <input type="text" name="category" class="form-control" id="category" placeholder="Category Name" value="{{ $data->name }}">
                                <input type="hidden" name="id" class="form-control" id="id" value="{{ $data->category_id }}">
                                @if ($errors->has('category'))
                                    <div style="color: red">{{ $errors->first('category') }}.</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="summernote" class="form-label">Description</label>
                                <textarea class="form-control" placeholder="Leave a comment here" name="description"
                                    id="summernote" style="height: 200px">{{ $data->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="matatitle" class="form-label">Meta Tag Title</label>
                                <input type="text" class="form-control" name="matatitle" id="matatitle"
                                    placeholder="Mata Tag Title" value="{{ $data->meta_title }}">
                                @if ($errors->has('matatitle'))
                                    <div style="color: red">{{ $errors->first('matatitle') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="metadesc" class="form-label">Meta Tag Description</label>
                                <textarea class="form-control" placeholder="Meta Tag Description" name="metadesc"
                                    id="metadesc" style="height: 100px">{{ $data->meta_description }}</textarea>
                                <label for="metadesc"></label>
                            </div>
                            <div class="mb-3">
                                <label for="metakey" class="form-label">Meta Tag Keywords</label>
                                <textarea class="form-control" placeholder="Meta Tag Keywords" name="metakey"
                                    id="metadesc" style="height: 100px">{{ $data->meta_keyword }}</textarea>
                                <label for="metakey"></label>

                            </div>
                        </div>

                        {{-- data --}}
                        <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">

                            <div class="mb-3">
                                <label for="parent">Parent</label>
                                <select class="form-control" name="parent" id="parent">
                                    <option value="{{ $data->parent_id }}" selected>Choose</option>

                                    @foreach ($fetchparent as $data)
                                        @if (!empty($data->cat_name))
                                            <option value="{{ $data->category_id }}">
                                                {{ $data->cat_name }}
                                            </option>
                                        @endif
                                        @php
                                            $subcat = get_subcat($data->category_id);
                                        @endphp

                                        @if (!empty($subcat))
                                            @foreach ($subcat as $scat)
                                                <option value="{{ $scat->category_id }}">
                                                    {{ $data->cat_name }} > {{ $scat->cat_name }}
                                                </option>

                                                @php
                                                    $dsubcat = depend_subcat($scat->category_id);
                                                @endphp

                                                @if (!empty($dsubcat))
                                                    @foreach ($dsubcat as $dcat)
                                                        <option value="{{ $dcat->category_id }}">
                                                            {{ $data->cat_name }} > {{ $scat->cat_name }} > {{ $dcat->cat_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="filters" class="form-label">Filters</label>
                                <input class="form-control" placeholder="Filters" name="filters" id="filters"></input>
                                <div id="category-filter" class="well bg-white mt-1 well-sm"
                                    style="height: 150px; overflow: auto;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="filters" class="form-label">Store</label>
                                <div class="well well-sm bg-white" style="height: 150px; overflow: auto;">
                                    <div class="checkbox p-3">
                                        <label>
                                            <input type="checkbox" name="category_store[]" value="0" checked="checked">
                                            Default
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" style="padding:3px;" id="image" class="form-control">
                                {{-- <img src="{{asset('/public/admin/image/'.$data->image)}}" width="100px"> --}}
                            </div>
                            <div class="mb-3">
                                <label for="top" class="form-label">Top</label><br>
                                <input type="checkbox" class="ml-3" id="top" name="top" value="1" {{ ($data->top == '1')? 'checked' : "" }}>
                            </div>
                            <div class="mb-3">
                                <label for="columns" class="form-label">Columns</label>
                                <input type="text" class="form-control" name="columns" id="columns" value="{{ $data->column }}">
                            </div>
                            <div class="mb-3">
                                <label for="sortorder" class="form-label">Sort Order</label>
                                <input type="text" class="form-control" name="sortorder" id="sortorder" value="{{ $data->sort_order }}">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="custom-select" name="status" id="status">
                                    <option selected value="1" {{ ($data->status == '1')? 'selected' : "" }}>Enable</option>
                                    <option value="2" {{ ($data->status == '2')? 'selected' : "" }}>Desable</option>
                                </select>
                            </div>
                        </div>

                        {{-- SEO --}}
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Stores</td>
                                            <td class="text-left">Keyword</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">Default</td>
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1"><img
                                                            src="{{ asset('public/admin/image/en-gb.png') }}"></span>
                                                    <input type="text" name="keyword" placeholder="Keyword"
                                                        class="form-control">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        {{-- design --}}
                        <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Stores</td>
                                            <td class="text-left">Layout Override</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">Default</td>
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <select type="select" name="categor" value="" placeholder=""
                                                        class="form-control">
                                                        <option value=""></option>
                                                        @foreach ($category_layout as $item)
                                                            <option value="{{ $item->layout_id }}">
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')


