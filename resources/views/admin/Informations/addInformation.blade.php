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
                        <h1>Information</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('addInformation') }}">Information</li>
                            </a>
                            {{-- <li class="breadcrumb-item active">All</li> --}}
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                       Add Information
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('addInformation') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <form action="" method="POST" enctype="multipart/form-data">
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
                {{-- Genreal --}}
                <div class="tab-content p-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab"
                                    aria-controls="english" aria-selected="true">English</a>
                            </li>
                        </ul>
                        <div class="mb-3">
                            <label for="information" class="form-label">Information Title</label>
                            <input type="text" class="form-control" id="information" placeholder="Information Title">
                        </div>
                        <div class="form-floating">
                            <label for="summernote" class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Leave a comment here" name="description"
                                id="summernote" style="height: 200px"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="matatitle" class="form-label">Meta Tag Title</label>
                            <input type="text" class="form-control" name="matatitle" id="matatitle"
                                placeholder="Mata Tag Title">
                        </div>
                        <div class="form-floating">
                            <label for="metadesc" class="form-label">Meta Tag Description</label>
                            <textarea class="form-control" placeholder="Meta Tag Description" name="metadesc"
                                id="metadesc" style="height: 100px"></textarea>
                            <label for="metadesc"></label>
                        </div>
                        <div class="form-floating">
                            <label for="metakey" class="form-label">Meta Tag Keywords</label>
                            <textarea class="form-control" placeholder="Meta Tag Keywords" name="metakey" id="metakey"
                                style="height: 100px"></textarea>
                            <label for="metakey"></label>
                        </div>
                        
                    </div>
                    {{-- end Genral --}}

                    {{-- start Data --}}
                    <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">

                        <div class="mb-3">
                            <label for="stores" class="form-label">Stores</label>
                             <input type="checkbox" name="stores">
                        </div>

                        <div class="mb-3">
                            <label for="bottom" class="form-label">Bottom</label>
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                             <input type="checkbox" name="bottom">
                        </div>

                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="text" class="form-control" id="sort_order" value="1">
                        </div>
                    </div>
                    {{-- end Data --}}

                    {{-- Start SEO --}}
                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> Do not use spaces, instead
                            replace spaces with - and make sure the SEO URL is globally unique.</div>
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
                        <div class="card-footer">
                        </div>
                    </div>
                    {{-- End SEO --}}

                    {{-- Start Design --}}
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
                                                    {{-- @foreach ($result['product_layout'] as $item)
                                                        <option value="{{ $item->name }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End Design --}}
            </form>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
