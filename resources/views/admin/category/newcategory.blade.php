<!--
    THIS IS HEADER newcategory PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    newcategory.blade.php
    Its Used for Insert New Category
    ----------------------------------------------------------------------------------------------
-->


{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('category') }}">Categories</a></li>
                            </a>
                            <li class="breadcrumb-item active">Insert</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Insert Data Section --}}
        <section class="content">
            <div class="conatiner-fluid">
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
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('categoryinsert') }}" id="catform" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('category') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="category" class="form-label"> <b class="text-danger">*</b> Category Name</label>
                                        <input type="text" name="category" class="form-control {{ ($errors->has('category')) ? 'is-invalid' : '' }}" id="category" placeholder="Category Name" value="{{ old('category') }}">
                                        @if ($errors->has('category'))
                                            <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="days" class="form-label">Days Available</label><br>
                                        <div class="p-2 rounded" style="border: 1px solid rgb(197, 197, 197)">
                                            <input type="checkbox" id="inlineCheckbox1" value="0" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox1">Sunday</label>

                                            <input type="checkbox" id="inlineCheckbox2" value="1" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox2">Monday</label>

                                            <input type="checkbox" id="inlineCheckbox3" value="2" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox3">Tuesday</label>

                                            <input type="checkbox" id="inlineCheckbox4" value="3" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox4">Wedensday</label>

                                            <input type="checkbox" id="inlineCheckbox5" value="4" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox5">Thursday</label>

                                            <input type="checkbox" id="inlineCheckbox6" value="5" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox6">Friday</label>

                                            <input type="checkbox" id="inlineCheckbox7" value="6" name="availibleday[]" checked>
                                            <label class="form-check-label pr-3" for="inlineCheckbox7">Saturday</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="summernote" class="form-label">Description</label>
                                        <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="image" class="form-label">Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                              </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="image">
                                          </div>
                                          <img id="holder" style="margin-top:15px;max-height:100px;">
                                    </div>

                                    <div class="form-group">
                                        <label for="banner">Banner</label>
                                        {{-- <input type="file" name="banner" style="padding:3px;" id="banner" class="form-control">
                                        <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" style="padding:3px;" name="banner" id="banner" type="file">
                                        @if ($errors->has('banner'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('banner') }}
                                            </div>
                                        @endif --}}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail2" class="form-control" type="text" name="banner">
                                        </div>
                                         <div id="holder2"  style="margin-top:15px;max-height:100px;"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sortorder" class="form-label"><b class="text-danger">*</b>Sort Order</label>
                                        <input type="text" class="form-control {{ ($errors->has('sortorder')) ? 'is-invalid' : '' }}" name="sortorder" id="sortorder" value="{{ old('sortorder') }}">
                                        @if ($errors->has('sortorder'))
                                            <div class="invalid-feedback">{{ $errors->first('sortorder') }}</div>
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
        {{-- End Insert Data Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>

<script>
    $('#lfm').filemanager('file');
   var route_prefix = "filemanager";
   $('#lfm').filemanager('image', {prefix: route_prefix});
</script>
<script>
    var lfm = function(id, type, options) {
        let button = document.getElementById(id);

        button.addEventListener('click', function() {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var target_input = document.getElementById(button.getAttribute('data-input'));
            var target_preview = document.getElementById(button.getAttribute('data-preview'));

            window.open(route_prefix + '?type=' + 'image' || 'file', 'FileManager',
                'width=900,height=600');
            window.SetUrl = function(items) {
                var file_path = items.map(function(item) {
                    return item.url;
                }).join(',');

                // set the value of the desired input to image url
                target_input.value = file_path;
                target_input.dispatchEvent(new Event('change'));

                // clear previous preview
                target_preview.innerHtml = '';

                // set or change the preview image src
                items.forEach(function(item) {
                    let img = document.createElement('img')
                    img.setAttribute('style', 'display : none')
                    img.setAttribute('src', item.thumb_url)
                    target_preview.appendChild(img);
                });

                // trigger change event
                target_preview.dispatchEvent(new Event('change'));
            };
        });
    };

    lfm('lfm2', 'file', {
        prefix: route_prefix
    });
    lfm('lfm3', 'image', {
        prefix: route_prefix
    });
</script>
