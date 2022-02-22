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
                        <h1>Add New Product</h1>
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
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Add Product
                    </h3>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
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
                    <a class="nav-link" id="reward_points-tab" data-toggle="tab" href="#reward_points" role="tab"
                        aria-controls="reward_points" aria-selected="false">Reward Points</a>
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
            <div class="tab-content p-4" id="myTabContent">
                <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab"
                                aria-controls="english" aria-selected="true">English</a>
                        </li>
                    </ul>
                    <form action="" method="POST" enctype="multipart/form-data">
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
                            <textarea class="form-control" placeholder="Meta Tag Keywords" name="metakey"
                                id="metakey" style="height: 100px"></textarea>
                            <label for="metakey"></label>
                        </div>
                        <div class="form-floating">
                            <label for="producttag" class="form-label">Product Tags</label>
                            <textarea class="form-control" placeholder="Product Tags" name="producttag"
                                id="producttag" style="height: 100px"></textarea>
                            <label for="producttag"></label>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save">
                                        Save</i></button>
                                <a href="{{ route('product') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                        Back</i></a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                    <form>
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
                                <option>Taxable Goods</option>
                                <option>Downloadable Products</option>
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
                                <option>2-3 Days</option>
                                <option>In Stock</option>
                                <option>Out Of Stock</option>
                                <option>Pre-Order</option>
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
                                      <input type="text" name="length" value="" placeholder="Length" id="length" class="form-control"/>
                                    </div>
                                    <div class="col-sm-4">
                                      <input type="text" name="width" value="" placeholder="Width" id="width" class="form-control"/>
                                    </div>
                                    <div class="col-sm-4">
                                      <input type="text" name="height" value="" placeholder="Height" id="height" class="form-control"/>
                                    </div>
                                  </div>
                              </div>
                        </div>

                        <div class="mb-3">
                            <label for="lenght_class" class="form-label">Length Class</label>
                            <select name="length class" id="lenght_class" class="form-control">
                                <option value="1" selected="selected">Centimeter</option>
                                <option value="2">Millimeter</option>
                                <option value="3">Inch</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="text" class="form-control" id="weight" placeholder="Weight">
                        </div>

                        <div class="mb-3">
                            <label for="weight_class_id" class="form-label">Weight Class</label>
                            <select name="weight_class_id" id="weight_class_id" class="form-control">
                                <option value="1" selected="selected">Kilogram</option>
                                <option value="2">Gram</option>
                                <option value="5">Pound </option>
                                <option value="6">Ounce</option>
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

                        <div class="card-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save">
                                        Save</i></button>
                                <a href="{{ route('product') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                        Back</i></a>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
                    <form action="" method="POST">
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
                            <select class="form-control" name="categories[]" id="categories" multiple="multiple">
                                {{-- <option selected>---None---</option> --}}
                                @foreach ($result['category'] as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                              </select>
                        </div>

                        <div class="mb-3">
                            <label for="filters" class="form-label">Filters</label>
                            <select class="form-control" name="filters[]" id="filters" multiple="multiple">
                                <option selected>---None---</option>
                              </select>
                        </div>
                        <div class="mb-3">
                            <label for="stores" class="form-label">Stores</label>
                            <label>
                                <input type="checkbox" name="stores[]"  value="0" checked="checked"/>Default
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="downloads" class="form-label">Downloads</label>
                            <select class="form-control" name="downloads[]" id="downloads" multiple="multiple">
                                <option selected>---None---</option>
                              </select>
                        </div>

                        <div class="mb-3">
                            <label for="related_products" class="form-label">Related Products</label>
                            <select class="form-control" name="related_products[]" id="related_products" multiple="multiple">
                              </select>
                        </div>

                        <div class="card-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save">
                                        Save</i></button>
                                <a href="{{ route('product') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                        Back</i></a>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="tab-pane fade" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                    attribute
                </div>

                <div class="tab-pane fade" id="option" role="tabpanel" aria-labelledby="option-tab">
                    option
                </div>
                <div class="tab-pane fade" id="recurring" role="tabpanel" aria-labelledby="recurring-tab">
                    recurring
                </div>
                <div class="tab-pane fade" id="discount" role="tabpanel" aria-labelledby="discount-tab">
                    discount
                </div>
                <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">
                    special
                </div>
                <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
                    image
                </div>
                <div class="tab-pane fade" id="reward_points" role="tabpanel" aria-labelledby="reward_points-tab">
                    reward_points
                </div>
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                    seo
                </div>
                <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                    design
                </div>
</section>
{{-- End Form Section --}}
</div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
