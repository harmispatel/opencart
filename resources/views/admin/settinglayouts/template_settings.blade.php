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

                                {{-- TOPBAR --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        TOP BAR
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll" aria-expanded="true" aria-controls="coll">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse show" id="coll">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Background Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_topbackgr_color" class="form-control" value="{{ $template_settings['polianna_topbackgr_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile Background Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_bannerbackgr_color" class="form-control"  value="{{ $template_settings['polianna_bannerbackgr_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Line Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_line_color" class="form-control"  value="{{ $template_settings['polianna_line_color'] }}">
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
                                {{-- END TOPBAR --}}

                                {{-- MAIN --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        MAIN
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
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-striped table-bordered">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Background</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_contentimage_pattern" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_custom_pattern']))
                                                                                <img src="{{ $template_settings['polianna_custom_pattern'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                 Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="main_bg_status" id="main_bg_status1" name="main_bg_status" value="1" {{ ($template_settings['main_bg_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="main_bg_status1">ON</label>

                                                                                <input type="radio" class="main_bg_status" id="main_bg_status2" name="main_bg_status" value="0" {{ ($template_settings['main_bg_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="main_bg_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_backgr_repeat" id="polianna_backgr_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['polianna_backgr_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['polianna_backgr_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['polianna_backgr_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['polianna_backgr_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="main_bg_mobile_status" id="main_bg_mobile_status1" name="main_bg_mobile_status" value="1" {{ ($template_settings['main_bg_mobile_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="main_bg_mobile_status1">ON</label>

                                                                                <input type="radio" class="main_bg_mobile_status" id="main_bg_mobile_status2" name="main_bg_mobile_status" value="0" {{ ($template_settings['main_bg_mobile_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="main_bg_mobile_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="main_bg_tablet_status" id="main_bg_tablet_status1" name="main_bg_tablet_status" value="1" {{ ($template_settings['main_bg_tablet_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="main_bg_tablet_status1">ON</label>

                                                                                <input type="radio" class="main_bg_tablet_status" id="main_bg_tablet_status2" name="main_bg_tablet_status" value="0" {{ ($template_settings['main_bg_tablet_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="main_bg_tablet_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Position</label>
                                                                        </th>
                                                                        <td>
                                                                            <span><b>X</b></span>
                                                                            <input type="text" name="ybc_bgmain_positions_x" class="form-control" value="{{ $template_settings['ybc_bgmain_positions_x'] }}">
                                                                            <span><b>Y</b></span>
                                                                            <input type="text" name="ybc_bgmain_positions_y" class="form-control"  value="{{ $template_settings['ybc_bgmain_positions_y'] }}">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-striped table-bordered">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Footer Background</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_bg_footer" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_bg_footer']))
                                                                                <img src="{{ $template_settings['polianna_bg_footer'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="footer_bg_status" id="footer_bg_status1" name="footer_bg_status" value="1" {{ ($template_settings['footer_bg_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="footer_bg_status1">ON</label>

                                                                                <input type="radio" class="footer_bg_status" id="footer_bg_status2" name="footer_bg_status" value="0" {{ ($template_settings['footer_bg_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="footer_bg_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="footer_bg_repeat" id="footer_bg_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['footer_bg_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['footer_bg_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['footer_bg_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['footer_bg_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="footer_bg_mobile_status" id="footer_bg_mobile_status1" name="footer_bg_mobile_status" value="1" {{ ($template_settings['footer_bg_mobile_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="footer_bg_mobile_status1">ON</label>

                                                                                <input type="radio" class="footer_bg_mobile_status" id="footer_bg_mobile_status2" name="footer_bg_mobile_status" value="0" {{ ($template_settings['footer_bg_mobile_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="footer_bg_mobile_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="footer_bg_tablet_status" id="footer_bg_tablet_status1" name="footer_bg_tablet_status" value="1" {{ ($template_settings['footer_bg_tablet_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="footer_bg_tablet_status1">ON</label>

                                                                                <input type="radio" class="footer_bg_tablet_status" id="footer_bg_tablet_status2" name="footer_bg_tablet_status" value="0" {{ ($template_settings['footer_bg_tablet_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="footer_bg_tablet_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Position</label>
                                                                        </th>
                                                                        <td>
                                                                            <span><b>X</b></span>
                                                                            <input type="text" name="ybc_bgfooter_positions_x" class="form-control" value="{{ $template_settings['ybc_bgfooter_positions_x'] }}">
                                                                            <span><b>Y</b></span>
                                                                            <input type="text" name="ybc_bgfooter_positions_y" class="form-control" value="{{ $template_settings['ybc_bgfooter_positions_y'] }}">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <hr class="bg-dark">

                                                        <div class="row mt-4">
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-striped table-bordered">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Middle Images</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="ybc_module_bg" class="form-control p-1">
                                                                            @if (!empty($template_settings['ybc_module_bg']))
                                                                                <img src="{{ $template_settings['ybc_module_bg'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_module_bg_status" id="ybc_module_bg_status1" name="ybc_module_bg_status" value="1" {{ ($template_settings['ybc_module_bg_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_module_bg_status1">ON</label>

                                                                                <input type="radio" class="ybc_module_bg_status" id="ybc_module_bg_status2" name="ybc_module_bg_status" value="0" {{ ($template_settings['ybc_module_bg_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_module_bg_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="ybc_module_bg_repeat" id="ybc_module_bg_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['ybc_module_bg_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['ybc_module_bg_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['ybc_module_bg_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['ybc_module_bg_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_module_bg_mobile_status" id="ybc_module_bg_mobile_status1" name="ybc_module_bg_mobile_status" value="1" {{ ($template_settings['ybc_module_bg_mobile_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_module_bg_mobile_status1">ON</label>

                                                                                <input type="radio" class="ybc_module_bg_mobile_status" id="ybc_module_bg_mobile_status2" name="ybc_module_bg_mobile_status" value="0" {{ ($template_settings['ybc_module_bg_mobile_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_module_bg_mobile_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_module_bg_tablet_status" id="ybc_module_bg_tablet_status1" name="ybc_module_bg_tablet_status" value="1" {{ ($template_settings['ybc_module_bg_tablet_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_module_bg_tablet_status1">ON</label>

                                                                                <input type="radio" class="ybc_module_bg_tablet_status" id="ybc_module_bg_tablet_status2" name="ybc_module_bg_tablet_status" value="0" {{ ($template_settings['ybc_module_bg_tablet_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_module_bg_tablet_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-striped table-bordered">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Top Main Background</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_top_main_bg" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_top_main_bg']))
                                                                                <img src="{{ $template_settings['polianna_top_main_bg'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="top_main_bg_status" id="top_main_bg_status1" name="top_main_bg_status" value="1" {{ ($template_settings['top_main_bg_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="top_main_bg_status1">ON</label>

                                                                                <input type="radio" class="top_main_bg_status" id="top_main_bg_status2" name="top_main_bg_status" value="0" {{ ($template_settings['top_main_bg_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="top_main_bg_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="top_main_bg_repeat" id="top_main_bg_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['top_main_bg_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['top_main_bg_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['top_main_bg_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['top_main_bg_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="top_main_bg_mobile_status" id="top_main_bg_mobile_status1" name="top_main_bg_mobile_status" value="1" {{ ($template_settings['top_main_bg_mobile_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="top_main_bg_mobile_status1">ON</label>

                                                                                <input type="radio" class="top_main_bg_mobile_status" id="top_main_bg_mobile_status2" name="top_main_bg_mobile_status" value="0"  {{ ($template_settings['top_main_bg_mobile_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="top_main_bg_mobile_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="top_main_bg_tablet_status" id="top_main_bg_tablet_status1" name="top_main_bg_tablet_status" value="1"  {{ ($template_settings['top_main_bg_tablet_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="top_main_bg_tablet_status1">ON</label>

                                                                                <input type="radio" class="top_main_bg_tablet_status" id="top_main_bg_tablet_status2" name="top_main_bg_tablet_status" value="0" {{ ($template_settings['top_main_bg_tablet_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="top_main_bg_tablet_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Position</label>
                                                                        </th>
                                                                        <td>
                                                                            <span><b>X</b></span>
                                                                            <input type="text" name="ybc_bg_top_main_positions_x" class="form-control" value="{{ $template_settings['ybc_bg_top_main_positions_x'] }}">
                                                                            <span><b>Y</b></span>
                                                                            <input type="text" name="ybc_bg_top_main_positions_y" class="form-control" value="{{ $template_settings['ybc_bg_top_main_positions_y'] }}">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <hr class="bg-dark">

                                                        <div class="row mt-4">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Main Background Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_backgr_color" class="form-control" value="{{ $template_settings['polianna_backgr_color'] }}">
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
                                {{-- END MAIN --}}

                                {{-- CONTENT SETTING --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        CONTENT &nbsp;SETTING
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll3" aria-expanded="true" aria-controls="coll3">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse show" id="coll3">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-bordered table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Display Logo</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="polianna_blog_enable" id="polianna_blog_enable1" name="polianna_blog_enable" value="1" {{ ($template_settings['polianna_blog_enable'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="polianna_blog_enable1">ON</label>

                                                                                <input type="radio" class="polianna_blog_enable" id="polianna_blog_enable2" name="polianna_blog_enable" value="0" {{ ($template_settings['polianna_blog_enable'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="polianna_blog_enable2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Banner Images</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_custom_icon1" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_custom_icon1']))
                                                                                <img src="{{ $template_settings['polianna_custom_icon1'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                 Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Open Banner</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="banner_open_img" class="form-control p-1">
                                                                            @if (!empty($template_settings['banner_open_img']))
                                                                                <img src="{{ $template_settings['banner_open_img'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Close Banner</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="banner_close_img" class="form-control p-1">
                                                                            @if (!empty($template_settings['banner_close_img']))
                                                                                <img src="{{ $template_settings['banner_close_img'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="polianna_img1_menu" id="polianna_img1_menu1" name="polianna_img1_menu" value="1" {{ ($template_settings['polianna_img1_menu'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="polianna_img1_menu1">ON</label>

                                                                                <input type="radio" class="polianna_img1_menu" id="polianna_img1_menu2" name="polianna_img1_menu" value="0" {{ ($template_settings['polianna_img1_menu'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="polianna_img1_menu2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="ybc_baner_bg_repeat" id="ybc_baner_bg_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['ybc_baner_bg_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['ybc_baner_bg_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['ybc_baner_bg_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['ybc_baner_bg_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_baner_bg_mobile_status" id="ybc_baner_bg_mobile_status1" name="ybc_baner_bg_mobile_status" value="1" {{ ($template_settings['ybc_baner_bg_mobile_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_baner_bg_mobile_status1">ON</label>

                                                                                <input type="radio" class="ybc_baner_bg_mobile_status" id="ybc_baner_bg_mobile_status2" name="ybc_baner_bg_mobile_status" value="0" {{ ($template_settings['ybc_baner_bg_mobile_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_baner_bg_mobile_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_baner_bg_tablet_status" id="ybc_baner_bg_tablet_status1" name="ybc_baner_bg_tablet_status" value="1" {{ ($template_settings['ybc_baner_bg_tablet_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_baner_bg_tablet_status1">ON</label>

                                                                                <input type="radio" class="ybc_baner_bg_tablet_status" id="ybc_baner_bg_tablet_status2" name="ybc_baner_bg_tablet_status" value="0" {{ ($template_settings['ybc_baner_bg_tablet_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_baner_bg_tablet_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-bordered table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Display Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="logo_tablet_enable" id="logo_tablet_enable1" name="logo_tablet_enable" value="1" {{ ($template_settings['logo_tablet_enable'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="logo_tablet_enable1">ON</label>

                                                                                <input type="radio" class="logo_tablet_enable" id="logo_tablet_enable2" name="logo_tablet_enable" value="0" {{ ($template_settings['logo_tablet_enable'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="logo_tablet_enable2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle" width="220">
                                                                            <label>Banner Background Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="bg_banner" class="form-control" value="{{ $template_settings['bg_banner'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Transparent</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="bg_banner_tranparent" id="bg_banner_tranparent1" name="bg_banner_tranparent" value="1" {{ ($template_settings['bg_banner_tranparent'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="bg_banner_tranparent1">ON</label>

                                                                                <input type="radio" class="bg_banner_tranparent" id="bg_banner_tranparent2" name="bg_banner_tranparent" value="0" {{ ($template_settings['bg_banner_tranparent'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="bg_banner_tranparent2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle" width="220">
                                                                            <label>Banner Height</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="number" name="polianna_custom_topinfo1" class="form-control" value="{{ $template_settings['polianna_custom_topinfo1'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Wide Banner</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_wide_banner_fullwidth" id="ybc_wide_banner_fullwidth1" name="ybc_wide_banner_fullwidth" value="1"  {{ ($template_settings['ybc_wide_banner_fullwidth'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_wide_banner_fullwidth1">ON</label>

                                                                                <input type="radio" class="ybc_wide_banner_fullwidth" id="ybc_wide_banner_fullwidth2" name="ybc_wide_banner_fullwidth" value="0" {{ ($template_settings['ybc_wide_banner_fullwidth'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_wide_banner_fullwidth2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle" width="220">
                                                                            <label>Box Shadow</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="text" name="ybc_banner_box_shadow" class="form-control" value="{{ $template_settings['ybc_banner_box_shadow'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Position</label>
                                                                        </th>
                                                                        <td>
                                                                            <span><b>X</b></span>
                                                                            <input type="text" name="ybc_banner_positions_x" class="form-control" value="{{ $template_settings['ybc_banner_positions_x'] }}">
                                                                            <span><b>Y</b></span>
                                                                            <input type="text" name="ybc_banner_positions_y" class="form-control" value="{{ $template_settings['ybc_banner_positions_y'] }}">
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
                                {{-- END CONTENT SETTING --}}

                                {{-- MENU SETTINGS --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        MENU
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll4" aria-expanded="true" aria-controls="coll4">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse show" id="coll4">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table">
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Wide Menu</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="polianna_widthmenu" id="polianna_widthmenu1" name="polianna_widthmenu" value="1" {{ ($template_settings['polianna_widthmenu'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="polianna_widthmenu1">ON</label>

                                                                                <input type="radio" class="polianna_widthmenu" id="polianna_widthmenu2" name="polianna_widthmenu" value="0" {{ ($template_settings['polianna_widthmenu'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="polianna_widthmenu2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Menu Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_bar_color" class="form-control" value="{{ $template_settings['polianna_bar_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Button Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_line1_color" class="form-control" value="{{ $template_settings['polianna_line1_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Button Hover Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_hover_color" class="form-control" value="{{ $template_settings['polianna_hover_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Menu Font</label>
                                                                        </th>
                                                                        <td>
                                                                            @php
                                                                                $fonts = getFonts();
                                                                            @endphp
                                                                            <select name="polianna_subbar_color" id="polianna_subbar_color" class="form-control">
                                                                                @foreach ($fonts as $key => $font)
                                                                                    <option value="{{ $key }}" {{ ($template_settings['polianna_subbar_color'] == $key) ? 'selected' : '' }}>{{ $font }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Menu Font Size</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_toplinksize" id="polianna_toplinksize" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        $selected = '';
                                                                                        if($template_settings['polianna_toplinksize'] == $i)
                                                                                        {
                                                                                            $selected = 'selected';
                                                                                        }
                                                                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Menu Font Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_wide_menu_font_color1" class="form-control" value="{{ $template_settings['polianna_wide_menu_font_color1'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Menu Font Hover Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_hover2_color" class="form-control" value="{{ $template_settings['polianna_hover2_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Basket Background Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_menulink2_color" class="form-control" value="{{ $template_settings['polianna_menulink2_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Basket Mouse Hover Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_fonlink2_color" class="form-control" value="{{ $template_settings['polianna_fonlink2_color'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Basket Font Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_toplinksize2" class="form-control" value="{{ $template_settings['polianna_toplinksize2'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="250" class="align-middle">
                                                                            <label>Basket Font Hover Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_categorysize" class="form-control" value="{{ $template_settings['polianna_categorysize'] }}">
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
                                {{-- END MENU SETTINGS --}}

                                {{-- MAIN CONTENT --}}
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        MAIN CONTENT
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll5" aria-expanded="true" aria-controls="coll5">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse show" id="coll5">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table h-100 table-bordered table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Wide Content</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="main_content_fullwidth" id="main_content_fullwidth1" name="main_content_fullwidth" value="1" {{ ($template_settings['main_content_fullwidth'] == 1) ? 'checked' : '' }}/>

                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="main_content_fullwidth1">ON</label>

                                                                                <input type="radio" class="main_content_fullwidth" id="main_content_fullwidth2" name="main_content_fullwidth" value="0" {{ ($template_settings['main_content_fullwidth'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="main_content_fullwidth2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Content Width (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="number" name="polianna_contentwidth" id="polianna_contentwidth" class="form-control" value="{{ $template_settings['polianna_contentwidth'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Background Image</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="polianna_contentimage_pattern" class="form-control p-1">
                                                                            @if (!empty($template_settings['polianna_contentimage_pattern']))
                                                                                <img src="{{ $template_settings['polianna_contentimage_pattern'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                            @else
                                                                                 Not Avavilable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="polianna_img1_main_content" id="polianna_img1_main_content1" name="polianna_img1_main_content" value="1" {{ ($template_settings['polianna_img1_main_content'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="polianna_img1_main_content1">ON</label>

                                                                                <input type="radio" class="polianna_img1_main_content" id="polianna_img1_main_content2" name="polianna_img1_main_content" value="0" {{ ($template_settings['polianna_img1_main_content'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="polianna_img1_main_content2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_contentbackgr_repeat" id="polianna_contentbackgr_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['polianna_contentbackgr_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['polianna_contentbackgr_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['polianna_contentbackgr_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['polianna_contentbackgr_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_main_content_bg_mobile_status" id="ybc_main_content_bg_mobile_status1" name="ybc_main_content_bg_mobile_status" value="1" {{ ($template_settings['ybc_main_content_bg_mobile_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_main_content_bg_mobile_status1">ON</label>

                                                                                <input type="radio" class="ybc_main_content_bg_mobile_status" id="ybc_main_content_bg_mobile_status2" name="ybc_main_content_bg_mobile_status" value="0" {{ ($template_settings['ybc_main_content_bg_mobile_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_main_content_bg_mobile_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="ybc_main_content_bg_tablet_status" id="ybc_main_content_bg_tablet_status1" name="ybc_main_content_bg_tablet_status" value="1" {{ ($template_settings['ybc_main_content_bg_tablet_status'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="ybc_main_content_bg_tablet_status1">ON</label>

                                                                                <input type="radio" class="ybc_main_content_bg_tablet_status" id="ybc_main_content_bg_tablet_status2" name="ybc_main_content_bg_tablet_status" value="0"  {{ ($template_settings['ybc_main_content_bg_tablet_status'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="ybc_main_content_bg_tablet_status2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Box Shadow Value</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="number" name="polianna_shadowcontent" id="polianna_shadowcontent" class="form-control" value="{{ $template_settings['polianna_shadowcontent'] }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Background Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_contentbackgr_color" id="polianna_contentbackgr_color" class="form-control" value="{{ $template_settings['polianna_contentbackgr_color'] }}">
                                                                            <br>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="polianna_contentbackgr_transparent" id="polianna_contentbackgr_transparent1" name="polianna_contentbackgr_transparent" value="1" {{ ($template_settings['polianna_contentbackgr_transparent'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="polianna_contentbackgr_transparent1">ON</label>

                                                                                <input type="radio" class="polianna_contentbackgr_transparent" id="polianna_contentbackgr_transparent2" name="polianna_contentbackgr_transparent" value="0" {{ ($template_settings['polianna_contentbackgr_transparent'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="polianna_contentbackgr_transparent2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table table-bordered h-100 table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Footer Background Image</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="file" name="footer_background_image" class="form-control p-1">
                                                                            @if (!empty($template_settings['footer_background_image']))
                                                                            <img src="{{ $template_settings['footer_background_image'] }}" width="80" class="mt-2" style="border: 1px solid black;">
                                                                        @else
                                                                             Not Avavilable
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Status</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="footer_bg_enable" id="footer_bg_enable1" name="footer_bg_enable" value="1" {{ ($template_settings['footer_bg_enable'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="footer_bg_enable1">ON</label>

                                                                                <input type="radio" class="footer_bg_enable" id="footer_bg_enable2" name="footer_bg_enable" value="0" {{ ($template_settings['footer_bg_enable'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="footer_bg_enable2">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Repeat</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="footer_background_repeat" id="footer_background_repeat" class="form-control">
                                                                                <option value="no-repeat" {{ ($template_settings['footer_background_repeat'] == 'no-repeat') ? 'selected' : '' }}>no-repeat</option>
                                                                                <option value="repeat" {{ ($template_settings['footer_background_repeat'] == 'repeat') ? 'selected' : '' }}>repeat</option>
                                                                                <option value="repeat-x" {{ ($template_settings['footer_background_repeat'] == 'repeat-x') ? 'selected' : '' }}>repeat-x</option>
                                                                                <option value="repeat-y" {{ ($template_settings['footer_background_repeat'] == 'repeat-y') ? 'selected' : '' }}>repeat-y</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Mobile</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="footer_bg_mobile_status2" id="footer_bg_mobile_status21" name="footer_bg_mobile_status2" value="1" {{ ($template_settings['footer_bg_mobile_status2'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="footer_bg_mobile_status21">ON</label>

                                                                                <input type="radio" class="footer_bg_mobile_status2" id="footer_bg_mobile_status22" name="footer_bg_mobile_status2" value="0"  {{ ($template_settings['footer_bg_mobile_status2'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="footer_bg_mobile_status22">OFF</label>
                                                                             </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Tablet</label>
                                                                        </th>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <input type="radio" class="footer_bg_tablet_status2" id="footer_bg_tablet_status21" name="footer_bg_tablet_status2" value="1" {{ ($template_settings['footer_bg_tablet_status2'] == 1) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: green;color:white;opacity: 0.5;" for="footer_bg_tablet_status21">ON</label>

                                                                                <input type="radio" class="footer_bg_tablet_status2" id="footer_bg_tablet_status22" name="footer_bg_tablet_status2" value="0" {{ ($template_settings['footer_bg_tablet_status2'] == 0) ? 'checked' : '' }}/>
                                                                                <label class="btn btn-sm" style=" background: red;color: white;opacity: 0.5;" for="footer_bg_tablet_status22">OFF</label>
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
                                {{-- END MAIN CONTENT --}}

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        GLOBAL
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll6" aria-expanded="true" aria-controls="coll6">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse" id="coll6">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered ">
                                                                    <thead style="background: #171717;">
                                                                        <tr class="text-center">
                                                                            <th colspan="2" style="color: white;">BUTTONS</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="250" class="align-middle">Button Color</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_button_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Button Hover Color</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_buttonhov_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered">
                                                                    <thead style="background: #171717;">
                                                                        <tr class="text-center">
                                                                            <th colspan="2" style="color: white;">FORMS</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="250" class="align-middle">Border Hover Color</th>
                                                                            <td>
                                                                                <input type="color" name="ybc_mousehover_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Active Border Color</th>
                                                                            <td>
                                                                                <input type="color" name="ybc_click_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Errors Border Color</th>
                                                                            <td>
                                                                                <input type="color" name="ybc_error_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">General Border Color</th>
                                                                            <td>
                                                                                <input type="color" name="ybc_general_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Unactive Text Color</th>
                                                                            <td>
                                                                                <input type="color" name="ybc_unactive_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Active Text Color</th>
                                                                            <td>
                                                                                <input type="color" name="ybc_active_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered ">
                                                                    <thead style="background: #171717;">
                                                                        <tr class="text-center">
                                                                            <th colspan="2" style="color: white;">CATEGORY</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="250" class="align-middle">Category links (In Left/Right Columns)</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_categ_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Category Links Hover</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_hovercateg_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered ">
                                                                    <thead style="background: #171717;">
                                                                        <tr class="text-center">
                                                                            <th colspan="2" style="color: white;">PRODUCTS</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="250" class="align-middle">Product Name Color</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_titleitem_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Price Color</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_allprice_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="align-middle">Product Description Color</th>
                                                                            <td>
                                                                                <input type="color" name="polianna_oprice_color" class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
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

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        FOOTER
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll7" aria-expanded="true" aria-controls="coll7">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse" id="coll7">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Footer Link</label>
                                                                        </th>
                                                                        <td>
                                                                            <textarea name="polianna_custom_submenu_1" id="polianna_custom_submenu_1" rows="3" class="form-control"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Font Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_footertitle_color" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Link Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_footer_color" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Link Hover Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_footerhover_color" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Text Footer</label>
                                                                        </th>
                                                                        <td>
                                                                            <textarea name="polianna_custom_submenu_2" id="polianna_custom_submenu_2" rows="3" class="form-control"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Font Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_footerfon_color" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Link Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_footertext_color" class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Hover Color</label>
                                                                        </th>
                                                                        <td>
                                                                            <input type="color" name="polianna_footertext_hover_color" class="form-control">
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

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Card --}}
                                            <div class="card">
                                                {{-- Card Header --}}
                                                <div class="card-header" style="background: #1bbc9b ">
                                                    <h3 class="card-title pt-2 text-white">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        FONT
                                                    </h3>
                                                    <div class="container" style="text-align: right">
                                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll8" aria-expanded="true" aria-controls="coll8">
                                                            <i class="fa" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- End Card Header --}}

                                                <div class="collapse" id="coll8">
                                                    {{-- Card Body --}}
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <th width="350" class="align-middle">
                                                                            <label>Headings font (H1-H4)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_font" id="polianna_title_font" class="form-control">
                                                                                @foreach ($fonts as $key => $font)
                                                                                    <option value="{{ $key }}">{{ $font }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <code class="text-muted">
                                                                                + Main Menu Links
                                                                            </code>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Body font</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_body_font" id="polianna_body_font" class="form-control">
                                                                                @foreach ($fonts as $key => $font)
                                                                                    <option value="{{ $key }}">{{ $font }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <code class="text-muted">
                                                                                Main Font for All Texts.
                                                                            </code>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Body Text Font Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_bodysize" id="polianna_bodysize" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>H1 Titles Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="ybc_polianna_title_h1" id="ybc_polianna_title_h1" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>H2 Titles Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_h2" id="polianna_title_h2" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>H3 Titles & Footer Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_h3" id="polianna_title_h3" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>H4 Titles Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_h4" id="polianna_title_h4" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Content Area Module Title Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_box" id="polianna_title_box" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Left/Right Columns Title Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_column" id="polianna_title_column" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Product Title Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_title_product" id="polianna_title_product" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="align-middle">
                                                                            <label>Product Page Price Size (PX)</label>
                                                                        </th>
                                                                        <td>
                                                                            <select name="polianna_pricesize" id="polianna_pricesize" class="form-control">
                                                                                @php
                                                                                    for($i=9;$i<=36;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                    }
                                                                                @endphp
                                                                            </select>
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
