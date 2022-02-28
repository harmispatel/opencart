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
                        <h1>Manufacturers</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('manufacturer') }}">Manufacturers</a></li>
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
                                    Edit Manufacturer
                                </h3>

                                <div class="container" style="text-align: right">
                                    <button type="submit" form="manuForm" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Update</button>
                                    <a href="{{ route('manufacturer') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('updatemanufacturer') }}" id="manuForm" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab" aria-controls="genral" aria-selected="true">Genral</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"
                                                aria-controls="seo" aria-selected="false">SEO</a>
                                        </li>
                                    </ul>
                                    {{-- End Tabs Link --}}


                                    <div class="tab-content pt-4" id="myTabContent">

                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">

                                            <div class="form-group">

                                                <input type="hidden" name="id" id="id" value="{{ $manufacturer->manufacturer_id }}">

                                                <label for="mname" class="form-label">Manufacturer Name</label>
                                                <input type="text" name="manufacturername" class="form-control {{ ($errors->has('manufacturername')) ? 'is-invalid' : '' }}" id="manufacturername" value="{{ $manufacturer->name }}">
                                                @if($errors->has('manufacturername'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('manufacturername') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="stores" class="form-label">Stores</label>
                                                <div class="form-control" style="background: #e3e3e3">
                                                    <input type="checkbox" name="default" id="default" value="1" checked>
                                                    <label for="default"> Default</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" name="image" id="image" class="form-control" style="padding: 3px;">
                                            </div>

                                            @if(!empty($manufacturer->image))
                                                <div class="form-group">
                                                    <img src="{{ asset('public/admin/manufacturers/'.$manufacturer->image) }}" alt="Not Found" width="80">
                                                </div>
                                            @else
                                                <div class="form-group text-danger">
                                                    image Not Available
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="sortorder">Sort Order</label>
                                                <input type="number" name="sortorder" id="sortorder" class="form-control" placeholder="5" value="{{$manufacturer->sort_order }}">
                                            </div>

                                        </div>
                                        {{-- End Genral Tab --}}

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
                                                                <input type="text" name="keyword" placeholder="Keyword" class="form-control" aria-describedby="basic-addon1" aria-label="Keyword" value="{{ (isset($seo->keyword)) ? $seo->keyword : '' }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                {{-- End Table body --}}
                                                {{-- End SEO Table --}}
                                            </table>
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
{{-- End Section of Add Users--}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

</script>
