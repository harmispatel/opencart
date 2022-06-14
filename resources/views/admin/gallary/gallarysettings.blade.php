<!--
    THIS IS GAKKARY SETTINGS PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    gallarysettings.blade.php
    it is used for gallary settings like enable-disable, background option etc. for frontend.
    ----------------------------------------------------------------------------------------------
-->


<!-- Header Section -->
@include('header')
<!-- End Header Section -->

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


<!-- Section of List Gallary Setting -->
<section>
    <div class="content-wrapper">
        <!-- Breadcumb Section -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa fa-image"></i> Gallery Settings</h1>
                    </div>
                    <!-- Breadcrumb Start -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Gallary Setting </li>
                        </ol>
                    </div>
                    <!-- End Breadcumb -->
                </div>
            </div>
        </section>
        <!-- End Breadcumb Section -->

        <!-- List Section Start -->
        <section class="content">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <!-- Card -->
                        <div class="card ">
                            <form action="{{ route('gallarysettingsstore') }}" method="post" id="form" enctype="multipart/form-data">
                                @csrf
                                <div id="tab-general">
                                    <table class="table form w-100 table-striped">
                                        <tbody>
                                            @php
                                                $current_store_id = currentStoreId();

                                                $user_details = user_details();

                                                if(isset($user_details))
                                                {
                                                    $user_group_id = $user_details['user_group_id'];
                                                }
                                                $user_shop_id = $user_details['user_shop'];

                                                if($user_group_id== 1)
                                                {
                                                    $enable_gallery_module=getphoto($current_store_id,'enable_gallery_module');
                                                    $enable_home_gallery=getphoto($current_store_id,'enable_home_gallery');
                                                    $gallery_background_options=getphoto($current_store_id,'gallery_background_options');
                                                    $gallery_header_text=getphoto($current_store_id,'gallery_header_text');
                                                    $gallery_header_desc=getphoto($current_store_id,'gallery_header_desc');
                                                    $gallery_background_color=getphoto($current_store_id,'gallery_background_color');
                                                    $gallery_background_image=getphoto($current_store_id,'gallery_background_image');
                                                }
                                                else
                                                {
                                                    $enable_gallery_module=getphoto($user_shop_id,'enable_gallery_module');
                                                    $enable_home_gallery=getphoto($user_shop_id,'enable_home_gallery');
                                                    $gallery_background_options=getphoto($user_shop_id,'gallery_background_options');
                                                    $gallery_header_text=getphoto($user_shop_id,'gallery_header_text');
                                                    $gallery_header_desc=getphoto($user_shop_id,'gallery_header_desc');
                                                    $gallery_background_color=getphoto($user_shop_id,'gallery_background_color');
                                                    $gallery_background_image=getphoto($user_shop_id,'gallery_background_image');
                                                }
                                            @endphp
                                            <tr>
                                                <td width="250">Gallery Module</td>
                                                <td>
                                                    <input type="radio" value="1" name="enable_gallery_module" {{ ($enable_gallery_module == 1) ? 'checked' : '' }}> Enable
                                                    <input type="radio" value="0" name="enable_gallery_module" {{ ($enable_gallery_module  == 0) ? 'checked' : '' }}> Disable
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Home Page</td>
                                                <td>
                                                    <input type="radio" value="1" name="enable_home_gallery" {{ ($enable_home_gallery == 1) ? 'checked' : ''  }}> Enable
                                                    <input type="radio" value="0" name="enable_home_gallery" {{ ($enable_home_gallery == 0) ? 'checked' : ''  }}> Disable
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Background Options</td>
                                                <td>
                                                    <input type="radio" name="gallery_background_options"
                                                        value="transparent"  onclick="getgallary();"{{ $gallery_background_options == 'transparent' ? 'checked' : '' }}>
                                                    <label class="gal-bg-radio mr-3"> Transparent</label>
                                                    <input type="radio" name="gallery_background_options" value="color"
                                                        onclick="getgallary();" {{ $gallery_background_options == 'color' ? 'checked' : '' }}>
                                                    <label class="gal-bg-radio mr-3"> Color</label>
                                                    <input type="radio" name="gallery_background_options" value="image"
                                                        onclick="getgallary();" {{ $gallery_background_options == 'image' ? 'checked' : '' }} >
                                                    <label class="gal-bg-radio mr-3"> Image</label>
                                                </td>
                                            </tr>
                                            <tr width="250" id="color" style="display: none">
                                                <td width="250">Background Color</td>
                                                <td>
                                                    <input type="color"  name="gallery_background_color" class="form-control" value="{{ $gallery_background_color  }}">
                                                </td>
                                            </tr>
                                            <tr id="image" style="display: none">
                                                <td width="250">Background Image</td>
                                                <td>
                                                    <input type="file"  name="gallery_background_image" class="form-control p-1">
                                                    <img src="{{asset('public/admin/product/'.$gallery_background_image)}}" alt="" width="100px"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Header Text</td>
                                                <td>
                                                    <input type="text" class="form-control" value="{{ $gallery_header_text }}" name="gallery_header_text">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Header Description</td>
                                                <td>
                                                    <textarea name="gallery_header_desc" class="form-control" rows="3" cols="40">{{ $gallery_header_desc }}</textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    @if (check_user_role(69) == 1)
                                                        <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i>Update</button>
                                                    @else
                                                        <button type="submit" name="submit" class="btn btn-success" disabled><i class="fa fa-save"></i>Update</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <!-- End Card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Form Section -->
    </div>
</section>
<!-- End Section of List Gallary Setting -->


<!-- Footer Section -->
@include('footer')
<!-- End Footer Section -->

<!-- SCRIPT -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

     // Gallary  Radio Button OnClick
    $(document).ready(function()
    {
        var data = $('input[name=gallery_background_options]:checked').val();

        if (data == 'transparent')
        {
            $('#image').hide();
            $('#color').hide();
        }
        else if (data == 'color')
        {
            $('#color').show();
            $('#image').hide();
        }
        else if (data == 'image')
        {
            $('#image').show();
            $('#color').hide();
        }
    });

    // Gallary Settings
    function getgallary()
    {
        var data1 = $('input[name=gallery_background_options]:checked').val();

        var html = '';
        if (data1 == 'transparent')
        {
            $("#text").html('');
        }
        else if (data1 == 'color')
        {
            $("#text").html('');
        }
        else if (data1 == 'image')
        {
            $("#text").html('');
        }

        if (data1 == 'transparent')
        {
            $('#image').hide();
            $('#color').hide();
        }
        else if (data1 == 'color')
        {
            $('#color').show();
            $('#image').hide();
        }
        else if (data1 == 'image')
        {
            $('#image').show();
            $('#color').hide();
        }

    }
    // End Gallary Settings

</script>
<!-- END SCRIPT -->
