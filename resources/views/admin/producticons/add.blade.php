{{-- Header --}}
@include('header')
{{-- Footer --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of Add Product Icons --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Icons</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('producticons') }}">Producticons</a></li>
                            <li class="breadcrumb-item active">Insert</li>
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
                            {{-- Form --}}
                            <form method="POST" action="{{ route('storeproducticons') }}" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2" style="color: black">
                                        <i class="fas fa-pencil-alt mr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                        <a href="{{ route('producticons') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="icon_name"><span class="text-danger">*</span> Icon Name</label>
                                        <input type="text" name="icon_name" id="icon_name" class="form-control {{ ($errors->has('icon_name')) ? 'is-invalid' : '' }}" placeholder="Icon Name" value="{{ old('icon_name') }}">
                                        @if($errors->has('icon_name'))
                                            <span class="invalid-feedback">
                                                {{ $errors->first('icon_name') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="icon_url"><span class="text-danger">*</span> Icon URL</label>
                                        <input type="text" name="icon_url" id="icon_url" class="form-control {{ ($errors->has('icon_url')) ? 'is-invalid' : '' }}" value="{{ old('icon_url') }}" placeholder="Icon URL">
                                        @if($errors->has('icon_url'))
                                        <span class="invalid-feedback">
                                            {{ $errors->first('icon_url') }}
                                        </span>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Alt Description</label>
                                        <textarea name="description" id="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order') }}" placeholder="Sort Order">
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
{{-- End Section of Add Product Icons --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

