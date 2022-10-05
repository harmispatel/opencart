{{--
    THIS IS HEADER UploadGallary PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    upload_gallary.blade.php
    This for Edit UploadGallary
    ----------------------------------------------------------------------------------------------
--}}


{{-- Header --}}
@include('header')
{{-- End  Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- <link rel="shortcut icon" type="image/png" href="{{ asset('public/vendor/laravel-filemanager/img/72px color.png') }}"> --}}
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/cropper.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/mime-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendor/laravel-filemanager/css/lfm.css') }}">

{{-- Custom CSS --}}
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
{{-- End Custom CSS --}}

{{-- Section of List Gallary --}}
<section>
    <div class="content-wrapper">
        {{-- Breadcumb Section --}}
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
        {{-- End Breadcumb Section --}}

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

        {{-- List Section Start --}}
        <section class="content">
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
                                    @if (isset($image) && count($image) > 0)
                                        @foreach ($image as $images)
                                            <div class="demo_{{ $loop->iteration }} col-md-3 mt-3">
                                                <div class="image w-100" style="position: relative;display:inline-block;border: 2px solid black;overflow:hidden;">

                                                    <a onclick="$('.demo_{{ $loop->iteration }}').remove();" class="removeImg m-1">
                                                        <i class="fa fa-times" data-id="{{ $images->image_id }}"></i>
                                                    </a>

                                                    <div id="div{{ $loop->iteration }}" style="width: 100px;"></div>

                                                    <div class="imageOverlay" id="gallaryholder_[{{ $loop->iteration }}]">
                                                        @if (!empty($images->image))
                                                            <img class="w-100" height="250px" src="{{ $images->image }}"/>
                                                        @else
                                                            <img class="w-100" src="{{ asset('public/admin/no_image.jpg') }}" id="thumb{{ $loop->iteration }}" />
                                                        @endif
                                                        <span></span>
                                                    </div>
                                                    <input type="hidden" name="image[{{ $loop->iteration }}][img]" id="gallerythumbnail_[{{ $loop->iteration }}]" value="{{ $images->image }}" id="image_{{ $loop->iteration }}"/>

                                                    <a class="browse_image img-de" id="gallaryimg_[{{ $loop->iteration }}]" data-input="gallerythumbnail_[{{ $loop->iteration }}]" data-preview="gallaryholder_[{{ $loop->iteration }}]" onclick="setimage(this)">Browse</a>
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
        </section>
        {{-- End List Section --}}

    </div>
</section>
{{-- End Section of List Users --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

<script>
    // Add New Image
    var gallary = $('#img_count').val();
    function addGallary()
    {

        if (gallary == 1) {
            $('#gallryappend').html('')
        }
        var html = '';

        html+= '<div class="demo_'+ gallary +' col-md-3 mt-3">';
        html+= '<div class="image w-100" style="position: relative;display:inline-block;border: 2px solid black;overflow:hidden;">';
        html+= '<a onclick="$(\'.demo_'+gallary+'\').remove();" class="removeImg m-1">';
        html+= '<i class="fa fa-times"></i>';
        html+= '</a>';
        html+= '<div id="div'+ gallary +'" style="width: 100px;"></div>';
        html+= '<div class="imageOverlay" id="gallaryholder_['+ gallary +']">';
        html+= '<img class="w-100" height="250px" src="{{ asset("public/admin/no_image.jpg") }}"/>';
        html+= '</div>';
        html+= '<input type="hidden" name="image['+ gallary +'][img]" id="gallerythumbnail_['+ gallary +']" value=""/>';
        html+= '<a class="browse_image img-de" id="gallaryimg_['+ gallary +']" data-input="gallerythumbnail_['+ gallary +']" data-preview="gallaryholder_['+ gallary +']" onclick="setimage(this)">Browse</a>';
        html+= '<textarea name="image['+ gallary +'][desc]" placeholder="Image Description" class="form-control"></textarea>';
        html+= '</div>';
        html+= '</div>';

        gallary ++;

        $('#gallryappend').append(html);
    }
</script>

<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    var lfm = function(id, type, options) {
    let button = document.getElementById(id);

    // button.addEventListener('click', function() {
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
        // target_preview.innerHtml = '';
        $(target_preview).html('');

        // set or change the preview image src
        items.forEach(function(item) {
            let img = document.createElement('img')
            img.setAttribute('style', 'height : 250px')
            img.setAttribute('width', '100%')
            img.setAttribute('src', item.thumb_url)
            target_preview.appendChild(img);
        });



        // height: 250px;
        // width: 100%;

        // trigger change event
        target_preview.dispatchEvent(new Event('change'));
    };
    // });
};

function setimage(val) {
    var id = $(val).attr("id");
    var route_prefix = "filemanager";
    $(id).filemanager('image', {
        prefix: route_prefix
    });
    lfm(id, 'file', {
        prefix: route_prefix
    });
}
</script>

