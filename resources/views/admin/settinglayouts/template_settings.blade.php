{{--
    THIS IS TEMPLATE(THEME) SETTING FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    template_settings.blade.php
    It Displayed All Template(Theme) List & Storewise Display Template(Theme)
    ----------------------------------------------------------------------------------------------
--}}

{{-- PHP CODE --}}
@php
// Get all Fonts
$fonts = getFonts();

// Get Current Active Header
$header_data = headerActive();

// Get Current Active Slider
$slider_data = sliderActive();

// Get Current Active HTML Layout
// $about_data = aboutActive();

// Get Current Active Popular Food Layout
$popularfood_data = popularfoodActive();

// Get Current Active Best Category Layout
$bestcategory_data = bestcategoryActive();

// Get Current Active Recent Reviews Layout
$review_data = recentreviewActive();

// Get Current Active Reservation Layout
$reservation_data = reservationActive();

// Get Current Active Gallary Layout
$gallary_data = gallaryActive();

// Get Current Footer
$footer_data = footerActive();

// Get Current OpenHour
$openhour_data = openhoursActive();

@endphp
{{-- END PHP CODE --}}

{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/css/customradio.css') }}">

{{-- Custom CSS --}}
<style>
    [data-toggle="collapse"] .fa:before {
        content: "\f13a";
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f139";
    }

    .fix-bt{
        position:fixed;
        bottom:30px;
        right:40px;
        z-index: 9;
    }
</style>
{{-- End Custom CSS --}}

{{-- Section of List Template Setting --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if (Session::has('success'))
                    <div class="alert alert-success d-flex del-alert alert-dismissible" id="alert" role="alert">
                        <i class="fa fa-check-circle mt-1"></i>
                        <div class="ml-2">
                            {{ Session::get('success') }}
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger d-flex  del-alert alert-dismissible" id="alert" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                            role="img" aria-label="Warning:">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <div class="ml-2">
                            Errors : Please Check Form Carefully !!
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fa fa-cog fw"></i> Template Setting</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Template Setting</li>
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

                <hr class="bg-dark" style="height: 2px;">
                <div class="row">
                    <div class="col-md-6">
                        @if (check_user_role(74) == 1)
                            <a onclick="backgroundOption(this)" class="btn btn-primary fix-bt">
                                <i class="fa fa-save"></i> UPDATE
                            </a>
                        @else
                            <a class="btn btn-success fix-bt" disabled>
                                <i class="fa fa-save"></i> UPDATE
                            </a>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mt-2" style="font-size: 16px;"><i class="fa fa-copy"></i>&nbsp; Copy Template From</p>
                            </div>
                            <div class="col-md-8">
                                <select name="copytemplatesettings" id="copytemplatesettings" class="form-control">
                                    <option value="">Select Store to Copy Settings</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->store_id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('updateTemplateSetting') }}" id="templateSetting" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}

                    {{-- General Settings --}}
                    <hr class="bg-dark" style="height: 2px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        General Settings
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll1" aria-expanded="true" aria-controls="coll1">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>General Site Fonts</label>
                                                        </th>
                                                        <td>
                                                            <select name="general[general_site_fonts]"
                                                                class="form-control">
                                                                @php
                                                                    $general_site_fonts = isset($general_settings['general_site_fonts']) ? $general_settings['general_site_fonts'] : '';
                                                                @endphp
                                                                @foreach ($fonts as $key => $font)
                                                                    <option value="{{ $font }}"
                                                                        style="font-family: {{ $font }};"
                                                                        {{ $general_site_fonts == $font ? 'selected' : '' }}>
                                                                        {{ $key }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Module Title Fonts</label>
                                                        </th>
                                                        <td>
                                                            <select name="general[general_module_title_fonts]"
                                                                class="form-control">
                                                                @php
                                                                    $general_module_title_fonts = isset($general_settings['general_module_title_fonts']) ? $general_settings['general_module_title_fonts'] : '';
                                                                @endphp
                                                                @foreach ($fonts as $key => $font)
                                                                    <option value="{{ $font }}"
                                                                        style="font-family: {{ $font }};"
                                                                        {{ $general_module_title_fonts == $font ? 'selected' : '' }}>
                                                                        {{ $key }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Buttons Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="general[general_buttons_color]"
                                                                value="{{ isset($general_settings['general_buttons_color']) ? $general_settings['general_buttons_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Buttons Fonts Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="general[general_buttons_fonts_color]"
                                                                class="form-control"
                                                                value="{{ isset($general_settings['general_buttons_fonts_color']) ? $general_settings['general_buttons_fonts_color'] : '' }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Buttons Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="general[general_buttons_hover_color]"
                                                                class="form-control"
                                                                value="{{ isset($general_settings['general_buttons_hover_color']) ? $general_settings['general_buttons_hover_color'] : '' }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Buttons Fonts Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="general[general_buttons_fonts_hover_color]"
                                                                class="form-control"
                                                                value="{{ isset($general_settings['general_buttons_fonts_hover_color']) ? $general_settings['general_buttons_fonts_hover_color'] : '' }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Copyright &copy;</label>
                                                        </th>
                                                        <td>
                                                            <input type="text" name="general[general_copyright_text]" class="form-control" value="{{ isset($general_settings['general_copyright_text']) ? $general_settings['general_copyright_text'] : '' }}">
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End General Settings --}}


                    {{-- Header Options --}}
                    @php
                        $header_id = isset($header_data['header_id']) ? $header_data['header_id'] : '';
                        $get_header_settings = getLayouts('header_settings', $header_id, 'header_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Header Options
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll2" aria-expanded="true" aria-controls="coll2">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Select Header Layout</label>
                                                        </th>
                                                        <td>
                                                            <select name="header_setting[header_layout_id]" onchange="changeActiveHeader()" class="form-control" id="header_layout">
                                                                    <option value=""> - Select Header - </option>
                                                                @foreach ($headers as $header)
                                                                    <option value="{{ $header->header_id }}"
                                                                        {{ $header->header_id == $header_id ? 'selected' : '' }}>
                                                                        {{ $header->header_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="header-preview" class="bg-light">
                                                            @php
                                                                $header_image = isset($header_data['header_image']) ? $header_data['header_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/header_view/' . $header_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Menu Background Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="header_setting[menu_background_color]"
                                                                value="{{ isset($get_header_settings['menu_background_color']) ? $get_header_settings['menu_background_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Menu Text Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="header_setting[menu_text_color]"
                                                                value="{{ isset($get_header_settings['menu_text_color']) ? $get_header_settings['menu_text_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Menu Button Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="header_setting[menu_button_color]"
                                                                value="{{ isset($get_header_settings['menu_button_color']) ? $get_header_settings['menu_button_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Menu Button Text Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="header_setting[menu_button_text_color]"
                                                                value="{{ isset($get_header_settings['menu_button_text_color']) ? $get_header_settings['menu_button_text_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Top Bar Left</label>
                                                        </th>
                                                        <td>
                                                            <select name="header_setting[menu_topbar_left]"
                                                                class="form-control">
                                                                @php
                                                                    $menu_topbar_left = isset($get_header_settings['menu_topbar_left']) ? $get_header_settings['menu_topbar_left'] : '';
                                                                @endphp

                                                                @if ($header_id == 1 || $header_id == 2 || $header_id == 3 || $header_id == 4 || $header_id == 5)
                                                                    <option value="opening_times"
                                                                    {{ $menu_topbar_left == 'opening_times' ? 'selected' : '' }}>
                                                                    Opening Times</option>
                                                                @endif

                                                                @if ($header_id == 1 || $header_id == 4)
                                                                    <option value="social_media_links" {{ $menu_topbar_left == 'social_media_links' ? 'selected' : '' }}> Social Media Links</option>
                                                                @endif

                                                                @if ($header_id == 1 || $header_id == 3 || $header_id == 5 || $header_id == 6)
                                                                    <option value="customer_login" {{ $menu_topbar_left == 'customer_login' ? 'selected' : '' }}> Customer Login</option>
                                                                @endif

                                                                @if ($header_id == 2 || $header_id == 4)
                                                                    <option value="open_close_image" {{ $menu_topbar_left == 'open_close_image' ? 'selected' : '' }}> Open/Close Banner</option>
                                                                @endif

                                                                @if ($header_id == 2 || $header_id == 5)
                                                                    <option value="main_logo" {{ $menu_topbar_left == 'main_logo' ? 'selected' : '' }}> Logo</option>
                                                                @endif

                                                                @if ($header_id == 3 || $header_id == 6)
                                                                    <option value="shopping_cart" {{ $menu_topbar_left == 'shopping_cart' ? 'selected' : '' }}> Shopping Cart</option>
                                                                @endif

                                                            </select>
                                                        </td>
                                                    </tr>

                                                    @if ($header_id != 6)
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label>Top Bar Center</label>
                                                            </th>
                                                            <td>
                                                                <select name="header_setting[menu_topbar_center]"
                                                                    class="form-control">
                                                                    @php
                                                                        $menu_topbar_center = isset($get_header_settings['menu_topbar_center']) ? $get_header_settings['menu_topbar_center'] : '';
                                                                    @endphp

                                                                    @if ($header_id == 1 || $header_id == 2 || $header_id == 3 || $header_id == 4 || $header_id == 5)
                                                                        <option value="opening_times"
                                                                        {{ $menu_topbar_left == 'opening_times' ? 'selected' : '' }}>
                                                                        Opening Times</option>
                                                                    @endif

                                                                    @if ($header_id == 1 || $header_id == 4)
                                                                        <option value="social_media_links" {{ $menu_topbar_center == 'social_media_links' ? 'selected' : '' }}> Social Media Links</option>
                                                                    @endif

                                                                    @if ($header_id == 1 || $header_id == 3 || $header_id == 5 || $header_id == 6)
                                                                        <option value="customer_login" {{ $menu_topbar_center == 'customer_login' ? 'selected' : '' }}> Customer Login</option>
                                                                    @endif

                                                                    @if ($header_id == 2 || $header_id == 4)
                                                                        <option value="open_close_image" {{ $menu_topbar_center == 'open_close_image' ? 'selected' : '' }}> Open/Close Banner</option>
                                                                    @endif

                                                                    @if ($header_id == 2 || $header_id == 5)
                                                                        <option value="main_logo" {{ $menu_topbar_center == 'main_logo' ? 'selected' : '' }}> Logo</option>
                                                                    @endif

                                                                    @if ($header_id == 3 || $header_id == 6)
                                                                        <option value="shopping_cart" {{ $menu_topbar_center == 'shopping_cart' ? 'selected' : '' }}> Shopping Cart</option>
                                                                    @endif
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Top Bar Right</label>
                                                        </th>
                                                        <td>
                                                            <select name="header_setting[menu_topbar_right]"
                                                                class="form-control">
                                                                @php
                                                                    $menu_topbar_right = isset($get_header_settings['menu_topbar_right']) ? $get_header_settings['menu_topbar_right'] : '';
                                                                @endphp

                                                                @if ($header_id == 1 || $header_id == 2 || $header_id == 3 || $header_id == 4 || $header_id == 5)
                                                                    <option value="opening_times"
                                                                    {{ $menu_topbar_right == 'opening_times' ? 'selected' : '' }}>
                                                                    Opening Times</option>
                                                                @endif

                                                                @if ($header_id == 1 || $header_id == 4)
                                                                    <option value="social_media_links" {{ $menu_topbar_right == 'social_media_links' ? 'selected' : '' }}> Social Media Links</option>
                                                                @endif

                                                                @if ($header_id == 1 || $header_id == 3 || $header_id == 5 || $header_id == 6)
                                                                    <option value="customer_login" {{ $menu_topbar_right == 'customer_login' ? 'selected' : '' }}> Customer Login</option>
                                                                @endif

                                                                @if ($header_id == 2 || $header_id == 4)
                                                                    <option value="open_close_image" {{ $menu_topbar_right == 'open_close_image' ? 'selected' : '' }}> Open/Close Banner</option>
                                                                @endif

                                                                @if ($header_id == 2 || $header_id == 5)
                                                                    <option value="main_logo" {{ $menu_topbar_right == 'main_logo' ? 'selected' : '' }}> Logo</option>
                                                                @endif

                                                                @if ($header_id == 3 || $header_id == 6)
                                                                    <option value="shopping_cart" {{ $menu_topbar_right == 'shopping_cart' ? 'selected' : '' }}> Shopping Cart</option>
                                                                @endif
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    @if($header_id != 1)
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label>Open Close Banner</label>
                                                            </th>
                                                            <td>
                                                                <select
                                                                    name="header_setting[menu_topbar_open_close_permission]"
                                                                    id="" class="form-control">
                                                                    @php
                                                                        $menu_topbar_open_close_permission = isset($get_header_settings['menu_topbar_open_close_permission']) ? $get_header_settings['menu_topbar_open_close_permission'] : '';
                                                                    @endphp
                                                                    <option value="1"
                                                                        {{ $menu_topbar_open_close_permission == 1 ? 'selected' : '' }}>
                                                                        Enabled</option>
                                                                    <option value="0"
                                                                        {{ $menu_topbar_open_close_permission == 0 ? 'selected' : '' }}>
                                                                        Disabled</option>
                                                                </select>
                                                                <hr class="bg-dark">
                                                                <div class="form-group">
                                                                    <label class="form-label text-success">Open Banner</label>
                                                                    {{-- <input type="file"
                                                                        name="header_setting[menu_topbar_open_banner]"
                                                                        class="form-control p-1"> --}}
                                                                        <div class="input-group">
                                                                            <span class="input-group-btn">
                                                                              <a id="lfm" data-input="thumbnail" onclick="setimage(this)" data-preview="holder" class="btn btn-primary" style="padding: 7px">
                                                                                <i class="fa fa-picture-o"></i> Choose
                                                                              </a>
                                                                            </span>
                                                                            <input id="thumbnail" class="form-control" type="text" name="header_setting[menu_topbar_open_banner]">
                                                                        </div>
                                                                          <img id="holder" style="margin-top:15px;max-height:100px;">
                                                                    <img class="mt-2"
                                                                        src="{{ isset($get_header_settings['menu_topbar_open_banner']) ? $get_header_settings['menu_topbar_open_banner'] : '' }}"
                                                                        width="120" height="80"
                                                                        style="border: 2px solid green;">
                                                                </div>
                                                                <hr class="bg-dark">
                                                                <div class="form-group">
                                                                    <label class="form-label text-danger">Close Banner</label>
                                                                    {{-- <input type="file"
                                                                        name="header_setting[menu_topbar_close_banner]"
                                                                        class="form-control p-1"> --}}
                                                                        <div class="input-group">
                                                                            <span class="input-group-btn">
                                                                                <a id="lfm2" data-input="thumbnail2" data-preview="holder2" onclick="setimage(this)"
                                                                                    class="btn btn-primary text-white photo">
                                                                                    <i class="fa fa-picture-o"></i> Choose
                                                                                </a>
                                                                            </span>
                                                                            <input id="thumbnail2" class="form-control" type="text" name="header_setting[menu_topbar_close_banner]">
                                                                        </div>
                                                                        <div id="holder2" style="margin-top:15px;max-height:100px;"></div>
                                                                    <img class="mt-2"
                                                                        src="{{ isset($get_header_settings['menu_topbar_close_banner']) ? $get_header_settings['menu_topbar_close_banner'] : '' }}"
                                                                        width="120" height="80"
                                                                        style="border: 2px solid red;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Header Options --}}


                    {{-- Slider Options --}}
                    @php
                        $slider_id = isset($slider_data['slider_id']) ? $slider_data['slider_id'] : '';
                        $get_slider_settings = getLayouts('slider_settings', $slider_id, 'slider_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Sliders Options
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll3" aria-expanded="true" aria-controls="coll3">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Select Slider Layout</label>
                                                        </th>
                                                        <td>
                                                            <select name="slider_setting[slider_layout_id]" id="slider_layout" class="form-control" onchange="changeActiveSlider()">
                                                                <option value=""> - Select Slider - </option>
                                                                @foreach ($sliders_layouts as $slayout)
                                                                    <option value="{{ $slayout->slider_id }}"
                                                                        {{ $slayout->slider_id == $slider_id ? 'selected' : '' }}>
                                                                        {{ $slayout->slider_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="slider-preview" class="bg-light">
                                                            @php
                                                                $slider_image = isset($slider_data['slider_image']) ? $slider_data['slider_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/slider_view/' . $slider_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>
                                                    @if ($slider_id !=2)
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Order Online Search</label>
                                                        </th>
                                                        <td>
                                                            <select
                                                                name="slider_setting[slider_online_searchbox_permission]"
                                                                class="form-control">
                                                                @php
                                                                    $slider_online_searchbox_permission = isset($get_slider_settings['slider_online_searchbox_permission']) ? $get_slider_settings['slider_online_searchbox_permission'] : '';
                                                                @endphp
                                                                <option value="1"
                                                                    {{ $slider_online_searchbox_permission == 1 ? 'selected' : '' }}>
                                                                    Enabled</option>
                                                                <option value="0"
                                                                    {{ $slider_online_searchbox_permission == 0 ? 'selected' : '' }}>
                                                                    Diabled</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Postcode Box Default</label>
                                                        </th>
                                                        <td>
                                                            <input type="text"
                                                                name="slider_setting[slider_online_searchbox_default]"
                                                                class="form-control"
                                                                value="{{ isset($get_slider_settings['slider_online_searchbox_default']) ? $get_slider_settings['slider_online_searchbox_default'] : '' }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Postcode Box Text</label>
                                                        </th>
                                                        <td>
                                                            <input type="text"
                                                                name="slider_setting[slider_online_searchbox_text]"
                                                                value="{{ isset($get_slider_settings['slider_online_searchbox_text']) ? $get_slider_settings['slider_online_searchbox_text'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    @endif


                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Slider Motion Effects</label>
                                                        </th>
                                                        <td>
                                                            <select name="slider_setting[slider_motion_effects]"
                                                                class="form-control">
                                                                @php
                                                                    $slider_motion_effects = isset($get_slider_settings['slider_motion_effects']) ? $get_slider_settings['slider_motion_effects'] : '';
                                                                @endphp
                                                                <option value="random"
                                                                    {{ $slider_motion_effects == 'random' ? 'selected' : '' }}>
                                                                    Random</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="align-middle">
                                                            <label>Slider Overlay</label>
                                                        </th>
                                                        <td>
                                                            <select name="slider_setting[slider_overlay]"
                                                                class="form-control">
                                                                @php
                                                                    $slider_overlay = isset($get_slider_settings['slider_overlay']) ? $get_slider_settings['slider_overlay'] : '';
                                                                @endphp
                                                                <option value="dotes"
                                                                    {{ $slider_overlay == 'dotes' ? 'selected' : '' }}>
                                                                    Dotes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                        <hr class="bg-dark">
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-center">
                                                <h3>Slider Images</h3>
                                            </div>
                                        </div>

                                        {{-- PHP CODE --}}
                                        @php
                                            $slider_count = count($sliders) > 0 ? count($sliders) : 1;
                                        @endphp
                                        <input type="hidden" name="slider_count" id="slider_count" value="{{ $slider_count }}">
                                        {{-- END PHP CODE --}}

                                        <hr class="bg-dark">
                                        <div id="slider-images">
                                            @if (count($sliders) > 0)
                                                @foreach ($sliders as $slider)
                                                    <div class="row mt-3 bg-light p-2 rounded"
                                                        id="slider{{ $loop->iteration }}">
                                                        <div class="col-md-12">
                                                            <h3>Slider {{ $loop->iteration }}</h3>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table">
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Slider Image</label>
                                                                            <input type="hidden" name="slider[{{ $loop->iteration }}][edit]" value="{{ $slider->id }}">
                                                                            {{-- <input type="file" name="slider[{{ $loop->iteration }}][image]" id="" class="form-control p-1"> --}}
                                                                            <div class="input-group">
                                                                                <span class="input-group-btn">
                                                                                    <a id="lfmimage-{{ $loop->iteration }}" data-input="slider-{{ $loop->iteration }}" data-preview="sliderholder{{ $loop->iteration }}" onclick="setimage(this)"
                                                                                        class="btn btn-primary text-white photo">
                                                                                        <i class="fa fa-picture-o"></i> Choose
                                                                                    </a>
                                                                                </span>
                                                                                <input id="slider-{{ $loop->iteration }}" class="form-control" type="text" name="slider[{{ $loop->iteration }}][image]">
                                                                            </div>
                                                                            <div id="sliderholder{{ $loop->iteration }}" style="margin-top:15px;max-height:100px;"></div>
                                                                            <br>
                                                                            @if (isset($slider->image))
                                                                                <img src="{{ $slider->image }}" width="70" alt="img_{{ $loop->iteration }}">
                                                                            @else
                                                                                <h6><code>Image Not Selected</code></h6>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Slider Logo</label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-btn">
                                                                                    <a id="lfmlogo_[{{$loop->iteration}}]" data-input="thumbnail__[{{ $loop->iteration }}]" data-preview="holder__[{{ $loop->iteration }}]" onclick="setimage(this)"
                                                                                        class="btn btn-primary text-white photo">
                                                                                        <i class="fa fa-picture-o"></i> Choose
                                                                                    </a>
                                                                                </span>
                                                                                <input id="thumbnail__[{{ $loop->iteration }}]" class="form-control" type="text" name="slider[{{ $loop->iteration }}][logo]">
                                                                                <div id="holder__[{{ $loop->iteration }}]" style="margin-top:15px;max-height:100px;"></div>
                                                                            </div>
                                                                            <div id="logoholder{{ $loop->iteration }}" style="margin-top:15px;max-height:100px;"></div>
                                                                            <br>
                                                                            @if (isset($slider->logo))
                                                                                <img src="{{ $slider->logo }}" width="70" alt="logo_{{ $loop->iteration }}">
                                                                            @else
                                                                                <h6><code>Logo Not Selected</code></h6>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td rowspan="2" class="align-middle"
                                                                        style="text-align: right;">
                                                                        @if ($slider_count == 1)
                                                                            <button
                                                                                class="btn rounded-circle btn-sm btn-danger"
                                                                                disabled><i
                                                                                    class="fa fa-minus-circle"></i></button>
                                                                        @else
                                                                            <a onclick="deleteSlider('{{ $slider->id }}')"
                                                                                class="btn rounded-circle btn-sm btn-danger"><i
                                                                                    class="fa fa-minus-circle"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Slider
                                                                                Title</label>
                                                                            <input type="text"
                                                                                name="slider[{{ $loop->iteration }}][title]"
                                                                                value="{{ $slider->title }}"
                                                                                class="form-control">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label class="form-label">Slider
                                                                                Description</label>
                                                                            <textarea name="slider[{{ $loop->iteration }}][desc]" id="" class="form-control">{{ $slider->description }}</textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row mt-2 bg-light p-2 rounded" id="slider1">
                                                    <div class="col-md-12">
                                                        <h3>Slider 1</h3>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Slider Image</label>
                                                                        <input type="file" name="slider[1][image]" id="" class="form-control p-1" required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Slider Logo</label>
                                                                        <input type="file" name="slider[1][logo]" id="" class="form-control p-1">
                                                                    </div>
                                                                </td>
                                                                <td rowspan="2" class="align-middle" style="text-align: right;">
                                                                    <button class="btn rounded-circle btn-sm btn-danger" disabled><i class="fa fa-minus-circle"></i></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Slider Title</label>
                                                                        <input type="text" name="slider[1][title]" id="" class="form-control" required>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Slider Description</label>
                                                                        <textarea name="slider[1][desc]" id="" class="form-control"></textarea>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <hr class="bg-dark">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a onclick="addNewSlider()"
                                                    class="btn btn-sm rounded-circle btn-success"><i
                                                        class="fa fa-plus-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Slider Options --}}


                     {{-- HTML Box --}}
                @php
                    $about_id = isset($about_data['about_id']) ? $about_data['about_id'] : '';
                    $get_about_settings = getLayouts('about_settings', $about_id, 'about_id');
                @endphp
                 <div class="row mt-4">
                     <div class="col-md-12" >
                         <div class="card">
                             <div class="card-header bg-success">
                                 <h3 class="card-title pt-2">
                                     HTML BOX
                                 </h3>
                                 <div class="container" style="text-align: right">
                                     <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                         data-target="#coll4" aria-expanded="true" aria-controls="coll4">
                                         <i class="fa" aria-hidden="true"></i>
                                     </button>
                                 </div>
                             </div>

                            {{-- PHP CODE --}}
                            @php
                                $htmlbox_count = count($htmlbox) > 0 ? count($htmlbox) : 1;

                            @endphp
                            <input type="hidden" name="htmlbox_count" id="htmlbox_count" value="{{ $htmlbox_count }}">
                            {{-- END PHP CODE --}}
                             <div class="collapse show" id="coll4">
                                 <div class="card-body pb-0" id="htmlbox">
                                    @if (count($htmlbox) > 0)
                                        @foreach ($htmlbox as $htmlboxs)
                                            <div class="htmlbox-inr">
                                                <h2>HTML {{ $loop->iteration}}</h2>
                                                <div class="row align-items-center" >
                                                    <div class="col-md-11">
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <th width="250" class="align-middle">
                                                                    <label>Select HTML Layout</label>
                                                                </th>
                                                                <td>
                                                                    <input type="hidden" name="about_setting[{{ $loop->iteration }}][edithtmlbox]" value="{{ $htmlboxs->id }}">
                                                                    {{-- <select name="about_setting[{{ $loop->iteration}}][about_layout_id]" id="about_layout" class="form-control" onchange="changeActiveAboutLayout();"> --}}
                                                                    <select name="about_setting[{{ $loop->iteration}}][about_layout_id]" id="about_layout" class="form-control" onchange="backgroundOption(this)">
                                                                        @foreach ($about_layouts as $about)
                                                                            <option value="{{ $about->about_id }}" {{ $htmlboxs->about_layout_id == $about->about_id ? 'selected' : '' }}>{{ $about->about_name }}</option>
                                                                            {{-- <option value="{{ $about->about_id }}" {{ in_array($about->about_id,$test) == $about->about_id ? 'selected' : '' }}> --}}
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th width="250" class="align-middle">
                                                                    <label>Preview</label>
                                                                </th>
                                                                <td id="about-preview" class="bg-light">
                                                                    @php
                                                                        $about_image = isset($htmlboxs->hasoneaboutActive->about_image) ? $htmlboxs->hasoneaboutActive->about_image : '';
                                                                    @endphp
                                                                    <img src="{{ asset('public/admin/about_view/' . $about_image) }}" alt="Not Found" class="w-100">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th width="250" class="align-middle">
                                                                    <label>Background Option</label>
                                                                </th>
                                                                <td>
                                                                    <select name="about_setting[{{ $loop->iteration }}][about_background_option]" onchange="backgroundOption(this)" class="form-control">
                                                                        @php
                                                                            $about_background_option = isset($htmlboxs['about_background_option']) ? $htmlboxs['about_background_option'] : '';
                                                                        @endphp
                                                                        <option value="1" {{ $about_background_option == 1 ? 'selected' : '' }}>Image</option>
                                                                        <option value="2" {{ $about_background_option == 2 ? 'selected' : '' }}>Color</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            @if ($about_background_option == 2)
                                                                <tr>
                                                                    <th width="250" class="align-middle">
                                                                        <label>Background Color</label>
                                                                    </th>
                                                                    <td>
                                                                        <input type="color" name="about_setting[{{ $loop->iteration }}][about_background_color]" value="{{ isset($htmlboxs->about_background_color) ? $htmlboxs->about_background_color : '' }}" class="form-control">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th width="250" class="align-middle">
                                                                        <label>Background Hover Color</label>
                                                                    </th>
                                                                    <td>
                                                                        <input type="color" value="{{ isset($htmlboxs['about_background_hover_color']) ? $htmlboxs['about_background_hover_color'] : '' }}" name="about_setting[{{ $loop->iteration }}][about_background_hover_color]" class="form-control">
                                                                    </td>
                                                                </tr>
                                                            @endif


                                                            @if ($about_background_option == 1)
                                                                <tr>
                                                                    <th width="250" class="align-middle">
                                                                        <label>Background Image</label>
                                                                    </th>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-btn">
                                                                                <a id="aboutbgimg{{ $loop->iteration }}" data-input="thumbnaibgimg{{ $loop->iteration }}" data-preview="holderbgimg{{ $loop->iteration }}" onclick="setimage(this)" class="btn btn-primary text-white photo">
                                                                                    <i class="fa fa-picture-o"></i> Choose
                                                                                </a>
                                                                            </span>
                                                                            <input id="thumbnaibgimg{{ $loop->iteration }}" class="form-control" type="text" name="about_setting[{{ $loop->iteration}}][about_background_image]">
                                                                        </div>
                                                                        <div id="holderbgimg{{ $loop->iteration }}" style="margin-top:15px;max-height:100px;"></div>
                                                                        <img class="mt-2" src="{{ isset($htmlboxs['about_background_image']) ? $htmlboxs['about_background_image'] : '' }}" width="120" height="80" style="border: 2px solid black;">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th width="250" class="align-middle">
                                                                        <label>Background Image Position</label>
                                                                    </th>
                                                                    <td>
                                                                        <select
                                                                            name="about_setting[{{ $loop->iteration}}][about_background_image_position]"
                                                                            class="form-control">
                                                                            @php
                                                                                $about_background_image_position = isset($htmlboxs['about_background_image_position']) ? $htmlboxs['about_background_image_position'] : '';
                                                                            @endphp
                                                                            <option value="top" {{ $about_background_image_position == 'top' ? 'selected' : '' }}> Top</option>
                                                                            <option value="bottom" {{ $about_background_image_position == 'bottom' ? 'selected' : '' }}> Bottom</option>
                                                                            <option value="left" {{ $about_background_image_position == 'left' ? 'selected' : '' }}> Left</option>
                                                                            <option value="right" {{ $about_background_image_position == 'right' ? 'selected' : '' }}> Right</option>
                                                                            <option value="center" {{ $about_background_image_position == 'center' ? 'selected' : '' }}> Center</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            <tr>
                                                                <th width="250" class="align-middle">
                                                                    <label>Title</label>
                                                                </th>
                                                                <td>
                                                                    <input type="text" name="about_setting[{{ $loop->iteration}}][about_title]"
                                                                        value="{{ isset($htmlboxs['about_title']) ? $htmlboxs['about_title'] : '' }}"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th width="250" class="align-middle">
                                                                    <label>HTML BOX</label>
                                                                </th>
                                                                <td>
                                                                    <textarea name="about_setting[{{ $loop->iteration}}][about_description]"  class="form-control summernote">{{ isset($htmlboxs['about_description']) ? $htmlboxs['about_description'] : '' }}</textarea>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th width="250" class="align-middle">
                                                                    <label>Image</label>
                                                                </th>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <a id="abouthtmlbox{{ $loop->iteration }}" data-input="aboutimage{{ $loop->iteration }}" data-preview="aboutholder{{ $loop->iteration }}" onclick="setimage(this)"
                                                                                class="btn btn-primary text-white photo">
                                                                                <i class="fa fa-picture-o"></i> Choose
                                                                            </a>
                                                                        </span>
                                                                        <input id="aboutimage{{ $loop->iteration }}" class="form-control" type="text" name="about_setting[{{ $loop->iteration}}][about_image]">
                                                                    </div>
                                                                    <div id="aboutholder{{ $loop->iteration }}" style="margin-top:15px;max-height:100px;"></div>
                                                                    <img class="mt-2" src="{{ isset($htmlboxs['about_image']) ? $htmlboxs['about_image'] : '' }}" width="120" height="80" style="border: 2px solid black;">
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    @if ($htmlbox_count == 1)
                                                        <div class="col-md-1 text-center">
                                                            <button class="btn rounded-circle btn-sm btn-danger" disabled><i class="fa fa-minus-circle"></i></button>
                                                        </div>
                                                    @else
                                                        <div class="col-md-1 text-center">
                                                            <button type="button" class="btn rounded-circle btn-sm btn-danger" onclick="deletehtmlbox('{{ $htmlboxs->id }}')"><i class="fa fa-minus-circle"></i></button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    <div class="htmlbox-inr">
                                        <h2>HTML</h2>
                                        <div class="row align-items-center" >
                                            <div class="col-md-11">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Select HTML Layout</label>
                                                        </th>
                                                        <td>

                                                            <select name="about_setting[0][about_layout_id]" id="about_layout" onchange="backgroundOption(this)" class="form-control">
                                                                <option value=""> - Select HTML Box - </option>
                                                                @foreach ($about_layouts as $about)
                                                                    <option value="{{ $about->about_id }}">{{ $about->about_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Option</label>
                                                        </th>
                                                        <td>
                                                            <select name="about_setting[0][about_background_option]" class="form-control">

                                                                <option value="1">Image</option>
                                                                <option value="2">Color</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Color</label>
                                                            </th>
                                                            <td>
                                                                <input type="color" name="about_setting[0][about_background_color]" value="" class="form-control">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Hover Color</label>
                                                            </th>
                                                            <td>
                                                                <input type="color" value="" name="about_setting[0][about_background_hover_color]" class="form-control">
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image</label>
                                                            </th>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <a id="lfm3" data-input="thumbnail3" data-preview="holder3" onclick="setimage(this)" class="btn btn-primary text-white photo">
                                                                            <i class="fa fa-picture-o"></i> Choose
                                                                        </a>
                                                                    </span>
                                                                    <input id="thumbnail3" class="form-control" type="text" name="about_setting[0][about_background_image]">
                                                                </div>
                                                                <div id="holder3" style="margin-top:15px;max-height:100px;"></div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image Position</label>
                                                            </th>
                                                            <td>
                                                                <select
                                                                    name="about_setting[0][about_background_image_position]"
                                                                    class="form-control">

                                                                    <option value="top">Top</option>
                                                                    <option value="bottom">Bottom</option>
                                                                    <option value="left">Left</option>
                                                                    <option value="right">Right</option>
                                                                    <option value="center">Center</option>
                                                                </select>
                                                            </td>
                                                        </tr>


                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Title</label>
                                                        </th>
                                                        <td>
                                                            <input type="text" name="about_setting[0][about_title]" value="" class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>HTML BOX</label>
                                                        </th>
                                                        <td>
                                                            <textarea name="about_setting[0][about_description]"  class="form-control summernote"></textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Image</label>
                                                        </th>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <a id="abouthtmlbox[0]" data-input="aboutimage[0]" data-preview="aboutholder[0]" onclick="setimage(this)"
                                                                        class="btn btn-primary text-white photo">
                                                                        <i class="fa fa-picture-o"></i> Choose
                                                                    </a>
                                                                </span>
                                                                <input id="aboutimage[0]" class="form-control" type="text" name="about_setting[0][about_image]">
                                                            </div>
                                                            <div id="aboutholder[0]" style="margin-top:15px;max-height:100px;"></div>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="col-md-1 text-center">
                                                <button class="btn rounded-circle btn-sm btn-danger" disabled><i class="fa fa-minus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                 </div>

                                 <div class="row">
                                     <div class="col-md-12 text-center py-2">
                                         <a onclick="addHtmlBox()" class="btn btn-sm rounded-circle btn-success">
                                             <i class="fa fa-plus-circle"></i>
                                         </a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 {{-- End HTML Box --}}


                    {{-- Popular Foods --}}
                    @php
                        $popularfood_id = isset($popularfood_data['popular_food_id']) ? $popularfood_data['popular_food_id'] : '';
                        $get_popularfood_settings = getLayouts('popularfood_settings', $popularfood_id, 'popularfood_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Popular Foods Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll5" aria-expanded="true" aria-controls="coll5">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll5">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Popular Foods Design</label>
                                                        </th>
                                                        <td>
                                                            <select name="popularfood_setting[popularfood_layout_id]" id="popularfood_layout" onchange="changeActivePopularFoodLayout()" class="form-control">
                                                                <option value=""> - Select Popular Foods - </option>
                                                                @foreach ($popularfoods_layouts as $popularfood)
                                                                    <option
                                                                        value="{{ $popularfood->popular_food_id }}"
                                                                        {{ $popularfood->popular_food_id == $popularfood_id ? 'selected' : '' }}>
                                                                        {{ $popularfood->popular_food_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="popularfood-preview" class="bg-light">
                                                            @php
                                                                $popularfood_image = isset($popularfood_data['popular_food_image']) ? $popularfood_data['popular_food_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/popularfood_view/' . $popularfood_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Option</label>
                                                        </th>
                                                        <td>
                                                            <select name="popularfood_setting[popularfood_background_option]" class="form-control" onchange="backgroundOption(this);">
                                                                @php
                                                                    $popularfood_background_option = isset($get_popularfood_settings['popularfood_background_option']) ? $get_popularfood_settings['popularfood_background_option'] : '';
                                                                @endphp
                                                                <option value="1" {{ $popularfood_background_option == 1 ? 'selected' : '' }}>Image</option>
                                                                <option value="2" {{ $popularfood_background_option == 2 ? 'selected' : '' }}>Color</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    @if($popularfood_background_option == 2)
                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Color</label>
                                                            </th>
                                                            <td>
                                                                <input type="color"
                                                                    name="popularfood_setting[popularfood_background_color]"
                                                                    value="{{ isset($get_popularfood_settings['popularfood_background_color']) ? $get_popularfood_settings['popularfood_background_color'] : '' }}"
                                                                    class="form-control">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Hover Color</label>
                                                            </th>
                                                            <td>
                                                                <input type="color"
                                                                    name="popularfood_setting[popularfood_background_hover_color]"
                                                                    value="{{ isset($get_popularfood_settings['popularfood_background_hover_color']) ? $get_popularfood_settings['popularfood_background_hover_color'] : '' }}"
                                                                    class="form-control">
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if ($popularfood_background_option == 1)
                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image</label>
                                                            </th>
                                                            <td>
                                                                {{-- <input type="file" name="popularfood_setting[popularfood_background_image]" class="form-control p-1">
                                                                <img class="mt-2" src="{{ isset($get_popularfood_settings['popularfood_background_image']) ? $get_popularfood_settings['popularfood_background_image'] : '' }}" width="120" height="80" style="border: 2px solid black;"> --}}
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <a id="lfm5" data-input="thumbnail5" data-preview="holder5" onclick="setimage(this)"
                                                                            class="btn btn-primary text-white photo">
                                                                            <i class="fa fa-picture-o"></i> Choose
                                                                        </a>
                                                                    </span>
                                                                    <input id="thumbnail5" class="form-control" type="text" name="popularfood_setting[popularfood_background_image]">
                                                                </div>
                                                                <div id="holder5" style="margin-top:15px;max-height:100px;"></div>
                                                            <img class="mt-2" src="{{ isset($get_popularfood_settings['popularfood_background_image']) ? $get_popularfood_settings['popularfood_background_image'] : '' }}" width="120" height="80" style="border: 2px solid black;">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image Position</label>
                                                            </th>
                                                            <td>
                                                                <select
                                                                    name="popularfood_setting[popularfood_background_image_position]"
                                                                    class="form-control">
                                                                    @php
                                                                        $popularfood_background_image_position = isset($get_popularfood_settings['popularfood_background_image_position']) ? $get_popularfood_settings['popularfood_background_image_position'] : '';
                                                                    @endphp
                                                                    <option value="top"
                                                                        {{ $popularfood_background_image_position == 'top' ? 'selected' : '' }}>
                                                                        Top</option>
                                                                    <option value="bottom"
                                                                        {{ $popularfood_background_image_position == 'bottom' ? 'selected' : '' }}>
                                                                        Bottom</option>
                                                                    <option value="left"
                                                                        {{ $popularfood_background_image_position == 'left' ? 'selected' : '' }}>
                                                                        Left</option>
                                                                    <option value="right"
                                                                        {{ $popularfood_background_image_position == 'right' ? 'selected' : '' }}>
                                                                        Right</option>
                                                                    <option value="center"
                                                                        {{ $popularfood_background_image_position == 'center' ? 'selected' : '' }}>
                                                                        Center</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Title</label>
                                                        </th>
                                                        <td>
                                                            <input type="text"
                                                                name="popularfood_setting[popularfood_title]"
                                                                value="{{ isset($get_popularfood_settings['popularfood_title']) ? $get_popularfood_settings['popularfood_title'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    @if ($popularfood_id != 4)
                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Description</label>
                                                        </th>
                                                        <td>
                                                            <textarea name="popularfood_setting[popularfood_description]" class="form-control">{{ isset($get_popularfood_settings['popularfood_description']) ? $get_popularfood_settings['popularfood_description'] : '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    @endif


                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Max Number of Item</label>
                                                        </th>
                                                        <td>
                                                            <input type="number"
                                                                name="popularfood_setting[popularfood_limit]"
                                                                value="{{ isset($get_popularfood_settings['popularfood_limit']) ? $get_popularfood_settings['popularfood_limit'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Popular Foods --}}


                    {{-- Best Categories --}}
                    @php
                        $bestcategory_id = isset($bestcategory_data['best_category_id']) ? $bestcategory_data['best_category_id'] : '';
                        $get_bestcategory_settings = getLayouts('bestcategory_settings', $bestcategory_id, 'bestcategory_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Best Categories Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll6" aria-expanded="true" aria-controls="coll6">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll6">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Best Categories Design</label>
                                                        </th>
                                                        <td>
                                                            <select name="bestcategory_setting[bestcategory_layout_id]" id="bestcategory_layout" onchange="changeActiveBestcategoryLayout()" class="form-control">
                                                                <option value=""> - Select Best Categories - </option>
                                                                @foreach ($bestcategory_layouts as $bestcategory)
                                                                    <option
                                                                        value="{{ $bestcategory->best_category_id }}"
                                                                        {{ $bestcategory->best_category_id == $bestcategory_id ? 'selected' : '' }}>
                                                                        {{ $bestcategory->best_category_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="bestcategory-preview" class="bg-light">
                                                            @php
                                                                $bestcategory_image = isset($bestcategory_data['best_category_image']) ? $bestcategory_data['best_category_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/bestcategory_view/' . $bestcategory_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Option</label>
                                                        </th>
                                                        <td>
                                                            <select name="bestcategory_setting[bestcategory_background_option]" class="form-control" onchange="backgroundOption(this)">
                                                                @php
                                                                    $bestcategory_background_option = isset($get_bestcategory_settings['bestcategory_background_option']) ? $get_bestcategory_settings['bestcategory_background_option'] : '';
                                                                @endphp
                                                                <option value="1" {{ $bestcategory_background_option == 1 ? 'selected' : '' }}>Image</option>
                                                                <option value="2" {{ $bestcategory_background_option == 2 ? 'selected' : '' }}>Color</option>
                                                            </select>
                                                        </td>
                                                    </tr> --}}
                                                    {{-- @if($bestcategory_background_option == 2) --}}
                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="bestcategory_setting[bestcategory_background_color]"
                                                                value="{{ isset($get_bestcategory_settings['bestcategory_background_color']) ? $get_bestcategory_settings['bestcategory_background_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="bestcategory_setting[bestcategory_background_hover_color]"
                                                                value="{{ isset($get_bestcategory_settings['bestcategory_background_hover_color']) ? $get_bestcategory_settings['bestcategory_background_hover_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr> --}}
                                                    {{-- @endif --}}

                                                    {{-- @if ($bestcategory_background_option == 1)
                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image</label>
                                                            </th>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <a id="lfm6" data-input="thumbnail6" data-preview="holder6" onclick="setimage(this)"
                                                                            class="btn btn-primary text-white photo">
                                                                            <i class="fa fa-picture-o"></i> Choose
                                                                        </a>
                                                                    </span>
                                                                    <input id="thumbnail6" class="form-control" type="text" name="bestcategory_setting[bestcategory_background_image]">
                                                                </div>
                                                                <div id="holder6" style="margin-top:15px;max-height:100px;"></div>
                                                                <img class="mt-2" src="{{ isset($get_bestcategory_settings['bestcategory_background_image']) ? $get_bestcategory_settings['bestcategory_background_image'] : '' }}" width="120" height="80" style="border: 2px solid black;">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image Position</label>
                                                            </th>
                                                            <td>
                                                                <select
                                                                    name="bestcategory_setting[bestcategory_background_image_position]"
                                                                    class="form-control">
                                                                    @php
                                                                        $bestcategory_background_image_position = isset($get_bestcategory_settings['bestcategory_background_image_position']) ? $get_bestcategory_settings['bestcategory_background_image_position'] : '';
                                                                    @endphp
                                                                    <option value="top"
                                                                        {{ $bestcategory_background_image_position == 'top' ? 'selected' : '' }}>
                                                                        Top</option>
                                                                    <option value="bottom"
                                                                        {{ $bestcategory_background_image_position == 'bottom' ? 'selected' : '' }}>
                                                                        Bottom</option>
                                                                    <option value="left"
                                                                        {{ $bestcategory_background_image_position == 'left' ? 'selected' : '' }}>
                                                                        Left</option>
                                                                    <option value="right"
                                                                        {{ $bestcategory_background_image_position == 'right' ? 'selected' : '' }}>
                                                                        Right</option>
                                                                    <option value="center"
                                                                        {{ $bestcategory_background_image_position == 'center' ? 'selected' : '' }}>
                                                                        Center</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif --}}

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Title</label>
                                                        </th>
                                                        <td>
                                                            <input type="text"
                                                                name="bestcategory_setting[bestcategory_title]"
                                                                value="{{ isset($get_bestcategory_settings['bestcategory_title']) ? $get_bestcategory_settings['bestcategory_title'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    @if ($bestcategory_id != 4)
                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Description</label>
                                                        </th>
                                                        <td>
                                                            <textarea name="bestcategory_setting[bestcategory_description]" class="form-control">{{ isset($get_bestcategory_settings['bestcategory_description']) ? $get_bestcategory_settings['bestcategory_description'] : '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    @endif


                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Max Number of Item</label>
                                                        </th>
                                                        <td>
                                                            <input type="number"
                                                                name="bestcategory_setting[bestcategory_limit]"
                                                                value="{{ isset($get_bestcategory_settings['bestcategory_limit']) ? $get_bestcategory_settings['bestcategory_limit'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Best Categories --}}


                    {{-- Reviews Section --}}
                    @php
                        $review_id = isset($review_data['review_id']) ? $review_data['review_id'] : '';
                        $get_review_settings = getLayouts('review_settings', $review_id, 'reviews_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Recent Reviews Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll7" aria-expanded="true" aria-controls="coll7">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll7">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Reviews Design</label>
                                                        </th>
                                                        <td>
                                                            <select name="review_setting[review_layout_id]" id="review_layout" onchange="changeActiveReviewLayout()" class="form-control">
                                                                <option value=""> - Select reviews - </option>
                                                                @foreach ($reviews_layouts as $review)
                                                                    <option value="{{ $review->review_id }}"
                                                                        {{ $review->review_id == $review_id ? 'selected' : '' }}>
                                                                        {{ $review->review_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="review-preview" class="bg-light">
                                                            @php
                                                                $review_image = isset($review_data['review_image']) ? $review_data['review_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/reviews_view/' . $review_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Option</label>
                                                        </th>
                                                        <td>
                                                            <select name="review_setting[review_background_option]" class="form-control" onchange="backgroundOption(this)">
                                                                @php
                                                                    $review_background_option = isset($get_review_settings['review_background_option']) ? $get_review_settings['review_background_option'] : '';
                                                                @endphp
                                                                <option value="1" {{ $review_background_option == 1 ? 'selected' : '' }}>Image</option>
                                                                <option value="2" {{ $review_background_option == 2 ? 'selected' : '' }}>Color</option>
                                                            </select>
                                                        </td>
                                                    </tr> --}}

                                                    {{-- @if ($review_background_option == 2) --}}
                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Color</label>
                                                            </th>
                                                            <td>
                                                                <input type="color"
                                                                    name="review_setting[review_background_color]"
                                                                    value="{{ isset($get_review_settings['review_background_color']) ? $get_review_settings['review_background_color'] : '' }}"
                                                                    class="form-control">
                                                            </td>
                                                        </tr>

                                                        {{-- <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Hover Color</label>
                                                            </th>
                                                            <td>
                                                                <input type="color"
                                                                    name="review_setting[review_background_hover_color]"
                                                                    value="{{ isset($get_review_settings['review_background_hover_color']) ? $get_review_settings['review_background_hover_color'] : '' }}"
                                                                    class="form-control">
                                                            </td>
                                                        </tr> --}}
                                                    {{-- @endif --}}


                                                    {{-- @if ($review_background_option == 1)
                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image</label>
                                                            </th>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <a id="lfm7" data-input="thumbnail7" data-preview="holder7" onclick="setimage(this)"
                                                                            class="btn btn-primary text-white photo">
                                                                            <i class="fa fa-picture-o"></i> Choose
                                                                        </a>
                                                                    </span>
                                                                    <input id="thumbnail7" class="form-control" type="text" name="review_setting[review_background_image]">
                                                                </div>
                                                                <div id="holder7" style="margin-top:15px;max-height:100px;"></div>
                                                                <img class="mt-2" src="{{ isset($get_review_settings['review_background_image']) ? $get_review_settings['review_background_image'] : '' }}" width="120" height="80" style="border: 2px solid black;">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="250" class="align-middle">
                                                                <label>Background Image Position</label>
                                                            </th>
                                                            <td>
                                                                <select
                                                                    name="review_setting[review_background_image_position]"
                                                                    class="form-control">
                                                                    @php
                                                                        $review_background_image_position = isset($get_review_settings['review_background_image_position']) ? $get_review_settings['review_background_image_position'] : '';
                                                                    @endphp
                                                                    <option value="top"
                                                                        {{ $review_background_image_position == 'top' ? 'selected' : '' }}>
                                                                        Top</option>
                                                                    <option value="bottom"
                                                                        {{ $review_background_image_position == 'bottom' ? 'selected' : '' }}>
                                                                        Bottom</option>
                                                                    <option value="left"
                                                                        {{ $review_background_image_position == 'left' ? 'selected' : '' }}>
                                                                        Left</option>
                                                                    <option value="right"
                                                                        {{ $review_background_image_position == 'right' ? 'selected' : '' }}>
                                                                        Right</option>
                                                                    <option value="center"
                                                                        {{ $review_background_image_position == 'center' ? 'selected' : '' }}>
                                                                        Center</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif --}}

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Title</label>
                                                        </th>
                                                        <td>
                                                            <input type="text" name="review_setting[review_title]"
                                                                value="{{ isset($get_review_settings['review_title']) ? $get_review_settings['review_title'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Description</label>
                                                        </th>
                                                        <td>
                                                            <textarea name="review_setting[review_description]" class="form-control">{{ isset($get_review_settings['review_description']) ? $get_review_settings['review_description'] : '' }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Max Number of Item</label>
                                                        </th>
                                                        <td>
                                                            <input type="number" name="review_setting[review_limit]"
                                                                value="{{ isset($get_review_settings['review_limit']) ? $get_review_settings['review_limit'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Reviews Section --}}


                    {{-- Reservation Section --}}
                    @php
                        $reservation_id = isset($reservation_data['reservation_id']) ? $reservation_data['reservation_id'] : '';
                        $get_reservation_settings = getLayouts('reservation_settings', $reservation_id, 'reservation_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Reservation Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll8" aria-expanded="true" aria-controls="coll8">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll8">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Reservation Design</label>
                                                        </th>
                                                        <td>
                                                            <select  name="reservation_setting[reservation_layout_id]" id="reservation_layout" onchange="changeActiveReservationLayout()" class="form-control">
                                                                <option value=""> - Select Reservation - </option>
                                                                @foreach ($reservation_layouts as $reservation)
                                                                    <option
                                                                        value="{{ $reservation->reservation_id }}"
                                                                        {{ $reservation->reservation_id == $reservation_id ? 'selected' : '' }}>
                                                                        {{ $reservation->reservation_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="reservation-preview" class="bg-light">
                                                            @php
                                                                $reservation_image = isset($reservation_data['reservation_image']) ? $reservation_data['reservation_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/reservation_view/' . $reservation_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="reservation_setting[reservation_background_color]"
                                                                value="{{ isset($get_reservation_settings['reservation_background_color']) ? $get_reservation_settings['reservation_background_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="reservation_setting[reservation_background_hover_color]"
                                                                value="{{ isset($get_reservation_settings['reservation_background_hover_color']) ? $get_reservation_settings['reservation_background_hover_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr> --}}

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Title</label>
                                                        </th>
                                                        <td>
                                                            <input type="text"
                                                                name="reservation_setting[reservation_title]"
                                                                value="{{ isset($get_reservation_settings['reservation_title']) ? $get_reservation_settings['reservation_title'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>
                                                    @if ($reservation_id != 4)
                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Description</label>
                                                        </th>
                                                        <td>
                                                            <textarea name="reservation_setting[reservation_description]" class="form-control">{{ isset($get_reservation_settings['reservation_description']) ? $get_reservation_settings['reservation_description'] : '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    @endif


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Reservation Section --}}


                    {{-- Gallary Section --}}
                    @php
                        $gallary_id = isset($gallary_data['gallary_id']) ? $gallary_data['gallary_id'] : '';
                        $get_gallary_settings = getLayouts('gallary_settings', $gallary_id, 'gallary_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Gallary Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll9" aria-expanded="true" aria-controls="coll9">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll9">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Gallary Design</label>
                                                        </th>
                                                        <td>
                                                            <select name="gallary_setting[gallary_layout_id]" id="gallary_layout" onchange="changeActiveGallaryLayout()" class="form-control">
                                                                <option value=""> - Select Gallary - </option>
                                                                @foreach ($gallary_layouts as $gallary)
                                                                    <option value="{{ $gallary->gallary_id }}"
                                                                        {{ $gallary->gallary_id == $gallary_id ? 'selected' : '' }}> {{ $gallary->gallary_name }}</option> @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="gallary-preview" class="bg-light">
                                                            @php
                                                                $gallary_image = isset($gallary_data['gallary_image']) ? $gallary_data['gallary_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/gallary_view/' . $gallary_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Max Number of Item</label>
                                                        </th>
                                                        <td>
                                                            <input type="number"
                                                                name="gallary_setting[gallary_limit]"
                                                                value="{{ isset($get_gallary_settings['gallary_limit']) ? $get_gallary_settings['gallary_limit'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Gallary Section --}}


                    {{-- Opening Hours Section --}}
                    @php
                        $openhour_id = isset($openhour_data['openhour_id']) ? $openhour_data['openhour_id'] : '';
                        $get_openhour_settings = getLayouts('openhour_settings', $openhour_id, 'openhours_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Opening Hours Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll11" aria-expanded="true" aria-controls="coll11">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll11">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Opening Hours Design</label>
                                                        </th>
                                                        <td>
                                                            <select name="openhour_setting[openhour_layout_id]" id="openhour_layout" onchange="changeActiveOpeningHoursLayout()" class="form-control">
                                                                <option value=""> - Select Open Hours - </option>
                                                                @foreach ($openhours_layouts as $openhours) <option value="{{ $openhours->openhour_id }}"
                                                                        {{ $openhours->openhour_id == $openhour_id ? 'selected' : '' }}>
                                                                        {{ $openhours->openhour_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="openhour-preview" class="bg-light">
                                                            @php
                                                                $openhour_image = isset($openhour_data['openhour_image']) ? $openhour_data['openhour_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/openhour_view/' . $openhour_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="openhour_setting[openhour_background_color]"
                                                                value="{{ isset($get_openhour_settings['openhour_background_color']) ? $get_openhour_settings['openhour_background_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr> --}}

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="openhour_setting[openhour_background_hover_color]"
                                                                value="{{ isset($get_openhour_settings['openhour_background_hover_color']) ? $get_openhour_settings['openhour_background_hover_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr> --}}

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Image</label>
                                                        </th>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <a id="lfm8" data-input="thumbnail8" data-preview="holder8" onclick="setimage(this)"
                                                                        class="btn btn-primary text-white photo">
                                                                        <i class="fa fa-picture-o"></i> Choose
                                                                    </a>
                                                                </span>
                                                                <input id="thumbnail8" class="form-control" type="text" name="openhour_setting[openhour_background_image]">
                                                            </div>
                                                            <div id="holder8" style="margin-top:15px;max-height:100px;"></div>
                                                            <img class="mt-2" src="{{ isset($get_openhour_settings['openhour_background_image']) ? $get_openhour_settings['openhour_background_image'] : '' }}" width="120" height="80" style="border: 2px solid black;">
                                                        </td>
                                                    </tr> --}}

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Image Position</label>
                                                        </th>
                                                        <td>
                                                            <select
                                                                name="openhour_setting[openhour_background_image_position]"
                                                                class="form-control">
                                                                @php
                                                                    $openhour_background_image_position = isset($get_openhour_settings['openhour_background_image_position']) ? $get_openhour_settings['openhour_background_image_position'] : '';
                                                                @endphp
                                                                <option value="top"
                                                                    {{ $openhour_background_image_position == 'top' ? 'selected' : '' }}>
                                                                    Top</option>
                                                                <option value="bottom"
                                                                    {{ $openhour_background_image_position == 'bottom' ? 'selected' : '' }}>
                                                                    Bottom</option>
                                                                <option value="left"
                                                                    {{ $openhour_background_image_position == 'left' ? 'selected' : '' }}>
                                                                    Left</option>
                                                                <option value="right"
                                                                    {{ $openhour_background_image_position == 'right' ? 'selected' : '' }}>
                                                                    Right</option>
                                                                <option value="center"
                                                                    {{ $openhour_background_image_position == 'center' ? 'selected' : '' }}>
                                                                    Center</option>
                                                            </select>
                                                        </td>
                                                    </tr> --}}

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Opening Hours Section --}}


                    {{-- Footer Section --}}
                    @php
                        $footer_id = isset($footer_data['footer_id']) ? $footer_data['footer_id'] : '';
                        $get_footer_settings = getLayouts('footer_settings', $footer_id, 'footer_id');
                    @endphp
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h3 class="card-title pt-2">
                                        Footer Section
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse"
                                            data-target="#coll10" aria-expanded="true" aria-controls="coll10">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="collapse show" id="coll10">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-striped">

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Footer Design</label>
                                                        </th>
                                                        <td>
                                                            <select name="footer_setting[footer_layout_id]" id="footer_layout" onchange="changeActiveFooterLayout()" class="form-control">
                                                                <option value=""> - Select Footer - </option>
                                                                @foreach ($footers as $footer)
                                                                    <option value="{{ $footer->footer_id }}"
                                                                        {{ $footer->footer_id == $footer_id ? 'selected' : '' }}>
                                                                        {{ $footer->footer_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Preview</label>
                                                        </th>
                                                        <td id="footer-preview" class="bg-light">
                                                            @php
                                                                $footer_image = isset($footer_data['footer_image']) ? $footer_data['footer_image'] : '';
                                                            @endphp
                                                            <img src="{{ asset('public/admin/footer_view/' . $footer_image) }}"
                                                                alt="Not Found" class="w-100">
                                                        </td>
                                                    </tr>
                                                    </tr>

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="footer_setting[footer_background_color]"
                                                                value="{{ isset($get_footer_settings['footer_background_color']) ? $get_footer_settings['footer_background_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Background Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="footer_setting[footer_background_hover_color]"
                                                                value="{{ isset($get_footer_settings['footer_background_hover_color']) ? $get_footer_settings['footer_background_hover_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr> --}}

                                                    <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Link Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="footer_setting[footer_link_color]"
                                                                value="{{ isset($get_footer_settings['footer_link_color']) ? $get_footer_settings['footer_link_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr>

                                                    {{-- <tr>
                                                        <th width="250" class="align-middle">
                                                            <label>Link Hover Color</label>
                                                        </th>
                                                        <td>
                                                            <input type="color"
                                                                name="footer_setting[footer_link_hover_color]"
                                                                value="{{ isset($get_footer_settings['footer_link_hover_color']) ? $get_footer_settings['footer_link_hover_color'] : '' }}"
                                                                class="form-control">
                                                        </td>
                                                    </tr> --}}

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Footer Section --}}

                </form>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Template Setting --}}


{{-- Footer Section --}}
@include('footer')
{{-- End Footer Section --}}

{{-- Script --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    // Date Range Picker
    $(function() {
        $('input[name="daterange"]').daterangepicker();
    });

    // New Slider
    var incr = $('#slider_count').val();

    function addNewSlider() {
        incr++;
        var html = '';

        html += `<div class="row mt-3 bg-light p-2 rounded" id="slider` + incr + `">
                    <div class="col-md-12">
                        <h3>Slider ` + incr + `</h3>
                    </div>
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="form-label">Slider Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfmimage_[` + incr + `]" data-input="thumbnail_[` + incr + `]" data-preview="holder_[` + incr + `]" onclick="setimage(this)"
                                                    class="btn btn-primary text-white photo">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail_[` + incr + `]" class="form-control" type="text" name="slider[` + incr + `][image]">
                                            <div id="holder_[` + incr + `]" style="margin-top:15px;max-height:100px;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="form-label">Slider Logo</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfmlogo_[` + incr + `]" data-input="thumbnail__[` + incr + `]" data-preview="holder__[` + incr + `]" onclick="setimage(this)"
                                                    class="btn btn-primary text-white photo">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail__[` + incr + `]" class="form-control" type="text" name="slider[` + incr + `][logo]">
                                            <div id="holder__[` + incr + `]" style="margin-top:15px;max-height:100px;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td rowspan="2" class="align-middle" style="text-align: right;">
                                    <a onclick="$(\'#slider` + incr + `\').remove()" class="btn rounded-circle btn-sm btn-danger"><i class="fa fa-minus-circle"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="form-label">Slider Title</label>
                                        <input type="text" name="slider[` + incr + `][title]" id="" class="form-control" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="form-label">Slider Description</label>
                                        <textarea name="slider[` + incr + `][desc]" id="" class="form-control"></textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>`;

        $('#slider-images').append(html);
    }
    // End New Slider

    // New Html Box
    var incr_htmlbox = $('#htmlbox_count').val();
    $('.summernote').summernote({
            minHeight: 300,
        });
    function addHtmlBox(){
        $('.summernote').summernote({
            minHeight: 300,
        });
        incr_htmlbox++;
        var html = '';

        html +=`<div class="htmlbox-inr" id="about_setting` + incr_htmlbox + `">
                    <h2>HTML ` + incr_htmlbox + `</h2>
                    <div class="row align-items-center">
                        <div class="col-md-11">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Select HTML Layout</label>
                                    </th>
                                    <td>
                                        <select name="about_setting[` + incr_htmlbox + `][about_layout_id]" id="about_layout" class="form-control" onchange="backgroundOption(this)">
                                            <option> - Select HTML Box - </option>
                                            <option value="1">HTML Layout 1</option>
                                            <option value="2">HTML Layout 2</option>
                                            <option value="3">HTML Layout 3</option>
                                            <option value="4">HTML Layout 4</option>
                                            <option value="5">HTML Layout 5</option>
                                            <option value="6">HTML Layout 6</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Preview</label>
                                    </th>
                                    <td id="about-preview" class="bg-light">
                                        @php
                                            $about_image = isset($about_data['about_image']) ? $about_data['about_image'] : '';
                                        @endphp
                                    </td>
                                </tr>

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Background Option</label>
                                    </th>
                                    <td>
                                        <select name="about_setting[` + incr_htmlbox + `][about_background_option]" onchange="backgroundOption(this)" class="form-control">
                                            @php
                                                $about_background_option = isset($html_box_value['about_background_option']) ? $html_box_value['about_background_option'] : '';
                                            @endphp
                                            <option value="1">Image</option>
                                            <option value="2">Color</option>
                                        </select>
                                    </td>
                                </tr>
                                @if ($about_background_option == 2)
                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Background Color</label>
                                    </th>
                                    <td>
                                        <input type="color" name="about_setting[` + incr_htmlbox + `][about_background_color]" value="{{ isset($html_box_value['about_background_color']) ? $html_box_value['about_background_color'] : '' }}" class="form-control">
                                    </td>
                                </tr>

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Background Hover Color</label>
                                    </th>
                                    <td>
                                        <input type="color" value="{{ isset($html_box_value['about_background_hover_color']) ? $html_box_value['about_background_hover_color'] : '' }}" name="about_setting[` + incr_htmlbox + `][about_background_hover_color]" class="form-control">
                                    </td>
                                </tr>
                                @endif


                                @if ($about_background_option == 1)
                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Background Image</label>
                                    </th>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="htmlbgimage` + incr_htmlbox + `" data-input="htmlboxbgimg` + incr_htmlbox + `" data-preview="holderbgimg` + incr_htmlbox + `" onclick="setimage(this)" class="btn btn-primary text-white photo">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="htmlboxbgimg` + incr_htmlbox + `" class="form-control" type="text" name="about_setting[` + incr_htmlbox + `][about_background_image]">
                                        </div>
                                        <div id="holderbgimg` + incr_htmlbox + `" style="margin-top:15px;max-height:100px;"></div>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Background Image Position</label>
                                    </th>
                                    <td>
                                        <select name="about_setting[` + incr_htmlbox + `][about_background_image_position]" class="form-control">
                                            @php
                                            $about_background_image_position = isset($html_box_value['about_background_image_position']) ? $html_box_value['about_background_image_position'] : '';
                                            @endphp
                                            <option value="top"> Top</option>
                                            <option value="bottom"> Bottom</option>
                                            <option value="left"> Left</option>
                                            <option value="right"> Right</option>
                                            <option value="center"> Center</option>
                                        </select>
                                    </td>
                                </tr>
                                @endif

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Title</label>
                                    </th>
                                    <td>
                                        <input type="text" name="about_setting[` + incr_htmlbox + `][about_title]" value="{{ isset($html_box_value['about_title']) ? $html_box_value['about_title'] : '' }}" class="form-control">
                                    </td>
                                </tr>

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>HTML BOX</label>
                                    </th>
                                    <td>
                                        <textarea name="about_setting[` + incr_htmlbox + `][about_description]" class="form-control summernote"></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="250" class="align-middle">
                                        <label>Image</label>
                                    </th>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="abouthtmlbox_` + incr_htmlbox + `" data-input="aboutimage_` + incr_htmlbox + `" data-preview="aboutholder_` + incr_htmlbox + `" onclick="setimage(this)" class="btn btn-primary text-white photo">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="aboutimage_` + incr_htmlbox + `" class="form-control" type="text" name="about_setting[` + incr_htmlbox + `][about_image]">
                                        </div>
                                        <div id="aboutholder_` + incr_htmlbox + `" style="margin-top:15px;max-height:100px;"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn rounded-circle btn-sm btn-danger" onclick="$(\'#about_setting` + incr_htmlbox + `\').remove()"><i class="fa fa-minus-circle"></i></button>
                        </div>
                    </div>
                </div>
                `;
        $('#htmlbox').append(html);
     }

    // End New Html Box



    // Delete Slider
    function deleteSlider(id) {
        var id = id;

        if (confirm("Are You Sure You Want to Delete It ?")) {
            $.ajax({
                type: "POST",
                url: "{{ url('deleteSlider') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'slider_id': id,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == 1) {
                        alert("Slider has been deleted Successfully..");
                        location.reload();
                    }
                }
            });
        }

    }
    // End Delete Slider

    function deletehtmlbox(id){
        var d_id = id;

        if (confirm("Are You Sure You Want to Delete It ?")) {
            $.ajax({
                type: "POST",
                url: "{{ route('deletehtmlbox') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'htmlbox_id': d_id,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == 1) {
                        alert("HtmlBox has been deleted Successfully..");
                        location.reload();
                    }
                }
            });
        }
    }


    function backgroundOption(elem) {
        var form_data = new FormData(document.getElementById("templateSetting"));
        $.ajax({
            url: "{{ url('updateTemplateSetting') }}",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response){
                location.reload();
            }
        });
    }

    // Change Active Header
    function changeActiveHeader() {
        var head_id = $('#header_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activeheader') }}/" + head_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Header


    // Change Active Slider
    function changeActiveSlider() {
        var slide_id = $('#slider_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activeslider') }}/" + slide_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Slider


    // Change Active About Layout
    function changeActiveAboutLayout() {
        var about_id = $('#about_layout :selected').val();

         $htmlbox =$('#htmlbox_count').val();
        $.ajax({
            type: "GET",
            url: "{{ url('activeabout') }}/" + about_id,

            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active About Layout


    // Change Active Popular Food Layout
    function changeActivePopularFoodLayout() {
        var popularfood_id = $('#popularfood_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activepopularfood') }}/" + popularfood_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Popular Food Layout


    // Change Active Best Category Layout
    function changeActiveBestcategoryLayout() {
        var bestcategory_id = $('#bestcategory_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activebestcategory') }}/" + bestcategory_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Best Category Layout


    // Change Active Recent Reviews Layout
    function changeActiveReviewLayout() {
        var review_id = $('#review_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activerecentreview') }}/" + review_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Recent Reviews Layout


    // Change Active Reservation Layout
    function changeActiveReservationLayout() {
        var reservation_id = $('#reservation_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activereservation') }}/" + reservation_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Reservation Layout


    // Change Active Gallary Layout
    function changeActiveGallaryLayout() {
        var gallary_id = $('#gallary_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activegallary') }}/" + gallary_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Gallary Layout

    // Change Active Footer
    function changeActiveFooterLayout() {
        var footer_id = $('#footer_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activefooter') }}/" + footer_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Footer


    // Change Active Openhours Layout
    function changeActiveOpeningHoursLayout() {
        var openhour_id = $('#openhour_layout :selected').val();

        $.ajax({
            type: "GET",
            url: "{{ url('activeopenhours') }}/" + openhour_id,
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    location.reload();
                }
            }
        });

    }
    // End Change Active Openhours Layout


    // Start Copy Template Settings
    $('#copytemplatesettings').change(function() {
        var store_id = this.value;
        $.ajax({
            url: '{{ url('copytemplatesettings') }}',
            type: "POST",
            data: {
                store_id : store_id,
            },
            success: function(data) {
                if(data.success == 1)
                {
                    location.reload();
                }
            }
        });
    });

    // End Copy Template Settings
</script>
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    var lfm = function(id, type, options) {
    let button = document.getElementById(id);

    // button.addEventListener('click', function() {
    var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
    var target_input = document.getElementById(button.getAttribute('data-input'));
    var target_preview = document.getElementById(button.getAttribute('data-preview'));

    window.open(route_prefix + '?type=' + 'image' || 'file', 'FileManager', 'width=900,height=600');
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
    // });
};

function setimage(image) {
    var id = $(image).attr("id");
    var route_prefix = "filemanager";
    $(id).filemanager('image', {
        prefix: route_prefix
    });
    lfm(id, 'file', {
        prefix: route_prefix
    });
}
</script>
{{-- End Script --}}
