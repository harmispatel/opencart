@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Gallary Setting --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa fa-image"></i> Gallery Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Gallary Setting </li>
                        </ol>
                    </div>

                    {{-- <div class="container" style="text-align: right; padding:30px">
                        <button type="submit" form="form" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div> --}}
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
                        <div class="card ">
                            <form action="{{ route('gallarysettingsstore') }}" method="post" id="form">
                                @csrf
                                <div id="tab-general">
                                    <table class="table form w-100 table-striped">
                                        <tbody>
                                            <tr>
                                                <td width="250">Gallery Module</td>
                                                <td>
                                                    <input type="checkbox" value="1" class="en_switch"
                                                        name="enable_gallery_module"> Enable
                                                    <input type="checkbox" value="0" class="en_switch ml-3"
                                                        name="enable_gallery_module" checked> Disable
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Home Page</td>
                                                <td>
                                                    <input type="checkbox" value="1" class="en_switch"
                                                        name="enable_gallery_module1"> Enable
                                                    <input type="checkbox" value="0" class="en_switch ml-3"
                                                        name="enable_gallery_module1" checked> Disable
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Background Options</td>
                                                <td>
                                                    <input type="radio" name="gallery_background_options"
                                                        value="transparent" checked="checked" onclick="getgallary();">
                                                    <label class="gal-bg-radio mr-3"> Transparent</label>
                                                    <input type="radio" name="gallery_background_options" value="color"
                                                        onclick="getgallary();">
                                                    <label class="gal-bg-radio mr-3"> Color</label>
                                                    <input type="radio" name="gallery_background_options" value="image"
                                                        onclick="getgallary();">
                                                    <label class="gal-bg-radio mr-3"> Image</label>
                                                </td>
                                            </tr>
                                            <tr width="250" id="text">
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td width="250">Header Text</td>
                                                <td>
                                                    <input type="text" value="" name="gallery_header_text"
                                                        style="max-width: 40%; width: 40%">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="250">Header Description</td>
                                                <td>
                                                    <textarea name="gallery_header_desc" rows="3" cols="40"></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><button type="submit" name="submit" class="btn btn-primary"><i
                                                            class="fa fa-save"></i>Save</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Gallary Setting --}}
@include('footer')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function getgallary() {
        var data = $('input[name=gallery_background_options]:checked').val();

        var html = '';
        if (data == 'transparent') {
            $("#text").html('');

        } else if (data == 'color') {
            $("#text").html('');
        } else if (data == 'image') {
            $("#text").html('');
        }

        if (data == 'transparent') {
            html += '<td></td>';
        } else if (data == 'color') {
            html +=
                '<td width="250">Background Color</td><td><input type="color" name="gallary[name]" style="width:40%"class="form-control"></td>';
        } else if (data == 'image') {
            html +=
                '<td width="250">Background Image</td><td><input type="file" name="gallary[image]" style="width:40%"class="form-control"></td>';
        }
        $("#text").append(html);
    }
</script>
