@include('header')


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

<link rel="shortcut icon" type="image/png" href="{{ asset('public/vendor/laravel-filemanager/img/72px color.png') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/cropper.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/mime-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/lfm.css') }}">
<style>
    .img-de {
        padding: 10px;
        background-color: #3ca2b8;
        color: #fff !important;
        border-radius: 5px;
        position: absolute;
        top: 30%;
        left: -100%;
        text-align: center;
        transition: all ease-in-out .4s;
    }

    .image:hover .img-de {
        left: 0;
        right: 0;
        margin: 0 auto;
        width: 100px
    }

    .removeImg {
        background-color: #3ca2b8;
        padding: 0px 5px;
        border-radius: 5px;
        color: #fff !important;
        position: absolute;
        top: 0;
        right: 0;
    }

</style>
{{-- Use the line below instead of the above if you need to cache the css. --}}
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/lfm.css') }}">


{{-- Section of List Customers --}}
<section>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa fa-image"></i>Photo Gallery</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Gallery</li>
                        </ol>
                    </div>
                    <div class="container" style="text-align: right; padding:30px">
                        @if (check_user_role(72) == 1)
                            <button type="submit" form="form" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> UPDATE</button>
                        @else
                            <button class="btn btn-sm btn-primary" disabled><i class="fa fa-save"></i> UPDATE</button>
                        @endif
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>


        {{-- End Header Section --}}
        @php

            $current_store = currentStoreId();
            $user_details = user_details();

            if(isset($user_details))
            {
                $user_group_id = $user_details['user_group_id'];
            }

            $user_shop_id = $user_details['user_shop'];

            if($user_group_id == 1)
            {
                $image=getimage($current_store);
            }
            else
            {
                $image=getimage($user_shop_id);
            }

        @endphp
        <div class="content">
            <div class="conatiner-fluid">
                <div class="row" style="margin:0">
                    <div class="col-md-12">
                        @php
                            $galary_count = count($image);
                            $image_count = isset($galary_count) ? $galary_count+1 : 1;
                        @endphp
                        <form action="{{ route('storeGallary') }}" id="form" method="post" enctype="multipart-form/data" >
                            <input type="hidden" name="img_count" id="img_count" value="{{ $image_count }}">
                            @csrf
                            <div class="row m-4"  id="gallryappend">
                                @if (isset($image))
                                    @foreach ($image as $images)
                                        <div class="demo_{{ $loop->iteration }} col-md-3 mt-3">
                                            <div class="image" style="position: relative;display:inline-block;border: 2px solid black;overflow:hidden;">

                                                <a onclick="$('.demo_{{ $loop->iteration }}').remove();" class="removeImg m-1">
                                                    <i class="fa fa-times" data-id="{{ $images->image_id }}"></i>
                                                </a>

                                                <div id="div{{ $loop->iteration }}" style="width: 100px;"></div>

                                                <div class="imageOverlay">
                                                    @if (!empty($images->image))
                                                        <img class="w-100" src="{{ $images->image }}" id="thumb{{ $loop->iteration }}"/>
                                                    @else
                                                        <img class="w-100" src="{{ asset('public/admin/no_image.jpg') }}" id="thumb{{ $loop->iteration }}" />
                                                    @endif
                                                    <span></span>
                                                </div>

                                                <input type="hidden" name="image[{{ $loop->iteration }}][img]" value="{{ $images->image }}" id="image_{{ $loop->iteration }}"/>

                                                <a class="browse_image img-de" onclick="showmodal({{ $loop->iteration }});">Browse</a>

                                                <textarea name="image[{{ $loop->iteration }}][desc]" placeholder="Image Description" class="form-control">{{ $images->description }}</textarea>

                                            </div>
                                        </div>
                                    @endforeach
                               @else
                                    <h3 class="text-center">Images Not Avavilable</h3>
                               @endif
                            </div>
                        </form>

                        <div class="addImage mb-2 mt-2" align="center">
                            @if (check_user_role(70) == 1)
                                <button type="button" onclick="addGallary();" class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i> ADD NEW
                                </button>
                            @else
                                <button type="button" class="btn btn-primary" disabled>
                                    <i class="fa fa-plus-circle"></i> ADD NEW
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                            <span
                                class="d-none d-lg-inline">{{ trans('laravel-filemanager::lfm.menu-multiple') }}</span>
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
                    <div id="tree"></div>

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
                                    <input type='hidden' name='type' id='type' value='{{ request('type') }}'>
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

                <div class="modal fade" id="notify" tabindex="-1" role="dialog" aria-hidden="true">
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
                </div>

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
            {{-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> --}}
        </div>

    </div>
</div>

@include('footer')


<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('public/vendor/laravel-filemanager/js/cropper.min.js') }}"></script>
<script src="{{ asset('public/vendor/laravel-filemanager/js/dropzone.min.js') }}"></script>
<script>
    var lang = {!! json_encode(trans('laravel-filemanager::lfm')) !!};
    var actions = [
        // {
        //   name: 'use',
        //   icon: 'check',
        //   label: 'Confirm',
        //   multiple: true
        // },
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
        // {
        //   name: 'preview',
        //   icon: 'image',
        //   label: lang['menu-view'],
        //   multiple: true
        // },
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
</script>
<script src="{{ asset('public/vendor/laravel-filemanager/js/script.js') }}"></script>
<script>

</script>
{{-- Use the line below instead of the above if you need to cache the script. --}}
{{-- <script src="{{ asset('public/vendor/laravel-filemanager/js/script.js') }}"></script> --}}
<script>

    var modalToSelectedFilePath = "";
    var gallary1 ='';
    function getImageUrl(url)
    {
        modalToSelectedFilePath = url;
    }

    function closePopupAndSetPath(imageId) {
        var v=$('#test').attr('imageId');
        //  alert(v);
        jQuery("#myModal").modal('hide');
        // $(".modal-backdrop").attr("style", "display:none;");
        // jQuery("#thumb").attr("src", modalToSelectedFilePath);
        jQuery('#thumb' + v).attr("src",modalToSelectedFilePath);
    }

    function showmodal(gallary){
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
        acceptedFiles: "{{ implode(',', $helper->availableMimeTypes()) }}",
        maxFilesize: ({{ $helper->maxUploadSize() }} / 1000)
    }


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

</script>

