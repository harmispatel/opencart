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
                            <li class="breadcrumb-item active">Edit</li>
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
                                    <a href="{{ route('products') }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-arrow-left">
                                            Back</i></a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Start --}}
                            <form action="{{ route('updateproduct') }}" method="POST" id="catform"
                                enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <input type="hidden" id="product_id"
                                    value="{{ isset($product->product_id) ? $product->product_id : '' }}"
                                    name="product_id">
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

                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option disabled selected>select</option>
                                                    @php
                                                        $test1 = isset($product->category_id) ? $product->category_id : '';
                                                        $test = explode(' ', $test1);
                                                    @endphp

                                                    @if (isset($result['category']))
                                                        @foreach ($result['category'] as $category)
                                                            <option value="{{ $category->category_id }}"
                                                                {{ in_array($category->category_id, $test) == $category->category_id ? 'selected' : '' }}>
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <hr>
                                            @php
                                                $productname = html_entity_decode($product->name);
                                            @endphp
                                            <div class="mb-3">
                                                <label for="product" class="form-label"><span
                                                        class="text-danger">*</span>Product Name</label>
                                                <input type="text" class="form-control" name="product" id="product"
                                                    placeholder="Product Name"
                                                    value="{{ isset($productname) ? $productname : '' }}" required>
                                            </div>
                                            <hr>
                                            <div class="mb-3">
                                                <label for="category" class="form-label"><span
                                                        class="text-danger">*</span>Product Icon</label>
                                                @php
                                                    $pro_icon = isset($product->product_icons) ? $product->product_icons : '';
                                                    $array = explode(',', $pro_icon);

                                                @endphp
                                                <select name="product_icons[]" id="product_icon" class="form-control"
                                                    multiple required>
                                                    @foreach ($result['product_icon'] as $productIcon)
                                                        <option value="{{ $productIcon->id }}" {{ in_array($productIcon->id, $array) == $productIcon->id ? 'selected' : '' }}>{{ $productIcon->icon_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <hr>
                                            <div class="mb-3">
                                                <label for="day" class="form-label">select the days
                                                    availiable</label>
                                                <div>
                                                    @php
                                                        $days = isset($product->availibleday) ? $product->availibleday : '';
                                                        $arr = explode(',', $days);
                                                    @endphp
                                                    <input type="checkbox" name="day[]" value="2"
                                                        {{ in_array(2, $arr) ? 'checked' : '' }}> Mon
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="3"
                                                        {{ in_array(3, $arr) ? 'checked' : '' }}> Tue
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="4"
                                                        {{ in_array(4, $arr) ? 'checked' : '' }}> Wed
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="5"
                                                        {{ in_array(5, $arr) ? 'checked' : '' }}> Thu
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="6"
                                                        {{ in_array(6, $arr) ? 'checked' : '' }}> Fir
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="7"
                                                        {{ in_array(7, $arr) ? 'checked' : '' }}> Sat
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" name="day[]" value="8"
                                                        {{ in_array(8, $arr) ? 'checked' : '' }}> Sun
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="mb-3" id="order_types">
                                                <label for="order" class="form-label">Order Type</label>
                                                <div>

                                                    <input type="radio" name="order_type" value="both"
                                                        {{ (isset($product->order_type) ? $product->order_type : '' == 'both') ? 'checked' : '' }}>
                                                    Both
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="order_type" value="delivery"
                                                        {{ (isset($product->order_type) ? $product->order_type : '' == 'delivery') ? 'checked' : '' }}>
                                                    Delivery
                                                    Only &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="order_type" value="collection"
                                                        {{ (isset($product->order_type) ? $product->order_type : '' == 'collection') ? 'checked' : '' }}>
                                                    Collection Only &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="form-floating">
                                                <label for="summernote" class="form-label">Description</label>
                                                @php
                                                    $productdescription = html_entity_decode($product->description);
                                                @endphp
                                                <textarea class="form-control" name="description" id="summernote"
                                                    style="height: 200px">{{ isset($productdescription) ? $productdescription : '' }}</textarea>
                                            </div>
                                            <hr>
                                            <div class="class=mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <div>
                                                    Main Price <input type="text" name="mainprice"
                                                        class="form-control"
                                                        value="{{ isset($product->price) ? $product->price : '' }}">
                                                    Delivery Price <input type="text" name="deliveryprice"
                                                        class="form-control"
                                                        value="{{ isset($product->delivery_price) ? $product->delivery_price : '' }}">
                                                    Collection Price <input type="text" name="collectionprice"
                                                        class="form-control"
                                                        value="{{ isset($product->collection_price) ? $product->collection_price : '' }}">
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="class=mb-3">
                                                <label for="size" class="form-label">Size Price</label>
                                                <br>
                                                <div>

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Size</th>
                                                                <th>Main Price</th>
                                                                <th>Delivery Price</th>
                                                                <th>Collection Price</th>
                                                            </tr>
                                                            @foreach ($result['header'] as $header)
                                                                <tr>
                                                                    <td><label
                                                                            for="">{{ $header->size }}</label><input
                                                                            type="hidden" name="id_size[]"
                                                                            value="{{ $header->id_size }}">
                                                                    </td>

                                                                    @php
                                                                        $product_size = getProductSize($header->id_size, $product->product_id);
                                                                    @endphp
                                                                    <td>
                                                                        @if (!empty($product_size) || $product_size != '')
                                                                            <input type="hidden"
                                                                                name="id_product_price_size[]"
                                                                                value="{{ isset($product_size->id_product_price_size) ? $product_size->id_product_price_size : '0' }}">
                                                                        @endif

                                                                        <input type="text" name="mainprices[]"
                                                                            id="mainprice"
                                                                            value="{{ isset($product_size->price) ? $product_size->price : 0 }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="deliveryprices[]"
                                                                            id="deliveryprice"
                                                                            value="{{ isset($product_size->delivery_price) ? $product_size->delivery_price : 0 }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="collectionprices[]"
                                                                            id="collectionprice"
                                                                            value="{{ isset($product_size->collection_price) ? $product_size->collection_price : 0 }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </thead>
                                                    </table>

                                                </div>

                                            </div>


                                            <div class="form-group">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" name="image" id="image" class="form-control">
                                                @php
                                                    $p_image = isset($product->image) ? $product->image : '';
                                                @endphp
                                                <div class="mt-1">
                                                    <img src="{{ $p_image }}" width="100px" />
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end Genral --}}
                                        {{-- start Option --}}
                                        <div class="tab-pane fade" id="option" role="tabpanel"
                                            aria-labelledby="option-tab">
                                            @php
                                                $t_type_prod_id = isset($result['toppingType']->id_product) ? $result['toppingType']->id_product : '';
                                                $t_type_name_topping = isset($result['toppingType']->name_topping) ? $result['toppingType']->name_topping : '';
                                            @endphp

                                            @if (isset($product->product_id) ? $product->product_id : '' == $t_type_prod_id)
                                                <h2>{{ $t_type_name_topping }}</h2>
                                                <div style="margin-bottom: 10px;">
                                                    <input type="radio" name="typetopping" class="avtive"
                                                        value="select"
                                                        {{ (isset($result['toppingType']->typetopping) ? $result['toppingType']->typetopping : '' == 'select') ? 'checked' : '' }}
                                                        onclick="radiocheck()">
                                                    Dropdown
                                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                                    <input type="radio" name="typetopping" value="checkbox"
                                                        {{ (isset($result['toppingType']->typetopping) ? $result['toppingType']->typetopping : '' == 'checkbox') ? 'checked' : '' }}
                                                        onclick="radiocheck()">
                                                    Checkbox
                                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                                </div>

                                                <div id="text"></div>

                                                <div style="margin-bottom: 10px;">
                                                    <input type="radio" name="enable[]" value="1"
                                                        {{ (isset($result['toppingType']->enable) ? $result['toppingType']->enable : '' == 1) ? 'checked' : '' }}>
                                                    Enable
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="enable[]" value="0"
                                                        {{ (isset($result['toppingType']->enable) ? $result['toppingType']->enable : '' == 0) ? 'checked' : '' }}>
                                                    Disable
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                                <div class="form-floating">
                                                    <label for="rename" class="form-label">Rename to</label>
                                                    <input type="text" name="renamegroup" class="form-control">
                                                </div>
                                                <div class="form-floating"
                                                    style="padding-bottom:20px;border-bottom: 1px solid #000000;margin-bottom:10px;">
                                                    <label for="sort_order" class="form-label">Sort Order</label>
                                                    <input type="text" name="topping_sort_order" value="0"
                                                        class="form-control">
                                                </div>
                                            @else
                                                {{ 'No Topping' }}
                                            @endif

                                            <hr>


                                            <div class="form-floating">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option
                                                        value="{{ isset($product->status) ? $product->status : '' }}"
                                                        style="display: none">
                                                        {{ isset($product->status) ? $product->status : '' }}</option>
                                                    <option value="1">Enabled</option>
                                                    <option value="0">Deabled</option>
                                                </select>
                                            </div>
                                            <div class="form-floating">
                                                <label for="sort_order" class="form-label">Sort Order</label>
                                                <input type="text" name="sort_order"
                                                    value="{{ isset($product->sort_order) ? $product->sort_order : '' }}"
                                                    class="form-control">
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

<script>
    $(document).ready(function() {

        var data = $('input[name=typetopping]:checked').val();
        var html = '';
        if (data == 'checkbox') {
            html = '<div><lable>Minimum</lable></div>';
            html += '<div><input type="text" name="minimum" value="0" class="form-control"></div>';
            html += '<div><lable>Maximum</lable></div>';
            html += '<div><input type="text" name="maximum" value="0" class="form-control"></div>';
        }
        $("#text").append(html);
    });

    function radiocheck() {
        var data = $('input[name=typetopping]:checked').val();

        var html = '';
        if (data == 'select') {
            $("#text").html('');
        }
        if (data == 'checkbox') {
            html += '<div><lable>Minimum</lable></div>';
            html += '<div><input type="text" name="minimum" value="0" class="form-control"></div>';
            html += '<div><lable>Maximum</lable></div>';
            html += '<div><input type="text" name="maximum" value="0" class="form-control"></div>';
        }
        $("#text").append(html);
    }
</script>
