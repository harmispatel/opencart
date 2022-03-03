@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Information --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Informations</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('information') }}">Informations</a></li>
                            <li class="breadcrumb-item active">Add</li>
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
                                    <i class="fas fa-pencil-alt mr-2"></i>
                                    Add Information
                                </h3>
                                <div class="container" style="text-align: right">
                                    <button type="submit" form="manuForm" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('information') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('storeinformation') }}" id="manuForm" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab" aria-controls="genral" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false">Data</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="design-tab" data-toggle="tab" href="#design" role="tab" aria-controls="design" aria-selected="false">Design</a>
                                        </li>
                                    </ul>
                                    {{-- End Tabs Link --}}


                                    <div class="tab-content pt-4" id="myTabContent">

                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">

                                            <div class="form-group">
                                                <label for="infotitle" class="form-label">Information Title</label>
                                                <input type="text" name="infotitle" class="form-control {{ ($errors->has('infotitle')) ? 'is-invalid' : '' }}" id="infotitle">
                                                @if($errors->has('infotitle'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('infotitle') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control {{ ($errors->has('description')) ? 'is-invalid' : '' }}" name="description" id="summernote">{{ old('description') }}</textarea>
                                                @if($errors->has('description'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="metatitle" class="form-label">Meta Tag Title</label>
                                                <input type="text" name="metatitle" class="form-control {{ ($errors->has('metatitle')) ? 'is-invalid' : '' }}" id="metatitle" value="{{ old('metatitle') }}">
                                                @if($errors->has('metatitle'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('metatitle') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="metadescription" class="form-label">Meta Tag Description</label>
                                                <textarea class="form-control" name="metadescription" id="metadescription">{{  old('metadescription') }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="metakeyword" class="form-label">Meta Tag Keywords</label>
                                                <textarea class="form-control" name="metakeyword" id="metakeyword">{{ old('metakeyword')}}</textarea>
                                            </div>

                                        </div>
                                        {{-- End Genral Tab --}}


                                        {{-- Data Tab --}}
                                        <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">

                                            <div class="form-group">
                                                <label for="stores" class="form-label">Stores</label>
                                                <div class="form-control" style="background: #e3e3e3">
                                                    <input type="checkbox" name="default" id="default" value="1" checked>
                                                    <label for="default"> Default</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="bottom" class="form-label">Bottom</label>
                                                <div class="form-control" style="background: #e3e3e3">
                                                    <input type="checkbox" name="bottom" id="bottom" value="1">
                                                    <label for="yes"> Yes</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1" selected>Enabled</option>
                                                    <option value="0">Disabled</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="sortorder">Sort Order</label>
                                                <input type="number" name="sortorder" id="sortorder" class="form-control" value="{{ old('sortorder') }}">
                                            </div>

                                        </div>
                                        {{-- End Data Tab --}}


                                        {{-- SEO Tab --}}
                                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">

                                            {{-- Alert Info Message --}}
                                            <div class="alert" style="background: #d9edf7; padding:8px;"><i class="fa fa-info-circle"></i> Do not use spaces, instead replace spaces with - and make sure the SEO URL is globally unique.</div>
                                            {{-- End Alert Info Message --}}

                                            {{-- SEO Table --}}
                                            <table class="table table-bordered">
                                                {{-- Table Head --}}
                                                <thead>
                                                    <tr>
                                                        <th>Stores</th>
                                                        <th>Keyword</th>
                                                    </tr>
                                                </thead>
                                                {{-- End Table Head --}}

                                                {{-- Table body --}}
                                                <tbody>
                                                    <tr>
                                                        <td>Default</td>
                                                        <td>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <img src="{{ asset('public/admin/image/en-gb.png') }}">
                                                                    </span>
                                                                </div>
                                                                <input type="text" name="keyword" placeholder="Keyword" class="form-control" aria-describedby="basic-addon1" aria-label="Keyword" value="{{ old('keyword') }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                {{-- End Table body --}}
                                            </table>
                                            {{-- End SEO Table --}}
                                        </div>
                                        {{-- End SEO Tab --}}


                                        {{-- Design Tab --}}
                                        <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">

                                            {{-- Design Table --}}
                                            <table class="table table-bordered">
                                                {{-- Table Head --}}
                                                <thead>
                                                    <tr>
                                                        <th>Stores</th>
                                                        <th>Layout Override</th>
                                                    </tr>
                                                </thead>
                                                {{-- End Table Head --}}

                                                {{-- Table body --}}
                                                <tbody>
                                                    <tr>
                                                        <td>Default</td>
                                                        <td>
                                                            <select name="designid" class="form-control" id="designid">
                                                                <option value="">None</option>
                                                                @foreach ($layouts as $layout)
                                                                    <option value="{{ $layout->layout_id }}">{{ $layout->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                {{-- End Table body --}}
                                            </table>
                                            {{-- End Design Table --}}
                                        </div>
                                        {{-- End SEO Tab --}}


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
{{-- End Section of Add Manufacturers--}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

</script>
