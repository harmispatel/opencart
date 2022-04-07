{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Insert Cart Rule --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cart Rules</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('cartrule') }}">Cart Rules</a></li>
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
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ url('cartruleinsert') }}" id="cartruleadd" method="POST">
                            {{ csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('cartrule') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name"><span class="text-danger">*</span> Name</label>
                                        <input type="name" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" id="name" name="name">
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="total_above"><span class="text-danger">*</span> Free Item</label>
                                        <div class="row rounded {{ ($errors->has('free_item')) ? 'is-invalid' : '' }}" style="background: rgb(236, 229, 229)">
                                            @foreach ($freeitems as $freeitem)
                                                <div class="col-md-2 p-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                        name="free_item[]" value="{{ $freeitem->id_free_item }}" id="free_item_{{ $loop->iteration }}">
                                                        <label class="form-check-label" for="free_item_{{ $loop->iteration }}">{{html_entity_decode($freeitem->name_item) }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($errors->has('free_item'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('free_item') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="total_above"><span class="text-danger">*</span> Total Above</label>
                                        <input type="text" class="form-control {{ ($errors->has('total_above')) ? 'is-invalid' : '' }}" name="total_above" id="total_above">
                                        @if($errors->has('total_above'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('total_above') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- End Form --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Insert Cart Rule --}}

{{-- Footer Start --}}
@include('footer')
{{-- End Footer --}}
