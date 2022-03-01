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
                        <h1>Add New Product</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('productlist') }}">Product List </li>
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
                        Add Product
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('category') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
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
                        <a class="nav-link" id="links-tab" data-toggle="tab" href="#links" role="tab"
                            aria-controls="links" aria-selected="false">Links</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="attribute-tab" data-toggle="tab" href="#attribute" role="tab"
                            aria-controls="attribute" aria-selected="false">Attribute</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="option-tab" data-toggle="tab" href="#option" role="tab"
                            aria-controls="option" aria-selected="false">Option</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="recurring-tab" data-toggle="tab" href="#recurring" role="tab"
                            aria-controls="recurring" aria-selected="false">Recurring</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="discount-tab" data-toggle="tab" href="#discount" role="tab"
                            aria-controls="discount" aria-selected="false">Discount</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="special-tab" data-toggle="tab" href="#special" role="tab"
                            aria-controls="special" aria-selected="false">Special</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="image-tab" data-toggle="tab" href="#image" role="tab"
                            aria-controls="image" aria-selected="false">Image</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reward_points-tab" data-toggle="tab" href="#reward_points"
                            role="tab" aria-controls="reward_points" aria-selected="false">Reward Points</a>
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
                            <label for="product" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product" placeholder="Product Name">
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
                        <div class="form-floating">
                            <label for="producttag" class="form-label">Product Tags</label>
                            <textarea class="form-control" placeholder="Product Tags" name="producttag"
                                id="producttag" style="height: 100px"></textarea>
                            <label for="producttag"></label>
                        </div>
                    </div>
                    {{-- end Genral --}}

                    {{-- start Data --}}
                    <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" placeholder="Model">
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" placeholder="SKU">
                        </div>
                        <div class="mb-3">
                            <label for="upc" class="form-label">UPC</label>
                            <input type="text" class="form-control" id="upc" placeholder="UPC">
                        </div>
                        <div class="mb-3">
                            <label for="ean" class="form-label">EAN</label>
                            <input type="text" class="form-control" id="ean" placeholder="EAN">
                        </div>
                        <div class="mb-3">
                            <label for="jan" class="form-label">JAN</label>
                            <input type="text" class="form-control" id="jan" placeholder="JAN">
                        </div>
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" placeholder="ISBN">
                        </div>
                        <div class="mb-3">
                            <label for="mpn" class="form-label">MPN</label>
                            <input type="text" class="form-control" id="mpn" placeholder="MPN">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" placeholder="Location">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" placeholder="Price">
                        </div>
                        <div class="mb-3">
                            <label for="texclass" class="form-label">Tax Class</label>
                            <select name="texclass" id="texclass" class="form-control">
                                <option selected disabled>---None---</option>
                                @foreach ($result['tex_class'] as $tex_class)
                                    <option value="{{ $tex_class->title }}">{{ $tex_class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" value="1">
                        </div>
                        <div class="mb-3">
                            <label for="minimumid" class="form-label">Minimum Quantity</label>
                            <input type="text" class="form-control" id="minimumid" value="1">
                        </div>
                        <div class="mb-3">
                            <label for="subtract" class="form-label">Subtract Stock</label>
                            <select name="subtract" id="subtract" class="form-control">
                                <option value="1" selected="selected">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stock_status_id" class="form-label">Out Of Stock Status</label>
                            <select name="stock_status_id" id="stock_status_id" class="form-control">
                                @foreach ($result['stok_status'] as $stok_status)
                                    <option value="{{ $stok_status->name }}">{{ $stok_status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="requires_shipping" class="form-label">Requires Shipping</label>
                            <input type="radio" name="shipping" value="1" checked="checked">Yes
                            <input type="radio" name="shipping" value="0" checked="checked">No
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_available" class="form-label">Date Available</label>
                            <input type="date" class="form-control" name="date_available" id="date_available">
                        </div>
                        <div class="mb-6">
                            <label class="col-sm-3 control-label" for="length">Dimensions(L x W x H)</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="length" value="" placeholder="Length" id="length"
                                            class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="width" value="" placeholder="Width" id="width"
                                            class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="height" value="" placeholder="Height" id="height"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lenght_class" class="form-label">Length Class</label>
                            <select name="length class" id="lenght_class" class="form-control">
                                @foreach ($result['lenght_class'] as $lenght_classed)
                                    <option value="{{ $lenght_classed->title }}">{{ $lenght_classed->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="text" class="form-control" id="weight" placeholder="Weight">
                        </div>

                        <div class="mb-3">
                            <label for="weight_class_id" class="form-label">Weight Class</label>
                            <select name="weight_class_id" id="weight_class_id" class="form-control">
                                @foreach ($result['weight_class'] as $weight_classed)
                                    <option value="{{ $weight_classed->title }}">{{ $weight_classed->title }}
                                    </option>
                                @endforeach
                            </select>
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

                    {{-- start Links --}}
                    <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
                        <div class="mb-3">
                            <label for="manufacturer" class="form-label">Manufacturer</label>
                            <select name="Manufacturer" class="form-control" id="Manufacturer">
                                <option selected>---None---</option>
                                @foreach ($result['manufacturer'] as $manufacturer)
                                    <option value="{{ $manufacturer->name }}">{{ $manufacturer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="categories" class="form-label">Categories</label>

                            <select class="js-example-basic-multiple" name="categories[]" multiple="multiple"
                                style="width: 100%">
                                @foreach ($result['category'] as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="filters" class="form-label">Filters</label>
                            <select class="js-example-basic-multiple" name="filters[]" id="filters" multiple="multiple"
                                style="width: 100%">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stores" class="form-label">Stores</label>
                            <label>
                                <input type="checkbox" name="stores[]" value="0" checked="checked" />Default
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="downloads" class="form-label">Downloads</label>
                            <select class="js-example-basic-multiple" name="downloads[]" multiple="multiple"
                                style="width: 100%">
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="related_products" class="form-label">Related Products</label>
                            <select class="js-example-basic-multiple" name="related_products[]" multiple="multiple"
                                style="width: 100%">
                                @foreach ($result['releted_product'] as $releted_product)
                                    <option value="{{ $releted_product->name }}">{{ $releted_product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- end links --}}

                    {{-- start Attribute --}}
                    <div class="tab-pane fade" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">

                        <div class="tab-pane" id="tab-attribute">
                            <div class="table-responsive">
                                <table id="attribute" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left">Attribute</td>
                                            <td class="text-left">Text</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-right"><button type="button" onclick="addAttribute();"
                                                    data-toggle="tooltip" title="Add Attribute"
                                                    class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end Attribute --}}

                    {{-- start Option --}}
                    <div class="tab-pane fade" id="option" role="tabpanel" aria-labelledby="option-tab">
                        <div class="mb-3">
                              
                            <select name="option_showww" id="option_showww"  placeholder="Option" class="form-control">
                                <option selected disabled>---None---</option>
                                @foreach ($option as $option)
                                    <option value="{{ $option->name }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div id="appandoption"></div>
                    </div>
                    {{-- end Option --}}

                    {{-- Start Recurring --}}
                    <div class="tab-pane fade" id="recurring" role="tabpanel" aria-labelledby="recurring-tab">
                        <div class="tab-pane" id="tab-attribute">
                            <div class="table-responsive">
                                <table id="attribute" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><b>Recurring Profile</b></td>
                                            <td class="text-left"><b>Customer Group</b></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-right"><button type="button" onclick="recurring();"
                                                    data-toggle="tooltip" title="Add Attribute"
                                                    class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end Recurring --}}

                    {{-- Start Discount --}}
                    <div class="tab-pane fade" id="discount" role="tabpanel" aria-labelledby="discount-tab">
                        <div class="tab-pane" id="tab-discount">
                            <div class="table-responsive">
                                <table id="discount" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><b>Customer Group</b></td>
                                            <td class="text-left"><b>Quantity</b></td>
                                            <td class="text-left"><b>Priority</b></td>
                                            <td class="text-left"><b>Price</b></td>
                                            <td class="text-left"><b>Date Start</b></td>
                                            <td class="text-left"><b>Date End</b></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-right"><button type="button" onclick="discount();"
                                                    data-toggle="tooltip" title="Add discount"
                                                    class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- End Discount --}}

                    {{-- Start Special --}}
                    <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">
                        <div class="tab-pane" id="tab-special">
                            <div class="table-responsive">
                                <table id="special" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><b>Customer Group</b></td>
                                            <td class="text-left"><b>Priority</b></td>
                                            <td class="text-left"><b>Price</b></td>
                                            <td class="text-left"><b>Date Start</b></td>
                                            <td class="text-left"><b>Date End</b></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-right"><button type="button" onclick="special();"
                                                    data-toggle="tooltip" title="Add discount"
                                                    class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- End Special --}}

                    {{-- Start Image --}}
                    <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
                        <div class="tab-pane" id="tab-image">
                            <div class="table-responsive">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" id="image">
                                    <img src="{{ asset('public/admin/image/no_image.png') }}" height="100px"
                                        width="100px">
                                </div>
                                <table id="image" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><b>
                                                    Additional Images</b></td>
                                            <td class="text-right"><b>Sort Order</b></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-right"><button type="button" onclick="product_image();"
                                                    data-toggle="tooltip" title="Add discount"
                                                    class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- End Image --}}

                    {{-- Start Reward Ppoints --}}
                    <div class="tab-pane fade" id="reward_points" role="tabpanel" aria-labelledby="reward_points-tab">
                        <div class="mb-3">
                            <label for="reward_points" class="form-label">Points</label>
                            <input type="text" class="form-control" id="reward_points" placeholder="Points">
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><b>Customer Group</b></td>
                                            <td class="text-right"><b>Reward Points</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">Default</td>
                                            <td class="text-left">
                                                <div class="input-group">
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- End Reward Ppoints --}}

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
                                                    @foreach ($result['product_layout'] as $item)
                                                        <option value="{{ $item->name }}">{{ $item->name }}
                                                        </option>
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
                {{-- End Design --}}
            </form>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
