<!--
    THIS IS HEADER Addproduct PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    add.blade.php
    Its Used for Insert New Product
    ----------------------------------------------------------------------------------------------
-->


{{-- Header--}}
@include('header')
{{-- End Header--}}

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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Warning: Please check the form carefully for errors!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
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
                                                <select name="category" id="category" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}">
                                                    <option disabled selected>select</option>
                                                    @foreach ($result['category'] as $category)
                                                        <option value="{{ $category->category_id }}">
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('category') }}
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label for="product" class="form-label"><span
                                                        class="text-danger">*</span>Product Name</label>
                                                <input type="text"
                                                    class="form-control {{ $errors->has('product') ? 'is-invalid' : '' }}"
                                                    value="{{ old('product') }}" name="product" id="product"
                                                    placeholder="Product Name">
                                                @if ($errors->has('product'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('product') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="category" class="form-label"><span
                                                        class="text-danger">*</span>Product Icon</label>
                                                <select name="product_icons[]" id="product_icon"
                                                    class="form-control {{ $errors->has('product_icons') ? 'is-invalid' : '' }}"
                                                    multiple>
                                                    @foreach ($result['product_icon'] as $productIcon)
                                                        <option value="{{ $productIcon->id }}">
                                                            {{ $productIcon->icon_name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('product_icons'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('product_icons') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">select the days
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
                                                <label class="form-label">Order Type</label>
                                                <div>
                                                    <input type="radio" name="order_type[]" value="both" > Both
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="order_type[]" value="delivery"> Delivery
                                                    Only &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="order_type[]" value="collection">
                                                    Collection Only &nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                            </div>


                                            <div class="form-floating">
                                                <label for="summernote" class="form-label">Description</label>
                                                <textarea class="form-control" placeholder="Leave a comment here" name="description" id="summernote"
                                                    style="height: 200px">{{ old('description') }}</textarea>
                                            </div>

                                            <div class="class=mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <div>
                                                    Main Price <input type="text" name="mainprice" class="form-control {{ $errors->has('mainprice') ? 'is-invalid' : '' }}" value="{{ old('mainprice') }}">
                                                    @if ($errors->has('mainprice'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('mainprice') }}
                                                        </div>
                                                    @endif
                                                    Delivery Price <input type="text" name="deliveryprice" class="form-control" value="{{ old('deliveryprice') }}">
                                                    Collection Price <input type="text" name="collectionprice" class="form-control" value="{{ old('collectionprice') }}">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="test"  data-toggle="modal" data-target="#myModal" class="form-control">
                                                <div class="row m-4"  id="gallryappend">

                                                            <div class="demo_ col-md-3 mt-3">
                                                                <div class="image w-100" style="position: relative;display:inline-block;border: 2px solid black;overflow:hidden;">

                                                                    <div id="div" style="width: 100px;"></div>

                                                                    <div class="imageOverlay">
                                                                            <img class="w-100" src="{{ asset('public/admin/no_image.jpg') }}" id="thumb" />
                                                                        <span></span>
                                                                    </div>
                                                                    <a class="browse_image img-de" data-toggle="modal" data-target="#myModal">Browse</a>
                                                                    {{-- <a class="browse_image img-de" onclick="showmodal(1);">Browse</a> --}}
                                                                </div>
                                                            </div>


                                                </div>

                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                      <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                      </a>
                                                    </span>
                                                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                                                  </div>
                                                  <img id="holder" style="margin-top:15px;max-height:100px;">
                                                {{-- <button data-toggle="modal" data-target="#myModal">image</button> --}}
                                                {{-- <input
                                                    class="form-control p-1   {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                                    name="image" id="image" type="file">
                                                @if ($errors->has('image'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('image') }}
                                                    </div>
                                                @endif --}}
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
{{-- End Section of Add Product --}}
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="max-width: 950px ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Photo Gallery</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <nav class="navbar sticky-top navbar-expand-lg navbar-dark" id="nav">
                    <a class="navbar-brand invisible-lg d-none d-lg-inline" id="to-previous">
                        <i class="fas fa-arrow-left fa-fw"></i>
                        <span class="d-none d-lg-inline">{{ trans('laravel-filemanager::lfm.nav-back') }}</span>
                    </a>
                    <a class="navbar-brand d-block d-lg-none" id="show_tree">
                        <i class="fas fa-bars fa-fw"></i>
                    </a>
                    <a class="navbar-brand d-block d-lg-none" id="current_folder"></a>
                    <a id="loading" class="navbar-brand"><i class="fas fa-spinner fa-spin"></i></a>
                    <div class="ml-auto px-2">
                        <a class="navbar-link d-none" id="multi_selection_toggle">
                            <i class="fa fa-check-double fa-fw"></i>
                            <span class="d-none d-lg-inline">{{ trans('laravel-filemanager::lfm.menu-multiple') }}</span>
                        </a>
                    </div>
                    <a class="navbar-toggler collapsed border-0 px-1 py-2 m-0" data-toggle="collapse"
                        data-target="#nav-buttons">
                        <i class="fas fa-cog fa-fw"></i>
                    </a>
                    <div class="collapse navbar-collapse flex-grow-0" id="nav-buttons">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" data-display="grid">
                                    <i class="fas fa-th-large fa-fw"></i>
                                    <span>{{ trans('laravel-filemanager::lfm.nav-thumbnails') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-display="list">
                                    <i class="fas fa-list-ul fa-fw"></i>
                                    <span>{{ trans('laravel-filemanager::lfm.nav-list') }}</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-sort fa-fw"></i>{{ trans('laravel-filemanager::lfm.nav-sort') }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right border-0"></div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <nav class="bg-light fixed-bottom border-top d-none" id="actions">
                    <a data-action="open" data-multiple="false"><i
                            class="fas fa-folder-open"></i>{{ trans('laravel-filemanager::lfm.btn-open') }}</a>
                    <a data-action="preview" data-multiple="true"><i
                            class="fas fa-images"></i>{{ trans('laravel-filemanager::lfm.menu-view') }}</a>
                    <a data-action="use" onclick="closePopupAndSetPath()" data-imageId="0" id="test" data-multiple="true"><i
                            class="fas fa-check"></i>Confirm</a>
                </nav>

                <div class="d-flex flex-row">
                    <div class="tree"></div>

                    <div id="main">
                        <div id="alerts"></div>

                        <nav aria-label="breadcrumb" class="d-none d-lg-block" id="breadcrumbs">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item invisible">Home</li>
                            </ol>
                        </nav>

                        <div id="empty" class="d-none">
                            <i class="far fa-folder-open"></i>
                            {{ trans('laravel-filemanager::lfm.message-empty') }}
                        </div>

                        <div id="content"></div>
                        <div id="pagination"></div>

                        <a id="item-template" class="d-none">
                            <div class="square"></div>

                            <div class="info">
                                <div class="item_name text-truncate"></div>
                                <time class="text-muted font-weight-light text-truncate"></time>
                            </div>
                        </a>
                    </div>

                    <div id="fab"></div>
                </div>

                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">
                                    {{ trans('laravel-filemanager::lfm.title-upload') }}</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aia-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('unisharp.lfm.upload') }}" role='form' id='uploadForm'
                                    name='uploadForm' method='post' enctype='multipart/form-data'
                                    class="dropzone">
                                    <div class="form-group" id="attachment">
                                        <div class="controls text-center">
                                            <div class="input-group w-100">
                                                <a class="btn btn-primary w-100 text-white"
                                                    id="upload-button">{{ trans('laravel-filemanager::lfm.message-choose') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <input type='hidden' name='working_dir' id='working_dir'>
                                    <input type='hidden' name='type' id='type' value="{{ request('type') }}">
                                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary w-100"
                                    data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="modal fade" id="notify" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary w-100"
                                    data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
                                <button type="button" class="btn btn-primary w-100"
                                    data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-confirm') }}</button>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary w-100"
                                    data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
                                <button type="button" class="btn btn-primary w-100"
                                    data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-confirm') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="carouselTemplate" class="d-none carousel slide bg-light" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#previewCarousel" data-slide-to="0" class="active"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a class="carousel-label"></a>
                            <div class="carousel-image"></div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#previewCarousel" role="button" data-slide="prev">
                        <div class="carousel-control-background" aria-hidden="true">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#previewCarousel" role="button" data-slide="next">
                        <div class="carousel-control-background" aria-hidden="true">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Modal content-->
    </div>
</div>
<!-- End Modal -->
{{-- footer section--}}
@include('footer')
{{-- End footer section--}}

{{-- <script src="{{ asset('public/vendor/laravel-filemanager/js/cropper.min.js') }}"></script>
<script src="{{ asset('public/vendor/laravel-filemanager/js/dropzone.min.js') }}"></script>
<script src="{{ asset('public/vendor/laravel-filemanager/js/script.js') }}"></script> --}}
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
{{-- <script type="text/javascript">

    var lang = {!! json_encode(trans('laravel-filemanager::lfm')) !!};

    var actions = [
        {
            name: 'rename',
            icon: 'edit',
            label: lang['menu-rename'],
            multiple: false
        },
        {
            name: 'download',
            icon: 'download',
            label: lang['menu-download'],
            multiple: true
        },
        {
            name: 'move',
            icon: 'paste',
            label: lang['menu-move'],
            multiple: true
        },
        {
            name: 'resize',
            icon: 'arrows-alt',
            label: lang['menu-resize'],
            multiple: false
        },
        {
            name: 'crop',
            icon: 'crop',
            label: lang['menu-crop'],
            multiple: false
        },
        {
            name: 'trash',
            icon: 'trash',
            label: lang['menu-delete'],
            multiple: true
        },
    ];

    var sortings = [{
            by: 'alphabetic',
            icon: 'sort-alpha-down',
            label: lang['nav-sort-alphabetic']
        },
        {
            by: 'time',
            icon: 'sort-numeric-down',
            label: lang['nav-sort-time']
        }
    ];


    // Function for Get Image URL
    var modalToSelectedFilePath = "";
    var gallary1 ='';
    function getImageUrl(url)
    {
        modalToSelectedFilePath = url;
    }


    // Close Popup Modal
    function closePopupAndSetPath(imageId)
    {
        var v=$('#test').attr('imageId');
        jQuery("#myModal").modal('hide');
        jQuery('#thumb' + v).attr("src",modalToSelectedFilePath);
    }


    // Show Popup Modal
    function showmodal(gallary)
    {
        $("#myModal").modal('show');
       var gallary1=gallary;
        $('#test').attr('imageId',gallary1);
    }


    Dropzone.options.uploadForm = {
        paramName: "upload[]", // The name that will be used to transfer the file
        uploadMultiple: false,
        parallelUploads: 5,
        timeout: 0,
        clickable: '#upload-button',
        dictDefaultMessage: lang['message-drop'],
        init: function() {
            var _this = this; // For the closure
            this.on('success', function(file, response) {
                if (response == 'OK') {
                    loadFolders();
                } else {
                    this.defaultOptions.error(file, response.join('\n'));
                }
            });
        },
        headers: {
            'Authorization': 'Bearer ' + getUrlParam('token')
        },
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
        maxFilesize: 1,
    }


    // Add New Image
    var gallary = $('#img_count').val();
    function addGallary()
    {
        var html = '';
        html += '<div class="demo_'+gallary+' col-md-3 mt-3">';
        html += '<div class="image" style="position: relative;display:inline-block;border: 2px solid black;overflow:hidden;">';

        html += '<a onclick="$(\'.demo_'+gallary+'\').remove();" class="removeImg m-1">';
        html += '<i class="fa fa-times"></i>';
        html += '</a>';

        html += '<div id="div'+gallary+'" style="width: 100px;"></div>';

        html += '<div class="imageOverlay">';
        html += '<img class="w-100" src="{{ asset("public/admin/no_image.jpg") }}" id="thumb'+gallary+'" />';
        html += '<span></span>';
        html += '</div>';

        html += '<input type="hidden" name="image['+gallary+'][img]" value="" id="image_'+gallary+'"/>';

        html += '<a class="browse_image img-de" onclick="showmodal('+gallary+');">Browse</a>';
        html += '<textarea name="image['+gallary+'][desc]" placeholder="Image Description" class="form-control"></textarea>';

        html += '</div>';
        html += '</div>';

        gallary ++;

        $('#gallryappend').append(html);
    }


    $('#test').on('click',function()
    {
       var image_id = $(this).attr('imageid');

       var image_url = $('#thumb'+image_id).attr('src');

       var new_url = String(image_url).replace('/thumbs','');

       $('#image_'+image_id).val('');
       $('#image_'+image_id).val(new_url);

    });

</script> --}}

<script>
     $('#lfm').filemanager('file');
    var route_prefix = "uploadgallary";
    $('#lfm').filemanager('image', {prefix: route_prefix});
</script>
