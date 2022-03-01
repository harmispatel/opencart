@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Reviews --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reviews</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('review') }}">Reviews</a></li>
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
                                    <i class="fas fa-pencil-alt"></i>
                                    Add Review
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('storereview') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="author" class="form-label">Author</label>
                                                <input type="text" name="author" id="author" value="{{ old('author') }}" class="form-control {{ ($errors->has('author')) ? 'is-invalid' : '' }}" placeholder="John Doe">
                                                @if ($errors->has('author'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('author') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pname" class="form-label">Product</label>
                                                <select name="productid" id="productid" class="form-control {{ ($errors->has('productid')) ? 'is-invalid' : '' }}">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->product_id }}" {{ ($product->product_id == old('productid')) ? 'selected' : '' }}>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('productid'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('productid') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="desc" class="form-label">Description</label>
                                                <textarea name="description" id="description" class="form-control {{ ($errors->has('description')) ? 'is-invalid' : '' }}" placeholder="Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae, rerum.    ">{{ old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="desc" class="form-label">Rating</label>
                                                <div class="form-control pt-0 {{ ($errors->has('rating')) ? 'is-invalid' : '' }}">

                                                    <div class="wrapper-star mt-0 pt-0">

                                                        <input type="radio" id="r1" name="rating" value="5" {{ (old('rating') == 5) ? 'checked' : '' }}>
                                                        <label for="r1" class="{{ (old('rating') == 5) ? 'text-success' : '' }}">&#10038;</label>

                                                        <input type="radio" id="r2" name="rating" value="4" {{ (old('rating') == 4) ? 'checked' : '' }}>
                                                        <label for="r2" class="{{ (old('rating') == 4 || old('rating') == 5) ? 'text-success' : '' }}">&#10038;</label>

                                                        <input type="radio" id="r3" name="rating" value="3" {{ (old('rating') == 3) ? 'checked' : '' }}>
                                                        <label for="r3" class="{{ (old('rating') == 3 || old('rating') == 4 || old('rating') == 5) ? 'text-success' : '' }}">&#10038;</label>

                                                        <input type="radio" id="r4" name="rating" value="2" {{ (old('rating') == 2) ? 'checked' : '' }}>
                                                        <label for="r4" class="{{ (old('rating') == 2 || old('rating') == 3 || old('rating') == 4 || old('rating') == 5) ? 'text-success' : '' }}">&#10038;</label>

                                                        <input type="radio" id="r5" name="rating" value="1" {{ (old('rating') == 1) ? 'checked' : '' }}>
                                                        <label for="r5" class="{{ (old('rating') == 1 || old('rating') == 2 || old('rating') == 3 || old('rating') == 4 || old('rating') == 5 ) ? 'text-success' : '' }}">&#10038;</label>

                                                      </div>
                                                </div>
                                                @if ($errors->has('rating'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('rating') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date" class="form-label">Date Added</label>
                                                <input type="date" name="date" id="date" value="{{ old('date') }}" class="form-control {{ ($errors->has('date')) ? 'is-invalid' : '' }}">
                                                @if ($errors->has('date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('date') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1" selected>Enabled</option>
                                                    <option value="0">Disabled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- End Card Body --}}

                                {{-- Card Footer --}}
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('review') }}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
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
{{-- End Section of Add Reviews--}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

{{-- Sweet Alert Js --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- End Sweet Alert --}}


<script type="text/javascript">

// Autosearch Product
// $('#productname').autocomplete({
//     source: function(request, response){
//             $.ajax({
//                     url: '{{ url("getproductsearch") }}',
//                     data: {
//                             term : request.term
//                     },
//                     dataType: "json",
//                     success: function(data)
//                     {
//                         var result = $.map(data,function(obj){

//                             $('#pid').val(obj.product_id);
//                             return obj.name;
//                         });
//                         response(result);
//                     }
//             });
//     }
// });
// End Autosearch Product

</script>
