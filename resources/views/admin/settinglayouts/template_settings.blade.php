@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/css/customradio.css') }}">

{{-- Custom CSS --}}
<style>
    [data-toggle="collapse"] .fa:before
    {
        content: "\f13a";
    }

    [data-toggle="collapse"].collapsed .fa:before
    {
        content: "\f139";
    }
</style>
{{-- End Custom CSS --}}

{{-- Section of List Template Setting --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Template Setting</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Template Setting </li>
                        </ol>
                    </div>
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
                        <div class="container">
                            <h4 class="card-title pt-2" style="font-size: 22px;">Themes</h4>
                            <div class="container" style="text-align: right;">
                                <button type="submit" form="templateSetting" class="btn btn-success">
                                    <i class="fa fa-save"></i> UPDATE
                                </button>
                            </div>
                            <hr>
                            <div class="row">
                                @if (isset($themes))
                                    @foreach ($themes as $theme)
                                        <div class="col-md-4 mt-1 mb-3">
                                            <div class="card h-100" style="border: 1px solid black;">
                                                <div class="card-header bg-dark text-center pt-1 pb-0">
                                                    <h3>{{ $theme->theme_name }}</h3>
                                                </div>
                                                <div class="card-body">
                                                    <img src="{{ asset('public/admin/theme_view/'.$theme->theme_image) }}" class="w-100">
                                                </div>
                                                <div class="card-footer bg-dark">
                                                    @php
                                                        $theme_active = themeActive();
                                                    @endphp

                                                    @if($theme->theme_id == $theme_active)
                                                        <button type="button" class="btn btn-secondary w-100" disabled>ACTIVATED &nbsp;<i class="fa fa-check-circle"></i></button>
                                                    @else
                                                        <a href="{{ route('activetheme',$theme->theme_id) }}" class="btn btn-success w-100">ACTIVE</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <hr>

                            {{-- Form --}}
                            <form action="{{ route('updateTemplateSetting') }}" method="POST" id="templateSetting" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                {{-- TOPBAR SETTINGS --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        NAVBAR
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll" aria-expanded="true" aria-controls="coll">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse" id="coll">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Navbar Background</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_navbar_background" class="form-control" value="{{ $template_settings['polianna_navbar_background'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Navbar Link</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_navbar_link" class="form-control"  value="{{ $template_settings['polianna_navbar_link'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Logo</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_main_logo" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_main_logo']))
                                                                                <img src="{{ $template_settings['polianna_main_logo'] }}" width="100" height="100" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Logo Width & Height (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <label>Width</label>
                                                                            <input type="number" name="polianna_main_logo_width" class="form-control"  value="{{ $template_settings['polianna_main_logo_width'] }}"><br>
                                                                            <label>Height</label>
                                                                            <input type="number" name="polianna_main_logo_height" class="form-control"  value="{{ $template_settings['polianna_main_logo_height'] }}">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End Card Body --}}
                                                </div>
                                            </div>
                                            {{-- End Card --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- END TOPBAR SETTINGS --}}

                                {{-- SLIDER SETTINGS --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        SLIDER
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll1" aria-expanded="true" aria-controls="coll1">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse" id="coll1">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Sliders Permission</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="form-control">
                                                                                <label for="polianna_slider_permission1">ON</label>
                                                                                <input type="radio" name="polianna_slider_permission" id="polianna_slider_permission1" value="1" {{ ($template_settings['polianna_slider_permission'] == 1) ? 'checked' : '' }}>
                                                                                <label for="polianna_slider_permission2" class="ml-2">OFF</label>
                                                                                <input type="radio" name="polianna_slider_permission" id="polianna_slider_permission2" value="0" {{ ($template_settings['polianna_slider_permission'] == 0) ? 'checked' : '' }}>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Slider 1</label>
                                                                        </th>
                                                                        <td>
                                                                            <label>Image</label>
                                                                            <input type="file" name="polianna_slider_1" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_slider_1']))
                                                                                <img src="{{ $template_settings['polianna_slider_1'] }}" width="100" height="100" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                            <hr>
                                                                            <label>Title</label>
                                                                            <input type="text" name="polianna_slider_1_title" class="form-control" value="{{ $template_settings['polianna_slider_1_title'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Slider 2</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_slider_2" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_slider_2']))
                                                                                <img src="{{ $template_settings['polianna_slider_2'] }}" width="100" height="100" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                            <hr>
                                                                            <label>Title</label>
                                                                            <input type="text" name="polianna_slider_2_title" class="form-control"  value="{{ $template_settings['polianna_slider_2_title'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Slider 3</label>
                                                                        </th>
                                                                        <td>
                                                                            <label>Image</label>
                                                                            <input type="file" name="polianna_slider_3" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_slider_3']))
                                                                                <img src="{{ $template_settings['polianna_slider_3'] }}" width="100" height="100" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                            <hr>
                                                                            <label>Title</label>
                                                                            <input type="text" name="polianna_slider_3_title" class="form-control"  value="{{ $template_settings['polianna_slider_3_title'] }}">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End Card Body --}}
                                                </div>
                                            </div>
                                            {{-- End Card --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- END SLIDER SETTINGS --}}

                                {{-- PERMISSION SETTINGS  --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        PERMISSIONS
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll2" aria-expanded="true" aria-controls="coll2">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse show" id="coll2">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Online Order Searchbar</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="form-control">
                                                                                <label for="polianna_online_order_permission1">ON</label>
                                                                                <input type="radio" name="polianna_online_order_permission" id="polianna_online_order_permission1" value="1" {{ ($template_settings['polianna_online_order_permission'] == 1) ? 'checked' : '' }}>
                                                                                <label for="polianna_online_order_permission2" class="ml-2">OFF</label>
                                                                                <input type="radio" name="polianna_online_order_permission" id="polianna_online_order_permission2" value="0" {{ ($template_settings['polianna_online_order_permission'] == 0) ? 'checked' : '' }}>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End Card Body --}}
                                                </div>
                                            </div>
                                            {{-- End Card --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- END PERMISSION SETTINGS --}}

                            </form>
                            {{-- End Form --}}

                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Template Setting --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

// $(document).ready(function() {
//     $('#transaction').DataTable();
// } );

// Date Range Picker
$(function() {
    $('input[name="daterange"]').daterangepicker();
});


</script>
