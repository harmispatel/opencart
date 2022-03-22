@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


{{-- Section of Add Product --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
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
                                    Add Product 
                                </h3>
                                <div class="container" style="text-align: right;">
                                    <button type="submit" form="catform" class="btn btn-sm btn-primary"><i
                                            class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('category') }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-arrow-left">
                                            Back</i></a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Start --}}
                            <form action="{{ route('storeproduct') }}" method="POST" id="catform"
                                enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tab Links --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral"
                                                role="tab" aria-controls="genral" aria-selected="true"><i
                                                    class="fa fa-table-cells"></i>Genral</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="option-tab" data-toggle="tab" href="#option"
                                                role="tab" aria-controls="option" aria-selected="false">Option</a>
                                        </li>

                                    </ul>


                                    <div class="tab-content p-4" id="myTabContent">
                                        {{-- Genreal --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel"
                                            aria-labelledby="genral-tab">
                                            {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="english-tab" data-toggle="tab"
                                                        href="#english" role="tab" aria-controls="english"
                                                        aria-selected="true">English</a>
                                                </li>
                                            </ul> --}}

                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option disabled selected>select</option>
                                                    @foreach ($result['category'] as $category)
                                                        <option value="{{ $category->category_id }}">
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>



                                            <div class="mb-3">
                                                <label for="product" class="form-label"><span class="text-danger">*</span>Product Name</label>
                                                <input type="text" class="form-control" name="product" id="product"
                                                    placeholder="Product Name" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="category" class="form-label"><span class="text-danger">*</span>Product Icon</label>
                                                <select name="product_icons[]" id="product_icon" class="form-control"
                                                    multiple required>
                                                    @foreach ($result['product_icon'] as $productIcon)
                                                        <option value="{{ $productIcon->id }}">
                                                            {{ $productIcon->icon_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="day" class="form-label">select the days
                                                    availiable</label>
                                                <div>
                                                    <input type="checkbox" name="day[]" value="2"> Mon
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="3"> Tue
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="4"> Wed
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="5"> Thu
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="6"> Fir
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="7"> Sat
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="8"> Sun
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="order" class="form-label">Order Type</label>
                                                <div>
                                                    <input type="radio" name="order_type[]" value="both"> Both
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="order_type[]" value="delivery"> Delivery
                                                    Only &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="order_type[]" value="collection">
                                                    Collection Only &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>


                                            <div class="form-floating">
                                                <label for="summernote" class="form-label">Description</label>
                                                <textarea class="form-control" placeholder="Leave a comment here"
                                                    name="description" id="summernote" style="height: 200px"></textarea>
                                            </div>

                                            <div class="class=mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <div>
                                                    Main Price <input type="text" name="mainprice"
                                                        class="form-control">
                                                    Delivery Price <input type="text" name="deliveryprice"
                                                        class="form-control">
                                                    Collection Price <input type="text" name="collectionprice"
                                                        class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" name="image" id="image" class="form-control">
                                            </div>
                                        </div>
                                        {{-- end Genral --}}
                                        {{-- start Option --}}
                                        <div class="tab-pane fade" id="option" role="tabpanel"
                                            aria-labelledby="option-tab">
                                            <div class="form-floating">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1">Enabled</option>
                                                    <option value="0">Deabled</option>
                                                </select>
                                            </div>
                                            <div class="form-floating">
                                                <label for="sort_order" class="form-label">Sort Order</label>
                                                <input type="text" name="sort_order" value="10" class="form-control">
                                            </div>
                                        </div>
                                        {{-- end Option --}}


                                         </div>
                                 </div> 
                                        {{-- End Card Body --}}
                            </form>
                            {{-- Form End --}}
                        </div>
                        {{-- Card End --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
